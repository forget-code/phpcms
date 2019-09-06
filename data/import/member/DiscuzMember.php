<?php
$settings['DiscuzMember'] = array (
  'importtime' => 1171006750,
  'name' => 'DiscuzMember',
  'note' => 'Discuz论坛用户数据导入配置',
  'dbfrom' => '1',
  'database' => 'mysql',
  'dbhost' => 'localhost',
  'dbuser' => 'test',
  'dbpw' => 'test',
  'dbname' => 'test',
  'table' => 'cdb_members a,cdb_memberfields b',
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
    'field' => 'qq',
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
    'field' => 'credits',
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
    'field' => '',
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
    'field' => 'lastip',
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
    1 => '1',
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
  'timelimit' => '90',
  'number' => '100',
  'edittime' => 1171006746,
);
?>