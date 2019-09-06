<?php
require_once './include/common.inc.php';
$lastedittime = @filemtime('index_cache.html');
$lastedittime = $PHP_TIME-$lastedittime;
$autoupdatetime = intval($MOD['autoupdate']);
if(file_exists('index_cache.html') && $lastedittime<$autoupdatetime)
{	
	include 'index_cache.html';
}
else
{
	$CATEGORY = cache_read('categorys_'.$mod.'.php');
	$end_vote_r = $db->query("SELECT qid,score,endtime FROM ".TABLE_WENBA_QUESTION." WHERE status=3");
	while($r=$db->fetch_array($end_vote_r))
	{
		if($r['endtime']<$PHP_TIME)
		{
			$hight_vote = $db->get_one("SELECT aid,username FROM ".TABLE_WENBA_ANSWER." WHERE qid=".$r['qid']." ORDER BY vote_count DESC LIMIT 0,1");
			@extract($hight_vote);
			$db->query("UPDATE ".TABLE_MEMBER." SET credit=credit+".$r['score']." WHERE username='$username'");
			$db->query("UPDATE ".TABLE_WENBA_ANSWER." SET accept_status=1 WHERE aid=".$aid." AND qid=".$r['qid']);
			$db->query("DELETE FROM ".TABLE_WENBA_VOTE." WHERE qid=".$r['qid']);
			$db->query("UPDATE ".TABLE_WENBA_QUESTION." SET status=2,introtime=$PHP_TIME WHERE qid=".$r['qid']);
		}
	}
	@extract($db->get_one("SELECT count(*) AS solve_ques_count FROM ".TABLE_WENBA_QUESTION." WHERE status = 2" ));
	@extract($db->get_one("SELECT count(*) AS nosolve_ques_count FROM ".TABLE_WENBA_QUESTION." WHERE status = 1" ));
	ob_start();
	include template($mod, 'index');
	$data .= ob_get_contents();
	ob_clean();
	file_put_contents('index_cache.html', $data);
	@chmod('index_cache.html', 0777);	
	echo $data;
}
?>