<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */
$this->SetViewTarget('class_title');
echo 'contacts__title section-title';
$this->EndViewTarget();

$this->SetViewTarget('class_wrapper');
echo 'page-contacts__contacts contacts';
$this->EndViewTarget();

$this->SetViewTarget('page_layout_class');
echo 'page-contacts';
$this->EndViewTarget();