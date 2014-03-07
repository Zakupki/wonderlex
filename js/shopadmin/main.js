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
    var $applyInput = $('input[name="apply"]', form),
        $applyButton = $('.apply .el', form),
        validator = $(form).validate({
            rules: o.rules,
            highlight: o.highlight,
            unhighlight: o.unhighlight,
            errorPlacement: o.errorPlacement,
            submitHandler: o.submitHandler
        });
    $applyButton.on('click', function(){
        $applyInput.val(1).trigger('change');
        form.submit();
    });
    return validator;
};
$.form.defaults = {
    rules: {},
    highlight: function(el){
        $(el).closest('.field').addClass('field-error');
    },
    unhighlight: function(el){
        $(el).closest('.field').removeClass('field-error');
    },
    errorPlacement: function(){},
    submitHandler: function(form){
        if (o.ajax) {
            $(form).ajaxSubmit({
                url: o.url || form.action,
                data: typeof o.data == 'function' ? o.data() : o.data,
                dataType: o.dataType,
                beforeSubmit: o.beforeSubmit,
                success: o.success || function(data){
                    o.complete(data);
                    if (data.error) {
                        return;
                    }
                    if (o.reset) {
                        validator.resetForm();
                        $(form).trigger('afterReset');
                    }
                    if (o.reload) {
                        location.reload(true);
                    }
                }
            });
        } else {
            form.submit();
        }
    },
    ajax: false,
    url: '',
    data: {},
    dataType: 'json',
    reset: true,
    reload: false,
    beforeSubmit: function(){},
    success: null,
    complete: function(){}
};
})(jQuery);



/* button
----------------------------------------------- */
(function($){
$.button = function(){
    $(document).on('selectstart', '.button', function(e){
        e.preventDefault();
    }).on('mouseenter', '.button .el', function(){
        $(this).closest('.bg').addClass('hover');
    }).on('mouseleave', '.button .el', function(){
        $(this).closest('.bg').removeClass('hover');
    }).on('mousedown', '.button .el', function(){
        $(this).closest('.bg').addClass('down');
    }).on('mouseup mouseleave', '.button .el', function(){
        $(this).closest('.bg').removeClass('down');
    });
};
})(jQuery);



/* password
----------------------------------------------- */
(function($){
$.fn.password = function(){
    return this.each(function(){
        var $input = $(this),
            $toggle = $input.siblings('.toggle');
        $toggle.on('click', '.show', show).on('click', '.hide', hide);
        function show() {
            $toggle.addClass('visible');
            $input.prop('type', 'text');
        }
        function hide() {
            $toggle.removeClass('visible');
            $input.prop('type', 'password');
        }
    });
};
})(jQuery);



/* jcheckbox
----------------------------------------------- */
(function($){
$.fn.jcheckbox = function(o){
    return this.each(function(){
        var $root = $(this),
            $input = $('input', $root);
        build();
        function change() {
            update();
        }
        function update() {
            $root.toggleClass('jcheckbox-checked', $input.prop('checked'));
        }
        function build() {
            $root.addClass('jcheckbox');
            $('label', $root).append('<i class="input"><i class="i" /></i>');
            $input.off('.jcheckbox').on('change.jcheckbox', change).on('click.jcheckbox update.jcheckbox', update);
            update();
        }
    });
};
})(jQuery);



/* jselect
----------------------------------------------- */
(function($){
$(document).on('click.jselect', function(){
    $('select').trigger('close');
});
$.fn.jselect = function(o){
    o = $.extend({
        width: 'inherit',
        openEvent: 'click',
        extraClass: ''
    }, o || {});
    return this.each(function(){
        var $select = $(this),
            $options = $('option', $select),
            $jselect = $('<div class="jselect"><div class="jselect-title"><div class="jselect-caption"></div><div class="jselect-arrow"></div></div><div class="jselect-list"><div class="jselect-ul"></div></div></div>'),
            $title = $('.jselect-title', $jselect),
            $caption = $('.jselect-caption', $jselect),
            $items = $(),
            t;
        build();
        $jselect.addClass(o.extraClass).on('click.jselect', function(e){
            e.stopPropagation();
        }).noselect();
        if (o.width == 'inherit') {
            $jselect.width($select.width());
        } else {
            $jselect.width(o.width);
        }
        $select.css({'left': -9999, 'position': 'absolute'}).after($jselect).off('.jselect').on('change.jselect', change).on('update.jselect', update).on('build.jselect', build).on('open.jselect', open).on('close.jselect', close).on('enable.jselect', enable).on('disable.jselect', disable);
        $(this.form).on('reset.jselect', update);
        $('.jselect-title', $jselect).on(o.openEvent, function(e){
            e.stopPropagation();
            clearTimeout(t);
            $select.trigger('open');
        });
        if (o.closeDelay >= 0) {
            $jselect.hover(
                function(){
                    clearTimeout(t);
                },
                function(){
                    t = setTimeout(function(){
                        $select.trigger('close');
                    }, o.closeDelay);
                }
            );
        }
        function open() {
            $('select').not($select).trigger('close');
            if ($select.prop('disabled')) {
                return;
            }
            $jselect.addClass('jselect-open');
        }
        function close() {
            $jselect.removeClass('jselect-open');
        }
        function change() {
            update();
            close();
        }
        function update() {
            var selectedIndex = $select.prop('selectedIndex'),
                $selectedOption = $options.eq(selectedIndex);
            $caption.html($selectedOption.html() || '&nbsp;');
            $title.toggleClass('jselect-title-disabled', $selectedOption.prop('disabled'));
            $items.each(function(index){
                $(this).toggleClass('jselect-li-selected', index == selectedIndex).toggleClass('jselect-li-disabled', $options.eq(index).prop('disabled'));
            });
            $jselect.toggleClass('jselect-disabled', $select.prop('disabled'));
        }
        function build() {
            $options.each(function(index){
                var $option = $(this),
                    $item = $('<div />', {
                        'class': 'jselect-li',
                        'html': $option.html() || '&nbsp;',
                        'click': function(){
                            $select.prop('selectedIndex', index).trigger('change');
                        }
                    });
                $items = $items.add($item);
            });
            $('.jselect-ul', $jselect).html($items);
            update();
        }
        function enable() {
            $select.prop('disabled', false);
            update();
        }
        function disable() {
            $select.prop('disabled', true);
            update();
        }
    });
};
})(jQuery);



