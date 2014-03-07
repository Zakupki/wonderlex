/* popup
----------------------------------------------- */
(function($){
    var o = {},
        el = {},
        xhr = null,
        $src = $(),
        $object = $(),
        $popup = $('<div class="popup"><div class="popup-window"><div class="popup-r"><div class="popup-l"><div class="popup-content"></div><div class="popup-buttons"><div class="popup-ok"><i class="i"></i></div><div class="popup-cancel"><i class="i"></i></div></div></div></div><div class="popup-rt"><div class="popup-lt"></div></div><div class="popup-rb"><div class="popup-lb"></div></div><div class="popup-close"><i class="i"></i></div></div><div class="popup-loading"><i class="i"></i></div><div class="popup-overlay"></div></div>'),
        $window = $('.popup-window', $popup),
        $content = $('.popup-content', $popup),
        $ok = $('.popup-ok', $popup),
        $cancel = $('.popup-cancel', $popup),
        $close = $('.popup-close', $popup),
        $loading = $('.popup-loading', $popup),
        $overlay = $('.popup-overlay', $popup),
        $browser = $(window),
        $document = $(document),
        documentProps = {
            clientWidth: function(){
                return document.documentElement.clientWidth;
            },
            clientHeight: function(){
                return document.documentElement.clientHeight;
            },
            scrollWidth: function(){
                return Math.max(document.documentElement.clientWidth, document.documentElement.scrollWidth);
            },
            scrollHeight: function(){
                return Math.max(document.documentElement.clientHeight, document.documentElement.scrollHeight);
            },
            scrollLeft: function(){
                return Math.max(document.body.scrollLeft, document.documentElement.scrollLeft);
            },
            scrollTop: function(){
                return Math.max(document.body.scrollTop, document.documentElement.scrollTop);
            }
        };
    function init() {
        if ($('.popup').length) {
            return;
        }
        $('body').append($popup);
        $ok.on('click', ok).noselect();
        $cancel.on('click', cancel).noselect();
        $close.on('click', close).noselect();
        $loading.on('click', close).noselect();
        $overlay.on('click', function(){
            if (o.closeOnOverlay) {
                close();
            }
        }).noselect();
    }
    function clear() {
        $popup.css({'left': '', 'position': '', 'width': '', 'height': ''});
        $popup.removeClass('text-popup alert-popup confirm-popup');
        if (o.extraClass) {
            $popup.removeClass(o.extraClass);
        }
        $window.stop(true).css({'left': '', 'margin': '', 'opacity': ''});
        $loading.hide();
        if ($src.length) {
            $src.html($object);
        } else {
            $object.detach();
        }
        if (xhr) {
            xhr.abort();
        }
        $browser.off('.popup');
        $document.off('.popup');
        o = {};
        el = {};
        xhr = null;
        $src = $();
        $object = $();
    }
    function start(param1, param2, mode) {
        clear();
        var params = {};
        if (param1 && param1.nodeType) {
            el = param1;
        } else if (param1) {
            $.extend(params, param1);
        }
        if (param2) {
            $.extend(params, param2);
        }
        if (el.nodeType && !params.href) {
            var rel = $(el).attr('rel'),
                href = $(el).attr('href');
            if (rel && rel.indexOf('popup:') == 0) {
                params.href = rel.substr(6);
            } else if (href) {
                params.href = href;
            }
        }
        if (params.text) {
            params.mode = 'text';
        }
        if (mode) {
            params.mode = mode;
        }
        o = $.extend({}, $.popup.defaults, params);
        handle();
    }
    function handle() {
        $popup.addClass(o.extraClass);
        switch(o.mode) {
            case 'text':
            $popup.addClass('text-popup');
            break;
            case 'alert':
            $popup.addClass('alert-popup');
            break;
            case 'confirm':
            $popup.addClass('confirm-popup');
            break;
        }
        if (o.text) {
            text();
        } else if (o.content) {
            content();
        } else if (o.src) {
            src();
        } else if (o.href) {
            href();
        } else {
            error();
        }
        function text() {
            showOverlay();
            $content.html(o.text);
            $object = $content.contents();
            showWindow();
        }
        function content() {
            showOverlay();
            $object = $(o.content);
            $content.html($object);
            showWindow();
        }
        function src() {
            showOverlay();
            $src = $(o.src);
            $object = $src.contents();
            $content.html($object);
            showWindow();
        }
        function href() {
            showOverlay();
            if (o.href.indexOf('#') == 0) {
                $src = $(o.href);
                $object = $src.contents();
                $content.html($object);
                showWindow();
            } else {
                showLoading();
                xhr = $.get(o.href, function(data){
                    $content.html(data);
                    $object = $content.contents();
                    hideLoading();
                    showWindow();
                });
            }
        }
    }
    function showOverlay() {
        if (o.beforeShowOverlay) {
            o.beforeShowOverlay(el);
        }
        if (o.showOverlay) {
            o.showOverlay(el, o.afterShowOverlay);
        } else {
            $.popup.showOverlay(o.afterShowOverlay);
        }
    }
    function hideOverlay() {
        if (o.beforeHideOverlay) {
            o.beforeHideOverlay(el);
        }
        if (o.hideOverlay) {
            o.hideOverlay(el, o.afterHideOverlay);
        } else {
            $.popup.afterHideOverlay(o.afterHideOverlay);
        }
    }
    function showLoading() {
        if (o.beforeShowLoading) {
            o.beforeShowLoading(el);
        }
        if (o.showLoading) {
            o.showLoading(el, o.afterShowLoading);
        } else {
            $.popup.showLoading(o.afterShowLoading);
        }
    }
    function hideLoading() {
        if (o.beforeHideLoading) {
            o.beforeHideLoading(el);
        }
        if (o.hideLoading) {
            o.hideLoading(el, o.afterHideLoading);
        } else {
            $.popup.hideLoading(o.afterHideLoading);
        }
    }
    function showWindow() {
        if (o.beforeShowWindow) {
            o.beforeShowWindow(el);
        }
        if (o.showWindow) {
            o.showWindow(el, o.afterShowWindow);
        } else {
            $.popup.showWindow(o.afterShowWindow);
        }
    }
    function hideWindow() {
        if (o.beforeHideWindow) {
            o.beforeHideWindow(el);
        }
        if (o.hideWindow) {
            o.hideWindow(el, o.afterHideWindow);
        } else {
            $.popup.hideWindow(o.afterHideWindow);
        }
    }
    function error() {
        close();
    }
    function ok() {
        if (o.beforeOk) {
            o.beforeOk(el);
        }
        if (o.ok) {
            o.ok(el, o.afterOk);
        } else {
            $.popup.ok(o.afterOk);
        }
    }
    function cancel() {
        if (o.beforeCancel) {
            o.beforeCancel(el);
        }
        if (o.cancel) {
            o.cancel(el, o.afterCancel);
        } else {
            $.popup.cancel(o.afterCancel);
        }
    }
    function close() {
        if (o.beforeClose) {
            o.beforeClose(el);
        }
        if (o.close) {
            o.close(el, o.afterClose);
        } else {
            $.popup.close(o.afterClose);
        }
    }
    function resizeViewport() {
        var documentClientWidth = documentProps.clientWidth(),
            documentClientHeight = documentProps.clientHeight(),
            documentScrollWidth = documentProps.scrollWidth(),
            documentScrollHeight = documentProps.scrollHeight(),
            windowWidth = $window[0].offsetWidth,
            windowHeight = $window[0].offsetHeight;
            width = '',
            height = '',
            popupStyle = $popup[0].style;
        if (windowWidth + o.marginX * 2 > documentScrollWidth) {
            width = windowWidth + o.marginX * 2 + 'px';
        } else if (documentScrollWidth > documentClientWidth) {
            width = documentScrollWidth + 'px';
        }
        if (windowHeight + o.marginY * 2 > documentScrollHeight) {
            height = windowHeight + o.marginY * 2 + 'px';
        } else if (documentScrollHeight > documentClientHeight) {
            height = documentScrollHeight + 'px';
        }
        popupStyle.width = width;
        popupStyle.height = height;
    }
    function alignWindow() {
        var documentClientWidth = documentProps.clientWidth(),
            documentClientHeight = documentProps.clientHeight(),
            documentScrollLeft = documentProps.scrollLeft(),
            documentScrollTop = documentProps.scrollTop(),
            viewportWidth = $popup[0].offsetWidth,
            viewportHeight = $popup[0].offsetHeight,
            windowWidth = $window[0].offsetWidth,
            windowHeight = $window[0].offsetHeight,
            left = 0,
            top = 0,
            marginLeft = 0,
            marginTop = 0,
            windowStyle = $window[0].style;
        if (windowWidth + o.marginX * 2 > documentClientWidth) {
            if (documentScrollLeft + windowWidth + o.marginX * 2 > viewportWidth) {
                left = viewportWidth - windowWidth - o.marginX;
            } else {
                left = documentScrollLeft + o.marginX;
            }
            marginLeft = 0;
        } else {
            left = documentScrollLeft + documentClientWidth / 2;
            marginLeft = -(windowWidth / 2);
        }
        if (windowHeight + o.marginY * 2 > documentClientHeight) {
            if (documentScrollTop + windowHeight + o.marginY * 2 > viewportHeight) {
                top = viewportHeight - windowHeight - o.marginY;
            } else {
                top = documentScrollTop + o.marginY;
            }
            marginTop = 0;
        } else {
            top = documentScrollTop + documentClientHeight / 2;
            marginTop = -(windowHeight / 2);
        }
        windowStyle.left = left + 'px';
        windowStyle.top = top + 'px';
        windowStyle.marginLeft = marginLeft + 'px';
        windowStyle.marginTop = marginTop + 'px';
    }
    $.fn.popup = function(params, mode){
        return this.click(function(e){
            e.preventDefault();
            $.popup(this, params, mode);
        });
    };
    $.popup = function(param1, param2, mode){
        start(param1, param2, mode);
    };
    $.fn.alert = function(params){
        return this.click(function(e){
            e.preventDefault();
            $.popup(this, params, 'alert');
        });
    };
    $.alert = function(param1, param2){
        start(param1, param2, 'alert');
    };
    $.fn.confirm = function(params){
        return this.click(function(e){
            e.preventDefault();
            $.popup(this, params, 'confirm');
        });
    };
    $.confirm = function(param1, param2){
        start(param1, param2, 'confirm');
    };
    $.popup.showOverlay = function(complete){
        if (!o.fixed) {
            $popup.css({'position': 'absolute'});
            resizeViewport();
            $browser.on('resize.popup', function(){
                resizeViewport();
            });
        }
        $popup.css({'left': 0});
        if (complete) {
            complete(el);
        }
        $document.on('keyup.popup', function(e){
            if (e.which == 13 &&  o.okOnEnter && (o.mode == 'alert' || o.mode == 'confirm')) {
                ok();
            } else if (e.which == 27 && o.cancelOnEsc && o.mode == 'confirm') {
                cancel();
            } else if (e.which == 27 && o.closeOnEsc) {
                close();
            }
        });
    };
    $.popup.hideOverlay = function(complete){
        $popup.css({'left': ''});
        if (complete) {
            complete(el);
        }
        clear();
    };
    $.popup.showLoading = function(complete){
        $loading.show();
        if (complete) {
            complete(el);
        }
    };
    $.popup.hideLoading = function(complete){
        $loading.hide();
        if (complete) {
            complete(el);
        }
    };
    $.popup.showWindow = function(complete) {
        if (!o.fixed) {
            resizeViewport();
        }
        if (o.fixed) {
            $window.css({'margin-left': -($window[0].offsetWidth / 2), 'margin-top': -($window[0].offsetHeight / 2), 'left': '50%', 'top': '50%'});
        } else {
            alignWindow();
            $browser.on('resize.popup', function(){
                alignWindow();
            });
        }
        $window.stop(true).fadeTo(o.speed, 1, function(){
            if (complete) {
                complete(el);
            }
        });
    }
    $.popup.hideWindow = function(complete){
        $window.stop(true).fadeTo(o.speed, 0, function(){
            $window.css({'margin': '', 'left': '', 'top': ''});
            if (complete) {
                complete(el);
            }
        });
    };
    $.popup.ok = function(complete){
        $.popup.hideLoading();
        $.popup.hideWindow(function(){
            $.popup.hideOverlay(complete);
        });
    };
    $.popup.cancel = function(complete){
        $.popup.hideLoading();
        $.popup.hideWindow(function(){
            $.popup.hideOverlay(complete);
        });
    };
    $.popup.close = function(complete){
        $.popup.hideLoading();
        $.popup.hideWindow(function(){
            $.popup.hideOverlay(complete);
        });
    };
    $.popup.get = function(){
        return o;
    };
    $.popup.set = function(params){
        if (params.extraClass) {
            $popup.addClass(params.extraClass);
            if (o.extraClass) {
                $popup.removeClass(o.extraClass);
            }
        }
        $.extend(o, params);
    };
    $.popup.defaults = {
        speed: 100,
        fixed: true,
        marginX: 40,
        marginY: 40,
        okOnEnter: true,
        cancelOnEsc: true,
        closeOnEsc: true,
        closeOnOverlay: true,
        extraClass: ''
    };
    $(function(){
        init();
    });
})(jQuery);



