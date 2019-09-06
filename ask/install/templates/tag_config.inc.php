<?php
return array (
  '问吧首页最新' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  AND flag=\'0\' ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '0',
    'status' => '3',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '30',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  AND flag=\'0\' ORDER BY askid DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'0\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'30\',))',
  ),
  '待解决问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '-1',
    'status' => '3',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '1',
      4 => '45',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  ORDER BY askid DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'1\',  \'titlelen\' => \'45\',))',
  ),
  '已解决问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'5\'  ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '-1',
    'status' => '5',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '1',
      4 => '45',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'5\'  ORDER BY askid DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'1\',  \'titlelen\' => \'45\',))',
  ),
  '栏目热点问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status>2  AND catid=\'$catid\' ORDER BY hits DESC',
    'catid' => '$catid',
    'userid' => '',
    'flag' => '-1',
    'status' => '-1',
    'orderby' => 'hits DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status>2  AND catid=\'$catid\' ORDER BY hits DESC", 0, 10, array (  \'catid\' => $catid,  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',))',
  ),
  '最新问题' => 
  array (
    'introduce' => '最新问题',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  AND catid=\'$catid\' AND flag=\'0\' ORDER BY askid DESC',
    'catid' => '$catid',
    'userid' => '',
    'flag' => '0',
    'status' => '3',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '1',
      4 => '45',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  AND catid=\'$catid\' AND flag=\'0\' ORDER BY askid DESC", 0, 10, array (  \'catid\' => $catid,  \'userid\' => \'\',  \'flag\' => \'0\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'1\',  \'titlelen\' => \'45\',))',
  ),
  '总积分排行榜' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT m.userid,m.username,m.point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_member` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY point DESC',
    'flag' => '0',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_credit',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
    ),
    'type' => 'credit',
    'tagcode' => 'tag(\'ask\', \'tag_credit\', "SELECT m.userid,m.username,m.point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_member` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY point DESC", 0, 10, array (  0 => \'\',  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
  '上月积分排行榜' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT m.userid,m.username,m.premonth AS point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_ask_credit` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY premonth DESC',
    'flag' => '1',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_credit',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
    ),
    'type' => 'credit',
    'tagcode' => 'tag(\'ask\', \'tag_credit\', "SELECT m.userid,m.username,m.premonth AS point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_ask_credit` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY premonth DESC", 0, 10, array (  0 => \'\',  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
  '上周积分排行榜' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT m.userid,m.username,m.preweek AS point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_ask_credit` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY preweek DESC',
    'flag' => '2',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_credit',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
    ),
    'type' => 'credit',
    'tagcode' => 'tag(\'ask\', \'tag_credit\', "SELECT m.userid,m.username,m.preweek AS point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_ask_credit` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY preweek DESC", 0, 10, array (  0 => \'\',  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
  '问吧首页热点问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  ORDER BY hits DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '-1',
    'status' => '3',
    'orderby' => 'hits DESC',
    'page' => '0',
    'number' => '4',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  ORDER BY hits DESC", 0, 4, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'46\',))',
  ),
  '栏目页全部问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status>2  AND catid=\'$catid\' ORDER BY askid DESC',
    'catid' => '$catid',
    'userid' => '',
    'flag' => '-1',
    'status' => '-1',
    'orderby' => 'askid DESC',
    'page' => '$page',
    'number' => '15',
    'template' => 'tag_ask_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '1',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask_list\', "SELECT * FROM `phpcms2008_ask` WHERE status>2  AND catid=\'$catid\' ORDER BY askid DESC", $page, 15, array (  \'catid\' => $catid,  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'1\',  \'titlelen\' => \'46\',))',
  ),
  '栏目页已解决问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'5\'  AND catid=\'$catid\' ORDER BY askid DESC',
    'catid' => '$catid',
    'userid' => '',
    'flag' => '-1',
    'status' => '5',
    'orderby' => 'askid DESC',
    'page' => '$page',
    'number' => '10',
    'template' => 'tag_ask_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '1',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask_list\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'5\'  AND catid=\'$catid\' ORDER BY askid DESC", $page, 10, array (  \'catid\' => $catid,  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'1\',  \'titlelen\' => \'46\',))',
  ),
  '栏目页待解决问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  AND catid=\'$catid\' ORDER BY askid DESC',
    'catid' => '$catid',
    'userid' => '',
    'flag' => '-1',
    'status' => '3',
    'orderby' => 'askid DESC',
    'page' => '$page',
    'number' => '15',
    'template' => 'tag_ask_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask_list\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  AND catid=\'$catid\' ORDER BY askid DESC", $page, 15, array (  \'catid\' => $catid,  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',))',
  ),
  '栏目页投票问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status>2  AND catid=\'$catid\' AND flag=\'1\' ORDER BY askid DESC',
    'catid' => '$catid',
    'userid' => '',
    'flag' => '1',
    'status' => '-1',
    'orderby' => 'askid DESC',
    'page' => '$page',
    'number' => '10',
    'template' => 'tag_ask_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask_list\', "SELECT * FROM `phpcms2008_ask` WHERE status>2  AND catid=\'$catid\' AND flag=\'1\' ORDER BY askid DESC", $page, 10, array (  \'catid\' => $catid,  \'userid\' => \'\',  \'flag\' => \'1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'46\',))',
  ),
  '栏目页高分问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  AND catid=\'$catid\' AND flag=\'2\' ORDER BY askid DESC',
    'catid' => '$catid',
    'userid' => '',
    'flag' => '2',
    'status' => '3',
    'orderby' => 'askid DESC',
    'page' => '$page',
    'number' => '10',
    'template' => 'tag_ask_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask_list\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  AND catid=\'$catid\' AND flag=\'2\' ORDER BY askid DESC", $page, 10, array (  \'catid\' => $catid,  \'userid\' => \'\',  \'flag\' => \'2\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',))',
  ),
  '栏目页推荐问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  AND catid=\'$catid\' AND flag=\'3\' ORDER BY askid DESC',
    'catid' => '$catid',
    'userid' => '',
    'flag' => '3',
    'status' => '3',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  AND catid=\'$catid\' AND flag=\'3\' ORDER BY askid DESC", 0, 10, array (  \'catid\' => $catid,  \'userid\' => \'\',  \'flag\' => \'3\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'46\',))',
  ),
  '问吧首页推荐问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status>2  AND flag=\'3\' ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '3',
    'status' => '-1',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status>2  AND flag=\'3\' ORDER BY askid DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'3\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'46\',))',
  ),
  '侧栏最新问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '-1',
    'status' => '3',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  ORDER BY askid DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',))',
  ),
  '侧栏推荐问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status>2  AND flag=\'3\' ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '3',
    'status' => '-1',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status>2  AND flag=\'3\' ORDER BY askid DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'3\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'titlelen\' => \'46\',))',
  ),
  '积分列表页月排行' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT m.userid,m.username,m.premonth AS point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_ask_credit` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY premonth DESC',
    'flag' => '1',
    'page' => '$page',
    'number' => '10',
    'template' => 'tag_credit_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
    ),
    'type' => 'credit',
    'tagcode' => 'tag(\'ask\', \'tag_credit_list\', "SELECT m.userid,m.username,m.premonth AS point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_ask_credit` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY premonth DESC", $page, 10, array (  0 => \'\',  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
  '积分列表页周排行' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT m.userid,m.username,m.preweek AS point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_ask_credit` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY preweek DESC',
    'flag' => '2',
    'page' => '$page',
    'number' => '10',
    'template' => 'tag_credit_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
    ),
    'type' => 'credit',
    'tagcode' => 'tag(\'ask\', \'tag_credit_list\', "SELECT m.userid,m.username,m.preweek AS point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_ask_credit` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY preweek DESC", $page, 10, array (  0 => \'\',  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
  '积分列表页总排行' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT m.userid,m.username,m.point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_member` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY point DESC',
    'flag' => '0',
    'page' => '$page',
    'number' => '10',
    'template' => 'tag_credit_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
    ),
    'type' => 'credit',
    'tagcode' => 'tag(\'ask\', \'tag_credit_list\', "SELECT m.userid,m.username,m.point,i.lastlogintime,i.logintimes,i.actortype,i.answercount,i.acceptcount FROM `phpcms2008_member` m LEFT JOIN `phpcms2008_member_info` i ON m.userid=i.userid ORDER BY point DESC", $page, 10, array (  0 => \'\',  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
  '全部已解决问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'5\'  ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '-1',
    'status' => '5',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '30',
    'template' => 'tag_ask_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '45',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask_list\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'5\'  ORDER BY askid DESC", 0, 30, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'45\',))',
  ),
  '全部待解决问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '-1',
    'status' => '3',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '30',
    'template' => 'tag_ask_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask_list\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  ORDER BY askid DESC", 0, 30, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'46\',))',
  ),
  '全部投票问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status>2  AND flag=\'1\' ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '1',
    'status' => '-1',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask_list\', "SELECT * FROM `phpcms2008_ask` WHERE status>2  AND flag=\'1\' ORDER BY askid DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'46\',))',
  ),
  '全部高分问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status>2  AND flag=\'2\' ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '2',
    'status' => '-1',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask_list\', "SELECT * FROM `phpcms2008_ask` WHERE status>2  AND flag=\'2\' ORDER BY askid DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'2\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'46\',))',
  ),
  '全部问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status>2  ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '-1',
    'status' => '-1',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask_list\', "SELECT * FROM `phpcms2008_ask` WHERE status>2  ORDER BY askid DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'46\',))',
  ),
  '侧栏热点问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  ORDER BY hits DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '-1',
    'status' => '3',
    'orderby' => 'hits DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '0',
      4 => '46',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status=\'3\'  ORDER BY hits DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'0\',  \'titlelen\' => \'46\',))',
  ),
  '首页热点问题' => 
  array (
    'introduce' => '',
    'mode' => '0',
    'sql' => 'SELECT * FROM `phpcms2008_ask` WHERE status>2  ORDER BY askid DESC',
    'catid' => '0',
    'userid' => '',
    'flag' => '-1',
    'status' => '-1',
    'orderby' => 'askid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_ask',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '是否显示栏目名称',
      4 => '标题字符数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'showcatname',
      4 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '1',
      4 => '38',
    ),
    'type' => 'ask',
    'tagcode' => 'tag(\'ask\', \'tag_ask\', "SELECT * FROM `phpcms2008_ask` WHERE status>2  ORDER BY askid DESC", 0, 10, array (  \'catid\' => \'0\',  \'userid\' => \'\',  \'flag\' => \'-1\',  \'action\' => $action,  \'urlruleid\' => \'29\',  \'class\' => \'url\',  \'target\' => \'_blank\',  \'showcatname\' => \'1\',  \'titlelen\' => \'38\',))',
  ),
);
?>