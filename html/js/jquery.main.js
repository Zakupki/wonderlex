var wonderlex;

$(function(){
    "use strict";
    wonderlex = Wonderlex;
    Wonderlex.init();
} );

/*
    Wonderlex
    main class

    depend:
        js/modernizr-2.6.2.min.js
        js/jquery-1.9.0.min.js
        js/tween-max.min.js

    methods:
        init(initialize object);
        controls(initialize object controls);
        rotateHeader (rotate header);
        getInternetExplorerVersion (get Internet Explorer version ).

    Sub classes:
        Authors;
        Social;
        Banners.
*/
var Wonderlex = {
    /* initialize object */
    init: function(){
        var self = this,
            header = $( '.header__cube');

        self.centerContent( $('.search-result__notfound') );
        self.centerContent( $('.error-page') );

        self.ie = self.getInternetExplorerVersion();

        self.authors = new self.Authors( $( '.authors__gallery' ) );
        self.banner = new self.Banners( $( '.banner' ) );
        self.social = new self.Social( $( '.social' ) );
        self.popup = new self.Popup();
        self.authorization = new self.Authorization();

        if( !Modernizr.csstransforms3d || self.ie > 1 ) {
            header.addClass( 'header__cube_dis' );
        }

        self.privacyRequest = new XMLHttpRequest();

        self.controls();

        self.checkOS();
    },

    /* object controls */
    controls: function() {
        var self = this
            authorsListLabel = $('#authors-list-label'),
            authorsListSortLabel = $('#authors-list-sort-label'),
            authorsListSortParameters = $('#authors-list-sort-parameters'),
            authorsListSortWrap = $('.authors-list__sort-popup');

        //==============================================================================================================
        // for open/close sort
        //==============================================================================================================
        authorsListSortWrap.on('click', function () {

            if (authorsListSortParameters.hasClass('authors-list__sort-popup_opened')) {
                authorsListSortParameters.slideUp(300, function() {
                    authorsListSortParameters.removeClass('authors-list__sort-popup_opened');
                    authorsListSortWrap.removeClass('authors-list__sort-popup_opened');
                    authorsListSortLabel.removeClass('authors-list__sort-header_opened');
                });
            }
            else {
                authorsListSortLabel.addClass('authors-list__sort-header_opened');
                authorsListSortWrap.addClass('authors-list__sort-popup_opened');
                authorsListSortParameters.slideDown(300, function() {
                    authorsListSortParameters.addClass('authors-list__sort-popup_opened');
                });
            }

        });

        /* animate header */
        $( '.language__lnk' ).on( 'click', function() {
            var headerRus = $( '.header__item_rus'),
                headerEn = $( '.header__item_en'),
                currentObj = $( this );

            if( Modernizr.csstransforms3d ) {
              return self.rotateHeader( currentObj );
            } else {
                $( '.header').css( {
                    overflow: 'hidden'});
                headerEn.css( {'display':'block'} );

                if( headerRus.position().top == 0 ) {
                    headerRus.animate( { top: '-100%' }, 300 );
                    headerEn.animate( { top: 0 }, 300, function(){
                       window.location.href = currentObj.attr( 'href' );
                    } );
                } else {
                    headerRus.animate( { top: 0 }, 300 );
                    headerEn.animate( { top: '100%' }, 300, function(){
                      window.location.href = currentObj.attr( 'href' );
                    } );
                }
                return false;
            }
        } );

        /* show privacy */
        $( '.footer .main-menu__lnk' ).on( 'click', function(){
            var privacy = 0;

            if( $(this).hasClass('main-menu__lnk_privacy') ) {
                privacy = 1;
            }

            self.showPrivacy( $( this).attr( 'href' ), privacy );

            return false;
        } );

        /* hide privacy */
        $( '.header').click( 'mousedown', function() {
            self.popup.hide();
        } );

        /* header resize */
        $(window).scroll(function() {
            var scrollElem = ( window.scrollY == undefined ) ? document.documentElement.scrollTop : window.scrollY,
                header = $( '.header'),
                site = $( '.site__content' );

            if( scrollElem || $( '.popup').length ){
                header.addClass( 'header_small' );
                site.addClass( 'site__content_small' );
            } else {
                header.removeClass( 'header_small' );
                site.removeClass( 'site__content_small' );
            }
        });

        //main menu poppup
        $( '.main-menu__item_sub').hover( function(){
            $( this).find( '.main-menu__sub' ).stop().fadeIn( 300 );
        }, function(){
            $( this).find( '.main-menu__sub' ).stop().fadeOut( 300 );
        } );
        //main menu poppup
        $( '.account__profile').hover( function(){
            $( this).find( '.account__profile-menu' ).stop().fadeIn( 300 );
        }, function(){
            $( this).find( '.account__profile-menu' ).stop().fadeOut( 300 );
        } );

        /* privacy resize */
        $( window ).on( 'resize', function(){
            var privacy = $( '.privasy' );

            privacy.height( $('.popup__layout').height() - 120 );
            $('.scroll-privacy').height( privacy.height() - $( '.privasy__title').height() - 100 );

            if( $.browser.msie && $.browser.version <= 8 ) {
                $('.scroll').jScrollPane();
            } else {
                if( $( '.scroll').length ){
                    if (self.myScroll) {
                        self.myScroll.refresh();
                    }
                }
            }

            self.centerContent( $('.search-result__notfound') );
            self.centerContent( $('.error-page') );
        } );

        /* search more */
        $( '.search-result__more' ).on( 'click', function(){
            self.authorization.showSearchForm();
            return false;
        } );
    },

    centerContent: function( obj ){
        if( obj.length ) {
            obj.css( { top: ( ( $( window ).height() - 240 ) - obj.innerHeight() ) / 2 } );
        }
    },

    disableScroll: function(){
        var keys = [37, 38, 39, 40];

        if (window.addEventListener) {
            window.addEventListener('DOMMouseScroll', wheel, false);
        }
        window.onmousewheel = document.onmousewheel = wheel;
        document.onkeydown = keydown;
        document.ontouchmove = function(e){ e.preventDefault(); }


    },

    enableScroll: function(){

        if (window.removeEventListener) {
            window.removeEventListener('DOMMouseScroll', wheel, false);
        }

        window.onmousewheel = document.onmousewheel = document.onkeydown = null;

        document.ontouchmove = function(e){ return true; }
    },

    showPrivacy: function( url, privacy ){
        var self = this;

        self.privacyRequest.abort();

        self.popup.show( {
            request: self.request
        } );

        self.privacyRequest = $.ajax( {
            url: url,
            data: 'lang=' + $( '.language__lnk_active' ).text() + '&privacy=' + privacy,
            dataType: 'json',
            timeout: 20000,
            type: "GET",
            success: function(msg){
                var popupLayout = $('.popup__layout'),
                    newPrivacy, scroll;

                popupLayout.append( msg.html );

                newPrivacy = popupLayout.find( '.privasy' );
                scroll = popupLayout.find( '.scroll' );

                newPrivacy.height( popupLayout.height() - 120 );

                scroll.height( newPrivacy.height() - $( '.privasy__title').height() - 100 );
                if( $.browser.msie && $.browser.version <= 8 ) {
                    $('.scroll').jScrollPane();
                } else {
                    self.myScroll = new iScroll( $('.scroll')[0]);
                }

                popupLayout.find(' > *').css( { opacity: 0.1, 'background-color': '#fff' } );

                popupLayout.find(' > *').animate( { opacity: 1 },300, function(){
                    popupLayout.css( { background: 'none' } );
                } )

            },
            error: function(XMLHttpRequest){
                if(XMLHttpRequest.statusText!="abort"){
                    alert("При попытке отправить сообщение произошла неизвестная ошибка. \n Попробуй еще раз через несколько минут.");
                }
            }
        } );

    },

    /* rotate header */
    rotateHeader: function( obj ) {
        var header = $( '.header__cube' );

        $( '.header').css( {
            overflow: 'hidden'
        } );

        setTimeout( function(){
            $( '.header').css( {
                '-webkit-perspective': '1000px',
                '-o-perspective': '1000px',
                '-ms-perspective': '1000px'
            } );

            header.removeClass( 'header__cube_rus' );
            header.removeClass( 'header__cube_en' );
            header.addClass( obj.attr( 'data-action' ) );

            setTimeout( function(){
                window.location.href = obj.attr( 'href' );
            }, 1000 );

        },100 );


        return false;
    },

    checkOS: function() {
        "use strict";

        var USER_DATA = {

            Browser: {
                KHTML: /Konqueror|KHTML/.test(navigator.userAgent) &&
                    !/Apple/.test(navigator.userAgent),
                Safari: /KHTML/.test(navigator.userAgent) &&
                    /Apple/.test(navigator.userAgent),
                Opera: !!window.opera,
                MSIE: !!(window.attachEvent && !window.opera),
                Gecko: /Gecko/.test(navigator.userAgent) &&
                    !/Konqueror|KHTML/.test(navigator.userAgent)
            },

            OS: {
                Windows: navigator.platform.indexOf("Win") > -1,
                Mac: navigator.platform.indexOf("Mac") > -1,
                Linux: navigator.platform.indexOf("Linux") > -1
            }
        };

        if (USER_DATA.OS.Linux || USER_DATA.OS.Mac) {
            var cartPurhchaseButton = $('.cart-pushcase__button-submit'),
                customListItem = $('.jui-custom-select__item'),
                authorsNewLabel = $('.authors-list__new'),
                profilePacketButton = $('.profile__packet-button');

            cartPurhchaseButton.css('padding-bottom', 15 + 'px');
            customListItem.css('padding-bottom', parseInt(customListItem.css('padding-bottom'), 10) - 4 + 'px');
            authorsNewLabel.css('padding-bottom', parseInt(authorsNewLabel.css('padding-bottom'), 10) - 4 + 'px');
            profilePacketButton.css('padding-bottom', parseInt(profilePacketButton.css('padding-bottom'), 10) - 4 + 'px');
        }

    },

    /* get Internet Explorer version */
    getInternetExplorerVersion: function() {
        var rv = -1; // Return value assumes failure.
        if (navigator.appName == 'Microsoft Internet Explorer') {
            var ua = navigator.userAgent;
            var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
            if (re.exec(ua) != null)
                rv = parseFloat(RegExp.$1);
        }
        return rv;
    }
};

 /*
* Authorization
*
*   Methods
*       init(initialize object),
*       controls(initialize object controls),
*       showRegistration,
*       remindPassword,
*       showgoodMessage (showing messege if all done well),
*       login,
*       showLogin (show login form),
*       validateItem (validation),
*       showSearchForm (shoeing search form)
* */
Wonderlex.Authorization = function() {
    this.obj = $( '.account' );
    this.elems = {
        logBtn: this.obj.find( '.account__login' ),
        regBtn: this.obj.find( '.account__registration' ),
        loginInput: this.obj.find( '.login__input' ),
        reminder: this.obj.find( '.login__forgot-pass' ),
        btn: $('#search')
    };
    this.request = new XMLHttpRequest();
    this.loginRequest = new XMLHttpRequest();

    this.init();
};
    Wonderlex.Authorization.prototype = {
        /* init(initialize object) */
        init: function() {
            var self = this;

            self.controls();
        },
        /* /init */

        /* controls(initialize object controls) */
        controls: function() {
            var self = this,
                elems = self.elems,
                body = $( 'body' );

            /* show search form */
            elems.btn
                .off( 'click' )
                .on( 'click', function( event ){
                    event = event || window.event

                        (event.stopPropagation) ? event.stopPropagation():event.cancelBubble = true;

                    self.showSearchForm();
                } );

            /* show registration form */
            elems.regBtn
                .off( 'click' )
                .on( 'click', function( event ){
                    event = event || window.event

                    (event.stopPropagation) ? event.stopPropagation():event.cancelBubble = true;

                    self.showRegistration();
                } );

            /* show login form */
            elems.logBtn
                .off( 'click' )
                .on( 'click', function( event ){
                    event = event || window.event

                    (event.stopPropagation) ? event.stopPropagation():event.cancelBubble = true;

                    self.showLogin();
                } );

            /* validate item on blur */
            elems.loginInput
                .off('blur')
                .on( 'blur', function() {
                    self.validateItem( $( this ) );
                } );

            /* delete validate error class */
            elems.loginInput
                .off('focus')
                .on( 'focus', function() {
                    $( this ).parents( '.login__layout' ).find( '.tooltip').remove();
                    $( this ).removeClass( 'err' );
                } );

            /* show reminder form */
            elems.reminder
                .off('click')
                .on( 'click', function() {
                    var curElem = $( this );

                    curElem.parents('form').find( '.login__layout').eq( 1 ).css( { display: 'none' } );
                    $('.login__send').css( { display: 'none' } );
                    $('.login__reminder').css( { display: 'block' } );
                    $( this ).css( { display: 'none' } );

                    var login = $('.login');
                    login.css( { top: ( $('.popup__layout').height() - login.height() + 31 ) / 2 } )
                } );

            /* remind password */
            body
                .off( 'click', '.login__reminder' )
                .on( 'click', '.login__reminder', function(){
                if ( self.validateItem( elems.loginInput.eq( 0 ) ) ) {
                    self.remindPassword();
                }

                return false;
            } );

            /* login */
            body
                .off( 'submit', '.login' )
                .on( 'submit', '.login', function(){
                    if( $( this ).parents( '.registration').length ) {
                            if ( $( '#login__check')[ 0 ].checked ){
                                if ( self.validateItem( elems.loginInput ) ) {
                                    self.registrate();
                                }
                            } else {
                                showErr( 'Согласитесь с соглашением' );
                            }
                    } else {
                        if ( self.validateItem( elems.loginInput ) ) {

                            self.login();
                        }
                    }


                    return false;

                    function showErr( text ) {
                        var errMsg = $( '<div class="err-message">' + text + '</div>' );

                        $( '.login' ).append( errMsg );
                    }
                } );

            /* rebuild page on resize */
            $( window ).on( 'resize', function(){
                var login = $('.login');

                if( login.parents( '.registration').length ){
                    login.parents( '.registration').css( { top: ($('.popup__layout').height() - login.innerHeight())/2 } );
                } else {
                    login.css( { top: ( $('.popup__layout').height() - login.height() + 31 ) / 2 } );
                }
            } );
        },
        /* /controls */

        /* showSearchForm (shoeing search form) */
        showSearchForm: function(){
            var self = this,
                elems = self.elems;

            Wonderlex.popup.show( {
                request: self.request
            } );
            self.request.abort();
            self.request = $.ajax( {
                url:  elems.btn.attr( 'data-php' ),
                data: 'lang=' + $( '.language__lnk_active' ).text(),
                dataType: 'json',
                timeout: 20000,
                type: "GET",
                success: function(msg){
                    var popupLayout = $('.popup__layout').eq(-1),
                        search,
                        slider;

                    popupLayout.css( { width: '100%' } );
                    popupLayout.append( msg.html );

                    slider = popupLayout.find( '.switch__slider > div' ).slider( {
                        min: 0,
                        max: 1,
                        value: 0,
                        slide: function( event, ui ) {
                            popupLayout.find( '.switch__txt').removeClass( 'switch__txt_active' );
                            popupLayout.find( '.switch__txt').eq( ui.value ).addClass( 'switch__txt_active' );
                            popupLayout.find( '.switch__radio').eq( ui.value ).attr( 'checked', true );
                        },
                        change: function( event, ui ) {
                            popupLayout.find( '.switch__txt').removeClass( 'switch__txt_active' );
                            popupLayout.find( '.switch__txt').eq( ui.value ).addClass( 'switch__txt_active' );
                            popupLayout.find( '.switch__radio').eq( ui.value ).attr( 'checked', true );
                        }
                    } );

                    popupLayout.find( '.search-form__search-txt' ).focus();

                    search = popupLayout.find( '.search-form');

                    popupLayout.find(' > *').css( { opacity: 0.1, 'background-color': '#fff' } );

                    popupLayout.find(' > *').animate( { opacity: 1 },600, function(){
                        elems.loginInput = $( '.login__input' );
                        self.controls();
                        popupLayout.css( {background: 'none'} );
                    } );

                    popupLayout.find( '.switch__txt').on( 'click', function(){
                        if( $( this).index() == 0 ) {
                            slider.slider( "value", 0 );
                        } else {
                            slider.slider( "value", 1 );
                        }
                    } );
                },
                error: function(XMLHttpRequest){
                    if(XMLHttpRequest.statusText!="abort"){
                        alert("При попытке отправить сообщение произошла неизвестная ошибка. \n Попробуй еще раз через несколько минут.");
                    }
                }
            } );
        },
        /* /showSearchForm  */

        /* showRegistration */
        showRegistration: function() {
            var self = this,
                elems = self.elems;

            Wonderlex.popup.show( {
                request: self.request
            } );
            self.request.abort();
            self.request = $.ajax( {
                url:  elems.regBtn.attr( 'data-php' ),
                data: 'lang=' + $( '.language__lnk_active' ).text(),
                dataType: 'json',
                timeout: 20000,
                type: "GET",
                success: function(msg){
                    var popupLayout = $('.popup__layout').eq(-1);

                    popupLayout.append( msg.html );

                    changeCheckStart( popupLayout.find( '.niceCheck' ) );

                    login = popupLayout.find( '.registration');

                    if( $.browser.msie && $.browser.version <= 9 ) {
                        setTimeout( function(){
                            $('input[placeholder], textarea[placeholder]').placeholder();
                        },700 );
                    }
                    if( $.browser.msie && $.browser.version <= 8 ) {
                        $('.scroll').jScrollPane();
                    } else {
                        self.myScroll = new iScroll( $('.scroll')[ $('.scroll').length-1 ] , {
                            desktopCompatibility:true,
                            fadeScrollbar: false,
                            useTransition:true
                        });
                    }

                    popupLayout.find(' > *').css( { opacity: 0.1, 'background-color': '#fff' } );

                    login.css( {
                        top: (popupLayout.height() - login.innerHeight()) / 2,
                        left: (popupLayout.width() - login.innerWidth()) / 2
                    } );

                    popupLayout.find(' > *').animate( { opacity: 1 },600, function(){
                        elems.loginInput = $( '.login__input' );
                        self.controls();
                        popupLayout.css( {background: 'none'} );
                    } )
                },
                error: function(XMLHttpRequest){
                    if(XMLHttpRequest.statusText!="abort"){
                        alert("При попытке отправить сообщение произошла неизвестная ошибка. \n Попробуй еще раз через несколько минут.");
                    }
                }
            } );
        },
        /* /showRegistration */

        /* remindPassword */
        remindPassword: function(){
            var self = this,
                login = $('.login'),
                elems = self.elems;

            self.loginRequest.abort();
            self.loginRequest = $.ajax( {
                url: login.attr( 'data-php' ), // from form attribute action
                data: 'input_login=' + elems.loginInput.eq( 0).val(), // form serialize
                dataType: 'json',
                timeout: 20000,
                type: "GET",
                success: function(msg, success, XMLHttpRequest){
                    self.showgoodMessage( XMLHttpRequest.statusText );
                },
                error: function(XMLHttpRequest){
                    var status = XMLHttpRequest.status,
                        statusText = XMLHttpRequest.statusText;

                    if( statusText != "abort" ){
                        if ( status == 401 ){
                            showErr(statusText);
                        } else if ( status == 404 ){
                            showErr(statusText);
                        } else {
                            showErr(statusText);
                        }
                    }
                }
            } );
            function showErr( text ) {
                var errMsg = $( '<div class="err-message">' + text + '</div>' );

                login.append( errMsg );
            }
        },
        /* /remindPassword */

        /* showgoodMessage (showing messege if all done well) */
        showgoodMessage: function( txt ){
            var self = this,
                login = $( '.login'),
                curElems = login.find( '> *'),
                goodText = $( '<div class="good-text">' + txt + '</div>'),
                layOut = login.parents('.popup__layout');

            layOut.append( goodText );
            goodText.css( {
                top: ( layOut.height() - goodText.height()) / 2,
                left: ( layOut.width() - goodText.width()) / 2
            } );

            layOut.css( { 'textAlign': 'center' } );
            curElems.fadeOut( 300 );
            $('.registration__aside').fadeOut( 300 );
            goodText.fadeIn( 300 );

            setTimeout( function(){
                self.showLogin( self.elems.loginInput.filter( '.email' ).val() );
            }, 3000 );

        },
        /* /showgoodMessage */

        registrate: function(){
            var self = this,
                login = $('.login'),
                elems = self.elems;

            self.loginRequest.abort();
            self.loginRequest = $.ajax( {
                url: login.attr( 'action' ), // from form attribute action
                data: login.serialize(), // form serialize
                dataType: 'json',
                timeout: 20000,
                type: "GET",
                success: function(msg, success, XMLHttpRequest){
                    self.showgoodMessage( XMLHttpRequest.statusText );
                },
                error: function(XMLHttpRequest){
                    var status = XMLHttpRequest.status,
                        statusText = XMLHttpRequest.statusText;

                    if( statusText != "abort" ){
                        if ( status == 401 ){
                            showErr(statusText);
                        } else if ( status == 404 ){
                            showErr(statusText);
                        } else {
                            showErr(statusText);
                        }
                    }
                }
            } );
            function showErr( text ) {
                var errMsg = $( '<div class="err-message">' + text + '</div>' );

                login.append( errMsg );
            }
        },

        /* login */
        login: function(){
            var self = this,
                login = $( '.login' );

            self.loginRequest.abort();
            self.loginRequest = $.ajax( {
                url: login.attr( 'action' ), // from form attribute action
                data: login.serialize(), // form serialize
                dataType: 'json',
                timeout: 20000,
                type: "GET",
                success: function(){
                    window.location.reload()
                },
                error: function(XMLHttpRequest){
                    var status = XMLHttpRequest.status,
                        statusText = XMLHttpRequest.statusText;

                    if( statusText != "abort" ){
                        if ( status == 401 ){
                            showErr(statusText);
                        } else if ( status == 404 ){
                            showErr(statusText);
                        } else {
                            showErr(statusText);
                        }
                    }
                }
            } );

            function showErr( text ) {
                var errMsg = $( '<div class="err-message">' + text + '</div>' );

                login.append( errMsg );
            }
        },
        /* /login */

        /* showLogin (show login form) */
        showLogin: function ( txt ){
            var self = this,
                elems = self.elems;

            Wonderlex.popup.show( {
                request: self.request
            } );
            self.request.abort();
            self.request = $.ajax( {
                url:  elems.logBtn.attr( 'data-php' ),
                data: 'lang=' + $( '.language__lnk_active' ).text(),
                dataType: 'json',
                timeout: 20000,
                type: "GET",
                success: function(msg){
                    var popupLayout = $('.popup__layout').eq(-1);

                    popupLayout.append( msg.html );

                    if ( txt != undefined ){
                        var items = popupLayout.find('.login__input');
                        items.eq( 0 ).val(txt);
                        items.eq( 1 ).focus();
                    }

                    if( $.browser.msie && $.browser.version <= 9 ) {
                        setTimeout( function(){
                            $('input[placeholder], textarea[placeholder]').placeholder();
                        },700 );
                    }

                    login = popupLayout.find( '.login');

                    popupLayout.find(' > *').css( { opacity: 0.1, 'background-color': '#fff' } );
                    login.css( { top: ( popupLayout.height() - login.height() + 31 ) / 2 } );

                    popupLayout.find(' > *').animate( { opacity: 1 },600, function(){
                        elems.loginInput = $( '.login__input' );
                        elems.reminder =  $( '.login__forgot-pass' );
                        self.controls();
                        popupLayout.css( {background: 'none'} );
                    } )
                },
                error: function(XMLHttpRequest){
                    if(XMLHttpRequest.statusText!="abort"){
                        alert("При попытке отправить сообщение произошла неизвестная ошибка. \n Попробуй еще раз через несколько минут.");
                    }
                }
            } );
        },
        /* /showLogin */

        /* validateItem (validation) */
        validateItem: function( /*item or item arrey*/obj ){
            var check = true,
                passwords = obj.filter( '.login__input_pass');

            obj.each( function(){
                var curElem = $( this );

                if( curElem.val() == '' ){
                    check = false;

                    curElem.addClass( 'err' );

                    tooltip( {
                        obj: curElem,
                        position: curElem.position(),
                        text: curElem.parents( 'form').attr( 'data-empty' )
                    } );

                    return false;
                }

                if( curElem.filter( '.email').length ){
                    if( !(/^[-._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/i.test($( this ).val()) ) ){
                        check = false;

                        curElem.addClass( 'err' );

                        tooltip( {
                            obj: curElem,
                            position: curElem.position(),
                            text: curElem.parents( 'form').attr( 'data-mail' )
                        } );

                        return false;
                    }
                }
            } );

            if( passwords.length == 2 && check ){
                if( passwords.eq( 0 ).val() != passwords.eq( 1 ).val() ){
                    check = false;

                    passwords.eq( 0 ).addClass( 'err' );

                    tooltip( {
                        obj: passwords.eq( 0 ),
                        position: passwords.eq( 0 ).position(),
                        text: 'Пароли<br /> не совпадают'
                    } );
                }
            }


            return check;

            function tooltip ( params ){
                var tooltip = $( '<div class="tooltip">' + params.text + '</div>' );

                tooltip.css( {
                    top: params.position.top + 22,
                    opacity: 0
                } );

                if( params.obj.hasClass( 'login__input_pass') && params.obj.parents( '.registration').length == 0 ) {
                    tooltip.css( {right: 120} );
                }

                params.obj.parents( '.login__layout' ).append( tooltip );
                tooltip.animate( { opacity: 1 } );
                removeTooltip( tooltip );

                tooltip.on( 'click', function(){
                    $( this ).parents( '.login__layout' ).find( 'input' ).focus();
                } );
            }
            function removeTooltip ( obj ){
                setTimeout( function(){
                    obj.fadeOut( 300, function(){
                        $( this ).remove();
                    } );
                }, 1500 );
            }
        }
    };
/*
* /Authorization
* */

/*
* Popup
*
*   methods:
*       init;
*       controls;
*       show;
*       hide.
* */
Wonderlex.Popup = function(){

    this.init();
};
    Wonderlex.Popup.prototype = {
        init: function() {
            var self = this;

            self.controls();
        },
        controls: function(){
            /* popup resize */
            $( window ).on( 'resize', function() {
                var header = $( '.header'),
                    site = $( '.site__content'),
                    popup = $( '.popup' );

                if( popup.length ){
                    header.addClass('header_small');
                    site.addClass( 'site__content_small' );
                    popup.height( $( this ).height() - 30 );
                    popup.find( '.popup__layout').css( {
                        height: popup.height()
                    } );
                }
            } );

        },
        show: function( params ){
            var self = this,
                header = $( '.header'),
                site = $( '.site__content'),
                popup = $( '<div class="popup">\
                                <div class="popup__close"></div>\
                                <div class="popup__layout"></div>\
                            </div>');

            self.request = params.request || new XMLHttpRequest();

            header.addClass('header_small');
            site.addClass( 'site__content_small' );

            popup.css( {
                top: 60,
                height: $( window ).height() - 30
            } );
            popup.find( '.popup__layout').css( {
                height: popup.height()
            } );

            Wonderlex.disableScroll();

            $( 'body' ).append( popup );

            popup.fadeIn( 500, function(){
                var popups = $('.popup' );
                if(popups.length > 1) {
                    popups.eq( 0 ).remove();
                }
            } );

            popup.find('.popup__close').on( 'click', function(){
                if (!$(this).find('a').length) {
                    self.hide();
                }
            } );
        },
        hide: function(){
            var self = this,
                popup = $( '.popup'),
                scrollElem = ( window.scrollY == undefined ) ? document.documentElement.scrollTop : window.scrollY,
                header = $( '.header'),
                site = $( '.site__content' );

            popup.fadeOut( 500, function() {

                if( !scrollElem ){
                    header.removeClass( 'header_small' );
                    site.removeClass( 'site__content_small' );
                }
                self.request.abort();
                Wonderlex.enableScroll();
                $( this ).remove();
            } );
        }

    };
/*
* /Popup
* * /

/*Social*/
Wonderlex.Social = function( obj ){
    this.obj = obj;
    this.elems = {
        btns: $( '.social__item' ),
        items: $( '.social__content-item' )
    };

    this.init();
};
    Wonderlex.Social.prototype = {
        init: function(){
            var self = this;

            self.startView();
            self.controls();
        },
        controls: function(){
            var self = this,
                elems = self.elems;

            elems.btns.on( 'click', function(){
                elems.btns.removeClass( 'social__item_active' );
                $( this ).addClass( 'social__item_active' );

                self.startView();
            } );
        },
        startView: function(){
            var self = this,
                elems = self.elems;
                elems.items.css( { top: '100%' } );
                elems.items.eq( elems.btns.filter( '.social__item_active' ).index()).css( { top: '0' } );

        }
    };
/*
    /Social
*/

/*
    Baners

     methods:
     init(initialize object),
     controls(initialize object controls),
     events(add events),
     addTweens
 */
Wonderlex.Banners = function( obj ) {
    this.obj = obj;
    this.elems = {
        items: this.obj.find( '> .banner__item' ),
        closeBtn: $( '<div class="banner__close"></div>' )
    };


    this.init();
};
    Wonderlex.Banners.prototype = {

        /*
            init
            (initialize object)
        */
        init: function(){
            var self = this,
                elems = self.elems;

            if( $( '.banner__item_video').length ){
                self.iframe = $('#player1')[0];
                self.player = $f(self.iframe);
                self.status = $('.status');

                // When the player is ready, add listeners for pause, finish, and playProgress
                self.player.addEvent('ready', function() {
                    self.status.text('ready');

                    self.player.addEvent('pause', onPause);
                    self.player.addEvent('finish', onFinish);
                    self.player.addEvent('playProgress', onPlayProgress);

                    function onPause(  ) {
                        self.status.text('paused');
                    }

                    function onFinish() {
                        self.status.text('finished');
                    }

                    function onPlayProgress(data) {
                        self.status.text(data.seconds + 's played');
                    }
                });

                elems.items.append( elems.closeBtn );
            } else {
                elems.items.css( {
                    'visibility': 'hidden',
                    'position': 'absolute',
                    top: 0
                } );
                elems.items.each( function(){
                    $( this ).css( {
                        left: ( self.obj.width() - $( this ).width() ) / 2
                    } );
                } );
                elems.items.eq( 0 ).css( {
                    'visibility': 'visible'
                } );
            }
            self.controls();
            if( elems.items.length > 1 ){

                elems.items.eq( 0 ).addClass( 'banner__item_active' );
                self.addTweens();
                self.events();
            }
        },
        /*
            /init
        */

        /*
            controls
            (initialize object controls)
        */
        controls:function(){
            var self = this,
                elems = self.elems;

            $( window).resize( function(){
                elems.items.each( function(){
                    $( this ).css( {
                        left: ( self.obj.width() - $( this ).width() ) / 2
                    } );
                } );
                if( elems.items.length > 1 ){

                    elems.items.eq( 0 ).addClass( 'banner__item_active' );
                    self.addTweens();
                }
            } );
            if( $( '.banner__item_video').length ){

                elems.closeBtn.on( 'click', function( event ){
                    event = event || window.event;

                    if (event.stopPropagation) {
                        event.stopPropagation()
                    } else {
                        event.cancelBubble = true
                    }
                    self.obj.css( { 'min-height': 0 } );
                    elems.items.animate( {opacity: 0}, 300 );
                    self.obj.animate( {height: 0}, 500, function(){
                        $('html').css({'overflow-y': 'scroll'});
                        $( this ).remove();
                    } );
                } );

                elems.items.on( 'click', function(){
                    var scrollElem = ( window.scrollY == undefined ) ? document.documentElement.scrollTop : window.scrollY;

                    if( scrollElem!=0 ){
                        $('html,body').animate( {
                            scrollTop: 0
                        }, {
                            duration: 300,
                            easing: 'easeInOutCubic',
                            complete: function(){
                                elems.items.animate( { height: $( window).height()-120 }, 300, function(){
                                    elems.items.find( 'iframe').css('display', 'block' );
                                } );
                                $('html').css({'overflow-y': 'hidden'});
                            }
                        });
                    } else {
                        $( this ).animate( { height: $( window).height()-120 }, 300, function(){
                            elems.items.find( 'iframe').css('display', 'block' );

                            self.player.api('play');
                        } );
                        $('html').css({'overflow-y': 'hidden'});
                    }
                } );
            }
        },
        /*
            /controls
        */

        /*
            events
            (add events)
        */
        events: function(){
            var self = this,
                elems = self.elems;

            self.timer = setTimeout( function(){
                cengeBanner();
            },5000 );
            function cengeBanner(){
                var active = $( '.banner__item_active' );

                elems.items[ active.index() ].tweenOut.play(0);
                self.timer = setTimeout( function(){
                    elems.items.eq( active.index() - 1 )[ 0 ].tweenIn.play(0);
                    active.removeClass( 'banner__item_active' );
                    elems.items.eq( active.index() - 1 ).addClass( 'banner__item_active' );
                },300 );

                setTimeout( function(){
                    cengeBanner();
                },5000 );
            }
        },
        /*
            /events
        */

        /*
            addTweens
        */
        addTweens: function(){
            var self = this,
                elems = self.elems;

            elems.items.each( function(){
                this.tweenIn = TweenMax.fromTo( $( this ), 0.3,{
                    css: {
                        left: $( this ).position().left + 100,
                        autoAlpha: 0
                    }
                }, {
                    css: {
                        left: $( this ).position().left,
                        autoAlpha: 1
                    },
                    paused: true
                } );
                this.tweenOut = TweenMax.fromTo( $( this ), 0.3,{
                    css: {
                        left: $( this ).position().left,
                        autoAlpha: 1
                    }
                }, {
                    css: {
                        left: $( this ).position().left - 100,
                        autoAlpha: 0
                    },
                    paused: true
                } );
            } );
        }
        /*
            /addTweens
        */

    };
/*
    Baners
 */

/*
    Authors gallery

    methods:
        init(initialize object),
        controls(initialize object controls),
        openPage (opening page, params: index - index of page),
        startView(set normal view, params: firstIndex - index of element),
        addTweens(add tweens for gallery).


*/
Wonderlex.Authors = function( obj ) {
    this.obj = obj;
    this.elems = {
        items: this.obj.find( '.authors__gallery-item' ),
        buttons: this.obj.find( '.authors__gallery-btn' )
    };
    this.isMovie = false;
    this.activeIndex = 0;
    if( this.obj.length ){
        this.init();
    }
};
    Wonderlex.Authors.prototype = {
        /*
            init
            (initialize object)
        */
        init: function() {
            var self = this;

            if((/iPhone|iPod|iPad|Android|Windows Phone|SymbianOS|Nokia|BlackBerry|HTC|Samsung|LG|Sony/).test(navigator.userAgent)) {
                self.obj.addClass('authors_mobile');
            }

            self.addTweens();
            self.startView( self.activeIndex );
            self.controls();
        },
        /*
            /init
        */

        /*
            controls
            (initialize object controls)
        */
        controls: function(){
            var self = this,
                elems = self.elems;

            elems.items.hover( function(){
                this.tween.play();
                $(this).addClass( 'active' );
                elems.items.filter(':not(.active)').find('span').stop().animate({ opacity: 0.3 },300);

            }, function(){
                this.tween.reverse();
                var notactive = elems.items.filter(':not(.active)').find('span');

                notactive.stop().animate({ opacity: 1 },300);
                $(this).removeClass( 'active' );
            } );

            elems.buttons.on( 'click', function(){
                var active = $( '.authors__gallery-pager-item_active');
                if( $( this ).hasClass( 'authors__gallery-btn_next' ) ) {
                    var newIndex = active.index() + 1;

                    if( newIndex == $( '.authors__gallery-pager-item').length ) {
                        newIndex = 0;
                    }

                    self.openPage( newIndex );
                } else {
                    self.openPage( active.index() - 1 );
                }
            } );

            $( window ).resize( function(){
                self.startView( self.activeIndex );
            } );

            self.obj.on( 'click', '.authors__gallery-pager-item', function(){
                if( !$( this).hasClass( 'authors__gallery-pager-item_active' ) ) {
                    self.openPage( $( this).index() );
                }
            } );
        },
        /*
            /controls
        */

        /*
            openPage
            (opening page, params: index - index of page)
        */
        openPage: function( index ){
            var self = this,
                elems = self.elems,
                curElement = $( '.authors__gallery-pager-item_active' ),
                newElement = $( '.authors__gallery-pager-item' ).eq( index ),
                startItem = parseInt( curElement.attr( 'data-start' ) ),
                lastItem = parseInt( curElement.attr( 'data-last' ) ),
                startDely = 0,
                startDely2 = 300,
                i;

            function show( index, delay ){
                setTimeout( function(){
                    elems.items[ index ].tweenIn.play( 0 );
                }, delay );
            }

            function hide( index, delay ){
                setTimeout( function(){
                    elems.items[ index ].tweenOut.play( 0 );
                }, delay );
            }

            if( !self.isMovie ) {
                self.isMovie = true;

                curElement.removeClass( 'authors__gallery-pager-item_active' );
                newElement.addClass( 'authors__gallery-pager-item_active' );

                for( i = startItem; i < lastItem; i++ ){
                    hide( i, startDely );
                    startDely += 100;
                }

                self.activeIndex = parseInt( newElement.attr( 'data-start' ) );
                for( j = parseInt( newElement.attr( 'data-start' ) ); j < parseInt( newElement.attr( 'data-last' ) ); j++ ){
                    show( j, startDely2 );
                    startDely2 += 100;
                    if( j + 1 == newElement.attr( 'data-last' )  ){
                        setTimeout( function(){
                            self.isMovie = false;
                        }, startDely2 );
                    }
                }


            }
        },
        /*
            /openPage
         */

        /*
            startView
            (set normal view, params: firstIndex - index of element)
        */
        startView: function( firstIndex ){
            var self = this,
                elems = self.elems,
                countElems = Math.floor( self.obj.width() / 256),
                countPages = Math.ceil( elems.items.length / countElems),
                controlsString = '<ul class="authors__gallery-pager">',
                curCountElems, i, curentStart, curLast, startLeft, step, lastIndex;

            firstIndex = ( Math.floor( firstIndex / countElems ) * countElems );

            for( i = 0; i < countPages ; i++ ) {
                curentStart = countElems * i;
                curCountElems = countElems;

                if( ( elems.items.length - curCountElems ) < ( curentStart + 1 ) ) {
                    curCountElems = elems.items.length - curentStart;
                }

                startLeft = ( ( self.obj.width() / curCountElems ) - 180 ) / 2 + 100;

                step = ( ( startLeft - 100 ) * 2 ) + 180;

                curLast = ( curentStart + curCountElems );

                controlsString += '<li class="authors__gallery-pager-item" data-start="' + curentStart + '" data-last="' + curLast + '"></li>';

                for( j = curentStart; j < curLast; j++ ) {
                    elems.items.eq( j ).css( { left: startLeft } );
                    startLeft += step;
                }
            }

            controlsString += '</ul>';
            $( '.authors__gallery-pager' ).remove();

            var control = $( controlsString );

            control.find( 'li').eq( Math.floor( firstIndex / countElems ) ).addClass( 'authors__gallery-pager-item_active' );
            self.obj.find( '.authors__gallery-layout' ).after( control );
            control.css( { marginLeft: -control.width() / 2 } );

            lastIndex = countElems + firstIndex;
            elems.items.css( {
                visibility: 'hidden',
                '-moz-transform':'scale(1)',
                '-webkit-transform':'scale(1)',
                '-o-transform':'scale(1)',
                '-ms-transform':'scale(1)',
                'transform':'scale(1)',
                opacity: 1
            } );
            for( i = firstIndex; i < lastIndex; i++ ) {
                elems.items.eq( i ).css( { visibility: 'visible' } );
            }
        },
        /*
            /startView
        */

        /*
            addTweens
            (add tweens for gallery)
        */
        addTweens: function(){
            var self = this,
                elems = self.elems;

            elems.items.each( function(){
                this.tween = TweenMax.fromTo( $( this ).find( '.authors__gallery-pic' ), 0.2,{
                    css: {
                        scale: 0.9
                    }
                }, {
                    css: {
                        scale: 1
                    },
                    paused: true
                } );
                this.tweenIn = TweenMax.fromTo( $( this ), 0.3,{
                    css: {
                        scale: 0.5,
                        autoAlpha: 0
                    }
                }, {
                    css: {
                        scale: 1,
                        autoAlpha: 1
                    },
                    paused: true
                } );
                this.tweenOut = TweenMax.fromTo( $( this ), 0.3,{
                    css: {
                        scale: 1,
                        autoAlpha: 1
                    }
                }, {
                    css: {
                        scale: 0.5,
                        autoAlpha: 0
                    },
                    paused: true
                } );
            } );
        }
        /*
            /addTweens
        */
    };
/*
    /Authors gallery
*/
/*
    /Wonderlex
*/




function changeCheck(el) {

    var el = el,
        input = el.find("input").eq(0);

    if(el.attr("class").indexOf("niceCheckDisabled")==-1)
    {
        if(!input.attr("checked")) {
            el.addClass("niceChecked");
            input.attr("checked", true);
        } else {
            el.removeClass("niceChecked");
            input.attr("checked", false).focus();
        }
    }

    return true;
}

function changeVisualCheck(input)
{
    /*
     меняем вид чекбокса при смене значения
     */
    var wrapInput = input.parent();
    if(!input.attr("checked")) {
        wrapInput.removeClass("niceChecked");
    }
    else
    {
        wrapInput.addClass("niceChecked");
    }
}

function changeCheckStart(el)
    /*
     новый чекбокс выглядит так <span class="niceCheck"><input type="checkbox" name="[name check]" id="[id check]" [checked="checked"] /></span>
     новый чекбокс получает теже name, id и другие атрибуты что и были у обычного
     */
{

    try
    {
        var el = el,
            checkName = el.attr("name"),
            checkId = el.attr("id"),
            checkChecked = el.attr("checked"),
            checkDisabled = el.attr("disabled"),
            checkValue = el.attr("value");
        checkTab = el.attr("tabindex");
        if(checkChecked)
            el.after("<span class='niceCheck niceChecked'>"+
                "<input type='checkbox'"+
                "name='"+checkName+"'"+
                "id='"+checkId+"'"+
                "checked='"+checkChecked+"'"+
                "value='"+checkValue+"'"+
                "tabindex='"+checkTab+"' /></span>");
        else
            el.after("<span class='niceCheck'>"+
                "<input type='checkbox'"+
                "name='"+checkName+"'"+
                "id='"+checkId+"'"+
                "value='"+checkValue+"'"+
                "tabindex='"+checkTab+"' /></span>");

        /* если checkbox disabled - добавляем соотвсмтвующи класс для нужного вида и добавляем атрибут disabled для вложенного chekcbox */
        if(checkDisabled)
        {
            el.next().addClass("niceCheckDisabled");
            el.next().find("input").eq(0).attr("disabled","disabled");
        }

        /* цепляем обработчики стилизированным checkbox */
        el.next().on("mousedown", function(e) { changeCheck($(this)) });
        el.next().find("input").eq(0).on("change", function(e) { changeVisualCheck($(this)) });
        if(getInternetExplorerVersion() == 1)
        {
            el.next().find("input").eq(0).on("click", function(e) { changeVisualCheck($(this)) });
        }
        el.remove();
    }
    catch(e)
    {
        // если ошибка, ничего не делаем
    }
    /* get Internet Explorer version */
    function getInternetExplorerVersion () {
        var rv = -1; // Return value assumes failure.
        if (navigator.appName == 'Microsoft Internet Explorer') {
            var ua = navigator.userAgent;
            var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
            if (re.exec(ua) != null)
                rv = parseFloat(RegExp.$1);
        }
        return rv;
    }

    return true;
}


function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}

function keydown(e) {
    e = e || window.event;

    if (keys) {
        for (var i = keys.length; i--;) {
            if (e.keyCode === keys[i]) {
                preventDefault(e);
                return;
            }
        }
    }
}

function wheel(e) {
    preventDefault(e);
}