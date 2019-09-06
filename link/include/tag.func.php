<?php
function link_list($templateid = '', $typeid = '', $linktype = 0, $linknum = 100, $cols = 6, $showhits = 0)
{
	global $db,$PHP_SITEURL,$MOD;
	$showhits = intval($showhits);
	$cols = intval($cols);
	$linknum = intval($linknum);
	$linktype = intval($linktype);
	$showhits = intval($showhits);
	$condition = '';
	$condition .= " AND linktype=$linktype ";
	if($typeid)
	$condition .= "AND typeid IN ($typeid) ";
	$result = $db->query("SELECT * FROM ".TABLE_LINK." WHERE passed=1 $condition ORDER BY elite DESC,listorder ASC LIMIT $linknum " );
	if($db->affected_rows()>0)
	{
		while($r=$db->fetch_array($result))
		{	
			if(!preg_match('/http:\/\//',$r['logo']))
			{
				$r['logo'] = $PHP_SITEURL.$r['logo'];
			}
			$links[]=$r;
		}
		$templateid = $templateid ? $templateid : "tag_link_list";
		include template('link',$templateid);
	}
	
}

?>