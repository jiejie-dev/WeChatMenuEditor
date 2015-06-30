<?php 
	$access_token = $_GET['access_token'];
//	echo $access_token;
	
	require_once('all.require.php');
	
	$wx = WeiXin::getInstance();
	$wx->setAccessToken($access_token);
	$menu = $wx->viewMenu();

	header('Content-type: application/json');
	
	echo json_encode($menu);
?>