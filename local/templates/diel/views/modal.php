<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

global $arSetting;
?>
    <div class="popup popup-main-menu">
        <div class="popup-main-menu__inner">
            <div class="popup-main-menu__left">
                <a class="popup-main-menu__logo logo-wrapper">
                    <?= GetContentSvgIcon('logo') ?>
                </a>
            </div>

            <div class="popup-main-menu__right">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "full",
                    array(
                        "COMPONENT_TEMPLATE" => "full",
                        "ROOT_MENU_TYPE" => "full",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MAX_LEVEL" => "2",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N"
                    ),
                    false
                ); ?>

                <ul class="popup-main-menu__footer popup-menu-footer">
                    <li class="popup-menu-footer__item">
                        <a class="popup-menu-footer__phone phone-comp"
                           href="tel:<?= $arSetting['FILIAL']['PROPS']['PHONE']['VALUE'] ?>"><?= $arSetting['FILIAL']['PROPS']['PHONE']['VALUE'] ?>
                            <span class="phone-comp__description"><?=Loc::getMessage('MODAL_FORM_CALLBACK_LINK_TITLE')?></span>
                            <?= GetContentSvgIcon('phone-comp') ?>
                        </a>
                    </li>
                    <li class="popup-menu-footer__item">
                        <a class="popup-menu-footer__address address-comp" href="/contacts/">
                            <address class="address-comp__address">]
                                <?= $arSetting['FILIAL']['PROPS']['CITY']['VALUE'] ? $arSetting['FILIAL']['PROPS']['PHONE']['VALUE'] . ', ' : '' ?> <?= $arSetting['FILIAL']['PROPS']['ADDRESS']['VALUE'] ?>
                            </address>
                            <?= GetContentSvgIcon('address-comp') ?>
                        </a>
                    </li>
                    <? if (isset($arSetting['SOCIAL'])) { ?>
                        <li class="popup-menu-footer__item popup-menu-footer__item--social">
                            <ul class="popup-menu-footer__social social-menu">
                                <? foreach ($arSetting['SOCIAL'] as $arItem) { ?>
                                    <li class="social-menu__item">
                                        <a class="social-menu__link social-menu__link-twitter"
                                           href="<?= $arItem['NAME'] ?>">
                                            <? if ($arItem['PROPS']['ICON']['VALUE']) { ?>
                                                <img style="max-width: 16px;"
                                                     alt="<?= $arItem['PROPS']['SOCIAL_LIST']['NAME'] ?>"
                                                     src="<?= CFile::GetPath($arItem['PROPS']['ICON']['VALUE']) ?>">
                                            <? } else { ?>
                                                <?= GetContentSvgIcon($arItem['PROPS']['SOCIAL_LIST']['VALUE']) ?>
                                            <? } ?>
                                        </a>
                                    </li>
                                <? } ?>
                            </ul>
                        </li>
                    <? } ?>
                </ul>
            </div>
            <button class="popup-main-menu__close popup-main-menu__button popup__close popup-main-menu__button--close">
                <?= GetContentSvgIcon('close') ?>
            </button>
            <a class="popup-main-menu__search button-serch" href="#">
                <?= GetContentSvgIcon('search-button') ?>
            </a>
        </div>
    </div>

    <div class="popup popup-search">
        <div class="popup-search__inner">
            <div class="popup-search__left">
                <a class="popup-search__logo logo-wrapper">
                    <?= GetContentSvgIcon('logo') ?>
                </a>
            </div>
            <div class="popup-search__right">
                <form class="main-search" action="<?=SITE_DIR?>search/?q=">
                    <input class="main-search__input" type="text" placeholder="ПОИСК">
                    <button class="main-search__button">
                        <?= GetContentSvgIcon('search-button') ?></button>
                </form>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "full_search",
                    array(
                        "COMPONENT_TEMPLATE" => "full_search",
                        "ROOT_MENU_TYPE" => "full",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                        "MAX_LEVEL" => "2",
                        "CHILD_MENU_TYPE" => "left",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N"
                    ),
                    $component, array('HIDE_ICONS' => true)
                ); ?>
            </div>
        </div>
        <button class="popup-search__close popup-search__button popup-search__button--close">
            <?= GetContentSvgIcon('close') ?>
        </button>
    </div>