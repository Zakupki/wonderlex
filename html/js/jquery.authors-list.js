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
        ltie9 = ie&&(ieV <= 9);


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
    this.loadAuthorsList = function (authorsList) {

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
                itemsAnimate = authorsListContent.find('li:gt(' + parseInt(skipElements - 1, 10) + ')');

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
            modifyedString = replaceSymbol(authorsList.attr('data-value'), '\'', '"'),
            jsonParameters = JSON.parse(modifyedString),
            dataToSend = 'typeOfWork=' + jsonParameters.typeOfWork + '&directions=' + jsonParameters.directions +
                '&count=' + jsonParameters.count;

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

    //==================================================================================================================
    // add events listeners
    //==================================================================================================================
    this.addEventList = function () {

        var authorsList = $('#authors-list'),
            authorsListJobs = $('#authors-list-jobs'),
            authorsListLabel = $('#authors-list-label'),
            authorsListJobsList = authorsListJobs.find('.authors-list__jobs-list'),
            authorsListSortLabel = $('#authors-list-sort-label'),
            authorsListSortParameters = $('#authors-list-sort-parameters'),
            authorsListSortWrap = $('.authors-list__sort-popup'),
            authorsListSeeMore = $('#authors-list-see-more');


        //==============================================================================================================
        // for open/close jobs
        //==============================================================================================================
        authorsListLabel.on('click', function () {

            if (authorsListJobs.hasClass('authors-list__jobs_opened')) {
                authorsListJobs.slideUp(300, function () {
                    authorsListLabel.removeClass('authors-list__label_opened').css('display', '');
                    authorsListJobs.removeClass('authors-list__jobs_opened').css('display', '');

                });
            }
            else {

                authorsListJobs.css({
                    'display': 'block',
                    'opacity': '0'
                });

                var getHeight = authorsListJobsList.height() + 74;

                authorsListJobs.css({
                    'display': '',
                    'opacity': ''
                });

                authorsListJobs.css('height', getHeight + 'px');

                authorsListJobs.slideDown(300, function () {
                    authorsListLabel.addClass('authors-list__label_opened').css('display', '');
                    authorsListJobs.addClass('authors-list__jobs_opened').css('display', '');
                });
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
