<?php include admintpl('header');?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td>当前位置：文章预览 &gt;&gt; <?=$cat_pos?> <a href="<?=$url?>" target="_blank"><?=$title?></a></td>
    <td></td>
    <td align=right></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>文章预览</th>
  </tr>
<tr>
<td align=center class="tablerow"><b><? if($titleintact) { ?><?=$titleintact?><? } else { ?><?=$title?><? } ?></b></td>
</tr>
    <? if($subheading) { ?>
      <tr>
        <td height="30" valign="top">
   <table width="100%"  border="0" cellspacing="0" cellpadding="0">
       <tr>
       <td width="50%"></td>
       <td width="50%">——<?=$subheading?></td>
      </tr>
   </table>
    </td>
      </tr>
    <? } ?>
<tr>
<td align=center class="tablerow">作者：<?=$author?><? if($authoremail) { ?>(<a href="#" onclick="javascript:window.open('<?=PHPCMS_PATH?>mail/sendmail.php?mailto=<?=$authoremail?>','<?=$_PHPCMS[sitename]?>','width=460,height=310,top=0,left=0');"><?=$authoremail?></a>)<? } ?>&nbsp;&nbsp;&nbsp;&nbsp; 来源：<a href="<?=$copyfromurl?>"><?=$copyfromname?></a>&nbsp;&nbsp;&nbsp;&nbsp; 发表时间：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>&time=<?=$adddate?>"><?=$adddate?></a> </td>
</tr>
<tr>
<td align=left class="tablerow"><?=$content?></td>
</tr>
<tr>
<td align=right class="tablerow">
        <b>管理操作</b> 
        <a href="?mod=<?=$mod?>&file=<?=$file?>&action=pass&channelid=<?=$channelid?>&articleid=<?=$articleid?>" title="通过文章审核">批准</a> |
		<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&channelid=<?=$channelid?>&articleid=<?=$articleid?>" title="编辑文章">编辑</a> |
        <a href="#" onclick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=torecycle&value=1&channelid=<?=$channelid?>&articleid=<?=$articleid?>','确认删除文章吗？此操作可以从回收站恢复。')" title="将文章移至回收站">删除</a> |
		<a href="javascript:window.close()">[关闭窗口]</a></td>
</tr>
</table>
<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
  </tr>
</table>
<table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align=center></td>
  </tr>
</table>
</form>
</body>
</html>
