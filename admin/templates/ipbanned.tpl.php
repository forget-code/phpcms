<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<form name="myform" id='myform' method="get" action="?" >
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="<?=$file?>">
<input type="hidden" name="action" value="add">
 <table cellpadding="1" cellspacing="0" class="table_form">
    <tr>
      <caption>添加禁止 IP</caption>
    <tr>
      <td>IP地址：<input name="ip"  type="text" value="<?=$ip?>" size="20" maxlength="15" />&nbsp;&nbsp;解封日期：<?=form::date('expires', $expires)?>&nbsp;&nbsp;<input name="dosubmit" type="submit" value=" 添加 " /> &nbsp;&nbsp; 说明：可以使用“*”作为通配符禁止某段地址。</td>
    </tr>
  </table>
</form>

<form name="search" id='myform' method="get" action="?" >
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="<?=$file?>">
<input type="hidden" name="action" value="manage">
  <table cellpadding="1" cellspacing="0" class="table_form">
    <tr>
      <caption>查询禁止 IP</caption>
    <tr>
		<td>IP地址：<input type="text" name="sip" size="20" maxlength="15" value="<?=$sip?>"/> <input type="submit" name="search" value=" 查询 "/></td>
	</tr>
  </table>
</form>

<form name="delete" id='myform' method="get" action="?" >
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="<?=$file?>">
<input type="hidden" name="action" value="delete">
<table border="0" align="center" cellpadding="1" cellspacing="1" class="table_list">
    <caption>禁止 IP 列表</caption>
   <tr>
	<th>选中</th>
	<th>IP</th>
	<th>解封时间</th>
	<th>操作</th>
   </tr>
<?php 
if(is_array($data)) foreach($data as $r) { 
?>
<tr>
	<td class="align_c"><input type="checkbox" name="ip[]" value="<?=$r['ip']?>"></td>
	<td class="align_c"><a href="<?=ip_url($r['ip'])?>"><?=$r['ip']?></a></td>
	<td style="text-align:center;<?=$r['expires'] < TIME ? 'color:red' : ''?>"><?=date('Y-m-d', $r['expires'])?></td>
	<td class="align_c"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&ip=<?=$r['ip']?>">删除</a></td>
</tr>
<?php 
}
?>
</table>
<div class="button_box"><a href="#" onclick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="#" onclick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a> 	<input name="delete" type="submit"  value="删除选定的IP" />&nbsp;&nbsp;<input name="delete" type="button" value="删除所有过期IP" onclick="redirect('?mod=<?=$mod?>&file=<?=$file?>&action=clear')" /></div>
</form>
<div id="pages"><?=$ipbanned->pages?></div>
</body>
</html>