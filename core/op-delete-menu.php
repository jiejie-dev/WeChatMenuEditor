<?php

require_once('require-all.php');

$wx = WeiXin::getInstance();
$result = $wx->deleteMenu();

echo $result;
?>