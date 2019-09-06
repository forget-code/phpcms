<?php
$settings['PHP168'] = array (
  'importtime' => '',
  'name' => 'PHP168',
  'note' => 'PHP168 V4 数据导入配置文件',
  'dbfrom' => '1',
  'database' => 'mysql',
  'dbhost' => 'localhost',
  'dbuser' => 'root',
  'dbpw' => '',
  'dbname' => 't1',
  'table' => 'p8_article,p8_reply',
  'selectfield' => 'p8_article.*,p8_reply.*',
  'condition' => 'p8_article.aid=p8_reply.aid',
  'maxid' => '0',
  'isuseoldid' => '0',
  'articleid' => 
  array (
    'field' => 'aid',
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
    'field' => 'smalltitle',
    'value' => '',
    'func' => '',
  ),
  'style' => 
  array (
    'field' => 'titlecolor',
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
    'field' => 'author',
    'value' => '',
    'func' => '',
  ),
  'copyfrom' => 
  array (
    'field' => 'copyfrom',
    'value' => '',
    'func' => '',
  ),
  'content' => 
  array (
    'field' => 'content',
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
    'field' => 'hits',
    'value' => '',
    'func' => '',
  ),
  'comments' => 
  array (
    'field' => 'comments',
    'value' => '',
    'func' => '',
  ),
  'thumb' => 
  array (
    'field' => 'picurl',
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
    'field' => 'posttime',
    'value' => '',
    'func' => '',
  ),
  'editor' => 
  array (
    'field' => 'editer',
    'value' => '',
    'func' => '',
  ),
  'edittime' => '',
  'checker' => 
  array (
    'field' => 'yzer',
    'value' => '',
    'func' => '',
  ),
  'checktime' => 
  array (
    'field' => 'yztime',
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
    'field' => 'jumpurl',
    'value' => '',
    'func' => '',
  ),
  'defaultcatid' => '0',
  'articlecheck' => '0',
  'timelimit' => '90',
  'number' => '100',
);
?>