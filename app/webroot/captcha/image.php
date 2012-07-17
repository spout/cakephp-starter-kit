<?php
include 'prepend.php';
$securimage->ttf_file = $securimagePath.'AHGBold.ttf';
$securimage->num_lines = 5;
$color = new Securimage_Color('#666666');
$securimage->text_color = $color;
$securimage->line_color = $color;
$securimage->image_bg_color = new Securimage_Color('#FFFFFF');
$securimage->code_length = rand(3, 4);

$securimage->image_signature = $_SERVER['HTTP_HOST'];
$securimage->signature_color = $color;
$securimage->signature_font  = $securimage->ttf_file;

$securimage->show();
?>
