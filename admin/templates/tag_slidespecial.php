<?php include admintpl('header');?>
<?=$menu?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/tag.js"></script>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center><?=$_CHA['channelname']?>频道 - <?=$funcs[$func]?>管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=set&func=<?=$func?>&channelid=<?=$channelid?>">添加<?=$funcs[$func]?></a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&func=<?=$func?>&channelid=<?=$channelid?>">管理<?=$funcs[$func]?></a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2><?=$funcs[$func]?>设置</th>
  </tr>
  <form name="myform" method="get" action="?" onsubmit="javascript:return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="channelid" type="hidden" value="<?=$channelid?>">
   <input name="action" type="hidden" value="save">
   <input name="tagid" type="hidden" value="<?=$tagid?>">
   <input name="func" type="hidden" value="<?=$func?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
    <tr> 
      <td class="tablerow" width="40%"><b>配置名称</b><font color="red">*</font><br/>只能由字母、数字和下划线组成，例如：new_article</td>
      <td  class="tablerow">
	  <input name="tag" id="tag" type="text" size="20" value="<?=$my?><?=$tag?>" <?php if($tagid){?>disabled<?php } ?>> <input type="button" name="submit" value=" 检查是否已经存在 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=<?=$file?>&action=tag_exists&tag='+myform.tag.value,'tag_exists','450','160')"> <br/>
	  为避免与系统内置标签冲突，自定义标签配置名前面会自动加上 <font color="red">my_</font> 为前缀
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>配置说明</b><font color="red">*</font><br/>对标签进行简单描述（可用中文），例如：最新文章</td>
      <td  class="tablerow"><input name="tagname" id="tagname" type="text" size="60" value="<?=$tagname?>"></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>所属频道</b></td>
      <td  class="tablerow"><input name="newdata[channelid]" id="setchannelid" type="text" size="15" value="<?=$data[channelid]?>"> 
<select name='selectchannelid' onchange="javascript:myform.setchannelid.value=this.value">
<option>请选择频道</option>
<option value='$channelid'>$channelid</option>
<?php 
foreach($_CHANNEL as $id=>$channel)
{
	if($channel[channeltype])
	{
       $selected = $id == $channelid ? "selected" : "";
?>
<option value='<?=$id?>' <?=$selected?>><?=$channel[channelname]?></option>
<?php 
	}
}
?>
</select>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"  width="40%"><b>调用专题ID</b><br>多个ID之前用半角逗号隔开，0表示不限栏目</td>
      <td  class="tablerow">
<input name="newdata[specialid]" type="text" size="20" value="<?=$data[specialid]?>" id="specialid">
<br>
<?=$special_select?>
选择时专题ID会自动加入到表单中
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>显示专题数</b></td>
      <td  class="tablerow"><input name="newdata[specialnum]" type="text" size="10" value="<?=$data[specialnum]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>专题名称最大字符数</b></td>
      <td  class="tablerow"><input name="newdata[specialnamelen]" type="text" size="10" value="<?=$data[specialnamelen]?>"> 一个汉字=两个英文字符，若为0，则不显示专题名称</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否为推荐专题</b></td>
      <td  class="tablerow"><input type="radio" name="newdata[iselite]" value="1" <? if($data[iselite]) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="newdata[iselite]" value="0" <? if(!$data[iselite]) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>多少天以内的专题</b></td>
      <td  class="tablerow"><input name="newdata[datenum]" type="text" size="5" value="<?=$data[datenum]?>" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name='selectdatenum' onclick="javascript:myform.datenum.value=this.value">
<option value='0' <? if($data[datenum]==0) { ?>selected<? } ?>>不限天数</option>
<option value='3' <? if($data[datenum]==3) { ?>selected<? } ?>>3天以内</option>
<option value='7' <? if($data[datenum]==7) { ?>selected<? } ?>>一周以内</option>
<option value='14' <? if($data[datenum]==14) { ?>selected<? } ?>>两周以内</option>
<option value='30' <? if($data[datenum]==30) { ?>selected<? } ?>>一个月内</option>
<option value='60' <? if($data[datenum]==60) { ?>selected<? } ?>>两个月内</option>
<option value='90' <? if($data[datenum]==90) { ?>selected<? } ?>>三个月内</option>
<option value='180' <? if($data[datenum]==180) { ?>selected<? } ?>>半年以内</option>
<option value='365' <? if($data[datenum]==365) { ?>selected<? } ?>>一年以内</option>
</select>
您可以从下拉框中选择
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片宽度</b></td>
      <td  class="tablerow"><input name="newdata[imgwidth]" type="text" size="10" value="<?=$data[imgwidth]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片高度</b></td>
      <td  class="tablerow"><input name="newdata[imgheight]" type="text" size="10" value="<?=$data[imgheight]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片播放间隔时间</b></td>
      <td  class="tablerow">
