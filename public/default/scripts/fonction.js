$(".vignettes").on('click',function(){	
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

$("#block_menu ul li").on('click',function(){	
	$(":last-child").unbind('click');
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