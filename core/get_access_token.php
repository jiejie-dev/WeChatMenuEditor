<?php 
	require_once('all.require.php');

	$wx = WeiXin::getInstance();
	$access_token = $wx->getAccessToken();
	
	echo $access_token;
?>