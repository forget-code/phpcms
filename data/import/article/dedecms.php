<?php
$settings['dedecms'] = array (
  'importtime' => '',
  'name' => 'dedecms',
  'note' => 'dedecms3x',
  'dbfrom' => '1',
  'database' => 'mysql',
  'dbhost' => 'localhost',
  'dbuser' => 'test',
  'dbpw' => 'test',
  'dbname' => 'test',
  'table' => 'dede_archives a,dede_addonarticle b',
  'selectfield' => '*',
  'condition' => 'a.ID=b.aid AND a.ID>$maxid',
  'maxid' => '0',
  'isuseoldid' => '0',
  'articleid' => 
  array (
    'field' => 'ID',
    'value' => '',
    'func' => '',
  ),
  'catid' => 
  array (
    'field' => 'channel',
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
    'field' => 'title',
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
    'field' => 'description',
    'value' => '',
    'func' => '',
  ),
  'keywords' => 
  array (
    'field' => 'keywords',
    'value' => '',
    'func' => '',
  ),
  'author' => 
  array (
    'field' => 'writer',
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
    'field' => 'body',
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
    'field' => 'writer',
    'value' => '',
    'func' => '',
  ),
  'addtime' => 
  array (
    'field' => 'pubdate',
    'value' => '',
    'func' => '',
  ),
  'editor' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'edittime' => '',
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