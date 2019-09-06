<?php
defined('IN_PHPCMS') or exit('Access Denied');

require_once MOD_ROOT.'include/video.class.php';
require_once 'attachment.class.php';
$v = new video();

$submenu = $allowprocessids = array();
$submenu[] = array('<font color="red">发布信息</font>', '?mod='.$mod.'&file='.$file.'&action=add&catid='.$catid);

// X 判断是否有权限管理视频
$allow_manage = 1;
$status = $status ? intval($status) : 99;
if($allow_manage)
{
	$submenu[] = array('管理视频', '?mod='.$mod.'&file='.$file.'&action=manage&_FB_=1&catid='.$catid,'',$_FB_,1);
	$submenu[] = array('审核视频', '?mod='.$mod.'&file='.$file.'&action=manage&_FB_=2&status=3&catid='.$catid,'',$_FB_,2);
	$submenu[] = array('待通知列表', '?mod='.$mod.'&file='.$file.'&action=manage&_FB_=3&status=90&catid='.$catid,'',$_FB_,3);
	$submenu[] = array('回收站', '?mod='.$mod.'&file='.$file.'&action=recycle&_FB_=4&catid='.$catid,'',$_FB_,4);
}
$menu = admin_menu($CATEGORY[$catid]['catname'].'视频管理', $submenu);

if(is_numeric($vid) && $vid>0)
{
	$data = $v->get($vid);
	$catid = $data['catid'];
}

$attachment = new attachment($mod, $catid);

