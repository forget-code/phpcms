<?php
$settings['xspace'] = array (
  'importtime' => '',
  'name' => 'xspace',
  'note' => 'X-Space 日志导入',
  'dbfrom' => '1',
  'database' => 'mysql',
  'dbhost' => 'localhost',
  'dbuser' => 'admin',
  'dbpw' => 'admin',
  'dbname' => 'supesite',
  'table' => 'supe_spaceblogs a,supe_spaceitems b',
  'selectfield' => '*',
  'condition' => 'a.itemid=b.itemid AND a.itemid>$maxid AND b.type=\\\'blog\\\'',
  'maxid' => '0',
  'isuseoldid' => '0',
  'articleid' => 
  array (
    'field' => 'itemid',
    'value' => '',
    'func' => '',
  ),
  'catid' => 
  array (
    'field' => 'catid',
    'value' => '',
    'func' => 'get_catid',
  ),
  'typeid' => 
  array (
    'field' => 'itemtypeid',
    'value' => '',
    'func' => '',
  ),
  'title' => 
  array (
    'field' => 'subject',
    'value' => '',
    'func' => '',
  ),
  'titleintact' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'subheading' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'style' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'showcommentlink' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'introduce' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'keywords' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'author' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'copyfrom' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'content' => 
  array (
    'field' => 'message',
    'value' => '',
    'func' => '',
  ),
  'paginationtype' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'maxcharperpage' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'hits' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'comments' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'thumb' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'username' => 
  array (
    'field' => 'username',
    'value' => '',
    'func' => '',
  ),
  'addtime' => 
  array (
    'field' => 'dateline',
    'value' => '',
    'func' => '',
  ),
  'editor' => 
  array (
    'field' => 'username',
    'value' => '',
    'func' => '',
  ),
  'edittime' => '',
  'checker' => 
  array (
    'field' => 'username',
    'value' => '',
    'func' => '',
  ),
  'checktime' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'templateid' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'skinid' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'posid' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'status' => 
  array (
    'field' => '',
    'value' => '3',
    'func' => '',
  ),
  'listorder' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'arrgroupidview' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'readpoint' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'ishtml' => 
  array (
    'field' => '',
    'value' => '1',
    'func' => '',
  ),
  'htmldir' => 
  array (
    'field' => '',
    'value' => 'article',
    'func' => '',
  ),
  'prefix' => 
  array (
    'field' => '',
    'value' => 'article_',
    'func' => '',
  ),
  'urlruleid' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'islink' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'linkurl' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'defaultcatid' => '3',
  'catids' => 
  array (
    3 => '',
    4 => '',
  ),
  'articlecheck' => '1',
  'timelimit' => '90',
  'number' => '100',
);
?>