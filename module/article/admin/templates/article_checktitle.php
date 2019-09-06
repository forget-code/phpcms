<?php include admintpl('header');?>
<body>
<table cellpadding="1" cellspacing="1"  width="100%">
  <tr>
    <td height=6> </td>
  </tr>
  </table>
<?php 
if($error_msg){
?>
<table cellpadding="1" cellspacing="1" class="tableborder" width="100%">
  <tr>
    <th>提示:出错了:(</th>
  </tr>  
  <tr>
    <td class="tablerow"><?=$error_msg?></td>
  </tr>

<?php 
} else {	
?>
<table cellpadding="1" cellspacing="1" class="tableborder" width="100%">
<? if($articles) { ?>
  <tr>
    <th>提示:找到如下类似标题:</th>
  </tr>  

<? foreach($articles AS $article) { ?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align=left class="tablerow"><a href="<?=$article[url]?>" target="_blank"><?=$article[title]?></a> <?=$article[adddate]?></td>
</tr>
<? } ?>

<?php } else {?>
<tr>
    <th>提示:未找到类似标题:</th>
</tr>
<tr>
    <td class="tablerow">你可以添加此标题!</td>
</tr>
<?php }?>

<?php 
}
?>
  <tr>
    <td align="right" class="tablerow"><a href="javascript:window.close()">[关闭窗口]</a></td>
  </tr>
</table>
</body>
</html>