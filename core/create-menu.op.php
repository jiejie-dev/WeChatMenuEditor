<?php
      $buttons = $_POST['buttons'];

	include('config.inc.php');
      include('menu.models.php');
      include('menuOperator.class.php');
      include('WeiXin.class.php');

      $wx = WeiXin::getInstance();

      $result = $wx->create($buttons);
      if($result)
      	echo "操作成功！";
      else
      	echo '操作失败！';
?>