var charArray = { 	7: "Avata", 
					5: "Curry Puff",
					2: "Deadpoo",
					8: "Dollraemon",
              		4: "Donald Drunk", 
              		6: "Genghis Khan",
              		1: "Hairy Porter", 
              		3: "Hermoney Changer",
              		10: "Hulky",
              		11: "Kimchi Jong-un",  
                  	9: "Queen Kong",
                  	12: "Super Maria"};

var captions;

function getCaptions(image_id, caption_id) {
	var url = "/caption?likes=1&image_id=";
	var has_selected_caption = false;
	url = url.concat(image_id);
	$.getJSON(url, function(data){
		captions = data;
		$.each(data, function(i, object){
	  		var thumb = "<div onclick=like(event) id="+object['id']+" class='glyphicon glyphicon-thumbs-up'>"+object['likes']+"</div>";
	  		var caption_content = "<div onclick=changeCaption(event)>"+object['content']+"</div>";
	  		var li_content = caption_content + thumb;
      		
      		if (caption_id == object['id']) {
      			$("#all_caption").append("<li class='selected' href='#'>"+li_content+"</li>");
      			updateCaptionDisplay(object);
      			var thumb = "<div onclick=like(event) id="+object['id']+" class='glyphicon glyphicon-thumbs-up'>"+object['likes']+"</div>";
				$("#likes").html(thumb);
				$("#fb-share-button").attr("data-href", document.location.href);
      			has_selected_caption = true;
      		} else {
      			$("#all_caption").append("<li href='#'>"+li_content+"</li>");
      		}
    	});

    	if (!has_selected_caption) {
    		$("ol#all_caption li:first").addClass("selected");
    		updateCaptionDisplay(data[0]);
    		var thumb = "<div onclick=like(event) id="+data[0]['id']+" class='glyphicon glyphicon-thumbs-up'>"+data[0]['likes']+"</div>";
			$("#likes").html(thumb);
			var url = document.location.href+"?caption_id="+data[0]['id'];
			$("#fb-share-button").attr("data-href", url);
    	}
	})
}

function addCaption(image_id){
	var url = "/new_create?image_id="+image_id;
	window.open(url);
	return false;
}

function changeCaption(event){
	$(".selected").removeClass("selected");
	$(event.target).parent().addClass("selected");
	var this_caption_id = $(event.target).next().attr("id");
	var this_caption;
	$.each(captions, function(i, object){
		if (this_caption_id == object['id']) {
			this_caption = object;
		}
	});
	updateCaptionDisplay(this_caption);
	
	var this_likes = $(event.target).next().clone();
	$("#likes").html(this_likes);
	var url = window.location.pathname.concat("?caption_id=");
	url = url.concat($(event.target).next().attr("id"));
	window.history.replaceState(null, null, url);
	$("#fb-share-button").attr("data-href", document.location.href);
};

function like(event){
	var this_caption_id = $(event.target).context.id;
	$.ajax({
    	type: 'PUT',
    	beforeSend: function(request) {
    		request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        url: "/caption/" + this_caption_id, 
        success: function(data) {
            updateLikeDisplay(event, this_caption_id)
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	if (errorThrown == "Bad Request") {
        		swal({
        			title: "You have liked this caption",
        			type: "warning",
  					timer: 700,
  					showConfirmButton: false
        		});
        	} else {
        		console.log(textStatus, errorThrown);
        	}
		}
    });
}

function updateCaptionDisplay(caption) {
	var caption_content = "<p>"+caption['content']+"</p>";
	var post_by = "<h5>Posted by "+charArray[caption['character_id']]+"</h5>";
	var post_date;
	if (caption['created_at'] == null) {
		post_date = "";
	} else {
		var date = caption['created_at'].split(" ")[0];
		post_date = "<div class='text-muted'>on "+date+"</div>";
	}

	$("#caption").html(caption_content);
	$("#author").html(post_by+post_date);
}

function updateLikeDisplay(event, id) {
	$.getJSON("/caption/"+id, function(data){
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