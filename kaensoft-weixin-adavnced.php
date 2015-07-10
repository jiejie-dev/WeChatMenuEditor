<?php
/*
Plugin Name: Kaensoft Weixin Menu Adavnced
Plugin URI: 没有
Description: kaensoft weixin menu adavnced editor
Version: 1.0
Author: 卢杰杰
Author URI: lujiejie.com
License: A "Slug" license name e.g. GPL2
*/

define('APP_URL', plugin_dir_url(__FILE__));
define('APP_DIR', plugin_dir_path(__FILE__));

require_once(APP_DIR . 'core/func-common.php');
require_once(APP_DIR . 'core/class-weixin.php');

$wx = WeiXin::getInstance();
define('APP_ID', get_option('kaensoft_weixin_appid_oauth'));
define('APP_SECRET', get_option('kaensoft_weixin_appsecret_oauth'));

define('CURRENT_SERVER_MENU_CACHE', get_option('kaensoft_weixin_customize_menu_json_data_src'));

//if(empty(APP_ID)||empty(APP_SECRET))
//	echo '<script>alert("app_id or app_secret is empty , please get settings !");</script>';

save_app_config();

//echo 'app_id:'.APP_ID.'<br>';
//echo 'app_secret:'.APP_SECRET.'<br>';
//echo 'access_token:'.CURRENT_ACCESS_TOKEN.'<br>';

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
	register_setting( 'wxmenu_settings-group', 'kaensoft_weixin_appid_oauth' );
	register_setting( 'wxmenu_settings-group', 'kaensoft_weixin_appsecret_oauth' );
}
function wxmenu_menu() {
    /* add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);  */
    /* 页名称，菜单名称，访问级别，菜单别名，点击该菜单时的回调函数（用以显示设置页面） */
    add_menu_page('WeChat Menu Editor', 'WeChat Menu Editor', 'administrator','wxmenu', 'wxmenu_html_page');
	add_submenu_page('wxmenu',"Settings","Settings","administrator","wxmenu_settings",'wxmenu_settings_html_page');
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
                <?php
                    if(!empty(CURRENT_SERVER_MENU_CACHE)){
                        echo "var server_cache =".CURRENT_SERVER_MENU_CACHE.";";
                        echo "editor.setServerCache(server_cache)";
                    }
                ?>
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
				<label for="kaensoft_weixin_appid_oauth">APPID</label>
				<input id="kaensoft_weixin_appid_oauth" name="kaensoft_weixin_appid_oauth" type="text" value="<?php echo esc_attr(get_option('kaensoft_weixin_appid_oauth')); ?>" />
				<label for="kaensoft_weixin_appsecret_oauth">APPSCRECT</label>
				<input id="kaensoft_weixin_appsecret_oauth" name="kaensoft_weixin_appsecret_oauth" type="text"  value="<?php echo esc_attr(get_option('kaensoft_weixin_appsecret_oauth')); ?>" />
				<?php submit_button(); ?>
			</div>
		</form>
	</div>
		
	<?php
}
?>