<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
    <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" border="0" class="tableBorder" >
 <tr>
    <th>投票预览</th>
  </tr>
  <tr align="left">
    <td style="padding:5 100">
		<?=$voteform?>
	</td>
  </tr>
</table>
<br/>
<table cellpadding="2" cellspacing="1" border="0" class="tableBorder" >
 <tr>
    <th>获取调用代码</th>
  </tr>
  <tr align=center>
    <td class="tablerowhighlight">(1) JS调用代码</td>
  </tr>
  <tr align=center>
    <td class="tablerow">
	<input name="script" type="text" size="100" value="<script language='javascript' src='<?=$PHP_SITEURL?>vote/data/vote_<?=$voteid?>.js'></script>" onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');" >
    </td>
  </tr>
  <tr align=center>
    <td class="tablerowhighlight">(2) 标签调用代码 </td>
  </tr>
  <tr align=center>
    <td class="tablerow">
<input name="tag" type="text" size="100" value="{$vote_show(0,<?=$voteid?>)}" onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');" >
</td>
  </tr>
    <tr align=center>
    <td class="tablerowhighlight">(3) HTML调用代码 </td>
  </tr>
  <tr align=center>
    <td class="tablerow">
<textarea name="tag" cols="100" rows="15" onDblClick="clipboardData.setData('text',this.value); alert(this.value +'已复制到剪贴板');">
<?=$voteform?>
</textarea>
</td>
  </tr>
</table>
</body>
</html>