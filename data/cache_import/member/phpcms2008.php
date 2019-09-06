<?php
return array (
  'phpcms2008会员导入' => 
  array (
    'modelid' => '10',
    'dataname' => '',
    'name' => 'phpcms2008会员导入',
    'note' => 'phpcms2008会员导入配置文件',
    'dbtype' => 'mysql',
    'dbhost' => '',
    'dbuser' => '',
    'dbpw' => '',
    'charset' => '',
    'dbname' => '',
    'table' => 'phpcms_member,phpcms_member_info',
    'condition' => 'phpcms_member.userid=phpcms_member_info.userid AND phpcms_member.userid>$maxid',
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
      'field' => 'question',
      'value' => '',
      'func' => '',
    ),
    'answer' => 
    array (
      'field' => 'answer',
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
      'field' => 'gender',
      'value' => '',
      'func' => '',
    ),
    'amount' => 
    array (
      'field' => 'amount',
      'value' => '',
      'func' => '',
    ),
    'point' => 
    array (
      'field' => 'point',
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
      'field' => 'regtime',
      'value' => '',
      'func' => '',
    ),
    'lastloginip' => 
    array (
      'field' => 'lastloginip',
      'value' => '',
      'func' => '',
    ),
    'lastlogintime' => 
    array (
      'field' => 'lastlogintime',
      'value' => '',
      'func' => '',
    ),
    'logintimes' => 
    array (
      'field' => 'logintimes',
      'value' => '',
      'func' => '',
    ),
    'defaultgroupid' => '',
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
    'maxid' => '1',
  ),
);
?>