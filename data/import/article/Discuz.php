<?php
$settings['Discuz'] = array (
  'importtime' => '1171012197',
  'name' => 'Discuz',
  'note' => '论坛精华主题(4.x,5.x)',
  'dbfrom' => '1',
  'database' => 'mysql',
  'dbhost' => 'localhost',
  'dbuser' => 'test',
  'dbpw' => 'test',
  'dbname' => 'test',
  'table' => 'cdb_threads t,cdb_posts p',
  'selectfield' => '*',
  'condition' => 't.tid=p.tid and t.dateline=p.dateline and t.digest>0',
  'maxid' => '4',
  'isuseoldid' => '0',
  'articleid' => 
  array (
    'field' => 'tid',
    'value' => '',
    'func' => '',
  ),
  'catid' => 
  array (
    'field' => 'fid',
    'value' => '',
    'func' => 'get_catid',
  ),
  'typeid' => 
  array (
    'field' => '',
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
    'field' => 'views',
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
    'field' => 'author',
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
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'edittime' => 1175506116,
  'checker' => 
  array (
    'field' => '',
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
    'value' => 'html',
    'func' => '',
  ),
  'prefix' => 
  array (
    'field' => '',
    'value' => '',
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
    2 => '',
    3 => '',
  ),
  'articlecheck' => '1',
  'timelimit' => '90',
  'number' => '100',
);
?>