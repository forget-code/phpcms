<?php
defined('IN_PHPCMS') or exit('Access Denied');

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES (5, '投票问卷', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0,'vote')");

$id=$db->insert_id();

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES ($id, '添加投票', '', '?mod=vote&file=vote&action=add', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES ($id, '管理投票', '', '?mod=vote&file=vote&action=manage', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES ($id, '已禁止投票', '', '?mod=vote&file=vote&action=manage&enabled=0', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES ($id, '过期投票', '', '?mod=vote&file=vote&action=manage&timeout=1', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES ($id, '添加问卷', '', '?mod=vote&file=vote&action=add&survey=1', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES ($id, '管理问卷', '', '?mod=vote&file=vote&action=manage&survey=1', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES ($id, '已禁止问卷', '', '?mod=vote&file=vote&action=manage&enabled=0&survey=1', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES ($id, '过期问卷', '', '?mod=vote&file=vote&action=manage&timeout=1&survey=1', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES ($id, '模块配置', '', '?mod=vote&file=setting', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES ($id, '权限配置', '', '?mod=vote&file=priv', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");


$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES (7, '投票', '', '', '', 'right', '', '', '', '', 1, 0, 0, 0,'vote')");

$id=$db->insert_id();

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES (".$id.", '新建模板', '', '?mod=phpcms&file=template&action=add&module=vote', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");

$db->query("INSERT INTO ".DB_PRE."menu(parentid,name,image,url,description,target,style,js,groupids,roleids,isfolder,isopen,listorder,userid,keyid) VALUES (".$id.", '管理模板', '', '?mod=phpcms&file=template&action=manage&module=vote', '', 'right', '', '', '', '', 0, 0, 0, 0,'vote')");
?>