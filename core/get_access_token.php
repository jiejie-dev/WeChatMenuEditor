<?php 
	include('config.inc.php');
	include('WeiXin.class.php');

	$wx = WeiXin::getInstance();
	$access_token = $wx->getAccessToken();
	
	echo $access_token;
?>