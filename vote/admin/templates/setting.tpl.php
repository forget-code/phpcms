<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption><?=$M['name']?>模块配置</caption>
	<tr>
      <td width='40%'>启用编辑器</td>
      <td >
      <input type="radio" name="setting[editor]" value="1" <?=$editor?'checked':''?> />是 &nbsp;&nbsp;
      <input type="radio" name="setting[editor]" value="0" <?=$editor?'':'checked'?>>否&nbsp;&nbsp;      </td>
    </tr>
    <tr>
      <td width='40%' >投票页默认模板</td>
      <td >
      <?=form::select_template($mod,'setting[template]','',$template)?>      </td>
    </tr>
    <tr>
      <td width='40%' >默认是否启用验证码</td>
      <td >
      <input type="radio" name="setting[checkcode]" value="1" <?=$checkcode?'checked':''?> />是  &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="radio" name="setting[checkcode]" value="0" <?=$checkcode?'':'checked'?> />否      </td>
    </tr>
	<tr>
      <td width='40%' >默认是否允许游客投票	  </td>
      <td >
	  <input type='radio' name='setting[anonymous]' value='1'  <?=$anonymous?'checked':''?> > 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[anonymous]' value='0'  <?=$anonymous?'':'checked'?> > 否     </td>
    </tr>
</table><br />
<input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;
<input type="reset" name="reset" value=" 重置 ">

</form>
</body>
</html>