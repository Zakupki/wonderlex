/*
    js for profile service membership wsite
 */

/*global wonderlex*/

var profile;

function Profile() {

    "use strict";

    var Self = this;

    this.controls = {};

    this.getControl = function() {
        var ctrl = Self.controls;
        ctrl.profilePacketList = $('#profile-packet-list');
        ctrl.packetItems = ctrl.profilePacketList.find('.profile__packet-list-item');
        ctrl.packetInfo = ctrl.profilePacketList.find('.profile__packet-info');
        ctrl.toolTipText = ctrl.profilePacketList.find('.profile__packet-info-text');
        ctrl.improve = $('.profile__packet-improve');
    };

    this.addEventList = function() {

        var ctrl = Self.controls,
            isAnimate = true;

        var closeOpenedItems = function(element) {
            clearTimeout(isAnimate);
            var animElement = $(element).find('.profile__packet-button-wrap');

            animElement.stop(true, true);
            animElement.animate({
                bottom: '0'
            }, 300, function() {
            });
        };

        ctrl.improve.on('click', function(){

            if (!$(this).hasClass('active')) {

                $(this).addClass('active');
                ctrl.profilePacketList.slideDown(500);

            }
            else {

                $(this).removeClass('active');
                ctrl.profilePacketList.slideUp(500);

            }
        });

        ctrl.packetItems.hover(

            function() {
                var This = $(this);

                clearTimeout(isAnimate);

                This.addClass('isAnimate');

                closeOpenedItems(ctrl.packetItems.filter(':not(.isAnimate)'));

                This.removeClass('isAnimate');

                isAnimate = setTimeout(function() {
                    var animElement = This.find('.profile__packet-button-wrap');
                    animElement.stop(true, true);

                    animElement.animate({
                        bottom: '-54px'
                    }, 100, function() {

                    });
                }, 300);
            },

            function() {
                closeOpenedItems($(this));
            }

        );

        ctrl.packetInfo.on('click', function() {

            var popupWindow = new wonderlex.Popup(),
                popupLayout;

            popupWindow.show({
                request: null
            });

            popupLayout = $('.popup__layout');

            var textToShow = $(this).find('.profile__packet-info-text');

            popupLayout.append(textToShow.html());

            var newPrivacy = popupLayout.find( '.privasy'),
                scroll = popupLayout.find( '.scroll-inner' );

            console.log(scroll);

            newPrivacy.height( popupLayout.height() - 120 );

            scroll.height( newPrivacy.height() - $( '.privasy__title').height() - 100 );
            if( $.browser.msie && $.browser.version <= 8 ) {
                Self.myScroll = scroll;
                Self.myScroll.jScrollPane();
            } else {
                Self.myScroll = new iScroll(scroll[0]);
            }

            popupLayout.find(' > *').css( { opacity: 0.1, 'background-color': '#fff' } );

            popupLayout.find(' > *').animate( { opacity: 1 },300, function(){
                popupLayout.css( { background: 'none' } );
            });

        });

        $(window).on( 'resize', function(){
            //var privacy = $( '.privasy' );

            //privacy.height( $('.popup__layout').height() - 120 );
            //$('.scroll-privacy').height( privacy.height() - $( '.privasy__title').height() - 100 );

            if( $.browser.msie && $.browser.version <= 8 ) {
                Self.myScroll.jScrollPane();
            } else {
                if( $( '.scroll-inner').length ){
                    if (Self.myScroll) {
                        Self.myScroll.refresh();
                    }
                }
            }

        } );

        ctrl.toolTipText.on('mouseleave', function() {
            $(this).fadeOut(300);
        });
    };

    this.init = function() {
        this.getControl();
        this.addEventList();
    };

    return this.init();
}

$(document).ready(function() {

    "use strict";

    profile = new Profile();
});
