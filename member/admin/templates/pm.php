<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>

<?=$menu?>

<br />

<script language = 'JavaScript'>
// 表单提交检测
function doCheck(){
// 检测表单的有效性
// 如：标题不能为空，内容不能为空，等等....

	if (document.myform.catid.value=='0'){
	alert('指定的栏目不允许添加文章！只允许在其子栏目中添加文章。');
	document.myform.catid.focus();
	return false;
	}

	if (myform.title.value=="") {
	alert("请输入标题");
	document.myform.title.focus();
	return false;
	}

}

</script>




<? if($action=='add' || $action=='edit') { ?>

<script type="text/javascript" src="<?=PHPCMS_PATH?>fckeditor/fckeditor.js"></script>
<script type="text/javascript">
	var editorBasePath = '<?=PHPCMS_PATH?>fckeditor/';
	var ChannelId = 0 ;
</script>

<script type="text/javascript">
window.onload = function()
{
	var oFCKeditor = new FCKeditor('content') ;
	oFCKeditor.BasePath	= editorBasePath ;
	oFCKeditor.ReplaceTextarea() ;
}
</script>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=2>发送 / 编辑 系 统 信 件</th>
  </tr>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&pmid=<?=$pm['pmid']?>&submit=1">
<tr bgColor='#F1F3F5'>
<td>标 题:</td>
<td><input type="text" name="title" size="65" value="<?=$pm['title']?>"></td>
</tr>
<tr bgColor='#F1F3F5'>
<td valign="top">内 容:</td>
<td><textarea name="content" style="display:none"><?=$pm['content']?></textarea>
</td>
</tr>
<tr bgColor='#F1F3F5'>
<td> </td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value=" 提 &nbsp; 交 "></td>
</tr>
</table>
</form>



<? } elseif ($action=='view') { ?>



<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder">
<tr>
<th align=left>标题:<?=$pm['title']?> - <?=$pm['posttime']?></th>
</tr>
<tr  bgColor='#F1F3F5'>
<td><?=$pm['content']?></td>
</tr>
<tr bgColor='#F1F3F5'>
<td align="right">
<a href="#" onclick="javascript:history.go(-1);">返回</a>
</td>
</tr>
</table>


<? } else { ?>


<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=8>系 统 信 件 管 理</th>
  </tr>
  <tr align=center>
    <td width="5%" class="tablerowhighlight">ID</td>
    <td width="10%" class="tablerowhighlight">姓名</td>
    <td width="33%" class="tablerowhighlight">标题</td>
    <td width="17%" class="tablerowhighlight">时间</td>
    <td width="18%" class="tablerowhighlight">管理操作</td>
  </tr>
<? if(is_array($pms)) foreach($pms AS $pm) { ?>
  <tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
    <td height="23"><?=$pm[pmid]?></td>
    <td><?=$pm[fromusername]?></td>
    <td align=left><a href='?mod=<?=$mod?>&file=<?=$file?>&action=view&pmid=<?=$pm[pmid]?>'><?=$pm[title]?></a></td>
    <td><?=$pm[posttime]?></td>
    <td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&pmid=<?=$pm[pmid]?>">编辑</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&pmid=<?=$pm[pmid]?>">删除</a></td>
  </tr>
<? } ?>


</table>

<table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center height="40"><?=$pages?></td>
  </tr>
</table>

<br />
<br />

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th>站 内 信 件 清 理</th>
  </tr>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=clear&submit=1">  <tr bgColor='#F1F3F5'>
    <td height="25"> 清除  &nbsp; <input type="text" name="day" size="10" value="365">  &nbsp;  天以前的信件 &nbsp; <input type="submit" name="submit" value=" 提 &nbsp; 交 "> &nbsp; <span style="color:red;">[注意:此操作将删除所有会员在指定日期前的所有信件，并且不可恢复，请谨慎操作!]</span></td>
  </tr>
</table>
</form>


<? } ?>
</body>
</html>