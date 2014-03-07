/*

    last modified 22.02.2013

    structure
        -

*/

var authors;

/*global TweenMax */

function Authors() {

    "use strict";

    var Self = this,
        ie = $.browser.msie,
        ieV = $.browser.version,
        ltie8 = ie&&(ieV <= 8),
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

    var parseDate = function (dateString) {

        var year = dateString.substr(6, 4),
            month = dateString.substr(3, 2),
            day = dateString.substr(0, 2);

        return year + '-' + month + '-' + day;
    };

    this.loadComments = function (commentsList) {

        var animateItem = function(items) {

            if (items.length > 0) {

                items.eq(0).slideDown(200, function () {

                    items.splice(0, 1);

                    animateItem(items);
                });
            }
            else {
                var elems = $('#authors-profile-comments').find('li.authors-profile-comments_new-item');
                elems.removeClass('authors-profile-comments_new-item');
                $('html, body').animate({
                    scrollTop: elems.eq(0).offset().top - 100
                });
            }
        };

        var showItems = function (skipElements) {
            var authorsListContent = $('#authors-profile-comments').find('.authors-profile-comments__list'),
                itemsAnimate = authorsListContent.find('li:gt(' + parseInt(skipElements - 1, 10) + ')');

            animateItem(itemsAnimate);
        };

        var createItem = function (serverResponse, skipElements) {

            var html = [],
                authorsListContent = $('#authors-profile-comments').find('.authors-profile-comments__list');

            for (var i = 0, length = serverResponse.length; i < length; i++) {
                html.push('<li class="authors-profile-comments__item-description authors-profile-comments_new-item">');
                html.push('<a href="' + serverResponse[i].href + '" class="authors-profile-comments__author-photo ' + serverResponse[i].attitude + '">');
                html.push('<img src="' + serverResponse[i].imgPath + '" alt="" width="45" height="45"></a>');
                html.push('<div class="authors-profile-comments__item-text">');
                html.push('<p class="authors-profile-comments__item-paragraph">' + serverResponse[i].description + '</p>');
                html.push('<time class="authors-profile-comments__item-date" datetime="' + parseDate(serverResponse[i].date) + 'T' + serverResponse[i].time + '">' + serverResponse[i].date + ', ' + serverResponse[i].time + '</time>');
                html.push('</div>');
                html.push('</li>');
            }

            skipElements = authorsListContent.find('li').length;
            authorsListContent.append(html.join(''));

            return skipElements;
        };

        var sendTo = commentsList.attr('data-php'),
            count = commentsList.attr('data-value'),
            dataToSend = 'count=' + count;

        $.ajax({
            url: sendTo,
            type: 'get',
            data: dataToSend,
            dataType: 'json',
            beforeSend: function () {
                Self.showPreloader();
            },
            success: function (serverResponse, status, xhr) {
                if (xhr.status === 200) {
                    showItems(createItem(serverResponse.arrays));

                    var authorsProfileComments = $('#authors-profile-comments');
                    authorsProfileComments.find('li.authors-profile-comments__item-opacity').removeClass('authors-profile-comments__item-opacity');

                    if (serverResponse.last === 0) {
                        $('#btn__comments-more').remove();
                    }
                    else {
                        authorsProfileComments.find('li.authors-profile-comments__item-description:last-child').addClass('authors-profile-comments__item-opacity');
                    }
                }
                else {
                    alert(status);
                }
            },
            error: function (xhr) {
                Self.hidePreloader();
                alert(xhr.statusText);
            }
        });
    };

    this.addNewComment = function(currentForm, serverResponse) {
        var commentList = $('#authors-profile-comments').find('.authors-profile-comments__list'),
            description = $(currentForm).find('.authors-profile-comments__textarea').val(),
            attitude = $(currentForm).find('#authors-profile-comments-attitude-type').val(),
            attitudeClass,
            html = [];

        switch (attitude) {

            case 'positive':
                attitudeClass = 'authors-profile-comments__author-photo_positive';
                break;

            case 'neutral':
                attitudeClass = 'authors-profile-comments__author-photo_neutral';
                break;

            case 'negative':
                attitudeClass = 'authors-profile-comments__author-photo_negative';
                break;
        }

        html.push('<li class="authors-profile-comments__item-description authors-profile-comments_new-item">');
        html.push('<a href="' + serverResponse.href + '" class="authors-profile-comments__author-photo ' + attitudeClass + '">');
        html.push('<img src="' + serverResponse.imgPath + '" alt="" width="45" height="45"></a>');
        html.push('<div class="authors-profile-comments__item-text">');
        html.push('<p class="authors-profile-comments__item-paragraph">' + description + '</p>');
        html.push('<time class="authors-profile-comments__item-date" datetime="' + parseDate(serverResponse.date) + 'T' + serverResponse.time + '">' + serverResponse.date + ',' + serverResponse.time + '</time>');
        html.push('</div>');
        html.push('</li>');


        commentList.prepend(html.join(''));
        $('html, body').animate({
            'scrollTop': commentList.parent().offset().top
        }, 500, function() {
            var animateElement = commentList.find('.authors-profile-comments_new-item');

            animateElement.slideDown(500, function() {
                $(this).find('.authors-profile-comments__author-photo').fadeIn(300, function() {
                    $(this).removeClass('authors-profile-comments_new-item');
                });
                $(currentForm).find('.authors-profile-comments__textarea').val('');
            });
        });
    };

    this.sendComment = function(currentForm) {

        var errorMessage = $(currentForm).find('.authors-profile-comments__error-send');
        errorMessage.hide();

        $.ajax({
            url: $(currentForm).attr('action'),
            data: $(currentForm).serialize(),
            dataType: 'json',
            type: 'post',
            success: function (serverResponse, status, xhr) {
                if (xhr.status === 200) {
                    Self.addNewComment(currentForm, serverResponse);
                }
                else {
                    errorMessage.fadeIn(300);
                }
            },
            error: function () {
                errorMessage.fadeIn(300);
            }
        });
    };

    this.showCircle = function(color) {

        var render = function() {

            var now = new Date().getTime(),
                progress = (now - startAnimate) / 1000,
                animatePos = (endingAngle - startingAngle) * progress + startingAngle;

            ctx.clearRect(0, 0, width, height);
            ctx.beginPath();
            ctx.drawImage(imgObj[0], 5, 5);
            ctx.arc(centerX, centerY, radius, startingAngle, animatePos, false);
            ctx.stroke();

            if (progress < 1) {
                timeOutAnimate = setAnimation(render);
            }
            else {
                clearAnimation(timeOutAnimate);
            }

        };

        var userPhoto = $('#authors-profile-comments-photo'),
            canvas = userPhoto.find('canvas'),
            imgObj = userPhoto.find('img'),

            width = userPhoto.width(),
            height = userPhoto.height(),
            centerX = width / 2,
            centerY = height / 2,
            radius = centerY - 2,
            startingAngle = Math.PI,
            endingAngle = 4 * Math.PI,
            timeOutAnimate,
            startAnimate;

        if (!canvas.length) {
            userPhoto.removeClass('authors-profile-comments_photo-write');
            canvas = document.createElement('canvas');
            canvas.setAttribute('class', 'authors-profile-photo-canvas');
            canvas.setAttribute('width',  width);
            canvas.setAttribute('height',  height);
            userPhoto.append(canvas);
            imgObj.hide();
        }
        else {
            canvas = canvas[0];
        }

        var ctx = canvas.getContext('2d');

        ctx.lineWidth = 3;
        ctx.strokeStyle = color;

        ctx.clearRect(0, 0, width, height);
        //ctx.beginPath();
        //ctx.stroke();

        startAnimate = new Date().getTime();
        render();
    };

    this.setAttitude = function(clickElement, setTo) {

        var authorsProfileCommentsPhoto = $('#authors-profile-comments-photo');

        if ($(clickElement).hasClass('authors-profile-comments__write-positive')) {
            setTo.val('positive');
            if (!ltie8) {
                Self.showCircle('#00d665');
            }
            else {
                authorsProfileCommentsPhoto.removeClass('authors-profile-comments__author-photo_neutral authors-profile-comments__author-photo_negative authors-profile-comments_photo-write')
                    .addClass('authors-profile-comments__author-photo_positive');
            }
        }
        else if ($(clickElement).hasClass('authors-profile-comments__write-neutral')) {
            setTo.val('neutral');
            if (!ltie8) {
                Self.showCircle('#c1c1c1');
            }
            else {
                authorsProfileCommentsPhoto.removeClass('authors-profile-comments__author-photo_positive authors-profile-comments__author-photo_negative authors-profile-comments_photo-write')
                    .addClass('authors-profile-comments__author-photo_neutral');
            }
        }
        else if ($(clickElement).hasClass('authors-profile-comments__write-negative')) {
            setTo.val('negative');
            if (!ltie8) {
                Self.showCircle('#ff4469');
            }
            else {
                authorsProfileCommentsPhoto.removeClass('authors-profile-comments__author-photo_neutral authors-profile-comments__author-photo_positive authors-profile-comments_photo-write')
                    .addClass('authors-profile-comments__author-photo_negative');
            }
        }

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
            authorsListSeeMore = $('#authors-list-see-more'),

            authorsProfileMyWork = $('#authors-profile-my-work'),
            authorsProfileComments = $('#authors-profile-comments'),
            authorsProfileMyComments = $('#authors-profile-reviews'),
            authorsProfileGalelry = $('.gallery'),
            authorsBtnSeeMoreComments = $('#btn__comments-more'),
            authorsProfileCommentsForm = $('#authors-profile-comments-form'),
            authorsProfileCommentsAttitudeType = $('#authors-profile-comments-attitude-type'),
            authorsProfileCommentsLabel = $('.authors-profile-comments__write-label'),
            authorsProfileCommentsArea = authorsProfileCommentsForm.find('.authors-profile-comments__textarea'),
            authorsProfileCommentsErrorMessage = authorsProfileCommentsForm.find('.authors-profile-comments__error-send');

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
        // for open/close sort
        //==============================================================================================================
        authorsListSortLabel.on('click', function () {

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

        //==============================================================================================================
        // click to see more authors
        //==============================================================================================================
        authorsListSeeMore.on('click', function () {
            Self.loadAuthorsList(authorsList);
        });

        //==============================================================================================================
        // move scroll to comments block
        //==============================================================================================================
        authorsProfileMyComments.on('click', function () {

            $('html, body').animate({
                scrollTop: authorsProfileComments.position().top - 150 + 'px'
            }, 500);
        });

        //==============================================================================================================
        // move scroll to block my work
        //==============================================================================================================
        authorsProfileMyWork.on('click', function () {

            $('html, body').animate({
                scrollTop: authorsProfileGalelry.position().top - 150 + 'px'
            }, 500);
        });

        //==============================================================================================================
        // load more comments
        //==============================================================================================================
        authorsBtnSeeMoreComments.on('click', function () {
            Self.loadComments(authorsProfileComments);
        });

        authorsProfileCommentsForm.on('submit', function() {
            Self.sendComment(this);
            return false;
        });

        authorsProfileCommentsLabel.on('click', function() {
            Self.setAttitude(this, authorsProfileCommentsAttitudeType);
        });

        authorsProfileCommentsArea.on('keydown', function() {
            authorsProfileCommentsErrorMessage.hide();
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

    authors = new Authors();
});

var setAnimation = (function() {

    "use strict";

    return  window.requestAnimationFrame||
    window.webkitRequestAnimationFrame||
    window.mozRequestAnimationFrame||
    window.oRequestAnimationFrame||
    window.msRequestAnimationFrame||
    function(callback) {
        return window.setTimeout(callback, 1000 / 60);
    };
})();

//canсelRequestAnimFrame
var clearAnimation = (function() {

    "use strict";

    return window.cancelRequestAnimationFrame|| window.webkitCancelRequestAnimationFrame||
           window.mozCancelRequestAnimationFrame|| window.oCancelRequestAnimationFrame||
           window.msCancelRequestAnimationFrame|| function(id){ clearTimeout(id); };
})();
