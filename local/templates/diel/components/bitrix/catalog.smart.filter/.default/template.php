<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

?>
<? if ($arResult["ITEMS"]) { ?>
    <section class="popup filter" style="display: block;">
        <form class="filter__form filter-form" action="<?= POST_FORM_ACTION_URI ?>">
            <h2 class="filter__title">Фильтр</h2>
            <input type="hidden" name="set_filter" value="y"/>
            <button class="popup__close filter__close" type="button">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 0.908974L19.091 0L10 9.09103L0.908974 0L0 0.908974L9.09103 10L0 19.091L0.908974 20L10 10.909L19.091 20L20 19.091L10.909 10L20 0.908974Z"
                          fill="rgba(255, 255, 255, 0.5)"/>
                </svg>
            </button>

            <div class="filter__section filter__section-reset">
                <a href="<?= $APPLICATION->GetCurPage() ?>" style="display: inline-block;text-decoration: none"
                   class="filter__reset" type="reset">Сбросить фильтр</a>
            </div>
            <? foreach ($arResult["ITEMS"] as $k => $arFilterItem) {
                if ($arFilterItem['VALUES']) { ?>
                    <div class="filter__section">
                        <h3 class="filter__section-title"><?= $arFilterItem['NAME'] ?></h3>
                        <? switch ($arFilterItem['DISPLAY_TYPE']) {
                            case 'A':
                                ?>
                                <div class="filter__price-wrapper">
                                    <?
                                    foreach ($arFilterItem['VALUES'] as $code => $value) { ?>
                                        <input type="text"
                                               data-<?= mb_strtolower($code) ?>="<?= round($value['VALUE']) ?>"
                                               name="<?= $value['CONTROL_NAME'] ?>"
                                               class="filter__price-<?= strtolower($code) ?> js-init-filter filter__price-input"
                                               id="<?= $value['CONTROL_ID'] ?>"
                                               value="<?= $value['HTML_VALUE'] ? round($value['HTML_VALUE']) : round($value['VALUE']) ?>">
                                        <?= $code == 'MIN' ? '<span>-</span>' : '' ?>
                                    <? } ?>
                                </div>
                                <div class="filter__price-slider-container">
                                    <div class="filter__price-slider">
                                        <div class="filter__price-slider-area"></div>
                                    </div>
                                    <div class="filter__price-slider-thumb filter__price-slider-thumb_min"></div>
                                    <div class="filter__price-slider-thumb filter__price-slider-thumb_max"></div>
                                </div>
                                <?
                                break;
                            case 'P': //dropdown
                                ?>
                                <div class="diel-select">
                                    <button class="diel-select__button" type="button">
                                        <span class="diel-select__button-text">Не выбрано</span>
                                    </button>
                                    <ol class="diel-select__list diel-select-list"></ol>

                                    <select class="filter__diel-js js-init-filter"
                                            name="<?= $arParams["FILTER_NAME"] ?>_<?= $arFilterItem["ID"] ?>"
                                            id="<?= $arParams["FILTER_NAME"] ?>_<?= $arFilterItem["ID"] ?>" hidden>
                                        <?
                                        $isChecked = false;
                                        foreach ($arFilterItem['VALUES'] as $value) { ?>
                                            <option class="filter__diel-option-js" id="<?= $value['CONTROL_ID'] ?>"
                                                    value="<?= ($value['HTML_VALUE_ALT']) ?>"
                                                <?= $value['CHECKED'] ? 'selected' : '' ?>><?= $value['VALUE'] ?></option>
                                            <? if (isset($value['CHECKED'])) {
                                                $isChecked = true;
                                            }
                                        } ?>
                                        <option class="filter__diel-option-js" <?= !$isChecked ? 'selected' : '' ?>
                                                disabled>Не выбрано
                                        </option>
                                    </select>
                                </div>
                                <?
                                break;
                            case 'F': //checkbox
                                foreach ($arFilterItem['VALUES'] as $value) {
                                    ?>
                                    <label class="filter__section-checkbox">
                                        <input class="input-checkbox js-init-filter"
                                               name="<?= $value['CONTROL_NAME'] ?>"
                                               id="<?= $value['CONTROL_ID'] ?>"
                                               value="<?= $value['HTML_VALUE'] ?>"
                                               type="checkbox" <?= $value['CHECKED'] ? 'checked="checked"' : '' ?>><?= $value['VALUE'] ?>
                                    </label>
                                    <?
                                }
                                break;
                            case 'K': //radio buttons
                                //dump($value);
                                foreach ($arFilterItem['VALUES'] as $value) { ?>
                                    <label class="filter__section-radio" for="<?= $value['CONTROL_ID'] ?>">
                                        <input id="<?= $value['CONTROL_ID'] ?> js-init-filter"
                                               class="input-radio"
                                               type="radio"
                                               value="<?= $value['HTML_VALUE'] ?>"
                                               name="<?= $value["CONTROL_NAME"] ?>"
                                               id="<?= $value['CONTROL_ID'] ?>"
                                            <?= $value['CHECKED'] ? 'checked="checked"' : '' ?>><?= $value['VALUE'] ?>
                                    </label>
                                    <?
                                }
                                break;
                        } ?>


                    </div>
                <? } ?>
            <? } ?>
            <div class="filter__section filter__section-submit ">
                <button class="filter__reset" type="submit">Применить фильтр</button>
            </div>
        </form>
    </section>

<? } ?>
<script>
    $('.js-init-filter').on('change', function (e) {
        let params = '',
            block = $('.f-count');

        if (block.length > 0) {
            block.remove();
        }
        $(this).closest('form').find('.js-init-filter').each(function (i) {
            let val = $(this).val();

            if (i !== 0) {
                params = params + '&';
            }
            if (val !== undefined) {
                params = params + $(this).attr('name') + '=' + $(this).val();
            }
        });
        $.arcticmodal({
            type: 'ajax',
            url: '<?=$APPLICATION->GetCurPage()?>?filter_use=y&ajax=y',
            ajax: {
                type: 'get',
                dataType: 'html',
                data: $(this).closest('form').serialize(),
                success: function (response) {
                    let obj = JSON.parse(JSON.stringify(response));

                    $.ajax({
                        url: '/local/tools/getJson.php',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            json: obj['ajax_request']['responseText']
                        },
                        success: function (res) {
                            let form = $('.filter-form');

                            let h = '<div class="f-count" style="left:' + form.innerWidth() + 'px">Найдено ' + res.ELEMENT_COUNT + ' элементов<br><a href="' + res.FILTER_URL + '">Показать</a></div>';
                            form.append(h);
                            // alert($(this).attr('name'));
                        }
                    });

                }
            }
        });

    });

    /*function ajaxFilter(el) {
        let params = '',
            value = el.val(),
            name = el.attr('name');

        el.closest('form').find('.js-init-filter').each(function (i) {
            let val = $(this).val();

            if (i !== 0) {
                params = params + '&';
            }
            if (val !== undefined) {
                params = params + $(this).attr('name') + '=' + $(this).val();
            }
        });
        params = params.substring(0, params.length - 1);


            alert(json);

        });
    }*/
</script>
<style>
    .f-count {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        top: calc(50% - 50px);
        background: #160d08;
        padding: 4px 8px;
        border: 1px solid #a4664a;
    }

    .f-count a {
        color: #fff;
        transition: 300ms;
    }

    .f-count a:hover,
    .f-count a:active,
    .f-count a:focus {
        color: #E08B66;
    }
</style>