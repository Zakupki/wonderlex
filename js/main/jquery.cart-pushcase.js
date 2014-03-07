/*
    js for cart pushcase page

    structure
        public methods:
*/


/*global wonderlex*/

//======================================================================================================================
// path to php files
//======================================================================================================================
var phpGetNewPrice = 'php/php-get-new-price.php',
    phpGetCities = '/getcities/';

///======================================================================================================================
// global variables
//======================================================================================================================
var cartPushcase;


function ScrollBar(scrollButton, scrollContainer, scrollObject) {

    "use strict";

    var Self = this,
        boolMouseDown = false,
        heightScroll,
        topPosition,
        topScrollObject,
        scrollButtonDiv2,
        minTop,
        maxTop,
        listHeight,
        scrollListHeight,
        touchPos;

    //==================================================================================================================
    // mouse down
    //==================================================================================================================
    this.mouseDown = function() {
        Self.getScrollParameters();
        Self.enableSelection();
        boolMouseDown = true;
    };

    //==================================================================================================================
    // mouse up
    //==================================================================================================================
    this.mouseUp = function() {
        boolMouseDown = false;
        Self.disableSelection();

    };

    //==================================================================================================================
    // move scroll elements
    //==================================================================================================================
    this.mouseMove = function(event) {

        if (!boolMouseDown) {
            return;
        }

        if (event.pageX === null && event.clientX !== null ) {
            var doc = document.documentElement, body = document.body;
            event.pageX = event.clientX + (doc && doc.scrollLeft || body && body.scrollLeft || 0) - (doc && doc.clientLeft || body && body.clientLeft || 0);
            event.pageY = event.clientY + (doc && doc.scrollTop  || body && body.scrollTop  || 0) - (doc && doc.clientTop  || body && body.clientTop  || 0);
        }
        //var scrollPos = Self.getScrollXY();
        var posY = event.pageY - topScrollObject - scrollButtonDiv2;

        if (posY < minTop) {
            posY = minTop;
        }

        if (posY > maxTop) {
            posY = maxTop;
        }

        if (posY >= minTop && posY <= maxTop) {
            Self.moveButtonToPos(posY);
        }
    };

    this.mouseWheel = function(event) {
        event = event || window.event;

        // get delta value
        var delta = event.deltaY || event.detail || event.wheelDelta;

        if ($.browser.mozilla || $.browser.opera) {
            if (delta > 0) {
                delta = 50;
            }
            else {
                delta = -50;
            }
        }
        else {
            if (delta > 0) {
                delta = -50;
            }
            else {
                delta = 50;
            }
        }
        var topPosition = parseInt(scrollButton.css('top'), 10) + delta;

        if (topPosition < minTop) {
            topPosition = minTop;
        }

        if (topPosition > maxTop) {
            topPosition = maxTop;
        }

        Self.getScrollParameters();

        if (topPosition >= minTop && topPosition <= maxTop) {
            Self.moveButtonToPos(topPosition);
        }

        // stop event
        if (event.preventDefault) {
            event.preventDefault();
        } else {
            event.returnValue = false;
        }
    };

    //==================================================================================================================
    // move scroll elements
    //==================================================================================================================
    this.moveButtonToPos = function(pos) {
        scrollButton.css('top', pos + 'px');

        var percentage = (pos - minTop) / (maxTop - minTop);

        var listPos = scrollListHeight * percentage;

        scrollObject.css('top', -listPos + 'px');
    };

    //==================================================================================================================
    // get scroll parameters
    //==================================================================================================================
    this.getScrollParameters = function() {

        // get center scroll button
        scrollButtonDiv2 = scrollButton.height() / 2;

        // get max bottom scroll button position
        heightScroll = scrollContainer.height();

        // get obj position
        topPosition = scrollObject.parent().offset().top - scrollContainer.offset().top;

        topScrollObject = scrollContainer.offset().top;

        // get list height
        listHeight = scrollObject.height();

        minTop = topPosition;
        maxTop = heightScroll - 25;

        scrollListHeight = listHeight - heightScroll + 32;

    };

    //==================================================================================================================
    // enable document selections
    //==================================================================================================================
    this.enableSelection = function() {

        document.body.onselectstart = function() {
            return false;
        };

        document.body.onmousedown = function() {
            return false;
        };

        document.body.unselectable = "on";
        $(document.body).css({
            '-moz-user-select': 'none',
            '-khtml-user-select': 'none',
            '-webkit-user-select': 'none',
            '-o-user-select': 'none',
            'user-select': 'none'
        });

    };

    //==================================================================================================================
    // disable document selections
    //==================================================================================================================
    this.disableSelection = function() {

        document.body.onmousedown = null;
        document.body.onselectstart = null;
        document.body.unselectable = "off";
        $(document.body).css({
            '-moz-user-select': 'auto',
            '-khtml-user-select': 'auto',
            '-webkit-user-select': 'auto',
            '-o-user-select': 'auto',
            'user-select': 'auto'
        });
    };

    //==================================================================================================================
    // add event listener
    //==================================================================================================================
    this.addEventList = function() {

        scrollButton.on('mousedown', Self.mouseDown);

        scrollButton.on('mouseup', Self.mouseUp);

        scrollContainer.on('mouseup', Self.mouseUp);

        $(document.body).on('mousemove', Self.mouseMove);
        $(document.body).on('mouseup', Self.mouseUp);

        //==============================================================================================================
        // add mouse event to mouse wheel
        //==============================================================================================================
        if (scrollContainer[0].addEventListener) {

            if ('onwheel' in document) {
                scrollContainer[0].addEventListener ("wheel", Self.mouseWheel, false);
            } else if ('onmousewheel' in document) {
                scrollContainer[0].addEventListener ("mousewheel", Self.mouseWheel, false);
            } else {
                scrollContainer[0].addEventListener ("MozMousePixelScroll", Self.mouseWheel, false);
            }

            scrollContainer[0].addEventListener('touchstart', function(event) {
                touchPos = event.touches[0].pageY;

            });

            scrollContainer[0].addEventListener('touchmove', function(event) {

                var topPosition = parseInt(scrollButton.css('top'), 10);

                if (event.touches[0].pageY > touchPos) {
                    topPosition -= 5;
                }
                else {
                    topPosition += 5;
                }

                if (topPosition < minTop) {
                    topPosition = minTop;
                }

                if (topPosition > maxTop) {
                    topPosition = maxTop;
                }

                Self.getScrollParameters();

                if (topPosition >= minTop && topPosition <= maxTop) {
                    Self.moveButtonToPos(topPosition);
                }

                // stop event
                if (event.preventDefault) {
                    event.preventDefault();
                }
                else {
                    event.returnValue = false;
                }
            });
        }
        else {
            scrollContainer[0].attachEvent ("onmousewheel", Self.mouseWheel);
        }
    };

    //==================================================================================================================
    // init scroll bar object
    //==================================================================================================================
    this.init = function() {
        this.addEventList();
    };

    return this.init();
}

