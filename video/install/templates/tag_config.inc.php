<?php
return array (
  '栏目页推荐3条' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=4 AND a.status=99  ".get_sql_catid($catid)." ORDER BY a.vid ASC',
    'selectfields' => 
    array (
      0 => 'vid',
      1 => 'catid',
      2 => 'title',
      3 => 'style',
      4 => 'thumb',
      5 => 'keywords',
      6 => 'description',
      7 => 'userid',
      8 => 'updatetime',
      9 => 'timelen',
      10 => 'islink',
      11 => 'inputtime',
    ),
    'orderby' => 'vid ASC',
    'page' => '0',
    'number' => '3',
    'template' => 'tag_li',
    'var_description' => 
    array (
      1 => '日期格式',
      2 => '打开窗口',
    ),
    'var_name' => 
    array (
      1 => 'dateformat',
      2 => 'target',
    ),
    'var_value' => 
    array (
      1 => 'Y-m-d',
      2 => '_blank',
    ),
    'type' => '',
    'where' => 
    array (
      'catid' => '$catid',
      'keywords' => '',
      'userid' => '',
      'updatetime' => '',
      'inputtime' => '',
      'posids' => '4',
    ),
    'modelid' => '20',
    'tagcode' => 'tag(\'video\', \'tag_li\', "SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=4 AND a.status=99  ".get_sql_catid($catid)." ORDER BY a.vid ASC", 0, 3, array (  \'dateformat\' => \'Y-m-d\',  \'target\' => \'_blank\',))',
  ),
  '栏目页头条3条' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=3 AND a.status=99  ".get_sql_catid($catid)." ORDER BY a.vid ASC',
    'selectfields' => 
    array (
      0 => 'vid',
      1 => 'catid',
      2 => 'title',
      3 => 'style',
      4 => 'thumb',
      5 => 'keywords',
      6 => 'description',
      7 => 'userid',
      8 => 'updatetime',
      9 => 'timelen',
      10 => 'islink',
      11 => 'inputtime',
    ),
    'orderby' => 'vid ASC',
    'page' => '0',
    'number' => '3',
    'template' => 'tag_top',
    'var_description' => 
    array (
      1 => '日期格式',
      2 => '打开窗口',
    ),
    'var_name' => 
    array (
      1 => 'dateformat',
      2 => 'target',
    ),
    'var_value' => 
    array (
      1 => 'Y-m-d',
      2 => '_blank',
    ),
    'type' => '',
    'where' => 
    array (
      'catid' => '$catid',
      'keywords' => '',
      'userid' => '',
      'updatetime' => '',
      'inputtime' => '',
      'posids' => '3',
    ),
    'modelid' => '20',
    'tagcode' => 'tag(\'video\', \'tag_top\', "SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=3 AND a.status=99  ".get_sql_catid($catid)." ORDER BY a.vid ASC", 0, 3, array (  \'dateformat\' => \'Y-m-d\',  \'target\' => \'_blank\',))',
  ),
  '栏目页最新3条' => 
  array (
    'introduce' => '头条下面图文',
    'mode' => '0',
    'sql' => 'SELECT vid,catid,title,style,thumb,keywords,description,userid,islink,inputtime FROM phpcms2008_video WHERE  status=99   AND  `thumb`!=\'\'  ORDER BY vid ASC',
    'selectfields' => 
    array (
      0 => 'vid',
      1 => 'catid',
      2 => 'title',
      3 => 'style',
      4 => 'thumb',
      5 => 'keywords',
      6 => 'description',
      7 => 'userid',
      8 => 'islink',
      9 => 'inputtime',
    ),
    'orderby' => 'vid ASC',
    'page' => '0',
    'number' => '3',
    'template' => 'tag_pic_li',
    'var_description' => 
    array (
      1 => '日期格式',
      2 => '打开窗口',
      3 => '标题长度',
      4 => '缩略图宽度',
      5 => '缩略图高度',
    ),
    'var_name' => 
    array (
      1 => 'dateformat',
      2 => 'target',
      3 => 'titlelen',
      4 => 'width',
      5 => 'height',
    ),
    'var_value' => 
    array (
      1 => 'Y-m-d',
      2 => '_blank',
      3 => '46',
      4 => '102',
      5 => '78',
    ),
    'type' => '',
    'where' => 
    array (
      'catid' => '',
      'thumb' => '1',
      'keywords' => '',
      'userid' => '',
      'updatetime' => '',
      'inputtime' => '',
      'posids' => '0',
    ),
    'modelid' => '20',
    'tagcode' => 'tag(\'video\', \'tag_pic_li\', "SELECT vid,catid,title,style,thumb,keywords,description,userid,islink,inputtime FROM phpcms2008_video WHERE  status=99   AND  `thumb`!=\'\'  ORDER BY vid ASC", 0, 3, array (  \'dateformat\' => \'Y-m-d\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',  \'width\' => \'102\',  \'height\' => \'78\',))',
  ),
  '列表页推荐视频' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=4 AND a.status=99   ORDER BY a.vid ASC',
    'selectfields' => 
    array (
      0 => 'vid',
      1 => 'catid',
      2 => 'title',
      3 => 'style',
      4 => 'thumb',
      5 => 'keywords',
      6 => 'description',
      7 => 'userid',
      8 => 'updatetime',
      9 => 'timelen',
      10 => 'islink',
      11 => 'inputtime',
    ),
    'orderby' => 'vid ASC',
    'page' => '0',
    'number' => '8',
    'template' => 'tag_pic_time',
    'var_description' => 
    array (
      1 => '日期格式',
      2 => '打开窗口',
      3 => '标题长度',
      4 => '缩略图宽度',
      5 => '缩略图高度',
    ),
    'var_name' => 
    array (
      1 => 'dateformat',
      2 => 'target',
      3 => 'titlelen',
      4 => 'width',
      5 => 'height',
    ),
    'var_value' => 
    array (
      1 => 'Y-m-d',
      2 => '_blank',
      3 => '46',
      4 => '124',
      5 => '94',
    ),
    'type' => '',
    'where' => 
    array (
      'catid' => '',
      'keywords' => '',
      'userid' => '',
      'updatetime' => '',
      'inputtime' => '',
      'posids' => '4',
    ),
    'modelid' => '20',
    'tagcode' => 'tag(\'video\', \'tag_pic_time\', "SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=4 AND a.status=99   ORDER BY a.vid ASC", 0, 8, array (  \'dateformat\' => \'Y-m-d\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',  \'width\' => \'124\',  \'height\' => \'94\',))',
  ),
  '内容页推荐视频' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT vid,catid,title,style,thumb,keywords,description,userid,updatetime,timelen,islink,inputtime FROM phpcms2008_video WHERE  status=99   ORDER BY vid ASC',
    'selectfields' => 
    array (
      0 => 'vid',
      1 => 'catid',
      2 => 'title',
      3 => 'style',
      4 => 'thumb',
      5 => 'keywords',
      6 => 'description',
      7 => 'userid',
      8 => 'updatetime',
      9 => 'timelen',
      10 => 'islink',
      11 => 'inputtime',
    ),
    'orderby' => 'vid ASC',
    'page' => '0',
    'number' => '6',
    'template' => 'tag_pic_time',
    'var_description' => 
    array (
      1 => '日期格式',
      2 => '打开窗口',
      3 => '标题长度',
      4 => '缩略图宽度',
      5 => '缩略图高度',
    ),
    'var_name' => 
    array (
      1 => 'dateformat',
      2 => 'target',
      3 => 'titlelen',
      4 => 'width',
      5 => 'height',
    ),
    'var_value' => 
    array (
      1 => 'Y-m-d',
      2 => '_blank',
      3 => '46',
      4 => '124',
      5 => '94',
    ),
    'type' => '',
    'where' => 
    array (
      'catid' => '',
      'keywords' => '',
      'userid' => '',
      'updatetime' => '',
      'inputtime' => '',
      'posids' => '0',
    ),
    'modelid' => '20',
    'tagcode' => 'tag(\'video\', \'tag_pic_time\', "SELECT vid,catid,title,style,thumb,keywords,description,userid,updatetime,timelen,islink,inputtime FROM phpcms2008_video WHERE  status=99   ORDER BY vid ASC", 0, 6, array (  \'dateformat\' => \'Y-m-d\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',  \'width\' => \'124\',  \'height\' => \'94\',))',
  ),
  '内容页推荐视频6条' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT vid,catid,title,style,thumb,keywords,description,userid,updatetime,timelen,islink,inputtime FROM phpcms2008_video WHERE  status=99   ORDER BY vid DESC',
    'selectfields' => 
    array (
      0 => 'vid',
      1 => 'catid',
      2 => 'title',
      3 => 'style',
      4 => 'thumb',
      5 => 'keywords',
      6 => 'description',
      7 => 'userid',
      8 => 'updatetime',
      9 => 'timelen',
      10 => 'islink',
      11 => 'inputtime',
    ),
    'orderby' => 'vid DESC',
    'page' => '0',
    'number' => '6',
    'template' => 'tag_pic_li',
    'var_description' => 
    array (
      1 => '日期格式',
      2 => '打开窗口',
      3 => '标题长度',
      4 => '缩略图宽度',
      5 => '缩略图高度',
    ),
    'var_name' => 
    array (
      1 => 'dateformat',
      2 => 'target',
      3 => 'titlelen',
      4 => 'width',
      5 => 'height',
    ),
    'var_value' => 
    array (
      1 => 'Y-m-d',
      2 => '_blank',
      3 => '46',
      4 => '104',
      5 => '79',
    ),
    'type' => '',
    'where' => 
    array (
      'catid' => '',
      'keywords' => '',
      'userid' => '',
      'updatetime' => '',
      'inputtime' => '',
      'posids' => '0',
    ),
    'modelid' => '20',
    'tagcode' => 'tag(\'video\', \'tag_pic_li\', "SELECT vid,catid,title,style,thumb,keywords,description,userid,updatetime,timelen,islink,inputtime FROM phpcms2008_video WHERE  status=99   ORDER BY vid DESC", 0, 6, array (  \'dateformat\' => \'Y-m-d\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',  \'width\' => \'104\',  \'height\' => \'79\',))',
  ),
  '视频内容相关视频' => 
  array (
    'introduce' => 'SELECT DISTINCT c.vid,c.title,c.style,c.url FROM `phpcms2008_video` c,`phpcms2008_video_tag` t  WHERE c.vid=t.vid and c.`status`=99 AND t.`tag` IN(".get_sql_in($r[keywords]).") ORDER BY c.vid DESC',
    'mode' => '0',
    'sql' => 'SELECT vid,catid,title,style,thumb,keywords,description,userid,updatetime,timelen,islink,inputtime FROM phpcms2008_video WHERE  status=99   ORDER BY vid ASC',
    'selectfields' => 
    array (
      0 => 'vid',
      1 => 'catid',
      2 => 'title',
      3 => 'style',
      4 => 'thumb',
      5 => 'keywords',
      6 => 'description',
      7 => 'userid',
      8 => 'updatetime',
      9 => 'timelen',
      10 => 'islink',
      11 => 'inputtime',
    ),
    'orderby' => 'vid ASC',
    'page' => '0',
    'number' => '6',
    'template' => 'tag_pic_li',
    'var_description' => 
    array (
      1 => '日期格式',
      2 => '打开窗口',
      3 => '标题长度',
      4 => '缩略图宽度',
      5 => '缩略图高度',
    ),
    'var_name' => 
    array (
      1 => 'dateformat',
      2 => 'target',
      3 => 'titlelen',
      4 => 'width',
      5 => 'height',
    ),
    'var_value' => 
    array (
      1 => 'Y-m-d',
      2 => '_blank',
      3 => '46',
      4 => '100',
      5 => '75',
    ),
    'type' => '',
    'where' => 
    array (
      'catid' => '',
      'keywords' => '',
      'userid' => '',
      'updatetime' => '',
      'inputtime' => '',
      'posids' => '0',
    ),
    'modelid' => '20',
    'tagcode' => 'tag(\'video\', \'tag_pic_li\', "SELECT vid,catid,title,style,thumb,keywords,description,userid,updatetime,timelen,islink,inputtime FROM phpcms2008_video WHERE  status=99   ORDER BY vid ASC", 0, 6, array (  \'dateformat\' => \'Y-m-d\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',  \'width\' => \'100\',  \'height\' => \'75\',))',
  ),
  '视频首页焦点幻灯片' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=2 AND a.status=99   ORDER BY a.vid DESC',
    'selectfields' => 
    array (
      0 => 'vid',
      1 => 'catid',
      2 => 'title',
      3 => 'style',
      4 => 'thumb',
      5 => 'keywords',
      6 => 'description',
      7 => 'userid',
      8 => 'updatetime',
      9 => 'timelen',
      10 => 'islink',
      11 => 'inputtime',
    ),
    'orderby' => 'vid DESC',
    'page' => '0',
    'number' => '5',
    'template' => 'tag_flash',
    'var_description' => 
    array (
      2 => '打开窗口',
      3 => '标题长度',
      4 => '宽度',
      5 => '高度',
    ),
    'var_name' => 
    array (
      2 => 'target',
      3 => 'titlelen',
      4 => 'width',
      5 => 'height',
    ),
    'var_value' => 
    array (
      2 => '_blank',
      3 => '46',
      4 => '456',
      5 => '383',
    ),
    'type' => '',
    'where' => 
    array (
      'catid' => '',
      'keywords' => '',
      'userid' => '',
      'updatetime' => '',
      'inputtime' => '',
      'posids' => '2',
    ),
    'modelid' => '20',
    'tagcode' => 'tag(\'video\', \'tag_flash\', "SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=2 AND a.status=99   ORDER BY a.vid DESC", 0, 5, array (  \'target\' => \'_blank\',  \'titlelen\' => \'46\',  \'width\' => \'456\',  \'height\' => \'383\',))',
  ),
  '视频首页热点视频' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=1 AND a.status=99   ORDER BY a.vid ASC',
    'selectfields' => 
    array (
      0 => 'vid',
      1 => 'catid',
      2 => 'title',
      3 => 'style',
      4 => 'thumb',
      5 => 'keywords',
      6 => 'description',
      7 => 'userid',
      8 => 'updatetime',
      9 => 'timelen',
      10 => 'islink',
      11 => 'inputtime',
    ),
    'orderby' => 'vid ASC',
    'page' => '0',
    'number' => '5',
    'template' => 'tag_pic_index',
    'var_description' => 
    array (
      1 => '日期格式',
      2 => '打开窗口',
      3 => '标题长度',
      4 => '缩略图宽度',
      5 => '缩略图高度',
    ),
    'var_name' => 
    array (
      1 => 'dateformat',
      2 => 'target',
      3 => 'titlelen',
      4 => 'width',
      5 => 'height',
    ),
    'var_value' => 
    array (
      1 => 'Y-m-d',
      2 => '_blank',
      3 => '46',
      4 => '72',
      5 => '54',
    ),
    'type' => '',
    'where' => 
    array (
      'catid' => '',
      'keywords' => '',
      'userid' => '',
      'updatetime' => '',
      'inputtime' => '',
      'posids' => '1',
    ),
    'modelid' => '20',
    'tagcode' => 'tag(\'video\', \'tag_pic_index\', "SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=1 AND a.status=99   ORDER BY a.vid ASC", 0, 5, array (  \'dateformat\' => \'Y-m-d\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',  \'width\' => \'72\',  \'height\' => \'54\',))',
  ),
  '栏目页头条' => 
  array (
    'introduce' => '调用的视频信息为首页头条',
    'mode' => '0',
    'sql' => 'SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=2 AND a.status=99  ".get_sql_catid($catid)." ORDER BY a.vid DESC',
    'selectfields' => 
    array (
      0 => 'vid',
      1 => 'catid',
      2 => 'title',
      3 => 'style',
      4 => 'thumb',
      5 => 'keywords',
      6 => 'description',
      7 => 'userid',
      8 => 'updatetime',
      9 => 'timelen',
      10 => 'islink',
      11 => 'inputtime',
    ),
    'orderby' => 'vid DESC',
    'page' => '0',
    'number' => '1',
    'template' => 'tag_pic_cat',
    'var_description' => 
    array (
      1 => '日期格式',
      2 => '打开窗口',
      3 => '标题长度',
      4 => '缩略图宽度',
      5 => '缩略图高度',
    ),
    'var_name' => 
    array (
      1 => 'dateformat',
      2 => 'target',
      3 => 'titlelen',
      4 => 'width',
      5 => 'height',
    ),
    'var_value' => 
    array (
      1 => 'Y-m-d',
      2 => '_blank',
      3 => '46',
      4 => '291',
      5 => '243',
    ),
    'type' => '',
    'where' => 
    array (
      'catid' => '$catid',
      'keywords' => '',
      'userid' => '',
      'updatetime' => '',
      'inputtime' => '',
      'posids' => '2',
    ),
    'modelid' => '20',
    'tagcode' => 'tag(\'video\', \'tag_pic_cat\', "SELECT a.vid,a.catid,a.title,a.style,a.thumb,a.keywords,a.description,a.userid,a.updatetime,a.timelen,a.islink,a.inputtime FROM `phpcms2008_video` a, `phpcms2008_video_position` p WHERE a.vid=p.vid AND p.posid=2 AND a.status=99  ".get_sql_catid($catid)." ORDER BY a.vid DESC", 0, 1, array (  \'dateformat\' => \'Y-m-d\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',  \'width\' => \'291\',  \'height\' => \'243\',))',
  ),
);
?>