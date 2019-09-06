<?php 
require dirname(__FILE__).'/include/common.inc.php';

$keyword = load('keyword.class.php');
$tag = safe_replace($tag);
$data = $keyword->get($tag);
if(!$data) showmessage("TAG: $tag 不存在！");
$keyword->hits($tag);
extract($data);

$head['title'] = $tag.'-'.$PHPCMS['sitename'];

include template('phpcms', 'tag');
?>