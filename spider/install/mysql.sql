INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('采集', 'spider', 'spider', '', 0, 0, 0, '1.0.0', 'phpcms', 'http://www.phpcms.cn', 'phpcms@163.com', '<p>采集</p>', '', '', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');
DROP TABLE IF EXISTS `phpcms_spider_job`;
CREATE TABLE `phpcms_spider_job` (
  `JobId` int(11) unsigned NOT NULL auto_increment,
  `SiteId` int(8) NOT NULL default '0',
  `JobName` varchar(100) NOT NULL default '',
  `JobDescription` text NOT NULL,
  `StartUrl` text NOT NULL,
  `SpiderStep` tinyint(1) NOT NULL default '0',
  `UseSpecialLink` tinyint(1) NOT NULL default '0',
  `ScriptLink` varchar(250) NOT NULL default '',
  `TrueLink` varchar(250) NOT NULL default '',
  `ListPageMust` varchar(100) NOT NULL default '',
  `ListPageForbid` varchar(100) NOT NULL default '',
  `ContentPageMust` varchar(100) NOT NULL default '',
  `ContentPageForbid` varchar(100) NOT NULL default '',
  `ListUrlStart` text NOT NULL,
  `ListUrlEnd` text NOT NULL,
  `Cookie` text NOT NULL,
  `DividePageStyle` tinyint(1) NOT NULL default '0',
  `DividePageStart` text NOT NULL,
  `DividePageEnd` text NOT NULL,
  `SourceEncode` tinyint(1) NOT NULL default '0',
  `LabelCycle` tinyint(1) NOT NULL default '0',
  `TestPageUrl` varchar(250) NOT NULL default '',
  `DownImg` tinyint(1) NOT NULL default '0',
  `DownSwf` tinyint(1) NOT NULL default '0',
  `DownOther` tinyint(1) NOT NULL default '0',
  `OtherFileType` varchar(200) NOT NULL default '',
  `ThreadNum` int(5) NOT NULL default '0',
  `ThreadRequest` int(5) NOT NULL default '0',
  `ThreadSleep` int(8) NOT NULL default '0',
  `TimeOut` int(5) NOT NULL default '0',
  `CreateOn` int(11) NOT NULL default '0',
  `UpdateOn` int(11) NOT NULL default '0',
  PRIMARY KEY  (`JobId`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_spider_out`;
CREATE TABLE `phpcms_spider_out` (
  `Id` int(11) unsigned NOT NULL auto_increment,
  `CMS` varchar(50) NOT NULL default '',
  `Field` varchar(100) NOT NULL default '',
  `Description` varchar(250) NOT NULL default '',
  `UserValue` text NOT NULL,
  `DefaultValue` varchar(250) NOT NULL default '',
  `Label` text NOT NULL,
  `Hidden` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) TYPE=MyISAM ;

INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'articleid', '文章ID(自动生成)', '自动生成', '自动生成', '<input style="width:220px;height:20px;"  onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinarticleid" name="art[articleid]"  readonly >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorarticleid" onchange="document.getElementById(''textUinarticleid'').value=value;saveUinList(value)"  disabled ></select></span>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'title', '文章标题', '[标签:标题]', '[标签:标题]', '<input style="width:220px;height:20px;"  onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUintitle" name="art[title]" >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectortitle" onchange="document.getElementById(''textUintitle'').value=value;saveUinList(value)">\r\n<option selected>---手动填写或选择下拉列表---</option>\r\n[采集生成标签]</select></span>', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'author', '文章作者', '[标签:作者]', '[标签:作者]', '<input style="width:220px;height:20px;"  onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinauthor" name="art[author]" >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorauthor" onchange="document.getElementById(''textUinauthor'').value=value;saveUinList(value)">\r\n<option selected>---手动填写或选择下拉列表---</option>\r\n[采集生成标签]</select></span>', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'copyfrom', '来源', '[标签:来源]|[采集页网址]', '[标签:来源]|[采集页网址]', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUincopyfrom" name="art[copyfrom]" >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorcopyfrom" onchange="document.getElementById(''textUincopyfrom'').value=value;saveUinList(value)">\r\n<option selected>---手动填写或选择下拉列表---</option>\r\n[采集生成标签]</select></span>', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'titleintact', '完整标题', '', '', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUintitleintact" name="art[titleintact]" >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectortitle" onchange="document.getElementById(''textUintitleintact'').value=value;saveUinList(value)">\r\n<option selected>---手动填写或选择下拉列表---</option>\r\n[采集生成标签]</select></span>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'subheading', '副标题', '', '', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinsubheading" name="art[subheading]" >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorsubheading" onchange="document.getElementById(''textUinsubheading'').value=value;saveUinList(value)">\r\n<option selected>---手动填写或选择下拉列表---</option>\r\n[采集生成标签]</select></span>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'introduce', '文章简介', '', '', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinintroduce" name="art[introduce]" >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorintroduce" onchange="document.getElementById(''textUinintroduce'').value=value;saveUinList(value)">\r\n<option selected>---手动填写或选择下拉列表---</option>\r\n[采集生成标签]</select></span>', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'keywords', '文章关键词', '', '', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinkeywords" name="art[keywords]" >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorkeywords" onchange="document.getElementById(''textUinkeywords'').value=value;saveUinList(value)">\r\n<option selected>---手动填写或选择下拉列表---</option>\r\n[采集生成标签]</select></span>', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'paginationtype', '分页形式', '0', '0', '<select style="margin-left:20px;width:240px;"   name="art[paginationtype]"  id="textUinpaginationtype" onchange="document.getElementById(''textUinpaginationtype'').value=value;saveUinList(value)">\r\n<option value=''0'' selected>不分页</option>\r\n                <option value=''1''>自动分页</option>\r\n                <option value=''2''>手动分页</option>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'maxcharperpage', '最大分页字符数', '10000', '10000', '<input style="width:220px;height:20px;" value="10000" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinmaxcharperpage" name="art[maxcharperpage]"  onkeypress="return(event.keyCode>=48&&event.keyCode<=57)" >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectormaxcharperpage" onchange="document.getElementById(''textUinmaxcharperpage'').value=value;saveUinList(value)"   disabled ></select></span>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'hits', '点击数', '[随机数:0至1000]', '[随机数:0至1000]', '<input style="width:220px;height:20px;" value="[随机数:0至1000]" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinhits" name="art[hits]">\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorhits" onchange="document.getElementById(''textUinhits'').value=value;saveUinList(value)">[采集生成标签]\r\n</select></span>', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'thumb', '缩略图', '', '', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinthumb" name="art[thumb]">\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorthumb" onchange="document.getElementById(''textUinthumb'').value=value;saveUinList(value)">\r\n[采集生成标签]</select></span>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'username', '文章发布人', '[当前登录用户]', '[当前登录用户]', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinusername" name="art[username]">\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorusername" onchange="document.getElementById(''textUinusername'').value=value;saveUinList(value)">\r\n[采集生成标签]</select></span>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'addtime', '文章添加时间', '[随机时间:2006-06-16 01:30:30至2007-01-14 10:00:56]', '[随机时间:2006-06-16 01:30:30至[当前时间]]', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinaddtime" name="art[addtime]" >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectoraddtime" onchange="document.getElementById(''textUinaddtime'').value=value;saveUinList(value)">\r\n[采集生成标签]</select></span>', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article_data', 'content', '文章内容', '', '[标签:内容]', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUincontent" name="art[content]" readonly />', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'editor', '编辑人员', '', '', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUineditor" name="art[editor]"   >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectoreditor" onchange="document.getElementById(''textUineditor'').value=value;saveUinList(value)">\r\n[采集生成标签]</select></span>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'edittime', '编辑时间', '', '', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinedittime" name="art[edittime]">\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectoredittime" onchange="document.getElementById(''textUinedittime'').value=value;saveUinList(value)">\r\n[采集生成标签]</select></span>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'checker', '审核人员', '', '', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinchecker" name="art[checker]">\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorchecker" onchange="document.getElementById(''textUinchecker'').value=value;saveUinList(value)">\r\n[采集生成标签]</select></span>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'checktime', '审核时间', '', '', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinchecktime" name="art[checktime]">\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorchecktime" onchange="document.getElementById(''textUinchecktime'').value=value;saveUinList(value)">\r\n[采集生成标签]</select></span>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'posid', '推荐位置', '0', '0', '[附属类别]', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'prefix', 'html生成前缀', 'article_', 'article_', '<input style="width:220px;height:20px;" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinprefix" name="art[prefix]" />', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'urlruleid', 'URL规则', '0', '', '<input style="width:220px;height:20px;"  id="textUinurlruleid" name="art[urlruleid]" value=''[栏目urlruleid]'' />', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'status', '状态', '3', '3', '<select  name="art[status]"     style="margin-left:20px;width:240px;" id="textUinstatus" onchange="document.getElementById(''textUinstatus'').value=value;saveUinList(value)">\r\n<option value=''3'' selected> 已通过&nbsp;</option>\r\n<option value=''1'' >待审核&nbsp;</option>\r\n<option value=''0'' >草稿&nbsp;</option>\r\n<option value=''-1'' >删除&nbsp;</option>\r\n</select>', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'htmldir', 'html保存文件夹', 'html', 'html', '<input style="width:220px;height:20px;"  onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinhtmldir" name="art[htmldir]" />', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'set', 'ckbacksort', '倒序发布', '1', '1', '', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'set', 'ckdeletepre', '发布成功后删除原采集内容', '0', '', '', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'set', 'cksaveset', '发布时保存当前配置', '1', '1', '', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'typeid', '标题类别', '', '', '<input style="width:220px;height:20px;" value="" onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUintypeid"  name="art[typeid]"  readonly >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectortypeid" onchange="document.getElementById(''textUintypeid'').value=value;saveUinList(value)">\r\n<option  value=''0'' selected></option>\r\n<option value=''1'' >[图文]</option>\r\n<option value=''2'' >[组图]</option>\r\n<option value=''3'' >[推荐]</option>\r\n<option value=''4'' >[注意]</option></select>', 0);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article', 'ishtml', '是否生成html', '1', '1', '<input style="width:220px;height:20px;"  onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUinishtml" name="art[ishtml]" />', 1);
INSERT INTO `phpcms_spider_out` ( `CMS`, `Field`, `Description`, `UserValue`, `DefaultValue`, `Label`, `Hidden`) VALUES ( 'article_data', 'articleid', '文章ID(自动生成)', '', '自动生成 =主表.articleid', '<input style="width:220px;height:20px;"  onkeydown="if(event.keyCode==13)saveUinList(value)" id="textUindataarticleid" name="artdata[articleid]"  readonly >\r\n<span style="position:absolute;margin:1px 1px 1px -6px">\r\n<select style="margin-left:-202px;width:220px;" id="uinSelectorarticleid" onchange="document.getElementById(''textUindataarticleid'').value=value;saveUinList(value)"  disabled ></select></span>', 0);

DROP TABLE IF EXISTS `phpcms_spider_sites`;
CREATE TABLE `phpcms_spider_sites` (
  `Id` int(11) unsigned NOT NULL auto_increment,
  `SiteName` varchar(100) NOT NULL default '',
  `SiteUrl` varchar(250) NOT NULL default '',
  `Description` text NOT NULL,
  PRIMARY KEY  (`Id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_spider_urls`;
CREATE TABLE `phpcms_spider_urls` (
  `Id` int(11) NOT NULL auto_increment,
  `JobId` int(7) NOT NULL default '0',
  `Title` varchar(80) NOT NULL default '',
  `PageUrl` varchar(250) NOT NULL default '',
  `CreateOn` int(11) NOT NULL default '0',
  `SpiderOn` int(11) NOT NULL default '0',
  `Spidered` tinyint(1) NOT NULL default '0',
  `Content` text NOT NULL,
  `StartTimeStamp` int(11) NOT NULL default '0',
  `IsOut` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`Id`),
  KEY `title` (`Title`,`PageUrl`,`CreateOn`,`JobId`,`Spidered`)
) TYPE=MyISAM ;