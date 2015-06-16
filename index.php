<?php
/*
Plugin Name: 创建自定义菜单
Plugin URI: 没有
Description: 微信公众号创建自定义菜单
Version: 1.0
Author: 卢杰杰
Author URI: lujiejie.com
License: A "Slug" license name e.g. GPL2
*/

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
}

function wxmenu_menu() {
    /* add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);  */
    /* 页名称，菜单名称，访问级别，菜单别名，点击该菜单时的回调函数（用以显示设置页面） */
    add_menu_page('微信自定义菜单', '微信自定义菜单', 'administrator','wxmenu', 'wxmenu_html_page');
}

function wxmenu_html_page() {
      include('config.inc.php');
      include('Menu.models.php');
      include('WeiXin.class.php');

      $wx = WeiXin::getInstance();

      $menu = $wx -> viewMenu();
      if($menu['errcode']=='46003')
        echo '还没有菜单！';
      else
        echo $menu;
    ?>
    <div class="container">  
        <h2>微信自定义菜单</h2>  
        <form class="form-horizontal" method="post" action="/wp-content/plugins/wxmenu/create-menu.op.php">  
            <?php /* 下面这行代码用来保存表单中内容到数据库 */ ?>  
            <?//php wp_nonce_field('update-options'); ?>  
            <div class="form-group">
              <label class="col-md-2 control-label">ACCESS_TOKEN</label>
              <div class="col-md-10">
                <input type="text" value="<?php $wx = WeiXin::getInstance(); echo $wx->getAccessToken(); ?>" class="form-control" />
              </div>
            </div>
            <p>  
                <textarea  
                    name="buttons" 
                    id="buttons" 
                    cols="40" 
                    rows="6">{
                                "button": [
                                    {
                                        "type": "view", 
                                        "name": "长得帅", 
                                        "url": "http://lujiejie.com"
                                    }, 
                                    {
                                        "name": "菜单", 
                                        "sub_button": [
                                            {
                                                "type": "view", 
                                                "name": "百度", 
                                                "url": "http://www.soso.com/"
                                            }, 
                                            {
                                                "type": "view", 
                                                "name": "腾讯视频", 
                                                "url": "http://v.qq.com/"
                                            }, 
                                            {
                                                "type": "view", 
                                                "name": "腾讯网", 
                                                "url": "http://www.qq.com/"
                                            }
                                        ]
                                    }
                                ]
                            }
                         </textarea>  
            </p>  
 
            <p>  
                <!--<input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value="display_copyright_text" />  -->

                <input type="submit" value="保存" class="button-primary" />  
            </p>  
        </form>  
    </div>  
<?php  
}  

?>