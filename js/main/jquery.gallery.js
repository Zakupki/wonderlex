var mainGallery;

$( function(){
    "use strict";



    mainGallery = new MainGallery( $( '.gallery' ) );

} );
/*
 MainGallery

 methods:
     init(initialize object),
     controls(initialize object controls),
     reloadElems(reload items),
     addPics (requst for pictures),
     startView(set normal view, mode: mode of botton 'more'),
 */
var MainGallery = function( obj ) {

    "use strict";

    this.imgWidth = 430;
    this.imgObjWidth = 460;
    this.imgClass = 'gallery__pic';

    this.obj = obj;
    this.elems = {
        items: this.obj.find( '.gallery__item' ),
        layout: this.obj.find( '.gallery__layout' ),
        preloader: $( '<div class="gallery__preloader"></div>' ),
        moreBtn: this.obj.find( '#btn__gallery-more' ),
        dataWindow: this.obj.find( '.gallery__data' )
    };
    this.request = new XMLHttpRequest();

    this.init();
};
    MainGallery.prototype = {

        /*
         init
         (initialize object)
         */
        init: function(){

            "use strict";

            var self = this,
                elems = self.elems;

            if (self.obj.find('.gallery__pic_min').length) {

                self.imgWidth = 200;
                self.imgObjWidth = 230;
                self.imgClass = 'gallery__pic_min';

            }


            elems.moreBtn.before( elems.preloader );

            self.loadPics( this.obj.find('img') );
            self.controls();
        },
        /*
         /init
         */

        /*
         controls
         (initialize object controls)
         */
        controls: function() {
            var self = this,
                elems = self.elems;

            $( window )
                .off( 'resize' )
                .on( 'resize', function(){
                var arrResult = [];

                elems.items.each( function( i ){
                    var curElem = $( this ),
                        addClass = ( curElem.hasClass( 'gallery__item_new' ) ) ? 'gallery__item gallery__item_new': ( curElem.hasClass( 'gallery__item_best' ) ) ? 'gallery__item gallery__item_best' : 'gallery__item';

                    arrResult[ i ] = [];
                    arrResult[ i ][ 0 ] = curElem.attr( 'data-index' );
                    arrResult[ i ][ 1 ] = curElem.innerHeight();
                    arrResult[ i ][ 2 ] = '<li class="' + addClass + '" data-id="' + curElem.attr( 'data-id' ) + '" data-index="' + curElem.attr( 'data-index' ) + '">' + curElem.html() + '</li>';

                } );
                self.replacePics( arrResult );
            } );

            elems.moreBtn.on( 'click', function(){
                self.addPics();
            } );

            self.obj.on( 'mouseover', '.gallery__wrap-element', function(){
                var curElem = $( this );
                clearTimeout(this.timer);
                curElem[ 0 ].timer = setTimeout( function(){
                    curElem.find( '.gallery__data').stop().animate( { bottom: 0 }, 500 );
                    curElem.find( '.gallery__pic').stop().animate( { marginTop: -129 }, 500 );
                }, 300 );
            } );
            self.obj.on( 'mouseleave', '.gallery__wrap-element', function(){
                clearTimeout(this.timer);
                $( this ).find( '.gallery__data').stop().animate( { bottom: -129 }, 500 );
                $( this ).find( '.gallery__pic').stop().animate( { marginTop: 0 }, 500 );
            } );

            $(window)
                .off('scroll')
                .on('scroll',function() {

                if( $( '#btn__gallery-more').length ) {
                    if(elems.moreBtn.attr( 'data-mode' ) === "all" ){
                        var scrollElem = ( window.scrollY === undefined ) ? document.documentElement.scrollTop : window.scrollY;

                        if( (scrollElem + $( this).height() ) > ( elems.preloader.offset().top + 100 ) ){
                            self.addPics();
                        }
                    }
                }
            });
        },
        /*
         /controls
         */

        loadPics: function( obj, second, mode ){

            "use strict";

            var self = this,
                elems = self.elems,
                counter = 0,
                arrResult = [],
                countItems = obj.length,
                i,curElem,addClass;

            if ( second ) {

                elems.items.each( function( i ){
                    curElem = $( this );
                    addClass = ( curElem.hasClass( 'gallery__item_new' ) ) ? 'gallery__item gallery__item_new': ( curElem.hasClass( 'gallery__item_best' ) ) ? 'gallery__item gallery__item_best' : 'gallery__item';

                    arrResult[ i ] = [];
                    arrResult[ i ][ 0 ] = curElem.attr( 'data-index' );
                    arrResult[ i ][ 1 ] = curElem.innerHeight();
                    arrResult[ i ][ 2 ] = '<li class="' + addClass + '" data-id="' + curElem.attr( 'data-id' ) + '" data-index="' + curElem.attr( 'data-index' ) + '">' + curElem.html() + '</li>';

                } );
                counter = elems.items.length;
                for( i = 0; i < countItems; i++){
                    obj[ i ].find('img').load( function(){
                        curElem = $( this ).parents( '.gallery__item').eq( 0 );
                        addClass = ( curElem.hasClass( 'gallery__item_new' ) ) ? 'gallery__item gallery__item_new': ( curElem.hasClass( 'gallery__item_best' ) ) ? 'gallery__item gallery__item_best' : 'gallery__item';

                        arrResult[ counter ] = [];
                        arrResult[ counter ][ 0 ] = counter;
                        arrResult[ counter ][ 1 ] = this.height + 30;
                        arrResult[ counter ][ 2 ] = '<li class="' + addClass + '" data-id="' + curElem.attr( 'data-id' ) + '" data-index="' + counter + '">' + curElem.html() + '</li>';
                        counter++;

                        if( ( counter - elems.items.length ) == countItems ){

                            self.replacePics( arrResult, mode );
                        }
                    } );
                }

            } else {
                obj.each(function(){
                    curElem = $( this ).parents( '.gallery__item').eq( 0 );
                    addClass = ( curElem.hasClass( 'gallery__item_new' ) ) ? 'gallery__item gallery__item_new': ( curElem.hasClass( 'gallery__item_best' ) ) ? 'gallery__item gallery__item_best' : 'gallery__item';

                    arrResult[ counter ] = [];
                    arrResult[ counter ][ 0 ] = curElem.index();
                    arrResult[ counter ][ 1 ] = curElem.innerHeight();
                    arrResult[ counter ][ 2 ] = '<li class="' + addClass + '" data-id="' + curElem.attr( 'data-id' ) + '" data-index="' + curElem.index() + '">' + curElem.html() + '</li>';
                    counter++;

                    if( counter == countItems ){
                        self.replacePics( arrResult );
                    }
                } );
            }

        },

        /*
         reloadElems
         (reload items)
         */
        reloadElems: function(){
            var self = this;

            self.elems.items= self.obj.find( '.gallery__item' );
        },
        /*
         /reloadElems
         */

        /*
         addPics
         (requst for pictures)
         */
        addPics: function(){
            "use strict";
            var self = this,
                elems = self.elems,
                i, currentItem,
                siteId,
                subDataToSend = '';

            elems.moreBtn.fadeOut( 300 );
            self.request.abort();

            var filterYearStart = $('.filter__item_year .filter__slider-start'),
                filterYearFinish = $('.filter__item_year .filter__slider-finish'),
                filterPriceStart = $('.filter__item_price .filter__slider-start'),
                filterPriceFinish = $('.filter__item_price .filter__slider-finish'),
                url = window.location.search.replace('?', '&');

            if (filterYearStart.length) {
                subDataToSend = '&yearStart=' + filterYearStart.text() + '&yearFinish=' + filterYearFinish.text();
            }

            if (filterPriceStart.length) {
                subDataToSend += '&priceStart=' + filterPriceStart.text() + '&priceFinish=' + filterPriceFinish.text();
            }


            siteId = elems.moreBtn.attr( 'data-value');

            if (siteId) {
                siteId = '&siteid=' + JSON.parse(elems.moreBtn.attr( 'data-value').replace(/\'/g, '"')).siteid;
            }
            else {
                siteId = '';
            }

            self.request = $.ajax( {
                url: elems.moreBtn.attr( 'data-php' ),
                data: 'mode=' + elems.moreBtn.attr( 'data-mode' ) +
                    '&step=' + elems.moreBtn.attr( 'data-step' ) +
                    siteId +
                    '&count=' + elems.items.length + subDataToSend +
                    '&catalogType=' + elems.moreBtn.parents('.gallery').attr('data-type') + url,
                dataType: 'json',
                timeout: 20000,
                type: "GET",
                success: function(msg){
                    var count = msg.items.length,
                        arrItems = [];

                    for( i = 0; i < count; i++ ){
                        currentItem = msg.items[ i ];

                        if (!currentItem.image.price) {
                            currentItem.image.price = '';
                        }

						var tempString = '<li class="gallery__item" data-id="' + currentItem.image.id + '">\
                                                <div class="gallery__wrap-element">\
                                                    <a class="gallery__pic-lnk" href="' + currentItem.image.href + '"><img class="' + self.imgClass + '" src="' + currentItem.image.url + '" width="' + self.imgWidth + '" alt=""></a>';

                        var tempPrice = currentItem.image.price;

                        if (!tempPrice) {
                            tempPrice = '';
                            tempString +=
                                '<section class="gallery__data gallery__data_without-price">';
                        }
                        else {
                            tempString +=
                                '<section class="gallery__data">';
                        }

                        tempString +=
                                                        '<a href="' + currentItem.image.href + '" class="gallery__title">' + currentItem.image.pictureName + '</h1>\
                                                        <a class="gallery__lnk" href="' + currentItem.painter.href + '">' + currentItem.painter.name + '</a>\
                                                        <div class="gallery__price">' + tempPrice + '</div>';
														
						if (!currentItem.image.withoutAuction) {
							tempString += '<a href="' + currentItem.auction_href + '" class="gallery__auction"></a>';
						}
						
						if (!currentItem.image.withoutCart) {
							tempString += '<a href="' + currentItem.cart_href + '" class="gallery__cart"></a>';
						}
						
						tempString += '</section>\
                                                 </div>\
                                            </li>';
						
                        arrItems[ i ] = $(tempString);
						
                        $('.gallery__column').eq(0).append(arrItems[ i ]);
                    }
                    self.loadPics( arrItems, true, msg.mode );
                },
                error: function(XMLHttpRequest){
                    if(XMLHttpRequest.statusText !== "abort"){
                        alert("При попытке отправить сообщение произошла неизвестная ошибка. \n Попробуй еще раз через несколько минут.");
                    }
                }
            } );
        },
        /*
         /addPics
         */

        replacePics: function( arrElems, mode ){
            "use strict";
            var self = this,
                elems = self.elems,
                maxWidth = $( window ).width() < 1000?1000:$( window ).width(),
                columnCount = Math.floor( maxWidth / self.imgObjWidth),
                arrElemsLength = arrElems.length,
                columns = $( '.gallery__column'),
                arrResult = [],
                maxHeight = 0,
                i, tempLeft;

            arrElems.sort( function( a, b ) {
                return a[ 0 ] - b[ 0 ];
            } );

            for( i = 0; i < columnCount; i++ ) {
                arrResult[ i ] = [];
                arrResult[ i ][ 0 ] = '<ul class="gallery__column">';
                arrResult[ i ][ 1 ] = 0;
                arrResult[ i ][ 2 ] = i;
            }

            for( i = 0; i < arrElemsLength; i++ ) {
                arrResult.sort( function( a, b ) {
                    return a[ 1 ] - b[ 1 ];
                } );

                arrResult[ 0 ][ 0 ] += arrElems[ i ][ 2 ];
                arrResult[ 0 ][ 1 ] += arrElems[ i ][ 1 ];
            }

            arrResult.sort( function( a, b ) {
                return a[ 2 ] - b[ 2 ];
            } );

            columns.remove();

            tempLeft = ( maxWidth - ( self.imgObjWidth * columnCount ) ) / 2;
            for( i = 0; i < columnCount; i++ ) {
                var tempElem = $( arrResult[ i ][ 0 ] + '</ul>' );

                tempElem.css( { left: tempLeft} );
                elems.layout.append( tempElem );

                if( maxHeight < arrResult[ i ][ 1 ] ){
                    maxHeight = arrResult[ i ][ 1 ];
                }
                tempLeft += self.imgObjWidth;
            }
            self.reloadElems();

            elems.items.each( function(){
                $( this ).find('.gallery__wrap-element').height( $( this ).height() );
            } );

            elems.layout.stop().animate( {
                height: maxHeight - 25
            }, {
                duration: 1000,
                complete: function(){
                    if ( mode === 'all' ){
                        elems.moreBtn.attr( 'data-mode', mode );
                    } else if (mode === 'finish') {
                        elems.moreBtn.remove();
                        elems.preloader.remove();
                    } else {
                        elems.moreBtn.fadeIn( 300 );
                    }
                },
                easing: 'easeInOutCubic'
            } );
        }
    };
/*
 /MainGallery
 */
