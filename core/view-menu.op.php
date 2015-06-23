<?php 
	include('all.require.php');
	
	$wx = WeiXin::getInstance();
	$menu = $wx->viewMenu();
	
	header('Content-type: application/json');
	
	echo json_encode($menu);
?>