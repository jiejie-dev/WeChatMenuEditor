<?php
/*
Plugin Name: 微信自定义菜单编辑器
Plugin URI: 没有
Description: 微信公众号自定义菜单可视化编辑器
Version: 1.0
Author: 卢杰杰
Author URI: lujiejie.com
License: A "Slug" license name e.g. GPL2
*/

define('APP_URL', plugin_dir_url(__FILE__));
define('APP_DIR', plugin_dir_path(__FILE__));

/* 注册激活插件时要调用的函数 */ 
register_activation_hook( __FILE__, 'wxmenu_install');   

/* 注册停用插件时要调用的函数 */ 
register_deactivation_hook( __FILE__, 'wxmenu_remove' );  

function wxmenu_install() {  
    /* 在数据库的 wp_options 表中添加一条记录，第二个参数为默认值 */ 
    //add_option("display_copyright_text", "<p style='color:red'>本站点所有文章均为原创，转载请注明出处！</p>", '', 'yes');  
}

function wxmenu_remove() {  
    /* 删除 wp_options 表中的对应记录 */ 
    //delete_option('display_copyright_text');  
}

if( is_admin() ) {
    /*  利用 admin_menu 钩子，添加菜单 */
    add_action('admin_menu', 'wxmenu_menu');
	
	//call register settings function
	add_action( 'admin_init', 'register_settings' );
}
function register_settings(){
	//register our settings
	register_setting( 'wxmenu_settings-group', 'app_id' );
	register_setting( 'wxmenu_settings-group', 'app_screct' );
}
function wxmenu_menu() {
    /* add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);  */
    /* 页名称，菜单名称，访问级别，菜单别名，点击该菜单时的回调函数（用以显示设置页面） */
    add_menu_page('微信自定义菜单编辑器', '微信自定义菜单编辑器', 'administrator','wxmenu', 'wxmenu_html_page');
	add_submenu_page('wxmenu',"设置","设置","administrator","wxmenu_settings",'wxmenu_settings_html_page');
}

function wxmenu_html_page() {

    ?>
    
		<link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
	   	<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
	   	<script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
	   	<link rel="stylesheet" href="<?php echo APP_URL; ?>/meditor/meditor.css" />
	   	<script type="text/javascript" src="<?php echo APP_URL; ?>/meditor/meditor.js" ></script>
	   	<script type="text/javascript">
		   	$(document).ready(function (){
		   		var editor = new MEditor();  //实例化一个自定义菜单编辑器类的实例
		   		editor.setWorkUrl('<?php echo APP_URL; ?>');
		   		editor.render("editor");	//将编辑器渲染到id为editor的容器里面
		   		editor.loadLocal();			//加载本地缓存菜单
		   	});
		   	
	   	</script>
	
		<div id="editor" class="container">
			<!--
	        	作者：1006397539@qq.com
	        	时间：2015-06-23
	        	描述：微信自定义菜单编辑器demo
	        -->
		</div>
<?php  
}  

function wxmenu_settings_html_page (){
	?>
	<div class="wrap">
		<h2>微信自定义菜单设置项</h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'wxmenu_settings-group' ); ?>
    		<?php do_settings_sections( 'wxmenu_settings-group' ); ?>
			<div>
				<label for="app_id">APPID</label>
				<input id="app_id" name="app_id" type="text" value="<?php echo esc_attr(get_option('app_id')); ?>" />
				<label for="app_screct">APPSCRECT</label>
				<input id="app_screct" name="app_screct" type="text"  value="<?php echo esc_attr(get_option('app_screct')); ?>" />
				<?php submit_button(); ?>
			</div>
		</form>
	</div>
		
	<?php
}
?>