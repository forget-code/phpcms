<?php
return array (
  '用户测试标签' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT a.userid,a.username,a.groupid,a.point,a.amount,a.areaid FROM `phpcms2008_member_cache` a, `phpcms2008_member_info` i, `phpcms2008_member_detail` b WHERE a.userid=b.userid AND a.userid=i.userid  ORDER BY a.point ASC',
    'selectfields' => 
    array (
      0 => 'userid',
      1 => 'username',
      2 => 'groupid',
      3 => 'point',
      4 => 'amount',
      5 => 'areaid',
    ),
    'orderby' => 'a.point ASC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_member',
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
    'where' => 
    array (
      'userid' => '',
      'username' => '',
      'groupid' => '',
      'point' => '',
      'amount' => '',
      'areaid' => '',
    ),
    'modelid' => '10',
    'tagcode' => 'tag(\'member\', \'tag_member\', "SELECT a.userid,a.username,a.groupid,a.point,a.amount,a.areaid FROM `phpcms2008_member_cache` a, `phpcms2008_member_info` i, `phpcms2008_member_detail` b WHERE a.userid=b.userid AND a.userid=i.userid  ORDER BY a.point ASC", 0, 10, array (  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
  '按模型列出用户' => 
  array (
    'introduce' => '',
    'mode' => '1',
    'sql' => 'SELECT * FROM `phpcms2008_member_cache` a, `phpcms2008_member_info` i WHERE a.userid=i.userid AND a.modelid=\'$modelid\'AND a.disabled=0 ORDER BY a.userid ASC',
    'selectfields' => 
    array (
      0 => 'truename',
      1 => 'gender',
      2 => 'birthday',
      3 => 'address',
      4 => 'userid',
      5 => 'username',
      6 => 'groupid',
    ),
    'orderby' => 'a.userid ASC',
    'page' => '$page',
    'number' => '10',
    'template' => 'tag_list',
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
    'modelid' => '10',
    'tagcode' => 'tag(\'member\', \'tag_list\', "SELECT * FROM `phpcms2008_member_cache` a, `phpcms2008_member_info` i WHERE a.userid=i.userid AND a.modelid=\'$modelid\'AND a.disabled=0 ORDER BY a.userid ASC", $page, 10, array (  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
  '用户详细列表' => 
  array (
    'introduce' => '用户详细列表',
    'mode' => '0',
    'sql' => 'SELECT b.qq,a.userid,a.username,a.groupid,a.point,a.amount,a.areaid,a.modelid FROM `phpcms2008_member_cache` a, `phpcms2008_member_info` i, `phpcms2008_member_detail` b WHERE a.userid=b.userid AND a.userid=i.userid  ORDER BY a.point ASC',
    'selectfields' => 
    array (
      0 => 'qq',
      1 => 'userid',
      2 => 'username',
      3 => 'groupid',
      4 => 'point',
      5 => 'amount',
      6 => 'areaid',
      7 => 'modelid',
    ),
    'orderby' => 'a.point ASC',
    'page' => '$page',
    'number' => '10',
    'template' => 'tag_list',
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
    'where' => 
    array (
      'userid' => '',
      'username' => '',
      'groupid' => '',
      'point' => '',
      'amount' => '',
      'areaid' => '',
    ),
    'modelid' => '10',
    'tagcode' => 'tag(\'member\', \'tag_list\', "SELECT b.qq,a.userid,a.username,a.groupid,a.point,a.amount,a.areaid,a.modelid FROM `phpcms2008_member_cache` a, `phpcms2008_member_info` i, `phpcms2008_member_detail` b WHERE a.userid=b.userid AND a.userid=i.userid  ORDER BY a.point ASC", $page, 10, array (  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
);
?>