/* jdrop
----------------------------------------------- */
(function($){
$(document).on('click.jdrop', function(){
    $('.jdrop').trigger('jdrop-close');
});
$.fn.jdrop = function(o){
    o = $.extend({
        mode: 'menu',
        width: 'auto',
        open: {
            event: 'mouseenter',
            delay: 100
        },
        close: {
            event: 'mouseleave',
            delay: 500
        }
    }, o || {});
    return this.each(function(){
        var $jdrop = $(this),
            $title = $('.jdrop-title', $jdrop),
            $caption = $('.jdrop-caption', $jdrop),
            $list = $('.jdrop-list', $jdrop),
            $items = $('li', $jdrop),
            width = o.width,
            t;
        $('ul', $jdrop).addClass('jdrop-ul');
        $('li', $jdrop).addClass('jdrop-li');
        if (typeof o.width == 'function') {
            width = o.width($jdrop);
        }
        $list.width(width);
        $jdrop.on('jdrop-open', open).on('jdrop-close', close);
        $jdrop.on(o.open.event, function(){
            clearTimeout(t);
            t = setTimeout(function(){
                $jdrop.trigger('jdrop-open');
            }, o.open.delay);
        }).on('click', function(e){
            e.stopPropagation();
        });
        if (o.close.event != 'unfocus') {
            $jdrop.on(o.close.event, function(){
                clearTimeout(t);
                t = setTimeout(function(){
                    $jdrop.trigger('jdrop-close');
                }, o.close.delay);
            });
        }
        $items.each(function(){
            var $item = $(this),
                text = $('a', $item).html() || $item.html();
            $item.on('click', function(e){
                e.stopPropagation();
                if (o.mode == 'select') {
                    select(text);
                }
                $jdrop.trigger('jdrop-close');
            });
        });
        function open() {
            $('.jdrop').not($jdrop).trigger('jdrop-close');
            if (typeof o.width == 'function') {
                width = o.width($jdrop);
            }
            $list.width(width);
            $jdrop.addClass('jdrop-open');
        }
        function close() {
            $jdrop.removeClass('jdrop-open');
        }
        function select(text) {
            $caption.html(text);
        }
    });
};
})(jQuery);



/* multiling
----------------------------------------------- */
(function($){
$.fn.multiling = function(){
    return this.each(function(){
        var $root = $(this),
            $select = $('.multiling-select select', $root),
            $items = $('.multiling-item', $root),
            currentIndex = $items.index($items.filter('.multiling-current')),
            $inputs = $('input, textarea', $items),
            $label = $('label[for="' + $inputs.eq(currentIndex).attr('id') + '"]');
        $select.jselect().on('change', function(){
            show($select.prop('selectedIndex'));
        });
        function show(index) {
            if (index == currentIndex) {
                return;
            }
            $root.height($root.height());
            $items.hide().eq(index).show();
            $root.height('');
            $label.attr('for', $inputs.eq(index).attr('id'));
            currentIndex = index;
        }
    });
};
})(jQuery);



/* editor
----------------------------------------------- */
(function($){
$.fn.editor = function(o){
    o = $.extend({
        toolbar: true,
        buttons: ['bold', 'formatting', 'link', 'image', 'video', 'fullscreen', 'html']
    }, o || {});
    return this.each(function(){
        var $textarea = $(this),
            $form = $textarea.closest('form'),
            cssURL = $('input[name="redactor_css"]', $form).val(),
            imageUploadURL = $('input[name="redactor_image_upload"]', $form).val(),
            imageRemoveURL = $('input[name="redactor_image_remove"]', $form).val(),
            imagesURL = $('input[name="redactor_images"]', $form).val(),
            buttons = $('input[name="redactor_buttons"]', $form).val(),
            maxWidth = $('input[name="redactor_max_width"]', $form).val() || 0;
        buttons = buttons ? buttons.split(',') : o.buttons;
        var params = {
                lang: LANG,
                xhtml: true,
                resize: false,
                removeStyles: true,
                path: BASE,
                css: cssURL,
                imageUpload: imageUploadURL,
                imageRemove: imageRemoveURL,
                imageGetJson: imagesURL,
                buttons: buttons,
                maxWidth: maxWidth
            };
        if (!o.toolbar) {
            params.toolbar = false;
        }
        $('textarea', this).redactor(params);
    });
};
})(jQuery);



