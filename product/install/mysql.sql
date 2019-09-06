INSERT INTO `phpcms_module` (`name`, `module`, `moduledir`, `moduledomain`, `iscore`, `iscopy`, `isshare`, `version`, `author`, `site`, `email`, `introduce`, `license`, `faq`, `setting`, `disabled`, `publishdate`, `installdate`, `updatedate`) VALUES ('商城', 'product', 'product', '', 0, 0, 0, '1.0.0', 'phpcms团队', 'http://www.phpcms.cn/', 'phpcms@163.com', '产品展示、产品订购、在线支付', '许可协议内容', '使用帮助内容', '', 0, '0000-00-00', '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `phpcms_product`;
CREATE TABLE `phpcms_product` (
  `productid` int(11) unsigned NOT NULL auto_increment,
  `pdt_name` varchar(80) NOT NULL default '',
  `style` varchar(80) NOT NULL default '',
  `catid` smallint(5) unsigned NOT NULL default '0',
  `subtype` smallint(5) NOT NULL default '0',
  `brand_id` int(8) unsigned NOT NULL default '0',
  `arrposid` varchar(50) NOT NULL default '0',
  `pro_id` smallint(5) unsigned NOT NULL default '0',
  `pdt_No` varchar(80) NOT NULL default '',
  `pdt_num` int(11) unsigned NOT NULL default '0',
  `pdt_weight` decimal(10,3) unsigned NOT NULL default '0.000',
  `pdt_unit` varchar(20) NOT NULL default '',
  `introduce` text NOT NULL,
  `pdt_img` varchar(255) NOT NULL default '',
  `pdt_bigimg` varchar(255) NOT NULL default '',
  `pdt_thumb` varchar(255) NOT NULL default '',
  `hits` int(8) NOT NULL default '0',
  `comments` int(10) unsigned NOT NULL default '0',
  `sales` mediumint(7) unsigned NOT NULL default '0',
  `showcommentlink` tinyint(4) NOT NULL default '0',
  `price` decimal(10,2) NOT NULL default '0.00',
  `marketprice` decimal(10,2) NOT NULL default '0.00',
  `pdt_keyword` varchar(255) NOT NULL default '',
  `pdt_description` text NOT NULL,
  `addtime` int(11) unsigned NOT NULL default '0',
  `edittime` int(11) unsigned NOT NULL default '0',
  `onsale` tinyint(1) unsigned NOT NULL default '0',
  `disabled` tinyint(1) NOT NULL default '0',
  `ishtml` tinyint(1) unsigned NOT NULL default '1',
  `htmldir` varchar(20) NOT NULL default '',
  `prefix` varchar(50) NOT NULL default '',
  `urlruleid` tinyint(3) unsigned NOT NULL default '0',
  `linkurl` varchar(255) NOT NULL default '',
  `templateid` varchar(20) NOT NULL default '0',
  `skinid` varchar(20) NOT NULL default '0',
  `listorder` int(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`productid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_product_att`;
CREATE TABLE `phpcms_product_att` (
  `att_id` int(10) unsigned NOT NULL auto_increment,
  `pro_id` smallint(5) unsigned NOT NULL default '0',
  `att_name` varchar(60) NOT NULL default '',
  `att_type` tinyint(1) unsigned NOT NULL default '1',
  `att_values` text NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`att_id`),
  KEY `listorder` (`listorder`),
  KEY `pro_id` (`pro_id`)
) TYPE=MyISAM;

INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (1, 1, '网络制式', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (2, 1, '可选颜色', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (3, 1, '尺寸体积', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (4, 1, '外观样式', 1, '翻盖\r\n滑盖\r\n直板', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (5, 1, '主屏参数', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (6, 1, '副屏参数', 0, '1', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (7, 1, '通话时间', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (8, 1, '待机时间', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (9, 1, '上市时间', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (10, 1, '标准配置', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (11, 1, '和弦铃音', 1, '32和弦\r\n64和弦\r\n128和弦', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (12, 1, '中文短信', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (13, 1, '处理器', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (14, 1, '摄像头', 0, '', 0);
INSERT INTO `phpcms_product_att` (`att_id`, `pro_id`, `att_name`, `att_type`, `att_values`, `listorder`) VALUES (15, 1, '主要特点', 2, '', 0);

DROP TABLE IF EXISTS `phpcms_product_brand`;
CREATE TABLE `phpcms_product_brand` (
  `brand_id` smallint(5) unsigned NOT NULL auto_increment,
  `brand_name` varchar(80) NOT NULL default '',
  `brand_frequency` int(11) unsigned NOT NULL default '0',
  `brand_icon` varchar(255) NOT NULL default '',
  `brand_description` text NOT NULL,
  PRIMARY KEY  (`brand_id`)
) TYPE=MyISAM ;

INSERT INTO `phpcms_product_brand` (`brand_id`, `brand_name`, `brand_frequency`, `brand_icon`, `brand_description`) VALUES (1, '诺基亚', 4, '', '');
INSERT INTO `phpcms_product_brand` (`brand_id`, `brand_name`, `brand_frequency`, `brand_icon`, `brand_description`) VALUES (2, '摩托罗拉', 3, '', '');
INSERT INTO `phpcms_product_brand` (`brand_id`, `brand_name`, `brand_frequency`, `brand_icon`, `brand_description`) VALUES (3, '三星', 0, '', '');
INSERT INTO `phpcms_product_brand` (`brand_id`, `brand_name`, `brand_frequency`, `brand_icon`, `brand_description`) VALUES (4, '联想', 0, '', '');
INSERT INTO `phpcms_product_brand` (`brand_id`, `brand_name`, `brand_frequency`, `brand_icon`, `brand_description`) VALUES (5, '西门子', 0, '', '');
INSERT INTO `phpcms_product_brand` (`brand_id`, `brand_name`, `brand_frequency`, `brand_icon`, `brand_description`) VALUES (6, '康佳', 0, '', '');
INSERT INTO `phpcms_product_brand` (`brand_id`, `brand_name`, `brand_frequency`, `brand_icon`, `brand_description`) VALUES (7, '三菱', 0, '', '');
INSERT INTO `phpcms_product_brand` (`brand_id`, `brand_name`, `brand_frequency`, `brand_icon`, `brand_description`) VALUES (8, '索尼爱立信', 0, '', '');
INSERT INTO `phpcms_product_brand` (`brand_id`, `brand_name`, `brand_frequency`, `brand_icon`, `brand_description`) VALUES (9, 'NEC', 0, '', '');

DROP TABLE IF EXISTS `phpcms_product_cart`;
CREATE TABLE `phpcms_product_cart` (
  `cart_id` mediumint(8) unsigned NOT NULL auto_increment,
  `odr_id` mediumint(8) NOT NULL default '0',
  `user_id` mediumint(8) unsigned NOT NULL default '0',
  `productid` mediumint(8) unsigned NOT NULL default '0',
  `pdt_No` varchar(60) NOT NULL default '',
  `pdt_name` varchar(120) NOT NULL default '',
  `pdt_number` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cart_id`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_product_images`;
CREATE TABLE `phpcms_product_images` (
  `Id` int(11) unsigned NOT NULL auto_increment,
  `imgurl` varchar(255) NOT NULL default '',
  `introduce` text NOT NULL,
  `imgthumb` varchar(255) NOT NULL default '',
  `productid` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) TYPE=MyISAM ;

DROP TABLE IF EXISTS `phpcms_product_order`;
CREATE TABLE `phpcms_product_order` (
  `odr_id` int(11) unsigned NOT NULL auto_increment,
  `odr_No` varchar(30) NOT NULL default '',
  `memberid` int(11) unsigned NOT NULL default '0',
  `truename` varchar(50) NOT NULL default '',
  `province` varchar(30) NOT NULL default '',
  `city` varchar(40) NOT NULL default '',
  `area` varchar(30) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `zipcode` varchar(6) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `telephone` varchar(20) NOT NULL default '',
  `mobile` varchar(15) NOT NULL default '',
  `order_num` int(10) NOT NULL default '0',
  `isverify` tinyint(1) unsigned NOT NULL default '0',
  `verifytime` int(11) unsigned NOT NULL default '0',
  `verifyuser` varchar(50) NOT NULL default '',
  `isship` tinyint(1) unsigned NOT NULL default '0',
  `shiptime` int(11) unsigned NOT NULL default '0',
  `shipuser` varchar(50) NOT NULL default '',
  `ispay` tinyint(1) unsigned NOT NULL default '0',
  `paytime` int(11) unsigned NOT NULL default '0',
  `paytype` varchar(50) NOT NULL default '',
  `payuser` varchar(50) NOT NULL default '',
  `note` text NOT NULL,
  `disabled` tinyint(1) NOT NULL default '0',
  `addtime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`odr_id`)
) TYPE=MyISAM ;

DROP TABLE IF EXISTS `phpcms_product_pdtatt`;
CREATE TABLE `phpcms_product_pdtatt` (
  `pdtatt_id` int(11) unsigned NOT NULL auto_increment,
  `productid` int(11) unsigned NOT NULL default '0',
  `att_id` int(8) unsigned NOT NULL default '0',
  `att_value` text NOT NULL,
  PRIMARY KEY  (`pdtatt_id`)
) TYPE=MyISAM ;

DROP TABLE IF EXISTS `phpcms_product_property`;
CREATE TABLE `phpcms_product_property` (
  `pro_id` smallint(5) unsigned NOT NULL auto_increment,
  `pro_name` varchar(60) NOT NULL default '',
  `disabled` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`pro_id`)
) TYPE=MyISAM ;

INSERT INTO `phpcms_product_property` (`pro_id`, `pro_name`, `disabled`) VALUES (1, '手机', 0);
INSERT INTO `phpcms_menu` (`position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('member_menu', '我的订单', '', 'product/myorder.php', '_self', '', 17, '', '', '');
INSERT INTO `phpcms_channel` (`module`, `channelname`, `style`, `channelpic`, `introduce`, `seo_title`, `seo_keywords`, `seo_description`, `listorder`, `islink`, `channeldir`, `channeldomain`, `disabled`, `templateid`, `skinid`, `items`, `comments`, `categorys`, `specials`, `hits`, `enablepurview`, `arrgroupid_browse`, `purview_message`, `point_message`, `enablecontribute`, `enablecheck`, `emailofreject`, `emailofpassed`, `enableupload`, `uploaddir`, `maxfilesize`, `uploadfiletype`, `linkurl`, `setting`, `ishtml`, `cat_html_urlruleid`, `item_html_urlruleid`, `special_html_urlruleid`, `cat_php_urlruleid`, `item_php_urlruleid`, `special_php_urlruleid`) VALUES ('product', '商城', '', '', '', '', '', '', 30, 1, '', '', 0, '0', '0', 0, 0, 0, 0, 0, 0, '', '', '', 1, 1, '', '', 1, 'uploadfile', 1024000, 'gif|jpg', 'product/', '', 1, 0, 0, 0, 0, 0, 0);


INSERT INTO `phpcms_menu` ( `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_add', '添加商品', '商品管理首页', '?mod=product&file=product&action=main', '_self', '', 0, '1', '0,1', '');
INSERT INTO `phpcms_menu` ( `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_make', '商城首页', '生成商城首页', '?mod=product&file=createhtml&action=index', '_self', '', 4, '1', '', '');
INSERT INTO `phpcms_menu` ( `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_make', '商品html', '生成商城栏目，商品html', '?mod=product&file=createhtml', '_self', '', 8, '1', '', '');
INSERT INTO `phpcms_menu` ( `position`, `name`, `title`, `url`, `target`, `style`, `listorder`, `arrgroupid`, `arrgrade`, `username`) VALUES ('admin_quick_infolist', '商品列表', '商品列表', '?mod=product&file=product&action=manage', '_self', '', 0, '1', '', '');