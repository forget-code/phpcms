<?php
return array (
  'PHP168' => 
  array (
    'modelid' => '1',
    'dataname' => '',
    'name' => 'PHP168',
    'note' => 'PHP168v5.0资讯导入配置文件',
    'dbtype' => 'mysql',
    'dbhost' => '',
    'dbuser' => '',
    'dbpw' => '',
    'charset' => '',
    'dbname' => '',
    'table' => 'p8_article,p8_reply',
    'condition' => 'p8_article.aid=p8_reply.aid AND p8_article.aid>$maxid',
    'maxid' => '0',
    'contentid' => 
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
    'areaid' => 
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
    'style' => 
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
    'description' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'userid' => 
    array (
      'field' => 'username',
      'value' => '',
      'func' => '',
    ),
    'updatetime' => 
    array (
      'field' => 'edittime',
      'value' => '',
      'func' => '',
    ),
    'content' => 
    array (
      'field' => 'content',
      'value' => '',
      'func' => '',
    ),
    'islink' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'inputtime' => 
    array (
      'field' => 'posttime',
      'value' => '',
      'func' => '',
    ),
    'posids' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'groupids_view' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'readpoint' => 
    array (
      'field' => 'money',
      'value' => '',
      'func' => '',
    ),
    'url' => 
    array (
      'field' => 'jumpurl',
      'value' => '',
      'func' => '',
    ),
    'listorder' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'status' => 
    array (
      'field' => '',
      'value' => '99',
      'func' => '',
    ),
    'template' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'defaultcatid' => '',
    'catids' => 
    array (
      11 => '',
      12 => '',
      13 => '',
    ),
    'number' => '50',
    'expire' => '90',
    'edittime' => 0,
	'maxid' => '0',
  ),
);
?>