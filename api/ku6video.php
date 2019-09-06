<?php
require '../include/common.inc.php';
$ku6video = load('ku6video.class.php');
if(!is_a($c, 'content'))
{
	require '../include/admin/content.class.php';
	$c = new content();
}

$http = load('http.class.php');

switch($action)
{
	case 'post':
		$G['allowpost'] = 1;
		if(md5($ku6vid.$state.$PHPCMS['general_skey']) != $vcode) exit('illegal words');
		$contentid = $ku6video->get_contentid($ku6vid);
		if(!$contentid) exit('this content not exstists');
		
		if($state >= 20)
		{
			$ku6video->status($ku6vid, $state);
			$c->status($contentid, 99);
			$data = $c->get($contentid);
			if($picpath && !$data['thumb'])
			{
				$picpath = strpos($picpath, '://') ? $picpath = 'http://'.$picpath: $picpath;
				$info['catid'] = $data['catid'];
				$info['thumb'] = $picpath;
				$c->edit($contentid, $info);
			}
		}
		else
		{
			$c->status($contentid, 0);
		}
	break;

	case 'get':
		if(!$contentid) exit('short infomation');
		$arr_video = $ku6video->get($contentid);
		$arr_post['vid'] = $arr_video['vid'];
		$http->post(KU6_UNION.'vip/jumaInterface.php?method=request', $arr_post);
		$arr_get = json_decode($http->get_data(), true);
		$arr_content = $arr_get['ku6vid'];
		if($arr_get['STATUS'] == 'done')
		{
			$c->status($contentid, 99);
		}
	break;

	default:
		exit('ko');
	break;
}
?>