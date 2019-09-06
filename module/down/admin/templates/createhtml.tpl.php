<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$mod?>&action=main&channelid=<?=$channelid?>">下载首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=tohtml&channelid=<?=$channelid?>">发布网页</a> </td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="4">更新下载</th>
  </tr>
<tr align="center">
<td width="25%" class="tablerowhighlight">下载起始ID</td>
<td width="25%" class="tablerowhighlight">下载结束ID</td>
<td width="25%" class="tablerowhighlight">每轮生成下载数</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform2" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>">
<input type="hidden" name="action" value="show" id="action">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$mindownid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxdownid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成下载'>&nbsp;&nbsp;<input type="submit" onClick="$('action').value='url';" value="更新地址" ></td>
  </tr>
</form>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableborder" >
  <tr>
    <th colspan="6">更新栏目</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="25%" class="tablerowhighlight">栏目名称</td>
<td width="15%" class="tablerowhighlight">栏目目录</td>
<td width="10%" class="tablerowhighlight">是否已生成</td>
<td width="35%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform">
<?=$categorys?>
  <tr>
    <td class="tablerow"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td class="tablerow" colspan="5">&nbsp;&nbsp;
	<input type="submit" name="submit1" value="生成列表" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=list&channelid=<?=$channelid?>'">&nbsp;&nbsp;
	<input type="submit" name="submit2" value="生成下载" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=cat_show&channelid=<?=$channelid?>'">&nbsp;&nbsp;
	<input type="submit" name="submit3" value="生成目录" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=create_dir&channelid=<?=$channelid?>'">&nbsp;&nbsp;
	<input type="submit" name="submit4" value="删除目录" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete_dir&channelid=<?=$channelid?>'">&nbsp;&nbsp;
	<input type="button" onClick="window.location='?mod=phpcms&file=category&action=manage&channelid=<?=$channelid?>'" value="管理栏目">
  </td>
  </tr>
</form>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableborder" >
  <tr>
    <th>分段更新</th>
  </tr>
<form method="post" name="myformper" action="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>">
  <tr height="30">
    <td class="tablerow">&nbsp;&nbsp;<?=$category_select?>&nbsp;&nbsp;每轮更新数据条数<input name="pernum" type="text" size="15" value="50">&nbsp;&nbsp;<input name='submit' type='submit' value=' 生成栏目列表 ' onClick="document.myformper.action='?mod=<?=$mod?>&file=<?=$file?>&action=per_list&channelid=<?=$channelid?>'">&nbsp;&nbsp;<input name='submit' type='submit' value=' 生成栏目下载 ' onClick="document.myformper.action='?mod=<?=$mod?>&file=<?=$file?>&action=per_show&channelid=<?=$channelid?>'" ></td>
  </tr>
</form>
<tr>
<td class="tablerow">&nbsp;&nbsp;提示：对于数据量较大的栏目，可用此方法分段更新栏目列表和栏目下载。注：每次只更新选中栏目，不包括其子栏目</td>
</tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>

</body>
</html>