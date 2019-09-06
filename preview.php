<?php
require dirname(__FILE__).'/include/common.inc.php';
if(!$_userid) showmessage('禁止访问');
require_once CACHE_MODEL_PATH.'content_output.class.php';
require_once 'output.class.php';
if(!is_array($info)) showmessage('信息预览不能翻页');
$r = new_stripslashes($info);
$C = cache_read('category_'.$r['catid'].'.php');
$out = new content_output();
$r['userid'] = $_userid;
$r['inputtime'] = TIME;
$data = $out->get($r);
extract($data);
$userid = $_username;
for($i=1;$i<10;$i++)
{
	$str_attachmentArray[$i] = array("filepath" => "images/preview.gif","description" => "这里是图片的描述","thumb"=>"images/thumb_60_60_preview.gif");
}

$array_images = $str_attachmentArray;
$images_number = 10;
$allow_priv = $allow_readpoint = 1;
$updatetime = date('Y-m-d H:i:s',TIME);

$page = max(intval($page), 1);
$pages = $titles = '';
if(strpos($content, '[page]') !== false)
{
	require_once 'url.class.php';
    $curl = new url();
	$contents = array_filter(explode('[page]', $content));
	$pagenumber = count($contents);
	for($i=1; $i<=$pagenumber; $i++)
	{
		$pageurls[$i] = $curl->show($r['contentid'], $i, $r['catid'], $r['inputtime']);
	}
	if(strpos($content, '[/page]') !== false)
	{
		if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER))
		{
			foreach($m[1] as $k=>$v)
			{
				$p = $k+1;
				$titles .= '<a href="'.$pageurls[$p].'">'.$p.'、'.$v.'</a>';
			}
		}
	}
	$pages = $curl->show_pages($page, $pagenumber, $pageurls);
	$content = $contents[$page];
	if($titles)
	{
		list($title, $content) = explode('[/page]', $content);
	}
}

$title = $head['title'] = strip_tags($title);
$head['keywords'] = $r['keywords'];
$head['description'] = $r['description'];
if(!$template) $template = $C['template_show'];
include template('phpcms', $template);

?>