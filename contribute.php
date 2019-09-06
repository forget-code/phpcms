<?php
require dirname(__FILE__).'/include/common.inc.php';
if(!$G['allowpost']) showmessage('你所在的用户组没有发表权限');
if($_userid)
{
	header("Location:manage.php?action=add&catid=$catid");
	exit;
}

require_once 'form.class.php';
require_once 'admin/content.class.php';

$c = new content();

$STATUS = cache_read('status.php');
if(is_array($STATUS))
{
	krsort($STATUS);
}
$head['title'] = '信息管理';

if(!$contribute)
{
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
	if($catid == '') showmessage('请选择栏目',$forward);
	if($CATEGORY[$catid]['child']) showmessage('请选择的栏目不允许发布信息，请重新选择',$forward);
	if(!isset($CATEGORY[$catid]) || $CATEGORY[$catid]['type'] != 0) showmessage('非法参数！');
	$category = cache_read("category_$catid.php");
	extract($category);

	require_once 'attachment.class.php';
	$attachment = new attachment($mod, $catid);

	if($dosubmit)
	{
		checkcode($checkcodestr,1,'goback');
		$contentid = $c->add($info);
		showmessage('发布成功！', $forward);
	}
	else
	{


		require CACHE_MODEL_PATH.'content_form.class.php';
		$content_form = new content_form($modelid);
		$data['catid'] = $catid;
		$forminfos = $content_form->get($data);
		include template($mod, 'contribute');
	}
}
?>