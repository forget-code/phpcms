<?php
$settings['phparticle'] = array (
  'importtime' => '',
  'name' => 'phparticle',
  'note' => 'phpArticle 2.0 文章导入配置文件',
  'dbfrom' => '1',
  'database' => 'mysql',
  'dbhost' => 'localhost',
  'dbuser' => 'root',
  'dbpw' => '',
  'dbname' => 't4',
  'table' => 'pa_article,pa_articletext',
  'selectfield' => 'pa_article.*,pa_articletext.*',
  'condition' => 'pa_article.articleid=pa_articletext.articleid and visible=1',
  'maxid' => '0',
  'isuseoldid' => '0',
  'articleid' => 
  array (
    'field' => 'articleid',
    'value' => '',
    'func' => '',
  ),
  'catid' => 
  array (
    'field' => '',
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
    'field' => 'subhead',
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
    'field' => 'keyword',
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
    'field' => 'source',
    'value' => '',
    'func' => '',
  ),
  'content' => 
  array (
    'field' => 'articletext',
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
    'field' => 'comments',
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
    'field' => 'date',
    'value' => '',
    'func' => '',
  ),
  'editor' => 
  array (
    'field' => 'editor',
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
    'field' => 'displayorder',
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
    'value' => '',
    'func' => '',
  ),
  'htmldir' => 
  array (
    'field' => '',
    'value' => '',
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
  'defaultcatid' => '0',
  'catids' => 
  array (
    896 => '',
  ),
  'articlecheck' => '0',
  'timelimit' => '90',
  'number' => '100',
);
?>