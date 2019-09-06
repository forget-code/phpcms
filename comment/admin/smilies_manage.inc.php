<?php 
defined('IN_PHPCMS') or exit('Access Denied');
if($dosubmit)
{
	foreach($src as $k=>$v)
	{
		$smiliesarr[$v] = $listorder[$k];
	}
	cache_write('smilies_list.php',$smiliesarr);
	showmessage($LANG['operation_success'], $forward);
}
else
{
	$files = glob(PHPCMS_ROOT.'/comment/smilies/smile_*.gif');
	$smiliesarr = cache_read('smilies_list.php');
	if(!is_array($files))
	{
		exit($LANG['check_dir']." /comment/smilies/");
	}	
	foreach($files as $k=>$v)
	{
		$i = $k+1;
		$id[$i] = $i;
		$img[$i] = str_replace(PHPCMS_ROOT,'',$v);	
		if($img[$i][0]=='/') $img[$i]=substr($img[$i],1);
		$listorder[$i] = array_key_exists($img[$i],$smiliesarr) ? (int)$smiliesarr[$img[$i]] : 0;		
	}
	$sms = array('id'=>$id,'img'=>$img,'listorder'=>$listorder);

	array_multisort($sms['listorder'], SORT_NUMERIC, SORT_DESC,
	                $sms['img'], SORT_STRING, SORT_ASC);
	
	$smilies = array();
	foreach($sms['listorder'] as $k=>$v)
	{
		$i = $k +1;
		$r['id'] = $sms['id'][$i];
		$r['img'] = $sms['img'][$k];
		$r['listorder'] = $v;
		$smilies[] = $r;
	}
	unset($sms);
	include admintpl('smilies_manage');
}
?>