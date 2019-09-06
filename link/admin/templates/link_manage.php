<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>



<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=7>友情链接管理</th>
  </tr>
  <tr align=center>
    <td width="5%" class="tablerowhighlight">选中</td>
    <td width="5%" class="tablerowhighlight">排序</td>
    <td width="8%" class="tablerowhighlight">链接类型</td>
    <td width="20%" class="tablerowhighlight">网站名称</td>
    <td width="12%" class="tablerowhighlight">网站Logo</td>
    <td class="tablerowhighlight">网站概况</td>
    <td width="6%" class="tablerowhighlight">操作</td>
  </tr>
  <form name="myform" method="post" action="?mod=link&file=link&action=updateorderid&channelid=<?=$channelid?>">
  <input type="hidden" name="channelid" value="<?=$channelid?>">
<? if(is_array($links)) foreach($links AS $link) { ?>
  <tr align=center>
    <td class="tablerow"><input name='siteid[]' type='checkbox' id='siteid[]' value='<?=$link[siteid]?>'></td>
    <td class="tablerow"><input size=4 name="orderid[<?=$link[siteid]?>]" type=text value="<?=$link[orderid]?>"></td>
    <td class="tablerow"><? if($link[linktype]) { ?>Logo<? } else { ?>文字<? } ?></td>
    <td align="left" class="tablerow"><a href='<?=$link[url]?>' target='_blank' title='<?=$link[url]?>'><?=$link[name]?></a><? if($link[elite]) { ?> <font color='red'>荐</font><?}?></td>
    <td class="tablerow"><? if($link[linktype]) { ?><a href='<?=$link[url]?>' target='_blank' title='<?=$link[logo]?>'><img src='<?=$link[logo]?>' width='88' height='31' border='0'></a><? } ?></td>
    <td class="tablerow">
	<textarea name="introduction" cols="55" rows="2" id="introduction">简介:<?=$link[introduction]?><?=chr(13)?>站长:<?=$link[username]?> <?=$link[email]?>
    </textarea></td>
    <td class="tablerow"><a href="?mod=link&file=link&action=edit&siteid=<?=$link[siteid]?>&channelid=<?=$channelid?>">修改</a> </td>
  </tr>

<? } ?>

</table>

<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
		<input type="submit" name="submit" value=" 更新排序 ">&nbsp;
       <? if($passed) { ?>
        <input name='submit5' type='submit' value='取消批准' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=pass&passed=0&channelid=<?=$channelid?>'" >&nbsp;
		<? } else { ?>
		<input name='submit4' type='submit' value='批准链接' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=pass&passed=1&channelid=<?=$channelid?>'" >&nbsp;
		<? } ?>
        <input name='submit2' type='submit' value='推荐链接' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&elite=1&channelid=<?=$channelid?>'" >&nbsp;
        <input name='submit3' type='submit' value='取消推荐' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&elite=0&channelid=<?=$channelid?>'" >&nbsp;
		<input name='submit6' type='submit' value='删除链接'		onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&channelid=<?=$channelid?>'"></td>
  </tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
</form>






<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th align=center> 链接搜索 </th>
  </tr>
<form method="post" name="search">
  <tr>
    <td class="tablerow">&nbsp;
	<b>显示选项：</b> <input name='passed' type='radio' value='1' onclick="location='?mod=link&file=link&action=manage&passed=1&channelid=<?=$channelid?>'" <? if($passed==1) { ?>checked<? } ?>><a href='?mod=link&file=link&action=manage&passed=1&channelid=<?=$channelid?>'>已审核的链接</a>&nbsp;<input name='passed' type='radio' value='0' onclick="location='?mod=link&file=link&action=manage&passed=0&channelid=<?=$channelid?>'" <? if(!$passed) { ?>checked<? } ?>><a href='?mod=link&file=link&action=manage&passed=0&channelid=<?=$channelid?>'>未审核的链接</a>&nbsp;<input name='channelid' type='hidden' value='<?=$channelid?>'>
	关键字：<input name='keyword' type='text' size='15' value='<?=$keyword?>'>&nbsp;
    <input type="radio" name="linktype" value="1" <?if($linktype==1){?>checked<?}?>> <a href='?mod=link&file=link&action=manage&passed=<?=$passed?>&linktype=1&channelid=<?=$channelid?>'>Logo链接</a>	
	<input type="radio" name="linktype" value="0" <?if($linktype==0){?>checked<?}?>> <a href='?mod=link&file=link&action=manage&passed=<?=$passed?>&linktype=0&channelid=<?=$channelid?>'>文字链接</a>
	<input type="checkbox" name="elite" value="1" <?if($elite){?>checked<?}?>> 推荐
	<input name='submit' type='submit' value='链接搜索'></td>
  </tr>
</form>
</table>

</body>
</html>