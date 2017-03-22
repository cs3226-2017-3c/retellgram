function getImage(image_id) {
	var url = "../image/";
	url = url.concat(image_id);
	$.getJSON(url, function(data) {
	$("#image").attr("src",data['path']);
});
}

function getCaptions(image_id, caption_id) {
	var url = "../caption?likes=1&image_id=";
	var has_selected_caption = false;
	url = url.concat(image_id);
	$.getJSON(url, function(data){
		$.each(data, function(i, object){
	  		var thumb = "<div onclick=like(event) id="+object['id']+" class='glyphicon glyphicon-thumbs-up'>"+object['likes']+"</div>";
	  		var caption_content = "<div onclick=changeCaption(event)>"+object['content']+"</div>";
	  		var li_content = caption_content + thumb;
      		
      		if (caption_id == object['id']) {
      			$("#all_caption").append("<li class='selected' href='#'>"+li_content+"</li>");
      			$("#caption").html("<p>"+object['content']+"</p>");
      			var thumb = "<div onclick=like(event) id="+object['id']+" class='glyphicon glyphicon-thumbs-up'>"+object['likes']+"</div>";
				$("#likes").html(thumb);
      			has_selected_caption = true;
      		} else {
      			$("#all_caption").append("<li href='#'>"+li_content+"</li>");
      		}
    	});

    	if (!has_selected_caption) {
    		$("ol#all_caption li:first").addClass("selected");
    		$("#caption").html("<p>"+data[0]['content']+"</p>");
			var thumb = "<div onclick=like(event) id="+data[0]['id']+" class='glyphicon glyphicon-thumbs-up'>"+data[0]['likes']+"</div>";
			$("#likes").html(thumb);
    	}
	})
}

function addCaption(image_id){
	console.log("add caption!");
	window.open("../create?image_id="+image_id);
}

function changeCaption(event){
	$(".selected").removeClass("selected");
	$(event.target).parent().addClass("selected");
	var this_caption = $(event.target).html();
	$("#caption").html("<p>"+this_caption+"</p>");
	var this_likes = $(event.target).next().clone();
	$("#likes").html(this_likes);
	var url = window.location.pathname.concat("?caption_id=");
	url = url.concat($(event.target).next().attr("id"));
	window.history.replaceState(null, null, url);
};

function like(event){
	var this_caption_id = $(event.target).context.id;
	$.ajax({
    	type: 'PUT',
    	beforeSend: function(request) {
    		request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        url: "../caption/" + this_caption_id, 
        success: function(data) {
            updateLikeDisplay(event, this_caption_id)
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	if (errorThrown == "Bad Request") {
        		alert("You have liked this caption");
        	} else {
        		console.log(textStatus, errorThrown);
        	}
		}
    });
}

function updateLikeDisplay(event, id) {
	$.getJSON("../caption/"+id, function(data){
		$(event.target).html(data['likes']);
		if($("#likes div:last").attr('id') == id) {
			$("#likes div:last").html(data['likes']);
		}

		var aCaption = $("ol#all_caption li:first");
		var like = aCaption.children().last();
		if (like.attr('id') == id) {
			like.html(data['likes']);
		}
		while (aCaption.next().is('li')) {
			aCaption = aCaption.next();
			like = aCaption.children().last();
			if (like.attr('id') == id) {
				like.html(data['likes']);
			}
		}	
	})
}