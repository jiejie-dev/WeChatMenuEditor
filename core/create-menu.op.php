<?php

$buttons = $_POST['buttons'];
$buttons_json = json_encode($buttons,JSON_UNESCAPED_UNICODE);
//$buttons_json = iconv("gbk", "utf-8", $buttons_json);
//echo $buttons_json;

$access_token = $_POST['access_token'];
//echo $access_token;

require_once('all.require.php');

$wx = WeiXin::getInstance();
$wx->setAccessToken($access_token);
$result = $wx->createMenu($buttons_json);

if($result){
	echo "操作成功！";
}
else{
	echo "操作失败！";
}
?>