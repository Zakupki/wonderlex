$( function(){
    new About();
} );

var About = function(){
    this.init();
};
    About.prototype = {
        init: function(){
            var self = this;

            $('.about__quote').height($('.about__quote-item_active').height());

            self.controls();
        },
        controls: function(){
            var self = this;

            $('.about__quote-prev').click( function(){
                var index = $('.about__quote-item_active').index() - 1;

                if( index == -1 ) index = $('.about__quote-item').length - 1;

                self.slideLeft( index );
            } );
            $('.about__quote-next').click( function(){
                var index = $('.about__quote-item_active').index() + 1;

                if( index == $('.about__quote-item').length ) index = 0;

                self.slideRight( index );
            } );
        },
        slideLeft: function(index){
            var curElem = $('.about__quote-item').eq( index),
                active = $('.about__quote-item_active'),
                newHeight = curElem.height(),
                parent = curElem.parent();

            curElem.css({left:-1000, display: 'block', opacity: 0});
            parent.animate({ height: newHeight },150);
            active.animate({left:1000, opacity:0},300);
               curElem.animate({left:90, opacity: 1},300, function(){
                   active.removeClass('about__quote-item_active');
                   curElem.addClass('about__quote-item_active');
               });
        },
        slideRight: function(index){
            var curElem = $('.about__quote-item').eq( index),
                active = $('.about__quote-item_active'),
                newHeight = curElem.height(),
                parent = curElem.parent();

            curElem.css({left:1000, display: 'block', opacity: 0});
            parent.animate({ height: newHeight },150);
            active.animate({left:-1000, opacity:0},300);
            curElem.animate({left:90, opacity: 1},300, function(){
                active.removeClass('about__quote-item_active');
                curElem.addClass('about__quote-item_active');
            });
        }
    };
