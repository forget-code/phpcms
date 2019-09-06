<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">下载首页</a> &gt;&gt; 从本服务器批量添加 </td>
  </tr>
</table>
<script type="text/javascript">
function doCheck(){
	if ($F('dir')=="") {
		alert("请输入目录");
		$('dir').focus();
		return false;
	}
	if ($F('catid')==0) {
		alert("请选择栏目");
		$('catid').focus();
		return false;
	}

}
</script>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=add_batch_local&channelid=<?=$channelid?>" method="post" name="myform" onsubmit="return doCheck();">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="2">从本服务器批量添加</th>
  </tr>

  <tr>
<td width="20%" class="tablerowhighlight">目录类型</td>
<td class="tablerow">
<input type="radio" name="dirtype" value="0" checked onclick="dirhelp();"/>相对目录
<input type="radio" name="dirtype" id="realdir" value="1" onclick="dirhelp();"/>绝对目录
</td>
</tr>

<tr>
<td class="tablerowhighlight">目录地址</td>
<td class="tablerow"><input type="input" name="batch[dir]" size="40" id="dir" value="down/<?=$CHA['uploaddir']?>/"/> <br />
<span id="dirhelp"></span>
<script>
var a = '<font color="red">例如:</font> /usr\/local/或者 D:\\www\\download\\';
var b = '<font color="red">例如:</font>您指定的目录在 \'<font color="blue">网站根目录/down/uploadfiles/books/</font>\' 则请填写<font color="green">down/uploadfiles/books/</font>';
function dirhelp()
{
	$('dirhelp').innerHTML = $('realdir').checked ? a : b;
}
window.onload = dirhelp;
</script>

</td>
</tr>
<tr>
<td class="tablerowhighlight">指定文件后缀</td>
<td class="tablerow"><input type="input" name="batch[ext]" size="40" /> 多个后缀请用"|"隔开,例如:zip|rar|exe,留空表示所有文件</td>
</tr>
<tr>
<td class="tablerowhighlight">所属栏目</td>
<td class="tablerow"><?=$category_select?></td>
</tr>

 <tr> 
      <td class="tablerowhighlight">是否生成</td>
      <td class="tablerow"><input type="radio" name="batch[ishtml]" value="1" <?php if($CHA['ishtml']==1) {?>checked <?php } ?>  onclick="$('htmlrule').style.display='';$('phprule').style.display='none';"> 是 <input type="radio" name="batch[ishtml]" value="0" <?php if($CHA['ishtml']==0) {?>checked <?php } ?> onclick="$('htmlrule').style.display='none';$('phprule').style.display='';"> 否</td>
 </tr>
<tbody id="htmlrule" style="display:<?php if($CHA['ishtml']==0) {?>none<?php }?>"> 
<tr> 
		  <td class="tablerowhighlight">html文件生成目录</td>
		  <td class="tablerow"><input type="text" name="batch[htmldir]" ></td>
		</tr>
		<tr> 
		  <td class="tablerowhighlight">html文件名前缀</td>
		  <td class="tablerow"><input type="text" name="batch[prefix]"></td>
		</tr>
		<tr> 
		  <td class="tablerowhighlight">url规则（生成html）</td>
		  <td class="tablerow"><?=$html_urlrule?></td>
		</tr>
</tbody>
<tbody id="phprule" style="display:<?php if($CHA['ishtml']==1) {?>none<?php }?>">
		<tr> 
		  <td class="tablerowhighlight">url规则（不生成html）</td>
		  <td class="tablerow"><?=$php_urlrule?></td>
		</tr>
</tbody>
 <tr>
      <td class="tablerowhighlight">允许查看的会员组</td>
      <td class="tablerow"><?=$showgroup?></td>
    </tr>
    <tr>
      <td class="tablerowhighlight">阅读所需点数</td>
      <td class="tablerow">&nbsp;<input size="5" name="batch[readpoint]" type="input" /> 点</td>
    </tr>

	 <tr> 
      <td class="tablerowhighlight">下载状态</td>
		<td class="tablerow">
		<input name="batch[status]" type="radio" value="3" checked> 已通过&nbsp;
		<input name="batch[status]" type="radio" value="1"> 待审核&nbsp;</td>
	  </tr>


  <tr>
    <td class="tablerowhighlight"> </td>
    <td class="tablerow">
	<input type="submit" name="dosubmit" value=" 确定 " />
	&nbsp;&nbsp;
	<font color="red">Tips:</font>此功能对同一目录可反复使用,系统会自动监测文件是否已经被添加过
	</td>
  </tr>
</table>


</body>
</html>