/* inputImage
----------------------------------------------- */
(function($){
$.fn.inputImage = function(o){
    o = $.extend({
        speed: 300
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $form = $root.closest('form'),
            $preview = $('.preview', $root),
            $bg = $('.bg', $preview),
            $img = $('.img', $preview),
            $remove = $('.remove', $preview),
            $loading = $('.loading', $preview),
            $newInput = $('input[name*="_new"]', $root),
            $removedInput = $('input[name*="_removed"]', $root),
            $fileInput = $('input[name*="_file"]', $root),
            itemID = $('input[name="itemid"]', $form).val() || 0,
            uploader = $('input[name*="_uploader"]', $root).val(),
            cropper = $('input[name*="_cropper"]', $root).val(),
            size = $('input[name*="_size"]', $root).val() || 0,
            ratio = eval($('input[name*="_ratio"]', $root).val()) || 0,
            minW = $('input[name*="_min_w"]', $root).val() || 0,
            minH = $('input[name*="_min_h"]', $root).val() || 0,
            maxW = $('input[name*="_max_w"]', $root).val() || 0,
            maxH = $('input[name*="_max_h"]', $root).val() || 0;
        $remove.on('click', remove);
        $fileInput.upload({
            uploader: uploader,
            fileTypeExts: '*.jpg; *.jpeg; *.gif; *.png',
            formData: {
                itemid: itemID,
                size: size,
                min_w: minW,
                min_h: minH,
                max_w: maxW,
                max_h: maxH
            },
            complete: function(files, errors){
                if (errors.length) {
                    $.alert({text: errors[0].status});
                    return;
                }
                if (cropper) {
                    $.crop({
                        cropper: cropper,
                        min: [minW, minH],
                        ratio: ratio,
                        file: files[0].src_file,
                        data: {
                            itemid: itemID,
                            size: size,
                            min_w: minW,
                            min_h: minH,
                            max_w: maxW,
                            max_h: maxH
                        },
                        complete: function(data){
                            preview(data.file);
                        }
                    });
                } else {
                    preview(files[0].file);
                }
            }
        });
        function remove() {
            $.confirm({
                text: lang.imageRemoveConfirm,
                afterOk: function(){
                    $bg.add($img).fadeOut(o.speed, function(){
                        $preview.addClass('empty');
                        $bg.css('background-image', '');
                        $img.empty();
                    });
                    $newInput.val('').trigger('change');
                    $removedInput.val(1).trigger('change');
                }
            });
        }
        function preview(file) {
            $.popup.close();
            $preview.removeClass('empty').width($preview.width()).height($preview.height());
            $bg.hide().css('background-image', 'url(' + file + ')');
            $img.hide().html($('<img src="' + file + '" alt="" />'));
            var img = new Image();
            img.onload = function(){
                $loading.hide();
                $bg.fadeIn(o.speed);
                $img.fadeIn(o.speed);
                $preview.width('').height('');
            };
            img.src = file;
            if (!img.complete) {
                $loading.show();
            }
            $newInput.val(file).trigger('change');
        }
    });
};
})(jQuery);



/* inputImages
----------------------------------------------- */
(function($){
$.fn.inputImages = function(o){
    o = $.extend({
        speed: 300,
        multi: true
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $form = $root.closest('form'),
            $list = $('.list', $root),
            $preview = $('.preview', $root),
            $bg = $('.bg', $preview),
            $img = $('.img', $preview),
            $edit = $('.edit', $preview),
            $loading = $('.loading', $preview),
            $fileInput = $('input[name*="_file"]', $root),
            $tpl = $('.tpl', $root),
            $trash = $('.trash', $root),
            itemID = $('input[name="itemid"]', $form).val() || 0,
            uploader = $('input[name*="_uploader"]', $root).val(),
            cropper = $('input[name*="_cropper"]', $root).val() || '',
            size = $('input[name*="_size"]', $root).val() || 0,
            minW = $('input[name*="_min_w"]', $root).val() || 0,
            minH = $('input[name*="_min_h"]', $root).val() || 0,
            maxW = $('input[name*="_max_w"]', $root).val() || 0,
            maxH = $('input[name*="_max_h"]', $root).val() || 0,
            previewSize = $('input[name*="_preview_size"]', $root).val() || 0,
            previewRatio = eval($('input[name*="_preview_ratio"]', $root).val()) || 0,
            previewMinW = $('input[name*="_preview_min_w"]', $root).val() || 0,
            previewMinH = $('input[name*="_preview_min_h"]', $root).val() || 0,
            previewMaxW = $('input[name*="_preview_max_w"]', $root).val() || 0,
            previewMaxH = $('input[name*="_preview_max_h"]', $root).val() || 0,
            name = $('input[type="radio"]', $tpl).attr('name'),
            ID = $('input[type="radio"]', $tpl).attr('id');
        $edit.on('click', edit);
        $list.on('change', 'input[name="' + name + '"]', change).on('click', '.remove', remove).sortable({items: '.li', handle: 'label', tolerance: 'pointer'});
        $fileInput.upload({
            multi: o.multi,
            uploader: uploader,
            fileTypeExts: '*.jpg; *.jpeg; *.gif; *.png',
            formData: {
                itemid: itemID,
                size: size,
                min_w: minW,
                min_h: minH,
                max_w: maxW,
                max_h: maxH,
                preview_size: previewSize,
                preview_min_w: previewMinW,
                preview_min_h: previewMinH,
                preview_max_w: previewMaxW,
                preview_max_h: previewMaxH
            },
            success: function(data){
                if (data.error) {
                    return;
                }
                var $item = $tpl.clone(),
                    isFirst = $('.li', $list).length ? false : true,
                    index = getLastIndex() + 1;
                $item.removeClass('tpl');
                $('label', $item).attr('for', ID + index).toggleClass('checked', isFirst).css('background-image', 'url(' + data.file + ')');
                $('input[name="' + name + '"]', $item).attr('id', ID + index).prop('checked', isFirst).val(index).trigger('change');
                $('input[name*="_id["]', $item).attr('name', name + '_id[' + index + ']').val('').trigger('change');
                $('input[name*="_src["]', $item).attr('name', name + '_src[' + index + ']').val(data.src_file).trigger('change');
                $('input[name*="_tn["]', $item).attr('name', name + '_tn[' + index + ']').val(data.file).trigger('change');
                $('input[name*="_preview["]', $item).attr('name', name + '_preview[' + index + ']').val(data.preview_file).trigger('change');
                $('input[name*="_preview_new["]', $item).attr('name', name + '_preview_new[' + index + ']').val('').trigger('change');
                $('input[name*="_removed["]', $item).attr('name', name + '_removed[' + index + ']').val(0).trigger('change');
                if (isFirst) {
                    preview(data.preview_file);
                    $list.add($preview).removeClass('empty');
                }
                $list.append($item.hide().fadeIn(o.speed));
            },
            complete: function(files, errors){
                if (errors.length) {
                    $.alert({text: lang.upload.errors});
                } else {
                    $.popup.close();
                }
            }
        });
        function edit() {
            var index = $('input[name="' + name + '"]:checked', $list).val(),
                src = $('input[name*="_src[' + index + ']"]', $list).val(),
                $previewNewInput = $('input[name*="_preview_new[' + index + ']"]', $list);
            $.crop({
                cropper: cropper,
                min: [previewMinW, previewMinH],
                ratio: previewRatio,
                file: src,
                data: {itemid: itemID, size: previewSize, edit: 1},
                complete: function(data){
                    $.popup.close();
                    preview(data.file);
                    $previewNewInput.val(data.file).trigger('change');
                }
            });
        }
        function change() {
            var $input = $(this);
            if (!$input.prop('checked')) {
                return;
            }
            $('label', $list).removeClass('checked');
            $input.siblings('label').addClass('checked');
            var file = $input.siblings('input[name*="_preview["]').val(),
                fileNew = $input.siblings('input[name*="_preview_new["]').val();
            preview(fileNew || file);
        }
        function remove() {
            var $item = $(this).closest('.li'),
                $firstItem = $('.li', $list).not($item).first();
            $.confirm({
                text: lang.imageRemoveConfirm,
                afterOk: function(){
                    $item.fadeOut(o.speed, function(){
                        $item.appendTo($trash);
                        $('input[name*="_removed"]', $item).val(1).trigger('change');
                        $('input[name*="_new"]', $item).val('').trigger('change');
                        if ($firstItem.length) {
                            if ($('input[name="' + name + '"]', $item).prop('checked')) {
                                $('label', $firstItem).addClass('checked');
                                $('input[name="' + name + '"]', $firstItem).prop('checked', true).change();
                            }
                        } else {
                            $list.add($preview).addClass('empty');
                        }
                    });
                }
            });
        }
        function preview(file) {
            if (!file) {
                $bg.hide().css('background-image', '').fadeIn(o.speed);
                $img.hide().empty().fadeIn(o.speed);
                return;
            }
            $preview.removeClass('empty').width($preview.width()).height($preview.height());
            $bg.hide().css('background-image', 'url(' + file + ')');
            $img.hide().html($('<img src="' + file + '" alt="" />'));
            var img = new Image();
            img.onload = function(){
                $loading.hide();
                $bg.fadeIn(o.speed);
                $img.fadeIn(o.speed);
                $preview.width('').height('');
            };
            img.src = file;
            if (!img.complete) {
                $loading.show();
            }
        }
        function getLastIndex() {
            var lastIndex = 0;
            $('.list input[type="radio"], .trash input[type="radio"]', $root).each(function(){
                var index = parseInt(this.value);
                lastIndex = index > lastIndex ? index : lastIndex;
            });
            return lastIndex;
        }
    });
};
})(jQuery);