/* noselect
----------------------------------------------- */
(function($){
$.fn.noselect = function(){
    return this.on('selectstart', function(e){
        e.preventDefault();
    });
};
})(jQuery);



/* reset
----------------------------------------------- */
(function($){
$.fn.reset = function(complete){
    return this.each(function(){
        if (complete) {
            $(this).on('afterReset', complete);
        } else {
            this.reset();
            $(this).trigger('afterReset');
        }
    });
};
})(jQuery);



/* placeholder
----------------------------------------------- */
(function($){
$.fn.placeholder = function(className){
    var className = className || 'placeholder';
    return this.each(function(){
        var $label = $(this),
            $input = $('#' + $label.attr('for')),
            placeholder = $label.html();
        init();
        if (!$input.data('placeholder')) {
            $input.closest('form').reset(function(){
                init();
            });
        }
        $input.off('.placeholder').on('focusin.placeholder', function(){
            if ($input.val() == placeholder) {
                $input.val('').removeClass(className);
            }
        }).on('focusout.placeholder', function(){
            if ($input.val() == '') {
                $input.addClass(className).val(placeholder);
            }
        }).data('placeholder', placeholder);
        function init() {
            if ($input.val() == '' || $input.val() == placeholder) {
                $input.addClass(className).val(placeholder);
            } else {
                $input.removeClass(className);
            }
        }
    });
};
})(jQuery);



