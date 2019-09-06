<?php 
defined('IN_PHPCMS') or exit('Access Denied');

function trade_select($name = 'tradeid', $defaultalt = '', $tradeid = 0, $property = '')
{
	global $tree,$TRADE;
	$content = '';
	if(is_array($TRADE)) 
	{
		$trades = array();
		foreach($TRADE as $i=>$v)
		{
			$trades[$i] = array('id'=>$i,'parentid'=>$v['parentid'],'name'=>$v['tradename']);
		}
		$tree->tree($trades);
		$content = $tree->get_tree(0,"<option value='\$id' \$selected>\$spacer\$name</option>",$tradeid);
	}
	$content = "<select name='".$name."' ".$property."><option value='0'>".$defaultalt."</option>".$content."</select>";
	return $content;
}

function ajax_trade_select($name = 'tradeid', $script, $tradeid = 0)
{
	global $LANG;
	if(!$script) return;
	echo '<input name="'.$name.'" id="tradeid" type="hidden" value="'.$tradeid.'"><span id="load_trade"></span> <a href="javascript:reload();">'.$LANG['re_select'].'</a>';
	echo '<script type="text/javascript">var trade_script="'.$script.'";var trade_path="'.PHPCMS_PATH.'";</script>';
	echo '<script type="text/javascript" src="'.PHPCMS_PATH.'include/js/trade_ajax.js"></script>';
}

function cache_trades($script)
{
	global $db,$PHPCMS;
	$tradeids = $data = array();
    $query = $db->query("SELECT script,tradeid,tradename,linkurl,parentid,arrparentid,child,arrchildid,urlruleid FROM ".TABLE_YP_TRADE." WHERE script='$script' ORDER by listorder,tradeid");
    while($r = $db->fetch_array($query))
	{
		$tradeid = $r['tradeid'];
        $data[$tradeid] = $r;
		$tradeids[] = $tradeid;
    }
	cache_write('trades_'.$script.'.php', $data);
	return $tradeids;
}

function cache_trade($tradeid)
{
	global $db,$PHPCMS;
	if(!$tradeid) return FALSE;
    $data = $db->get_one("SELECT * FROM ".TABLE_YP_TRADE." WHERE tradeid=$tradeid");
	$setting = unserialize($data['setting']);
	unset($data['setting']);
	$data = is_array($setting) ? array_merge($data, $setting) : $data;
	cache_write('trade_'.$tradeid.'.php', $data);
	return $data;
}

function trade_url($type, $tradeid, $script,$page = 0)
{
	global $TRADE,$PHPCMS,$urlrule,$PHP_DOMAIN;
	if(!is_array($TRADE)) return FALSE;
	$fileext = $PHPCMS['fileext'];
	$index = $PHPCMS['index'];
	$urlruleid = $TRADE[$tradeid]['urlruleid'];
	$html = 'php';
	$rule = $urlrule[$html][$script][$urlruleid];
	$rule = $page == 0 ? $rule['index'] : $rule['page'];
    eval("\$url = \"$rule\";");
	return substr($url,1);
}

function subtrade($script, $tradeid = 0, $type = 'menu')
{
	global $TRADE;
    if(!is_array($TRADE)) $TRADE = cache_read('trades_'.$script.'.php');;
	$subtrade = array();
	foreach($TRADE as $id=>$trade)
	{
		if($trade['parentid'] == $tradeid)
		{
			$subtrade[] = $trade; 
		}
	}
	return $subtrade;
}

function tradepos($tradeid, $s = ' &gt;&gt; ')
{
	global $MOD,$TRADE;
	$script = $TRADE[$tradeid]['script'];
    $arrparentid = $TRADE[$tradeid]['arrparentid'];
	$arrparentid = explode(',', $arrparentid);
	if($tradeid) $arrparentid[] = $tradeid;
	$pos = '';
	foreach($arrparentid as $ptradeid)
	{
		if($ptradeid == 0 && !isset($TRADE[$ptradeid])) continue;
		$tradename = $TRADE[$ptradeid]['tradename'];
		$linkurl = $TRADE[$ptradeid]['linkurl'];
		$pos .= '<a href="'.$linkurl.'">'.$tradename.'</a>'.$s;
	}
	return $pos;
}

function get_trade_id($script, $tradename)
{
	global $db;
	$r = $db->get_one("select tradeid from ".TABLE_YP_TRADE." where tradename='$tradename' and script='$script' ");
	if($r)
	{
		return $r['tradeid'];
	}
	else
	{
		return 0;
	}
}

function get_trade_parentid($script, $tradeid)
{
	if(!$tradeid) return 0;
	global $TRADE;
	if(!array_key_exists($tradeid, $TRADE))  return 0;
	if($TRADE[$tradeid]['parentid'] == 0)
	{
		return $tradeid;
	}
	else
	{
		return get_trade_parentid($script, $TRADE[$tradeid]['parentid']);
	}
}

function trade_urlrule_select($name, $fileext = 'html', $type = 'cat', $urlruleid = 0, $property = '')
{
	include MOD_ROOT.'/include/urlrule.inc.php';
	$string = "<select name=\"".$name."\" ".$property.">\n";
	for($i=0; $i<count($urlrule[$fileext][$type]); $i++)
	{
		$selected = $i==$urlruleid ? " selected=\"selected\"" : "";
		$string.="<option value=\"".$i."\"".$selected.">".$urlrule[$fileext][$type][$i]['example']."</option>\n";
	}
	$string.="</select>\n";
	return $string;
}
?>