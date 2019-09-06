<?php include admintpl('header');?>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">图片首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=move&channelid=<?=$channelid?>">批量移动图片</a> &gt;&gt;</td>
	</td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=3>批量移动图片</th>
  </tr>
<form method="post" name="myform" action="?mod=picture&file=picture&action=move&channelid=<?=$channelid?>&dosubmit=1">
<input type="hidden" name="referer" value="<?=$referer?>">


<tr>
<td class="tablerow" valign="top"  width="45%">
<input type="radio" name="fromtype" value="1" <? if($pictureids){?>checked<?}?> id="fromtype_1" onclick="if(this.checked){$('frombox_1').style.display='';$('frombox_2').style.display='none';}">从指定ID的图片：
<input type="radio" name="fromtype" value="2" <? if(!$pictureids){?>checked<?}?> id="fromtype_2" onclick="if(this.checked){$('frombox_1').style.display='none';$('frombox_2').style.display='';}">从指定栏目的图片
<div id="frombox_1" style="display:'';">
<textarea name="pictureids" style="height:300px;width:350px;"><?=$pictureids?></textarea>
<br/>
<font color="red">Tips:</font>多个图片ID请用','隔开，<font color="red">注意不要换行</font>
</div>
<div id="frombox_2" style="display:none;">
<select name="batchcatid[]" size="2" multiple style="height:300px;width:350px;">
<option style="background:#F1F3F5;color:green;">源 栏 目</option>
<?=$category_select?>
<br/>
<font color="red">Tips:</font>源栏目可按Ctrl键多选
</div>


</td>
<td align="center" class="tablerow" width="10%"> &gt;&gt;</td>
<td class="tablerow" valign="top"  width="45%">
<input type="radio" name="totype" value="1" checked  id="totype_1" onclick="if(this.checked){$('tobox_1').style.display='';$('tobox_2').style.display='none';}">移动到本频道
<input type="radio" name="totype" value="2" id="totype_2" onclick="if(this.checked){$('tobox_1').style.display='none';$('tobox_2').style.display='';}">移动到其他频道
<div id="tobox_1" style="display:'';">
<select name="targetcatid" size="2" style="height:300px;width:350px;">
<option style="background:#F1F3F5;color:blue;">目 标 栏 目</option>
<?=$category_select?>
<br/>
<font color="red">Tips:</font>目标栏目只能单选。
</div>

<div id="tobox_2" style="display:'none';">
<script type="text/javascript">
function getcategoris(channelid)
{
    var url ="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>";
    var pars = "request_channelid="+channelid;
	var cAjax = new Ajax.Request(url, {method: 'get', parameters: pars, onComplete: intext});
}

function intext(Request)
{
	var text = Request.responseText;
	$('catselect').innerHTML = text;
}
</script>
	<table width="100%" cellpadding="3" cellspacing="2">
	<tr>
	<td>
	&nbsp;<select name='tochannelid' onchange="if(this.value){getcategoris(this.value);}">
	<option>目标频道</option>
	<?php 
	foreach($CHANNEL as $id=>$channel)
	{
		if($channel['module'] != $mod || $channel['islink'] || $id == $channelid) continue;
	?>
			<option value='<?=$id?>'><?=$channel['channelname']?></option>
	<?php 
	}
	?>
	</select>
	<span id="catselect"><select><option>目标栏目</option></select></span>
	</td>
	</tr>
	<tr>
	<td>
	<input type="radio" name="move_mode" value="1" checked onclick="if(this.checked){$('save_original_box').style.display='none';}"> 在目标频道添加图片,链接至本频道原文</td>
	</tr>
	<tr>
	<td>
	<input type="radio" name="move_mode" value="2" onclick="if(this.checked){$('save_original_box').style.display='';}"> 完全移动至目标频道
	<span id="save_original_box" style="display:none"><input type="checkbox" name="save_original" value="1" checked> 保留原文<br/><font color="blue">注意:</font><font color="red">如果选择完全移动，需要在移动成功后在目标频道<b>更新图片地址</b>后重新<b>生成图片</b></font></span>
	</td>
	</tr>
	</table>
</div>
</td>
</tr>
</tbody>
<tr align="center">
<td class="tablerow"></td>
<td class="tablerow"><input type="submit" value=" 移 动 "></td>
<td class="tablerow"></td>
</tr>
</form>
</table>
<script type="text/javascript">
function allPlay()
{
	if ($('fromtype_1').checked)
	{
		$('frombox_1').style.display='';
		$('frombox_2').style.display='none';
	}
	else if ($('fromtype_2').checked)
	{
		$('frombox_1').style.display='none';
		$('frombox_2').style.display='';
	}
}
window.onload = allPlay;
</script>
</body>
</html>