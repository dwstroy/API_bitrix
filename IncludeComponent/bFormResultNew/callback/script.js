// Создаём script.js и подключаем его
// bitrix\templates\eshop_bootstrap_v4\components\bitrix\form.result.new\callback\script.js

function formResultCallBack(form, data) {
    var $response = form.find('.response');
    var msg = '';
    $response.html('');
    if( data.STATUS == 'success' ){
        $response.removeClass('alert-error');
        $response.addClass('alert-success');
        form.addClass('success');
        if( typeof data.MSG != 'string' ){
            msg = data.MSG.join('<br/>');
        }else{
            msg = data.MSG;
        }
        $response.html('');
        $response.append(msg);
        form[0].reset();
    }else{
        $response.addClass('alert-error');
        $response.removeClass('alert-success');
        form.removeClass('success');
        if( typeof data.MSG != 'string' ){
            msg = data.MSG.join('<br/>');
        }else{
            msg = data.MSG;
        }
        $response.html('');
        $response.append(msg);
    }
    form.find('.captcha_container').html(data.CAPTCHA);
    form.removeClass('onsubmit');
}
function validations($form) {
    function submitF(e) {
        e.preventDefault();
        console.log("click");
        var valid = true;
        var $targetForm = ($(this).hasClass('form')?$(this):$(this).parents('.form'));
        var $response = $targetForm.find('.response');
        if( $targetForm.hasClass('onsubmit') ){
            return false;
        }
        $response.html('');
        $targetForm.find('[required]').map(function () {
            var $this = $(this),
                parent = $this.closest('.error_container'),
                errors = [],
                value = '',
                placeholder = $this.attr('placeholder');
            if( !parent.length ){
                parent = $this.parent()
            }
            value = $this.val();
            if (value == '') {
                errors.push('Поле обязательно для заполнения');
                parent.addClass('_error');
                valid = false;
            } else {
                parent.removeClass('_error');
            }
            if ($this.attr('type') == 'email') {
                errors.push('Неверный формат для E-mail');
                var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9])+$/;
                //var $email = $targetForm.find('[type="email"]');
                if (!filter.test(value)) {
                    parent.addClass('_error');
                    valid = false;
                } else {
                    parent.removeClass('_error');
                }
            }
            if ($this.attr('type') == 'checkbox') {
                console.log($this);
                if (!$this.is(':checked')) {
                    parent.addClass('_error');
                    parent.append('<div class="_error_text">Отметьте чекбокс</div>');
                    valid = false;
                } else {
                    parent.removeClass('_error');
                    parent.find('._error_text').remove();
                }
            }else if( !valid && errors.length ){
                parent.addClass('_error');
                parent.find('._error_text').remove();
                errors.forEach(function (value) {
                    parent.append('<div class="_error_text">'+value+'</div>');
                })
            }else{
                parent.removeClass('_error');
            }
        });
        if (valid) {
            $targetForm.addClass('onsubmit');
            if ($targetForm.hasClass('js-ajax_form')) {
                var dataForm = new FormData($targetForm[0]),
                    callback = $targetForm.data('back'),
                    actionURL = $targetForm.attr('action');
                if( $targetForm.find('[name="captcha_word"]').length ){
                    grecaptcha.ready(function() {
                        grecaptcha.execute(BX.message('RECAPTCHA_SITE_KEY'), {action: 'form'})
                            .then(function(token) {
                                dataForm.append('g-recaptcha-response', token);
                                $.ajax({
                                    url: actionURL,
                                    data: dataForm,
                                    method: 'POST',
                                    dataType: 'json',
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                }).done(function (data) {
                                    window[callback]($targetForm, data);
                                });
                            });
                    });
                }else{
                    $.ajax({
                        url: actionURL,
                        data: dataForm,
                        method: 'POST',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false
                    }).done(function (data) {
                        window[callback]($targetForm, data);
                    });
                }
                /*
                $.post(actionURL, dataForm, function (data) {
                    console.log(callback);
                    window[callback]($targetForm, data);
                }, 'json');*/
            } else {
                $targetForm.submit();
            }
        }else{
            return false;
        }
    }
    function check(){
        var $this = $(this),
            parent = $this.closest('.error_container'),
            errors = [],
            value = '';
        if( !parent.length ){
            parent = $this.parent()
        }
        if( $this.attr('name').indexOf('[]') != -1 ){
            var checkboxes = document.getElementsByName($this.attr('name'));
            for (var i=0, n=checkboxes.length;i<n;i++)
            {
                if (checkboxes[i].checked)
                {
                    value += ","+checkboxes[i].value;
                }
            }
            $this = $this.closest('.checkbox');
            parent = $this.parent();
        }else{
            value = $this.val();
        }
        if (value == '') {
            errors.push('Поле обязательно для заполнения');
        }
        if ($this.attr('type') == 'email') {
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9])+$/;
            if (!filter.test(value)) {
                errors.push('Неверный формат для E-mail')
            }
        }
        parent.find('._error_text').remove();
        if ($this.attr('type') == 'checkbox') {
            if (!$this.is(':checked')) {
                parent.addClass('_error');
                parent.find('.blog3-form-container-checkbox-text').append('<div class="_error_text" style="margin-top: 0;">Отметьте чекбокс</div>');
            } else {
                parent.removeClass('_error');
                parent.find('._error_text').remove();
            }
        }if( errors.length ){
            parent.addClass('_error');
            parent.removeClass('_success');
            errors.forEach(function (value) {
                parent.append('<div class="_error_text">'+value+'</div>');
            })
        }else{
            parent.removeClass('_error');
            parent.addClass('_success');
        }
    }
    if( typeof $form == 'undefined' ){
        $form = $('body');
    }
    $form.find('[required]').on('input', check);
    $form.find('[required]').on('change', check);
    // Проверка при отправке
    var $obj = $form.find('.form').find('.form__button-send');
    $obj.on("click", submitF);
    $form.find('.form').on("submit", submitF);
}
$(document).ready(function () {
    validations();
});