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
      <td>是否允许Html</td>
      <td><input type="radio" name="setting[enablehtml]" value="1" <?=($enablehtml ? 'checked' : '')?> /> 是 <input type="radio" name="setting[enablehtml]" value="0"  <?=($enablehtml ? '' : 'checked')?> /> 否</td>
    </tr>
	<tr> 
      <td>是否启用关联链接</td>
      <td><input type="radio" name="setting[enablekeylink]" value="1" <?=($enablekeylink ? 'checked' : '')?> /> 是 <input type="radio" name="setting[enablekeylink]" value="0" <?=($enablekeylink ? '' : 'checked')?> /> 否</td>
    </tr>
</table>