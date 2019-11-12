<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */

CJSCore::Init('jquery');

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("public/libs/arcticmodal/jquery.arcticmodal-0.3.min.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("public/libs/arcticmodal/jquery.arcticmodal-0.3.css"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("public/add-favorites.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("public/app.js"));

Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/tiny-slider.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/dist/js/swiper.min.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/dist/js/imask.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/flow-menu.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/banner-slider.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/collections-slider.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/stocks-slider.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/advantages.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/our-products.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/popup.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/popup-request-call.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/button-up.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/filter.js"));
Asset::getInstance()->addJs($APPLICATION->GetTemplatePath("frontend/js/form.js"));

