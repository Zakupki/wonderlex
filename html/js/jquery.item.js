/*
    last edit 04.03.2013

    Structure

*/

var item;


function Item() {
    "use strict";

    var Self = this;

    this.controls = {};

    this.unsetActiveItem = function() {
        var itemView = $('#item-view'),
            activeItem = itemView.find('.item__view-preview-item_active');

        activeItem.removeClass('item__view-preview-item_active').find('.item__view-preview_select').fadeOut(300, function() {
            $(this).remove();
        });
    };

    this.nextPhoto = function() {

        var items = $('.item__view-preview-item'),
            index;

        for (var i = 0, length = items.length; i < length; i++){
            if (items.eq(i).hasClass('item__view-preview-item_active')) {
                index = i;
                break;
            }
        }

        if (index + 1 === items.length) {
            index = 0;
        }
        else {
            index += 1;
        }

        items.eq(index).click();
    };

    this.prevPhoto = function() {
        var items = $('.item__view-preview-item'),
            index;

        for (var i = 0, length = items.length; i < length; i++){
            if (items.eq(i).hasClass('item__view-preview-item_active')) {
                index = i;
                break;
            }
        }

        if (index - 1 < 0) {
            index = items.length - 1;
        }
        else {
            index -= 1;
        }

        items.eq(index).click();
    };

    this.showPreloader = function() {
        $('#item-view-photo').css('cursor', 'wait');
        $('.item__view-preview_select').css('cursor', 'wait');
    };

    this.hidePreloader = function() {
        $('#item-view-photo').css('cursor', '');
        $('.item__view-preview_select').css('cursor', '');
    };

    this.likeButtonClick = function() {
        var element = $(this),
            php = element.attr('data-php'),
            productId = element.attr('data-id');

        if (element.hasClass('disabled')) {
            return;
        }

        $.ajax({
            url: php,
            data: 'productId=' + productId,
            type: 'get',
            dataType: 'json',
            timeout: 20000,
            success: function(serverAnswer, status, xhr) {

                if (xhr.status === 200) {
                    element.html(serverAnswer.count);
                    element.addClass('disabled');
                }
                else {
                    if (serverAnswer.message !== 'Not content') {
                        alert(status);
                    }
                }

            },
            error: function(xhr) {
                alert(xhr.responseText);
            }
        });
    };

    this.changePhoto = function(item) {
        var img = new Image(),
            photoContainer = $('#item-view-photo');

        Self.showPreloader();

        img.src = $(item).find('img').attr('data-src');
        img.onload = function() {

            img.setAttribute('width', img.width);
            img.setAttribute('height', img.height);
            var width = photoContainer.width(),
                height = photoContainer.height();

            photoContainer.css({
                'width': width + 'px',
                'height': height + 'px'
            });

            var animateImg = photoContainer.find('img').addClass('item__view-photo_animate');

            photoContainer.append(img);

            Self.hidePreloader();

            $(animateImg).fadeOut(500, function() {
                $(this).remove();
            });
        };
    };

    this.setActiveItem = function() {
        var itemView = $('#item-view'),
            activeItem = itemView.find('.item__view-preview-item_active');

        activeItem.append('<div class="item__view-preview_select"></div>');
        activeItem.find('.item__view-preview_select').fadeIn(300);

    };

    this.addEventList = function() {
        var itemsView = $('.item__view-preview-item'),
            rightPhotoButton = $('.item__view-photo-right'),
            leftPhotoButton = $('.item__view-photo-left'),
            photoContainer = $('#item-view-photo'),
            likeButton = $(Self.controls.likeButton);

        itemsView.on('click', function() {
            Self.unsetActiveItem();
            $(this).addClass('item__view-preview-item_active');
            Self.setActiveItem();
            Self.changePhoto(this);
        });

        leftPhotoButton.on('click', Self.prevPhoto);
        rightPhotoButton.on('click', Self.nextPhoto);
        likeButton.on('click', Self.likeButtonClick);

        photoContainer.hover(
            function() {
                photoContainer.find('div').fadeIn(300);
            },
            function() {
                photoContainer.find('div').fadeOut(300);
            }
        )
    };

    this.getControls = function() {
        var ctrl = Self.controls;

        ctrl.likeButton = document.querySelector('.item__view-price_like');
    };

    this.init = function() {
        this.getControls();
        this.setActiveItem();
        this.addEventList();
    };

    return this.init();
}

$(document).ready(function() {
    "use strict";

    item = new Item();
});