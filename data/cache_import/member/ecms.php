<?php
return array (
  '帝国会员信息导入' => 
  array (
    'modelid' => '10',
    'dataname' => '',
    'name' => '帝国会员信息导入',
    'note' => '帝国5.0会员信息导入配置文件',
    'dbtype' => '',
    'dbhost' => '',
    'dbuser' => '',
    'dbpw' => '',
    'charset' => '',
    'dbname' => '',
    'table' => 'phome_enewsmember,phome_enewsmemberadd',
    'condition' => 'phome_enewsmember.userid=phome_enewsmemberadd.userid AND phome_enewsmember.userid>$maxid',
    'maxid' => '0',
    'userid' => 
    array (
      'field' => 'userid',
      'value' => '',
      'func' => '',
    ),
    'username' => 
    array (
      'field' => 'username',
      'value' => '',
      'func' => '',
    ),
    'password' => 
    array (
      'field' => 'password',
      'value' => '',
      'func' => '',
    ),
    'email' => 
    array (
      'field' => 'email',
      'value' => '',
      'func' => '',
    ),
    'question' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'answer' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'groupid' => 
    array (
      'field' => 'groupid',
      'value' => '',
      'func' => '',
    ),
    'gender' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'amount' => 
    array (
      'field' => 'money',
      'value' => '',
      'func' => '',
    ),
    'point' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'regip' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'regtime' => 
    array (
      'field' => 'registertime',
      'value' => '',
      'func' => '',
    ),
    'lastloginip' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'lastlogintime' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'logintimes' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'ddd' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'truename' => 
    array (
      'field' => 'truename',
      'value' => '',
      'func' => '',
    ),
    'defaultgroupid' => '1',
    'groupids' => 
    array (
      1 => '',
      2 => '',
      3 => '',
      4 => '',
      5 => '',
      6 => '',
      7 => '',
      8 => '',
    ),
    'membercheck' => '1',
    'number' => '100',
    'expire' => '90',
    'edittime' => 0,
  ),
);
?>