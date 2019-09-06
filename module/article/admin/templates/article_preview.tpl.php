<?php include admintpl('header');?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">文章首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&job=check&channelid=<?=$channelid?>">审核文章</a> &gt;&gt; 文章预览 &gt;&gt; <a href="<?=$linkurl?>" target="_blank"><?=$title?></a></td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="2">文章预览</th>
  </tr>
<tr>
<td align="center" class="tablerow" colspan="2"><b><?=$title?></b></td>
</tr>


 <tr>
    <td class="tablerow" width="15%"><b>栏目</b></td>
	<td class="tablerow"><?=$catname?></td>
  </tr>
  <tr>
    <td class="tablerow"><b>关键词</b></td>
    <td class="tablerow"><?=$keywords?></td>
  </tr>
  <tr>
    <td class="tablerow"><b>日期</b></td>
    <td class="tablerow"><?=$adddate?></td>
  </tr>
  <tr>
    <td class="tablerow"><b>标题图片</b></td>
    <td class="tablerow"><a href="<?=$thumb?>" target="_blank"><?=$thumb?></td>
  </tr>
  <tr>
    <td class="tablerow"><b>作者</b></td>
    <td class="tablerow"><?=$author?></td>
  </tr>
  <tr>
    <td class="tablerow"><b>来源</b></td>
    <td class="tablerow"><?=$copyfrom?></td>
  </tr>
  
  <tr>
    <td class="tablerow"><b>内容简介</b></td>
    <td class="tablerow"><?=$introduce?></td>
  </tr>
  <tr>
    <td class="tablerow"><b>内容</b></td>
    <td class="tablerow"><?=$content?></td>
  </tr>
    <?php if(is_array($fields)) foreach($fields as $f) {?>
    <tr>
    <td class="tablerow"><b><?=$f['title']?></b></td>
    <td class="tablerow"><?=$f['value']?></td>
  </tr>
  <?php } ?>
<tr>
<td align="right" class="tablerow" colspan="2"><a href="javascript:history.go(-1);"><font color="red">返 回 上 一 步</font></a>&nbsp;</td>
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
