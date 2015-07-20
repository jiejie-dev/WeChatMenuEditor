<?php
/*
 * 用于微信服务器后端验证
 */
  include('inc-config.php');
  include('class-weixin.php');

  $wx = WeiXin::getInstance();
  $wx -> valid();
?>