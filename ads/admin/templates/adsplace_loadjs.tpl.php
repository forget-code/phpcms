<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder"><form method="post" name="myform">
<tr>
<th><a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage"><font color="white"><B><?php echo $loadadsplace['placename']; ?></B>&nbsp;广告位代码调用</font></a></th>
</tr>
<tr>
<td class="tablerow" align="center"><textarea name="jscode" id="jscode" rows="3" cols="100"><script language="javascript" src="<?=linkurl($MOD['linkurl'],1)?>ad.php?id=<?=$placeid?>"></script></textarea>
<br><input type="button" onclick="document.all.jscode.select();document.execcommand('copy');" value=" 复制代码至剪贴板 ">
&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.open('?mod=ads&file=adsplace&action=view&placeid=<?=$placeid?>');" value="查阅当前用户广告位效果"></td>
</tr>
</table>