/* upload
----------------------------------------------- */
(function($){
$.fn.upload = function(o){
    var o = $.extend({
        auto: true,
        debug: false,
        preventCaching: false,
        swf: BASE + 'swf/uploadify.swf',
        uploader: '',
        width: '100%',
        height: '100%',
        multi: false,
        formData: {},
        fileTypeExts: '*.*',
        success: function(){},
        complete: function(){
            $.popup.close();
        }
    }, o || {});
    return this.each(function(){
        var $input = $(this),
            files = [],
            errors = [];
    		$input.uploadify({
    		    auto: o.auto,
    		    debug: o.debug,
            preventCaching: o.preventCaching,
            swf: o.swf,
            uploader: o.uploader,
            width: o.width,
            height: o.height,
            multi: o.multi,
            formData: o.formData,
            fileTypeExts: o.fileTypeExts,
            onDialogClose: function(){
                files = [];
                errors = [];
            },
            onUploadStart: function(){
                $.popup({
                    afterShowOverlay: function(){
                        $.popup.showLoading();
                    },
                    beforeClose: function(){
                        $input.uploadify('cancel');
                    }
                });
            },
            onUploadSuccess: function(file, data) {
                data = $.parseJSON(data);
                files.push(data);
                if (data.error) {
                    errors.push(data);
                }
                o.success(data);
            },
            onQueueComplete: function(){
                o.complete(files, errors);
            }
        });
    });
};
})(jQuery);



/* crop
----------------------------------------------- */
(function($){
$.crop = function(o){
    o = $.extend({
        cropper: '',
        file: '',
        min: [0, 0],
        ratio: 0,
        size: 0,
        data: {},
        complete: function(){
            $.popup.close();
        }
    }, o || {});
    $.popup();
    $.popup.showLoading();
    var img = new Image();
    img.onload = function(){
        var $img = $(img),
            zoom = 1,
            min = o.min,
            imgWidth = img.width,
            imgHeight = img.height,
            maxImgWidth = document.documentElement.clientWidth - 200,
            maxImgHeight = document.documentElement.clientHeight - 255;
        if (imgWidth > maxImgWidth || imgHeight > maxImgHeight) {
            if (maxImgWidth / imgWidth < maxImgHeight / imgHeight) {
                zoom = maxImgWidth / imgWidth;
            } else {
                zoom = maxImgHeight / imgHeight;
            }
            min[0] = Math.floor(min[0] * zoom);
            min[1] = Math.floor(min[1] * zoom);
            imgWidth = Math.floor(img.width * zoom);
            imgHeight = Math.floor(img.height * zoom);
        }
        img.width = imgWidth;
        img.height = imgHeight;
        var x = 0,
            y = 0,
            x2 = imgWidth,
            y2 = imgHeight;
        if (o.ratio) {
            var width = imgWidth,
                height = imgHeight;
            if (height * o.ratio > width) {
                height = Math.floor(width / o.ratio);
                y = Math.floor(imgHeight / 2 - height / 2);
                y2 = y + height;
            } else {
                width = Math.floor(height * o.ratio);
                x = Math.floor(imgWidth / 2 - width / 2);
                x2 = x + width;
            }
        }
        var area = [x, y, x2 - x, y2 - y];
        $.confirm({
            extraClass: 'crop-popup',
            content: $img,
            okButton: '',
            cancelButton: '',
            beforeShowWindow: function(){
                $img.Jcrop({
                    handleSize: 11,
                    handleOpacity: 1,
                    createHandles: ['nw','ne','se','sw'],
                    drawBorders: false,
                    aspectRatio: o.ratio,
                    minSize: min,
                    setSelect: [x, y, x2, y2],
                    onSelect: function(c) {
                        area = {
                            x: c.x,
                            y: c.y,
                            width: c.w,
                            height: c.h
                        }
                    }
                });
            },
            ok: function(){
                $.popup.hideWindow(function(){
                    $.popup.showLoading();
                    for (i in area) {
                        area[i] = Math.floor(area[i] / zoom);
                    };
                    var data = $.extend({
                            file: o.file,
                            x: area.x,
                            y: area.y,
                            width: area.width,
                            height: area.height
                        }, o.data);
                    $.post(o.cropper, data, function(data) {
                        if (data.error) {
                            $.alert({text: data.status});
                            return;
                        }
                        o.complete(data);
                    }, 'json');
                });
            }
        });
    };
    img.src = o.file;
};
})(jQuery);



