$( function() {
    new Cart();
} );

var Cart = function() {
    this.elems = {
        cardGallery: $( '.cart-gallery' ),
        cardGalleryItem: $( '.cart-gallery__wrap-element' )
    };
    this.request = new XMLHttpRequest();

    this.init();
};
    Cart.prototype = {
        init: function(){
            var self = this,
                elems = self.elems;

            if( elems.cardGallery.length ) {
                self.startCartGalery();
            }
            self.controls();
        },
        controls: function(){
            var self = this,
                elems = self.elems;

            /* show picture info */
            elems.cardGalleryItem.on( 'mouseover', function(){
                var curElem = $( this );
                clearTimeout(this.timer);
                curElem[ 0 ].timer = setTimeout( function(){
                    curElem.find( '.cart-gallery__data').stop().animate( { bottom: 0 }, 500 );
                    curElem.find( '.cart-gallery__pic').stop().animate( { marginTop: -129 }, 500 );
                }, 300 );
            } );
            elems.cardGalleryItem.on( 'mouseleave', function(){
                clearTimeout(this.timer);
                $( this ).find( '.cart-gallery__data').stop().animate( { bottom: -129 }, 500 );
                $( this ).find( '.cart-gallery__pic').stop().animate( { marginTop: 0 }, 500 );
            } );

            elems.cardGallery.on( 'click', '.cart-gallery__del', function(){
                self.removeFromCart( $( this ) );
            } );

            $( window ).on( 'resize', function(){
                elems.cardGallery.css( { padding: '0 '+ ( elems.cardGallery.width() - ( Math.floor( elems.cardGallery.width() / 460 ) * 460 ) ) /2  + 'px' } );
            } );

        },

        startCartGalery: function() {
            var self = this,
                elems = self.elems,
                arrPos = [],
                layOut = $( '.cart-gallery__layout' );



            elems.cardGallery.css( {
                padding: '0 '+ ( elems.cardGallery.width() - ( Math.floor( elems.cardGallery.width() / 460 ) * 460 ) ) /2  + 'px',
                height:elems.cardGallery.height()
            } );

            elems.cardGalleryItem.each( function() {
                var curElem = $( this );

                curElem.css( {
                    height: curElem.find( 'img' ).height()
                } );
            } );
            layOut.each( function( i ) {
                var curElem = $( this );

                arrPos[ i ] = curElem.position();
            } );
            layOut.each( function( i ) {
                var curElem = $( this );

                curElem.css( {
                    position: 'absolute',
                    top: arrPos[ i ].top,
                    left: arrPos[ i ].left
                } );
            } );
        },

        removeFromCart: function( obj ){
            var self = this,
                elems = self.elems,
                layout = $( '.cart-gallery__layout' ),
                parent = obj.parents( '.cart-gallery__layout' ).eq( 0 ),
                curIndex = parent.index(),
                i;

            self.request.abort();
            self.request = $.ajax( {
                url:  elems.cardGallery.attr( 'data-php' ),
                data: 'lang=' + $( '.language__lnk_active' ).text() + '&id=' + parent.attr( 'data-id' ),
                dataType: 'json',
                timeout: 20000,
                type: "GET",
                success: function( msg ){
                    $( '.cart__header-txt' ).html( msg.header );
                    $( '.account__cart-count' ).text( msg.itemsCount );

                    parent.addClass( 'cart-gallery__layout_closed' );

                    for( i = ( layout.length - 1 ); i >= 0; i-- ) {
                        if( i > curIndex ){
                            layout.eq( i ).animate( {
                                left: layout.eq( i - 1 ).position().left,
                                top: layout.eq( i - 1 ).position().top
                            }, 500 );
                        }
                    }
                    layout = $( '.cart-gallery__layout' );
                    setTimeout( function() {
                        parent.remove();
                    },500);


                },
                error: function( XMLHttpRequest ){
                    if( XMLHttpRequest.statusText != "abort" ){
                        alert("При попытке отправить сообщение произошла неизвестная ошибка. \n Попробуй еще раз через несколько минут.");
                    }
                }
            } );


        }
    };