function CustomSelect(selectItems, styleSheet, eventHandler) {

    "use strict";

    var Self = this;

    //==================================================================================================================
    // default element style
    //==================================================================================================================
    this.defStyleSheet = {
        'block': 'jui-custom-select',
        'list': 'jui-custom-select__list',
        'item': 'jui-custom-select__item',
        'placeholder': 'jui-custom_placeholder',
        'listWrap': 'jui-custom-select__list-wrap',
        'scroll': 'jui-custom-select__scroll',
        'disabled': 'jui-custom-select__disabled'
    };

    //==================================================================================================================
    // create placeholder / current element
    //==================================================================================================================
    this.createPlaceholder = function(inputData) {
        var html = [];

        html.push('<span class="' + Self.defStyleSheet.placeholder + '">' + inputData + '</span>');

        return html.join('');
    };

    //==================================================================================================================
    // set user stylesheet
    //==================================================================================================================
    this.setStyleSheet = function(_styleSheet) {
        if (!_styleSheet) {
            return;
        }

        if (_styleSheet.block) {
            Self.defStyleSheet.block = _styleSheet.block;
        }

        if (_styleSheet.item) {
            Self.defStyleSheet.item = _styleSheet.item;
        }

        if (_styleSheet.item) {
            Self.defStyleSheet.list = _styleSheet.list;
        }
    };

    //==================================================================================================================
    // create list item
    //==================================================================================================================
    this.createItem = function(inputData) {
        var html = [];

        html.push('<li class="' + Self.defStyleSheet.item + '" data-value="' + inputData.val() + '">' + inputData.html() + '</li>');

        return html.join('');
    };

    //==================================================================================================================
    // create element
    //==================================================================================================================
    this.createElement = function(elements) {
        var html;

        for (var i = 0, length = elements.length; i < length; i++) {

            html = [];

            var elementItems = elements.eq(i).find('option');
            if (elementItems.length) {
                html.push('<div class="' + Self.defStyleSheet.block + '">');
            }
            else {
                html.push('<div class="' + Self.defStyleSheet.block + ' ' + Self.defStyleSheet.disabled + '">');
            }

            html.push('<div class="jui-custom-select__scroll"></div>');

            html.push(Self.createPlaceholder(elements.eq(i).attr('data-placeholder')));

            html.push('<div class="' + Self.defStyleSheet.listWrap + '">');
            html.push('<ul class="' + Self.defStyleSheet.list + '">');



            for (var j = 0, itemsLength = elementItems.length; j < itemsLength; j++) {
                html.push(Self.createItem(elementItems.eq(j)));
            }

            html.push('</ul>');
            html.push('</div>');

            html.push('</div>');

            elements.eq(i).after(html.join(''));

        }
    };

    //==================================================================================================================
    // set scroll parameters
    //==================================================================================================================
    this.setScrollParameters = function(element) {

        element.find('.' + Self.defStyleSheet.scroll).fadeIn(300);
        element.find('.' + Self .defStyleSheet.listWrap).css({
            'height': parseInt(element.css('max-height'), 10) + parseInt(element.css('padding-top'), 10) +
                parseInt(element.css('padding-bottom'), 10) + 'px'
        });

        element.find('.' + Self.defStyleSheet.list).css({
            'position': 'absolute'
        });
    };

    //==================================================================================================================
    // show list
    //==================================================================================================================
    this.show = function(element) {

        if (eventHandler.focusIn) {
            eventHandler.focusIn();
        }

        Self.hideOpened();

        var list = element.find('.' + Self.defStyleSheet.list);

        element.addClass('jui-custom-select_open');
        list.slideDown(300, function() {

            var childCount = list.find('li').length;

            // if list item count > 5, show scroll button
            if (childCount > 5) {
                Self.setScrollParameters(element);
            }
        });

    };

    //==================================================================================================================
    // hide list
    //==================================================================================================================
    this.hide = function(element) {

        var list = element.find('.' + Self.defStyleSheet.list);

        element.removeClass('jui-custom-select_open');
        list.slideUp(300, function() {
            var childCount = list.find('li').length;

            if (childCount > 5) {
                element.find('.' + Self.defStyleSheet.scroll).hide();
            }
        });

    };

    //==================================================================================================================
    // hide oll list
    //==================================================================================================================
    this.hideOpened = function() {

        var elements = $('.' + Self.defStyleSheet.block + '.jui-custom-select_open');

        for (var i = 0, length = elements.length; i < length; i++) {
            Self.hide(elements.eq(i));
        }

    };

    //==================================================================================================================
    // init scroll bar
    //==================================================================================================================
    this.initScrollBar = function() {

        var elements = $('.' + Self.defStyleSheet.block),
            scrollBar,
            scrollButton;

        for (var i = 0, length = elements.length; i < length; i++) {
            scrollButton = elements.eq(i);
            scrollBar = new ScrollBar(scrollButton.find('.' + Self.defStyleSheet.scroll), scrollButton, scrollButton.find('.' + Self.defStyleSheet.list));
        }

    };


    this.refresh = function(currentItem) {

        var select = selectItems.eq(currentItem),
            placeholder = selectItems.eq(currentItem).parent().find('.' + Self.defStyleSheet.placeholder),
            options = select.find('option'),
            list = selectItems.eq(currentItem).parent().find('.' + Self.defStyleSheet.list),
            scrollButton = selectItems.eq(currentItem).parent().find('.' + Self.defStyleSheet.scroll),
            html = [];

        placeholder.removeClass('jui-custom_selected').removeAttr('data-value').html(select.attr('data-placeholder'));

        list.css('top', '');
        scrollButton.css('top', '');

        list.find('li').remove();

        for (var i = 0, length = options.length; i < length; i++) {
            html.push(Self.createItem(options.eq(i)));
        }
        if (html.length) {
            selectItems.eq(currentItem).parent().find('.' + Self.defStyleSheet.block).removeClass(Self.defStyleSheet.disabled);
            list.append(html.join(''));
        }
        else {
            selectItems.eq(currentItem).addClass(Self.defStyleSheet.disabled);
        }

    };

    //==================================================================================================================
    // add event listener to this object
    //==================================================================================================================
    this.addEventList = function() {

        var customList = $('.' + Self.defStyleSheet.list),
            customPlaceholder = $('.' + Self.defStyleSheet.placeholder);

        //==============================================================================================================
        // ChangeItems
        //==============================================================================================================
        customList.on('click', '.' + Self.defStyleSheet.item, function() {
            var parent = $(this).parent().parent().parent(),
                selectedValue = $(this).attr('data-value');

            parent.find('.' + Self.defStyleSheet.placeholder).attr('data-value', selectedValue).addClass('jui-custom_selected').html($(this).html());
            Self.hide(parent);

            var select = parent.parent().find('select');

            if (eventHandler && eventHandler.onchange) {
                eventHandler.onchange(selectedValue, select);
            }
        });

        //==============================================================================================================
        // click by list
        //==============================================================================================================
        customPlaceholder.on('click', function() {

            var parent = $(this).parent();

            if (parent.hasClass(Self.defStyleSheet.disabled)) {

                $('.cart-pushcase__select_country').parent().addClass('cart-pushcase__invalid-field').append('<div class="tooltip cart-pushcase_form-invalid">Не выбрана страна</div>');
                setTimeout(function() {

                    $('.cart-pushcase_form-invalid').fadeOut(300, function() {
                        $(this).remove();
                    });

                }, 2000);
                return false;
            }

            if (parent.hasClass('jui-custom-select_open')) {
                Self.hide(parent);
            }
            else {
                Self.show(parent);
            }

        });

        $(document).on('click', function(event) {

            if (!$(event.target).hasClass('.jui-custom-select') && !$(event.target).parents('.jui-custom-select').length &&
                !$(event.target).hasClass('jui-custom-select__scroll') && !$(event.target).parents('.cart-pushcase__fieldset').length) {
                Self.hideOpened();
            }

        });


    };

    //==================================================================================================================
    // initialization list
    //==================================================================================================================
    this.init = function() {
        this.setStyleSheet(styleSheet);
        this.createElement(selectItems);
        this.addEventList();

        this.initScrollBar();
    };

    return this.init();
}

