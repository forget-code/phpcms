<?php
return array (
  'phpcms2008' => 
  array (
    'modelid' => '1',
    'dataname' => '',
    'name' => 'phpcms资讯导入',
    'note' => 'phpcms2008资讯导入配置文件',
    'dbtype' => '',
    'dbhost' => '',
    'dbuser' => '',
    'dbpw' => '',
    'charset' => '',
    'dbname' => '',
    'table' => 'phpcms_content,phpcms_c_news',
    'condition' => 'phpcms_content.contentid=phpcms_c_news.contentid AND phpcms_content.contentid>$maxid',
    'maxid' => '10',
    'contentid' => 
    array (
      'field' => 'contentid',
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
      'field' => 'typeid',
      'value' => '',
      'func' => '',
    ),
    'areaid' => 
    array (
      'field' => 'areaid',
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
      'field' => 'style',
      'value' => '',
      'func' => '',
    ),
    'thumb' => 
    array (
      'field' => 'thumb',
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
      'field' => 'username',
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
      'field' => 'description',
      'value' => '',
      'func' => '',
    ),
    'userid' => 
    array (
      'field' => 'userid',
      'value' => '',
      'func' => '',
    ),
    'updatetime' => 
    array (
      'field' => 'updatetime',
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
      'field' => 'islink',
      'value' => '',
      'func' => '',
    ),
    'inputtime' => 
    array (
      'field' => 'inputtime',
      'value' => '',
      'func' => '',
    ),
    'posids' => 
    array (
      'field' => 'posids',
      'value' => '',
      'func' => '',
    ),
    'groupids_view' => 
    array (
      'field' => 'groupids_view',
      'value' => '',
      'func' => '',
    ),
    'readpoint' => 
    array (
      'field' => 'readpoint',
      'value' => '',
      'func' => '',
    ),
    'url' => 
    array (
      'field' => 'url',
      'value' => '',
      'func' => '',
    ),
    'listorder' => 
    array (
      'field' => 'listorder',
      'value' => '',
      'func' => '',
    ),
    'status' => 
    array (
      'field' => 'status',
      'value' => '',
      'func' => '',
    ),
    'template' => 
    array (
      'field' => 'template',
      'value' => '',
      'func' => '',
    ),
    'defaultcatid' => '',
    'catids' => 
    array (
      11 => '',
      12 => '',
    ),
    'number' => '50',
    'expire' => '90',
    'edittime' => 0,
  ),
);
?>