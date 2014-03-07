/* popup
----------------------------------------------- */
(function($){
    var o = {},
        el = {},
        xhr = null,
        $src = $(),
        $object = $(),
        $wrap = $('<div class="popup"><div class="popup-window"><div class="popup-r"><div class="popup-l"><div class="popup-content"></div><div class="popup-buttons"><div class="popup-ok"><i class="i"></i></div><div class="popup-cancel"><i class="i"></i></div></div></div></div><div class="popup-rt"><div class="popup-lt"></div></div><div class="popup-rb"><div class="popup-lb"></div></div><div class="popup-close"><i class="i"></i></div></div><div class="popup-loading"><i class="i"></i></div><div class="popup-overlay"></div></div>'),
        $window = $('.popup-window', $wrap),
        $content = $('.popup-content', $wrap),
        $ok = $('.popup-ok', $wrap),
        $cancel = $('.popup-cancel', $wrap),
        $close = $('.popup-close', $wrap),
        $loading = $('.popup-loading', $wrap),
        $overlay = $('.popup-overlay', $wrap),
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
        $('body').append($wrap);
        $ok.on('click', function(){
            ok();
        }).noselect();
        $cancel.on('click', function(){
            cancel();
        }).noselect();
        $close.on('click', function(){
            close();
        }).noselect();
        $loading.on('click', function(){
            close();
        }).noselect();
        $overlay.css({'opacity': 0}).on('click', function(){
            if (o.closeOnOverlay) {
                close();
            }
        }).noselect();
    }
    function clear() {
        $wrap.removeClass('text-popup alert-popup confirm-popup');
        if (o.extraClass) {
            $wrap.removeClass(o.extraClass);
        }
        $window.stop(true).css({'left': '', 'margin': '', 'opacity': ''});
        $ok.html('<i class="i"></i>');
        $cancel.html('<i class="i"></i>');
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
        $wrap.addClass(o.extraClass);
        $ok.html(o.okButton ||'<i class="i"></i>');
        $cancel.html(o.cancelButton || '<i class="i"></i>');
        switch(o.mode) {
            case 'text':
            $wrap.addClass('text-popup');
            break;
            case 'alert':
            $wrap.addClass('alert-popup');
            break;
            case 'confirm':
            $wrap.addClass('confirm-popup');
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
            empty();
        }
        function text() {
            showOverlay(function(){
                $content.html(o.text);
                $object = $content.contents();
                showWindow();
            });
        }
        function content() {
            showOverlay(function(){
                $object = $(o.content);
                $content.html($object);
                showWindow();
            });
        }
        function src() {
            showOverlay(function(){
                $src = $(o.src);
                $object = $src.contents();
                $content.html($object);
                showWindow();
            });
        }
        function href() {
            showOverlay(function(){
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
            });
        }
        function empty() {
            showOverlay();
        }
    }
    function showOverlay(complete) {
        if (o.beforeShowOverlay) {
            o.beforeShowOverlay(el);
        }
        if (o.showOverlay) {
            o.showOverlay(el, o.afterShowOverlay);
        } else {
            $.popup.showOverlay(function(el){
                if (o.afterShowOverlay) {
                    o.afterShowOverlay(el);
                }
                if (complete) {
                    complete(el);
                }
            });
        }
    }
    function hideOverlay(complete) {
        if (o.beforeHideOverlay) {
            o.beforeHideOverlay(el);
        }
        if (o.hideOverlay) {
            o.hideOverlay(el, o.afterHideOverlay);
        } else {
            $.popup.hideOverlay(function(el){
                if (o.afterHideOverlay) {
                    o.afterHideOverlay(el);
                }
                if (complete) {
                    complete(el);
                }
            });
        }
    }
    function showLoading(complete) {
        if (o.beforeShowLoading) {
            o.beforeShowLoading(el);
        }
        if (o.showLoading) {
            o.showLoading(el, o.afterShowLoading);
        } else {
            $.popup.showLoading(function(el){
                if (o.afterShowLoading) {
                    o.afterShowLoading(el);
                }
                if (complete) {
                    complete(el);
                }
            });
        }
    }
    function hideLoading(complete) {
        if (o.beforeHideLoading) {
            o.beforeHideLoading(el);
        }
        if (o.hideLoading) {
            o.hideLoading(el, o.afterHideLoading);
        } else {
            $.popup.hideLoading(function(el){
                if (o.afterHideOverlay) {
                    o.afterHideLoading(el);
                }
                if (complete) {
                    complete(el);
                }
            });
        }
    }
    function showWindow(complete) {
        if (o.beforeShowWindow) {
            o.beforeShowWindow(el);
        }
        if (o.showWindow) {
            o.showWindow(el, o.afterShowWindow);
        } else {
            $.popup.showWindow(function(el){
                if (o.afterShowWindow) {
                    o.afterShowWindow(el);
                }
                if (complete) {
                    complete(el);
                }
            });
        }
    }
    function hideWindow(complete) {
        if (o.beforeHideWindow) {
            o.beforeHideWindow(el);
        }
        if (o.hideWindow) {
            o.hideWindow(el, o.afterHideWindow);
        } else {
            $.popup.hideWindow(function(el){
                if (o.afterHideWindow) {
                    o.afterHideWindow(el);
                }
                if (complete) {
                    complete(el);
                }
            });
        }
    }
    function error() {
        close();
    }
    function ok(complete) {
        if (o.beforeOk) {
            o.beforeOk(el);
        }
        if (o.ok) {
            o.ok(el, o.afterOk);
        } else {
            $.popup.ok(function(el){
                if (o.afterOk) {
                    o.afterOk(el);
                }
                if (complete) {
                    complete(el);
                }
            });
        }
    }
    function cancel(complete) {
        if (o.beforeCancel) {
            o.beforeCancel(el);
        }
        if (o.cancel) {
            o.cancel(el, o.afterCancel);
        } else {
            $.popup.cancel(function(el){
                if (o.afterCancel) {
                    o.afterCancel(el);
                }
                if (complete) {
                    complete(el);
                }
            });
        }
    }
    function close(complete) {
        if (o.beforeClose) {
            o.beforeClose(el);
        }
        if (o.close) {
            o.close(el, o.afterClose);
        } else {
            $.popup.close(function(el){
                if (o.afterClose) {
                    o.afterClose(el);
                }
                if (complete) {
                    complete(el);
                }
            });
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
            wrapStyle = $wrap[0].style;
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
        wrapStyle.width = width;
        wrapStyle.height = height;
    }
    function alignWindow() {
        var documentClientWidth = documentProps.clientWidth(),
            documentClientHeight = documentProps.clientHeight(),
            documentScrollLeft = documentProps.scrollLeft(),
            documentScrollTop = documentProps.scrollTop(),
            viewportWidth = $wrap[0].offsetWidth,
            viewportHeight = $wrap[0].offsetHeight,
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
        if (o.fixed) {
            $wrap.css({'position': '', 'width': '', 'height': ''});
        } else {
            $wrap.css({'position': 'absolute'});
            resizeViewport();
            $browser.off('resize.popup').on('resize.popup', function(){
                resizeViewport();
            });
        }
        $wrap.css({'left': 0});
        $overlay.stop(true).css({'background-color': o.overlayColor});
        if ($overlay.css('opacity') == o.overlayOpacity) {
            if (complete) {
                complete(el);
            }
        } else {
            $overlay.fadeTo(o.speed, o.overlayOpacity, function(){
                if (complete) {
                    complete(el);
                }
            });
        }
        $document.off('keyup.popup').on('keyup.popup', function(e){
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
        $overlay.stop(true);
        if ($overlay.css('opacity') == 0) {
            if (complete) {
                complete(el);
            }
        } else {
            $overlay.fadeTo(o.speed, 0, function(){
                if (complete) {
                    complete(el);
                }
            });
        }
    };
    $.popup.showLoading = function(complete){
        $.popup.hideWindow();
        $.popup.showOverlay(function(el){
            $loading.show();
            if (complete) {
                complete(el);
            }
        });
    };
    $.popup.hideLoading = function(complete){
        $loading.hide();
        if (complete) {
            complete(el);
        }
    };
    $.popup.showWindow = function(complete) {
        if (o.fixed) {
            $window.css({'margin-left': -($window[0].offsetWidth / 2), 'margin-top': -($window[0].offsetHeight / 2), 'left': '50%', 'top': '50%'});
        } else {
            resizeViewport();
            alignWindow();
            $browser.off('resize.popup').on('resize.popup', function(){
                alignWindow();
            });
        }
        $window.stop(true);
        if ($window.css('opacity') == 1) {
            if (complete) {
                complete(el);
            }
        } else {
            $window.fadeTo(o.speed, 1, function(){
                if (complete) {
                    complete(el);
                }
            });
        }
    }
    $.popup.hideWindow = function(complete){
        $window.stop(true);
        if ($window.css('opacity') == 0) {
            $window.css({'left': '', 'top': '', 'margin': ''});
            if (complete) {
                complete(el);
            }
        } else {
            $window.fadeTo(o.speed, 0, function(){
                $window.css({'left': '', 'top': '', 'margin': ''});
                if (complete) {
                    complete(el);
                }
            });
        }
    };
    $.popup.ok = function(complete){
        if (complete) {
            complete(el);
        }
        $.popup.close();
    };
    $.popup.cancel = function(complete){
        if (complete) {
            complete(el);
        }
        $.popup.close();
    };
    $.popup.close = function(complete){
        $.popup.hideLoading();
        $.popup.hideWindow(function(){
            $.popup.hideOverlay(function(){
                $wrap.css({'left': '', 'width': '', 'height': '', 'position': ''});
                if (complete) {
                    complete(el);
                }
                clear();
            });
        });
    };
    $.popup.get = function(){
        return o;
    };
    $.popup.set = function(params){
        if (params.extraClass) {
            $wrap.addClass(params.extraClass);
            if (o.extraClass) {
                $wrap.removeClass(o.extraClass);
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
        overlayColor: '#000',
        overlayOpacity: 0.5,
        extraClass: '',
        okButton: '',
        cancelButton: ''
    };
    $(function(){
        init();
    });
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
            total = $items.length,
            $prev = $('.jflow-prev', $root),
            $next = $('.jflow-next', $root),
            $counter = $('.jflow-counter', $root),
            currentIndex = $items.index($items.filter('.jflow-li-current')),
            t,
            busy = false;
        if (total < 2) {
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
                    if (o.controlsFade >= 0) {
                        $prev.add($next).fadeIn(o.controlsFade);
                    }
                },
                function(){
                    slideShow();
                    if (o.controlsFade >= 0) {
                        $prev.add($next).fadeOut(o.controlsFade);
                    }
                }
            );
            $prev.on('click', prev).noselect();
            $next.on('click', next).noselect();
        }
        function controls(index) {
            if (o.cyclic || (!o.cyclic && index > 0)) {
                $prev.removeClass('jflow-prev-disabled');
            } else if (!o.cyclic && index <= 0) {
                $prev.addClass('jflow-prev-disabled')
            }
            if (o.cyclic || (!o.cyclic && index < total - 1)) {
                $next.removeClass('jflow-next-disabled');
            } else if (!o.cyclic && index >= total - 1) {
                $next.addClass('jflow-next-disabled');
            }
        }
        function counter(index) {
            $counter.html((index + 1) + ' / ' + total);
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
            if (busy || (!o.cyclic && (index < 0 || index > total - 1))) {
                return;
            }
            busy = true;
            if (index < 0) {
                index = total - 1;
            } else if (index > total - 1) {
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
            if (index == total - 1 && currentIndex == 0) {
                currentItemLeft = '100%';
                $items[index].style.left = '-100%';
            } else if (index == 0 && currentIndex == total - 1) {
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















/* PLUGINS
----------------------------------------------- */
/* form
----------------------------------------------- */
(function($){
$.fn.form = function(o){
    return this.each(function(){
        $.form(this, o);
    });
};
$.form = function(form, o){
    o = $.extend({}, $.form.defaults, o);
    var $form = $(form),
        $inputs = $('input, textarea', $form),
        validator = $form.validate({
            rules: o.rules,
            messages: o.messages,
            highlight: o.highlight || function(el){
                $(el).closest('.field').addClass('field-error');
            },
            unhighlight: o.unhighlight || function(el){
                $(el).closest('.field').removeClass('field-error');
            },
            errorPlacement: o.errorPlacement || function(){},
            submitHandler: o.submitHandler || function(){
                if (o.ajax) {
                    $form.ajaxSubmit({
                        url: o.url || form.action,
                        data: typeof o.data == 'function' ? o.data() : o.data,
                        dataType: o.dataType,
                        beforeSerialize: o.beforeSerialize || function(){
                            $inputs.filter('.placeholder').each(function(){
                                var $input = $(this);
                                if ($input.val() == $input.data('placeholder')) {
                                    $input.val('');
                                }
                            });
                        },
                        beforeSubmit: o.beforeSubmit || function(){},
                        success: o.success || function(data){
                            $inputs.filter('.placeholder').each(function(){
                                var $input = $(this);
                                $input.val($input.data('placeholder'));
                            });
                            if (o.complete) {
                                o.complete(data);
                            }
                            if (data.error) {
                                return;
                            }
                            if (o.reset) {
                                validator.resetForm();
                                $form.reset();
                            }
                            if (o.reload) {
                                location.reload(true);
                            }
                        }
                    });
                } else {
                    form.action = o.url || form.action;
                    form.submit();
                }
            }
        });
};
$.form.defaults = {
    ajax: false,
    url: '',
    data: {},
    dataType: 'json',
    reset: true,
    reload: false,
    rules: {},
    messages: {}
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
            $input.closest('form').on('reset', init);
        }
        $input.off('.placeholder').on('reset.placeholder', init).on('focusin.placeholder', function(){
            if ($input.val() == placeholder) {
                $input.val('').removeClass(className);
            }
        }).on('focusout.placeholder', function(){
            if ($input.val() == '') {
                $input.addClass(className).val(placeholder);
            }
        }).data('placeholder', placeholder);
        function init() {
            console.log(111);
            if ($input.val() == '' || $input.val() == placeholder) {
                $input.addClass(className).val(placeholder);
            } else {
                $input.removeClass(className);
            }
        }
    });
};
})(jQuery);







/* jcheck
----------------------------------------------- */
(function($){
$.fn.jcheck = function(o){
    return this.each(function(){
        var $root = $(this);
        if ($root.is('.jcheck')) {
            return;
        }
        var $input = $('input', $root);
        $root.addClass('jcheck');
        $('label', $root).append('<i class="jcheck-input"><i class="i"><i/><i/>');
        update();
        $input.off('.jcheck').on('click.jcheck', function(){
            update();
        });
        function update() {
            $root.toggleClass('jcheck-checked', $input[0].checked);
        }
    });
};
})(jQuery);



/* teaser
----------------------------------------------- */
(function($){
$.fn.teaser = function(o){
    o = $.extend({
        speed: 300,
        easing: 'easeOutExpo',
        auto: 7000,
        cyclic: true,
        controlsFade: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $items = $('.jflow-li', $root);
        $('.jflow', $root).jflow({speed: o.speed, easing: o.easing, auto: o.auto, cyclic: o.cyclic, controlsFade: o.controlsFade});
    });
};
})(jQuery);



/* search
----------------------------------------------- */
(function($){
$.fn.search = function(){
    return this.each(function(){
        var $root = $(this);
        $('form', $root).form({
            highlight: function(){
                $root.addClass('search-error');
            },
            unhighlight: function(){
                $root.removeClass('search-error');
            }
        });
        $root.hover(
            function(){
                $root.addClass('search-hover');
            },
            function(){
                $root.removeClass('search-hover');
            }
        ).on('focusin', function(){
            $root.addClass('search-focus');
        }).on('focusout', function(){
            $root.removeClass('search-focus search-error');
        });
    });
};
})(jQuery);



/* eventsBlock
----------------------------------------------- */
(function($){
$.fn.eventsBlock = function(o){
    o = $.extend({
        speed: 200,
        easing: '',
        auto: -1,
        cyclic: false,
        controlsFade: -1,
        heightModule: 16
    }, o || {});
    return this.each(function(){
        $('.jswap', this).jswap({speed: o.speed, easing: o.easing, auto: o.auto, cyclic: o.cyclic, controlsFade: o.controlsFade, heightModule: o.heightModule});
    });
};
})(jQuery);



/* eventsWidget
----------------------------------------------- */
(function($){
$.fn.eventsWidget = function(o){
    o = $.extend({
        speed: 200,
        easing: '',
        auto: -1,
        cyclic: false,
        controlsFade: -1,
        heightModule: 1
    }, o || {});
    return this.each(function(){
        $('.jswap', this).jswap({speed: o.speed, easing: o.easing, auto: o.auto, cyclic: o.cyclic, controlsFade: o.controlsFade, heightModule: o.heightModule});
    });
};
})(jQuery);



/* catalogWidget
----------------------------------------------- */
(function($){
$.fn.catalogWidget = function(o){
    o = $.extend({
        speed: 200,
        easing: '',
        auto: -1,
        cyclic: false,
        controlsFade: -1,
        heightModule: 1
    }, o || {});
    return this.each(function(){
        $('.jswap', this).jswap({speed: o.speed, easing: o.easing, auto: o.auto, cyclic: o.cyclic, controlsFade: o.controlsFade, heightModule: o.heightModule});
    });
};
})(jQuery);



/* news
----------------------------------------------- */
(function($){
$.fn.news = function(o){
    o = $.extend({
        speed: 200,
        easing: '',
        auto: -1,
        cyclic: false,
        controlsFade: -1,
        heightModule: 1
    }, o || {});
    return this.each(function(){
        $('.jswap', this).jswap({speed: o.speed, easing: o.easing, auto: o.auto, cyclic: o.cyclic, controlsFade: o.controlsFade, heightModule: o.heightModule});
    });
};
})(jQuery);



/* auth
----------------------------------------------- */
(function($){
$.fn.auth = function(o){
    o = $.extend({
        speed: 100,
        src: '',
        link: ''
    }, o || {});
    return this.each(function(){
        var $root = $(this);
        (function(){
            var $tabs = $('.tabs li', $root),
                $content = $('.content', $root),
                $items = $('.ci', $root),
                currentIndex = $items.index($items.filter('.current')),
                busy = false;
            $tabs.each(function(index){
                $(this).on('click', function(){
                    show(index);
                });
            });
            function show(index) {
                if (busy || index == currentIndex) {
                    return;
                }
                busy = true;
                $tabs.eq(currentIndex).removeClass('act');
                $tabs.eq(index).addClass('act');
                $content.height($content.height());
                $items.eq(currentIndex).hide();
                $items.eq(index).fadeIn(o.speed, function(){
                    currentIndex = index;
                    busy = false;
                });
                $content.height('');
            }
        })();
        (function(){
            var $form = $('.logon form', $root),
                $status = $('.logon .status', $root),
                $emailInput = $('.logon input[name="email"]', $root);
            $(o.link).popup({
                src: o.src,
                beforeShowWindow: function(){
                    $emailInput.focus();
                }
            });
            $form.form({
                ajax: true,
                success: function(data){
                    if (data.error) {
                        $emailInput.focus();
                        $status.html(data.status).fadeIn(o.speed);
                    } else {
                        $status.hide();
                        $form[0].submit();
                    }
                }
            });
        })();
        (function(){
            var $form = $('.register form', $root),
                formAction = $form.attr('action'),
                $status = $('.register .status', $root);
            $form.form({
                ajax: true,
                highlight: function(el){
                    $(el).closest('.field').addClass('field-error');
                    if (this.errorMap.email || this.errorMap.agreement) {
                        $status.html(this.errorMap.email || this.errorMap.agreement).fadeIn(o.speed);
                    }
                },
                unhighlight: function(el){
                    $(el).closest('.field').removeClass('field-error');
                    if (!this.errorMap.email && !this.errorMap.agreement) {
                        $status.hide();
                    }
                },
                rules: {
                    email: {
                        remote: {
                            url: formAction,
                            type: 'post',
                            data: {check: 1}
                        }
                    },
                    password2: {
                        equalTo: '#register-password'
                    }
                },
                messages: {
                    email: {
                        required: ''
                    },
                    agreement: lang.validatorAgreement
                },
                success: function(data){
                    if (data.error) {
                        $status.html(data.status).fadeIn(o.speed);
                    } else {
                        $status.hide();
                        $.alert({
                            text: data.status,
                            afterOk: function(){
                                if (data.redirect) {
                                    location.replace(data.redirect);
                                }
                            }
                        });
                    }
                }
            });
        })();
        $('.password-field').each(function(){
            var $field = $(this),
                $input = $('input', $field),
                $toggle = $('.visible, .hidden', $field);
            $toggle.on('click', '.show', show).on('click', '.hide', hide);
            function show() {
                $input.prop('type', 'text');
                $toggle.addClass('visible').removeClass('hidden');
            }
            function hide() {
                $input.prop('type', 'password');
                $toggle.addClass('hidden').removeClass('visible');
            }
        });
    });
};
})(jQuery);




/* recover
----------------------------------------------- */
(function($){
$.fn.recover = function(o){
    o = $.extend({
        speed: 100,
        src: '',
        link: ''
    }, o || {});
    return this.each(function(){
        var $root = $(this);
        (function(){
            var $form = $('form', $root),
                $status = $('.status', $root),
                $emailInput = $('input[name="email"]', $root);
            $(o.link).popup({
                src: o.src,
                beforeShowWindow: function(){
                    $emailInput.focus();
                }
            });
            $form.form({
                ajax: true,
                success: function(data){
                    if (data.error) {
                        $emailInput.focus();
                    }
                    $status.html(data.status).fadeIn(o.speed);
                }
            });
        })();
    });
};
})(jQuery);




/* profile
----------------------------------------------- */
(function($){
$.fn.profile = function(o){
    o = $.extend({
        speed: 100,
        src: '',
        link: ''
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $form = $('form', $root),
            $status = $('.status', $root);
        $(o.link).popup({
            src: o.src
        });
        $form.form({
            ajax: true,
            rules: {
                new_password2: {
                    equalTo: '#profile-new-password'
                }
            },
            success: function(data){
                if (data.error) {
                    $status.html(data.status).fadeIn(o.speed);
                } else {
                    $status.hide();
                    $popup.close();
                }
            }
        });
    });
};
})(jQuery);



/* up
----------------------------------------------- */
(function($){
var $body = $();
$(function(){
    $body = $('html, body');
});
$.fn.up = function(o){
    o = $.extend({
        speed: 300,
        easing: 'easeOutExpo'
    }, o || {});
    return this.each(function(){
        $(this).on('click', function(){
            $body.animate({scrollTop: 0}, {duration: o.speed, easing: o.easing, queue: false});
        });
    });
};
})(jQuery);



/* jdrop
----------------------------------------------- */
(function($){
var t;
$(document).on('click.jdrop', close);
function close() {
    $('.jdrop').removeClass('jdrop-open');
}
$.fn.jdrop = function(o){
    o = $.extend({
        mode: 'select',
        click: true,
        delay: 500
    }, o || {});
    return this.each(function(){
        var $jdrop = $(this),
            $caption = $('.jdrop-caption', $jdrop),
            $list = $('.jdrop-list', $jdrop),
            $items = $(),
            listHTML = '';
        listHTML += '<div class="jdrop-wrap">';
        $('ul', $list).each(function(){
            listHTML += '<div class="jdrop-ul">';
            $('li', this).each(function(){
                listHTML += '<div class="jdrop-li">' + ($(this).html() || '&nbsp;') + '</div>';
            });
            listHTML += '</div>';
        });
        listHTML += '</div><div class="jdrop-arrow"></div>';
        $list.html(listHTML);
        $items = $('.jdrop-li', $jdrop);
        if (o.click) {
            $('.jdrop-title', $jdrop).add($list).off('.jdrop').on('click.jdrop', function(e){
                e.stopPropagation();
                open();
            });
        } else {
            $('.jdrop-title', $jdrop).add($list).off('.jdrop').on('click.jdrop', function(e){
                e.stopPropagation();
            }).on('mouseenter.jdrop', function(){
                clearTimeout(t);
                open();
            }).on('mouseleave.jdrop', function(){
                t = setTimeout(function(){
                    close();
                }, o.delay);
            });
        }
        $items.each(function(index){
            $(this).on('click.jdrop', function(e){
                e.stopPropagation();
                if (o.mode == 'select') {
                    set(index);
                }
                close();
            });
        });
        function open() {
            $jdrop.addClass('jdrop-open');
            $('.jdrop').not($jdrop).removeClass('jdrop-open');
        }
        function set(index) {
            $caption.html($items.eq(index).html());
        }
    });
};
})(jQuery);



/* jselect
----------------------------------------------- */
(function($){
$(document).on('click.jselect', close);
function close() {
    $('.jselect').removeClass('jselect-open');
}
$.fn.jselect = function(){
    return this.each(function(){
        var $select = $(this),
            $form = $($select.closest('form')),
            $options = $('option', $select),
            $jselect = $('<div class="jselect"><div class="jselect-title"><div class="jselect-caption"></div><div class="jselect-arrow"></div></div><div class="jselect-list"><div class="jselect-ul"></div><div class="jselect-arrow"></div></div></div>'),
            $title = $('.jselect-title', $jselect),
            $caption = $('.jselect-caption', $jselect),
            $list = $('.jselect-list', $jselect),
            $items = $();
        update();
        $options.each(function(index){
            var $option = $(this),
                $item = $('<div class="jselect-li">' + ($option.html() || '&nbsp;') + '</div>');
            if ($option.prop('disabled')) {
                $item.addClass('jselect-li-disabled');
            } else {
                $item.on('click.jselect', function(e){
                    e.stopPropagation();
                    set(index);
                    close();
                });
            }
            $items = $items.add($item);
        });
        $('.jselect-ul', $jselect).html($items);
        $jselect.width($select.width()).on('click', function(e){
            e.stopPropagation();
        }).noselect();
        $select.hide().after($jselect);
        $title.add($select).on('click.jselect', function(e){
            e.stopPropagation();
            open();
        });
        $form.reset(function(){
            update();
        });
        function open() {
            $jselect.addClass('jselect-open');
            $('.jselect').not($jselect).removeClass('jselect-open');
        }
        function set(index) {
            $select.prop('selectedIndex', index).triggerHandler('change');
            update();
        }
        function update() {
            var $selected = $options.eq($select.prop('selectedIndex'));
            $title.toggleClass('jselect-title-disabled', $select.prop('disabled'));
            $caption.html($selected.html() || '&nbsp;');
        }
    });
};
})(jQuery);



/* product
----------------------------------------------- */
(function($){
$.fn.product = function(o){
    o = $.extend({
        speed: 200,
        easing: ''
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $image = $('.image', $root),
            $img = $('.img', $root),
            $loading = $('.loading', $root),
            $items = $('.thumbs li', $root),
            $links = $('a', $items),
            currentIndex = $items.index($items.filter('.act')),
            busy = false;
        $links.on('click', function(e){
            e.preventDefault();
            var index = $links.index(this);
            show(index);
        });
        $img.on('click', 'a', function(e){
            e.preventDefault();
            var href = $(this).attr('href');
            $.fancybox({
                margin: 100,
                padding: 0,
                href: href,
                autoScale: true,
                overlayColor: '#000',
                overlayOpacity: 0.7
            });
        });
        function next() {
            show(currentIndex + 1);
        }
        function show(index) {
            if (busy || index == currentIndex) {
                return;
            }
            busy = true;
            if (index < 0) {
                index = $links.length - 1;
            } else if (index >= $links.length) {
                index = 0;
            }
            $items.removeClass('act').eq(index).addClass('act');
            $image.height($image.height());
            $img.hide();
            var img = new Image(),
                previewSRC = $links.eq(index).attr('rel'),
                fullSRC = $links.eq(index).attr('href');
            img.onload = function(){
                $loading.hide();
                $image.animate({'height': img.height}, {duration: o.speed, easing: o.easing, queue: false, complete: function(){
                    $img.html('<a href="' + fullSRC + '"><img src="' + previewSRC + '" alt="" /></a>').fadeIn(o.speed);
                    currentIndex = index;
                    busy = false;
                }});
            };
            img.src = previewSRC;
            if (!img.complete) {
                $loading.show();
            }
        }
    });
};
})(jQuery);



/* comments
----------------------------------------------- */
(function($){
var $win = $(window),
    docProps = {
        width: function(){
            return document.documentElement.clientWidth;
        },
        height: function(){
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
$.fn.comments = function(o){
    o = $.extend({
        speed: 200,
        statusDelay: 3000,
        easing: 'easeOutExpo'
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $loading = $('.comments-loading', $root),
            URL = $('input', $loading).val();
        load();
        $win.off('.comments').on('scroll.comments resize.comments', function(){
            load();
        });
        function load() {
            if (docProps.scrollTop() + docProps.height() >= $root.offset().top) {
                $win.off('scroll.comments resize.comments');
                $loading.show();
                $.post(URL, function(data){
                    if (data.error) {
                        $root.hide();
                        return;
                    }
                    $root.hide().html(data.content).fadeIn(o.speed);
                    init();
                }, 'json');
            }
        }
        function init() {
            var $form = $('.comments-form form', $root),
                removeURL = $('input[name="remove_url"]', $root).val(),
                $inputs = $('input, button, select, textarea', $root),
                $loading = $('.loading', $root),
                $status = $('.status', $root),
                $button = $('.button button', $root),
                $listWrap = $('.comments-list', $root),
                $total = $('.total', $root),
                $list = $('.list', $root);
            $form.form({
                ajax: true,
                data: function(){
                    return {total: $total.html()};
                },
                beforeSubmit: function(){
                    $button.prop('disabled', true);
                    $inputs.blur().prop('readonly', true);
                    $loading.show();
                },
                complete: function(data){
                    $loading.hide();
                    $inputs.prop('readonly', false);
                    $button.prop('disabled', false);
                    if (data.error) {
                        $status.addClass('status-error');
                        if (data.status) {
                            $status.html(data.status).fadeIn(o.speed);
                        }
                    } else {
                        $status.removeClass('status-error');
                        if (data.status) {
                            $status.html(data.status).fadeIn(o.speed).delay(o.statusDelay).fadeOut(o.speed);
                        }
                        $listWrap.show();
                        $total.html(data.total);
                        $('.last', $list).removeClass('last');
                        $list.append($(data.content).hide().fadeIn(o.speed));
                    }
                }
            });
            $list.on('click', '.remove', function(){
                var $item = $(this).closest('.li'),
                    ID = $('input[name="id"]', $item).val();
                $.confirm({
                    text: lang.comments.removeConfirm,
                    afterOk: function(){
                        remove($item, ID);
                    }
                });
            });
            function remove($item, ID) {
                var total = $total.html() - 1;
                if (total > 0) {
                    $total.html(total);
                    $item.fadeOut(o.speed, function(){
                        $item.remove();
                    });
                } else {
                    $listWrap.fadeOut(o.speed, function(){
                        $total.html(total);
                        $item.remove();
                    });
                }
                $.post(removeURL, {id: ID}, 'json');
            }
        }
    });
};
})(jQuery);



/* feedback
----------------------------------------------- */
(function($){
$.fn.feedback = function(){
    return this.each(function(){
        $('form', this).form({
            ajax: true,
            beforeSubmit: function(){
                $.popup({
                    afterShowOverlay: function(){
                        $.popup.showLoading();
                    }
                });
            },
            complete: function(data){
                $.alert({text: data.status});
            }
        });
    });
};
})(jQuery);



/* favorites
----------------------------------------------- */
(function($){
$.fn.favorites = function(items, o){
    var $items = $(items);
    if (!$items.length) {
        return this;
    }
    o = $.extend({
        faveURL: '',
        faversURL: ''
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            faveURL = o.faveURL || $('input[name="fave_url"]', $root).val(),
            faversURL = o.faversURL || $('input[name="favers_url"]', $root).val();
        $items.each(function(){
            var $item = $(this),
                $toggle = $('.favorites', $item),
                itemID = $('input[name^="itemid"]', $item).val();
            $toggle.on('click', '.fave:not(.fave-auth)', function(){
                toggle(faveURL, itemID, true, $toggle);
            }).on('click', '.unfave', function(){
                toggle(faveURL, itemID, false, $toggle);
            }).on('click', '.favers-link', function(){
                favers(faversURL, itemID);
            });
        });
    });
};
function toggle(faveURL, itemID, state, $toggle) {
    $toggle.toggleClass('faved', state);
    $.post(faveURL, {itemid: itemID, state: state}, function(data){
        if (data.error) {
            $toggle.toggleClass('faved', !state);
        }
    }, 'json');
}
function favers(faversURL, itemID) {
    $.popup();
    $.popup.showLoading();
    $.post(faversURL, {itemid: itemID}, function(data){
        if (data.error) {
            $.alert({text: data.status});
            return;
        }
        var $content = $(data.content);
        $.popup({content: $content});
        $('.li', $content).each(function(){
            var $item = $(this),
                userID = $('input[name^="userid"]', $item).val();
            $('.button', $item).mail(userID);
        });
    }, 'json');
}
})(jQuery);



/* mail
----------------------------------------------- */
(function($){
var $src, $root, $form, $fields, $userIDInput, validator;
$(function(){
    $src = $('#mail');
    if (!$src.length) {
        return;
    }
    $root = $('.mail', $src);
    $form = $('form', $root);
    $fields = $('.field', $root);
    $userIDInput = $('input[name^="userid"]', $root);
    $form.form({
        ajax: true,
        beforeSubmit: function(){
            $.popup.showLoading();
        },
        complete: function(data){
            $.alert({text: data.status});
        }
    });
    validator = $form.data('validator');
});
$.fn.mail = function(userID){
    if (!$src.length) {
        return this;
    }
    return this.each(function(){
        $(this).on('click', function(e){
            e.preventDefault();
            $userIDInput.val(userID);
            $.popup({
                src: $src,
                afterClose: function(){
                    validator.resetForm();
                    $form.reset();
                    $fields.removeClass('field-error');
                }
            });
        });
    });
};
})(jQuery);



/* buy
----------------------------------------------- */
(function($){
$.fn.buy = function(items){
    var $items = $(items);
    if (!$items.length) {
        return this;
    }
    return this.each(function(){
        var $root = $(this),
            buyURL = $('input[name="buy_url"]', $root).val(),
            helpURL = $('input[name="help_url"]', $root).val();
        $items.each(function(){
            var $item = $(this),
                itemID = $('input[name^="itemid"]', $item).val();
            $('.buy', $item).on('click', function(){
                buy(buyURL, itemID);
            });
            $('.help', $item).on('click', function(){
                help(helpURL, itemID);
            });
        });
    });
};
function buy(URL, itemID) {
    $.popup({
        afterShowOverlay: function(){
            $.popup.showLoading();
            $.post(URL, {'itemid': itemID}, function(data){
                if (data.error) {
                    $.alert(data.status);
                    return;
                }
                $content = $(data.content);
                $.popup({content: $content});

		            $('form', $content).form({
		                ajax: true,
		                beforeSubmit: function(){
			                	$.popup.showLoading();
		                },
		                success: function(data){
				                if (data.error) {
				                    $.alert(data.status);
				                    return;
				                }
                        $.popup({content: data.content});
		                }
		            });
            }, 'json');
        }
    });
}
function help(URL, itemID) {
    $.popup({
        afterShowOverlay: function(){
            $.popup.showLoading();
            $.post(URL, {'itemid': itemID}, function(data){
                if (data.error) {
                    $.alert(data.status);
                    return;
                }
                $.popup({content: data.content});
            }, 'json');
        }
    });
}
})(jQuery);



/* footnote
----------------------------------------------- */
(function($){
$.fn.footnote = function(){
    return this.each(function(){
        var $root = $(this);
        $('.a', $root).each(function(){
            var $link = $(this),
                href = $('.href', $link).html();
            $link.on('click', function(){
                $.popup();
                $.popup.showLoading();
                $.post(href, function(data){
                    $.popup({content: data.content});
                }, 'json');
            });
        });
    });
};
})(jQuery);



/* button
----------------------------------------------- */
(function($){
$.button = function(){
    $(document).on('mouseenter', '.button .el', function(){
        $(this).closest('.bg').addClass('hover');
    }).on('mouseleave', '.button .el', function(){
        $(this).closest('.bg').removeClass('hover');
    });
};
})(jQuery);



/* shareBar
----------------------------------------------- */
(function($){
$.fn.shareBar = function(){
    return this.each(function(){
        $('.vk', this).html(VK.Share.button(false, {type: 'round', text: 'Like'}));
    });
};
})(jQuery);



/* share
----------------------------------------------- */
(function($){
$.fn.share = function(o){
    o = $.extend({
        showSpeed: 300,
        posSpeed: 200,
        posEasing: 'easeOutExpo'
    }, o || {});
    return this.each(function(){
        var $el = $(this),
            $list = $(),
            itemID = $('.share-itemid', $el).html(),
            URL = $('.share-url', $el).html(),
            title = $('.share-title', $el).html(),
            descr = $('.share-descr', $el).html(),
            image = $('.share-image', $el).html();
        $el.qtip({
            events: {
                render: function(){
                    var html = '';
                    html += '<div class="share-list"><div class="bg"><ul>';
                    html += '<li class="vk"></li>';
                    html += '<li class="fb"><div class="fb-like" data-href="' + URL + '" data-layout="button_count" data-font="tahoma"></div></li>';
                    html += '<li class="twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-text="' + title + '" data-url="' + URL + '" data-lang="en">Tweet</a></li>'
                    html += '<li class="pinit"><a href="http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(URL) + '&amp;media=' + encodeURIComponent(image) + '&amp;description=' + encodeURIComponent(title) + '" class="pin-it-button" count-layout="horizontal"></a></li>'
                    html += '</ul></div><div class="bot"></div></div>';
                    $list = $(html);
                    $el.append($list);
                    $('.vk', $list).html(VK.Share.button(URL, {type: 'round', text: 'Like'}));
                    FB.XFBML.parse($('.fb', $list)[0]);
                    twttr.widgets.load($('.twitter', $list)[0]);
                    pinit.build($('.pinit', $list)[0]);
                }
            },
            content: {
                text: function(){
                    return $list;
                }
            },
            style: {
                tip: false
            },
            show: {
                solo: true,
                delay: 0,
                event: 'click',
                effect: function(offset) {
                    $(this).fadeIn(o.showSpeed);
                    $el.closest('.flips').addClass('flips-open');
                }
            },
            hide: {
                fixed: true,
                delay: 0,
                event: 'unfocus',
                effect: function(offset) {
                    $(this).hide();
                    $el.closest('.flips').removeClass('flips-open');
                }
            },
            position: {
                my: 'top center',
                at: 'bottom center',
                viewport: $(window),
                effect: function(api, pos, viewport) {
                    $(this).animate(pos, {duration: o.posSpeed, easing: o.posEasing, queue: false});
                },
                adjust: {
                    y: 10,
                    method: 'none flipinvert'
            		}
            }
        });
    });
};
})(jQuery);




/* jreel
----------------------------------------------- */
(function($){
$.fn.jreel = function(){
    return this.each(function(){
        var $viewport = $(this),
            viewportWidth = $viewport[0].clientWidth,
            $reel = $('.jreel', $viewport),
            reelWidth = $reel[0].clientWidth;
        if (reelWidth <= viewportWidth) {
            return;
        }
        var $frames = $('.jreel-frame', $reel),
            $gap = $('.jreel-gap', $reel).eq(0),
            gapWidth = $gap[0].clientWidth,
            $cloned = $(),
            clonedWidth = 0,
            left = 0,
            t;
        $frames.each(function(){
            var $frame = $(this);
            $cloned = $cloned.add($gap.clone()).add($frame.clone());
            clonedWidth += gapWidth + $frame[0].clientWidth;
            if (clonedWidth >= viewportWidth) {
                $frames.last().after($cloned);
                return false;
            }
        });
        move();
        function move() {
            t = setTimeout(function(){
                left -= 1;
                if (left + reelWidth + gapWidth <= 0) {
                    left = 0;
                }
                $reel[0].style.left = left + 'px';
                move();
            }, 30);
        }
        function stop() {
            clearTimeout(t);
        }
        $viewport.hover(stop, move);
    });
};
})(jQuery);



/* flips
----------------------------------------------- */
(function($){
$.fn.flips = function(o){
    return this.each(function(){
        var $el = $(this);
        $el.parent().addClass('flips');
        $el.after(
            $('<div class="flips-t" />').append($el.clone()),
            $('<div class="flips-b" />').append($el.clone())
        ).hide();
    });
};
})(jQuery);


/* map
----------------------------------------------- */
(function($){
$.fn.gmap = function(){
    return this.each(function(){
        var canvas = this,
            latlng = $('input[name="latlng"]', this).val().split(','),
            opts = {
                zoom: 13,
                center: new google.maps.LatLng(latlng[0], latlng[1]),
                streetViewControl: true,
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.TOP_LEFT
                },
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.LARGE,
                    position: google.maps.ControlPosition.TOP_LEFT
                },
                panControl: false,
                scaleControl: false,
                rotateControl: false,
                mapTypeControl: false,
                overviewMapControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            },
            map = new google.maps.Map(canvas, opts),
            icon = new google.maps.MarkerImage('/img/shop/map/marker.png', new google.maps.Size(20,31), new google.maps.Point(0,0), new google.maps.Point(10,31)),
            marker = new google.maps.Marker({
                map: map,
                icon: icon,
                position: opts.center
            });
    });
};
})(jQuery);



/* gallery
----------------------------------------------- */
(function($){
$.fn.gallery = function(o){
    o = $.extend({
        speed: 300,
        easing: 'easeOutExpo',
        auto: 7000,
        cyclic: true,
        controlsFade: 100
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $preview = $('.preview', $root),
            $img = $('.preview .img', $root),
            $loading = $('.preview .loading', $root),
            $prev = $('.preview .prev', $root),
            $next = $('.preview .next', $root),
            $zoom = $('.preview .zoom', $root),
            $controls = $zoom,
            busy = false,
            zoomed = false,
            $viewport = $('.thumbs .viewport', $root),
            viewportWidth = $viewport.width(),
            $list = $('.thumbs ul', $root),
            $items = $('.thumbs li', $root),
            $links = $('.thumbs a', $root),
            hrefs = [],
            total = $links.length,
            currentIndex = $links.index($links.filter('.act')),
            itemWidth = $items.width(),
            itemGap = parseInt($items.css('margin-right')),
            listWidth = total * (itemWidth + itemGap) - itemGap,
            currentPos = $viewport.scrollLeft(),
            maxPos = listWidth - viewportWidth,
            $thumbsPrev = $('.thumbs .prev', $root),
            $thumbsNext = $('.thumbs .next', $root),
            thumbsBusy = false;
        $links.each(function(){
            var href = $(this).attr('href');
            hrefs.push({href: href});
        });
        if (total > 1) {
            $controls = $controls.add($prev).add($next);
        }
        $controls.css('opacity', 0).show();
        $preview.hover(
            function(){
                $controls.stop(true).fadeTo(o.controlsFade, 1);
            },
            function(){
                $controls.stop(true).fadeTo(o.controlsFade, 0);
            }
        );
        $zoom.on('click', zoom);
        function zoom() {
            $.fancybox(hrefs, {
                margin: 100,
                padding: 0,
                cyclic: true,
                index: currentIndex,
                overlayColor: '#000',
                overlayOpacity: 0.7,
                onStart: function(){
                    zoomed = true;
                },
                onClosed: function(){
                    zoomed = false;
                }
            });
        }
        if (total < 2) {
            return;
        }
        $(document).on('keydown.gallery', function(e){
            if (!zoomed && (e.which == 37 || e.which == 39) && e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA' && e.target.tagName !== 'SELECT') {
                e.preventDefault();
                if (e.which == 37) {
                    prev();
                } else {
                    next();
                }
            }
        });
        $prev.on('click', prev);
        $next.on('click', next);
        $links.on('click', function(e){
            e.preventDefault();
            var index = $links.index(this);
            view(index);
        });
        function prev() {
            view(currentIndex - 1);
        }
        function next() {
            view(currentIndex + 1);
        }
        function view(index) {
            if (busy || index == currentIndex || !o.cyclic && (index < 0 || index >= total)) {
                return;
            }
            busy = true;
            if (index < 0) {
                index = total - 1;
            } else if (index >= total) {
                index = 0;
            }
            $links.removeClass('act').eq(index).addClass('act');
            $preview.height($preview.height());
            $img.hide();
            $loading.show();
            var img = new Image(),
                src = $links.eq(index).attr('rel');
            img.onload = function(){
                $loading.hide();
                $img.html(img);
                $preview.animate({'height': img.height}, {duration: o.speed, easing: o.easing, queue: false, complete: function(){
                    $img.fadeIn();
                    currentIndex = index;
                    busy = false;
                }});
            };
            img.src = src;
        }
        if (listWidth <= viewportWidth) {
            return;
        }
        $items.last().css('margin-right', 0);
        $list.width(listWidth);
        $thumbsPrev.add($thumbsNext).fadeIn(o.controlsFade).noselect();
        $thumbsPrev.on('click', thumbsPrev);
        $thumbsNext.on('click', thumbsNext);
        function thumbsPrev() {
            var pos = $viewport.scrollLeft() - viewportWidth - itemGap;
            thumbsScroll(pos);
        }
        function thumbsNext() {
            var pos = $viewport.scrollLeft() + viewportWidth + itemGap;
            thumbsScroll(pos);
        }
        function thumbsScroll(pos) {
            if (pos >= maxPos) {
                pos = maxPos;
            } else if (pos <= 0) {
                pos = 0;
            }
            if (thumbsBusy || pos == currentPos) {
                return;
            }
            thumbsBusy = true;
            $thumbsPrev.toggleClass('prev-disabled', (pos == 0));
            $thumbsNext.toggleClass('next-disabled', (pos == maxPos));
            $viewport.animate({'scrollLeft': pos}, {duration: o.speed, easing: o.easing, queue: false, complete: function(){
                currentPos = pos;
                thumbsBusy = false;
            }});
        }
    });
};
})(jQuery);



/* INIT
----------------------------------------------- */
$.popup.defaults.okButton = '<div class="button"><div class="bg"><div class="r"><div class="l"><span class="el">' + lang.popup.okButton + '</span></div></div></div></div>';
$.popup.defaults.cancelButton = '<div class="button"><div class="bg"><div class="r"><div class="l"><span class="el">' + lang.popup.cancelButton + '</span></div></div></div></div>';

$(function(){
    $('label.placeholder').placeholder();
    $('.search').search();
    $('.teaser').teaser();
    $('.catalog-widget').catalogWidget();
    $('.events-block').eventsBlock();
    $('.events-widget').eventsWidget();
    $('.news').news();
    $('.auth').auth({src: '#auth', link: '.auth-link, .fave-auth'});
    $('.recover').recover({src: '#recover', link: '.recover-link'});
    $('.profile').profile({src: '#profile', link: '.profile-link span'});
    $('.up').up();
    $('.currency .jdrop').jdrop({click: false});
    $('.m1 .jdrop').jdrop({click: false, mode: 'menu'});
    $('.h1 .filter .jdrop').jdrop({click: false});
    $('.product').product();
    $('.h1').buy(this);
    $('.comments').comments();
    $('.feedback').feedback();
    $('.input-checkbox').jcheck();
    $('.footnote').footnote();
    $.button();
    $('.catalog .image .img').flips();
    $('.catalog-widget .image .img').flips();
    $('.share').share();
    $('.gmap').gmap();
    $('.share-bar').shareBar();
    $('.gallery').gallery();
});

$(window).load(function(){
    $('.partners').jreel();
});
