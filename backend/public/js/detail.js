var MAX_CONTENT_LENGTH = 35;
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
var liked={};
var liked_heart = "<i class='fa fa-heart' aria-hidden='true'></i>";
var unliked_heart = "<i class='fa fa-heart-o' aria-hidden='true'></i>";

function getCaptions(image_id, caption_id) {
	var url = "/caption?likes=1&image_id=";
	var has_selected_caption = false;
	url = url.concat(image_id);
	$.getJSON(url, function(data){
		captions = data;
		$.each(data, function(i, object){
			if (object['liked']) {
				liked[object['id']] = 1;
			} else {
				liked[object['id']] = 0;
			}

	  		var like_button = generateLikeBadge(object['id'], object['likes']);
	  		var caption_content = shrinkContent(object['content']);
	  		var li_content = caption_content + like_button;
      		
      		if (caption_id == object['id']) {
      			updateCaptionDisplay(object);
      			$("#all_caption").append("<a onclick=changeCaption(event) class='list-group-item active' href='#'>"+li_content+"</a>");
      			like_button = generateLike(object['id'], object['likes']);
				$("#likes").html(like_button);
				has_selected_caption = true;
      		} else {
      			$("#all_caption").append("<a onclick=changeCaption(event) class='list-group-item' href='#'>"+li_content+"</a>");
      		}
    	});

    	if (!has_selected_caption) {
    		$("div#all_caption").children().first().addClass("active");
    		updateCaptionDisplay(data[0]);
    		var like_button = generateLike(data[0]['id'], data[0]['likes']);
			$("#likes").html(like_button);
			var url = document.location.href+"?caption_id="+data[0]['id'];
    	}
	})
}

function changeCaption(event){
	event.preventDefault();
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
	
	var this_likes = $(event.target).children().first().html();
	var like_button = generateLike(this_caption_id, this_likes);
	$("#likes").html(like_button);
	var url = window.location.pathname.concat("?caption_id=");
	url = url.concat(this_caption_id);
	window.history.replaceState(null, null, url);
};

function like(event){
	event.preventDefault();
	var this_caption_id = $(event.target).context.id;
	$.ajax({
    	type: 'PUT',
    	beforeSend: function(request) {
    		request.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        },
        url: "/caption/" + this_caption_id, 
        success: function(data) {
        	liked[this_caption_id] = 1;
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
	var post_by = "<h5>"+charArray[caption['character_id']]+"</h5>";
	var post_date;
	if (caption['created_at'] == null) {
		post_date = "";
	} else {
		var date = caption['created_at'].split(" ")[0];
		post_date = "<div>on "+date+"</div>";
	}

	$("#caption").html(caption_content);
	$("#author").html(post_by+post_date);
}

function updateLikeDisplay(event, id) {
	$.getJSON("/caption/"+id, function(data){
		var like_button = generateLike(id, data['likes']);
		$(event.target).parent().html(like_button);

		var aCaption = $("#all_caption").children().first();
		var like = aCaption.children().last();
		if (like.attr('id') == id) {
			like.html(data['likes']);
		}
		while (aCaption.next().is('a')) {
			aCaption = aCaption.next();
			like = aCaption.children().last();
			if (like.attr('id') == id) {
				like.html(data['likes']);
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

function generateLike(id, likes) {
	var heart;
	if (liked[id]) {
		heart = liked_heart;
	} else {
		heart = unliked_heart;
	}
	return heart+"<a href='#' onclick=like(event) id="+id+"> "+likes+" Likes"+"</a>"; 		
}

function generateLikeBadge(id, likes) {
	return "<div class='badge' id="+id+">"+likes+"</div>";
}

function generateShareLink(url){
	var share_url = "https://www.facebook.com/sharer/sharer.php?u=";
	var this_url = encodeURI(url);
	share_url.concat(this_url);
	return share_url;
}