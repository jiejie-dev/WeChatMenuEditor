<?php

require_once('all.require.php');

$wx = WeiXin::getInstance();
$result = $wx->deleteMenu();

echo $result;
?>