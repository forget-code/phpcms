<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
   <caption><?=$M['name']?>模块配置</caption>
   <tr>
      <th ><strong>身份识别码</strong></th>
      <td><input name='setting[skey]' type='text' id='skey' value='<?=$skey?>' size='32' maxlength='50'> <a href="http://www.ku6vms.com/register.php">必填项：请到 www.ku6vms.com 申请开通帐号</a></td>
    </tr>
    <tr>
      <th ><strong>加密密钥</strong></th>
      <td><input name='setting[sn]' type='text' id='sn' value='<?=$sn?>' size='32' maxlength='50'>必填项</td>
    </tr>
	<tr>
      <th ><strong>调用方案编号</strong></th>
      <td><input name='setting[style_projectid]' type='text' id='style_projectid' value='<?=$style_projectid?>' size='32' maxlength='50'>必填项</td>
    </tr>
	<tr>
      <th><strong>栏目页规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=video&filename=category&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td>
	  <span id="categorySpan" ><?=form::select_urlrule($mod, 'category', 0, 'category', 'category', $categoryUrlRuleid)?></span>
	  </td>
    </tr>
	<tr>
      <th><strong>内容页规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=video&filename=show&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td>
	  <span id="showSpan" ><?=form::select_urlrule($mod, 'show', 0, 'show', 'show',$showUrlRuleid)?></span>
	  </td>
    </tr>
	<tr>
      <th><strong>专辑列表规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=video&filename=special&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td>
	  <span id="special" ><?=form::select_urlrule($mod, 'special', 0, 'setting[specialUrlRuleid]', 'special', $specialUrlRuleid)?></span>
	  </td>
    </tr>
	<tr>
      <th><strong>专辑首页分页规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=video&filename=specialpage&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td>
	  <span id="specialpage" ><?=form::select_urlrule($mod, 'specialpage', 0, 'setting[sPageUrlRuleid]', 'specialpage', $sPageUrlRuleid)?></span>
	  </td>
    </tr>
	<tr>
      <th><strong>专辑内容页规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=video&filename=show&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td>
	  <span id="showSpan" ><?=form::select_urlrule($mod, 'specialshow', 0, 'setting[SUrlRuleid]', 'show',$SUrlRuleid)?></span>
	  </td>
    </tr>
	<tr>
      <th ><strong>模型ID</strong></th>
      <td> <?=$modelid?> <input name='setting[modelid]' type='hidden' id='modelid' value='<?=$modelid?>' size='3' maxlength='50'></td>
    </tr>
	<tr>
      <th ><strong>当前模块栏目ID</strong></th>
      <td><input name='setting[menu_selectid]' type='text' id='menu_selectid' value='<?=$menu_selectid?>' size='3' maxlength='50'></td>
    </tr>
	<tr>
      <th><strong>是否允许会员上传视频</strong></th>
      <td><input name='setting[allow_upload]' type='radio' value="1" <?php if($allow_upload) echo "checked";?>> 是 <input name='setting[allow_upload]' type='radio' value="0" <?php if(!$allow_upload) echo "checked";?>> 否</td>
    </tr>
	<tr>
      <th><strong>会员上传视频是否需要审核</strong></th>
      <td><input name='setting[check_video]' type='radio' value="1" <?php if($check_video) echo "checked";?>> 是 <input name='setting[check_video]' type='radio' value="0" <?php if(!$check_video) echo "checked";?>> 否</td>
    </tr>
	<tr>
      <th ><strong>模块访问网址（URL）</strong></th>
      <td><input name='setting[url]' type='text' id='url' value='<?=$url?>' size='40' maxlength='50'></td>
    </tr>
</table>

<table width="100%" height="25" cellpadding="0" cellspacing="1">
  <tr>
     <td width='40%'></td>
     <td>
	 <input type="hidden" name="hiddenShowUrlRuleid" value="<?=$showUrlRuleid?>">
	 <input type="hidden" name="hiddenCategoryUrlRuleid" value="<?=$categoryUrlRuleid?>">
	 <input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>