/* jflow
----------------------------------------------- */
(function($){
$.fn.jflow = function(o){
    o = $.extend({
        speed: 300,
        easing: 'easeOutExpo',
        auto: -1,
        cyclic: false,
        controlsFade: -1
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $items = $('.jflow-li', $root),
            $prev = $('.jflow-prev', $root),
            $next = $('.jflow-next', $root),
            $counter = $('.jflow-counter', $root),
            currentIndex = $items.index($items.filter('.jflow-li-current')),
            t,
            busy = false;
        if ($items.length < 2) {
            return;
        }
        init();
        function init() {
            controls(currentIndex);
            counter(currentIndex);
            slideShow();
            $root.hover(
                function(){
                    clearInterval(t);
                },
                function(){
                    slideShow();
                }
            );
            $prev.on('click', prev).noselect();
            $next.on('click', next).noselect();
        }
        function controls(index) {
            if (o.cyclic || (!o.cyclic && index > 0)) {
                $prev.removeClass('jflow-prev-disabled');
                if (o.controlsFade >= 0) {
                    $prev.fadeIn(o.controlsFade);
                }
            } else if (!o.cyclic && index <= 0) {
                $prev.addClass('jflow-prev-disabled')
                if (o.controlsFade >= 0) {
                    $prev.fadeOut(o.controlsFade);
                }
            }
            if (o.cyclic || (!o.cyclic && index < $items.length - 1)) {
                $next.removeClass('jflow-next-disabled');
                if (o.controlsFade >= 0) {
                    $next.fadeIn(o.controlsFade);
                }
            } else if (!o.cyclic && index >= $items.length - 1) {
                $next.addClass('jflow-next-disabled');
                if (o.controlsFade >= 0) {
                    $next.fadeOut(o.controlsFade);
                }
            }
        }
        function counter(index) {
            $counter.html((index + 1) + ' / ' + $items.length);
        }
        function prev() {
            go(currentIndex - 1);
        }
        function next() {
            go(currentIndex + 1);
        }
        function slideShow() {
            if (o.auto < 0) {
                return;
            }
            clearInterval(t);
            t = setInterval(function(){
                next();
            }, o.auto);
        }
        function go(index) {
            if (busy || (!o.cyclic && (index < 0 || index > $items.length - 1))) {
                return;
            }
            busy = true;
            if (index < 0) {
                index = $items.length - 1;
            } else if (index > $items.length - 1) {
                index = 0;
            }
            controls(index);
            counter(index);
            var currentItemLeft;
            if (index < currentIndex) {
                currentItemLeft = '100%';
                $items[index].style.left = '-100%';
            } else {
                currentItemLeft = '-100%';
                $items[index].style.left = '100%';
            }
            if (index == $items.length - 1 && currentIndex == 0) {
                currentItemLeft = '100%';
                $items[index].style.left = '-100%';
            } else if (index == 0 && currentIndex == $items.length - 1) {
                currentItemLeft = '-100%';
                $items[index].style.left = '100%';
            }
            $items.eq(currentIndex).animate({'left': currentItemLeft}, {duration: o.speed, easing: o.easing, queue: false});
            $items.eq(index).animate({left: '0%'}, {duration: o.speed, easing: o.easing, queue: false})
            $items.promise().done(function(){
                $items.removeClass('jflow-li-current').eq(index).addClass('jflow-li-current');
                currentIndex = index;
                busy = false;
            });
        }
    });
};
})(jQuery);



/* jswap
----------------------------------------------- */
(function($){
$.fn.jswap = function(o){
    o = $.extend({
        speed: 300,
        easing: 'easeOutExpo',
        auto: -1,
        cyclic: false,
        controlsFade: -1,
        heightModule: 1
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $list = $('.jswap-list', $root),
            $items = $('.jswap-li', $root),
            $prev = $('.jswap-prev', $root),
            $next = $('.jswap-next', $root),
            $counter = $('.jswap-counter', $root),
            currentIndex = $items.index($items.filter('.jswap-li-current')),
            t,
            busy = false;
        $items[currentIndex].style.height = o.heightModule * Math.ceil($items[currentIndex].offsetHeight / o.heightModule) + 'px';
        if ($items.length < 2) {
            return;
        }
        init();
        function init() {
            controls(currentIndex);
            counter(currentIndex);
            slideShow();
            $root.hover(
                function(){
                    clearInterval(t);
                },
                function(){
                    slideShow();
                }
            );
            $prev.on('click', prev).noselect();
            $next.on('click', next).noselect();
        }
        function controls(index) {
            if (o.cyclic || (!o.cyclic && index > 0)) {
                $prev.removeClass('jswap-prev-disabled');
                if (o.controlsFade >= 0) {
                    $prev.fadeIn(o.controlsFade);
                }
            } else if (!o.cyclic && index <= 0) {
                $prev.addClass('jswap-prev-disabled')
                if (o.controlsFade >= 0) {
                    $prev.fadeOut(o.controlsFade);
                }
            }
            if (o.cyclic || (!o.cyclic && index < $items.length - 1)) {
                $next.removeClass('jswap-next-disabled');
                if (o.controlsFade >= 0) {
                    $next.fadeIn(o.controlsFade);
                }
            } else if (!o.cyclic && index >= $items.length - 1) {
                $next.addClass('jswap-next-disabled');
                if (o.controlsFade >= 0) {
                    $next.fadeOut(o.controlsFade);
                }
            }
        }
        function counter(index) {
            $counter.html((index + 1) + ' / ' + $items.length);
        }
        function prev() {
            go(currentIndex - 1);
        }
        function next() {
            go(currentIndex + 1);
        }
        function slideShow() {
            if (o.auto < 0) {
                return;
            }
            clearInterval(t);
            t = setInterval(function(){
                next();
            }, o.auto);
        }
        function go(index) {
            if ( busy || ( !o.cyclic && ( index < 0 || index > $items.length - 1 ) ) ) {
                return;
            }
            busy = true;
            if (index < 0) {
                index = $items.length - 1;
            } else if (index > $items.length - 1) {
                index = 0;
            }
            controls(index);
            counter(index);
            var $item = $items.eq(index);
            $item.css({'position': 'absolute', 'left': -500, 'height': '', 'display': 'block'});
            var height = o.heightModule * Math.ceil($item[0].offsetHeight / o.heightModule);
            $item.css({'height': height, 'display': 'none', 'left': ''});
            $list.css({'height': $list.height(), 'overflow': 'hidden'});
            $items.css({'position': 'absolute', 'z-index': ''});
            $list.animate({'height': height}, {duration: o.speed, easing: o.easing, queue: false});
            $items.eq(currentIndex).css('z-index', 2).fadeOut(o.speed);
            $item.fadeIn(o.speed);
            $items.promise().done(function(){
                $items.css({'position': ''}).removeClass('jswap-li-current');
                $item.addClass('jswap-li-current');
                $list.css({'overflow': '', 'height': ''});
                currentIndex = index;
                busy = false;
            });
        }
    });
};
})(jQuery);



