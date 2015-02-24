$(document).on('click',".vignettes",function(){
	if($('.check',this).hasClass('active')){
		$('.check').removeClass('active');
	}else{
		$('.check').removeClass('active');
		$('.check',this).addClass('active');
	}
});

$('a[data-slide]').on('click', function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        console.log(link);
        $('body').animate({ scrollTop: $(link).offset().top }, 800);
    });

$(".item3").on('click',function(){
		$("#login-popup").animate(500);

		$("#login-popup")
		.css({
		"display" : "block",

		})



});




$("#close").on('click',function(){

	$("#login-popup").animate(500);

		$("#login-popup")
		.css({
		"display" : "none",

		})

});




$("#open_menu_mobile").on('click',function(){
	if(!$('#menu_open').hasClass('active')){
		$('#menu_open').addClass('active');
	}else{
		$('#menu_open').removeClass('active');
	}
});

$(".menu_deroulant").on('click',function(){

	$('#menu_open').removeClass('active')


});

$(".favorit").on('click',function(){
	if($('.coeur2',this).hasClass('active')){
		$('.coeur2',this).removeClass('active');
		$('.coeur',this).removeClass('remove');
	}else{
		$('.coeur2',this).addClass('active');
		$('.coeur',this).addClass('remove');
	}
});

$(".fav_event").on('click',function(){
	if($('.coeur2',this).hasClass('active2')){
		$('.coeur2',this).removeClass('active2');
		$('.coeur',this).removeClass('remove');
	}else{
		$('.coeur2',this).addClass('active2');
		$('.coeur',this).addClass('remove');
	}
});


function checkClass(){
	if($("#bar-menu-1").hasClass('activeAfter')){
		$("#bar-menu-1").css({
			"border-top-right-radius":"0px",
			"transition":"0s"
		});
	}
}

$("#block_menu ul li:not(:last-child)").on('click',function(){
	if($(this).hasClass('activeAfter')){
		$("#bar-menu-1").css({"border-top-right-radius":"5px"});
		checkClass();
	}else{
		$('#block_menu ul li').removeClass('activeAfter');
		$(this).addClass('activeAfter');
		$("#bar-menu-1").css({
			"border-top-right-radius":"5px",
			"transition":"0s"
		});
		checkClass();
	}
});

$("#bar-menu-1").on('click',function(){

		$("#formulaire")
		.css({"display" : "block",})
		$("#formulaire-host")
		.css({"display" : "none",})
		$("#formulaire-transport")
		.css({"display" : "none",})
		$("#formulaire-contributors")
		.css({"display" : "none",})
		$("#formulaire-options")
		.css({"display" : "none",})

		$("#bouton-next-1")
		.css({"display" : "block",})
		$("#bouton-next-2")
		.css({"display" : "none",})
		$("#bouton-next-3")
		.css({"display" : "none",})
		$("#bouton-next-4")
		.css({"display" : "none",})
		$("#bouton-next-5")
		.css({"display" : "none",})

});

$("#bar-menu-2").on('click',function(){

		$("#formulaire")
		.css({"display" : "none",})
		$("#formulaire-host")
		.css({"display" : "block",})
		$("#formulaire-transport")
		.css({"display" : "none",})
		$("#formulaire-contributors")
		.css({"display" : "none",})
		$("#formulaire-options")
		.css({"display" : "none",})

		$("#bouton-next-1")
		.css({"display" : "none",})
		$("#bouton-next-2")
		.css({"display" : "block",})
		$("#bouton-next-3")
		.css({"display" : "none",})
		$("#bouton-next-4")
		.css({"display" : "none",})
		$("#bouton-next-5")
		.css({"display" : "none",})

});

$("#bar-menu-3").on('click',function(){

		$("#formulaire")
		.css({"display" : "none",})
		$("#formulaire-host")
		.css({"display" : "none",})
		$("#formulaire-transport")
		.css({"display" : "block",})
		$("#formulaire-contributors")
		.css({"display" : "none",})
		$("#formulaire-options")
		.css({"display" : "none",})

		$("#bouton-next-1")
		.css({"display" : "none",})
		$("#bouton-next-2")
		.css({"display" : "none",})
		$("#bouton-next-3")
		.css({"display" : "block",})
		$("#bouton-next-4")
		.css({"display" : "none",})
		$("#bouton-next-5")
		.css({"display" : "none",})

});