/* inputColor
----------------------------------------------- */
(function($){
$.fn.inputColor = function(o){
    return this.each(function(){
        var $root = $(this),
            $input = $('input', $root),
            $sample = $('.sample', $root),
            $picker = $('.picker', $root),
            colorpicker = $picker.colorpicker({
                color: $input.val(),
                parts: ['map', 'bar'],
                select: function(e, color){
                    $input.val(color.formatted).trigger('change.color');
                    $sample.css('background', color.formatted);
                }
            }).data('colorpicker');
        $input.on('change', function(){
            colorpicker.setColor(this.value);
        }).data('colorpicker', colorpicker);
        $input.qtip({
            content: {
                text: $picker
            },
            show: {
                event: 'click',
                target: $input
            },
            hide: {
                event: 'unfocus'
            },
            position: {
                my: 'left center',
                at: 'right center',
                adjust: {
                    x: 10
                },
                viewport: $(window)
            },
            style: {
                tip: {
                    corner: true,
                    mimic: 'center',
                    border: 0,
                    width: 9,
                    height: 5
                }
            }
        });
    });
};
})(jQuery);



/* inputDate
----------------------------------------------- */
(function($){
$.fn.inputDate = function(){
    return this.each(function(){
        var $root = $(this),
            $input = $('input', $root),
            $picker = $('.picker', $root),
            datepicker = $picker.datepicker({
                prevText: '',
                nextText: '',
                onSelect: function(dateText, inst) {
                    $input.val(dateText);
                }
            }).data('datepicker');
        $input.on('change', function(){
            datepicker.setDate(this.value);
        }).data('datepicker', datepicker);
        $input.qtip({
            content: {
                text: $picker
            },
            show: {
                event: 'click',
                target: $input
            },
            hide: {
                event: 'unfocus'
            },
            position: {
                my: 'left top',
                at: 'right center',
                adjust: {
                    x: 10,
                    y: -83
                },
                viewport: $(window)
            },
            style: {
                classes: 'ui-date-tooltip',
                tip: {
                    corner: true,
                    mimic: 'center',
                    border: 0,
                    width: 9,
                    height: 5
                }
            }
        });
    });
};
})(jQuery);



/* jtable
----------------------------------------------- */
(function($){
$.fn.jtable = function(o){
    o = $.extend({
        speed: 150,
        onInit: function(){},
        onActivate: function(){},
        onRemove: function(){},
        onSort: function(){},
        onAddPlaceholder: function(){},
        onRemovePlaceholder: function(){}
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $tbody = $('.tbody', $root).last(),
            $tpl = $('.tpl', $root),
            $trash = $('.trash', $root);
        $tbody.on('focus', '.placeholder input[type="text"]', function(){
            var $item = $(this).closest('.tr');
            $item.removeClass('placeholder');
            o.onRemovePlaceholder($item);
        }).on('blur', '.empty input[type="text"]', function(){
            var $item = $(this).closest('.tr');
            $item.addClass('placeholder');
            o.onAddPlaceholder($item);
        }).on('keyup', '.empty input[type="text"]', function(){
            if (this.value) {
                add();
            }
            o.onActivate($(this).closest('.tr'));
        }).on('change', '.empty input', function(){
            add();
        })
        $('.sortable', $root).sortable({
            axis: 'y',
            items: '.tr',
            revert: o.speed,
            handle: '.handle',
            tolerance: 'pointer',
            containment: 'parent',
            update: function(e, ui){
                var $items = $('.tr', this).not('.empty');
                $items.removeClass('first last');
                $items.first().addClass('first');
                $items.last().addClass('last');
                o.onSort(e, ui);
            }
        });
        $('.tr', $tbody).each(function(){
            init($(this));
        });
        function init($item) {
            var $remove = $('.remove .i', $item),
                $removeInput = $('input[name^="remove"]', $item),
                $state = $('.state', $item),
                $stateInput = $('input[name^="state"]', $item);
            $remove.on('click', function(){
                remove($item, $removeInput);
            });
            $state.on('click', '.enable', function(){
                  enable($state, $stateInput);
            }).on('click', '.disable', function(){
                  disable($state, $stateInput);
            });
            o.onInit($item);
        }
        function add() {
            $('.empty', $tbody).removeClass('placeholder empty');
            var $items = $('.tr', $tbody);
            if ($items.length > 1) {
                $items.removeClass('single first last');
                $items.first().addClass('first');
                $items.last().addClass('last');
            } else {
                $items.addClass('single');
            }
            var $item = $tpl.clone().removeClass('tpl'),
                index = getLastIndex() + 1;
            $tbody.append($item.hide().fadeIn(o.speed));
            $('input', $item).each(function(){
                this.name = this.name.replace('[]', '[' + index + ']');
                if (this.id) {
                    this.id = this.id + index;
                }
            });
            init($item);
        }
        function remove($item, $removeInput) {
            $.confirm({
                text: lang.jtable.removeConfirm,
                afterOk: function(){
                    $item.fadeOut(o.speed, function(){
                        var itemID = $('input[name^="itemid"]', $item).val();
                        if (itemID && $trash.length) {
                            $item.appendTo($trash);
                            $removeInput.val(1);
                        } else {
                            $item.remove();
                        }
                        var $items = $('.tr', $tbody).not('.empty');
                        if ($items.length > 1) {
                            $items.removeClass('first last');
                            $items.first().addClass('first');
                            $items.last().addClass('last');
                        } else {
                            $items.addClass('single');
                        }
                        o.onRemove($item);
                    });
                }
            });
        }
        function enable($state, $stateInput) {
            $state.removeClass('disabled');
            $stateInput.val(1);
        }
        function disable($state, $stateInput) {
            $state.addClass('disabled');
            $stateInput.val(0);
        }
        function getLastIndex() {
            var lastIndex = 0;
            $('input[name^="itemid"]', $tbody).each(function(){
                var index = parseInt(this.name.substr(7));
                if (index > lastIndex) {
                    lastIndex = index;
                }
            });
            return lastIndex;
        }
    });
};
})(jQuery);



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
        speed: 300,
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



