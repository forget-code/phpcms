-- 主表
CREATE TABLE `$basic_table` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `catid` smallint(5) unsigned NOT NULL default '0',
  `typeid` smallint(5) unsigned NOT NULL,
  `title` char(80) NOT NULL default '',
  `style` char(24) NOT NULL default '',
  `thumb` char(100) NOT NULL default '',
  `keywords` char(40) NOT NULL default '',
  `description` char(255) NOT NULL default '',
  `posids` tinyint(1) unsigned NOT NULL default '0',
  `url` char(100) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  `status` tinyint(2) unsigned NOT NULL default '1',
  `sysadd` tinyint(1) unsigned NOT NULL default '0',
  `islink` tinyint(1) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `status` (`status`,`listorder`,`id`),
  KEY `listorder` (`catid`,`status`,`listorder`,`id`),
  KEY `catid` (`catid`,`status`,`id`)
) TYPE=MyISAM;

-- 从表
CREATE TABLE `$table_data` (
  `id` mediumint(8) unsigned default '0',
  `content` text NOT NULL,
  `readpoint` smallint(5) unsigned NOT NULL default '0',
  `groupids_view` varchar(100) NOT NULL,
  `paginationtype` tinyint(1) NOT NULL,
  `maxcharperpage` mediumint(6) NOT NULL,
  `template` varchar(30) NOT NULL,
  `paytype` tinyint(1) unsigned NOT NULL default '0',
  `allow_comment` tinyint(1) unsigned NOT NULL default '1',
  `relation` varchar(255) NOT NULL default '',
  KEY `id` (`id`)
) TYPE=MyISAM;


INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'catid', '栏目', '', '', 1, 6, '/^[0-9]{1,6}$/', '请选择栏目', 'catid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 1, 0, $modelid, $siteid, 1, 0, 0, 1, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'typeid', '类别', '', '', 0, 0, '', '', 'typeid', 'array (\n  ''minnumber'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, $modelid, $siteid, 1, 0, 0, 2, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'title', '标题', '', 'inputtitle', 1, 80, '', '请输入标题', 'title', '', '', '', '', 0, 1, 0, $modelid, $siteid, $modelid, $siteid, 1, 4, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'keywords', '关键词', '多关键词之间用空格或者“,”隔开', '', 0, 40, '', '', 'keyword', 'array (\r\n  ''size'' => ''100'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '-99', '-99', 0, 1, 0, $modelid, $siteid, $modelid, $siteid, 0, 7, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'description', '摘要', '', '', 0, 255, '', '', 'textarea', 'array (\r\n  ''width'' => ''98'',\r\n  ''height'' => ''46'',\r\n  ''defaultvalue'' => '''',\r\n  ''enablehtml'' => ''0'',\r\n)', '', '', '', 0, 1, 0, 1, 0, $modelid, $siteid, 1, 10, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'updatetime', '更新时间', '', '', 0, 0, '', '', 'datetime', 'array (\r\n  ''dateformat'' => ''int'',\r\n  ''format'' => ''Y-m-d H:i:s'',\r\n  ''defaulttype'' => ''1'',\r\n  ''defaultvalue'' => '''',\r\n)', '', '', '', $modelid, $siteid, 0, 1, 0, 0, 0, 0, 12, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'content', '内容', '<div class="content_attr"><label><input name="add_introduce" type="checkbox"  value="1" checked>是否截取内容</label><input type="text" name="introcude_length" value="200" size="3">字符至内容摘要\r\n<label><input type=''checkbox'' name=''auto_thumb'' value="1" checked>是否获取内容第</label><input type="text" name="auto_thumb_no" value="1" size="2" class="">张图片作为标题图片\r\n</div>', '', 1, 999999, '', '内容不能为空', 'editor', 'array (\n  ''toolbar'' => ''full'',\n  ''defaultvalue'' => '''',\n  ''enablekeylink'' => ''1'',\n  ''replacenum'' => ''2'',\n  ''link_mode'' => ''0'',\n  ''enablesaveimage'' => ''1'',\n)', '', '', '', 0, 0, 0, 1, 0, $modelid, $siteid, 0, 13, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'thumb', '缩略图', '', '', 0, 100, '', '', 'image', 'array (\n  ''size'' => ''50'',\n  ''defaultvalue'' => '''',\n  ''show_type'' => ''1'',\n  ''upload_maxsize'' => ''1024'',\n  ''upload_allowext'' => ''jpg|jpeg|gif|png|bmp'',\n  ''watermark'' => ''0'',\n  ''isselectimage'' => ''1'',\n  ''images_width'' => '''',\n  ''images_height'' => '''',\n)', '', '', '', 0, 1, 0, 0, 0, 1, 0, 1, 14, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'relation', '相关文章', '', '', 0, 0, '', '', 'omnipotent', 'array (\n  ''formtext'' => ''<input type=\\''hidden\\'' name=\\''info[relation]\\'' id=\\''relation\\'' value=\\''{FIELD_VALUE}\\'' style=\\''50\\'' >\r\n<ul class="list-dot" id="relation_text"></ul>\r\n<div>\r\n<input type=\\''button\\'' value="添加相关" onclick="omnipotent(\\''selectid\\'',\\''?m=content&c=content&a=public_relationlist&modelid={MODELID}\\'',\\''添加相关文章\\'',1)" class="button" style="width:66px;">\r\n<span class="edit_content">\r\n<input type=\\''button\\'' value="显示已有" onclick="show_relation({MODELID},{ID})" class="button" style="width:66px;">\r\n</span>\r\n</div>'',\n  ''fieldtype'' => ''varchar'',\n  ''minnumber'' => ''1'',\n)', '', '2,6,4,5,1,17,18,7', '', 0, 0, 0, 0, 0, 0, 1, 0, 15, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'pages', '分页方式', '', '', 0, 0, '', '', 'pages', '', '', '-99', '-99', 0, 0, 0, 1, 0, 0, 0, 0, 16, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'inputtime', '发布时间', '', '', 0, 0, '', '', 'datetime', 'array (\n  ''fieldtype'' => ''int'',\n  ''format'' => ''Y-m-d H:i:s'',\n  ''defaulttype'' => ''0'',\n)', '', '', '', 0, 1, 0, 0, 0, 0, 0, 1, 17, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'posids', '推荐位', '', '', 0, 0, '', '', 'posid', 'array (\n  ''cols'' => ''4'',\n  ''width'' => ''125'',\n)', '', '', '', 0, 1, 0, 1, 0, 0, 0, 0, 18, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'groupids_view', '阅读权限', '', '', 0, 100, '', '', 'groupid', 'array (\n  ''groupids'' => '''',\n)', '', '', '', 0, 0, 0, 1, 0, 0, 0, 0, 19, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'url', 'URL', '', '', 0, 100, '', '', 'text', '', '', '', '', $modelid, $siteid, 0, 1, 0, 0, 0, 0, 50, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'listorder', '排序', '', '', 0, 6, '', '', 'number', '', '', '', '', $modelid, $siteid, 0, 1, 0, 0, 0, 0, 51, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'template', '内容页模板', '', '', 0, 30, '', '', 'template', 'array (\n  ''size'' => '''',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 53, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'allow_comment', '允许评论', '', '', 0, 0, '', '', 'box', 'array (\n  ''options'' => ''允许评论|1\r\n不允许评论|0'',\n  ''boxtype'' => ''radio'',\n  ''fieldtype'' => ''tinyint'',\n  ''minnumber'' => ''1'',\n  ''cols'' => ''5'',\n  ''width'' => ''88'',\n  ''size'' => ''1'',\n  ''default_select_value'' => ''1'',\n)', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 54, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'status', '状态', '', '', 0, 2, '', '', 'box', '', '', '', '', $modelid, $siteid, 0, 1, 0, 0, 0, 0, 55, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'readpoint', '阅读收费', '', '', 0, 5, '', '', 'readpoint', 'array (\n  ''minnumber'' => ''1'',\n  ''maxnumber'' => ''99999'',\n  ''decimaldigits'' => ''0'',\n  ''defaultvalue'' => '''',\n)', '', '-99', '-99', 0, 0, 0, 0, 0, 0, 0, 0, 55, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'username', '用户名', '', '', 0, 20, '', '', 'text', '', '', '', '', $modelid, $siteid, 0, 1, 0, 0, 0, 0, 98, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `siteid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `isbase`, `issearch`, `isadd`, `isfulltext`, `isposition`, `listorder`, `disabled`, `isomnipotent`) VALUES($modelid, $siteid, 'islink', '转向链接', '', '', 0, 0, '', '', 'islink', '', '', '', '', 0, 1, 0, 1, 0, 1, 0, 0, 20, 0, 0);