<select name='newdata[timeout]'>
<option value='1000' <? if($data[timeout]==1000) { ?>selected<? } ?>>1秒</option>
<option value='2000' <? if($data[timeout]==2000) { ?>selected<? } ?>>2秒</option>
<option value='3000' <? if($data[timeout]==3000) { ?>selected<? } ?>>3秒</option>
<option value='4000' <? if($data[timeout]==4000) { ?>selected<? } ?>>4秒</option>
<option value='5000' <? if($data[timeout]==5000) { ?>selected<? } ?>>5秒</option>
<option value='6000' <? if($data[timeout]==6000) { ?>selected<? } ?>>6秒</option>
<option value='7000' <? if($data[timeout]==7000) { ?>selected<? } ?>>7秒</option>
<option value='8000' <? if($data[timeout]==8000) { ?>selected<? } ?>>8秒</option>
<option value='9000' <? if($data[timeout]==9000) { ?>selected<? } ?>>9秒</option>
<option value='10000' <? if($data[timeout]==10000) { ?>selected<? } ?>>10秒</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>幻灯片显示效果</b></td>
      <td  class="tablerow">
<select name='newdata[effectid]'>
<option value='-1' <? if($data[effectid]==-1) { ?>selected<? } ?>>随机综合效果</option>
<option value='0' <? if($data[effectid]==1) { ?>selected<? } ?>>矩形缩小</option>
<option value='1' <? if($data[effectid]==1) { ?>selected<? } ?>>矩形扩大</option>
<option value='2' <? if($data[effectid]==2) { ?>selected<? } ?>>圆形缩小</option>
<option value='3' <? if($data[effectid]==3) { ?>selected<? } ?>>圆形扩大</option>
<option value='4' <? if($data[effectid]==4) { ?>selected<? } ?>>向上擦除</option>
<option value='5' <? if($data[effectid]==5) { ?>selected<? } ?>>向下擦除</option>
<option value='6' <? if($data[effectid]==6) { ?>selected<? } ?>>向右擦除</option>
<option value='7' <? if($data[effectid]==7) { ?>selected<? } ?>>向左擦除</option>
<option value='8' <? if($data[effectid]==8) { ?>selected<? } ?>>垂直百页</option>
<option value='9' <? if($data[effectid]==9) { ?>selected<? } ?>>水平百页</option>
<option value='10' <? if($data[effectid]==10) { ?>selected<? } ?>>棋盘状通过</option>
<option value='11' <? if($data[effectid]==11) { ?>selected<? } ?>>棋盘状向下</option>
<option value='12' <? if($data[effectid]==12) { ?>selected<? } ?>>随机融化</option>
<option value='13' <? if($data[effectid]==13) { ?>selected<? } ?>>垂直向内分开</option>
<option value='14' <? if($data[effectid]==14) { ?>selected<? } ?>>垂直向外分开</option>
<option value='15' <? if($data[effectid]==15) { ?>selected<? } ?>>水平向内分开</option>
<option value='16' <? if($data[effectid]==16) { ?>selected<? } ?>>水平向外分开</option>
<option value='17' <? if($data[effectid]==17) { ?>selected<? } ?>>左下条状</option>
<option value='18' <? if($data[effectid]==18) { ?>selected<? } ?>>左上条状</option>
<option value='19' <? if($data[effectid]==19) { ?>selected<? } ?>>右下条状</option>
<option value='20' <? if($data[effectid]==20) { ?>selected<? } ?>>右上条状</option>
<option value='21' <? if($data[effectid]==21) { ?>selected<? } ?>>随机的水平栅栏</option>
<option value='22' <? if($data[effectid]==22) { ?>selected<? } ?>>随机的垂直栅栏</option>
<option value='23' <? if($data[effectid]==23) { ?>selected<? } ?>>随机任意的上述一种效果</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow"><?=$showtpl?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选中模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=phpcms&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="Submit" value=" 保存 " onclick="javascript:doSave();">   &nbsp; 
         <input type="submit" name="dopreview" value=" 预览 " onclick="return doPreview();">  &nbsp; 
         <input type="reset" name="reset" value=" 重置 "> </td>
    </tr>
  </form>
</table>
</body>
</html>