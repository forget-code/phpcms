<table cellpadding="2" cellspacing="1">
	<tr> 
      <td>文本域行数</td>
      <td><input type="text" name="setting[rows]" value="<?=$rows?>" size="10"></td>
    </tr>
	<tr> 
      <td>文本域列数</td>
      <td><input type="text" name="setting[cols]" value="<?=$cols?>" size="10"></td>
    </tr>
	<tr> 
      <td>默认值</td>
      <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" style="height:60px;width:250px;"><?=$defaultvalue?></textarea></td>
    </tr>
	<tr> 
      <td>是否启用关联链接：</td>
      <td><input type="radio" name="setting[enablekeylink]" value="1" <?=($enablekeylink == 1 ? 'checked' : '')?> /> 是 <input type="radio" name="setting[enablekeylink]" value="0" <?=($enablekeylink == 0 ? 'checked' : '')?> /> 否  <input type="text" name="setting[replacenum]" value="<?=$replacenum?>" size="4"> 替换次数 （留空则为替换全部）</td>
    </tr>
	<tr> 
      <td>是否启用剩余字符提示：</td>
      <td><input type="radio" name="setting[checkcharacter]" value="1" <?=($checkcharacter ? 'checked' : '')?> /> 是 <input type="radio" name="setting[checkcharacter]" value="0" <?=($checkcharacter ? '' : 'checked')?> /> 否 <font color='#f00;'>启用此项，必填字符长度最大值</font></td>
    </tr>
</table>