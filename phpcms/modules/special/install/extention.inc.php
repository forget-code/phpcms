<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name'=>'special', 'parentid'=>821, 'm'=>'special', 'c'=>'special', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'add_special', 'parentid'=>$parentid, 'm'=>'special', 'c'=>'special', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_special', 'parentid'=>$parentid, 'm'=>'special', 'c'=>'special', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'special_list', 'pareentid'=>$parentid, 'm'=>'special', 'c'=>'special', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>0));
$menu_db->insert(array('name'=>'special_elite', 'pareentid'=>$parentid, 'm'=>'special', 'c'=>'special', 'a'=>'elite', 'data'=>'', 'listorder'=>0, 'display'=>0));
$menu_db->insert(array('name'=>'del_space', 'parentid'=>$parentid, 'm'=>'poster', 'c'=>'space', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'poster_list', 'parentid'=>$parentid, 'm'=>'poster', 'c'=>'poster', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'add_poster', 'parentid'=>$parentid, 'm'=>'poster', 'c'=>'poster', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_poster', 'parentid'=>$parentid, 'm'=>'poster', 'c'=>'poster', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'del_poster', 'parentid'=>$parentid, 'm'=>'poster', 'c'=>'poster', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'poster_stat', 'parentid'=>$parentid, 'm'=>'poster', 'c'=>'poster', 'a'=>'stat', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'poster_setting', 'parentid'=>$parentid, 'm'=>'poster', 'c'=>'space', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'0'));

$language = array('special'=>'广告', 'add_special'=>'添加专题', 'edit_special'=>'修改专题', 'special_list'=>'专题列表', 'special_elite'=>'推荐专题', 'del_space'=>'删除版位', 'poster_list'=>'广告列表', 'add_poster'=>'添加广告', 'edit_poster'=>'编辑广告', 'del_poster'=>'删除广告', 'poster_stat'=>'广告统计', 'poster_setting'=>'模块配置');
?>