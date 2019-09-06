<?php
return array (
  '商家最新消息' => 
  array (
    'introduce' => '商家最新消息',
    'mode' => '0',
    'sql' => 'SELECT userid,id,inputtime,updatetime,title,style,thumb,listorder FROM `phpcms2008_yp_news` WHERE  status=99   AND  `userid`=\'$userid\'  ORDER BY id ASC',
    'selectfields' => 
    array (
      0 => 'userid',
      1 => 'id',
      2 => 'inputtime',
      3 => 'updatetime',
      4 => 'title',
      5 => 'style',
      6 => 'thumb',
      7 => 'listorder',
    ),
    'orderby' => 'id ASC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_content',
    'var_description' => 
    array (
      1 => '显示日期',
      2 => '打开窗口',
      3 => '标题长度',
      4 => '缩略图宽度',
      5 => '缩略图高度',
    ),
    'var_name' => 
    array (
      1 => 'showdate',
      2 => 'target',
      3 => 'titlelen',
      4 => 'width',
      5 => 'height',
    ),
    'var_value' => 
    array (
      1 => '1',
      2 => '_blank',
      3 => '46',
      4 => '100',
      5 => '75',
    ),
    'type' => 'news',
    'where' => 
    array (
      'userid' => '$userid',
    ),
    'modelid' => '12',
    'tagcode' => 'tag(\'yp\', \'tag_content\', "SELECT userid,id,inputtime,updatetime,title,style,thumb,listorder FROM `phpcms2008_yp_news` WHERE  status=99   AND  `userid`=\'$userid\'  ORDER BY id ASC", 0, 10, array (  \'showdate\' => \'1\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',  \'width\' => \'100\',  \'height\' => \'75\',))',
  ),
  '最新产品' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT id,title,catid,style,keywords,price,quantifier,inputtime,updatetime FROM `phpcms2008_yp_product` WHERE  status=99   AND  `elite`=\'0\' ".get_sql_catid($catid)." ORDER BY id ASC',
    'selectfields' => 
    array (
      0 => 'id',
      1 => 'title',
      2 => 'catid',
      3 => 'style',
      4 => 'keywords',
      5 => 'price',
      6 => 'quantifier',
      7 => 'inputtime',
      8 => 'updatetime',
    ),
    'orderby' => 'id ASC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_content',
    'var_description' => 
    array (
      1 => '显示日期',
      4 => '缩略图宽度',
    ),
    'var_name' => 
    array (
      1 => 'showdate',
      4 => 'width',
    ),
    'var_value' => 
    array (
      1 => '1',
      4 => '100',
    ),
    'type' => 'product',
    'where' => 
    array (
      'catid' => '$catid',
      'userid' => '',
      'price' => '',
      'elite' => '0',
    ),
    'modelid' => '13',
    'tagcode' => 'tag(\'yp\', \'tag_content\', "SELECT id,title,catid,style,keywords,price,quantifier,inputtime,updatetime FROM `phpcms2008_yp_product` WHERE  status=99   AND  `elite`=\'0\' ".get_sql_catid($catid)." ORDER BY id ASC", 0, 10, array (  \'showdate\' => \'1\',  \'width\' => \'100\',))',
  ),
 
);
?>