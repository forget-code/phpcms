<?php
require './include/common.inc.php';

if(!$_userid) showmessage('只有注册会员才能上传视频，请登录',$MODULE['member']['url'].'login.php?forward='.urlencode(URL));
if(!$M['allow_upload']) showmessage('本站关闭了会员上传功能，如需上传视频，请联系管理员');
require MOD_ROOT.'include/video.class.php';
$v = new video();

require_once PHPCMS_ROOT.'member/include/member.class.php';
$member = new member();
require_once 'attachment.class.php';
$attachment = new attachment($mod, $catid);

if(!isset($action)) $action = 'manage';
switch($action)
{

	case 'manage':
		
		$status = isset($status) ? intval($status) : 99;
		
		$v->set_userid($_userid);
		$infos = $v->listinfo("status='$status'","vid DESC",$page,10);
		$pages = $v->pages;
		include template($mod, 'center_manage');
	break;

	case 'add':
		if($dosubmit)
		{
			require 'http.class.php';
			$http = new http();
		
			 //发布到ku6vms 获取 视频ku6vid
			$ku6vms_upload = "http://v.ku6vms.com/phpvms/api/upLoad/";
			$postdata['skey'] = $M['skey'];
			$postdata['sid'] = $sid;
			$postdata['title'] = $title = strip_tags($info['title']);
			$description = trim(strip_tags($info['description']));
			if($description=='')
			{
				$postdata['description'] = $title;
			}
			else
			{
				$postdata['description'] = $description;
			}
			$tag = trim(strip_tags($info['keywords']));
			if($tag)
			{
				$postdata['tag'] = $tag;
			}
			else
			{
				$postdata['tag'] = $title;
			}
			$postdata['v'] = 1;
			if(strtolower(CHARSET)=='gbk')
			{
				foreach ($postdata as $key=>$val) {
					$postdata[$key] = iconv('gbk', 'utf-8', $val);
				}
			}
			$postdata['md5'] = $md5string = strtoupper(md5($postdata['skey'].$postdata['v'].$postdata['sid'].$postdata['title'].$postdata['description'].$postdata['tag'].$M['sn']));
			$http->post($ku6vms_upload, $postdata, '', 0, 30, TRUE);
			//$a = $http->get_status();
			$get_data = $http->get_data();
			$get_data = json_decode($get_data, true);
			
			if($get_data['code'] != 200)
			{
				showmessage($get_data['msg']);
			}
			$info['status'] = $M['check_video'] ? 3 : 90;
			
			if(isset($info['inputtime'])) $info['updatetime'] = $info['inputtime'];
			$vid = $v->add($info);
			$v->update_ku6vid($vid,$get_data['vid']);
			if($vid) showmessage('发布成功！', '?mod='.$mod.'&file='.$file.'&action=add&catid='.$catid);
		}
		else
		{
			//KU6站外上传接口。 'http://v.ku6.com/uploadProcessForOutsite.htm?t=putInfo

			//获取SID的服务器
			$sid = @file_get_contents('http://v.ku6.com/uploadProcessForOutsite.htm?t=open');
			if (!$sid) {
				showmessage('遇到麻烦了，获取SID失败，请重新刷新页面');
			}
			
			$data['catid'] = $catid;
			$data['template'] = isset($template_show) ? $template_show :$MODEL[$modelid]['template_show'];

			require CACHE_MODEL_PATH.'video_form.class.php';
			
			$model_form = new model_form($modelid);
			$forminfos = $model_form->get($data);
			
           
			$categorys = '';
            $pagetitle = $CATEGORY[$catid]['catname'].'-发布';
			include template($mod, 'center_add');
		}
		
		break;
	case 'check_catid':
		if($CATEGORY[$catid]['child']==0)
		{
			exit('0');
		}
		else
		{
			exit('1');
		}
		break;

	case 'edit':
		$vid = intval($vid);
		if($dosubmit)
		{
			$v->edit($vid, $info);
			showmessage('修改成功！', $forward);
		}
		else
		{
			require CACHE_MODEL_PATH.'video_form.class.php';
			$content_form = new model_form($modelid);
			$data = $v->get($vid);
			$forminfos = $content_form->get($data);

			include template($mod, 'center_edit');
		}
		break;
}
?>