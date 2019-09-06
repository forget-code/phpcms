<?php 
function phpcms_mytag($tagname)
{
	global $CONFIG,$PHPCMS,$CHANNEL,$CATEGORY,$MOD,$CHA,$CAT,$PHP_URL,$PHP_IP,$PHP_TIME,$mod,$channelid,$catid,$specialid,$typeid,$page;
	include PHPCMS_ROOT.'/data/mytag/'.urlencode($tagname).'.php';
}

function phpcms_cat($templateid, $keyid, $catid = 0, $child = 0, $showtype = 0, $open = 1)
{
	$display = $open ? '' : 'none';
    if($showtype)
	{
		$subcat = subcat($keyid, $catid);
		$childcat = array();
		if($child)
		{
			foreach($subcat as $c)
			{
				if($c['child']) $childcat[$c['catid']] = subcat($keyid, $c['catid']);
			}
		}
	}
	else
	{
		$cattree = cattree($keyid, $catid, $open);
	}
	$templateid = $templateid ? $templateid : 'tag_cat';
	include template('phpcms', $templateid);
}

function cattree($keyid, $catid = 0, $open = 1, $pat = '')
{
	$cats = '';
	$childcats = subcat($keyid, $catid);
	$endi = count($childcats) - 1;
	foreach($childcats AS $i => $cat)
	{
		$catid = $cat['catid'];
		$image = $open ? 'open' : 'close';
		$onclick = $cat['child'] ? 'onclick="javascript:show(\'a'.$catid.'\',\'b'.$catid.'\',\''.$catid.'\')"' : '';
		$addpat = $cat['child'] ? '<td width=18 '.$onclick.'><img src="'.PHPCMS_PATH.'images/icon/'.$image.'.gif" id="a'.$catid.'"></td><td width=18 '.$onclick.'><img src="'.PHPCMS_PATH.'images/icon/f'.$image.'.gif" id="b'.$catid.'"></td>' : ($endi==$i ? '<td width=18><img src="'.PHPCMS_PATH.'images/icon/nodeend.gif"></td><td width=18><img src="'.PHPCMS_PATH.'images/icon/doc.gif"></td>' : '<td width=18><img src="'.PHPCMS_PATH.'images/icon/node.gif"></td><td width=18><img src="'.PHPCMS_PATH.'images/icon/doc.gif"></td>') ;
		$cats .= '<table border="0" cellspacing="0" cellpadding="0" style="font-size:9pt"><tr height=18 align="left">'.$pat.$addpat.'</td><td><a href="'.$cat['linkurl'].'" target="_blank">'.$cat['catname'].'</a></td></tr></table>';
		if($cat['child']) $cats .= '<div id="'.$catid.'" style="display=\''.($open ? '\'\'' : 'none').'\'">'.cattree($keyid, $catid, $open, $pat.'<td width=18><img src="'.PHPCMS_PATH.'images/icon/vertline.gif"></td>').'</div>';
	}
	return $cats;
}

