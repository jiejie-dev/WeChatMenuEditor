<?php 

	require_once('require-all.php');
	
	$wx = WeiXin::getInstance();
	$menu = $wx->viewMenu();

	header('Content-type: application/json');
	
	echo $menu;
?>