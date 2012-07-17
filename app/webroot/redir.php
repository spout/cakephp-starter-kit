<?php
if (!empty($_GET['url'])) {
	$url = $_GET['url'];
}
elseif (!empty($_POST['url'])) {
	$url = $_POST['url'];
} else {
	$url = '';
}

if (!empty($url)) {
	header("Status: 301 Moved Permanently");
	header("Location: ".$url);
}

exit();
?>