switch($action)
{
    case 'add':
		if(!$priv_role->check('catid', $catid, 'add') && !$allow_manage) showmessage('无发布权限！');

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
			$get_data = $http->get_data();
			$get_data = json_decode($get_data, true);
			
			if($get_data['code'] != 200)
			{
				showmessage($get_data['msg']);
			}
			$info['status'] = ($status == 2 || $status == 3) ? $status : 90;
			
			if(isset($info['inputtime'])) $info['updatetime'] = $info['inputtime'];
			$vid = $v->add($info);
			$v->update_ku6vid($vid,$get_data['vid']);
			if($vid) showmessage('发布成功！', '?mod='.$mod.'&file='.$file.'&action=add&catid='.$catid);
		}
		else
		{
			if(!file_exists(PHPCMS_ROOT.'data/cache_model/video_form.class.php'))
			{
				require MOD_ROOT.'admin/include/fields/fields.inc.php';
				require MOD_ROOT.'admin/include/model_field.class.php';
				require MOD_ROOT.'admin/include/model.class.php';
				$field = new model_field($modelid);
				$model = new model();
				$model->cache();
				$field->cache();
			}
			if(empty($M['skey'])) showmessage('身份识别码不能为空，请到模块配置中设置');
			if(empty($M['sn'])) showmessage('加密密钥不能为空，请到模块配置中设置');
			if(empty($M['style_projectid'])) showmessage('调用方案编号不能为空，请到模块配置中设置');
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
			header("Cache-control: private");
			include admin_tpl('video_add');
		}
		break;

    case 'edit':

		if($dosubmit)
		{
			$info['status'] = ($status == 2 || $status == 3 || $status == 90) ? $status : 99;
			$v->edit($vid, $info);
			showmessage('修改成功！', $forward);
		}
		else
		{
			require CACHE_MODEL_PATH.'video_form.class.php';
			$content_form = new model_form($modelid);
			$forminfos = $content_form->get($data);

			include admin_tpl('video_edit');
		}
		break;

	case 'selectpic':
		if($data) {
			$picpath = $data['thumb'];
			$now_pic = substr(basename($data['thumb']),0,-4);//当前数据库图片
			$dir = dirname($picpath);
		}
		
		if($dosubmit) {
			if($n && is_numeric($n) || $n=='big') {
				
				$thumb = $dir.'/'.$n.'.jpg';
				$v->update_thumb($vid,$thumb);
				
				exit('1');
			}
		}

		if($data) {
			for($i=1;$i<9;$i++) {
				$infos[$i] = $dir.'/'.$i.'.jpg';
			}
			$infos['big'] = $dir.'/big.jpg';
			if($n) $now_pic = $n;
			include admin_tpl('selectpic');
		}
		else
		{
			showmessage('暂无图片');
		}
		break;
	case 'check':
		$v->status($vid,90);
		showmessage('操作成功！', $forward);
		break;
	case 'publish':
		$v->status($vid,99);
		showmessage('操作成功！', $forward);
		break;
	case 'check_title':
		if(CHARSET=='gbk') $c_title = iconv('utf-8', 'gbk', $c_title);
		if($c->get_vid($c_title))
		{	
			echo '此标题已存在！';
		}
		else
		{
			echo '标题不存在！';
		}
		break;

    case 'browse':
		$where = "`catid`=$catid AND `status`=99";
        $infos = $c->listinfo($where, 'listorder DESC,vid DESC', $page, 20);
		include admin_tpl('content_browse');
		break;

    case 'delete':
		if(!$allow_manage) showmessage('无管理权限！');
		$c->delete($vid);
		showmessage('操作成功！', $forward);
		break;

    case 'listorder':
		$result = $v->listorder($listorders);
		if($result)
		{
			showmessage('操作成功！', $forward);
		}
		else
		{
			showmessage('操作失败！');
		}
		break;

	case 'posid':
		if(!$posid) showmessage('不存在此推荐位！');
		if(!$vid) showmessage('没有被推荐的信息！');
		if(!$priv_role->check('posid', $posid)) showmessage('您没有此推荐位的权限！');
		foreach($vid as $cid)
		{
			if($v->get_posid($cid, $posid)) continue;
			$v->add_posid($cid, $posid);
		}
		showmessage('批量推荐成功！', '?mod='.$mod.'&file='.$file.'&action=manage&catid='.$catid);
		break;
	case 'add_to_special':
		$specialid = intval($specialid);
		require MOD_ROOT.'include/special.class.php';
		$special = new special;
		$special->add_to_special($specialid,$vid);
		showmessage("视频成功添加到专辑",$forward);
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
	case 'priview':
		//预览视频
		$r = $v->get($vid,2);
		$vmsvid = $r['vmsvid'];
		$style_projectid = $M['style_projectid'];
		include admin_tpl('video_priview');
		break;
	default:
		require_once MOD_ROOT.'admin/include/model_field.class.php';
        $model_field = new model_field($modelid);
		if($catid) {
			$where = "`catid`=$catid AND `status`=$status ";
		} else {
			$where = "`status`=$status ";
		}
	    
	    if($inputdate_start) $where .= " AND `inputtime`>='".strtotime($inputdate_start.' 00:00:00')."'"; else $inputdate_start = date('Y-m-01');
	    if($inputdate_end) $where .= " AND `inputtime`<='".strtotime($inputdate_end.' 23:59:59')."'"; else $inputdate_end = date('Y-m-d');
		if($q)
	    {
			if($field == 'title')
			{
				$where .= " AND `title` LIKE '%$q%'";
			}
			elseif($field == 'userid')
			{
				$userid = intval($q);
				if($userid)	$where .= " AND `userid`=$userid";
			}
			elseif($field == 'username')
			{
				$userid = userid($q);
				if($userid)	$where .= " AND `userid`=$userid";
			}
			elseif($field == 'vid')
			{
				$vid = intval($q);
				if($vid) $where .= " AND `vid`=$vid";
			}
		}
        $infos = $v->listinfo($where, '`listorder` DESC,`vid` DESC', $page, 10);

        $pagetitle = $CATEGORY[$catid]['catname'].'-管理';
       	$POSID[] = '批量添加至推荐位：' ;
		foreach($POS AS $key => $p)
		{
			if($priv_role->check('posid', $key))
			{
				$POSID[$key] = "::".$p;
			}
		}
		$POS = $POSID;
		//专辑分类
		if($specialid)
		{
			$special_arr = $db->get_one("SELECT * FROM ".DB_PRE."video_special WHERE specialid='$specialid'");
			$specialname = $special_arr['title'];
		}
		include admin_tpl('video_manage');
}
?>