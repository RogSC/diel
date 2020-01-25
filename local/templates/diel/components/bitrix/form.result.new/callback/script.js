let btnModal = $('.js-init-modal-form');


btnModal.on('click', function (e) {
    e.preventDefault();
    let formID = $(this).attr('data-modal'),
        sign = $(this).attr('data-sign'),
        url = '/local/tools/ajax.web.form.php',
        price = $('#offer-price'),
        blockError = $('.popup-error');

    if (blockError.length > 0) {
        blockError.css('display', 'none');
    }
    $.arcticmodal({
        type: 'ajax',
        url: url + '?sign=' + sign + '&ajax_form=' + formID,
        closeOnOverlayClick: true,
        overlay: {
            css: {
                opacity: 0
            }
        },
        afterOpen: function (data, el) {
        },
        ajax: {
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function (data, el, response) {

                data.body.html(response);
                initTextarea(formID);

                let priceField = $('#modal_form_product_price');

                if (priceField.length > 0) {
                    priceField.html(price.text());
                }
                $('#form_id_' + formID).off('submit.ajax-form').on('submit.ajax-form', function (e) {
                    e.preventDefault();
                    let form = $(this);

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        beforeSend: function () {
                            if(!formValidate(form)) {
                                return false;
                            }
                        },
                        success: function (res) {
                            if (res.result) {
                                let result = '<section class="popup popup-request-call popup--active arcticmodal-overlay"> <div class="popup-successful__inner">' +
                                    '<h2 class="popup-successful__title section-title">Заявка отправлена</h2>' +
                                    '<div class="popup-successful__message">Менеджер свяжется с вами в ближайшее время. </div> <button class="popup-successful__close popup__close js-init-form-close"> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M20 0.908974L19.091 0L10 9.09103L0.908974 0L0 0.908974L9.09103 10L0 19.091L0.908974 20L10 10.909L19.091 20L20 19.091L10.909 10L20 0.908974Z" fill="#D7825D"></path> </svg></button></div>';

                                $.arcticmodal('close');

                                $.arcticmodal({
                                    content: result
                                });
                            } else {
                                if (res.error === true) {
                                    $('.popup-error').css('display', 'block').html('<p>' + res["message"] + '</p>');
                                }
                            }
                        }
                    });
                    return false;
                });
            }
        }
    });

    return false;
});

function formValidate(form, reqPhone = true, reqEmail = false) {
    let popupError = $('.popup-error'),
        phone = form.find('input[type="tel"]').val().replace(/[^\d]/g, ''),
        policy = form.find('input[type="checkbox"]'),
        email = form.find('input[id="EMAIL"]').val(),
        name = form.find('input[id="NAME"]').val(),
        nameValid = /^[A-Za-zА-Яа-я]+$/,
        emailValid = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/,
        errors = false;

    popupError.empty().css('display', 'none');
    if (name.length < 2) {
        popupError.css('display', 'block').append('<p>Указано слишком короткое имя</p>');
        errors = true;
    } else if (!nameValid.test(name)) {
        popupError.css('display', 'block').append('<p>Имя должно содержать только буквы русского/латинского алфавита</p>');
        errors = true;
    }
    if (reqPhone === true) {
        if (phone.length < 11) {
            popupError.css('display', 'block').append('<p>Некорректный номер телефона</p>');
            errors = true;
        }
    } else if (typeof phone != 'undefined' && phone.length > 0) {
        if (phone.length < 11) {
            popupError.css('display', 'block').append('<p>Некорректный номер телефона</p>');
            errors = true;
        }
    }
    if (reqEmail === true) {
        if (!emailValid.test(email)) {
            popupError.css('display', 'block').append('<p>Некорректный E-mail</p>');
            errors = true;
        }
    } else if (typeof email != 'undefined' && email.length > 0) {
        if (!emailValid.test(email)) {
            popupError.css('display', 'block').append('<p>Некорректный E-mail</p>');
            errors = true;
        }
    }
    if (!policy.prop("checked")) {
        popupError.css('display', 'block').append('<p>Вы не согласились с политикой обработки персональных данных</p>');
        errors = true;
    }
    if (errors === true) {
        return false;
    }
    return true;
}