# WeChatMenuEditor
A wordpress plugin that can help to manager wechat customize menus like create,delete,view.
It can also work without wordpress just in you php webserver.

## Notes
* 如果一级菜单没有二级菜单，那么右侧二级菜单隐藏
* 编辑之后界面没有刷新
* 删除的功能只删除了界面，没有删除json数据
* 一级菜单不能超过三个，二级菜单不能超过五个
* 第一次点击需要点击两次才能选中
* 其他bug再次测试时可能会遇到
* 封装现有代码，模块化方便调用
* 服务器交互工作
* 修复bug_list中的bug
* 优化访问及响应速度
* 删除菜单加一个提示框，避免误操作
* 写说明文档，最好英文
* 整理编辑器界面，Button可以换成DropDownMenu
* 编辑菜单Url时，没有输入http://会报错
* 编辑菜单时，Key值没有显示出来
* 把微信素材和关键词回复的概念搞错了，暂时只用关键词回复，不用微信素材

### Some Problems
> 每次提交都进行刷新ACCESS TOKEN的操作，并用新取得的ACCESS TOKEN进行操作
修复点击保存并发布会弹出两次提示框的bug问题
每次提交操作都刷新ACCESS TOKEN的操作太耗时，
每次操作都要等好久才能完成原因：
每次提交操作是前台微信编辑器Ajax请求到WordPress插件，
本地WordPress插件再向微信服务器请求ACCESS TOKEN，
等待服务器返回ACCESS TOKEN后再次用返回的ACCESS TOKEN向微信服务器提交操作请求，
再次等待微信服务器返回数据，然后WordPress插件再次返回数据给前提微信菜单编辑器。