function CartPushcase() {

    "use strict";

    var Self = this,
        customSelects,
        ie = jQuery.browser.msie,
        ieV = jQuery.browser.version,
        //ltie8 = ie && (ieV <= 8),
        ltie9 = ie && (ieV <= 9);

    this.verification = function(form, noShow) {

        var selects = $(form).find('.jui-custom_placeholder'),
            inputField = $(form).find('.cart-pushcase__input'),
            textAreaFiled = $(form).find('.cart-pushcase__textarea'),
            boolValid = true;

        for (var i = 0, lengthSelects = selects.length; i < lengthSelects; i++) {

            var currentSelect = selects.eq(i);


            if (!currentSelect.hasClass('jui-custom_selected')) {
                if (!noShow) {
                    currentSelect.parent().parent().addClass('cart-pushcase__invalid-field').append('<div class="tooltip cart-pushcase_form-invalid">выберите значение</div>');
                }
                boolValid = false;
                break;
            }

        }

        for (var j = 0, lengthInputs= inputField.length; j < lengthInputs; j++) {

            var currentInput = inputField.eq(j);

            if (!currentInput.attr('required')) {
                continue;
            }

            if (currentInput.val().replace(' ', '') === '' || currentInput.val() === currentInput.attr('placeholder')) {
                if (!noShow) {
                    currentInput.parent().addClass('cart-pushcase__invalid-field').append('<div class="tooltip cart-pushcase_form-invalid">Обязатеьное поле</div>');
                }
                boolValid = false;
                break;
            }

            var validMail = true;

            if (currentInput.attr('type') === 'email') {
                validMail = /^[-._A-Z0-9]+@(?:[A-Z0-9][-A-Z0-9]+\.)+[A-Z]{2,6}$/i.test(currentInput.val());
            }

            if (!validMail) {
                boolValid = false;
                if (!noShow) {
                    if (!currentInput.parent().hasClass('cart-pushcase__invalid-field')) {
                        currentInput.parent().addClass('cart-pushcase__invalid-field').append('<div class="tooltip cart-pushcase_form-invalid">Некоректный e-mail</div>');
                    }

                }
                break;
            }

        }

        for (var k = 0, lengthTextArea = textAreaFiled.length; k < lengthTextArea; k++) {
            var curentText = textAreaFiled.eq(k);
            if (curentText.val().replace(' ', '') === '') {
                if (!noShow) {
                    curentText.addClass('cart-pushcase__invalid-field').parent().append('<div class="tooltip cart-pushcase_form-invalid">Обязатеьное поле</div>');
                }
                boolValid = false;
                break;
            }
        }

        setTimeout(function() {

            $('.cart-pushcase_form-invalid').fadeOut(300, function() {
                $(this).remove();
            });

        }, 2000);

        if (boolValid) {
            var passwordFiled,
                confirmPassword;

            for (j = 0, lengthInputs = inputField.length; j < lengthInputs; j++) {
                var currentField = inputField.eq(j);

                if (currentField.attr('type') === 'password') {

                    if (currentField.attr('name') === 'password') {
                        passwordFiled = currentField;
                    }

                    if (currentField.attr('name') === 'confirm-password') {
                        confirmPassword = currentField;
                    }
                }
            }

            if (passwordFiled && confirmPassword) {

                if (passwordFiled.val() !== confirmPassword.val()) {
                    passwordFiled.parent().addClass('cart-pushcase__invalid-field').append('<div class="tooltip cart-pushcase_form-invalid">Пароли не совпадают</div>');
                    confirmPassword.parent().addClass('cart-pushcase__invalid-field').append('<div class="tooltip cart-pushcase_form-invalid">Пароли не совпадают</div>');
                    boolValid = false;
                }

            }
        }

        return boolValid;
    };

    this.refreshCityList = function(list) {

        var selects = $('.cart-pushcase__select-element');

        for (var i = 0, length = selects.length; i < length; i++) {
            if (selects.eq(i).hasClass('cart-pushcase__select_city')) {

                var currentSelect = selects.eq(i);
                currentSelect.find('option').remove();

                var options = [];
                for (var j = 0, lengthList = list.length; j < lengthList; j++) {
                    options.push('<option value="' + list[j].value + '">' + list[j].name + '</option>');
                }

                currentSelect.append(options);

                customSelects.refresh(i);
                break;
            }
        }

    };

    this.ajaxGetCity = function() {

        var dataToSend = 'country=' +  $('.cart-pushcase__select_country').val();

        $.ajax({
            url: phpGetCities,
            type: 'post',
            data: dataToSend,
            dataType: 'json',
            success: function(serverResponse, status, xhr) {
                if (xhr.status === 200) {

                    Self.refreshCityList(serverResponse.list);
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

    this.ajaxSubmit = function(form) {
        var popupWindow = new wonderlex.Popup(),
            popupLayout,
            popupClose;

        $.ajax({
            url: $(form).attr('action'),
            type: 'post',
            dataType: 'json',
            data: $(form).serialize(),
            beforeSend: function() {
                popupWindow.show({
                    request: null
                });
                popupLayout = $('.popup__layout');
                popupClose = $('.popup__close');
            },
            success: function(serverResponse, status, xhr) {

                var textElement;
                if (xhr.status === 200) {
                    popupLayout.css({
                        background: 'none'
                    }).append('<div class="good-text">' + xhr.statusText + '</div>');
                    textElement = popupLayout.find('.good-text');
                    popupClose.append('<a href="' + serverResponse.href + '" title="' + serverResponse.title +
                        '"></a>');
                }
                else {
                    popupLayout.css({
                        background: 'none'
                    }).append('<div class="bad-text">' + status + '</div>');
                    textElement = popupLayout.find('.bad-text');
                }

                textElement.css( {
                    top: ( popupLayout.height() - textElement.height()) / 2,
                    left: ( popupLayout.width() - textElement.width()) / 2
                } );

                popupLayout.css( { 'text-align': 'center' } );
                textElement.fadeIn(300);

            },
            error: function(xhr) {
                popupLayout.css({
                    background: 'none'
                }).append('<div class="bad-text">' + xhr.statusText + '</div>');
                var textElement = popupLayout.find('.bad-text');

                textElement.css( {
                    top: ( popupLayout.height() - textElement.height()) / 2,
                    left: ( popupLayout.width() - textElement.width()) / 2
                } );

                popupLayout.css( { 'text-align': 'center' } );
                textElement.fadeIn(300);
            }
        });
        return false;
    };

    this.submitData = function() {

        var element = $(this);

        if (!Self.verification(this)) {
            return false;
        }

        if (!element.hasClass('cart-pushcase__form')) {
            Self.ajaxSubmit(this);
            return false;
        }
    };

    this.profileSettingsSubmit = function(event) {

        if (!Self.verification(this)) {

            return false;
        }

        var currentForm = $(this),
            oldPassword = $('#old-password');

        if (oldPassword.attr('valid') === 'false') {
            event.preventDefault();
            oldPassword.parent().append('<div id="tool-tip-invalid" class="tooltip cart-pushcase_form-invalid">' + oldPassword.attr('data-value') + '</div>');
            setTimeout(function() {
                $('#tool-tip-invalid').remove();
            }, 2000);
            return false;
        }

        $('.profile-settings_tooltip').remove();
        Self.ajaxSubmit(currentForm[0]);
        /*
        $.ajax({
            url: currentForm.attr('action'),
            data: currentForm.serialize(),
            dataType: 'json',
            type: 'post',
            success: function(serverAnswer, status, xhr) {
                currentForm.append('<div class="tooltip profile-settings_tooltip">' + serverAnswer.message + '</div>');

                setTimeout(function() {
                    $('.profile-settings_tooltip').fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);

                Self.ajaxSubmit(currentForm[0]);

            },
            error: function(xhr) {
                currentForm.append('<div class="tooltip profile-settings_tooltip">' + xhr.statusText + '</div>');

                setTimeout(function() {
                    $('.profile-settings_tooltip').fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }
        });
        */

        return false;
    };

    this.setPhoneMask = function() {

        var phone = $('.cart-pushcase__input_phone'),
            year = $('.cart-pushcase__input_year'),
            month = $('.cart-pushcase__input_month'),
            day = $('.cart-pushcase__input_day');

        $(function() {

            if (phone.length) {
                phone.mask("+380 99 999 99 99", {completed:function(){
                    $(this).addClass('cart-pushcase__input_complete');
                }});
            }

            if (year.length) {
                year.mask("9999");
            }

            if (month.length) {
                month.mask("99");
            }

            if (day.length) {
                day.mask("99");
            }

        });

    };

    this.checkOldPassword = function(form, input) {
        var url = form.attr('action');

        $('#tool-tip-invalid').remove();

        $.ajax({
            url: url,
            data: 'flag=check-old-password&password=' + input.value,
            timeout: 5000,
            dataType: 'json',
            type: 'post',
            success: function(serverAnswer, status, xhr) {
                if (xhr.status !== 200) {
                    $(input).parent().append('<div id="tool-tip-invalid" class="tooltip cart-pushcase_form-invalid">' + xhr.message + '</div>');
                    input.setAttribute('valid', 'false');
                }
                else {
                    input.setAttribute('valid', 'true');
                }
            },
            error: function(xhr) {
                input.setAttribute('valid', 'false');
                $(input).parent().append('<div id="tool-tip-invalid" class="tooltip cart-pushcase_form-invalid">' + xhr.responseText + '</div>');
            },
            complete: function() {
                setTimeout(function() {

                    $('#tool-tip-invalid').fadeOut(300, function() {
                        $(this).remove();
                    });

                }, 2000);
            }
        });
    };

    this.addEventList = function() {

        var submitForm = $('.cart-pushcase__form'),
            inputField = $('.cart-pushcase__input'),
            textAreas = $('.cart-pushcase__textarea'),
            profileSettings = $('.profile-settings__form'),
            profileServices = $('.profile-services__form'),
            oldPassword = $('#old-password');

        submitForm.on('submit', Self.submitData);
        profileSettings.on('submit', Self.profileSettingsSubmit);
        profileServices.on('submit', Self.submitData);

        inputField.on('focusin', function() {
            Self.selectFocusIn();
        });

        inputField.on('focusout', function() {

            var element = $(this);

            if (element.hasClass('cart-pushcase__input_password') || element.hasClass('cart-pushcase__input_confirm-password')) {

                var passwordFiled = $('.cart-pushcase__input_password'),
                    confirmPass = $('.cart-pushcase__input_confirm-password'),
                    bool = false,
                    i,
                    length;

                for (i = 0, length = passwordFiled.length; i < length; i++) {
                    if (passwordFiled.eq(i).val() !== '') {
                        bool= true;
                        break;
                    }
                }

                if (!bool) {
                    for (i = 0, length = confirmPass.length; i < length; i++) {
                        if (confirmPass.eq(i).val() !== '') {
                            bool= true;
                            break;
                        }
                    }
                }

                if (bool) {
                    passwordFiled.attr('required', 'required');
                    confirmPass.attr('required', 'required');
                }
                else {
                    passwordFiled.removeAttr('required');
                    confirmPass.removeAttr('required');
                }

            }
        });

        textAreas.on('focusin', function() {
            Self.selectFocusIn();
        });

        oldPassword.on('focusout', function() {
            if (this.value !== '') {
                this.setAttribute('required', 'required');
                Self.checkOldPassword(profileSettings, this);
            }
            else {
                this.removeAttribute('required');
            }
        });

        textAreas.on('keydown', function(event) {
            /*
            if (event.keyCode !== 8 && event.keyCode !== 46 &&
                event.keyCode !== 37 && event.keyCode !== 38 && event.keyCode !== 39 && event.keyCode !== 40) {

                if (event.keyCode === 13) {
                    return false;
                }

                if ($(this).val().length >= $(this).attr('maxlength')) {
                    return false;
                }

            }
            */
        });

        if (textAreas.length) {

            $("textarea").autosize({
                callback: function() {
                    $('.cart-pushcase_textarea').css({
                        height: $(this).height() + 10 + 'px'
                    });
                }
            });

        }

        if (ltie9) {
            var phoneFiled = $('.cart-pushcase__input_phone');
            phoneFiled.on('focusin', function() {
                $(this).removeClass('cart-pushcase__input_complete');
                $(this).css('color', '#000');
            });

            phoneFiled.on('focusout', function() {
                $(this).css('color', '');
            });
        }

    };

    this.selectFocusIn = function() {
        $('.cart-pushcase__invalid-field').removeClass('cart-pushcase__invalid-field');
    };

    this.changeSum = function(value) {
        $('.cart-pushcase__button-submit-sum').html(' - ' + value + ' грн');
        $('.cart__header-price').html(value + ' грн');
    };

    this.ajaxGetNewPrice = function() {

        var form = $('.cart-pushcase__form');

        if (!Self.verification(form[0], true)) {
            return false;
        }

        var dataToSend = form.serialize();

        $.ajax({
            url: phpGetNewPrice,
            data: dataToSend,
            type: 'get',
            dataType: 'json',
            success: function(msg, status, xhr) {
                if (xhr.status === 200) {
                    Self.changeSum(msg.newSumm);
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

    this.changeListValue = function(newValue, obj) {

        obj.find('option').removeAttr('selected').filter(function() {
            return $(this).val() === newValue;
        }).attr('selected', 'true');

        if (/*obj.attr('name') === 'payment' || */obj.attr('name') === 'delivery') {
            Self.ajaxGetNewPrice();
        }

        if (obj.attr('name') === 'country') {
            Self.ajaxGetCity();
        }

    };

    this.initCustomSelect = function() {

        var param = {
            'focusIn': Self.selectFocusIn,
            'onchange': Self.changeListValue
        };

        customSelects = new CustomSelect($('.cart-pushcase__select-element'), null, param);
    };

    this.init = function() {
        this.initCustomSelect();
        this.addEventList();
        this.setPhoneMask();

        wonderlex.checkOS();
    };

    return this.init();
}

$(document).ready(function() {

    "use strict";
    cartPushcase = new CartPushcase();

});