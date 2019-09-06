<?php
define('MOD_ROOT', substr(dirname(__FILE__), 0, -8));

$mod = 'vote';
require_once substr(MOD_ROOT, 0, -strlen($mod)).'include/common.inc.php';
if(!isset($keyid)) $keyid = 0;
require MOD_ROOT.'/include/vote.class.php';
require_once MOD_ROOT.'/include/tag.func.php';
require_once PHPCMS_ROOT.'/include/form.class.php';
require_once MOD_ROOT.'/include/global.func.php';
$admin_vote = new vote($voteid);

$head['title'] = $MOD['name'];
$head['keywords'] = $MOD['seo_keywords'];
$head['description'] = $MOD['seo_description'];

$page = max(1,intval($page));
$pagesize = isset($pagesize) && $pagesize<500 ? intval($pagesize) : $PHPCMS['pagesize'];
$pagesize = $pagesize>0?$pagesize:20;
$offset = ($page-1)*$pagesize;

$offset =intval($offset)<0?0:intval($offset);

$errmsg=array(
	'0'=>'illegal_parameters',
	'-2'=>'vote_disabled',
	'-3'=>'vote_expired',
	'-4'=>'has_voted',
	'-5'=>'later_vote',
	'-6'=>'group_disabled',
	'-7'=>'anonymous_cant_not_vote',
	'-8'=>'has_voted',
	'-9'=>'anonymous_cant_not_vote'
);
?>