/* jselect
----------------------------------------------- */
(function($){
var $jselects = $();
$(document).on('click.jselect', close);
function close() {
    $jselects.removeClass('jselect-open');
}
$.fn.jselect = function(){
    return this.each(function(){
        var $select = $('select', this),
            $form = $($select.closest('form')),
            $options = $('option', $select),
            $jselect = $('<div class="jselect"><div class="jselect-title"><div class="jselect-title-r"><div class="jselect-title-l"><div class="jselect-title-text"></div><div class="jselect-arrow"></div></div></div></div><div class="jselect-list"><div class="jselect-list-rt"><div class="jselect-list-lt"><div class="jselect-list-wrap"><div class="jselect-list-content"></div><div class="jselect-arrow"></div></div></div></div><div class="jselect-list-rb"><div class="jselect-list-lb"></div></div></div></div>'),
            $title = $('.jselect-title', $jselect),
            $titleText = $('.jselect-title-text', $jselect),
            $listContent = $('.jselect-list-content', $jselect),
            $items = $();
        update();
        $options.each(function(index){
            var $option = $(this),
                $item = $('<div />', {
                    'class': 'jselect-li',
                    'html': $option.html() || '&nbsp;'
                });
            if ($option[0].disabled) {
                $item.addClass('jselect-li-disabled');
            } else {
                $item.on('click', function(){
                    set(index);
                    close();
                });
            }
            $items = $items.add($item);
        });
        $listContent.html($items);
        $jselect.width($select.width()).on('click', function(e){
            e.stopPropagation();
        }).noselect();
        $select.hide().after($jselect);
        $jselects = $('.jselect');
        $title.add($select).on('click', function(e){
            e.stopPropagation();
            open();
        });
        $form.reset(function(){
            update();
        });
        function open() {
            close();
            $jselect.addClass('jselect-open');
        }
        function set(index) {
            $select[0].selectedIndex = index;
            $select.triggerHandler('change');
            update();
        }
        function update() {
            var $selected = $options.eq($select[0].selectedIndex);
            $title.toggleClass('jselect-title-disabled', $selected.prop('disabled'));
            $titleText.html($selected.html() || '&nbsp;');
        }
    });
};
})(jQuery);



/* buy
----------------------------------------------- */
(function($){
$.fn.buy = function(items, o){
    var $items = $(items);
    if (!$items.length) {
        return this;
    }
    o = $.extend({
        URL: ''
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            URL = o.URL || $('input[name="buy_url"]', $root).val();
        $items.each(function(){
            var $item = $(this),
                $link = $('.buy-link', $item),
                ID = $('input[name="id"]', $item).val();
            $link.on('click', function(){
                buy(URL, ID);
            });
        });
    });
};
function buy(URL, ID) {
    $.post(URL, {'id': ID}, function(data){
        $.alert({content: data.content});
    }, 'json');
}
})(jQuery);



/* like
----------------------------------------------- */
(function($){
$.fn.like = function(items, o){
    var $items = $(items);
    if (!$items.length) {
        return this;
    }
    o = $.extend({
        URL: ''
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            URL = o.URL || $('input[name="like_url"]', $root).val();
        $items.each(function(){
            var $item = $(this),
                $link = $('.like-link, .dislike-link', $item),
                ID = $('input[name="id"]', $item).val();
            $item.on('click', '.like-link', function(){
                toggle(URL, ID, 1, $link);
            }).on('click', '.dislike-link', function(){
                toggle(URL, ID, 0, $link);
            });
        });
    });
};
function toggle(URL, ID, state, $link) {
    if (state) {
        $link.addClass('dislike-link').removeClass('like-link');
    } else {
        $link.addClass('like-link').removeClass('dislike-link');
    }
    $.post(URL, {'id': ID, 'state': state}, function(data){
        if (data.error) {
            if (state > 0) {
                $link.addClass('like-link').removeClass('dislike-link');
            } else {
                $link.addClass('dislike-link').removeClass('like-link');
            }
        }
    }, 'json');
}
})(jQuery);



/* toggles
----------------------------------------------- */
(function($){
$.fn.toggles = function(items, o){
    var $items = $(items);
    if (!$items.length) {
        return this;
    }
    o = $.extend({
        showOn: 'mouseenter',
        hideOn: 'mouseleave',
        speed: 100,
        display: 'block',
        effect: 'fadeIn',
        easing: '',
        visibleClass: ''
    }, o || {});
    var showing = false;
    if (o.effect == 'fadeIn') {
        var show = function($toggle){
                showing = true;
                if (o.visibleClass) {
                    $toggle.addClass(o.visibleClass);
                }
                $items.stop(true).css('display', o.display).animate({'opacity': 1}, {duration: o.speed, easing: o.easing, queue: false});
            },
            hide = function($toggle){
                showing = false;
                $items.stop(true).animate({'opacity': 0}, {duration: o.speed, easing: o.easing, queue: false}).promise().done(function(){
                    if (!showing) {
                        $items.hide();
                        $toggle.removeClass(o.visibleClass);
                    }
                });
            };
            $items.css('opacity', 0);
    } else if (o.effect == 'slideDown') {
        var show = function($toggle){
                showing = true;
                if (o.visibleClass) {
                    $toggle.addClass(o.visibleClass);
                }
                $items.stop(true).css('display', o.display).each(function(){
                    var $item = $(this),
                        original = $item.data('original');
                    $item.animate({
                        'height': original.height,
                        'padding-top': original.paddingTop,
                        'padding-bottom': original.paddingBottom
                    }, {duration: o.speed, easing: o.easing, queue: false});
                });
            },
            hide = function($toggle){
                showing = false;
                $items.stop(true).animate({
                    'height': 0,
                    'padding-top': 0,
                    'padding-bottom': 0
                }, {duration: o.speed, easing: o.easing, queue: false}).promise().done(function(){
                    if (!showing) {
                        $items.hide();
                        $toggle.removeClass(o.visibleClass);
                    }
                });
            };
        $items.each(function(){
            var $item = $(this);
            $item.data('original', {
                height: $item.height(),
                paddingTop: $item.css('padding-top'),
                paddingBottom: $item.css('padding-bottom')
            });
        }).css({'height': 0, 'overflow': 'hidden', 'padding-top': 0, 'padding-bottom': 0});
    }
    return this.each(function(){
        var $toggle = $(this);
        $toggle.on(o.showOn, function(){
            show($toggle);
        }).on(o.hideOn, function(){
            hide($toggle);
        });
    });
};
})(jQuery);











