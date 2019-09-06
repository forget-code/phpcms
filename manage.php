<?php
require dirname(__FILE__).'/include/common.inc.php';

if(!$_userid) showmessage('请登陆', $MODULE['member']['url'].'login.php?forward='.urlencode(URL));

require_once 'form.class.php';
require_once 'admin/content.class.php';

$c = new content();
$c->set_userid($_userid);

$STATUS = cache_read('status.php');
if(is_array($STATUS))
{
	krsort($STATUS);
}
$head['title'] = '信息管理';

if($contentid)
{
	$data = $c->get($contentid);
	$catid = $data['catid'];
	$modelid = $CATEGORY[$catid]['modelid'];
}

switch($action)
{
    case 'add':
		if(!$G['allowpost'] || !$priv_group->check('catid', $catid, 'input', $_groupid)) showmessage('你所在的用户组没有发表权限');
        if(!isset($CATEGORY[$catid]))
	    {
			header('location:manage.php');
			exit;
		}
		if($CATEGORY[$catid]['type'] != 0) showmessage('非法参数！');
		$category = cache_read("category_$catid.php");
		extract($category);
        require_once 'attachment.class.php';
		$attachment = new attachment($mod, $catid);
		$presentpoint = intval($presentpoint);
		if($CATEGORY[$catid]['child'])
		{
			require_once 'stat.class.php';
			$stat = new stat();
			$totalnumber = $stat->count_content("userid='$_userid'");
			if(isset($CATEGORY[$catid]) && $CATEGORY[$catid]['type'] == 0)
			{
				$cats = submodelcat($CATEGORY[$catid]['modelid']);
				$categorys = '<select name="catid" id="catid" size="2" style="height:260px;width:350px;"><option value="0">请选择栏目</option>';
				foreach($cats AS $k=>$v)
				{
					$selected = '';
					if($v['child'] == 1) continue;
					if($v['child'] == 0 && $catid == $k) $selected = 'selected';
					$categorys .= "<option value='$k' $selected>$v[catname]</option>";
				}
				$categorys .= '</select>';
			}
			else
			{
				$categorys = form::select_category('phpcms', 0, 'catid', 'catid', '请选择栏目', $catid, 'size="2" style="height:260px;width:350px;"', 1, 1);
			}
			include template($mod, 'contribute_category');
		}
		else
		{
			if($dosubmit)
			{
				if(!$MODEL[$modelid]['ischeck']) $info['status'] = 99;
				$contentid = $c->add($info) ;
				if($contentid && isset($MODULE['pay']) && $presentpoint)
				{
					$api_msg = $presentpoint > 0 ? '投稿奖励' : '发布信息扣点';
					$pay_api = load('pay_api.class.php', 'pay', 'api');
					$pay_api->update_exchange('phpcms', 'point', $presentpoint, $api_msg);
				}
				showmessage('发布成功！', $forward);
			}
			else
			{
				if($presentpoint < 0 && $_point < abs($presentpoint))
				{
					if(isset($MODULE['pay']))
					{
						showmessage("您的积分不足！请充值！",$MODULE['pay']['url'].'showpayment.php?action=type&pay=card');
					}
					else
					{
						showmessage("您的积分不足！");
					}
				}
				require CACHE_MODEL_PATH.'content_form.class.php';
				$content_form = new content_form($modelid);
				$data['catid'] = $catid;
				$forminfos = $content_form->get($data);
				$position = catpos($catid, SCRIPT_NAME.'?action=manage&catid={$catid}');
				$member_detail = $db->get_one("SELECT c.email,d.* FROM ".DB_PRE."member_cache c,".DB_PRE."member_detail d WHERE c.userid=d.userid AND c.userid='$_userid'");
				$head['title'] = $CATEGORY[$catid]['catname'].'_发布信息_'.$PHPCMS['sitename'];
				include template($mod, 'manage');
			}
		}
		break;

    case 'edit':
        if(!isset($CATEGORY[$catid]) || $CATEGORY[$catid]['type'] != 0) showmessage('非法参数！');
		$category = cache_read("category_$catid.php");
		extract($category);

        require_once 'attachment.class.php';
		$attachment = new attachment($mod, $catid);

		if($dosubmit)
		{
			$contentid = intval($contentid);
			$r = $db->get_one("SELECT status FROM ".DB_PRE."content WHERE contentid=$contentid");
			if($r['status'] == 99) showmessage('您发布的信息已经通过审核，不能修改');
			$c->edit($contentid, $info);
			showmessage('修改成功！', $forward);
		}
		else
		{
			require CACHE_MODEL_PATH.'content_form.class.php';
			$content_form = new content_form($modelid);
			$forminfos = $content_form->get($data);
			$position = catpos($catid, SCRIPT_NAME.'?action=manage&catid={$catid}');
			$head['title'] = $CATEGORY[$catid]['catname'].'_修改信息_'.$PHPCMS['sitename'];
			include template($mod, 'manage');
		}
		break;

	case 'preview':
		$position = catpos($catid, SCRIPT_NAME.'?action=manage&catid={$catid}');

        require_once 'attachment.class.php';
		require CACHE_MODEL_PATH.'content_output.class.php';
		$attachment = new attachment($mod, $catid);
		$out = new content_output($modelid, $contentid);
		$info = $out->get($data);
		$fields = $out->fields;
		$head['title'] = $data['title'].'_预览信息_'.$PHPCMS['sitename'];
		include template($mod, 'manage');
		break;

    case 'delete':
		require_once 'attachment.class.php';
		$attachment = new attachment($mod);
		$c->delete($contentid);
		showmessage('操作成功！', $forward);
		break;

	default :
		$catid = max(intval($catid), 0);
	    if($catid)
	    {
			$category = cache_read("category_$catid.php");
			if(!$category) showmessage('非法参数！');
			extract($category);
		}
		$status = isset($status) ? intval($status) : 99;
		if(!isset($STATUS[$status])) $status = 99;
		$CATEGORY = subcat('phpcms');
		if(!$catid || $child)
	    {
			require_once 'tree.class.php';
			$tree = new tree;
			$category = array();
			foreach($CATEGORY as $cid => $cat)
			{
				if($cat['type']) continue;
				if(!$priv_group->check('catid', $cat['catid'], 'input', $_groupid)) continue;
				$count = $c->count("`catid`=$cid AND `status`=$status");
				$post = $cat['child'] ? "<font color='gray'>发布</font>" : "<a href='".SCRIPT_NAME."?action=add&catid=".$cat['catid']."'>发布</a>";
				$manage = " | <a href='".SCRIPT_NAME."?action=manage&catid=".$cat['catid']."&status=".$status."'>管理</a>";
				$category[$cid] = array('id'=>$cat['catid'], 'parentid'=>$cat['parentid'], 'name'=>$cat['catname'], 'count'=>$count, 'post'=>$post, 'manage'=>$manage, 'style'=>$cat['style'], 'mod'=>$mod, 'file'=>$file,'status'=>$status);
			}
			$str = "<tr><td class='align_left'>\$spacer<a href='".SCRIPT_NAME."?action=manage&catid=\$id&parentid=\$parentid&status=\$status'><span style='\$style'>\$name</span></a></td><td class='align_c'>\$count</td><td class='align_c'>\$post \$manage</td></tr>\n";
			$tree->tree($category);
			$categorys = $tree->get_tree($catid, $str);
		}
		else
	    {
			$data = $c->listinfo("`catid`=$catid AND `status`=$status", '`listorder` DESC,`contentid` DESC', $page, 20);
		}
		$position = catpos($catid, SCRIPT_NAME.'?action=manage&catid={$catid}');
		$head['title'] = $catid ? $CATEGORY[$catid]['catname'].'_信息管理_'.$PHPCMS['sitename'] : '信息管理_'.$PHPCMS['sitename'];
		include template($mod, 'manage');
}
?>