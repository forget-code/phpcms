<?php
return array (
  'DeDe会员信息导入' => 
  array (
    'modelid' => '10',
    'dataname' => '',
    'name' => 'DeDe会员信息导入',
    'note' => 'DeDe5.1会员信息导入配置文件',
    'dbtype' => 'mysql',
    'dbhost' => '',
    'dbuser' => '',
    'dbpw' => '',
    'charset' => '',
    'dbname' => '',
    'table' => 'dede_member',
    'condition' => 'dede_member.ID>$maxid',
    'maxid' => 1,
    'userid' => 
    array (
      'field' => 'ID',
      'value' => '',
      'func' => '',
    ),
    'username' => 
    array (
      'field' => 'userid',
      'value' => '',
      'func' => '',
    ),
    'password' => 
    array (
      'field' => 'pwd',
      'value' => '',
      'func' => 'get_groupid',
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
      'field' => 'membertype',
      'value' => '',
      'func' => '',
    ),
    'gender' => 
    array (
      'field' => 'sex',
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
      'field' => 'joinip',
      'value' => '',
      'func' => '',
    ),
    'regtime' => 
    array (
      'field' => 'jointime',
      'value' => '',
      'func' => '',
    ),
    'lastloginip' => 
    array (
      'field' => 'loginip',
      'value' => '',
      'func' => '',
    ),
    'lastlogintime' => 
    array (
      'field' => 'logintime',
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
      'field' => 'uname',
      'value' => '',
      'func' => '',
    ),
    'defaultgroupid' => 1,
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