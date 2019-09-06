<?php
function actor($actortype = 0, $credit = 0)
{
	$ACTOR = cache_read('actor.php', '', 1);
	$actortype = intval($actortype);
	foreach($ACTOR[$actortype] As $k=>$v)
	{
		if($credit >= $v['min'] && $credit <= $v['max'])
		{
			$data = $v['grade'].' '.$v['actor'];
		}
		elseif($credit>$v['max'])
		{
			$data = $v['grade'].' '.$v['actor'];
		}
	}
	return $data;
}
function ask_url($id)
{
	global $URLRULE,$MODULE;
	$M = cache_read('module_ask.php', '', 1);
	$urlrule = $URLRULE[$M['showUrlRuleid']];
	eval("\$url = \"$urlrule\";");
	$url = $MODULE['ask']['url'].$url;
	return $url;
}
?>