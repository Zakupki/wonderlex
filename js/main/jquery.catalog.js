var catalogFilter;

$(function() {

    "use strict";

    catalogFilter = new Filter();
});

/*
 *  Filter
 *
 *    Methods
 *        init(initialize object),
 *        controls(initialize object controls),
 *        removeMenu (remove filter menu item),
 *        chengeView ( change filter menu structure ),
 *        chengeGallery ( rebuild gallery),
 *        openMenu ( open filter sub menu ),
 *        closeMenu ( close filter sub menu ),
 *        startView ( start filter view )
 *
 * */

var Filter = function() {
    this.obj = $( '.filter' );
    this.elems = {
        menuItem: $( '.filter__item_menu' ),
        filterItem: $( '.filter__item' ),
        filterSlider: $( '.filter__item_slider' )
    };
    this.request = new XMLHttpRequest();
    this.sliders = [];

    this.init();
};
Filter.prototype = {

    /* init(initialize object) */
    init: function(){
        var self = this;

        self.startView();
        self.controls();
    },
    /* /init */

    /* controls(initialize object controls) */
    controls: function(){
        var self = this,
            elems = self.elems;

        self.obj.on( 'click',  '.filter__item_menu', function(){
            var curElem = $( this );
            if( curElem.hasClass( 'filter__item_active' ) ){
                self.closeMenu();
            } else {
                self.openMenu( curElem );
            }
        } );

        self.obj.on('click', '.filter__menu-lnk', function(){
            var curElem = $( this ),
                parent = curElem.parents('.filter__menu');

            if( !curElem.hasClass( 'filter__menu-lnk_active' ) ) {
                parent.find( '.filter__menu-lnk_active').removeClass( 'filter__menu-lnk_active' );
                curElem.addClass( 'filter__menu-lnk_active' );
                parent.attr( 'data-id', curElem.attr( 'data-id' ) );

                if( !$('.filter__item_clear').length ){
                    $('.filter__item_year').after('<div class="filter__item filter__item_clear" style="display: none;">сбросить фильтры</div>');
                }

                if( !parent.hasClass('filter__menu_genre') ) {
                    if( parent.hasClass( 'filter__menu_view' ) && $( '.filter__item_genre').length ) {
                        $( '.filter__menu_genre').remove();
                        $( '.filter__item_genre').addClass('dis');
                        $( '.filter__menu_style').removeAttr( 'data-id' );
                        self.removeMenu();
                    } else {
                        self.chengeView();
                    }
                } else {
                    self.chengeGallery();
                }
            }
            return false;
        } );

        self.obj.on('click', '.filter__item_clear', function(){
            var curElem = $( this);

            $( '.filter__menu_style, .filter__menu_genre').remove();
            $( '.filter__item_style, .filter__item_genre').addClass('dis');
            curElem.addClass('dis').addClass('dis');
            $( '.filter__menu_view').removeAttr( 'data-id' );

            $( ".filter__item_slider").each( function(i){
                var curensy = $(this).attr( 'data-currency');

                if(curensy == undefined) curensy = '';
                self.sliders[i].slider( { values: [ parseInt($(this).attr( 'data-start' )) , parseInt($(this).attr( 'data-finish' )) ]});
                $(this).find( ".filter__slider-start").text( curensy  + $(this).attr( 'data-start' ) );
                $(this).find( ".filter__slider-finish").text( curensy + $(this).attr( 'data-finish' ) );
            } );

            self.removeMenu();
        } );

        elems.filterSlider.on( 'click', function( event ) {
            event = event || window.event

            if (event.stopPropagation) {
                event.stopPropagation()
            } else {
               event.cancelBubble = true
            }
            $('.filter__slider').stop().fadeOut( 300 );
            $( this ).find('.filter__slider').stop().fadeIn( 300 );
        } );

        $("body").click(function(e) {
            if($(e.target).closest(".filter__slider").length==0 ) {
                $('.filter__slider').stop().fadeOut( 300 );
            }
        });

        self.obj.on('click', '.filter__slider-text', function() {
            $('.filter__slider').stop().fadeOut( 300 );
        } );

        $( 'body' ).on( 'resize.body', function() {
            self.startView();
        } );
    },
    /* /controls */

    /* removeMenu (remove filter menu item) */
    removeMenu: function(){
        var self =this,
            elems = self.elems,
            globalWidth = self.obj.width(),
            menuDelimiter = globalWidth * 0.05,
            menuWidth = 0,
            startLeft;

        elems.filterItem = $( '.filter__item:not(.dis)' );

        elems.filterItem.each( function(){
            var curElem = $( this );


            menuWidth += curElem.width();

        } );

        menuWidth += ( menuDelimiter ) * ( elems.filterItem.length - 1  );
        startLeft = ( ( globalWidth - menuWidth ) / 2 ) - elems.filterItem.eq( 0 ).width();

        elems.filterItem.each( function(){
            var curElem = $( this );

            curElem.animate( { left: startLeft }, 300 );
            startLeft += (menuDelimiter + curElem.width());
        } );

        $( '.filter__item.dis').animate({ opacity: 0 }, 300, function(){
            $( this).remove();
        } );

        self.chengeView();

    },
    /* /removeMenu */

    /* chengeView ( change filter menu structure ) */
    chengeView: function(){
        var self = this,
            elems = self.elems,
            viewId = $( '.filter__menu_view:not(.dis)' ).attr( 'data-id'),
            styleId = $( '.filter__menu_style:not(.dis)' ).attr( 'data-id' ),
            genreId = $( '.filter__menu_genre:not(.dis)' ).attr( 'data-id'),
            url = window.location.search.replace('?', '&');

        if ( viewId == undefined ) viewId = 'none';
        if ( styleId == undefined ) styleId = 'none';
        if ( genreId == undefined ) genreId = 'none';

        self.request.abort();
        self.request = $.ajax( {
            url:  $('.filter' ).attr( 'data-php' ),
            data: 'lang=' + $( '.language__lnk_active' ).text() +
                '&viewId=' + viewId +
                '&styleId=' + styleId +
                '&genreId=' + genreId +
                '&catalogType=' + $('.gallery').attr('data-type') + url,
            dataType: 'json',
            timeout: 20000,
            type: "GET",
            success: function( msg ){
                var globalWidth = self.obj.width(),
                    menuDelimiter = globalWidth * 0.05,
                    menuWidth = 0, startLeft,
                    itemsString = '',
                    i, menu;

                if( $( '.filter__item_' + msg.menu.type ).length == 0 ) {
                    var newItem = $( '<div class="filter__item filter__item_' +  msg.menu.type + ' filter__item_menu" style="display: none;">' + msg.menu.name + '</div>' );
                    $('.filter__item_price' ).before( newItem );

                    elems.filterItem = $( '.filter__item' );

                    elems.filterItem.each( function(){
                        var curElem = $( this );

                        menuWidth += curElem.width();
                    } );

                    menuWidth += ( menuDelimiter ) * ( elems.filterItem.length - 1 );
                    startLeft = ( ( globalWidth - menuWidth ) / 2 ) - elems.filterItem.eq( 0 ).width();

                    elems.filterItem.each( function(){
                        var curElem = $( this );

                        if($( this).css( 'display' ) == 'none'){
                            curElem.css( { left: startLeft } );
                            curElem.fadeIn(300);
                        }
                        curElem.animate( { left: startLeft }, 300 );
                        startLeft += (menuDelimiter + curElem.width());
                    } );
                    newItem.after( '<ul class="filter__menu filter__menu_' +  msg.menu.type + '"></ul>' );
                }
                for( i = 0; i < msg.menu.items.length; i++ ){
                    var cur = msg.menu.items[ i ];

                    itemsString += '<li class="filter__menu-item"><a class="filter__menu-lnk" href="#" data-id="' + cur.id + '">' + cur.name + '</a></li>'
                }

                menu = $( '.filter__menu_' + msg.menu.type );
                menu.find( '> *' ).remove();
                menu.html( itemsString );
                menu.css( { padding: '37px ' + ( globalWidth - (  Math.floor( globalWidth / 240 ) * 240 ) ) / 2 + 'px' } );

                self.chengeGallery();
            },
            error: function( XMLHttpRequest ){
                if( XMLHttpRequest.statusText != "abort" ){
                    alert("При попытке отправить сообщение произошла неизвестная ошибка. \n Попробуй еще раз через несколько минут.");
                }
            }
        } );
    },
    /* /chengeView */

    /* chengeGallery ( rebuild gallery) */
    chengeGallery: function(sortData) {
        var self = this,
            elems = self.elems,
            viewId = $( '.filter__menu_view' ).attr( 'data-id'),
            styleId = $( '.filter__menu_style' ).attr( 'data-id' ),
            genreId = $( '.filter__menu_genre' ).attr( 'data-id'),
            gallery = $( '.gallery'),
            url = window.location.search.replace('?', '&');

        if ( viewId == undefined ) viewId = 'none';
        if ( styleId == undefined ) styleId = 'none';
        if ( genreId == undefined ) genreId = 'none';


        if (!sortData) {
            var sortDirection = $('#authors-list-sort-parameters').find('li.active');
            if (!sortDirection.length) {
                sortData = '';
            }
            else {
                sortData = '&direction=';
                if (sortDirection.hasClass('authors-list__sort-parameters-item_date')) {
                    sortData += 'date';
                }
                else if (sortDirection.hasClass('authors-list__sort-parameters-item_rating')) {
                    sortData += 'rating';
                }
                else if (sortDirection.hasClass('authors-list__sort-parameters-item_popularity')) {
                    sortData += 'popularity';
                }
            }
        }

        self.request.abort();
        self.request = $.ajax( {
            url:  gallery.attr( 'data-php' ),
            data: 'lang=' + $( '.language__lnk_active' ).text() +
                  '&viewId=' + viewId +
                  '&styleId=' + styleId +
                  '&genreId=' + genreId +
                  '&priceStart=' + $( '.filter__item_price .filter__slider-start').text() +
                  '&priceFinish=' + $( '.filter__item_price .filter__slider-finish').text() +
                  '&yearStart=' + $( '.filter__item_year .filter__slider-start').text() +
                  '&yearFinish=' + $( '.filter__item_year .filter__slider-finish').text() + sortData +
                  '&catalogType=' + gallery.attr('data-type') + url,
            dataType: 'json',
            timeout: 20000,
            type: "GET",
            success: function( msg ){
                var i, menu,
                    count = msg.items.length,
                    arrItems = [],
                    height = $( '.gallery__layout' ).height(),
                    currentItem;

                $( '.gallery__preloader' ).remove();
                $( '.gallery__column').fadeOut( 300, function(){
                    $( '.gallery__column').each( function(i){
                        if( i != 0 ){
                            $(this).remove();
                        } else {
                            $(this)
                                .removeAttr( 'style' )
                                .find('> *').remove();
                        }
                    } );

                    for( i = 0; i < count; i++ ){
                        currentItem = msg.items[ i ];
                        arrItems[ i ] = $( '<li class="gallery__item" data-id="' + currentItem.image.id + '">\
                                                <div class="gallery__wrap-element">\
                                                    <a class="gallery__pic-lnk" href="' + currentItem.image.href + '"><img class="gallery__pic" src="' + currentItem.image.url + '" width="430" alt=""></a>\
                                                    <section class="gallery__data">\
                                                        <a href="' + currentItem.image.href + '" class="gallery__title">' + currentItem.image.pictureName + '</h1>\
                                                        <a class="gallery__lnk" href="' + currentItem.painter.href + '">' + currentItem.painter.name + '</a>\
                                                        <div class="gallery__price">' + currentItem.image.price + '</div>\
                                                        <a href="#" class="gallery__auction"></a>\
                                                        <a href="#" class="gallery__cart"></a>\
                                                    </section>\
                                                 </div>\
                                            </li>' );
                        $('.gallery__column').eq(0).append( arrItems[ i ] );
                    }
                    $( '.gallery__column').css({'display':'block', opacity: 1});
                    mainGallery = new MainGallery( $( '.gallery' ) );
                    $( '.gallery__column').css({'top': 100, opacity: 0});
                    $( '.gallery__column' ).each( function( i ){
                        showColumn( $( this) , i * 100 )
                    } );
                } );

                function showColumn( obj, i ) {
                    setTimeout( function(){
                        obj.animate( { top:0, opacity: 1 }, 300 );
                    }, i );
                }
            },
            error: function( XMLHttpRequest ){
                if( XMLHttpRequest.statusText != "abort" ){
                    alert("При попытке отправить сообщение произошла неизвестная ошибка. \n Попробуй еще раз через несколько минут.");
                }
            }
        } );
    },
    /* /chengeGallery */

    /* openMenu ( open filter sub menu ) */
    openMenu: function( obj ){
        var self = this;

        self.closeMenu();
        obj.addClass( 'filter__item_active' );
        obj.next().addClass( 'filter__menu_opened' );
        obj.next().stop().slideDown( 300 );
    },
    /* /openMenu */

    /* closeMenu ( close filter sub menu ) */
    closeMenu: function(){
        curElem = $('.filter__menu_opened');

        curElem.prev().removeClass( 'filter__item_active' );
        curElem.stop().slideUp( 300 );
    },
    /* closeMenu */

    /* startView ( start filter view ) */
    startView: function(){
        var self = this,
            elems = self.elems,
            menuWidth = 0,
            startLeft,
            globalWidth = self.obj.width(),
            menuDelimiter = globalWidth * 0.05;

        elems.menuItem.each( function(){
            var curElem = $( this ),
                curMenu = curElem.next();

            curMenu.css( { padding: '37px ' + ( globalWidth - (  Math.floor( globalWidth / 240 ) * 240 ) ) / 2 + 'px' } );
        } );

        elems.filterItem.each( function(){
            var curElem = $( this );

            menuWidth += curElem.width();
        } );

        menuWidth += ( menuDelimiter ) * ( elems.filterItem.length - 1 );
        startLeft = ( ( globalWidth - menuWidth ) / 2 ) - elems.filterItem.eq( 0 ).width();

        elems.filterItem.each( function(){
            var curElem = $( this );
            curElem.css( { left: startLeft } );
            startLeft += (menuDelimiter + curElem.width());
        } );

        if( !$( '.filter__slider' ).length ) {
            elems.filterSlider.each( function( i ){
                var curElem = $( this ),
                    currency = curElem.attr( 'data-currency'),
                    sliderContent;

                if( currency == undefined ) {
                    currency = '';
                }
                sliderContent = $( '<div class="filter__slider">\
                                        <div class="filter__slider-text">' + curElem.text() + '</div>\
                                        <div class="filter__slider-line"></div>\
                                        <span class="filter__slider-start">' + currency + curElem.attr( 'data-start' ) + '</span>\
                                        <span class="filter__slider-finish">' + currency + curElem.attr( 'data-finish' ) + '</span>\
                                    </div>');

                curElem.append( sliderContent );

                self.sliders[ i ] = sliderContent.find( ".filter__slider-line" ).slider({
                    range: true,
                    min: parseInt(curElem.attr( 'data-start' )),
                    max: parseInt(curElem.attr( 'data-finish' )),
                    values: [ parseInt(curElem.attr( 'data-start' )) , parseInt(curElem.attr( 'data-finish' )) ],
                    slide: function( event, ui ) {
                        sliderContent.find( ".filter__slider-start").text( currency + ui.values[ 0 ] );
                        sliderContent.find( ".filter__slider-finish").text( currency + ui.values[ 1 ] );
                    },
                    stop: function() {
                        self.chengeGallery();
                    }
                });
            } );
        }
    }
    /* startView */
};