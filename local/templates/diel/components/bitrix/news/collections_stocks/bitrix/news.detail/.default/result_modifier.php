<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */
$this->SetViewTarget('class_wrapper');
echo 'page-collection__information collection-information section-skew';
$this->EndViewTarget();
$this->SetViewTarget('class_title');
echo 'collection-information__title section-title';
$this->EndViewTarget();
$this->SetViewTarget('page_layout_class');
echo 'page-collection';
$this->EndViewTarget();
$this->SetViewTarget('content_in_section');
echo 'Y';
$this->EndViewTarget();

if ($arResult['PROPERTIES']['PRODUCTS']['VALUE']) {
    foreach ($arResult['PROPERTIES']['PRODUCTS']['VALUE'] as $ID) {
        $arResult['ITEMS'][$ID] = $ID;
    }
}


        $arImages = array();
        if ($arResult['PREVIEW_PICTURE']['ID'] || $arResult['DETAIL_PICTURE']['ID']) {
            $img = $arResult['PREVIEW_PICTURE']['ID'] ?: $arResult['DETAIL_PICTURE']['ID'];
            $arImages[] = CFile::ResizeImageGet(
                $img,
                array('width' => 748, 'height' => 565),
                BX_RESIZE_IMAGE_EXACT
            )['src'];
        }

        if ($arResult['PROPERTIES']['IMAGES']['VALUE']) {
            foreach ($arResult['PROPERTIES']['IMAGES']['VALUE'] as $arImage) {
                $arImages[] = CFile::ResizeImageGet(
                    $arImage,
                    array('width' => 748, 'height' => 565),
                    BX_RESIZE_IMAGE_EXACT
                )['src'];
            }
        }
        if (!empty($arImages)) {
            $arResult['MORE_IMAGES'] = $arImages;
        }
