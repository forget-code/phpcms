<?php
return array (
  'PHP168会员导入' => 
  array (
    'modelid' => '10',
    'dataname' => '',
    'name' => 'PHP168会员导入',
    'note' => 'PHP168v5会员导入配置文件',
    'dbtype' => '',
    'dbhost' => '',
    'dbuser' => '',
    'dbpw' => '',
    'charset' => '',
    'dbname' => '',
    'table' => 'p8_members,p8_memberdata',
    'condition' => 'p8_members.uid=p8_memberdata.uid AND p8_members.uid>$maxid',
    'maxid' => '1',
    'userid' => 
    array (
      'field' => 'uid',
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
      'field' => 'regip',
      'value' => '',
      'func' => '',
    ),
    'regtime' => 
    array (
      'field' => 'regdate',
      'value' => '',
      'func' => '',
    ),
    'lastloginip' => 
    array (
      'field' => 'regip',
      'value' => '',
      'func' => '',
    ),
    'lastlogintime' => 
    array (
      'field' => 'lastvist',
      'value' => '',
      'func' => '',
    ),
    'logintimes' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'mulitoptions' => 
    array (
      'field' => '',
      'value' => '',
      'func' => '',
    ),
    'textarea' => 
    array (
      'field' => '',
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
    ),
    'membercheck' => '1',
    'number' => '100',
    'expire' => '90',
    'edittime' => 0,
  ),
);
?>