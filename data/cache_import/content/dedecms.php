<?php
return array (
  'dedecms' => 
  array (
    'modelid' => '1',
    'dataname' => '',
    'name' => 'dedecms',
    'note' => 'dedecms5.1资讯导入配置文件',
    'dbtype' => '',
    'dbhost' => '',
    'dbuser' => '',
    'dbpw' => '',
    'charset' => '',
    'dbname' => '',
    'table' => 'dede_addonarticle,dede_archives',
    'condition' => 'dede_addonarticle.aid=dede_archives.ID AND dede_addonarticle.aid>$maxid',
    'maxid' => '0',
    'contentid' => 
    array (
      'field' => 'aid',
      'value' => '',
      'func' => '',
    ),
    'catid' => 
    array (
      'field' => 'typeid',
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
      'field' => 'writer',
      'value' => '',
      'func' => '',
    ),
    'copyfrom' => 
    array (
      'field' => 'source',
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
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'updatetime' => 
    array (
      'field' => 'endtime',
      'value' => '',
      'func' => '',
    ),
    'content' => 
    array (
      'field' => 'body',
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
      'field' => '',
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
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'url' => 
    array (
      'field' => '',
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
    'defaultcatid' => '11',
    'catids' => 
    array (
      11 => '',
      12 => '',
      13 => '',
    ),
    'number' => '50',
    'expire' => '90',
    'edittime' => 0,
  ),
);
?>