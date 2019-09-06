<?php
$settings['dedecms'] = array (
  'importtime' => '',
  'name' => 'dedecms',
  'note' => 'dedecms3.x会员数据导入配置',
  'dbfrom' => '1',
  'database' => 'mysql',
  'dbhost' => 'localhost',
  'dbuser' => 'test',
  'dbpw' => 'test',
  'dbname' => 'test',
  'table' => 'dede_member',
  'condition' => 'ID>$maxid',
  'maxid' => '1',
  'isuseoldid' => '0',
  'userid' => 
  array (
    'field' => 'ID',
    'value' => '',
    'func' => '',
  ),
  'username' => 
  array (
    'field' => 'uname',
    'value' => '',
    'func' => '',
  ),
  'password' => 
  array (
    'field' => 'pwd',
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
    'field' => 'membertype',
    'value' => '',
    'func' => 'get_groupid',
  ),
  'truename' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'gender' => 
  array (
    'field' => 'sex',
    'value' => '',
    'func' => '',
  ),
  'birthday' => 
  array (
    'field' => 'birthday',
    'value' => '',
    'func' => '',
  ),
  'homepage' => 
  array (
    'field' => 'homepage',
    'value' => '',
    'func' => '',
  ),
  'qq' => 
  array (
    'field' => 'oicq',
    'value' => '',
    'func' => '',
  ),
  'msn' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'address' => 
  array (
    'field' => 'address',
    'value' => '',
    'func' => '',
  ),
  'postid' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'telephone' => 
  array (
    'field' => 'tel',
    'value' => '',
    'func' => '',
  ),
  'credit' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'point' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'money' => 
  array (
    'field' => 'money',
    'value' => '',
    'func' => '',
  ),
  'begindate' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'enddate' => 
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
    'field' => '',
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
    'field' => 'loginip',
    'value' => '',
    'func' => '',
  ),
  'defaultgroupid' => '6',
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
    9 => '',
    10 => '',
  ),
  'membercheck' => '1',
  'timelimit' => '600',
  'number' => '1000',
  'edittime' => '',
);
?>