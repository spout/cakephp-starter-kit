<?php
//start session manually, no need to hack securimage 
session_name('CAKEPHP');
session_start();

$securimagePath = '../../Vendor/securimage/';
include $securimagePath.'securimage.php';

$securimage = new Securimage();
?>