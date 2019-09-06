<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：商品首页 &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=tohtml">发布网页</a> </td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=4>更新商品html</th>
  </tr>
<tr align="center">
<td width="25%" class="tablerowhighlight">商品起始ID</td>
<td width="25%" class="tablerowhighlight">商品结束ID</td>
<td width="25%" class="tablerowhighlight">每轮生成商品数</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform2" action="?mod=<?=$mod?>&file=<?=$file?>&action=show">
  <tr align=center>
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minproductid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxproductid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成商品'>
    &nbsp;&nbsp;<input type="button" onclick="window.location='?mod=<?=$mod?>&file=product&action=manage'" value="管理商品" ></td>
  </tr>
</form>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=6>更新栏目</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="25%" class="tablerowhighlight">栏目名称</td>
<td width="28%" class="tablerowhighlight">栏目目录</td>
<td width="8%" class="tablerowhighlight">已生成</td>
<td width="32%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform">
<?=$categorys?>
  <tr>
    <td class="tablerow"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选</td>
    <td class="tablerow" colspan="5">&nbsp;&nbsp;
	<input type="submit" name="submit1" value="生成列表" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=list'">&nbsp;&nbsp;
	<input type="submit" name="submit2" value="生成商品" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=cat_product'">
	&nbsp;&nbsp;
	<input type="submit" name="submit3" value="生成目录" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=create_dir'">&nbsp;&nbsp;
	<input type="submit" name="submit4" value="删除目录" onClick="if(confirm('删除目录其子目录和文件都将会被删除，是否继续？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete_dir'">&nbsp;&nbsp;
	<input type="button" onclick="window.location='?mod=<?=$mod?>&file=category&action=manage'" value="管理栏目">
  </td>
  </tr>
</form>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th>提示信息</th>
  </tr>
  <tr>
    <td class="tablerow">
	1、如果单个栏目下商品过多（例如超过1万篇）而导致栏目更新困难，您可以通过下面的栏目进行分栏目更新。<br>
	2、如果你更换服务器空间或者更换了模板，希望所有网页重新生成，请依次重新生成所有html
	</td>
  </tr>
</table>
</body>
</html>