
$(document).ready(function($) {
	alert(ajaxurl);
	var editor = new MEditor();  //实例化一个自定义菜单编辑器类的实例
	editor.setWorkUrl('<?php echo APP_URL; ?>');
	editor.render("editor");	//将编辑器渲染到id为editor的容器里面
	editor.loadLocal();			//加载本地缓存菜单
});
