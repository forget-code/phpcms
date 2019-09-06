<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body onLoad="is_ie();$('#setting').load('?mod=<?=$mod?>&file=<?=$file?>&action=setting_edit&modelid=<?=$modelid?>&fieldid=<?=$fieldid?>&formtype=<?=$formtype?>');">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&modelid=<?=$modelid?>&formtype=<?=$formtype?>&issystem=<?=$issystem?>" method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="table_form">
  <caption>复制<?=$field?>字段</caption>
	<tr> 
      <th width="25%"><strong>字段名</strong><br />
	  只能由英文字母、数字和下划线组成，并且仅能字母开头，不以下划线结尾
	  </th>
      <td><input size="20" name="info[field]" id="field" require="true" datatype="limit|ajax" min="1" max="20" url="?mod=<?=$mod?>&file=<?=$file?>&action=checkfield&modelid=<?=$modelid?>" msg="字符须为1到10位|"><font color="red">*</font></td>
    </tr>
	<tr> 
      <th><strong>字段别名</strong><br />例如：文章标题</th>
      <td><input type="text" name="info[name]" value="" size="30"></td>
    </tr>
	<tr> 
      <th><strong>字段提示</strong><br />显示在字段别名下方作为表单输入提示</th>
      <td><textarea name="info[tips]" rows="2" cols="20" id="tips" style="height:60px;width:250px;"><?=$tips?></textarea></td>
    </tr>
	<tr> 
      <th><strong>字段类型</strong><br /></th>
      <td>
	  <select name="info[formtype]" id="formtype" disabled>
<?php foreach($fields as $type=>$name)
{
    $selected = $type == $formtype ? 'selected' : '';
	echo "<option value=\"$type\" $selected>$name</option>\n";
} 
?>
	  </select>
	  </td>
    </tr>
	<tr> 
      <th><strong>相关参数</strong><br />设置表单相关属性</th>
      <td><div id="setting"></div></td>
    </tr>
	<tr> 
      <th><strong>表单附加属性</strong><br />可以通过此处加入javascript事件</th>
      <td><input type="text" name="info[formattribute]" value="<?=$formattribute?>" size="50"></td>
    </tr>
	<tr> 
      <th><strong>表单样式名</strong><br />定义表单的CSS样式名</th>
      <td><input type="text" name="info[css]" value="<?=$css?>" size="10"></td>
    </tr>
	<tr> 
      <th><strong>字符长度取值范围</strong><br />系统将在表单提交时检测数据长度范围是否符合要求，如果不想限制长度请留空</th>
      <td>最小值：<input type="text" name="info[minlength]" id="minlength" value="<?=$minlength?>" size="5"> 最大值：<input type="text" name="info[maxlength]" id="maxlength" value="<?=$maxlength?>" size="5"></td>
    </tr>
	<tr> 
      <th><strong>数据校验正则</strong><br />系统将通过此正则校验表单提交的数据合法性，如果不想校验数据请留空</th>
      <td><input type="text" name="info[pattern]" id="pattern" value="<?=$pattern?>" size="40"> 
<select name="pattern_select" onChange="javascript:$('pattern').value=this.value">
<option value="">常用正则</option>
<?php 
foreach($patterns as $p)
{
	echo "<option value=\"{$p[pattern]}\">{$p[name]}</option>\n";
}
?>
</select>
	  </td>
    </tr>
	<tr> 
      <th><strong>数据校验未通过的提示信息</strong><br />当表单数据不满足正在校验时的系统提示信息</th>
      <td><input type="text" name="info[errortips]" value="<?=$errortips?>" size="50"></td>
    </tr>
	<tr> 
      <th><strong>作为搜索条件</strong></th>
      <td><input type="radio" name="info[issearch]" value="1" <?=($issearch) ? 'checked' : ''?> /> 是 <input type="radio" name="info[issearch]" value="0" <?=($issearch) ? '' : 'checked'?>> 否</td>
    </tr>
	<tr> 
      <th><strong>是否在用户列表中显示</strong></th>
      <td><input type="radio" name="info[islist]" value="1" <?=($islist ? 'checked' : '')?> /> 是 <input type="radio" name="info[islist]" value="0"  <?=($islist ? '' : 'checked')?> /> 否</td>
    </tr>
	<tr> 
      <th><strong>是否在用户资料中显示</strong></th>
      <td><input type="radio" name="info[isshow]" <?=($isshow ? 'checked' : '')?> value="1"> 是 <input type="radio" name="info[isshow]" value="0" <?=($isshow ? '' : 'checked')?>> 否</td>
    </tr>
	<tr> 
      <th><strong>作为标签默认读取字段</strong></th>
      <td><input type="radio" name="info[isselect]" <?=($isselect ? 'checked' : '')?> value="1"> 是 <input type="radio" name="info[isselect]" value="0" <?=($isselect ? '' : 'checked')?>> 否</td>
    </tr>
	<tr> 
      <th><strong>作为标签调用条件</strong></th>
      <td><input type="radio" name="info[iswhere]" <?=($iswhere ? 'checked' : '')?> value="1"> 是 <input type="radio" name="info[iswhere]" value="0" <?=($iswhere ? '' : 'checked')?>> 否</td>
    </tr>
	<tr> 
      <th><strong>作为标签调用排序字段</strong></th>
      <td><input type="radio" name="info[isorder]" <?=($isorder ? 'checked' : '')?> value="1"> 是 <input type="radio" name="info[isorder]" value="0" <?=($isorder ? '' : 'checked')?>> 否</td>
    </tr>
	<tr> 
      <th><strong>禁止设置字段值的会员组</strong></th>
      <td><?=$unsetgroups?></td>
    </tr>
	<tr> 
      <th><strong>禁止设置字段值的角色</strong></th>
      <td><?=$unsetroles?></td>
    </tr>
	<tr>
	  <td></td>
	  <td>
		<input type="hidden" name="forward" value="?mod=<?=$mod?>&file=<?=$file?>&action=manage&modelid=<?=$modelid?>"> 
		<input type="submit" name="dosubmit" value=" 确定 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
	</tr>
    </table>
	</form>
</body>
</html>