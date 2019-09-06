<?php 
defined('IN_PHPCMS') or exit('Access Denied');

$action = isset($action) ? $action : 'setting';
switch($action)
{
	case 'disabled':
		if(!isset($keyid)) showmessage($LANG['illegal_parameters']);
		if(!isset($typeid)) showmessage($LANG['illegal_parameters']);
		$typeid = intval($typeid);
		$db->query('UPDATE '.TABLE_TYPE.' SET disabled = NOT disabled WHERE typeid='.$typeid);
		cache_type($keyid);
		showmessage($LANG['operation_success'], $forward);

    default:
    	if(!isset($keyid)) showmessage($LANG['illegal_parameters']);
		if($dosubmit)
		{
			if(is_array($name))
			{
				foreach($name as $id=>$v)
				{
					if(isset($delete[$id]) && $delete[$id])
					{
						$db->query("delete from ".TABLE_TYPE." where typeid='$id'");
					}
					else
					{
						$db->query("update ".TABLE_TYPE." SET name='$name[$id]',style='$style[$id]',type='$type[$id]',introduce='$introduce[$id]',listorder='$listorder[$id]' where typeid='$id'");
					}
				}
			}
			if($newname)
			{
				$db->query("insert into ".TABLE_TYPE."(keyid,name,style,type,introduce,listorder,disabled) values('$keyid','$newname','$newstyle','$newtype','$newintroduce','$newlistorder','0')");
			}
			cache_type($keyid);
			showmessage($LANG['operation_success'], $forward);
		}
		else
		{
			$maxtypeid = 1;
			$style_edit = style_edit('newstyle','');
			$result = $db->query("select * from ".TABLE_TYPE." where keyid='$keyid' order by listorder");
			$types = array();
			while($r = $db->fetch_array($result))
			{
				$r['style_edit'] = style_edit("style[".$r['typeid']."]",$r['style']);
				$types[$r['typeid']] = $r;
				$maxtypeid = max($maxtypeid, $r['typeid']);
			}
			$newlistorder = $maxtypeid + 1;
			include admintpl('type');
		}
}
?>