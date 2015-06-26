<?php

include('config.inc.php');
	include('WeiXin.class.php');

$wx = WeiXin::getInstance();

$result = $wx->deleteMenu();
if($result)
 echo "操作成功！";
else
 echo '操作失败！';
?>