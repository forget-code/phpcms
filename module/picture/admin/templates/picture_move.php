<?php include admintpl('header');?>
<?=$menu?>
<script language = 'JavaScript'>
function doplay(){
  if(document.myform.tospecial.checked==true){
	 document.myform.movetype[0].checked=true;
     cate.style.display='none';
	 special.style.display='';
  }else{
    cate.style.display='';
	special.style.display='none';
  }
}
</script>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=3>批量移动图片</th>
  </tr>
<form method='post' name='myform' action='?mod=picture&file=picture&action=move&channelid=<?=$channelid?>&referer=<?=$referer?>'>
<tr>
<td class="tablerow">
<input type='radio' name='movetype' value='1' <? if($pictureid){?>checked<?}?>>指定图片ID：<input type='text' name='pictureid' value='<?=$pictureid?>' size='40' onclick="this.form.movetype[0].checked=true"><br/>
<input type='radio' name='movetype' value='2' <? if(!$pictureid){?>checked<?}?>>指定栏目的图片&nbsp;&nbsp;<font color='red'>源栏目可按Ctrl键多选</font><br/>
<select name='batchcatid[]' size='2' multiple style='height:360px;width:350px;' onclick="this.form.movetype[1].checked=true;">
<?=$cat_option?>
</select>
</td>
<td align=center class="tablerow">移动到>></td>
<td class="tablerow">
<?=$special_select?><br/>
&nbsp;&nbsp;<font color='red'>目标栏目只能单选</font>
<select name='targetcatid' size='2' style='height:360px;width:350px;'>
<?=$cat_option?>
</select>
</td>
</tr>
</tbody>
<tr align=center>
<td class="tablerow"></td>
<td class="tablerow"><input name='submit' type='submit'  id='submit' value=' 移动 '></td>
<td class="tablerow"></td>
</tr>
</form>
</table>
</body>
</html>