/* SETTINGS
----------------------------------------------- */
/* accountSettings
----------------------------------------------- */
(function($){
$.fn.accountSettings = function(o){
    o = $.extend({
        speed: 300
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $form = $root.closest('form');
        $('.select select', $root).jselect();
        $('.multiling', $root).multiling();
        $('.input-image', $root).inputImage();
        formInit();
        langInit();
        currencyInit();
        locationInit();
        mapInit();
        function formInit() {
            var $passwordInput = $('input[name="password"]', $root),
                $newPasswordInput = $('input[name="new_password"]', $root),
                $repeatNewPasswordInput = $('input[name="repeatnew_password"]', $root);
            $form.form({
                rules: {
                    password: {
                        required: function(){
                            return $newPasswordInput.val() > '' || $repeatNewPasswordInput.val() > '';
                        }
                    },
                    repeatnew_password: {
                        equalTo: $newPasswordInput
                    }
                }
            });
        }
        function langInit() {
            var $available = $('input:checkbox[name^="language["]', $root),
                $default = $('select[name="default_language"]', $root),
                $defaultField = $('.default-language-field', $root);
            $available.each(function(index){
                $(this).on('change', function(){
                    updateDefault(index);
                });
            });
            $default.on('change', function(){
                updateAvailable($default.prop('selectedIndex'));
            });
            function updateDefault(index) {
                $default.prop('disabled', !$available.filter(':checked').length).trigger('update');
                if ($available.eq($default.prop('selectedIndex')).prop('checked')) {
                    return;
                }
                $available.each(function(i){
                    if ($(this).prop('checked')) {
                        $default.prop('selectedIndex', i).trigger('update');
                        return false;
                    }
                });
            }
            function updateAvailable(index) {
                $available.eq(index).prop('checked', true).trigger('update');
            }
        }
        function currencyInit() {
            var $available = $('input:checkbox[name^="currency["]', $root),
                $default = $('select[name="default_currency"]', $root),
                $defaultField = $('.default-currency-field', $root);
            $available.each(function(index){
                $(this).on('change', function(){
                    updateDefault(index);
                });
            });
            $default.on('change', function(){
                updateAvailable($default.prop('selectedIndex'));
            });
            function updateDefault(index) {
                $default.prop('disabled', !$available.filter(':checked').length).trigger('update');
                if ($available.eq($default.prop('selectedIndex')).prop('checked')) {
                    return;
                }
                $available.each(function(i){
                    if ($(this).prop('checked')) {
                        $default.prop('selectedIndex', i).trigger('update');
                        return false;
                    }
                });
            }
            function updateAvailable(index) {
                $available.eq(index).prop('checked', true).trigger('update');
            }
        }
        function locationInit() {
            var countriesURL = $('input[name="countries_url"]').val(),
                $countryTitleInput = $('input[name="country[title]"]', $root),
                $countryIDInput = $('input[name="country[id]"]', $root),
                citiesURL = $('input[name="cities_url"]').val(),
                $cityField = $('.city-field', $root),
                $cityTitleInput = $('input[name="city[title]"]', $root),
                $cityIDInput = $('input[name="city[id]"]', $root);
            $countryTitleInput.autocomplete({
                source: countriesURL,
                minLength: 2,
                autoFocus: true,
                open: function () {
                    $countryTitleInput.addClass('autocomplete').autocomplete('widget').css('z-index', 100);
                },
                close: function() {
                    $countryTitleInput.removeClass('autocomplete');
                },
                focus: function(e) {
                    e.preventDefault();
                },
                select: function(e, ui) {
                    e.preventDefault();
                    $countryTitleInput.val(ui.item.label);
                    $countryIDInput.val(ui.item.value);
                    $cityTitleInput.addClass('placeholder').val($cityTitleInput.data('placeholder')).autocomplete('option', 'source', citiesURL + '?country_id=' + ui.item.value);
                    $cityIDInput.val(0);
                    $cityField.fadeIn(o.speed);
                },
                change: function(e, ui) {
                    if (ui.item) {
                        $cityTitleInput.fadeIn(o.speed);
                    } else {
                        $countryTitleInput.addClass('placeholder').val($countryTitleInput.data('placeholder'));
                        $countryIDInput.val(0);
                        $cityField.fadeOut(o.speed);
                    }
                }
            }).on('focus', function(){
                $countryTitleInput.autocomplete('search');
            });
            $cityTitleInput.autocomplete({
                source: citiesURL + '?country_id=' + $countryIDInput.val(),
                minLength: 2,
                autoFocus: true,
                open: function () {
                    $cityTitleInput.addClass('autocomplete').autocomplete('widget').css('z-index', 100);
                },
                close: function() {
                    $cityTitleInput.removeClass('autocomplete');
                },
                focus: function(e) {
                    e.preventDefault();
                },
                select: function(e, ui) {
                    e.preventDefault();
                    $cityTitleInput.val(ui.item.label);
                    $cityIDInput.val(ui.item.value);
                },
                change: function(e, ui) {
                    if (!ui.item) {
                        $cityTitleInput.addClass('placeholder').val($cityTitleInput.data('placeholder'));
                        $cityIDInput.val(0);
                    }
                }
            }).on('focus', function(){
                $cityTitleInput.autocomplete('search');
            });
        }
        function mapInit() {
            var $field = $('.address-field', $root),
                $langSelect = $('.multiling-select select', $field),
                currentIndex = $langSelect.prop('selectedIndex'),
                $wrap = $('.maps', $field),
                $maps = $('.map', $wrap);
            $langSelect.on('change', function(){
                var index = $langSelect.prop('selectedIndex');
                if (index == currentIndex) {
                    return;
                }
                $wrap.height($wrap.height());
                $maps.eq(currentIndex).removeClass('map-current');
                $maps.eq(index).hide().addClass('map-current').fadeIn(o.speed);
                $wrap.height(''); 
                currentIndex = index;
            });
        }
    });
};
})(jQuery);



