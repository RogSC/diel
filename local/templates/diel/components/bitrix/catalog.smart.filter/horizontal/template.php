<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */
?>
<? if ($arResult["ITEMS"]) { ?>
    <section class="popup popup-horizontal-filter">

        <form class="popup-horizontal-filter__form horizontal-filter" action="<?= POST_FORM_ACTION_URI ?>">
            <div class="horizontal-filter__left">
                <h2 class="horizontal-filter__title">Фильтр</h2>
                <input type="hidden" name="set_filter" value="y"/>
                <a href="<?= $APPLICATION->GetCurPage() ?>" class="horizontal-filter__reset" type="reset">Сбросить
                    фильтр</a>

                <button class="popup__close horizontal-filter__close" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M16 1.61143L14.3886 0L8 6.38857L1.61143 0L0 1.61143L6.38857 8L0 14.3886L1.61143 16L8 9.61143L14.3886 16L16 14.3886L9.61143 8L16 1.61143Z"
                              fill="#969696"/>
                    </svg>
                </button>
            </div>

            <div class="horizontal-filter__right">
                <? foreach ($arResult["ITEMS"] as $k => $arFilterItem) {
                    if ($arFilterItem['VALUES']) { ?>
                        <div class="horizontal-filter__field">
                            <h4 class="horizontal-filter__field-title"><?= $arFilterItem['NAME'] ?></h4>
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
                                case 'P':
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
                                case 'F':
                                    ?>
                                    <div class="horizontal-filter__field-box">
                                        <?
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
                                        } ?>
                                    </div>
                                    <?
                                    break;
                                case 'K':
                                    ?>
                                    <div class="horizontal-filter__field-box">
                                        <? foreach ($arFilterItem['VALUES'] as $value) { ?>
                                            <label class="filter__section-radio" for="<?= $value['CONTROL_ID'] ?>">
                                                <input id="<?= $value['CONTROL_ID'] ?> js-init-filter"
                                                       class="input-radio"
                                                       type="radio"
                                                       value="<?= $value['HTML_VALUE'] ?>"
                                                       name="<?= $value["CONTROL_NAME"] ?>"
                                                       id="<?= $value['CONTROL_ID'] ?>"
                                                    <?= $value['CHECKED'] ? 'checked="checked"' : '' ?>><?= $value['VALUE'] ?>
                                            </label>
                                        <? } ?>
                                    </div>
                                    <? break; ?>
                                <? } ?>
                        </div>
                    <? } ?>
                <? } ?>

                <button class="horizontal-filter__submit" type="submit">Применить фильтр</button>
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
