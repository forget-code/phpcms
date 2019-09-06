<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>自定义网页管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td width="35" class="tablerowhighlight">选中</td>
<td width="250" class="tablerowhighlight">标题</td>
<td class="tablerowhighlight">链接地址</td>
<td width="100" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($mypages)) foreach($mypages AS $page) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="mypageid[]"  id="mypageid[]" value="<?=$page[mypageid]?>"></td>
<td align="left"><a href="<?=$page[url]?>" target="_blank"><?=$page[meta_title]?></a></td>
<td align="left"><a href="<?=$page[url]?>" target="_blank"><?=$page[url]?></a></td>
<td><a href='?mod=<?=$mod?>&file=mypage&action=edit&mypageid=<?=$page[mypageid]?>&channelid=<?=$channelid?>'>修改</a> | <a href='?mod=<?=$mod?>&file=mypage&action=delete&mypageid=<?=$page[mypageid]?>&channelid=<?=$channelid?>'>删除</a></td>
</tr>
<? } ?>
</table>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td>&nbsp;&nbsp;
		<input name="submit2" type="submit"  value="删除选定的自定义网页" onClick="document.myform.action='?mod=<?=$mod?>&file=mypage&action=delete&channelid=<?=$channelid?>&referer=<?=$referer?>'">&nbsp;&nbsp;
     </td>
  </tr>
</table>
</form>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td height="20" align="center"><?=$pages?></td>
  </tr>
</table>
<br>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
请先添加一个网页模板，然后再添加自定义网页并套用该模板。<br>
在自定义网页模板中，您可以使用标签来动态获取内容。<br>
配合标签功能，您可以通过自定义网页来随心所欲地制作出自己想要的内容页面。
</td>
  </tr>
</table>
</body>
</html>