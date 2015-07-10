<?php
/*
 * 用于微信服务器后端验证
 */
  include('config.inc.php');
  include('menu.models.php');
  include('menuOperator.class.php');
  include('WeiXin.class.php');

  $wx = WeiXin::getInstance();
  $wx -> valid();
?>