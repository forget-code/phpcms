<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption><?=$M['name']?>模块配置</caption>
	<tr>
      <th><strong>生成Html</strong></th>
      <td>
	  <input type='radio' name='setting[ishtml]' value='1' <?php if($ishtml){ ?>checked <?php } ?> onClick="$('#urlrule_1').show();$('#urlrule_0').hide();"> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ishtml]' value='0' <?php if(!$ishtml){ ?>checked <?php } ?> onClick="$('#urlrule_1').hide();$('#urlrule_0').show();"> 否
	  </td>
    </tr>
<tbody id="urlrule_1" style="display:<?=$ishtml ? '' : 'none'?>">
	<tr>
      <th><strong>类别页URL规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=special&filename=type&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td><?=form::select_urlrule($mod, 'type', 1, 'setting[type_urlruleid_1]', 'type_urlruleid_1', $type_urlruleid)?></td>
    </tr>
	<tr>
      <th><strong>专题页URL规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=special&filename=show&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td><?=form::select_urlrule($mod, 'show', 1, 'setting[show_urlruleid_1]', 'show_urlruleid_1', $show_urlruleid)?></td>
    </tr>
</tbody>
<tbody id="urlrule_0" style="display:<?=$ishtml ? 'none' : ''?>">
	<tr>
      <th><strong>类别页URL规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=special&filename=type&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td><?=form::select_urlrule($mod, 'type', 0, 'setting[type_urlruleid_0]', 'type_urlruleid_0', $type_urlruleid)?></td>
    </tr>
	<tr>
      <th><strong>专题页URL规则</strong><br />
	  <a href="?mod=phpcms&file=urlrule&action=add&module=special&filename=show&forward=<?=urlencode(URL)?>" style="color:red">点击新建URL规则</a></th>
      <td><?=form::select_urlrule($mod, 'show', 0, 'setting[show_urlruleid_0]', 'show_urlruleid_0', $show_urlruleid)?></td>
    </tr>
</tbody>
	<tr>
      <th><strong>模块URL地址</strong></th>
      <td><input name='setting[url]' type='text' id='url' value='<?=$url?>' size='40' maxlength='50'></td>
    </tr>
	<tr>
      <th></th>
      <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
    </tr>
</table>
</form>
</body>
</html>