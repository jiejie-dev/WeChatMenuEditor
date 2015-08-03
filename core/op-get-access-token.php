<?php

	require_once('require-all.php');

	$wx = WeiXin::getInstance();
	$access_token = $wx->getAccessToken();

	echo $access_token;
?>