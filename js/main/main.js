/* scroll */
jQuery(document).ready(function() {

    var speed = 10;     //Page scroll speed, decrease to speed up

    //Page scrolling
    function scroll()
    {
        var max = Math.max(start, end);
        var min = Math.min(start, end);
        
        if(max - min > 1)
        {
            var offset = (max-min)/speed;
            if(start > end)
            {
                start -= offset;  
            }
            else
            {
                start += offset;
            }
            jQuery(window).scrollTop(start);
        }
    }
    window.setInterval(scroll, 10);
	
    //The menu system
    var start = 0;
    var end = 0;
    jQuery('.joinLink, .feedLink, .link2 a').click(function(event) {
        event.preventDefault();

        var name = jQuery(this).attr('href').replace('#', '');
        var anchor = jQuery('a[name='+name+']');
        start = jQuery(window).scrollTop();
        end = anchor.offset().top;
        window.location.hash = name;
        return false;
    });
});


/* slider */	
$(window).load(function(){
	$(".delaycaptions-01").sliderkit({
		circular:true,
		keyboard:true,
		shownavitems:6,
		auto:true,
		autospeed:3000
});
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
	$(".delaycaptions-01").sliderkit({
		circular:true,
		keyboard:true,
		shownavitems:4,
		auto:true,
		autospeed:3000
	});
}
});	


$(document).click( function (event){
        if($(event.target).parents().filter('.window:visible').length != 1)
        $('.window').fadeOut();
});

/* feedback */			
$(document).ready(function(){
   $(".feedback a, .link2 a").click(function(){
     $(".feedback a").addClass("active");

     $(".windowFeedback .windowCont").css("display","block");
     $(".windowFeedback .windowContThanks").css("display","none");

     $(".windowFeedback").css("display","block");
     $(".windowFeedback").animate({
		 opacity:1
	 }, 300);
     $(".joinLink").removeClass("active");
     $(".windowReg").animate({
		 opacity:0
	 }, 300, function(){$(".windowReg").css("display","none")})
	 return false;
   });
   $(".windowFeedback .close").click(function(){
     $(".feedback a").removeClass("active");
     $(".windowFeedback").animate({
		 opacity:0
	 }, 300, function(){$(".windowFeedback").css("display","none")});
        return false;
   });
    var validator = $('.windowFeedback form').validate({
            errorPlacement: function(){},
            highlight: function(el){
                $(el).addClass('err');
            },
            unhighlight: function(el){
                $(el).removeClass('err');
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(){
                       $(".windowFeedback .windowCont").css("display","none");
                       $(".windowFeedback .windowContThanks").css("display","block");
                       validator.resetForm();
                    }
                });
            }
        });
/*
    $('.windowFeedback form').ajaxForm({
        success: function(){
           $(".windowFeedback .windowCont").css("display","none");
           $(".windowFeedback .windowContThanks").css("display","block");
        }
    });
*/
 });	
 
/* join */			
$(document).ready(function(){
   $(".joinLink").click(function(){
     $(this).addClass("active");
     $(".windowReg .windowCont").css("display","block");
     $(".windowReg .windowContThanks").css("display","none");

     $(".windowReg").css("display","block");
     $(".windowReg").animate({
		 opacity:1
	 }, 300);
     $(".feedback a").removeClass("active");
     $(".windowFeedback").animate({
		 opacity:0
	 }, 300, function(){$(".windowFeedback").css("display","none")});
	 return false;
   });
   $(".windowReg .close").click(function(){
     $(".joinLink").removeClass("active");
     $(".windowReg").animate({
		 opacity:0
	 }, 300, function(){$(".windowReg").css("display","none")})
        return false;
   });

    var validator = $('.windowReg form').validate({
            errorPlacement: function(){},
            highlight: function(el){
                $(el).addClass('err');
            },
            unhighlight: function(el){
                $(el).removeClass('err');
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(){
                       $(".windowReg .windowCont").css("display","none");
                       $(".windowReg .windowContThanks").css("display","block");
                       validator.resetForm();
                    }
                });
            }
        });
 });
 
/* select */
$(document).ready(function(){
	
    $('.select').click(function(event){
		event.stopPropagation();
		$('.select').css('z-index', 0);
		$('.select ul').not($(this).find($('ul'))).hide();
	    if($(this).find($('ul')).css('display') == 'none'){
		    $(this).find($('ul')).show();
			$(this).css('z-index', 10);
		}
		else{
		    $(this).find($('ul')).hide();
			$(this).css('z-index', 0);
		}
	});
	
	$('.select ul li').click(function(){
	    $(this).parent().parent().find('span').html($(this).html());
		$('.select ul').hide();
		return false;
	});

});


/* authors
----------------------------------------------- */
(function($){
$.fn.authors = function(o){
    o = $.extend({
        speed: 300,
        easing: 'easeOutExpo'
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $content = $('.content', $root),
            $list = $('.list', $root),
            height = $list.outerHeight(),
            $show = $('.show', $root),
            $hide = $('.hide', $root);
        $show.click(show);
        $hide.click(hide);
        function show() {
            $show.hide();
            $hide.show();
            $content.animate({'height': height}, {duration: o.speed, easing: o.easing, queue: false});
        }
        function hide() {
            $hide.hide();
            $show.show();
            $content.animate({'height': 1}, {duration: o.speed, easing: o.easing, queue: false});
        }
    });
};
})(jQuery);



/* noselect
----------------------------------------------- */
(function($){
$.fn.noselect = function(){
    return this.on('selectstart', function(e){
        e.preventDefault();
    });
};
})(jQuery);



/* jswap
----------------------------------------------- */
(function($){
$.fn.jswap = function(o){
    o = $.extend({
        speed: 300,
        easing: 'easeOutExpo',
        auto: 8000
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $items = $('.jswap-li', $root),
            total = $items.length,
            $prev = $('.jswap-prev', $root),
            $next = $('.jswap-next', $root),
            currentIndex = $items.index($items.filter('.jswap-current')),
            t,
            busy = false;

        if (total < 2) {
            return;
        }

        $prev.on('click', prev).noselect();

        $next.on('click', next).noselect();

        function prev() {
            show(currentIndex - 1);
        }
        function next() {
            show(currentIndex + 1);
        }

        function slideShow() {
            if (!o.auto) {
                return;
            }
            clearInterval(t);
            t = setInterval(function(){
                next();
            }, o.auto);
        }

        function show(index) {
            if (busy || index == currentIndex) {
                return;
            }
            clearInterval(t);
            busy = true;
            if (index < 0) {
                index = total - 1;
            } else if (index > total - 1) {
                index = 0;
            }
            $items.eq(currentIndex).hide().removeClass('jswap-current');
            $items.eq(index).fadeIn(o.speed, function(){
                currentIndex = index;
                busy = false;
                slideShow();
            });
        }
    });
};
})(jQuery);


$(function(){
    $('.sliderkit .sliderkit-btn').on('selectstart', function(e){
        e.preventDefault();
    });
    $('.authors').authors();
    $('.quotes').jswap();
});