<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'video_manage', 'parentid'=>'821', 'm'=>'video', 'c'=>'video', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'manage_video', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'video_add', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'video_edit', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'video_delete', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'setting_video', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'subscribe_manage', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'subscribe_list', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'sub_delete', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'sub_del', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'import_ku6_video', 'parentid'=>$parentid, 'm'=>'video', 'c'=>'video', 'a'=>'import_ku6video', 'data'=>'', 'listorder'=>0, 'display'=>'1'));


if (module_exists('special')) {
	$special_db = pc_base::load_model('special_model');
	if( !$special_db->field_exists('aid') ){
		$menu_db->insert(array('name'=>'album_import', 'parentid'=>868, 'm'=>'special', 'c'=>'album', 'a'=>'import', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
		$special_db->query("ALTER TABLE  `phpcms_special` ADD  `aid` INT UNSIGNED NOT NULL DEFAULT  '0' AFTER  `siteid`");
	}
	if (!$special_db->field_exists('isvideo')) {
		$special_db->query("ALTER TABLE `phpcms_special` ADD `isvideo` TINYINT( 1 ) UNSIGNED NOT NULL");
	}
	$special_content_db = pc_base::load_model('special_content_model');
	if (!$special_content_db->field_exists('videoid')) {
		$special_content_db->query("ALTER TABLE `phpcms_special_content` ADD `videoid` INT UNSIGNED NOT NULL DEFAULT  '0'");
	}
}

$database = pc_base::load_config('database');
$db_charset = $database['default']['charset'];

//判断视频模型是否存在
$sitemodel = pc_base::load_model('sitemodel_model');
$is_table =  $sitemodel->table_exists('video');
if(!$is_table){
	//模型不存在，建模型,加字段
	$modelid = $sitemodel->insert(array('name'=>'视频模型', 'tablename'=>'video', 'category_template'=>'category_video', 'list_template'=>'list_video', 'show_template'=>'show_video', 'enablesearch'=>'1', 'default_style'=>'default','siteid'=>1), true);
	
	$sitemodel->query("CREATE TABLE IF NOT EXISTS `phpcms_video` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(5) unsigned NOT NULL,
  `title` char(80) NOT NULL DEFAULT '',
  `style` char(24) NOT NULL DEFAULT '',
  `thumb` char(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `description` char(255) NOT NULL DEFAULT '',
  `posids` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` char(100) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `sysadd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `vision` varchar(255) NOT NULL DEFAULT '',
  `video_category` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`listorder`,`id`),
  KEY `listorder` (`catid`,`status`,`listorder`,`id`),
  KEY `catid` (`catid`,`status`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=".$db_charset.";");

$sitemodel->query("CREATE TABLE IF NOT EXISTS `phpcms_video_data` (
  `id` mediumint(8) unsigned DEFAULT '0',
  `content` text NOT NULL,
  `readpoint` smallint(5) unsigned NOT NULL DEFAULT '0',
  `groupids_view` varchar(100) NOT NULL,
  `paginationtype` tinyint(1) NOT NULL,
  `maxcharperpage` mediumint(6) NOT NULL,
  `template` varchar(30) NOT NULL,
  `paytype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `allow_comment` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `relation` varchar(255) NOT NULL DEFAULT '',
  `video` tinyint(3) unsigned NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=".$db_charset.";");
	
	$sitemodel->query("INSERT INTO `phpcms_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES
($modelid, 1, 'catid', '栏目', '', '', 1, 6, '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 1, 0, 0, 1, 0, 0),
($modelid, 1, 'typeid', '类别', '', '', 0, 0, '', '', 'typeid', 'array (\n  ''minnumber'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 0, 2, 0, 0),
($modelid, 1, 'title', '标题', '', 'inputtitle', 1, 80, '', '请输入标题', 'title', 'array (\n)', '', '', '', 0, 1, 0, 1, 1, 1, 1, 1, 4, 0, 0),
($modelid, 1, 'keywords', '关键词', '多关键词之间用空格或者“,”隔开', '', 0, 40, '', '', 'keyword', 'array (\n  ''size'' => ''100'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, 1, 1, 1, 1, 0, 7, 0, 0),
($modelid, 1, 'description', '摘要', '', '', 0, 255, '', '', 'textarea', 'array (\n  ''width'' => ''98'',\n  ''height'' => ''46'',\n  ''defaultvalue'' => '''',\n  ''enablehtml'' => ''0'',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 1, 1, 10, 0, 0),
($modelid, 1, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', 'array (\n  ''dateformat'' => ''int'',\n  ''format'' => ''Y-m-d H:i:s'',\n  ''defaulttype'' => ''1'',\n  ''defaultvalue'' => '''',\n)', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 12, 0, 0),
($modelid, 1, 'content', '内容', '<div class=\"content_attr\"><label><input name=\"add_introduce\" type=\"checkbox\"  value=\"1\" checked>是否截取内容</label><input type=\"text\" name=\"introcude_length\" value=\"200\" size=\"3\">字符至内容摘要\r\n<label><input type=''checkbox'' name=''auto_thumb'' value=\"1\" checked>是否获取内容第</label><input type=\"text\" name=\"auto_thumb_no\" value=\"1\" size=\"2\" class=\"\">张图片作为标题图片\r\n</div>', '', 0, 999999, '', '内容不能为空', 'editor', 'array (\n  ''toolbar'' => ''full'',\n  ''defaultvalue'' => '''',\n  ''enablekeylink'' => ''1'',\n  ''replacenum'' => ''2'',\n  ''link_mode'' => ''0'',\n  ''enablesaveimage'' => ''1'',\n  ''height'' => '''',\n  ''disabled_page'' => ''0'',\n)', '', '', '', 0, 0, 0, 1, 0, 1, 1, 0, 13, 0, 0),
($modelid, 1, 'thumb', '缩略图', '', '', 0, 100, '', '', 'image', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''show_type'' => ''1'',\n  ''upload_maxsize'' => ''1024'',\n  ''upload_allowext'' => ''jpg|jpeg|gif|png|bmp'',\n  ''watermark'' => ''0'',\n  ''isselectimage'' => ''1'',\n  ''images_width'' => '''',\n  ''images_height'' => '''',\n)', '', '', '', 0, 1, 0, 0, 0, 1, 0, 1, 14, 0, 0),
($modelid, 1, 'relation', '相关文章', '', '', 0, 0, '', '', 'omnipotent', 'array (\n  ''formtext'' => ''<input type=''hidden'' name=''info[relation]'' id=''relation'' value=''{FIELD_VALUE}'' style=''50'' >\r\n<ul class=\"list-dot\" id=\"relation_text\"></ul>\r\n<div>\r\n<input type=''button'' value=\"添加相关\" onclick=\"omnipotent(''selectid'',''?m=content&c=content&a=public_relationlist&modelid={MODELID}'',''添加相关文章'',1)\" class=\"button\" style=\"width:66px;\">\r\n<span class=\"edit_content\">\r\n<input type=''button'' value=\"显示已有\" onclick=\"show_relation({MODELID},{ID})\" class=\"button\" style=\"width:66px;\">\r\n</span>\r\n</div>'',\n  ''fieldtype'' => ''varchar'',\n  ''minnumber'' => ''1'',\n)', '', '2,6,4,5,1,17,18,7', '', 0, 0, 0, 0, 0, 0, 1, 0, 15, 0, 0),
($modelid, 1, 'pages', '分页方式', '', '', 0, 0, '', '', 'pages', 'array (\n)', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 16, 0, 0),
($modelid, 1, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', 'array (\n  ''fieldtype'' => ''int'',\n  ''format'' => ''Y-m-d H:i:s'',\n  ''defaulttype'' => ''0'',\n)', '', '', '', 0, 1, 0, 0, 0, 0, 0, 1, 17, 0, 0),
($modelid, 1, 'posids', '推荐位', '', '', 0, 0, '', '', 'posid', 'array (\n  ''cols'' => ''4'',\n  ''width'' => ''125'',\n)', '', '', '', 0, 1, 0, 1, 0, 0, 0, 0, 18, 0, 0),
($modelid, 1, 'groupids_view', '阅读权限', '', '', 0, 100, '', '', 'groupid', 'array (\n  ''groupids'' => '''',\n)', '', '', '', 0, 0, 0, 1, 0, 0, 0, 0, 19, 0, 0),
($modelid, 1, 'url', 'URL', '', '', 0, 100, '', '', 'text', 'array (\n)', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 50, 0, 0),
($modelid, 1, 'listorder', '排序', '', '', 0, 6, '', '', 'number', 'array (\n)', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 51, 0, 0),
($modelid, 1, 'template', '内容页模板', '', '', 0, 30, '', '', 'template', 'array (\n  ''size'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 53, 0, 0),
($modelid, 1, 'allow_comment', '允许评论', '', '', 0, 0, '', '', 'box', 'array (\n  ''options'' => ''允许评论|1\r\n不允许评论|0'',\n  ''boxtype'' => ''radio'',\n  ''fieldtype'' => ''tinyint'',\n  ''minnumber'' => ''1'',\n  ''width'' => ''88'',\n  ''size'' => ''1'',\n  ''defaultvalue'' => ''1'',\n  ''outputtype'' => ''0'',\n)', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 54, 0, 0),
($modelid, 1, 'status', '状态', '', '', 0, 2, '', '', 'box', 'array (\n)', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 55, 0, 0),
($modelid, 1, 'readpoint', '阅读收费', '', '', 0, 5, '', '', 'readpoint', 'array (\n  ''minnumber'' => ''1'',\n  ''maxnumber'' => ''99999'',\n  ''decimaldigits'' => ''0'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 55, 0, 0),
($modelid, 1, 'username', '用户名', '', '', 0, 20, '', '', 'text', 'array (\n)', '', '', '', 1, 1, 0, 1, 0, 0, 0, 0, 98, 0, 0),
($modelid, 1, 'islink', '转向链接', '', '', 0, 0, '', '', 'islink', 'array (\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 20, 0, 0),
($modelid, 1, 'video', '视频上传', '', '', 0, 0, '', '', 'video', 'array (\n  ''upload_allowext'' => ''flv|rm|mp4|rmv'',\n)', '', '', '', 0, 0, 0, 1, 0, 1, 0, 0, 8, 0, 0),
($modelid, 1, 'vision', '画质', '', '', 0, 0, '', '', 'box', 'array (\n  ''options'' => ''高清|1\r\n普通|2'',\n  ''boxtype'' => ''select'',\n  ''fieldtype'' => ''varchar'',\n  ''minnumber'' => ''1'',\n  ''width'' => ''80'',\n  ''size'' => ''1'',\n  ''defaultvalue'' => ''0'',\n  ''outputtype'' => ''1'',\n  ''filtertype'' => ''1'',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 9, 0, 0),
($modelid, 1, 'video_category', '视频分类', '', '', 0, 0, '', '', 'box', 'array (\n  ''options'' => ''喜剧|1\r\n爱情|2\r\n科幻|3\r\n剧情|4\r\n动作|5\r\n伦理|6'',\n  ''boxtype'' => ''select'',\n  ''fieldtype'' => ''varchar'',\n  ''minnumber'' => ''1'',\n  ''width'' => ''80'',\n  ''size'' => ''1'',\n  ''defaultvalue'' => ''1'',\n  ''outputtype'' => ''1'',\n  ''filtertype'' => ''1'',\n)', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 9, 0, 0);
");
}

 

//替换category_video模版推荐位值
$position_db = pc_base::load_model('position_model');
$position_1 = $position_db->insert(array('modelid'=>'0', 'catid'=>0, 'name'=>'视频首页焦点图推荐', 'maxnum'=>20, 'extention'=>'', 'listorder'=>'', 'siteid'=>1),true);
$position_2 = $position_db->insert(array('modelid'=>'0', 'catid'=>0, 'name'=>'视频首页头条推荐', 'maxnum'=>20, 'extention'=>'', 'listorder'=>'', 'siteid'=>1),true);
$position_3 = $position_db->insert(array('modelid'=>'0', 'catid'=>0, 'name'=>'视频首页每日热点推荐', 'maxnum'=>20, 'extention'=>'', 'listorder'=>'', 'siteid'=>1),true);
$position_4 = $position_db->insert(array('modelid'=>'0', 'catid'=>0, 'name'=>'视频栏目精彩推荐', 'maxnum'=>20, 'extention'=>'', 'listorder'=>'', 'siteid'=>1),true);

$tpl_file = PC_PATH.'templates'.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'category_video.html';
if(!file_exists($tpl_file)){
	showmessage($tpl_file.' template does not exist.');
}
if(!is_writable($tpl_file)) {
	showmessage($tpl_file.' template does not writable.');
}
$content = file_get_contents($tpl_file);

$content = str_replace('*position1*',$position_1,$content);
$content = str_replace('*position2*',$position_2,$content);
$content = str_replace('*position3*',$position_3,$content);
$content = str_replace('*position4*',$position_4,$content);

file_put_contents($tpl_file,$content);

$language = array('video_manage'=>'视频库管理', 'manage_video'=>'视频管理', 'video_add'=>'添加视频','video_edit'=>'修改视频', 'video_delete'=>'删除视频', 'setting_video'=>'视频设置', 'subscribe_manage'=>'订阅管理', 'sub_delete'=>'删除订阅', 'album_import'=>'视频专辑导入', 'import_ku6_video'=>'导入KU6视频');
?>