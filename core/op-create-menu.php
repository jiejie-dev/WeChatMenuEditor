<?php

$buttons = $_POST['buttons'];
$buttons_json = json_encode($buttons,JSON_UNESCAPED_UNICODE);

require_once('require-all.php');

$wx = WeiXin::getInstance();
$result = $wx->createMenu($buttons_json);

echo $result;
?>