<?php
return array (
  '首页最新公告' => 
  array (
    'func' => 'announce',
    'introduce' => '',
    'page' => '0',
    'announcenum' => '5',
    'datetype' => '0',
    'template' => 'tag_announce',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '标题字数',
      4 => '是否显示作者',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'titlelen',
      4 => 'showauthor',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '46',
      4 => '0',
    ),
    'number' => '5',
    'type' => 'announce',
    'sql' => 'SELECT * FROM phpcms2008_announce ORDER BY announceid DESC',
    'tagcode' => 'tag(\'announce\', \'tag_announce\', "SELECT * FROM phpcms2008_announce ORDER BY announceid DESC", 0, 6, array (  \'class\' => \'url\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',  \'showauthor\' => \'0\',))',
  ),
  '会员中心公告' => 
  array (
    'func' => 'announce',
    'introduce' => '',
    'page' => '0',
    'announcenum' => '1',
    'datetype' => '0',
    'template' => 'tag_announce_member',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
    ),
    'number' => '1',
    'type' => 'announce',
    'sql' => 'SELECT * FROM phpcms2008_announce ORDER BY announceid DESC',
    'tagcode' => 'tag(\'announce\', \'tag_announce_member\', "SELECT * FROM phpcms2008_announce ORDER BY announceid DESC", 0, 1, array (  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
);
?>