function phpcms_special_list($templateid, $keyid = 0, $page = 0, $specialnum = 50, $specialnamelen = 50, $descriptionlen = 100, $elite = 0, $datenum = 0, $showtype = 0, $imgwidth = 150, $imgheight = 150, $cols = 1)
{
	global $db,$PHP_TIME,$CHANNEL;
	$width = ceil(100/$cols).'%';
	$condition = $pages = '';
	$condition .= $keyid ? " AND keyid='$keyid' " : '';
	$condition .= $elite ? " AND elite=1 " : '';
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	if(!isset($page)) $page = 1;
	$offset = $page ? ($page-1)*$specialnum : 0;
	$limit = $specialnum ? ' LIMIT '.$offset.','.$specialnum : '';
	if($page && $specialnum)
	{
		$r = $db->get_one("SELECT count(*) AS number FROM ".TABLE_SPECIAL." WHERE parentid=0 AND disabled=0 $condition ","CACHE");
		$pages = specialpages($r['number'], $page, $specialnum);
	}
	$specials = array();
	$result = $db->query("SELECT * FROM ".TABLE_SPECIAL." WHERE parentid=0 AND disabled=0 $condition ORDER BY specialid DESC $limit ","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = date('Y-m-d', $r['addtime']);
		$r['linkurl'] = linkurl($r['linkurl'], 1);
		$r['alt'] = $r['specialname'];
		$r['specialname'] = $specialnamelen ? str_cut($r['specialname'], $specialnamelen, '...') : '';
		$r['introduce'] = $descriptionlen ? str_cut($r['introduce'], $descriptionlen, '...') : '';
		$r['specialpic'] = imgurl($r['specialpic']);		
		$r['specialbanner'] = imgurl($r['specialbanner']);
		if(defined('DOMAIN'))//For info
		{
			$r['specialpic'] = DOMAIN.$r['specialpic'];
			$r['specialbanner'] = DOMAIN.$r['specialbanner'];
		}
		$specials[] = $r;
	}
	$db->free_result($result);
	$templateid = $templateid ? $templateid : 'tag_special_list';
	include template('phpcms', $templateid);
}

function phpcms_special_slide($templateid, $keyid = 1, $specialnum = 2, $specialnamelen = 30, $elite = 0, $datenum = 0, $imgwidth = 150, $imgheight = 150, $timeout = 5000, $effectid = -1)
{
	global $db,$PHP_TIME,$CHANNEL;
	$condition = '';
	$condition .= $elite ? " AND elite=1 " : "";
	$condition .= $datenum ? " AND addtime>$PHP_TIME-86400*$datenum " : '';
	$limit = $specialnum ? ' LIMIT 0,'.$specialnum : '';
	$k = 0;
	$flash_pics = '';
	$flash_links = '';
	$flash_texts = '';
	$specials = array();
	$result = $db->query("SELECT * FROM ".TABLE_SPECIAL." WHERE specialpic!='' AND parentid=0 AND disabled=0 $condition ORDER BY specialid DESC $limit","CACHE");
	while($r = $db->fetch_array($result))
	{
		$r['adddate'] = date('Y-m-d',$r['addtime']);
		$r['linkurl'] = linkurl($r['linkurl'], 1);
		$r['alt'] = $r['specialname'];
		$r['specialname'] = str_cut($r['specialname'], $specialnamelen, '...');
		$r['specialpic'] = imgurl($r['specialpic']);
		if(defined('DOMAIN'))//For info
		{
			$r['specialpic'] = DOMAIN.$r['specialpic'];
		}
		$s = $k ? '|' : '';
		$flash_pics .= $s.$r['specialpic'];
		$flash_links .= $s.$r['linkurl'];
		$flash_texts .= $s.$r['specialname'];
		$k = 1;
		$specials[] = $r;
	}
	if(!$specials)
	{
		$specials['0']['specialpic'] = defined('DOMAIN') ? DOMAIN.'images/focus.jpg' : linkurl(PHPCMS_PATH.'images/focus.jpg', 1);
		$specials['0']['specialpic'] =  defined('DOMAIN') ? DOMAIN.'images/nopic.gif' : linkurl(PHPCMS_PATH.'images/nopic.gif', 1);
		$specials['0']['url'] = '#';
		$specials['0']['specialname'] = '';
	}
	$db->free_result($result);
	$templateid = $templateid ? $templateid : 'tag_special_slide';
	include template('phpcms', $templateid);
}

function phpcms_type($templateid = 0, $keyid = 1)
{
	global $CHANNEL, $MOD;
	if(!$keyid) return FALSE;
	$TYPE = cache_read('type_'.$keyid.'.php');
	$keyurl = is_numeric($keyid) ? $CHANNEL[$keyid]['linkurl'] : $MOD['linkurl'];
	if(!$templateid) $templateid = 'tag_type';
	include template('phpcms', $templateid);
}

function phpcms_freelink($type)
{
	@include PHPCMS_ROOT.'/data/freelink/'.urlencode($type).'.html';
}
?>