$("#bar-menu-4").on('click',function(){

		$("#formulaire")
		.css({"display" : "none",})
		$("#formulaire-host")
		.css({"display" : "none",})
		$("#formulaire-transport")
		.css({"display" : "none",})
		$("#formulaire-contributors")
		.css({"display" : "block",})
		$("#formulaire-options")
		.css({"display" : "none",})

		$("#bouton-next-1")
		.css({"display" : "none",})
		$("#bouton-next-2")
		.css({"display" : "none",})
		$("#bouton-next-3")
		.css({"display" : "none",})
		$("#bouton-next-4")
		.css({"display" : "block",})
		$("#bouton-next-5")
		.css({"display" : "none",})

});

$("#bar-menu-5").on('click',function(){

		$("#formulaire")
		.css({"display" : "none",})
		$("#formulaire-host")
		.css({"display" : "none",})
		$("#formulaire-transport")
		.css({"display" : "none",})
		$("#formulaire-contributors")
		.css({"display" : "none",})
		$("#formulaire-options")
		.css({"display" : "block",})

		$("#bouton-next-1")
		.css({"display" : "none",})
		$("#bouton-next-2")
		.css({"display" : "none",})
		$("#bouton-next-3")
		.css({"display" : "none",})
		$("#bouton-next-4")
		.css({"display" : "none",})
		$("#bouton-next-5")
		.css({"display" : "block",})

});

$("#bouton-next-1").on('click',function(){

		$("#bar-menu-1").removeClass('activeAfter');
		$("#bar-menu-1").css({
			"border-top-right-radius":"5px",
			"transition":"0s"
		});
		$("#bar-menu-2").addClass('activeAfter');
		$("#bar-menu-2").css({
			"transition":"0s"
		});

		$("#formulaire")
		.css({"display" : "none",})
		$("#formulaire-host")
		.css({"display" : "block",})
		$("#formulaire-transport")
		.css({"display" : "none",})
		$("#formulaire-contributors")
		.css({"display" : "none",})
		$("#formulaire-options")
		.css({"display" : "none",})

		$("#bouton-next-1")
		.css({"display" : "none",})
		$("#bouton-next-2")
		.css({"display" : "block",})
		$("#bouton-next-3")
		.css({"display" : "none",})
		$("#bouton-next-4")
		.css({"display" : "none",})
		$("#bouton-next-5")
		.css({"display" : "none",})

});

$("#bouton-next-2").on('click',function(){

		$("#bar-menu-2").removeClass('activeAfter');

		$("#bar-menu-3").addClass('activeAfter');
		$("#bar-menu-3").css({
			"transition":"0s"
		});

		$("#formulaire")
		.css({"display" : "none",})
		$("#formulaire-host")
		.css({"display" : "none",})
		$("#formulaire-transport")
		.css({"display" : "block",})
		$("#formulaire-contributors")
		.css({"display" : "none",})
		$("#formulaire-options")
		.css({"display" : "none",})

		$("#bouton-next-1")
		.css({"display" : "none",})
		$("#bouton-next-2")
		.css({"display" : "none",})
		$("#bouton-next-3")
		.css({"display" : "block",})
		$("#bouton-next-4")
		.css({"display" : "none",})
		$("#bouton-next-5")
		.css({"display" : "none",})

});

$("#bouton-next-3").on('click',function(){

		$("#bar-menu-3").removeClass('activeAfter');

		$("#bar-menu-4").addClass('activeAfter');
		$("#bar-menu-4").css({
			"transition":"0s"
		});

		$("#formulaire")
		.css({"display" : "none",})
		$("#formulaire-host")
		.css({"display" : "none",})
		$("#formulaire-transport")
		.css({"display" : "none",})
		$("#formulaire-contributors")
		.css({"display" : "block",})
		$("#formulaire-options")
		.css({"display" : "none",})

		$("#bouton-next-1")
		.css({"display" : "none",})
		$("#bouton-next-2")
		.css({"display" : "none",})
		$("#bouton-next-3")
		.css({"display" : "none",})
		$("#bouton-next-4")
		.css({"display" : "block",})
		$("#bouton-next-5")
		.css({"display" : "none",})

});

