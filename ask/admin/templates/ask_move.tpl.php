<?php include admin_tpl('header');?>
<?=$menu?>
<table width="100%" cellpadding="0" cellspacing="1">
<tr>
<td height="10"> </td>
</tr>
</table>
<form method="post" name="myform" action="?mod=ask&file=ask&action=move&dosubmit=1">
<table cellpadding="2" cellspacing="1" class="table_list">
  <tr>
    <th colspan=3>批量移动问题</th>
  </tr>
  <tr>
  	<td  valign="top"  width="45%">
    	<input type="radio" name="fromtype" value="0" <? if($ids){?>checked<?}?> id="fromtype_1" onclick="if(this.checked){$('#frombox_1').show();$('#frombox_2').hide();}">从指定ID的问题：
        <input type="radio" name="fromtype" value="1" <? if(!$ids){?>checked<?}?> id="fromtype_2" onclick="if(this.checked){$('#frombox_1').hide();$('#frombox_2').show();}">从指定栏目的问题
        <div id="frombox_1" style="display:<? if(!$ids){?>none<?}?>;">
        <textarea name="ids" style="height:300px;width:350px;"><?=$ids?></textarea>
        <br/>
        <font color="red">Tips:</font>多个问题ID请用','隔开，<font color="red">注意不要换行</font>
        </div>
        <div id="frombox_2" style="display:<? if($ids){?>none<?}?>;">
        <select name="batchcatid[]" size="2" multiple style="height:300px;width:350px;">
    	<option style="background:#F1F3F5;color:green;">源 栏 目</option>
    	<?=$category_select?>
    	</select>
        <br/>
        <font color="red">Tips:</font>源栏目可按Ctrl键多选
        </div>
    </td>
    <td align="center"  width="10%"> &gt;&gt;</td>
    <td  valign="top"  width="45%">
    <div id="tobox_1" style="display:'';">
    <select name="targetcatid" size="2" style="height:340px;width:350px;">
    <option style="background:#F1F3F5;color:blue;">目 标 栏 目</option>
	<?=$category_select?>
    </select>
    <br/>
    <font color="red">Tips:</font>目标栏目只能单选。
    </div>
    </td>
    </tr>
</tbody>
<tr align="center">
<td>&nbsp;</td>
<td><input type="submit" value=" 移 动 "></td>
<td>&nbsp;</td>
</tr>
</form>
</table>
</body>
</html>