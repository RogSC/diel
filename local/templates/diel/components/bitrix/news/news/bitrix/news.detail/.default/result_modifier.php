<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */
$this->SetViewTarget('class_wrapper');
echo 'news ';
$this->EndViewTarget();

$this->SetViewTarget('class_title');
echo 'news__title section-title ';
$this->EndViewTarget();

$this->SetViewTarget('content_in_section');
echo 'Y';
$this->EndViewTarget();