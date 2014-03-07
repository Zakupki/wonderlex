/*

    last modified 22.02.2013

    structure
        -

*/

var authorsProfile;

/*global TweenMax */

function AuthorsProfile() {

    "use strict";

    var Self = this,
        ie = $.browser.msie,
        ieV = $.browser.version,
        ltie8 = ie&&(ieV <= 8);


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

    var parseDate = function (dateString) {

        var year = dateString.substr(6, 4),
            month = dateString.substr(3, 2),
            day = dateString.substr(0, 2);

        return year + '-' + month + '-' + day;
    };

    //==================================================================================================================
    // load comments
    //==================================================================================================================
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
                html.push('<li data-id="' + serverResponse[i].id + '" class="authors-profile-comments__item-description authors-profile-comments_new-item">');
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
            count = commentsList.find('.authors-profile-comments__item-description').length,
            dataToSend = 'count=' + count + '&last_comment_id=' +
                commentsList.find('.authors-profile-comments__item-description').last().attr('data-id');

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

    //==================================================================================================================
    // add new comment to page
    //==================================================================================================================
    this.addNewComment = function(currentForm, serverResponse) {

        var commentBlock = $('#authors-profile-comments'),
            positiveStat = commentBlock.find('.authors-profile-comments__types-item_positive .authors-profile-comments__types-item-count'),
            negativeStat = commentBlock.find('.authors-profile-comments__types-item_negative .authors-profile-comments__types-item-count'),
            neutralStat = commentBlock.find('.authors-profile-comments__types-item_neutral .authors-profile-comments__types-item-count'),
            commentList = commentBlock.find('.authors-profile-comments__list'),
            attitude = $(currentForm).find('#authors-profile-comments-attitude-type').val(),
            html = [];

        positiveStat.html(serverResponse.statistic.positive);
        negativeStat.html(serverResponse.statistic.negative);
        neutralStat.html(serverResponse.statistic.neutral);

        for (var i = 0, length = serverResponse.array.length; i < length; i++) {

            html.push('<li data-id="' + serverResponse.array[i].id + '" class="authors-profile-comments__item-description authors-profile-comments_new-item">');
            html.push('<a href="' + serverResponse.array[i].href + '" class="authors-profile-comments__author-photo ' + serverResponse.array[i].attitude + '">');
            html.push('<img src="' + serverResponse.array[i].imgPath + '" alt="" width="45" height="45"></a>');
            html.push('<div class="authors-profile-comments__item-text">');
            html.push('<p class="authors-profile-comments__item-paragraph">' + serverResponse.array[i].description + '</p>');
            html.push('<time class="authors-profile-comments__item-date" datetime="' + parseDate(serverResponse.array[i].date) + 'T' +
                       serverResponse.array[i].time + '">' + serverResponse.array[i].date + ',' + serverResponse.array[i].time + '</time>');
            html.push('</div>');
            html.push('</li>');
        }

        commentList.prepend(html.join(''));
        $('html, body').animate({
            'scrollTop': commentList.parent().offset().top
        }, 500, function() {

            var animateCommentsElement = function(animateElement) {
                if (animateElement.length) {
                    animateElement.last().slideDown(500, function() {
                        $(this).find('.authors-profile-comments__author-photo').fadeIn(300, function() {
                            $(this).removeClass('authors-profile-comments_new-item');
                            animateElement.splice(animateElement.length - 1, 1);
                            animateCommentsElement(animateElement);
                        });

                    });
                }
            };

            var animateElement = commentList.find('.authors-profile-comments_new-item');
            animateCommentsElement(animateElement);
            $(currentForm).find('.authors-profile-comments__textarea').val('');
        });
    };

    //==================================================================================================================
    // ajax send comment
    //==================================================================================================================
    this.sendComment = function(currentForm) {

        var errorMessage = $(currentForm).find('.authors-profile-comments__error-send'),
            description = $(currentForm).find('.authors-profile-comments__textarea');

        if (!ltie8) {
            if (description.val().trim() === '') {
                return;
            }
        }
        else {
            if (description.val().replace(' ', '') === '') {
                return;
            }
        }

        errorMessage.hide();

        var lastItem = $('.authors-profile-comments__item-description').last();

        if (lastItem.length) {
            lastItem = '&last_comment_id=' + lastItem.attr('data-id');
        }
        else {
            lastItem = '';
        }

        $.ajax({
            url: $(currentForm).attr('action'),
            data: $(currentForm).serialize() + lastItem,
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

    //==================================================================================================================
    // draw circle
    //==================================================================================================================
    this.showCircle = function(color) {

        var render = function() {

            var now = new Date().getTime(),
                progress = (now - startAnimate) / 1000,
                animatePos = (endingAngle - startingAngle) * progress + startingAngle;

            //ctx.globalCompositeOperation = 'source-over';
            ctx.clearRect(0, 0, width, height);
            ctx.beginPath();
            //x, y, radius, startAngle, endAngle, anticlockwise
            ctx.arc(55 / 2, 55 / 2, 45 / 2, 0, Math.PI * 2, true);
            ctx.closePath();
            ctx.fill();//рисуем закрашенную фигуру.
            /*теперь задаем наложение для картинки. При таком наложении,отображается только та часть новой фигуры, которая накладыва-
             ется на старую. Остальные части новой и старой фигур не выводятся;*/
            ctx.globalCompositeOperation = 'source-in';
            ctx.drawImage(imgObj[0], 5, 5);
            ctx.globalCompositeOperation = 'source-over';
            ctx.beginPath();
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

    //==================================================================================================================
    // set attitude
    //==================================================================================================================
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

        var authorsProfileMyWork = $('#authors-profile-my-work'),
            authorsProfileComments = $('#authors-profile-comments'),
            authorsProfileMyComments = $('#authors-profile-reviews'),
            authorsProfileGalelry = $('.gallery'),
            authorsBtnSeeMoreComments = $('#btn__comments-more'),
            authorsProfileCommentsForm = $('#authors-profile-comments-form'),
            authorsProfileCommentsAttitudeType = $('#authors-profile-comments-attitude-type'),
            authorsProfileCommentsLabel = $('.authors-profile-comments__write-label'),
            authorsProfileCommentsArea = authorsProfileCommentsForm.find('.authors-profile-comments__textarea'),
            authorsProfileCommentsErrorMessage = authorsProfileCommentsForm.find('.authors-profile-comments__error-send'),
            authorsProfileAuth = $('.authors-profile-comments__enter-auth'),
            authorsProfileReg = $('.authors-profile-comments__enter-reg');

        authorsProfileAuth.on('click', function() {
            $('.account__login').click();
        });

        authorsProfileReg.on('click', function() {
            $('.account__registration').click();
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

    authorsProfile = new AuthorsProfile();
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
