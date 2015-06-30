<?php

$access_token = $_GET['access_token'];
echo $access_token;

require_once('all.require.php');

$wx = WeiXin::getInstance();
$wx->setAccessToken($access_token);
$result = $wx->deleteMenu();
if($result)
 echo "操作成功！";
else
 echo '操作失败！';
?>