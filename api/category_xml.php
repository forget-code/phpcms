<?php 
require '../include/common.inc.php';

function treecat($module, $parentid = NULL, $type = NULL, $nodeid = '')
{
	$data = '';
	$n = 1;
    $subcats = subcat($module, $parentid, $type);
	foreach($subcats as $catid=>$c)
	{
		$newid = $nodeid ? $nodeid.'.'.$n : $n;
		$catname = $c['catname'];
		$url = url($c['url'], 1);
        $data .= "\n<category id=\"$newid\">\n<catname>$catname</catname>\n<catid>$catid</catid>\n<url>$url</url>\n";
        if($c['child']) $data .= treecat($module, $catid, $type, $newid);
		$data .= "</category>\n";
	    $n++;
	}
	return $data;
}

$catid = intval($catid);
$type = intval($type);
if(!isset($MODULE[$module])) $module = 'phpcms';
if(!isset($CATEGORY[$catid])) $catid = 0;
if(!in_array($type, array(0, 1, 2))) $type = NULL;

$data .= "<categories>\n";
$data .= treecat($module, $catid, $type);
$data .= "</categories>";
$data = iconv(CHARSET, 'utf-8', $data);

header('Content-type: text/html; charset=utf-8');
echo $data;
?>