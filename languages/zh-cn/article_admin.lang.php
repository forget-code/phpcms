<?php
/*
Language Format:
Add a new file(.lang.php) with your module name at /phpcms/languages/
translation save at the array:$LANG
@lastmodify 2007-3-16
*/
//article.inc.php begin
$LANG['invalid_parameters']='非法参数！请返回！';
$LANG['homepage']='首页';
$LANG['add_article']='添加文章';
$LANG['manage_article']='管理文章';
$LANG['check_article']='审核文章';
$LANG['my_article']='我添加的文章';
$LANG['move_articles']='批量移动文章';
$LANG['manage_recycle']='回收站管理';
$LANG['template_config']='模块配置';
$LANG['use_tag']='标签调用';
$LANG['statistical_reports']='统计报表';
$LANG['publish_website']='发布网页';
//article.inc.php end

//article_action.inc.php begin
$LANG['operation_success']='操作成功';
$LANG['operation_failure']='操作失败';
//article_action.inc.php end

//article_add.inc.php begin
$LANG['empty_category_id']="栏目ID不能为空！请返回！";
$LANG['not_allowed_to_add_an_artcile']='指定栏目不允许添加文章！请返回！';
$LANG['short_title_can_not_be_blank']='对不起！短标题不能为空！';
$LANG['content_can_not_be_blank']='对不起！文章内容不能为空，请返回！';
$LANG['add_article_success']='文章添加成功！';
$LANG['add_article_failure']='文章添加失败！';
$LANG['type']='类别';
$LANG['change_category_add_article']='切换到其他栏目添加文章';
//article_add.inc.php end

//article_checktitle.inc.php begin
$LANG['check_the_same_title']="检查是否有同名标题";
$LANG['input_the_article_title']='请输入文章标题！';
$LANG['title_not_exists']="标题不存在，您可以使用！";
$LANG['title_exists']="标题已经存在，详情请在管理文章搜索！";
//article_checktitle.inc.php end

//article_edit.inc.php begin
$LANG['empty_article_id']='文章 id 不能为空！请返回！';
$LANG['modify_article_success']='文章编辑成功!';
$LANG['modify_article_failure']='文章编辑失败!';
//article_edit.inc.php end

//article_delete.inc.php begin
$LANG['delete_article_success']='文章删除成功!';
$LANG['delete_article_failure']='文章删除失败!';
//article_delete.inc.php end

//article_left.inc.php begin
$LANG['order_the_article_list_success']='文章排序更新成功';
$LANG['order_the_article_list_failure']='文章排序更新失败';
//article_left.inc.php end

//article_main.inc.php begin
$LANG['have_no_category_yet']="您还没有添加栏目，只有先添加栏目才能添加和管理文章。<br><br>现在进入栏目添加页面？";
$LANG['please_select']='请选择栏目';
$LANG['please_choose_category_add_article']='请选择栏目添加文章';
$LNAG['change_category_add_article'] = '改变栏目添加文章';
$LANG['click_here']='点击查看';
$LANG['list_updated']='生成列表';
$LANG['update_arcticle']='生成文章';
$LANG['create_arcticle']='生成文章';
//article_main.inc.php end

//article_manage.inc.php begin
$LANG['access_denied']='非法操作！';
$LANG['please_choose_category_manage']='请选择栏目进行管理';
$LANG['cool']='推荐位置';
//article_manage.inc.php end

//article_move.inc.php begin
$LANG['empty_category']="栏目不能为空！请返回！";
$LANG['empty_parent_category']="源栏目不能为空！请返回！";
$LANG['move_success']='移动操作成功!';
//article_move.inc.php end

//article_preview.inc.php begin
//article_preview.inc.php end

//article_sendback.inc.php begin
$LANG['can_not_access']='无法进行此操作';
$LANG['article_not_exists']='文章不存在';

//article_sendback.inc.php end

//createhtml.inc.php begin
$LANG['category']='栏目';
$LANG['updating']='正在开始更新';
$LANG['update_success']='成功更新';
$LANG['update_channel_homepage_success']='频道首页更新成功';
$LANG['update_article_success']='文章更新成功';
$LANG['update_article_failure']='文章更新失败';
$LANG['from']='从';
$LANG['to']='到';
$LANG['article']='文章';
$LANG['please_choose_article']='请选择文章';
$LANG['article_link_success']='文章地址成功';
$LANG['create_directory_success']='目录创建成功';
$LANG['delete_directory_success']='目录删除成功';
$LANG['article_home']='文章首页';
$LANG['update_channel']='更新频道';
$LANG['channel_home_updating']='更新频道首页';
$LANG['home']='首页';
$LANG['update_category']='更新栏目';
$LANG['update_article']='更新文章';
$LANG['quit_update']='快捷更新';
$LANG['create_category']='生成栏目列表';
$LANG['create_catdir']='生成栏目目录';	
//createhtml.inc.php end

//import.inc.php begin
$LANG['manage_article_data_config']='管理文章数据导入配置';
$LANG['add_article_data_config']='添加文章数据导入配置';
$LANG['manage_article_data']='文章数据导入管理';
$LANG['load_data_config']='导入配置文件';
$LANG['mssql_extension_do_not_loaded']='MSSQL 扩展没有加载，无法从MSSQL导入数据！';
$LANG['total_import']='总需导入:';
$LANG['record']='条数据';
$LANG['load_data_success']='导入数据成功';
$LANG['invalid_name']='配置名称不能为空！必须由字母和数字组成且首字符必须是字母！请返回！';
$LANG['config_file_load_success']='配置文件导入成功';
$LANG['data_config_load_success']='数据导入配置成功！';
$LANG['data_config_load_save_success']='数据导入配置保存成功！';
$LANG['error_parameters']='参数错误！';
$LANG['delete_data_success']='配置文件删除成功！';
$LANG['please_upload_file']='对不起，没有上传文件！';
//import.inc.php end

//setting.inc.php begin
$LANG['save_setting_success']='配置保存成功';
$LANG['manage_homepage']='管理首页';
$LANG['add_special_channel']='添加专题';
$LANG['manage_special_channel_article']='专题文章管理';
$LANG['add_article_to_channel_success']='添加文章到专题成功';
$LANG['remove_article_from_channel_success']='文章移出专题成功';
$LANG['empty_special']='专题不能为空！';
//setting.inc.php end

//tag.inc.php begin
$LANG['yes']='是';
$LANG['no']='否';
$LANG['article_list']='文章列表';
$LANG['article_thumb']='图片文章';
$LANG['article_slide']='幻灯片文章';
$LANG['article_related']='相关文章';
$LANG['tag']='标签';
$LANG['special_list_tag']='专题列表标签';
$LANG['category_tag']='栏目标签';
$LANG['sort_tag']='分类标签';
$LANG['manage_article_tag']='文章标签管理';
$LANG['not_exists']='不存在';
$LANG['exists']='已经存在';
$LANG['change_name']='请改名！';
$LANG['to_user_editer_chomd_templates']='要使用在线模板编辑和标签管理功能必须先把 ./templates/ 目录和子目录以及文件设置为 0777';
$LANG['empty_function_name']='函数名不能为空';
$LANG['empty_tag_name']='标签名不能为空';
$LANG['not_authorized']='您没有操作权限';
//tag.inc.php end

$LANG['only_in_child_special']='文章只能加入到专题子分类中！';

//txtdata.inc.php
$LANG['filemanager'] = '文件管理器';
$LANG['convert_success'] = '转换成功';

?>