$("#bouton-next-4").on("click",function(){

		$("#bar-menu-4").removeClass('activeAfter');

		$("#bar-menu-5").addClass('activeAfter');
		$("#bar-menu-5").css({
			"transition":"0s"
		});

		$("#formulaire").css({"display" : "none"});
		$("#formulaire-host").css({"display" : "none"});
		$("#formulaire-transport").css({"display" : "none"});
		$("#formulaire-contributors").css({"display" : "none"});
		$("#formulaire-options").css({"display" : "block"});

		$("#bouton-next-1").css({"display" : "none"});
		$("#bouton-next-2").css({"display" : "none"});
		$("#bouton-next-3").css({"display" : "none"});
		$("#bouton-next-4").css({"display" : "none"});
		$("#bouton-next-5").css({"display" : "block",})

});

$("#formulaire-host .icones-formu").on('click',function(){
	if($(this).hasClass('icones-bordures')){
		$(this).removeClass('icones-bordures');
	}else{
		$('#formulaire-host .icones-formu').removeClass('icones-bordures');
		$(this).addClass('icones-bordures');
	}
});

$("#formulaire-transport .icones-formu").on('click',function(){
	if($(this).hasClass('icones-bordures')){
		$(this).removeClass('icones-bordures');
	}else{
		$('#formulaire-transport .icones-formu').removeClass('icones-bordures');
		$(this).addClass('icones-bordures');
	}
});

$("#formulaire-contributors .icones-formu").on('click',function(){
	if($(this).hasClass('icones-bordures')){
		$(this).removeClass('icones-bordures');
	}else{
		$('#formulaire-contributors .icones-formu').removeClass('icones-bordures');
		$(this).addClass('icones-bordures');
	}
});

  



$(".other_option").on('click',function(){
	$(".add_option").html('<input type="text" name="option1_name" class="champs" placeholder="Titre..."></textarea><textarea name="option1_description" class="champs" placeholder="Description..."></textarea><input name="option1_price" type="number" class="champs" placeholder="Price per person...">');
});



// Likes

var app = angular.module("myApp",[]);


app.controller("likes", function($scope, $http) {

    $scope.unLike = function(e) {
        e.preventDefault();
        
        var id = $(e.target).data('id');
        $('ul[data-id="'+id+'"] .spinner-like').css('display','inline-block');
        $('ul[data-id="'+id+'"] .like_number').hide();

        $http.get(url+'/likes/destroy/'+id).
            success(function(data, status, headers, config) {
                if (data.success == true){
                    nblike = $('ul[data-id="'+id+'"] .like_number').html();
                    $('ul[data-id="'+id+'"] .like_number').html(parseInt(nblike)-1).show();
                    $('#' + id + ' .like.on').hide();
                    $('#' + id + ' .like.off').show();
                };

                $('ul[data-id="'+id+'"] .like_number').show()
                $('ul[data-id="'+id+'"] .spinner-like').hide();

                return;
            })
            .error(function(data, status, headers, config) {
              // log error
            });
        return false;
    }
    
    $scope.like = function(e) {
        e.preventDefault();
        
        var id = $(e.target).data('id');
        $('ul[data-id="'+id+'"] .spinner-like').css('display','inline-block');
        $('ul[data-id="'+id+'"] .like_number').hide();

        $http.get(url+'/likes/create/'+id).
            success(function(data, status, headers, config) {
                if (data.success == true){
                    nblike = $('ul[data-id="'+id+'"] .like_number').html();
                    $('ul[data-id="'+id+'"] .like_number').html(parseInt(nblike)+1).show();
                    $('#' + id + ' .like.on').show();
                    $('#' + id + ' .like.off').hide();
                };

                $('ul[data-id="'+id+'"] .like_number').show()
                $('ul[data-id="'+id+'"] .spinner-like').hide();

                return;
            })
            .error(function(data, status, headers, config) {
              // log error
            });
        return false;
    }
        
});



