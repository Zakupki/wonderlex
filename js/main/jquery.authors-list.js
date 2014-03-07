/*

    last modified 22.02.2013

    structure
        -

*/

var authorsList;

/*global TweenMax */

function AuthorsList() {

    "use strict";

    var Self = this,
        ie = $.browser.msie,
        ieV = $.browser.version,
        ltie9 = ie&&(ieV <= 9),
        ajaxRequest;


    //==================================================================================================================
    // show preloader
    //==================================================================================================================
    this.showPreloader = function () {
        $('#authors-list').append('<div class="authors-list__preloader"></div>');
    };

    //==================================================================================================================
    // hide preloader
    //==================================================================================================================
    this.hidePreloader = function () {
        $('#authors-list').find('.authors-list__preloader').remove();
    };

    //==================================================================================================================
    // ajax load authors list
    //==================================================================================================================
    this.loadAuthorsList = function (authorsList, data, flag) {

        //==============================================================================================================
        // for processing server response
        //==============================================================================================================
        var replaceSymbol = function(string, symbolSearch, symbolReplace) {
            for (var i = 0, length = string.length; i < length; i++) {
                if (string[i] === symbolSearch) {
                    string = string.replace(symbolSearch, symbolReplace);
                    i--;
                }
            }

            return string;
        };

        //==============================================================================================================
        // create items
        //==============================================================================================================
        var createItem = function (jsonResponse, skipElements) {

            var html = [],
                authorsListContent = $('#authors-list').find(' .authors-list__content');

            for (var i = 0, length = jsonResponse.length; i < length; i++) {

                html.push('<li class="authors-list__content-item authors-list__content-item_animate">');
                html.push('<a href="' + jsonResponse[i].href + '">');
                html.push('<div class="authors-list__content-item-href"><img src="' + jsonResponse[i].imgSrc + '" alt="" width="187" height="187" /></div>');
                html.push('<span class="authors-list__author-name">' + jsonResponse[i].name + '</span>');
                html.push('</a>');
                html.push('<p class="authors-list__author-description">' + jsonResponse[i].description + '</p>');
                html.push('</li>');

            }

            skipElements = authorsListContent.find('li').length;
            authorsListContent.append(html.join(''));

            return skipElements;
        };

        //==============================================================================================================
        // show items with animate
        //==============================================================================================================
        var showItems = function (skipElements) {

            var authorsListContent = $('#authors-list').find(' .authors-list__content'),
                itemsAnimate;

            if (flag) {
                itemsAnimate = authorsListContent.find('li');
                authorsListContent.show();
            }
            else {
                itemsAnimate = authorsListContent.find('li:gt(' + parseInt(skipElements - 1, 10) + ')');
            }

            setTimeout(function() {
                if (!ltie9) {
                    itemsAnimate.removeClass('authors-list__content-item_animate');
                }
                else {
                    var opa = function() {
                        $(this).removeClass('authors-list__content-item_animate');
                    };
                    for (var i = 0, length = itemsAnimate.length; i < length; i++) {
                        TweenMax.to(itemsAnimate[i], 0.3, {css: {scale: 1, opacity: 1}, onComplete: opa});
                    }
                }
            }, 0);

        };

        // prepare data to send
        var sendTo = authorsList.attr('data-php'),
            count = $('.authors-list__content-item').length,
            modifyedString = replaceSymbol(authorsList.attr('data-value'), '\'', '"'),
            jsonParameters = JSON.parse(modifyedString),
            dataToSend = 'viewId=' + jsonParameters.typeOfWork + '&directions=' + jsonParameters.directions +
                '&count=' + count + '&step=' + authorsList.attr('data-step') + '&styleId=' + jsonParameters.styleId +
                '&genreId=' + jsonParameters.genreId + window.location.search.replace('?', '&');

        // send data
        $.ajax({
            url: sendTo,
            type: 'get',
            data: dataToSend,
            dataType: 'json',
            beforeSend: function () {
                Self.showPreloader();
            },
            success: function (serverResponse, status, xhr) {

                var authorsList,
                    seeMoreButton;

                if (xhr.status === 200) {

                    showItems(createItem(serverResponse.arrays));
                    authorsList = $('#authors-list');
                    seeMoreButton = $('#authors-list-see-more');
                    if (serverResponse.button === 1) {
                        authorsList.addClass('authors-lis_no-button');
                        seeMoreButton.addClass('authors-list_see-more-hidden');
                    }
                    else {
                        authorsList.removeClass('authors-lis_no-button');
                        seeMoreButton.removeClass('authors-list_see-more-hidden');
                    }

                }
                else {

                    alert(status);

                }

                Self.hidePreloader();

            },
            error: function (xhr) {
                Self.hidePreloader();
                alert(xhr.statusText);
            }
        });

    };

    this.updateAuthors = function() {

        var element = $('.authors-list__sort-parameters-item.active'),
            dataToSend = '&direction=',
            authorsParam,
            authorsListForm = $('#authors-list');

        if (element.length) {

            if (element.hasClass('authors-list__sort-parameters-item_date')) {
                dataToSend += 'date';
                authorsParam = 'date';
            }
            else if (element.hasClass('authors-list__sort-parameters-item_rating')) {
                dataToSend += 'rating';
                authorsParam = 'rating';
            }
            else if (element.hasClass('authors-list__sort-parameters-item_popularity')) {
                dataToSend += 'popularity';
                authorsParam = 'popularity';
            }
        }

        var listParam = authorsListForm.attr('data-value').replace(/\'+/g, '"'),
            viewId = $('.authors-list__jobs-list-item-href_view.filter__menu-lnk_active'),
            styleId = $('.authors-list__jobs-list-item-href_style.filter__menu-lnk_active'),
            genreId = $('.authors-list__jobs-list-item-href_genre.filter__menu-lnk_active');

        listParam = JSON.parse(listParam);
        listParam.directions = authorsParam;

        if (viewId.length || styleId.length || genreId.length) {
            if (!$('.authors-list__filters-cancel').length) {
                $('.authors-list__label:last').after('<a href="#" class="authors-list__filters-cancel">Сбросить фильтры</a>');
                $('.authors-list__sort-popup').addClass('authors-list__sort-popup_filter');
            }
        }

        if (viewId.length) {
            listParam.typeOfWork = viewId.attr('data-id');
        }
        else {
            listParam.typeOfWork = 'none';
        }

        if (styleId.length) {
            listParam.styleId = styleId.attr('data-id');
        }
        else {
            listParam.styleId = 'none';
        }

        if (genreId.length) {
            listParam.genreId = genreId.attr('data-id');
        }
        else {
            listParam.genreId = 'none';
        }

        authorsListForm.attr('data-value',  JSON.stringify(listParam).replace(/\"+/g, "'"));

        authorsListForm.find('.authors-list__content').fadeOut(300, function() {
            $(this).find('li').remove();
            authorsList.loadAuthorsList(authorsListForm, dataToSend, true);
        });
    };

    this.changeFilter = function() {

        if (ajaxRequest) {
            ajaxRequest.abort();
        }

        var url = $('.authors-list__header').attr('data-php'),
            viewId = $('.authors-list__jobs-list-item-href_view.filter__menu-lnk_active'),
            styleId = $('.authors-list__jobs-list-item-href_style.filter__menu-lnk_active'),
            genreId = $('.authors-list__jobs-list-item-href_genre.filter__menu-lnk_active'),
            url_get = window.location.search.replace('?', '&');

        if (!viewId.length) {
            viewId = 'none';
        }
        else {
            viewId = viewId.attr('data-id');
        }

        if (!styleId.length) {
            styleId = 'none';
        }
        else {
            styleId = styleId.attr('data-id');
        }

        if (!genreId.length) {
            genreId = 'none';
        }
        else {
            genreId = genreId.attr('data-id');
        }

        var authorsList = $('#authors-list-jobs');

        ajaxRequest = $.ajax({
            url: url,
            data: 'lang=' + $( '.language__lnk_active' ).text() +
                '&viewId=' + viewId +
                '&styleId=' + styleId +
                '&genreId=' + genreId + url_get,
            dataType: 'json',
            timeout: 20000,
            type: "GET",
            success: function(msg) {
                var globalWidth = authorsList.width(),
                    menuDelimiter = globalWidth * 0.05,
                    menuWidth = 0, startLeft,
                    itemsString = '',
                    i, menu;

                if (!msg) {
                    return;
                }

                if (!$('.authors-list__label_' + msg.menu.type ).length) {

                    var newItem = $( '<div class="authors-list__label authors-list__label_' +  msg.menu.type + '" style="display: none;">' + msg.menu.name + '</div>');

                    $('.authors-list__label:last').after(newItem);
                    var elems = $('.authors-list__label');

                    elems.each(function() {
                        var curElem = $(this);
                        menuWidth += curElem.width();
                    });

                    menuWidth += (menuDelimiter) * (elems.length - 1);
                    startLeft = ((globalWidth - menuWidth) / 2) - elems.eq(0).width();

                    elems.each(function() {
                        var curElem = $(this);

                        if ($(this).css('display') === 'none') {

                            curElem.css({
                                left: startLeft
                            });

                            curElem.fadeIn(300);
                        }
                        curElem.animate({
                            left: startLeft
                        }, 300);

                        startLeft += (menuDelimiter + curElem.width());
                    } );
                    authorsList.append('<ul class="authors-list__jobs-list authors-list__jobs-list_' + msg.menu.type + '">');
                }

                for( i = 0; i < msg.menu.items.length; i++ ){
                    var cur = msg.menu.items[i];

                    itemsString += '<li class="authors-list__jobs-list-item"><a data-id="' + cur.id +
                        '" class="authors-list__jobs-list-item-href authors-list__jobs-list-item-href_' +
                        msg.menu.type +'" href="#">' + cur.name + '</a></li>';
                }

                menu = $('.authors-list__jobs-list_' + msg.menu.type);
                menu.find('> *').remove();
                menu.html(itemsString);
                menu.css({
                    padding: '37px ' + (globalWidth - (Math.floor(globalWidth / 240) * 240)) / 2 + 'px'
                });

            },
            error: function(xhr) {
                if (xhr.statusText !== "abort") {
                    alert("При попытке отправить сообщение произошла неизвестная ошибка. \n Попробуй еще раз через несколько минут.");
                }
            }
        });

    };

    this.removeMenu = function() {

        var elems;

        $('.authors-list__label_style').remove();
        $('.authors-list__label_genre').remove();
        $('.authors-list__sort-popup').removeClass('authors-list__sort-popup_filter');
        $('.authors-list__filters-cancel').remove();
        $('.filter__menu-lnk_active').removeClass('filter__menu-lnk_active');

        elems = $('.authors-list__label');
        elems.css('left', '');
        /*
        elems.each(function() {
            var curElem = $(this);
            menuWidth += curElem.width();
        });

        menuWidth += (menuDelimiter) * (elems.length - 1);
        startLeft = ((globalWidth - menuWidth) / 2) - elems.eq(0).width();

        elems.each(function() {
            var curElem = $(this);

            curElem.animate({
                left: startLeft
            }, 300);

            startLeft += (menuDelimiter + curElem.width());
        });
        $('.authors-list__filters-cancel').remove();
        */
    };

    //==================================================================================================================
    // add events listeners
    //==================================================================================================================
    this.addEventList = function () {

        var authorsList = $('#authors-list'),
            authorsListJobs = $('#authors-list-jobs'),
            authorsListSeeMore = $('#authors-list-see-more'),
            contentWrap = $('.content-wrap');

        contentWrap.on('click', '.authors-list__filters-cancel', function(event) {

            if (event.preventDefault) {
                event.preventDefault();
            }
            else {
                event.returnValue = false;
            }

            $('.authors-list__jobs-list_style').slideUp(300, function() {
                $(this).remove();
            });

            $('.authors-list__jobs-list_genre').slideUp(300, function() {
                $(this).remove();
            });

            Self.removeMenu();
            Self.updateAuthors();
        });

        contentWrap.on('click', '.authors-list__jobs-list-item-href', function(event) {

            if (event.preventDefault) {
                event.preventDefault();
            }
            else {
                event.returnValue = false;
            }

            var element = $(this),
                parents;

            if (element.hasClass('filter__menu-lnk_active')) {
                return;
            }

            parents = element.parents('.authors-list__jobs-list');
            parents.find('.filter__menu-lnk_active').removeClass('filter__menu-lnk_active');
            element.addClass('filter__menu-lnk_active');
            Self.changeFilter();
            Self.updateAuthors();
        });

        //==============================================================================================================
        // for open/close jobs
        //==============================================================================================================
        contentWrap.on('click', '.authors-list__label', function () {

            var element = $(this),
                list;

            if (element.hasClass('authors-list__label_view')) {
                list = '.authors-list__jobs-list_view';
            }
            else if (element.hasClass('authors-list__label_style')) {
                list = '.authors-list__jobs-list_style';
            }
            else if (element.hasClass('authors-list__label_genre')) {
                list = '.authors-list__jobs-list_genre';
            }

            if (authorsListJobs.hasClass('authors-list__jobs_opened')) {

                if (!authorsListJobs.find(list).is(':visible')) {
                    authorsListJobs.find('.authors-list__jobs-list:visible').slideUp(300);
                    authorsListJobs.find(list).slideDown(300, function () {
                        $('.authors-list__label_opened').removeClass('authors-list__label_opened');
                        element.addClass('authors-list__label_opened').css('display', '');
                        authorsListJobs.addClass('authors-list__jobs_opened').css('display', '');
                    });
                }
                else {
                    authorsListJobs.find(list).slideUp(300, function() {
                        //$('.authors-list__label_opened').removeClass('.authors-list__label_opened');
                        element.removeClass('authors-list__label_opened').css('display', '');
                        authorsListJobs.removeClass('authors-list__jobs_opened').css('display', '');
                    });
                }

            }
            else {

                if (!authorsListJobs.find(list).is(':visible')) {
                    authorsListJobs.find('.authors-list__jobs-list:visible').slideUp(300);
                    authorsListJobs.find(list).slideDown(300, function () {
                        $('.authors-list__label_opened').removeClass('authors-list__label_opened');
                        element.addClass('authors-list__label_opened').css('display', '');
                        authorsListJobs.addClass('authors-list__jobs_opened').css('display', '');
                    });
                }
                else {
                    authorsListJobs.find(list).slideUp(300, function() {
                        //$('.authors-list__label_opened').removeClass('.authors-list__label_opened');
                        element.removeClass('authors-list__label_opened').css('display', '');
                        authorsListJobs.removeClass('authors-list__jobs_opened').css('display', '');
                    });
                }
            }

        });


        //==============================================================================================================
        // click to see more authors
        //==============================================================================================================
        authorsListSeeMore.on('click', function () {
            Self.loadAuthorsList(authorsList);
        });

        //==============================================================================================================
        // scroll and load authrors
        //==============================================================================================================
        $(window).on('scroll', function () {

            if (authorsList.hasClass('authors-lis_no-button')) {
                var scrollElem = ( window.scrollY === undefined ) ? document.documentElement.scrollTop : window.scrollY;

                if( (scrollElem + $(this).height()) > (authorsListSeeMore.offset().top + 100 ) ){
                    Self.loadAuthorsList(authorsList);
                }
            }
        });

    };

    //==================================================================================================================
    // initialization authors
    //==================================================================================================================
    this.init = function () {
        this.addEventList();
    };

    return this.init();
}

$(document).ready(function () {

    "use strict";

    authorsList = new AuthorsList();
});
