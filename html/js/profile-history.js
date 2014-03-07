/*
    last edit 05.03.2013
*/

var profileHistory;

function ProfileHistory() {

    "use strict";

    var Self = this;

    this.preloader = null;
    this.wrap = null;
    this.slider = null;

    this.animateNewItems = function(items) {
        if (!items.length) {
            return;
        }

        var animateItem = items.eq(0);
        animateItem.slideDown(200, function() {
            items.splice(0, 1);
            Self.animateNewItems(items);
        });
    };

    this.addItems = function(activeElement, items) {

        if (items.flag === 'all') {
            activeElement.addClass('ajax-loaded');
        }

        var list = items.list,
            html = [];

        for (var i = 0, length = list.length; i < length; i++) {
            html.push('<li class="profile-history__item profile-history_item-new" data-id="' + list[i].id + '">\n');

            html.push('<div class="profile-history__img-wrap">\n');
            html.push('<img src="' + list[i].img + '" width="50" height="50" alt="" />\n');
            html.push('</div>\n');

            html.push('<div class="profile-history__description">\n');
            html.push('<span class="profile-history__item-name">' + list[i].itemName + '</span>\n');
            html.push('<span class="profile-history__author-name">' + list[i].name + '</span>\n');
            html.push('</div>\n');

            html.push('<div class="profile-history__price-date">\n');
            html.push('<span class="profile-history__price">' + list[i].price + '</span>\n');
            html.push('<span class="profile-history__date">' + list[i].date + '</span>\n');
            html.push('</div>\n');

            html.push('<div class="profile-history__remove-button"></div>\n');

            html.push('</li>');
        }

        activeElement.append(html.join(''));

        var newItems = activeElement.find('.profile-history_item-new');

        Self.animateNewItems(newItems);
    };

    this.hidePreloader = function() {
        Self.preloader.hide();
    };

    this.showPreloader = function() {
        Self.preloader.show();
    };

    this.loadItems = function(activeElement) {

        var dataUrl = activeElement.attr('data-php'),
            dataToSend = 'flag=load&list=' + activeElement.attr('id') + '&count=' + activeElement.find('li').length +
                '&step=' + activeElement.attr('data-step');

        Self.showPreloader();

        $.ajax({
            url: dataUrl,
            data: dataToSend,
            type: 'post',
            dataType: 'json',
            success: function(serverResponse, status, xhr) {

                if (xhr.status === 200) {
                    Self.addItems(activeElement, serverResponse);
                    Self.hidePreloader();
                }
                else {
                    alert(status);
                }

            },
            error: function(xhr) {
                alert(xhr.statusText);
            }
        });

    };

    this.chageViewList = function(element, bool) {

        if ($(element).hasClass('profile-history__header-control_active')) {
            return;
        }

        var profileHistoryList = $('#profile-history_shopping'),
            profileReviewList = $('#profile-history_review'),
            profileHistoryHeaderButton = $('#profile-history__header-button'),
            hiddenElement,
            showingElement,
            marginActiveElement,
            max,
            height1,
            height2,
            parent = profileHistoryList.parent(),
            cssConfig,
            cssResetConfig;

        if (profileHistoryList.hasClass('profile-history__list-active')) {
            hiddenElement = profileHistoryList;
            showingElement = profileReviewList;
        }
        else {
            hiddenElement = profileReviewList;
            showingElement = profileHistoryList;
        }

        marginActiveElement = showingElement.css('margin-bottom');

        height1 = hiddenElement.height();
        height2 = showingElement.height();

        if (height1 > height2) {
            max = height1;
        }
        else {
            max = height2;
        }

        parent.css({
            'height': max + 'px'
        });

        cssConfig = {
            'position': 'absolute',
            'top' : '0',
            'left': '0',
            'width' : '100%'
        };

        cssResetConfig = {
            'position': '',
            'top': '',
            'left': '',
            'width' : ''
        };

        showingElement.css(cssConfig);
        hiddenElement.css(cssConfig);

        hiddenElement.fadeOut(400, function() {
            showingElement.fadeIn(300);

            hiddenElement.removeClass('profile-history__list-active');
            showingElement.addClass('profile-history__list-active');

            $('.profile-history__header-control_active').removeClass('profile-history__header-control_active');
            $(element).addClass('profile-history__header-control_active');

            hiddenElement.css(cssResetConfig);
            showingElement.css(cssResetConfig);

            parent.css('height', '');
        });

        if (!bool) {

            if ($(element).index() === 0) {
                Self.slider.slider( "value", 0 );
            }
            else {
                Self.slider.slider( "value", 1 );
            }

        }

    };

    this.animateRow = function(element) {
        $(element).parent().slideUp(300, function() {
            $(this).remove();
        });
    };

    this.showToolTip = function(element, text) {
        $(element).parent().append('<div class="tooltip profile-history_tooltip">' + text + '</div> ');

        setTimeout(function() {

            $('.profile-history_tooltip').fadeOut(300, function() {
                $(this).remove();
            });

        }, 1500);
    };

    this.removeItem = function(element) {

        var action = $(element).parent().parent().attr('data-php'),
            dataToSend = 'flag=remove&ItemId=' + element.parentNode.getAttribute('data-id');

        $.ajax({
            url: action,
            data: dataToSend,
            dataType: 'json',
            type: 'post',
            success: function(serverResponse, status, xhr) {

                if (xhr.status === 200) {
                    Self.animateRow(element);
                }
                else {
                    Self.showToolTip(element, 'невозможно удалить запись');
                }

            },
            error: function(xhr) {
                Self.showToolTip(element, 'невозможно удалить запись');
            }
        });

    };

    this.addElementsPreloader = function() {
        this.wrap = $('.profile-history__list-wrap');
        this.wrap.append('<div class="profile-history_preloader"></div>');
        this.preloader = $('.profile-history_preloader');
    };

    this.addEventList = function() {

        var profileHistoryShoppingButton = $('#profile-history_shopping-button'),
            profileHistoryReview = $('#profile-history_review-button');


        profileHistoryShoppingButton.on('click', function() {
            Self.chageViewList(this);
        });

        profileHistoryReview.on('click', function() {
            Self.chageViewList(this);
        });

        Self.wrap.on('click', '.profile-history__remove-button', function() {
            Self.removeItem(this);
        });

        $(window).scroll(function() {

            var activeList = $('.profile-history__list-active');

            if (activeList.hasClass('ajax-loaded')) {
                return;
            }

            var scrollElem = ( window.scrollY === undefined ) ? document.documentElement.scrollTop : window.scrollY;

            if ((scrollElem + activeList.height() / 2) > ( Self.preloader.offset().top )) {
                Self.loadItems(activeList);
            }

        });

    };

    this.initSlider = function() {
        this.slider = $('.profile-history__header-control-slider').slider( {
            min: 0,
            max: 1,
            value: 0,
            slide: function( event, ui ) {

                //popupLayout.find( '.switch__txt').removeClass( 'switch__txt_active' );
                //popupLayout.find( '.switch__txt').eq( ui.value ).addClass( 'switch__txt_active' );
                //popupLayout.find( '.switch__radio').eq( ui.value ).attr( 'checked', true );
            },
            change: function( event, ui ) {
                var elem;

                if (ui.value === 0) {
                    elem = $('#profile-history_shopping-button');
                }
                else {
                    elem = $('#profile-history_review-button');
                }

                Self.chageViewList(elem[0], true);
                //popupLayout.find( '.switch__txt').removeClass( 'switch__txt_active' );
                //popupLayout.find( '.switch__txt').eq( ui.value ).addClass( 'switch__txt_active' );
                //popupLayout.find( '.switch__radio').eq( ui.value ).attr( 'checked', true );
            }
        } );
    };

    this.init = function() {
        this.addElementsPreloader();
        this.initSlider();
        this.addEventList();
    };

    return this.init();
}

$(document).ready(function() {

    "use strict";

    profileHistory = new ProfileHistory();
});