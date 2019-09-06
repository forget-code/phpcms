<?php
defined('IN_PHPCMS') or exit('Access Denied');
function show_url($filename = 'product',$id = 0)
{
	global $userid,$siteurl,$M;
	if($userid)
	{
		if($M['enable_rewrite'])
		{
			$url =  $M['url']."show-$userid-$filename-$id.html";
		}
		else
		{
			$url =  $M['url'].'web/show.php?userid-'.$userid.'/category-'.$filename.'/id-'.$id.'.html';
		}
	}
	else
	{
		if($M['enable_rewrite'])
		{
			$url = $M['url'].$filename.'-'.$id.'.html';
		}
		else
		{
			$url = $M['url'].$filename.'.php?action=show&id='.$id;
		}
	}
	return $url;
}

function job_list_url($inputtime = 0,$station = 0,$genre = 0)
{
	global $M;
	$inputtime = intval($inputtime);
	$station = intval($station);
	if(!$genre)$genre = intval($genre);
	$genre = urlencode($genre);
	if($M['enable_rewrite'])
	{
		return $M['url']."job-list-$inputtime-$station-$genre.html";
	}
	else
	{
		return $M['url']."job.php?action=list&inputtime=$inputtime&station=$station&genre=$genre";
	}
}

function apply_list_url($inputtime = 0,$experience = 0,$genre = 0)
{
	global $M;
	$genre = urlencode($genre);
	if($M['enable_rewrite'])
	return $M['url']."job-applylist-$inputtime-$experience-$genre.html";
	else
	return $M['url']."job.php?action=applylist&amp;inputtime=$inputtime&amp;experience=$experience&amp;genre=$genre";
}

function list_url($filename,$catid)
{
	global $M;
	if($M['enable_rewrite'])
	{
		return $M['url']."$filename-list-$catid.html";
	}
	else
	{
		return $M['url']."$filename.php?catid=$catid";
	}
}

?>