/* designSettings
----------------------------------------------- */
(function($){
$.fn.designSettings = function(){
    return this.each(function(){
        var $root = $(this),
            $headerList = $('.header-field .list', $root),
            $headerPreview = $('.header-field .preview .bg, .header-field .preview .img', $root);
        $('form', $root).form();
        $('select', $root).jselect();
        $('.multiling', $root).multiling();
        $('.input-image', $root).inputImage();
        $('.input-images', $root).inputImages();
        $('.input-color', $root).inputColor();
        $('input[name="main_color"]', $root).on('change.color', function(){
            $headerPreview.add($('label', $headerList)).css('background-color', this.value);
        });
    });
};
})(jQuery);



/* menuSettings
----------------------------------------------- */
(function($){
$.fn.menuSettings = function(){
    return this.each(function(){
        $('.table', this).jtable({
            onInit: function($item){
                $('.multiling', $item).multiling();
            }
        });
    });
};
})(jQuery);



/* categoriesSettings
----------------------------------------------- */
(function($){
$.fn.categoriesSettings = function(){
    return this.each(function(){
        var $root = $(this),
            $form = $root.closest('form');
        $('.table', $root).jtable({
            onInit: function($item){
                $('.multiling', $item).multiling();
            },
            onActivate: function($item){
                $('input[name^="title"]', $item).addClass('required');
                $('input[name^="url"]', $item).addClass('unique unique-url required');
            },
            onRemove: function($item){
                $('input[name^="title"]', $item).removeClass('required');
                $('input[name^="url"]', $item).removeClass('unique unique-url required');
            },
            onAddPlaceholder: function($item){
                $('select', $item).trigger('disable.jselect');
            },
            onRemovePlaceholder: function($item){
                $('select', $item).trigger('enable.jselect');
            }
        });
        $form.form({
            highlight: function(el){
                $(el).closest('.title, .url').addClass('field-error');
            },
            unhighlight: function(el){
                $(el).closest('.title, .url').removeClass('field-error');
            }
        });
    });
};
})(jQuery);




/* partnersSettings
----------------------------------------------- */
(function($){
$.fn.partnersSettings = function(o){
    return this.each(function(){
        var $root = $(this),
            uploader = $('input[name="image_uploader"]', $root).val(),
            maxW = $('input[name="image_max_w"]', $root).val(),
            maxH = $('input[name="image_max_h"]', $root).val();
        $('.table', $root).jtable({
            onInit: function($item) {
                var $img = $('.img', $item),
                    $newInput = $('input[name^="image_new"]', $item),
                    $fileInput = $('input[name^="image_file"]', $item);
                $fileInput.upload({
                    uploader: uploader,
                    formData: {max_w: maxW, max_h: maxH},
                    fileTypeExts: '*.jpg; *.jpeg; *.gif; *.png',
                    complete: function(files, errors){
                        $.popup.close();
                        $img.html('<img src="' + files[0].file + '" alt="" />').removeClass('na');
                        $newInput.val(files[0].file).trigger('change');
                    }
                });
            }
        });
    });
};
})(jQuery);



/* bnSettings
----------------------------------------------- */
(function($){
$.fn.bnSettings = function(o){
    o = $.extend({
        speed: 300,
        easing: 'easeOutExpo'
    }, o || {});
    return this.each(function(){
        var $root = $(this),
            $form = $root.closest('form'),
            $image = $('.image', $root),
            uploader = $('input[name="image_uploader"]', $root).val(),
            cropper = $('input[name="image_cropper"]', $root).val(),
            $newInput = $('input[name="image_new"]', $root),
            $fileInput = $('input[name="image_file"]', $root),
            $URLInput = $('input[name="url"]', $root);
        $fileInput.upload({
            uploader: uploader,
            fileTypeExts: '*.jpg; *.jpeg; *.gif; *.png; *.swf',
            complete: function(files, errors){
                if (files[0].extension == 'swf') {
                    $.popup.close();
                    $image.html('<object width="' + files[0].width + '" height="' + files[0].height + '" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"><param name="movie" value="' + files[0].file + '" /><!--[if !IE]>--><object data="' + files[0].file + '" width="' + files[0].width + '" height="' + files[0].height + '" type="application/x-shockwave-flash"></object><!--<![endif]--></object>').removeClass('na');
                    $newInput.val(files[0].file);
                } else {
                    $.crop({
                        cropper: cropper,
                        file: files[0].file,
                        complete: function(data){
                            $.popup.close();
                            var href = $URLInput.val();
                            if (href) {
                                $image.html('<a href="' + href + '" target="_blank"><img src="' + data.file + '" alt="" /></a>');
                            } else {
                                $image.html('<img src="' + data.file + '" alt="" />');
                            }
                            $image.removeClass('na');
                            $newInput.val(data.file);
                        }
                    });
                }
            }
        });
        $('.input-color', $root).inputColor();
        $('.input-color input', $root).on('change.color', function(){
            $image.css('background-color', this.value);
        });
        $('input[name="url"]', $root).on('change', function(){
            var href = this.value,
                $img = $('img', $image);
            if (href) {
                $image.html($('<a href="' + href + '" target="_blank" />').html($img));
            } else {
                $image.html($img);
            }
        });
    });
};
})(jQuery);



