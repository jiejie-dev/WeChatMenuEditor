<?php

require_once('require-all.php');

$buttons = $_POST['buttons'];
$buttons_json = json_encode_with_format($buttons);


$wx = WeiXin::getInstance();
$result = $wx->createMenu($buttons_json);

echo $result;
?>