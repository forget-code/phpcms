<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&departmentid=<?=$departmentid?>&forward=<?=$forward?>">
<table align="center" cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="2">添加部门</th>
  </tr>
  <tr>
    <td width="20%" class="tablerow"><strong>部门名称</strong></td>
	<td class="tablerow"><input name="department" type="text" size="30" value="<?=$department?>" /></td>
  </tr>
    <tr>
      <td  class='tablerow'><strong>部门介绍</strong><br></td>
      <td class='tablerow'><textarea name='note' cols='60' rows='4' id='note'><?=$note?></textarea>  <?=editor('note','introduce',400,200)?></td>
    </tr>
  <tr>
    <td class="tablerow"><strong>允许提问的会员组</strong></td>
	<td class="tablerow"><?=$showgroup?></td>
  </tr>
   <tr>
    <td class="tablerow"><strong>提问所需点数</strong></td>
	<td class="tablerow"><input name="point" type="text" size="5" value="<?=$point?>"/> 点</td>
  </tr>
   <tr>
    <td class="tablerow"><strong>部门管理员</strong></td>
	<td class="tablerow"><input name="admin" type="text" size="20" value="<?=$admin?>"/></td>
  </tr>
  <tr>
    <td class="tablerow">
	</td>
	<td class="tablerow">
	<input name="dosubmit" type="submit" value=" 确定 " /> <input name="reset" type="reset" value=" 重置 " />
	</td>
  </tr>
</table>
</form>

</body>
</html>