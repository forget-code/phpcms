<?php
function update_keywords($keywords, $keyid)
{
	global $db, $PHP_TIME;
	if(empty($keywords) || empty($keyid)) return FALSE;
	$keywords = trim(strip_tags($keywords));
	if(strpos($keywords, ","))
	{
		$keywords = explode("," ,$keywords);
		foreach($keywords as $k)
		{
			update_keywords($k, $keyid);
		}
		return TRUE;
	}
	else
	{
		$db->query("UPDATE ".TABLE_KEYWORDS." SET hits=hits+1,updatetime='$PHP_TIME' WHERE keywords='$keywords' AND keyid='$keyid' ");
		if($db->affected_rows() == 0)
		{
			$db->query("INSERT INTO ".TABLE_KEYWORDS." (keyid,keywords,updatetime) VALUES ('$keyid','$keywords','$PHP_TIME')");
		}
		cache_keywords($keyid);
		return TRUE;
	}
}

function cache_keywords($keyid)
{
	global $db;
	if(empty($keyid)) return FALSE;
	$result = $db->query("SELECT id,keywords,hits,updatetime FROM ".TABLE_KEYWORDS." WHERE keyid='$keyid' ORDER BY hits DESC LIMIT 0,50");
	$keywords = array();
	while($r = $db->fetch_array($result))
	{
		$r['updatetime'] = date('Y-m-d', $r['updatetime']);
		$keywords[] = $r;
	}
	cache_write('keywords_'.$keyid.'.php', $keywords);
}

function keywords_select($keyid, $name = '', $js = 'onchange="javascript:ChangeInput(this,document.myform.keywords)"')
{
	global $db,$LANG;
	if(empty($keyid)) return FALSE;
	$content = '<select name="'.$name.'" '.$js.'><option>'.$LANG['keyword_list'].'</option>';
	$keywords = cache_read('keywords_'.$keyid.'.php');
	foreach($keywords as $k=>$v)
	{
		if($k > 20) break;
		$content .= '<option value="'.$v['keywords'].'">'.$v['keywords'].'</option>';
	}
	$content .= '</select>';
	return $content;
}

function update_author($name, $keyid, $note = '')
{
	global $db, $PHP_TIME;
	if(empty($name) || empty($keyid)) return FALSE;
	$name = trim($name);
	$note = trim($note);
	$db->query("UPDATE ".TABLE_AUTHOR." SET items=items+1,updatetime='$PHP_TIME' WHERE name='$name' AND keyid='$keyid' ");
	if($db->affected_rows() == 0)
	{
		$db->query("INSERT INTO ".TABLE_AUTHOR." (keyid,name,note,updatetime) VALUES ('$keyid','$name','$note','$PHP_TIME')");
	}
	cache_author($keyid);
	return TRUE;
}

function cache_author($keyid)
{
	global $db;
	if(empty($keyid)) return FALSE;
	$result = $db->query("SELECT id,name,items,updatetime FROM ".TABLE_AUTHOR." WHERE keyid='$keyid' ORDER BY items DESC LIMIT 0,50");
	$author = array();
	while($r = $db->fetch_array($result))
	{
		$r['updatetime'] = date('Y-m-d', $r['updatetime']);
		$author[] = $r;
	}
	cache_write('author_'.$keyid.'.php', $author);
}

function author_select($keyid, $name = '', $js = 'onchange="document.myform.author.value=this.value"')
{
	global $db,$LANG;
	if(empty($keyid)) return FALSE;
	$content = '<select name="'.$name.'" '.$js.'><option>'.$LANG['author_list'].'</option><option value="'.$LANG['unknown'].'">'.$LANG['unknown'].'</option><option value="'.$LANG['anonymous'].'">'.$LANG['anonymous'].'</option>
	<option value="admin">admin</option>';
	$author = cache_read('author_'.$keyid.'.php');
	foreach($author as $k=>$v)
	{
		if($k > 20) break;
		$content .= '<option value="'.$v['name'].'">'.$v['name'].'</option>';
	}
	$content .= '</select>';
	return $content;
}

function update_copyfrom($copyfrom, $keyid)
{
	global $db, $PHP_TIME;
	if(empty($copyfrom) || empty($keyid)) return FALSE;
	$copyfrom = trim($copyfrom);
	if(preg_match("/^(.*)\|([a-zA-Z0-9\-\.\:\/]{5,})$/", $copyfrom, $m))
	{
		$name = $m[1];
		$url = strpos($m[2], '://') ? $m[2] : 'http://'.$m[2];
		$db->query("UPDATE ".TABLE_COPYFROM." SET hits=hits+1,updatetime='$PHP_TIME' WHERE name='$name' AND keyid='$keyid' ");
		if($db->affected_rows() == 0)
		{
			$db->query("INSERT INTO ".TABLE_COPYFROM." (keyid,name,url,updatetime) VALUES ('$keyid','$name','$url','$PHP_TIME')");
		}
		cache_copyfrom($keyid);
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

function cache_copyfrom($keyid)
{
	global $db;
	if(empty($keyid)) return FALSE;
	$result = $db->query("SELECT id,name,url,hits,updatetime FROM ".TABLE_COPYFROM." WHERE keyid='$keyid' ORDER BY hits DESC LIMIT 0,50");
	$copyfrom = array();
	while($r = $db->fetch_array($result))
	{
		$r['updatetime'] = date('Y-m-d', $r['updatetime']);
		$copyfrom[] = $r;
	}
	cache_write('copyfrom_'.$keyid.'.php', $copyfrom);
}

function copyfrom_select($keyid, $name = '', $js = 'onchange="document.myform.copyfrom.value=this.value"')
{
	global $db,$LANG;
	if(empty($keyid)) return FALSE;
	$content='<select name="'.$name.'" '.$js.'><option>'.$LANG['sources_list'].'</option><option value="'.$LANG['internet'].'|#">'.$LANG['internet'].'</option>';
	$copyfrom = cache_read('copyfrom_'.$keyid.'.php');
	foreach($copyfrom as $k => $v)
	{
		if($k > 20) break;
		$content .= '<option value="'.$v['name'].'|'.$v['url'].'">'.$v['name'].'</option>';
	}
	$content .= '</select>';
	return $content;
}

function segment_word()
{
	global $CONFIG,$PHPCMS;
	if(!$PHPCMS['enablegetkeywords']) 
	{
		return '<script type="text/javascript">function segment_word(obj){return false;}</script>';
	}
	else
	{
		return '<script type="text/javascript">
				var laststring = "";
				function segment_word(obj)
				{
					if(obj.value == "" || obj.value == laststring)
					{
						return false;
					}
					laststring = obj.value;
					document.myframe_form.string.value = obj.value;
					document.myframe_form.submit();
					return true;
				}
			 </script>
			 <iframe id="myframe" name="myframe" width="0" height="0"></iframe>
			 <form name="myframe_form" action="'.PHPCMS_PATH.'segment_word.php" method="get" target="myframe">
			  <input type="hidden" name="string" />
			  <input type="hidden" name="action" value="get_keywords" />
			  <input type="hidden" name="charset" value="'.$CONFIG['charset'].'" />
			 </form>';
	}
}
?>