<table cellpadding="2" cellspacing="1" border="0" align="center" width="100%" style="background:White;border:#F1F3F5 1px solid;">
<tr>
<td  width='20%' class='tablerow' colspan='2'><strong><font color="Blue">属性列表</font></strong></td>
</tr>
<?php
foreach ($attlists as $attlist)
{
$att_ids[] = $attlist['att_id'];
?>
<tr>
<td  width='20%' class='tablerow'><strong><?=$attlist['att_name']?></strong></td>
<td  width='80%' class='tablerow'><?=$attlist['attinput']?></td>
</tr>
<?php
}
?>
</table>
<input type="hidden" value="<?php echo new_htmlspecialchars(serialize($att_ids));?>" name="pdt_att_ids">