/* howtobuySettings
----------------------------------------------- */
(function($){
$.fn.howtobuySettings = function(){
    return this.each(function(){
        var $root = $(this);
        $('.multiling', this).multiling();
    });
};
})(jQuery);



/* agreementSettings
----------------------------------------------- */
(function($){
$.fn.agreementSettings = function(){
    return this.each(function(){
        $('.multiling', this).multiling();
    });
};
})(jQuery);



/* CONTENT
----------------------------------------------- */
/* about
----------------------------------------------- */
(function($){
$.fn.about = function(){
    return this.each(function(){
        $('.multiling', this).multiling();
    });
};
})(jQuery);



/* services
----------------------------------------------- */
(function($){
$.fn.services = function(){
    return this.each(function(){
        $('.table', this).jtable();
    });
};
})(jQuery);



/* serviceEdit
----------------------------------------------- */
(function($){
$.fn.serviceEdit = function(){
    return this.each(function(){
        var $root = $(this);
        $('.multiling', $root).multiling();
        $('.input-image', $root).inputImage();
        $root.closest('form').form();
    });
};
})(jQuery);



/* catalog
----------------------------------------------- */
(function($){
$.fn.catalog = function(){
    return this.each(function(){
        $('.table', this).jtable();
    });
};
})(jQuery);



/* catalogEdit
----------------------------------------------- */
(function($){
$.fn.catalogEdit = function(){
    return this.each(function(){
        var $root = $(this);
        $('.select select', $root).jselect();
        $('.multiling', $root).multiling();
        $('.input-image', $root).inputImage();
        $('.input-images', $root).inputImages();
        $root.closest('form').form();
    });
};
})(jQuery);



/* blog
----------------------------------------------- */
(function($){
$.fn.blog = function(){
    return this.each(function(){
        $('.table', this).jtable();
    });
};
})(jQuery);



/* blogEdit
----------------------------------------------- */
(function($){
$.fn.blogEdit = function(){
    return this.each(function(){
        var $root = $(this);
        $('.multiling', $root).multiling();
        $('.input-date', $root).inputDate();
        $root.closest('form').form();
    });
};
})(jQuery);



/* events
----------------------------------------------- */
(function($){
$.fn.events = function(){
    return this.each(function(){
        $('.table', this).jtable();
    });
};
})(jQuery);



/* eventEdit
----------------------------------------------- */
(function($){
$.fn.eventEdit = function(){
    return this.each(function(){
        var $root = $(this);
        $('.multiling', $root).multiling();
        $('.input-date', $root).inputDate();
        $root.closest('form').form();
    });
};
})(jQuery);



/* authors
----------------------------------------------- */
(function($){
$.fn.authors = function(){
    return this.each(function(){
        $('.table', this).jtable();
    });
};
})(jQuery);



/* authorEdit
----------------------------------------------- */
(function($){
$.fn.authorEdit = function(){
    return this.each(function(){
        var $root = $(this);
        $('.multiling', $root).multiling();
        $('.input-image', $root).inputImage();
        $root.closest('form').form();
    });
};
})(jQuery);


/* authorEdit
 ----------------------------------------------- */

(function($){
    $.fn.artstyles = function(){
        var $root = $(this);
        $root.change(function() {
            $.post( "/ajax/getarttype/",{ type: "artstyles", id: $root.val() }, function( data ) {
                if(data){
                    $('#catalog-artstyle').prop('disabled', false).html(data);
                }else
                {
                    $('#catalog-artstyle').prop('disabled', true).html('');
                }
                $('#catalog-artgenre').prop('disabled', true).html('')
                //$( ".result" ).html( data );
            });
        });
    };
})(jQuery);

(function($){
    $.fn.artgenres = function(){
        var $root = $(this);
        $root.change(function() {
            $.post( "/ajax/getarttype/",{ type: "artgenres", id: $root.val() }, function( data ) {
                if(data){
                    $('#catalog-artgenre').prop('disabled', false).html(data);
                }else
                {
                    $('#catalog-artgenre').prop('disabled', true).html('');
                }
                //$( ".result" ).html( data );
            });
        });
    };
})(jQuery);



/* INIT
----------------------------------------------- */
$.popup.defaults.okButton = '<div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el">' + lang.popup.okButton + '</div></div></div></div></div></span>';
$.popup.defaults.cancelButton = '<div class="button-small button"><div class="bg"><div class="r"><div class="l"><div class="el">' + lang.popup.cancelButton + '</div></div></div></div></div></span>';
$.datepicker.setDefaults(datepickerRegional);
$.button();
$(function(){
    if ($('#password-alert').length) {
        $.alert({src: $('#password-alert')});    
    }
    $('label.placeholder').placeholder();
    $('.input-checkbox').jcheckbox();
    $('.editor').editor();
    $('input[type="password"]').password();
    $('.add-menu .jdrop, .settings-menu .jdrop').jdrop({width: function($jdrop){
        return Math.max($('.jdrop-title', $jdrop).width() - 15, $('.jdrop-list', $jdrop).width());
    }});
    $('.m1 .jdrop').jdrop();
    $('.account').accountSettings();
    $('.design').designSettings();
    $('.menu').menuSettings();
    $('.categories').categoriesSettings();
    $('.partners').partnersSettings();
    $('.bn').bnSettings();
    $('.howtobuy').howtobuySettings();
    $('.agreement').agreementSettings();
    $('.about').about();
    $('.services').services();
    $('.service-edit').serviceEdit();
    $('.catalog').catalog();
    $('.catalog-edit').catalogEdit();
    $('.blog').blog();
    $('.blog-edit').blogEdit();
    $('.events').events();
    $('.event-edit').eventEdit();
    $('.author-edit').authorEdit();
    $('.authors').authors();
    $('#catalog-arttype').artstyles();
    $('#catalog-artstyle').artgenres();
});
