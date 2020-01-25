<?php
/**
 * @author Danil Syromolotov
 */
/**
 * @var CBitrixComponent $component
 * @var CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (isset($_REQUEST['web_form_submit']) && $_REQUEST['web_form_submit'] == 'Y' || isset($_REQUEST['formresult'])) {
    $APPLICATION->RestartBuffer();
    if ($arResult['FORM_ERRORS']) {
        $arResponse = array(
            'error' => true,
            'result' => false,
            'message' => $arResult['FORM_ERRORS']
        );
    } else {
        $arResponse = array(
            'result' => true
        );
    }
    echo json_encode($arResponse);
    die();
} else {
    if ($arParams['FAST_ORDER'] == 'Y') { ?>
        <section class="popup popup-order popup--active">
            <form class="popup-order-form" id="form_id_<?= $arResult['arForm']['ID'] ?>" enctype="multipart/form-data"
                  action="<?= POST_FORM_ACTION_URI; ?>">
                <?= bitrix_sessid_post(); ?>
                <input type="hidden" name="WEB_FORM_ID" value="<?= $arResult['arForm']['ID'] ?>">
                <input type="hidden" name="web_form_submit" value="Y">
                <h2 class="popup-order__title section-title">Оформление заказа</h2>

                <div class="popup-order-form__left">
                    <? foreach ($arResult["arAnswers"] as $SID => $arAnswer) { ?>
                        <? if ($arAnswer[0]['FIELD_TYPE'] == 'text') { ?>
                            <div class="popup-order-form__name input-text-wrapper">
                                <input class="input-text"
                                       type="<?= $SID == 'PHONE' ? 'tel' : 'text' ?>"
                                       id="<?= $SID ?>"
                                       name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $arAnswer[0]['ID'] ?>"
                                       placeholder="<?= $arResult["arQuestions"][$SID]['TITLE'] ?>">
                            </div>
                        <? } ?>
                        <? if ($arAnswer[0]['FIELD_TYPE'] == 'url') { ?>
                            <input type="hidden"
                                   id="<?= $SID ?>"
                                   value="<?= 'https://' . $_SERVER['HTTP_HOST'] . $arParams['PRODUCT']['URL'] ?>"
                                   name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $arAnswer[0]['ID'] ?>"
                                   placeholder="<?= $arResult["arQuestions"][$SID]['TITLE'] ?>">
                        <? } ?>
                        <? if ($arAnswer[0]['FIELD_TYPE'] == 'textarea') { ?>
                            <div class="popup-order-form__comment textarea-wrapper">
                            <textarea class="textarea"
                                      id="<?= $SID ?>"
                                      name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $arAnswer[0]['ID'] ?>"
                                      placeholder="<?= $arResult["arQuestions"][$SID]['TITLE'] ?>"></textarea>
                            </div>
                        <? } ?>
                    <? } ?>

                    <? foreach ($arResult["arAnswers"] as $SID => $arAnswer) { ?>
                        <? if ($arAnswer[0]['FIELD_TYPE'] == 'checkbox') { ?>
                            <label class="popup-order-form_form__consent label"
                                   for="<?= $SID ?>">
                                <input class="input-checkbox"
                                       id="<?= $SID ?>"
                                       name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $SID ?>[]"
                                       value="<?= $arAnswer[0]['ID'] ?>"
                                    <?= $arAnswer[0]["FIELD_PARAM"] == 'checked' ? 'checked' : '' ?>
                                       type="checkbox">

                                <?= $arResult["arQuestions"][$SID]['TITLE'] ?>
                            </label>
                        <? } ?>

                    <? } ?>


                    <div class="popup-order-form__submit-wrapper">
                        <div class="popup-order-form__submit input-submit-wrapper">
                            <button class="input-submit js-init-form-send">Оформить заказ</button>
                        </div>
                    </div>
                </div>

                <div class="popup-order-form__right">
                    <div class="popup-order-form__image-wrapper">
                        <img class="popup-order-form__image" src="<?= $arParams['PRODUCT']['PICTURE'] ?>" alt="">
                    </div>

                    <h3 class="popup-order-form__title"><?= htmlspecialchars_decode($arParams['PRODUCT']['NAME']) ?></h3>
                    <p class="popup-order-form__price" id="modal_form_product_price"></p>
                </div>

                <button class="popup-order__close popup__close js-init-form-close" type="button">
                    <?= GetContentSvgIcon('close') ?>
                </button>
                <div class="popup-error" style="display: none;"></div>
            </form>

        </section>
    <? } elseif ($arParams['PRICE_LIST'] == 'Y') { ?>
        <section class="price-list section-skew--left">
            <h2 class="price-list__title section-title">запросить прайс-лист</h2>
            <form class="price-list__form price-list-form" id="form_id_<?= $arResult['arForm']['ID'] ?>"
                  enctype="multipart/form-data"
                  action="/local/tools/ajax.web.form.php?ajax_form=<?= $arResult['arForm']['ID'] ?>&sign=<?= $arResult['JSON_SIGN'] ?>">
                <div class="popup-error" style="display: none;"></div>
                <?= bitrix_sessid_post(); ?>
                <input type="hidden" name="WEB_FORM_ID" value="<?= $arResult['arForm']['ID'] ?>">
                <input type="hidden" name="web_form_submit" value="Y">
                <ul class="price-list-form__list">
                    <? foreach ($arResult["arAnswers"] as $SID => $arAnswer) { ?>
                        <? if ($arAnswer[0]['FIELD_TYPE'] == 'text') { ?>
                            <li class="price-list-form__item">
                                <div class="input-text-wrapper">
                                    <input class="input-text" id="<?= $SID ?>"
                                           type="<?= $SID == 'PHONE' ? 'tel' : 'text' ?>"
                                           name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $arAnswer[0]['ID'] ?>"
                                           placeholder="<?= $arResult["arQuestions"][$SID]['TITLE'] ?>">
                                </div>
                            </li>
                        <? } ?>
                        <? if ($arAnswer[0]['FIELD_TYPE'] == 'checkbox') { ?>
                            <li class="price-list-form__item">
                                <label class="price-list-form__label">
                                    <input class="input-checkbox" id="<?= $SID ?>"
                                           name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $SID ?>[]"
                                           value="<?= $arAnswer[0]['ID'] ?>"
                                        <?= $arAnswer[0]["FIELD_PARAM"] == 'checked' ? 'checked' : '' ?>
                                           type="checkbox"><?= $arResult["arQuestions"][$SID]['TITLE'] ?>
                                </label>
                            </li>
                        <? } ?>
                    <? } ?>


                    <li class="price-list-form__item price-list-form__item--submit">
                        <div class="input-submit-wrapper">
                            <input class="input-submit js-init-form-send" type="submit" value="Запросить">
                        </div>
                    </li>
                </ul>
            </form>
        </section>
        <script>
            $(document).ready(function () {
                initTextarea(<?= $arResult['arForm']['ID'] ?>);
            });

            $('#form_id_' + <?= $arResult['arForm']['ID'] ?>).off('submit.ajax-form').on('submit.ajax-form', function (e) {
                $('.popup-error').css('display', 'none').html('');
                e.preventDefault();
                let form = $(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function () {
                        console.log(formValidate(form, false, true));
                        if(!formValidate(form, false, true)) {
                            return false;
                        }
                    },
                    success: function (res) {
                        if (res.error === true) {
                            $('.popup-error').css('display', 'block').html('<p>' + res["message"] + '</p>');
                        } else {
                            let result = '<section class="popup popup-request-call popup--active arcticmodal-overlay"> <div class="popup-successful__inner">' +
                                '<h2 class="popup-successful__title section-title">Заявка отправлена</h2>' +
                                '<div class="popup-successful__message">Менеджер свяжется с вами в ближайшее время. </div> <button class="popup-successful__close popup__close js-init-form-close"> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M20 0.908974L19.091 0L10 9.09103L0.908974 0L0 0.908974L9.09103 10L0 19.091L0.908974 20L10 10.909L19.091 20L20 19.091L10.909 10L20 0.908974Z" fill="#D7825D"></path> </svg></button></div>';
                            $.arcticmodal({
                                content: result
                            });
                        }
                    }
                });
                return false;
            });
        </script>
    <? } elseif ($arParams['ADD_REVIEWS'] == 'Y') { ?>

        <section class="popup popup-leave-feedback popup--active">
            <form class="popup-leave-feedback__form" id="form_id_<?= $arResult['arForm']['ID'] ?>"
                  enctype="multipart/form-data" action="<?= POST_FORM_ACTION_URI; ?>">
                <h2 class="popup-leave-feedback__title section-title">Оставить отзыв</h2>
                <?= bitrix_sessid_post(); ?>
                <input type="hidden" name="WEB_FORM_ID" value="<?= $arResult['arForm']['ID'] ?>">
                <input type="hidden" name="web_form_submit" value="Y">
                <div class="popup-leave-feedback__form-top">
                    <? foreach ($arResult["arAnswers"] as $SID => $arAnswer) { ?>
                        <? if ($SID == 'PHONE' || $SID == 'NAME') { ?>
                            <? $class = $SID == 'PHONE' ? 'popup-request-call__phone' : 'popup-request-call__username'; ?>
                            <div class="popup-leave-feedback__form-name input-text-wrapper">
                                <input class="input-text"
                                       type="<?= $SID == 'PHONE' ? 'tel' : 'text' ?>"
                                       id="<?= $SID ?>"
                                       name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $arAnswer[0]['ID'] ?>"
                                       placeholder="<?= $arResult["arQuestions"][$SID]['TITLE'] ?>">
                            </div>
                        <? } ?>
                    <? } ?>
                </div>
                <? foreach ($arResult["arAnswers"] as $SID => $arAnswer) { ?>
                    <? if ($SID != 'PHONE' && $SID != 'NAME') { ?>
                        <? if ($arAnswer[0]['FIELD_TYPE'] == 'textarea') { ?>
                            <div class="popup-leave-feedback__form-review textarea-wrapper">
                                <textarea class="textarea"
                                          id="<?= $SID ?>"
                                          name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $arAnswer[0]['ID'] ?>"
                                          placeholder="<?= $arResult["arQuestions"][$SID]['TITLE'] ?>"></textarea>
                            </div>
                        <? } ?>
                        <? if ($arAnswer[0]['FIELD_TYPE'] == 'text') { ?>
                            <div class="popup-leave-feedback__form-email input-text-wrapper">
                                <input class="input-text"
                                       id="<?= $SID ?>"
                                       type="<?= $SID == 'PHONE' ? 'tel' : 'text' ?>"
                                       name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $arAnswer[0]['ID'] ?>"
                                       placeholder="<?= $arResult["arQuestions"][$SID]['TITLE'] ?>">
                            </div>
                        <? } ?>
                    <? } ?>
                <? } ?>

                <div class="popup-leave-feedback__form-bottom">
                    <div class="popup-leave-feedback__form-bottom-right">
                        <? foreach ($arResult["arAnswers"] as $SID => $arAnswer) { ?>
                            <? if ($arAnswer[0]['FIELD_TYPE'] == 'checkbox') { ?>
                                <label class="popup-leave-feedback__form-consent label"
                                       for="<?= $SID ?>">
                                    <input class="input-checkbox"
                                           id="<?= $SID ?>"
                                           name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $SID ?>[]"
                                           value="<?= $arAnswer[0]['ID'] ?>"
                                        <?= $arAnswer[0]["FIELD_PARAM"] == 'checked' ? 'checked' : '' ?>
                                           type="checkbox"><?= $arResult["arQuestions"][$SID]['TITLE'] ?>
                                </label>
                            <? } ?>
                        <? } ?>
                        <div class="popup-leave-feedback__form-submit input-submit-wrapper">
                            <input class="input-submit" type="submit" value="Оставить отзыв">
                        </div>
                    </div>
                </div>

                <button class="popup-leave-feedback__close popup__close js-init-form-close" type="button">
                    <?= GetContentSvgIcon('close') ?>
                </button>
                <div class="popup-error" style="display: none;"></div>
            </form>
        </section>
    <? } elseif ($arParams['INDIVIDUAL_ORDER'] == 'Y') { ?>
        <form class="order-section__form price-list-form" method="POST" id="form_id_<?= $arResult['arForm']['ID'] ?>"
              enctype="multipart/form-data"
              action="/local/tools/ajax.web.form.php?ajax_form=<?= $arResult['arForm']['ID'] ?>&sign=<?= $arResult['JSON_SIGN'] ?>">
            <?= bitrix_sessid_post(); ?>
            <input type="hidden" name="WEB_FORM_ID" value="<?= $arResult['arForm']['ID'] ?>">
            <input type="hidden" name="web_form_submit" value="Y">
            <ul class="price-list-form__list">
                <? foreach ($arResult["arAnswers"] as $SID => $arAnswer) { ?>
                    <? if ($arAnswer[0]['FIELD_TYPE'] == 'text') { ?>
                        <li class="price-list-form__item">
                            <div class="input-text-wrapper">
                                <input class="input-text"
                                       type="<?= $SID == 'PHONE' ? 'tel' : 'text' ?>"
                                       id="<?= $SID ?>"
                                       name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $arAnswer[0]['ID'] ?>"
                                       placeholder="<?= $arResult["arQuestions"][$SID]['TITLE'] ?>">
                            </div>
                        </li>
                    <? } ?>
                    <? if ($arAnswer[0]['FIELD_TYPE'] == 'textarea') { ?>
                        <li class="price-list-form__item">
                            <div class="textarea-wrapper">
                                <textarea class="textarea"
                                          id="<?= $SID ?>"
                                          name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $arAnswer[0]['ID'] ?>"
                                          placeholder="<?= $arResult["arQuestions"][$SID]['TITLE'] ?>"></textarea>
                            </div>
                        </li>
                    <? } ?>
                    <? if ($arAnswer[0]['FIELD_TYPE'] == 'checkbox') { ?>
                        <li class="price-list-form__item">
                            <label class="price-list-form__label">
                                <input class="input-checkbox"
                                       id="<?= $SID ?>"
                                       name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $SID ?>[]"
                                       value="<?= $arAnswer[0]['ID'] ?>"
                                        <?= $arAnswer[0]["FIELD_PARAM"] == 'checked' ? 'checked' : '' ?>
                                       type="checkbox"><?= $arResult["arQuestions"][$SID]['TITLE'] ?>
                            </label>
                        </li>
                    <? } ?>
                <? } ?>


                <li class="order-section__form-submit price-list-form__item price-list-form__item--submit">
                    <div class="input-submit-wrapper">
                        <input class="input-submit js-init-form-send" type="submit" value="Оформить заказ">
                    </div>
                </li>
            </ul>
            <div class="popup-error" style="display: none;"></div>
        </form>
        <script>
            $(document).ready(function () {
                initTextarea(<?= $arResult['arForm']['ID'] ?>);
            });

            $('#form_id_' + <?= $arResult['arForm']['ID'] ?>).off('submit.ajax-form').on('submit.ajax-form', function (e) {
                $('.popup-error').css('display', 'none').html('');
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
                        if (res.error === true) {
                            if (e.target.querySelector("input[type=tel]")) {
                                let n = e.target.querySelector("input[type=tel]"),
                                    index = 0;

                                for (let i = 0; i < n.value.length; i++) {
                                    if (Number.isInteger(parseInt(n.value[i]))) {
                                        index++;
                                    }
                                }

                                if (index < 11) {
                                    if (res["message"].indexOf("Телефон") === -1) {
                                        $('.popup-error').css('display', 'block').html('<p>' + res["message"] + '<br>&nbsp;&nbsp;» "Телефон"' + '</p>');
                                    } else {
                                        $('.popup-error').css('display', 'block').html('<p>' + res["message"] + '</p>');
                                    }
                                } else {
                                    $('.popup-error').css('display', 'block').html('<p>' + res["message"] + '</p>');
                                }
                            }
                        } else {
                            let result = '<section class="popup popup-request-call popup--active arcticmodal-overlay"> <div class="popup-successful__inner">' +
                                '<h2 class="popup-successful__title section-title">Заявка отправлена</h2>' +
                                '<div class="popup-successful__message">Менеджер свяжется с вами в ближайшее время. </div> <button class="popup-successful__close popup__close js-init-form-close"> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M20 0.908974L19.091 0L10 9.09103L0.908974 0L0 0.908974L9.09103 10L0 19.091L0.908974 20L10 10.909L19.091 20L20 19.091L10.909 10L20 0.908974Z" fill="#D7825D"></path> </svg></button></div>';
                            $.arcticmodal({
                                content: result
                            });
                        }
                    }
                });
                return false;
            });
        </script>
    <? } else { ?>
        <section class="popup popup-request-call popup--active arcticmodal-overlay">
            <div class="popup-request-call__inner">
                <h2 class="popup-request-call__title section-title"><?= $arResult['arForm']['NAME'] ?></h2>

                <form class="popup-request-call__form" id="form_id_<?= $arResult['arForm']['ID'] ?>"
                      enctype="multipart/form-data" action="<?= POST_FORM_ACTION_URI; ?>">
                    <?= bitrix_sessid_post(); ?>
                    <input type="hidden" name="WEB_FORM_ID" value="<?= $arResult['arForm']['ID'] ?>">
                    <input type="hidden" name="web_form_submit" value="Y">
                    <fieldset class="popup-request-call__fieldset">
                        <? foreach ($arResult["arAnswers"] as $SID => $arAnswer) { ?>
                            <? if ($arAnswer[0]['FIELD_TYPE'] == 'text') { ?>
                                <div class="input-text-wrapper <?= $arResult["arQuestions"][$SID]['CSS_CLASSES'] ?>">
                                    <input class="popup-request-call__username input-text"
                                           type="<?= $SID == 'PHONE' ? 'tel' : 'text' ?>"
                                           id="<?= $SID ?>"
                                           name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $arAnswer[0]['ID'] ?>"
                                           placeholder="<?= $arResult["arQuestions"][$SID]['TITLE'] ?>">
                                </div>
                            <? } ?>
                        <? } ?>
                    </fieldset>
                    <fieldset class="popup-request-call__fieldset popup-request-call__fieldset--last">
                        <div class="popup-request-call__fieldset--last-inner">
                            <? foreach ($arResult["arAnswers"] as $SID => $arAnswer) { ?>
                                <? if ($arAnswer[0]['FIELD_TYPE'] == 'checkbox') { ?>
                                    <label class="popup-request-call__lable popup-request-call__lable-consent"
                                           for="<?= $SID ?>">
                                        <input class="input-checkbox"
                                               id="<?= $SID ?>"
                                               name="form_<?= $arAnswer[0]['FIELD_TYPE'] ?>_<?= $SID ?>[]"
                                               value="<?= $arAnswer[0]['ID'] ?>"
                                            <?= $arAnswer[0]["FIELD_PARAM"] == 'checked' ? 'checked' : '' ?>
                                               type="checkbox"><?= $arResult["arQuestions"][$SID]['TITLE'] ?>
                                    </label>
                                <? } ?>
                            <? } ?>
                            <div class="popup-request-call__input-submit-wrapper input-submit-wrapper">
                                <button class="input-submit js-init-form-send">Заказать</button>
                            </div>
                        </div>
                    </fieldset>
                    <div class="popup-error" style="display: none;"></div>
                </form>
                <button class="popup-request-call__close popup__close js-init-form-close">
                    <?= GetContentSvgIcon('close') ?>
                </button>
            </div>
        </section>
    <? } ?>

<? } ?>


<style>
    .popup-error {
        margin-top: 25px;
        background: #1c0d06;
        border: 2px solid #e08b66;
        display: block;
        padding: 15px 25px;
        color: #fff;
    }
</style>