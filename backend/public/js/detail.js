var MAX_CONTENT_LENGTH = 40;
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
			var heart;
			if (object['liked']) {
				heart = " class='fa fa-heart badge' aria-hidden='true'>";
			} else {
				heart = " class='fa fa-heart-o badge' aria-hidden='true'>";
			}

	  		var like_button = "<span onclick=like(event) id="+object['id']+heart+object['likes']+"</span>";
	  		var caption_content = shrinkContent(object['content']);
	  		var li_content = caption_content + like_button;
      		
      		if (caption_id == object['id']) {
      			updateCaptionDisplay(object);
      			$("#all_caption").append("<a onclick=changeCaption(event) class='list-group-item active' href='#'>"+li_content+"</a>");
      			like_button = "<span onclick=like(event) id="+object['id']+heart+object['likes']+"</span>";
				$("#likes").html(like_button);
				$("#fb-share-button").attr("data-href", document.location.href);
      			has_selected_caption = true;
      		} else {
      			$("#all_caption").append("<a onclick=changeCaption(event) class='list-group-item' href='#'>"+li_content+"</a>");
      		}
    	});

    	if (!has_selected_caption) {
    		var heart;
			if (data[0]['liked']) {
				heart = " class='fa fa-heart badge' aria-hidden='true'>";
			} else {
				heart = " class='fa fa-heart-o badge' aria-hidden='true'>";
			}
    		$("div#all_caption").children().first().addClass("active");
    		updateCaptionDisplay(data[0]);
    		var like_button = "<div onclick=like(event) id="+data[0]['id']+heart+data[0]['likes']+"</div>";
			$("#likes").html(like_button);
			var url = document.location.href+"?caption_id="+data[0]['id'];
			$("#fb-share-button").attr("data-href", url);
    	}
    	$("#likes").children().first().removeClass("badge");
	})
}

function addCaption(image_id){
	var url = "/new_create?image_id="+image_id;
	window.open(url);
	return false;
}

function changeCaption(event){
	if (!$(event.target).is("a")) {
		return ;
	}
	$(".active").removeClass("active");
	$(event.target).addClass("active");
	var this_caption_id = $(event.target).children().first().attr("id");

	var this_caption;
	$.each(captions, function(i, object){
		if (this_caption_id == object['id']) {
			this_caption = object;
		}
	});
	updateCaptionDisplay(this_caption);
	
	var this_likes = $(event.target).children().first().clone().removeClass("badge");
	$("#likes").html(this_likes);
	var url = window.location.pathname.concat("?caption_id=");
	url = url.concat(this_caption_id);
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
			$("#likes div:last").attr("class", "fa fa-heart");
		}

		var aCaption = $("div#all_caption").children().first();
		var like = aCaption.children().last();
		if (like.attr('id') == id) {
			like.html(data['likes']);
			like.attr("class", "fa fa-heart");
		}
		while (aCaption.next().is('a')) {
			aCaption = aCaption.next();
			like = aCaption.children().last();
			if (like.attr('id') == id) {
				like.html(data['likes']);
				like.attr("class", "fa fa-heart");
			}
		}	
	})
}

function shrinkContent(content) {
	if (content.length>MAX_CONTENT_LENGTH) {
		return content.substring(0,MAX_CONTENT_LENGTH) + "...";
	} else {
		return content;
	}
}