var pinit = (function (n, o, p, m) {
    var a = n[m.k] = {
        w: n,
        d: o,
        n: p,
        a: m,
        f: function () {
            return {
                callback: [],
                doNotTrack: function () {
                    var b = false;
                    if (a.n.doNotTrack === "1" || a.n.doNotTrack === "yes" || a.w.external && typeof a.w.external.msTrackingProtectionEnabled === "function" && a.w.external.msTrackingProtectionEnabled()) {
                        a.f.log("Client has requested Do Not Track.");
                        b = true
                    } else a.f.log("No request for Do Not Track found.");
                    return b
                },
                get: function (b, c) {
                    var d = null;
                    return d = typeof b[c] === "string" ? b[c] : b.getAttribute(c)
                },
                getData: function (b,
                c) {
                    c = a.a.dataAttributePrefix + c;
                    return a.f.get(b, c)
                },
                set: function (b, c, d) {
                    if (typeof b[c] === "string") b[c] = d;
                    else b.setAttribute(c, d)
                },
                make: function (b) {
                    var c = false,
                        d, e;
                    for (d in b) if (b[d].hasOwnProperty) {
                        c = a.d.createElement(d);
                        for (e in b[d]) b[d][e].hasOwnProperty && typeof b[d][e] === "string" && a.f.set(c, e, b[d][e]);
                        break
                    }
                    return c
                },
                kill: function (b) {
                    if (typeof b === "string") b = a.d.getElementById(b);
                    b && b.parentNode && b.parentNode.removeChild(b)
                },
                replace: function (b, c) {
                    b.parentNode.insertBefore(c, b);
                    a.f.kill(b)
                },
                listen: function (b,
                c, d) {
                    if (typeof a.w.addEventListener !== "undefined") b.addEventListener(c, d, false);
                    else typeof a.w.attachEvent !== "undefined" && b.attachEvent("on" + c, d)
                },
                call: function (b, c) {
                    var d, e, f = "?";
                    d = a.f.callback.length;
                    e = a.a.k + ".f.callback[" + d + "]";
                    a.f.callback[d] = function (g) {
                        c(g, d);
                        a.f.kill(e)
                    };
                    if (b.match(/\?/)) f = "&";
                    a.d.b.appendChild(a.f.make({
                        SCRIPT: {
                            id: e,
                            type: "text/javascript",
                            charset: "utf-8",
                            src: b + f + "callback=" + e
                        }
                    }))
                },
                log: function (b) {
                    a.v.config.debug && a.w.console && a.w.console.log(b)
                },
                presentation: function () {
                    var b,
                    c, d;
                    b = a.f.make({
                        STYLE: {
                            type: "text/css"
                        }
                    });
                    c = a.a.cdn[a.w.location.protocol] || a.a.cdn["http:"];
                    d = a.a.rules.join("\n");
                    d = d.replace(/\._/g, "." + m.k + "_");
/*                     d = d.replace(/;/g, "!important;"); */
                    d = d.replace(/_cdn/g, c);
                    d = d.replace(/_rez/g, a.v.resolution);
                    if (b.styleSheet) b.styleSheet.cssText = d;
                    else b.appendChild(a.d.createTextNode(d));
                    a.d.h ? a.d.h.appendChild(b) : a.d.b.appendChild(b)
                },
                click: function (b) {
                    b = b || a.w.event;
                    if ((b = b.target ? b.target.nodeType === 3 ? b.target.parentNode : b.target : b.srcElement) && b !== a.d.b) {
                        if (!a.f.getData(b,
                            "aha")) b = b.parentNode;
                        var c = a.f.getData(b, "aha");
                        if (c && b.href.match(/pinterest/)) {
                            if (!b.className.match(/hazClick/)) b.className = b.className + " " + a.a.k + "_hazClick";
                            a.f.aha("&type=" + c + "&href=" + encodeURIComponent(b.href))
                        }
                    }
                },
                behavior: function () {
                    a.f.listen(a.d.b, "click", a.f.click)
                },
                getPinCount: function (b) {
                    query = "?url=" + b + "&ref=" + encodeURIComponent(a.v.here) + "&source=" + a.a.countSource;
                    a.f.call(a.a.endpoint.count + query, a.f.ping.count)
                },
                prettyPinCount: function (b) {
                    if (b > 999) b = b < 1E6 ? ~~ (b / 1E3) + "K+" : b < 1E9 ? ~~ (b / 1E6) + "M+" : "++";
                    return b
                },
                tile: function (b, c) {
                    b.style.display = "block";
                    var d = {
                        height: a.a.tile.scale.height,
                        width: a.a.tile.scale.width
                    }, e = a.f.getData(b, "scale-height");
                    if (e && e >= a.a.tile.scale.minHeight) d.height = parseInt(e);
                    if ((e = a.f.getData(b, "scale-width")) && e >= a.a.tile.scale.minWidth) d.width = parseInt(e);
                    e = a.f.getData(b, "board-width") || b.offsetWidth;
                    if (e > b.offsetWidth) e = b.offsetWidth;
                    e = Math.floor(e / (d.width + a.a.tile.style.margin));
                    if (e > a.a.tile.maxColumns) e = a.a.tile.maxColumns;
                    if (e < a.a.tile.minColumns) return false;
                    var f = a.f.make({
                        SPAN: {
                            className: a.a.k + "_embed_board_bd"
                        }
                    });
                    f.style.height = d.height + "px";
                    a.v.renderedWidth = e * (d.width + a.a.tile.style.margin) - a.a.tile.style.margin;
                    f.style.width = a.v.renderedWidth + "px";
                    for (var g = 0, j = [], k = 0, q = c.length; k < q; k += 1) {
                        var i = a.f.make({
                            A: {
                                className: a.a.k + "_embed_board_th",
                                target: "_blank",
                                href: b.href
                            }
                        });
                        a.f.set(i, a.a.dataAttributePrefix + "aha", "embed_board");
                        var h = {
                            height: c[k].image_medium_size_pixels.height * (d.width / c[k].image_medium_size_pixels.width),
                            width: d.width
                        }, l = a.f.make({
                            IMG: {
                                src: c[k].image_medium_url,
                                height: h.height,
                                width: h.width,
                                className: a.a.k + "_embed_board_img"
                            }
                        });
                        l.style.height = h.height + "px";
                        l.style.width = h.width + "px";
                        l.style.marginTop = 0 - h.height / a.a.tile.style.margin + "px";
                        if (h.height > d.height) h.height = d.height;
                        i.appendChild(l);
                        i.style.height = h.height + "px";
                        i.style.width = h.width + "px";
                        j[g] || (j[g] = 0);
                        i.style.top = j[g] + "px";
                        i.style.left = g * (d.width + a.a.tile.style.margin) + "px";
                        j[g] = j[g] + h.height + a.a.tile.style.margin;
                        i.appendChild(l);
                        f.appendChild(i);
                        g = (g + 1) % e
                    }
                    return f
                },
                makeFooter: function (b, c) {
                    b = a.f.make({
                        A: {
                            className: a.a.k + "_embed_board_ft",
                            href: b.href,
                            target: "_blank"
                        }
                    });
                    if (a.v.renderedWidth > a.a.tile.minWidthToShowAuxText) b.innerHTML = "See On";
                    a.f.set(b, a.a.dataAttributePrefix + "aha", c);
                    c = a.f.make({
                        SPAN: {
                            className: a.a.k + "_embed_board_ft_logo"
                        }
                    });
                    b.appendChild(c);
                    return b
                },
                cssHook: function (b, c) {
                    if (b = a.f.getData(b, "css-hook")) c.className = c.className + " " + b
                },
                ping: {
                    count: function (b, c) {
                        if (c = a.d.getElementById(a.a.k + "_pin_count_" + c)) {
                            a.f.log("API replied with count: " + b.count);
                            var d = c.parentNode,
                                e = a.f.getData(d, "config");
                            if (b.count === 0) if (e === "above") {
                                a.f.log("Rendering zero count above.");
                                c.className = a.a.k + "_pin_it_button_count pin-it-button-count";
                                c.appendChild(a.d.createTextNode("0"))
                            } else a.f.log("Zero pin count not rendered to the side.");
                            if (b.count > 0) {
                                a.f.log("Got " + b.count + " pins for this page.");
                                e = a.f.getData(d, "config");
                                if (e === "above" || e === "beside") {
                                    a.f.log("Rendering pin count " + e);
                                    c.className = a.a.k + "_pin_it_button_count pin-it-button-count";
                                    c.appendChild(a.d.createTextNode(a.f.prettyPinCount(b.count)))
                                } else a.f.log("No valid pin count position specified; not rendering.")
                            }
                            a.f.cssHook(d,
                            c)
                        } else a.f.log("Pin It button container not found.")
                    },
                    pin: function (b, c) {
                        if ((c = a.d.getElementById(a.a.k + "_" + c)) && b.data && b.data[0]) {
                            a.f.log("API replied with a pin");
                            var d = a.f.make({
                                SPAN: {
                                    className: a.a.k + "_embed_pin"
                                }
                            });
                            if (a.v.config.style !== "plain") d.className = d.className + " " + a.a.k + "_fancy";
                            var e = a.f.make({
                                A: {
                                    className: a.a.k + "_embed_pin_link",
                                    href: "http://pinterest.com/pin/" + b.data[0].id,
                                    target: "_blank"
                                }
                            }),
                                f = a.f.make({
                                    IMG: {
                                        className: a.a.k + "_embed_pin_img",
                                        nopin: "true",
                                        src: b.data[0].image_medium_url
                                    }
                                });
                            e.appendChild(f);
                            a.f.set(e, a.a.dataAttributePrefix + "aha", "embed_pin");
                            d.appendChild(e);
                            if (b.data[0].attribution) {
                                e = a.f.make({
                                    SPAN: {
                                        className: a.a.k + "_embed_pin_attrib"
                                    }
                                });
                                e.appendChild(a.f.make({
                                    IMG: {
                                        className: a.a.k + "_embed_pin_attrib_icon",
                                        src: b.data[0].attribution.provider_favicon_url.replace(/\/api/, "")
                                    }
                                }));
                                e.appendChild(a.d.createTextNode("by "));
                                e.appendChild(a.f.make({
                                    A: {
                                        className: a.a.k + "_embed_pin_attrib_author",
                                        innerHTML: b.data[0].attribution.author_name,
                                        href: b.data[0].attribution.author_url,
                                        target: "_blank"
                                    }
                                }));
                                d.appendChild(e)
                            }
                            d.appendChild(a.f.make({
                                SPAN: {
                                    className: a.a.k + "_embed_pin_description",
                                    innerHTML: b.data[0].description || ""
                                }
                            }));
                            a.f.cssHook(c, d);
                            a.f.replace(c, d)
                        }
                    },
                    user: function (b, c) {
                        if ((c = a.d.getElementById(a.a.k + "_" + c)) && b.data && b.data.pins && b.data.pins.length) {
                            a.f.log("API replied with a user");
                            a.f.getData(c, "config");
                            var d = a.f.make({
                                SPAN: {
                                    className: a.a.k + "_embed_board"
                                }
                            });
                            if (a.v.config.style !== "plain") d.className = d.className + " " + a.a.k + "_fancy";
                            var e = a.f.make({
                                SPAN: {
                                    className: a.a.k + "_embed_board_hd"
                                }
                            }),
                                f = a.f.make({
                                    A: {
                                        aha: "embed_user",
                                        className: a.a.k + "_embed_board_title",
                                        innerHTML: b.data.user.full_name,
                                        target: "_blank",
                                        href: c.href
                                    }
                                });
                            e.appendChild(f);
                            d.appendChild(e);
                            if (b = a.f.tile(c, b.data.pins)) {
                                d.appendChild(b);
                                c.href += "pins/";
                                d.appendChild(a.f.makeFooter(c, "embed_user"));
                                a.f.cssHook(c, d);
                                a.f.replace(c, d)
                            }
                        }
                    },
                    board: function (b, c) {
                        if ((c = a.d.getElementById(a.a.k + "_" + c)) && b.data && b.data.pins && b.data.pins.length) {
                            a.f.log("API replied with a group of pins");
                            a.f.getData(c, "config");
                            var d = a.f.make({
                                SPAN: {
                                    className: a.a.k + "_embed_board"
                                }
                            });
                            if (a.v.config.style !== "plain") d.className = d.className + " " + a.a.k + "_fancy";
                            var e = a.f.tile(c, b.data.pins),
                                f = a.f.make({
                                    SPAN: {
                                        className: a.a.k + "_embed_board_hd"
                                    }
                                }),
                                g = a.f.make({
                                    A: {
                                        aha: "embed_board",
                                        className: a.a.k + "_embed_board_name",
                                        innerHTML: b.data.board.name,
                                        target: "_blank",
                                        href: c.href
                                    }
                                });
                            f.appendChild(g);
                            if (a.v.renderedWidth > a.a.tile.minWidthToShowAuxText) {
                                b = a.f.make({
                                    A: {
                                        aha: "embed_board",
                                        className: a.a.k + "_embed_board_author",
                                        innerHTML: b.data.user.full_name,
                                        target: "_blank",
                                        href: c.href
                                    }
                                });
                                f.appendChild(b)
                            } else g.className = a.a.k + "_embed_board_title";
                            d.appendChild(f);
                            if (e) {
                                d.appendChild(e);
                                d.appendChild(a.f.makeFooter(c, "embed_board"));
                                a.f.cssHook(c, d);
                                a.f.replace(c, d)
                            }
                        }
                    }
                },
                render: {
                    buttonBookmark: function (b) {
                        a.f.log("build bookmarklet button");
                        var c = a.f.make({
                            A: {
                                href: b.href,
                                className: a.a.k + "_pin_it_button pin-it-button"
                            }
                        });
                        a.f.set(c, a.a.dataAttributePrefix + "aha", "button_pinit");
                        var d = a.f.getData(b, "config");
                        if (a.a.config.pinItCountPosition[d] === true) {
                            a.f.set(c, a.a.dataAttributePrefix +
                                "config", d);
                            c.className = c.className + " " + a.a.k + "_pin_it_" + d
                        } else c.className = c.className + " " + a.a.k + "_pin_it_none";
                        a.f.getPinCount(encodeURIComponent(a.v.here));
                        c.onclick = function () {
                            a.v.firstScript.parentNode.insertBefore(a.f.make({
                                SCRIPT: {
                                    type: "text/javascript",
                                    charset: "utf-8",
                                    src: a.a.endpoint.bookmark + "?r=" + Math.random() * 99999999
                                }
                            }), a.v.firstScript);
                            return false
                        };
                        d = a.f.make({
                            SPAN: {
                                className: a.a.k + "_hidden ",
                                id: a.a.k + "_pin_count_" + a.f.callback.length,
                                innerHTML: "<i></i>"
                            }
                        });
                        c.appendChild(d);
                        a.f.replace(b,
                        c)
                    },
                    buttonPin: function (b) {
                        a.f.log("build Pin It button");
                        var c = a.f.make({
                            A: {
                                href: b.href,
                                className: a.a.k + "_pin_it_button pin-it-button"
                            }
                        });
                        a.f.set(c, a.a.dataAttributePrefix + "aha", "button_pinit");
                        var d = a.f.getData(b, "config");
                        if (a.a.config.pinItCountPosition[d] === true) {
                            a.f.set(c, a.a.dataAttributePrefix + "config", d);
                            c.className = c.className + " " + a.a.k + "_pin_it_" + d
                        } else c.className = c.className + " " + a.a.k + "_pin_it_none";
                        c.onclick = function () {
                            a.w.open(this.href, "pin" + (new Date).getTime(), a.a.pop);
                            return false
                        };
                        d = b.href.split("url=");
                        if (d[1]) {
                            d = d[1].split("&")[0];
                            var e = a.f.make({
                                SPAN: {
                                    className: a.a.k + "_hidden pin-it-button-count",
                                    id: a.a.k + "_pin_count_" + a.f.callback.length,
                                    innerHTML: "<i></i>"
                                }
                            });
                            c.appendChild(e);
                            a.f.getPinCount(d);
                            a.f.replace(b, c)
                        }
                    },
                    buttonFollow: function (b) {
                        a.f.log("build follow button");
                        if (b.href.split("/")[3]) {
                            a.f.getData(b, "config");
                            var c = a.f.make({
                                A: {
                                    target: "_pinterest",
                                    href: b.href,
                                    innerHTML: b.innerHTML,
                                    className: a.a.k + "_follow_me_button"
                                }
                            });
                            c.appendChild(a.f.make({
                                B: {}
                            }));
                            c.appendChild(a.f.make({
                                I: {}
                            }));
                            a.f.set(c, a.a.dataAttributePrefix +
                                "aha", "button_follow");
                            a.f.replace(b, c)
                        }
                    },
                    embedPin: function (b) {
                        a.f.log("build embedded pin");
                        (b = b.href.split("/")[4]) && parseInt(b) > 0 && a.f.getPinsIn("pin", "pins/info/", {
                            pin_ids: b
                        })
                    },
                    embedUser: function (b) {
                        a.f.log("build embedded profile");
                        (b = b.href.split("/")[3]) && a.f.getPinsIn("user", b + "/pins/")
                    },
                    embedBoard: function (b) {
                        a.f.log("build embedded board");
                        var c = b.href.split("/")[3];
                        b = b.href.split("/")[4];
                        c && b && a.f.getPinsIn("board", c + "/" + b + "/pins/")
                    }
                },
                getPinsIn: function (b, c, d) {
                    var e = "",
                        f = "?",
                        g;
                    for (g in d) if (d[g].hasOwnProperty) {
                        e = e + f + g + "=" + d[g];
                        f = "&"
                    }
                    a.f.call(a.a.endpoint[b] + c + e, a.f.ping[b])
                },
                build: function (b) {
                    if (typeof b !== "object" || b === null || !b.parentNode) b = a.d;
                    var c = b.getElementsByTagName("A"),
                        d, e = [];
                    d = 0;
                    for (b = c.length; d < b; d += 1) e.push(c[d]);
                    d = 0;
                    for (b = e.length; d < b; d += 1) if (e[d].href && e[d].href.match(a.a.myDomain)) {
                        c = a.f.getData(e[d], "do");
                        if (!c && e[d].href.match(/pin\/create\/button/)) {
                            c = "buttonPin";
                            var f = a.f.get(e[d], "count-layout"),
                                g = "none";
                            if (f === "vertical") g = "above";
                            if (f === "horizontal") g = "beside";
                            a.f.set(e[d], "data-pin-config",
                            g)
                        }
                        if (typeof a.f.render[c] === "function") {
                            e[d].id = a.a.k + "_" + a.f.callback.length;
                            a.f.render[c](e[d])
                        }
                    }
                },
                config: function () {
                    var b = a.d.getElementsByTagName("SCRIPT"),
                        c, d, e = b.length;
                    d = false;
                    a.v.firstScript = b[0];
                    for (c = 0; c < e; c += 1) if (a.a.myScript && b[c] && b[c].src && b[c].src.match(a.a.myScript)) {
                        if (d === false) {
                            for (d = 0; d < a.a.configParam.length; d += 1) a.v.config[a.a.configParam[d]] = a.f.get(b[c], a.a.dataAttributePrefix + a.a.configParam[d]);
                            d = true
                        }
                        a.f.kill(b[c])
                    }
                    if (e === 1) {
                        a.v.firstScript = a.f.make({
                            SCRIPT: {}
                        });
                        a.d.b.appendChild(a.v.firstScript)
                    }
                    if (typeof a.v.config.build ===
                        "string") a.w[a.v.config.build] = function (f) {
                        a.f.build(f)
                    };
                    if (a.a.doNotTrack === true || typeof a.v.config["do-not-track"] === "string" || a.f.doNotTrack()) a.v.aha = false;
                    else {
                        a.v.trackUrl = a.a.endpoint.track + "?r=" + Math.random() * 999999;
                        a.v.aha = a.f.make({
                            IFRAME: {
                                src: a.v.trackUrl,
                                height: "0",
                                width: "0",
                                frameborder: "0"
                            }
                        });
                        a.v.aha.style.position = "absolute";
                        a.v.aha.style.bottom = "-1px";
                        a.v.aha.style.left = "-1px";
                        a.d.b.appendChild(a.v.aha);
                        a.w.setTimeout(function () {
                            a.f.aha("&type=pidget")
                        }, 500)
                    }
                },
                aha: function (b) {
                    if (a.v.aha) {
                        var c = a.v.trackUrl + "#via=" + encodeURIComponent(a.v.here);
                        if (b) c += b;
                        a.v.aha.src = c
                    }
                },
                init: function () {
                    a.d.b = a.d.getElementsByTagName("BODY")[0];
                    a.d.h = a.d.getElementsByTagName("HEAD")[0];
                    a.v = {
                        resolution: 1,
                        here: a.d.URL.split("#")[0],
                        config: {}
                    };
                    if (a.w.devicePixelRatio && a.w.devicePixelRatio >= 2) a.v.resolution = 2;
                    a.f.config();
                    a.f.build();
                    a.f.presentation();
                    a.f.behavior()
                }
            }
        }()
    };
    a.f.init();
    return a.f
})(window, document, navigator, {
    doNotTrack: true,
    k: "PIN_" + (new Date).getTime(),
    myDomain: /^https?:\/\/pinterest\.com\//,
    myScript: /pinit.*?\.js$/,
    endpoint: {
        bookmark: "//assets.pinterest.com/js/pinmarklet.js",
        count: "//partners-api.pinterest.com/v1/urls/count.json",
        pin: "//api.pinterest.com/v3/pidgets/",
        board: "//api.pinterest.com/v3/pidgets/boards/",
        user: "//api.pinterest.com/v3/pidgets/users/",
        track: "//assets.pinterest.com/pidget.html"
    },
    config: {
        pinItCountPosition: {
            none: true,
            above: true,
            beside: true
        }
    },
    countSource: 6,
    dataAttributePrefix: "data-pin-",
    configParam: ["build", "do-not-track", "debug", "style"],
    pop: "status=no,resizable=yes,scrollbars=yes,personalbar=no,directories=no,location=no,toolbar=no,menubar=no,width=632,height=270,left=0,top=0",
    cdn: {
        "https:": "https://a248.e.akamai.net/passets.pinterest.com.s3.amazonaws.com",
        "http:": "http://passets-cdn.pinterest.com"
    },
    tile: {
        scale: {
            minWidth: 60,
            minHeight: 60,
            width: 92,
            height: 175
        },
        minWidthToShowAuxText: 150,
        minContentWidth: 120,
        minColumns: 1,
        maxColumns: 6,
        style: {
            margin: 2,
            padding: 10
        }
    },
    rules: ["a._pin_it_button {  background-image: url(_cdn/images/pidgets/bps_rez.png); background-repeat: none; background-size: 40px 60px; display: inline-block; height: 20px; margin: 0; position: relative; padding: 0; vertical-align: middle; text-decoration: none; width: 40px; background-position: 0 -20px }",
        "a._pin_it_button:hover { background-position: 0 0px}", "a._pin_it_button:active, a._pin_it_button._hazClick { background-position: 0 -40px}", "a._pin_it_button span._pin_it_button_count { position: absolute; color: #777; text-align: center;  }", "a._pin_it_above span._pin_it_button_count { background: transparent url(_cdn/images/pidgets/fpa_rez.png) 0 0 no-repeat; background-size: 40px 29px; position: absolute; bottom: 21px; left: 0px; height: 29px; width: 40px; font: 12px Arial, Helvetica, sans-serif; line-height: 24px; }",
        "a._pin_it_beside span._pin_it_button_count, a._pin_it_beside span._pin_it_button_count i { background-color: transparent; background-repeat: no-repeat; background-image: url(_cdn/images/pidgets/fpb_rez.png); }", "a._pin_it_beside span._pin_it_button_count { padding: 0 3px 0 10px; background-size: 45px 20px; background-position: 0 0; position: absolute; top: 0; left: 41px; height: 20px; font: 10px Arial, Helvetica, sans-serif; line-height: 20px; }", "a._pin_it_beside span._pin_it_button_count i { background-position: 100% 0; position: absolute; top: 0; right: -2px; height: 20px; width: 2px; }",
        "a._pin_it_button._pin_it_above { margin-top: 20px; }", "a._follow_me_button, a._follow_me_button i { background: transparent url(_cdn/images/pidgets/bfs1.png) 0 0 no-repeat }", 'a._follow_me_button { color: #444; display: inline-block; font: bold normal normal 11px/20px "Helvetica Neue",helvetica,arial,san-serif; height: 20px; margin: 0; padding: 0; position: relative; text-decoration: none; text-indent: 19px; vertical-align: middle;}', "a._follow_me_button:hover { background-position: 0 -20px}", "a._follow_me_button:active  { background-position: 0 -40px}",
        "a._follow_me_button b { position: absolute; top: 3px; left: 3px; height: 14px; width: 14px; background-size: 14px 14px; background-image: url(_cdn/images/pidgets/log_rez.png); }", "a._follow_me_button i { position: absolute; top: 0; right: -4px; height: 20px; width: 4px; background-position: 100% 0px; }", "a._follow_me_button:hover i { background-position: 100% -20px;  }", "a._follow_me_button:active i { background-position: 100% -40px; }", "span._embed_pin { display: inline-block; padding: 15px 0; text-align: center; width: 225px; }",
        "span._embed_pin._fancy { background: #fff; box-shadow: 0 0 3px #aaa; border-radius: 3px; }", "span._embed_pin a._embed_pin_link { display: block;  margin: 0 auto 10px; padding: 0; position: relative;  line-height: 0;}", "span._embed_pin a._embed_pin_link img._embed_pin_img { box-shadow: 0 0 1px #aaa; margin: 0;}", "span._embed_pin a._embed_pin_link img._embed_pin_video { left: 50%; margin-left: -25px; margin-top: -25px; position: absolute; top: 50%; }", 'span._embed_pin span._embed_pin_attrib, span._embed_pin span._embed_pin_description { display: block; font: normal 11px/14.85px "Helvetica Neue", arial, sans-serif; margin: 0 15px; text-align: left; }',
        "span._embed_pin span._embed_pin_attrib { color: #ad9c9c; margin-bottom: 10px; height: 16px; line-height: 16px;}", "span._embed_pin span._embed_pin_attrib a._embed_pin_attrib_author { color: #ad9c9c; font-weight: bold; text-decoration: none; }", "span._embed_pin span._embed_pin_attrib a._embed_pin_attrib_author:hover { text-decoration: underline; }", "span._embed_pin span._embed_pin_attrib img._embed_pin_attrib_icon { margin: 0 5px 0 0; height: 16px; width: 16px; vertical-align: middle; display: inline-block; }",
        "span._embed_board { display: inline-block; margin: 0; padding:10px 0; position: relative; text-align: center}", "span._embed_board._fancy { background: #fff; box-shadow: 0 0 3px #aaa; border-radius: 3px; }", "span._embed_board span._embed_board_hd { display: block; margin: 0 10px; padding: 0; line-height: 20px; height: 25px; position: relative;  }", "span._embed_board span._embed_board_hd a { cursor: pointer; background: inherit; text-decoration: none; width: 48%; white-space: nowrap; position: absolute; top: 0; overflow: hidden;  text-overflow: ellipsis; }",
        "span._embed_board span._embed_board_hd a:hover { text-decoration: none; background: inherit; }", "span._embed_board span._embed_board_hd a:active { text-decoration: none; background: inherit; }", "span._embed_board span._embed_board_hd a._embed_board_title { width: 100%; position: absolute; left: 0; text-align: left; font-family: Georgia; font-size: 16px; color:#2b1e1e;}", "span._embed_board span._embed_board_hd a._embed_board_name { position: absolute; left: 0; text-align: left; font-family: Georgia; font-size: 16px; color:#2b1e1e;}",
        "span._embed_board span._embed_board_hd a._embed_board_author { position: absolute; right: 0; text-align: right; font-family: Helvetica; font-size: 11px; color: #746d6a; font-weight: bold;}", 'span._embed_board span._embed_board_hd a._embed_board_author::before { content:"by "; font-weight: normal; }', "span._embed_board span._embed_board_bd { display:block; margin: 0 10px; overflow: hidden; border-radius: 2px; position: relative; }", "span._embed_board span._embed_board_bd a._embed_board_th { cursor: pointer; display: inline-block; position: absolute; overflow: hidden; }",
        'span._embed_board span._embed_board_bd a._embed_board_th::before { position: absolute; content:""; z-index: 2; top: 0; left: 0; right: 0; bottom: 0; box-shadow: inset 0 0 2px #888; }', "span._embed_board span._embed_board_bd a._embed_board_th img._embed_board_img { position: absolute; top: 50%; left: 0; }", "a._embed_board_ft { text-shadow: 0 1px #fff; display: block; text-align: center; border: 1px solid #ccc; margin: 10px 10px 0; height: 31px; line-height: 30px;border-radius: 2px; text-decoration: none; font-family: Helvetica; font-weight: bold; font-size: 13px; color: #746d6a; background: #f4f4f4 url(_cdn/images/pidgets/board_button_link.png) 0 0 repeat-x}",
        "a._embed_board_ft:hover { text-decoration: none; background: #fefefe url(_cdn/images/pidgets/board_button_hover.png) 0 0 repeat-x}", "a._embed_board_ft:active { text-decoration: none; background: #e4e4e4 url(_cdn/images/pidgets/board_button_active.png) 0 0 repeat-x}", "a._embed_board_ft span._embed_board_ft_logo { vertical-align: top; display: inline-block; margin-left: 2px; height: 30px; width: 66px; background: transparent url(_cdn/images/pidgets/board_button_logo.png) 50% 48% no-repeat; }", "._hidden { display:none; }"]
});