<?php
return array (
  'dedecms5.3' => 
  array (
    'modelid' => '1',
    'dataname' => '',
    'name' => 'dedecms5.3',
    'note' => 'dedecms5.3咨询导入配置文件',
    'dbtype' => 'mysql',
    'dbhost' => 'localhost',
    'dbuser' => '',
    'dbpw' => '',
    'charset' => '',
    'dbname' => '',
    'table' => 'dede_addonarticle,dede_archives',
    'condition' => 'dede_addonarticle.aid=dede_archives.id AND dede_addonarticle.aid>$maxid',
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
    'title' => 
    array (
      'field' => 'shorttitle',
      'value' => '',
      'func' => '',
    ),
    'titleintact' => 
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
      'field' => 'litpic',
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
      'field' => 'senddate',
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
      'field' => 'redirecturl',
      'value' => '',
      'func' => '',
    ),
    'inputtime' => 
    array (
      'field' => 'pubdate',
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
    'prefix' => 
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
      'value' => '',
      'func' => '',
    ),
    'template' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'defaultcatid' => '27',
    'catids' => 
    array (
      27 => '',
      33 => '',
      37 => '',
    ),
    'number' => '100',
    'expire' => '90',
    'edittime' => 1229668046,
  ),
);
?>