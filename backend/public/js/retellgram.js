var liked={};
var liked_heart = "<i class='fa fa-heart' aria-hidden='true'></i>";
var unliked_heart = "<i class='fa fa-heart-o' aria-hidden='true'></i>";

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

function generateLike(id, likes) {
    var heart;
    if (liked[id]) {
        heart = liked_heart;
    } else {
        heart = unliked_heart;
    }
    return "<a href='#' onclick=like(event) id="+id+">"+heart+" "+likes+" Likes"+"</a>";       
}

function shareFB(event){
  event.preventDefault();
  FB.ui({
    method: 'share',
    href: document.location.href,
  }, function(response){});
}

  window.fbAsyncInit = function() {
    FB.init({
      appId      : 164946997359533,
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));