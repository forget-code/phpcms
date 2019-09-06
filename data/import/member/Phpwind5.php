<?php
$settings['Phpwind5'] = array (
  'importtime' => '',
  'name' => 'Phpwind5',
  'note' => 'Phpwind5会员数据导入',
  'dbfrom' => '1',
  'database' => 'mysql',
  'dbhost' => 'localhost',
  'dbuser' => 'test',
  'dbpw' => 'test',
  'dbname' => 'test',
  'table' => 'pw_members a,pw_memberdata b',
  'condition' => 'a.uid=b.uid and a.uid>$maxid',
  'maxid' => '1',
  'isuseoldid' => '0',
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
    'field' => 'gender',
    'value' => '',
    'func' => '',
  ),
  'birthday' => 
  array (
    'field' => 'bday',
    'value' => '',
    'func' => '',
  ),
  'homepage' => 
  array (
    'field' => 'site',
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
    'field' => 'msn',
    'value' => '',
    'func' => '',
  ),
  'address' => 
  array (
    'field' => 'location',
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
    'field' => '',
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
    'field' => '',
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
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'lastlogintime' => 
  array (
    'field' => 'lastvisit',
    'value' => '',
    'func' => '',
  ),
  'logintimes' => 
  array (
    'field' => '',
    'value' => '',
    'func' => '',
  ),
  'defaultgroupid' => '6',
  'groupids' => 
  array (
    1 => '3',
    2 => '',
    3 => '',
    4 => '',
    5 => '7',
    6 => '',
    7 => '',
    8 => '',
    9 => '',
    10 => '',
  ),
  'membercheck' => '1',
  'timelimit' => '90',
  'number' => '100',
  'edittime' => '',
);
?>