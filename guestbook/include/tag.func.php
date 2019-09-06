<?php
function guestbook_list($templateid = '',$keyid = 'phpcms',$guestbooknum = 10,$subjectlen = 30,$datetype = 0,$showusername = 0,$target = 0,$cols = 1){
	global $db,$PHP_TIME,$MOD,$LANG;
	$guestbooknum = intval($guestbooknum);
	$subjectlen = intval($subjectlen);
	$datetype = intval($datetype);
	$showusername = intval($showusername);
	$cols = intval($cols);
	$target = intval($target);
	$datetypes = array('', 'Y-m-d', 'm-d', 'Y/m/d', 'Y.m.d', 'Y-m-d H:i:s', 'Y-m-d H:i');
	$sql = '';
	if($keyid != 'phpcms' && $keyid)
	{
		if(strpos($keyid, ","))
		{
			$keyid = explode(",", $keyid);
			$sm = '';
			foreach($keyid as $k=>$v)
			{
				if($k) $sm = "OR";
				$sql .= " $sm keyid='$v' ";
			}
		}
		else
		{
			$sql = " keyid='$keyid' ";
		}
	}
	else
	{
		$sql = 1;
	}
	$query = "SELECT * FROM ".TABLE_GUESTBOOK." WHERE $sql AND passed=1 AND hidden=0 ";
	$result = $db->query($query);
	$guestbooks = array();
	while($r = $db->fetch_array($result))
	{
		$r['addtime'] = $datetype ? date($datetypes[$datetype],$r['addtime']) : '';
		$r['title'] = $subjectlen ? str_cut($r['title'],$subjectlen,'...') : '';
		$r['username'] = $r['username'] ? $r['username'] : $LANG['guest'];
		$guestbooks[] = $r;
	}
	$target = $target ? 'target="_blank"' : '';
	$templateid = $templateid ? $templateid : "tag_guestbook_list";
	include template('guestbook',$templateid);
}
?>