<?php
defined('IN_PHPCMS') or exit('Access Denied');
require_once MOD_ROOT.'admin/include/mood.class.php';
$mood = new mood();

$action = $action ? $action : "manage";

switch($action)
{
	case 'manage':

		$infos = $mood->listinfo();
		
		include admin_tpl('project_manage');
		break;

	case 'add':
		if($dosubmit)
		{
			if($name=='') showmessage('方案名称不能为空！','goback');
			$mood->add($name, $m, $p);
			showmessage("添加成功",$forward);
		}
		else
		{
			include admin_tpl('project_add');
		}
		break;

	case 'delete':
			$mood->delete($moodid);
			showmessage("操作成功",$forward);
		break;

	case 'edit':
		if($dosubmit)
		{
			if($name=='') showmessage('方案名称不能为空！','goback');
			$mood->edit($moodid, $name, $m, $p);
			showmessage("修改成功",$forward);
		}
		else
		{
			$arr = $mood->show($moodid);
			extract($arr);
			for($i=1;$i<16;$i++)
			{
				$fn = 'm'.$i;
				$fp = 'p'.$i;
				$array = explode('|',$$fn);
				$$fn = $array[0];
				$$fp = $array[1];
			}
			include admin_tpl('project_edit');
		}
		break;
}
?>