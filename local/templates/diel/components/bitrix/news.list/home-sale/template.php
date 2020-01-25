<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */
?>
<? if ($arResult['ITEMS']) { ?>
    <section class="stocks">
        <h2 class="stocks__title section-title"><?= $arParams['BLOCK_TITLE'] ?></h2>

        <div class="stocks__slider-wrapper">
    <? foreach ($arResult['ITEMS'] as $k => $arItem) { ?>
            <div class="stocks-slider__text">
                <h3 class="stocks-slider__title">
                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><?= $arItem['NAME'] ?></a>
                </h3>

                <a class="stocks-slider__description"
                   href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><?= $arItem['PREVIEW_TEXT'] ?></a>

                <a class="stocks-slider__link-detail link-detail"
                   href="<?= $arItem['DETAIL_PAGE_URL']  ?>">Подробнее
                    <?= GetContentSvgIcon('link-detail__image')  ?>
                </a>
            </div>
    <? } ?>
            <div class="product-slider">
                <? foreach ($arResult['ITEMS'] as $k => $arItem) { ?>
                    <? if ($arItem['PREVIEW_PICTURE']) { ?>
                        <div class="product-slide">
                            <a class="product-slide__img" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                                <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>"
                                     alt="<?= $arItem['PREVIEW_PICTURE']['ALT'] ?>">
                            </a>
                            <h3 class="stocks-slider__title">
                                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><?= $arItem['NAME'] ?></a>
                            </h3>

                            <a class="stocks-slider__description"
                               href="<?= $arItem['DETAIL_PAGE_URL'] ?>"><?= $arItem['PREVIEW_TEXT'] ?></a>

                            <a class="stocks-slider__link-detail link-detail"
                               href="<?= $arItem['DETAIL_PAGE_URL']  ?>">Подробнее
                                <?= GetContentSvgIcon('link-detail__image')  ?>
                            </a>
                        </div>
                    <? } ?>
                <? } ?>
            </div>
            <? $i = 1 ?>
            <? if (count($arResult['ITEMS']) != 1) { ?>
                <div class="product-slider-cont">
                    <div class="product-slider-nav">
                        <? foreach ($arResult['ITEMS'] as $k => $arItem) { ?>
                            <div class="product-slider-nav__item-wrap">
                                <div class="product-slider-nav__item">
                                    0<?= $i++ ?>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            <? } ?>


            <!--<ul class="stocks__slider stocks-slider jumping-slider">
                <? /* foreach ($arResult['ITEMS'] as $k => $arItem) { */ ?>
                    <li class="stocks-slider__item jumping-slider__item">
                        <div class="stocks-slider__inner">
                            <? /* if ($arItem['PREVIEW_PICTURE']) { */ ?>
                                <div class="stocks-slider__image-wrapper">
                                    <a href="<? /*= $arItem['DETAIL_PAGE_URL'] */ ?>">
                                        <img class="stocks-slider__image" src="<? /*= $arItem['PREVIEW_PICTURE']['SRC'] */ ?>"
                                             alt="<? /*= $arItem['PREVIEW_PICTURE']['ALT'] */ ?>">
                                    </a>
                                </div>
                            <? /* } */ ?>
                            <div class="stocks-slider__text">
                                <h3 class="stocks-slider__title">
                                    <a href="<? /*= $arItem['DETAIL_PAGE_URL'] */ ?>"><? /*= $arItem['NAME'] */ ?></a>
                                </h3>

                                <a class="stocks-slider__description"
                                   href="<? /*= $arItem['DETAIL_PAGE_URL'] */ ?>"><? /*= $arItem['PREVIEW_TEXT'] */ ?></a>

                                <a class="stocks-slider__link-detail link-detail"
                                   href="<? /*= $arItem['DETAIL_PAGE_URL'] */ ?>">Подробнее
                                    <? /*= GetContentSvgIcon('link-detail__image') */ ?>
                                </a>
                            </div>
                        </div>
                    </li>
                <? /* } */ ?>
            </ul>

            <div class="stocks__slider-options jumping-slider-options">
                <div class="jumping-slider-options__progress">
                    <div class="jumping-slider-options__progress-line"></div>
                </div>
                <div class="jumping-slider-options__nav"></div>
            </div>-->

        </div>

        <a class="stocks__button-transition button-transition"
           href="<?= SITE_DIR ?>sale/"><?= $arParams['LINK_TITLE'] ?>
            <?= GetContentSvgIcon('arrow-long') ?>
        </a>
    </section>
<? } ?>