<?php
$tags_config = array (
  '信息频道首页推荐' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '36',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '1',
    'datetype' => '2',
    'showcatname' => '1',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2008-01-15 09:45:55',
    'editor' => 'phpip',
    'longtag' => 'info_list(0,$channelid,0,1,0,0,10,36,0,0,0,0,0,1,2,1,0,0,1,1,\'\')',
  ),
  '信息频道首页栏目最新' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '$cat[catid]',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '34',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '0',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => 'tag_info_list',
    'edittime' => '2008-01-16 01:22:21',
    'editor' => 'phpcms',
    'longtag' => 'info_list(\'tag_info_list\',$channelid,$cat[catid],1,0,0,10,34,0,0,0,0,0,0,2,0,0,0,1,1,\'\')',
  ),
  '本类最新信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '$catid',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '30',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '0',
    'showcatname' => '0',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => 'tag_info_list',
    'edittime' => '2008-01-06 03:42:38',
    'editor' => 'phpcms',
    'longtag' => 'info_list(\'tag_info_list\',$channelid,$catid,1,0,0,10,30,0,0,0,0,0,0,0,0,0,0,1,1,\'\')',
  ),
  '本类推荐信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '$catid',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '30',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '0',
    'showcatname' => '0',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-02-02 03:19:31',
    'editor' => 'info',
    'longtag' => 'info_list(0,$channelid,$catid,1,0,0,10,30,0,0,0,0,0,0,0,0,0,0,1,1,\'\')',
  ),
  '本类热点信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '$catid',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '40',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '30',
    'ordertype' => '3',
    'datetype' => '0',
    'showcatname' => '0',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2008-01-16 12:36:47',
    'editor' => 'phpip',
    'longtag' => 'info_list(0,$channelid,$catid,1,0,0,10,40,0,0,0,0,30,3,0,0,0,0,1,1,\'\')',
  ),
  '相关信息' => 
  array (
    'func' => 'info_related',
    'introduce' => '',
    'channelid' => '$channelid',
    'infoid' => '$infoid',
    'keywords' => '$keywords',
    'infonum' => '10',
    'titlelen' => '30',
    'datetype' => '0',
    'templateid' => 'tag_info_related',
    'edittime' => '2008-01-13 03:13:02',
    'editor' => 'xuewang',
    'longtag' => 'info_related(\'tag_info_related\',$channelid,$keywords,$infoid,10,30,0)',
  ),
  '子栏目最新信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '',
    'child' => '1',
    'areaid' => '$areaid',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '40',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '0',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => 'tag_info_list-zjlist',
    'edittime' => '2008-01-06 03:59:22',
    'editor' => 'phpcms',
    'longtag' => 'info_list(\'tag_info_list-zjlist\',$channelid,\'\',1,0,0,10,40,0,$areaid,0,0,0,0,2,0,0,0,1,1,\'\')',
  ),
  '终极栏目信息列表' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '$catid',
    'child' => '0',
    'areaid' => '$areaid',
    'specialid' => '0',
    'page' => '$page',
    'infonum' => '$maxperpage',
    'titlelen' => '70',
    'introducelen' => '300',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '1',
    'datetype' => '2',
    'showcatname' => '0',
    'showauthor' => '1',
    'showhits' => '1',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => 'tag_info_list-jdzj',
    'edittime' => '2008-01-16 12:34:14',
    'editor' => 'phpip',
    'longtag' => 'info_list(\'tag_info_list-jdzj\',$channelid,$catid,0,0,$page,$maxperpage,70,300,$areaid,0,0,0,1,2,0,1,1,1,1,\'\')',
  ),
  '专题子分类最新信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '$specialid',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '50',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '1',
    'showcatname' => '1',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '0',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-02-02 03:20:10',
    'editor' => 'info',
    'longtag' => 'info_list(0,$channelid,0,1,$specialid,0,10,50,0,0,0,0,0,0,1,1,0,0,0,1,\'\')',
  ),
  '专题信息列表' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '$subspecialid',
    'page' => '0',
    'infonum' => '100',
    'titlelen' => '50',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '1',
    'showcatname' => '1',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-02-02 03:20:45',
    'editor' => 'info',
    'longtag' => 'info_list(0,$channelid,0,1,$subspecialid,0,100,50,0,0,0,0,0,0,1,1,0,0,1,1,\'\')',
  ),
  '网站首页推荐信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '28',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '1',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-08-02 04:05:47',
    'editor' => 'phpcms',
    'longtag' => 'info_list(0,$channelid,0,1,0,0,10,28,0,0,0,0,0,0,2,1,0,0,1,1,\'\')',
  ),
  '网站首页最新信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '28',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '1',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-08-02 04:31:46',
    'editor' => 'phpcms',
    'longtag' => 'info_list(0,$channelid,0,1,0,0,10,28,0,0,0,0,0,0,2,1,0,0,1,1,\'\')',
  ),
  '类别图片信息' => 
  array (
    'func' => 'info_thumb',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '2',
    'titlelen' => '10',
    'introducelen' => '0',
    'typeid' => '$typeid',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '0',
    'showalt' => '0',
    'imgwidth' => '100',
    'imgheight' => '100',
    'target' => '1',
    'cols' => '2',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-02-02 04:02:00',
    'editor' => 'info',
    'longtag' => 'info_thumb(0,$channelid,0,1,0,0,2,10,0,0,$typeid,0,0,0,0,0,1,100,100,2,\'\')',
  ),
  '类别最新信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '30',
    'introducelen' => '0',
    'typeid' => '$typeid',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '1',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-02-02 03:20:25',
    'editor' => 'info',
    'longtag' => 'info_list(0,$channelid,0,1,0,0,10,30,0,0,$typeid,0,0,0,2,1,0,0,1,1,\'\')',
  ),
  '类别信息列表' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '$page',
    'infonum' => '10',
    'titlelen' => '50',
    'introducelen' => '0',
    'typeid' => '$typeid',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '1',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-02-02 03:20:20',
    'editor' => 'info',
    'longtag' => 'info_list(0,$channelid,0,1,0,$page,10,50,0,0,$typeid,0,0,0,2,1,0,0,1,1,\'\')',
  ),
  '终极地区信息列表' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '$areaid',
    'specialid' => '0',
    'page' => '$page',
    'infonum' => '20',
    'titlelen' => '70',
    'introducelen' => '300',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '1',
    'showauthor' => '1',
    'showhits' => '1',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => 'tag_info_list-jdzj',
    'edittime' => '2008-01-16 08:46:38',
    'editor' => 'xuewang',
    'longtag' => 'info_list(\'tag_info_list-jdzj\',$channelid,0,1,0,$page,20,70,300,$areaid,0,0,0,0,2,1,1,1,1,1,\'\')',
  ),
  '子地区最新信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '$areaid',
    'specialid' => '0',
    'page' => '$page',
    'infonum' => '10',
    'titlelen' => '70',
    'introducelen' => '220',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '1',
    'showauthor' => '1',
    'showhits' => '1',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => 'tag_info_list-jdzj',
    'edittime' => '2008-01-16 09:01:30',
    'editor' => 'xuewang',
    'longtag' => 'info_list(\'tag_info_list-jdzj\',$channelid,0,1,0,$page,10,70,220,$areaid,0,0,0,0,2,1,1,1,1,1,\'\')',
  ),
  '本地区推荐信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '$areaid',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '40',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '12',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '0',
    'showcatname' => '0',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-02-13 11:17:10',
    'editor' => 'phpcms',
    'longtag' => 'info_list(0,$channelid,0,1,0,0,10,40,0,$areaid,0,12,0,0,0,0,0,0,1,1,\'\')',
  ),
  '本地区热点信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '0',
    'child' => '1',
    'areaid' => '$areaid',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '30',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '60',
    'ordertype' => '3',
    'datetype' => '0',
    'showcatname' => '0',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2008-01-06 04:16:44',
    'editor' => 'phpcms',
    'longtag' => 'info_list(0,$channelid,0,1,0,0,10,30,0,$areaid,0,0,60,3,0,0,0,0,1,1,\'\')',
  ),
  '一级栏目信息列表' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '$catid',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '40',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '0',
    'showauthor' => '0',
    'showhits' => '0',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-04-19 02:28:00',
    'editor' => 'phpcms',
    'longtag' => 'info_list(0,$channelid,$catid,1,0,0,10,40,0,0,0,0,0,0,2,0,0,0,1,1,\'\')',
  ),
  '栏目页图片信息列表' => 
  array (
    'func' => 'info_thumb',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '$catid',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '4',
    'titlelen' => '20',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '0',
    'showalt' => '1',
    'imgwidth' => '145',
    'imgheight' => '100',
    'target' => '1',
    'cols' => '2',
    'username' => '',
    'templateid' => '0',
    'edittime' => '2007-04-19 02:30:20',
    'editor' => 'phpcms',
    'longtag' => 'info_thumb(0,$channelid,$catid,1,0,0,4,20,0,0,0,0,0,0,0,1,1,145,100,2,\'\')',
  ),
  '栏目最新列表' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '$channelid',
    'catid' => '$catid',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '$page',
    'infonum' => '30',
    'titlelen' => '70',
    'introducelen' => '220',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '1',
    'showauthor' => '1',
    'showhits' => '1',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => 'tag_info_list-jdzj',
    'edittime' => '2008-01-16 12:31:38',
    'editor' => 'phpip',
    'longtag' => 'info_list(\'tag_info_list-jdzj\',$channelid,$catid,1,0,$page,30,70,220,0,0,0,0,0,2,1,1,1,1,1,\'\')',
  ),
  '网站首页-最新分类信息' => 
  array (
    'func' => 'info_list',
    'introduce' => '',
    'channelid' => '4',
    'catid' => '0',
    'child' => '1',
    'areaid' => '0',
    'specialid' => '0',
    'page' => '0',
    'infonum' => '10',
    'titlelen' => '44',
    'introducelen' => '0',
    'typeid' => '0',
    'posid' => '0',
    'datenum' => '0',
    'ordertype' => '0',
    'datetype' => '2',
    'showcatname' => '0',
    'showauthor' => '1',
    'showhits' => '1',
    'target' => '1',
    'cols' => '1',
    'username' => '',
    'templateid' => 'tag_info_list-wzsyfl',
    'edittime' => '2008-01-16 02:08:44',
    'editor' => 'phpcms',
    'longtag' => 'info_list(\'tag_info_list-wzsyfl\',4,0,1,0,0,10,44,0,0,0,0,0,0,2,0,1,1,1,1,\'\')',
  ),
);
?>