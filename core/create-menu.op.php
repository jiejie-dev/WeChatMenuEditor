<?php

$buttons = $_POST['buttons'];
$buttons_json = json_encode($buttons,JSON_UNESCAPED_UNICODE);
//$buttons_json = iconv("gbk", "utf-8", $buttons_json);
echo $buttons_json;

include('common.func.php');
include('config.inc.php');
include('WeiXin.class.php');

$wx = WeiXin::getInstance();

$result = $wx->createMenu($buttons_json);

echo json_encode($result);
?>