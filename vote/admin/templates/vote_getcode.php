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
  <tr align=center>
    <td class="tablerow" ><script language='javascript' src='<?=PHPCMS_SITEURL?>vote/data/vote_<?=$voteid?>.js'></script></td>
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
	<input name="script" type="text" size="100" value="<script language='javascript' src='<?=PHPCMS_SITEURL?>vote/data/vote_<?=$voteid?>.js'></script>">
    </td>
  </tr>
  <tr align=center>
    <td class="tablerowhighlight">(2) 标签调用代码 </td>
  </tr>
  <tr align=center>
    <td class="tablerow">
<input name="tag" type="text" size="100" value="{$voteshow(0,<?=$voteid?>)}">
</td>
  </tr>
</table>
</body>
</html>