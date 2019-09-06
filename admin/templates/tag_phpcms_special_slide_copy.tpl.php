<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script type="text/javascript">
function doCheck(){
	if($F('tagname')==''){
		alert('标签名称不能为空');
		$('tagname').focus();
		return false;
	}
	return true;
}
</script>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>">管理标签</a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>复制<?=$functions[$function]?>标签 {tag_<?=$tagname?>} </th>
  </tr>
  <form name="myform" method="get" action="?" onsubmit="return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="channelid" type="hidden" value="<?=$channelid?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
   <input type="hidden" name="tag_config[func]" value="<?=$function?>">
   <input name="action" type="hidden" value="<?=$action?>">
    <tr> 
      <td class="tablerow" width="40%"><b>新标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input type="text" name="tagname" size="20"/>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>标签说明</b><br/>例如：首页最新推荐产品，10篇</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="60" value="<?=$tag_config['introduce']?>" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>所属频道</b></td>
      <td  class="tablerow"><input name="tag_config[keyid]" id="setchannelid" type="text" size="15" value="<?=$tag_config['keyid']?>"> 
<select name='selectchannelid' onchange="javascript:myform.setchannelid.value=this.value">
<option>请选择频道</option>
<option value='$channelid'>$channelid</option>
<?php 
foreach($CHANNEL as $id=>$channel)
{
	if($channel['islink'] == 0)
	{
       $selected = $id == $channelid ? "selected" : "";
?>
<option value='<?=$id?>' <?=$selected?>><?=$channel['channelname']?></option>
<?php 
	}
}
?>
</select>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>显示专题数</b></td>
      <td  class="tablerow"><input name="tag_config[specialnum]" type="text" size="10" value="<?=$tag_config['specialnum']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>专题名称最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[specialnamelen]" type="text" size="10" value="<?=$tag_config['specialnamelen']?>"> 一个汉字=两个英文字符，若为0，则不显示专题名称</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否为推荐专题</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[iselite]" value="1" <? if($tag_config['iselite']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[iselite]" value="0" <? if(!$tag_config['iselite']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>多少天以内的专题</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="5" value="<?=$tag_config['datenum']?>" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name='selectdatenum' onclick="javascript:myform.datenum.value=this.value">
<option value='0' <? if($tag_config['datenum']==0) { ?>selected<? } ?>>不限天数</option>
<option value='3' <? if($tag_config['datenum']==3) { ?>selected<? } ?>>3天以内</option>
<option value='7' <? if($tag_config['datenum']==7) { ?>selected<? } ?>>一周以内</option>
<option value='14' <? if($tag_config['datenum']==14) { ?>selected<? } ?>>两周以内</option>
<option value='30' <? if($tag_config['datenum']==30) { ?>selected<? } ?>>一个月内</option>
<option value='60' <? if($tag_config['datenum']==60) { ?>selected<? } ?>>两个月内</option>
<option value='90' <? if($tag_config['datenum']==90) { ?>selected<? } ?>>三个月内</option>
<option value='180' <? if($tag_config['datenum']==180) { ?>selected<? } ?>>半年以内</option>
<option value='365' <? if($tag_config['datenum']==365) { ?>selected<? } ?>>一年以内</option>
</select>
您可以从下拉框中选择
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片宽度</b></td>
      <td  class="tablerow"><input name="tag_config[imgwidth]" type="text" size="10" value="<?=$tag_config['imgwidth']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片高度</b></td>
      <td  class="tablerow"><input name="tag_config[imgheight]" type="text" size="10" value="<?=$tag_config['imgheight']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片播放间隔时间</b></td>
      <td  class="tablerow">
<select name='tag_config[timeout]'>
<option value='1000' <? if($tag_config['timeout']==1000) { ?>selected<? } ?>>1秒</option>
<option value='2000' <? if($tag_config['timeout']==2000) { ?>selected<? } ?>>2秒</option>
<option value='3000' <? if($tag_config['timeout']==3000) { ?>selected<? } ?>>3秒</option>
<option value='4000' <? if($tag_config['timeout']==4000) { ?>selected<? } ?>>4秒</option>
<option value='5000' <? if($tag_config['timeout']==5000) { ?>selected<? } ?>>5秒</option>
<option value='6000' <? if($tag_config['timeout']==6000) { ?>selected<? } ?>>6秒</option>
<option value='7000' <? if($tag_config['timeout']==7000) { ?>selected<? } ?>>7秒</option>
<option value='8000' <? if($tag_config['timeout']==8000) { ?>selected<? } ?>>8秒</option>
<option value='9000' <? if($tag_config['timeout']==9000) { ?>selected<? } ?>>9秒</option>
<option value='10000' <? if($tag_config['timeout']==10000) { ?>selected<? } ?>>10秒</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>幻灯片显示效果</b></td>
      <td  class="tablerow">
<select name='tag_config[effectid]'>
<option value='-1' <? if($tag_config['effectid']==-1) { ?>selected<? } ?>>随机综合效果</option>
<option value='0' <? if($tag_config['effectid']==1) { ?>selected<? } ?>>矩形缩小</option>
<option value='1' <? if($tag_config['effectid']==1) { ?>selected<? } ?>>矩形扩大</option>
<option value='2' <? if($tag_config['effectid']==2) { ?>selected<? } ?>>圆形缩小</option>
<option value='3' <? if($tag_config['effectid']==3) { ?>selected<? } ?>>圆形扩大</option>
<option value='4' <? if($tag_config['effectid']==4) { ?>selected<? } ?>>向上擦除</option>
<option value='5' <? if($tag_config['effectid']==5) { ?>selected<? } ?>>向下擦除</option>
<option value='6' <? if($tag_config['effectid']==6) { ?>selected<? } ?>>向右擦除</option>
<option value='7' <? if($tag_config['effectid']==7) { ?>selected<? } ?>>向左擦除</option>
<option value='8' <? if($tag_config['effectid']==8) { ?>selected<? } ?>>垂直百页</option>
<option value='9' <? if($tag_config['effectid']==9) { ?>selected<? } ?>>水平百页</option>
<option value='10' <? if($tag_config['effectid']==10) { ?>selected<? } ?>>棋盘状通过</option>
<option value='11' <? if($tag_config['effectid']==11) { ?>selected<? } ?>>棋盘状向下</option>
<option value='12' <? if($tag_config['effectid']==12) { ?>selected<? } ?>>随机融化</option>
<option value='13' <? if($tag_config['effectid']==13) { ?>selected<? } ?>>垂直向内分开</option>
<option value='14' <? if($tag_config['effectid']==14) { ?>selected<? } ?>>垂直向外分开</option>
<option value='15' <? if($tag_config['effectid']==15) { ?>selected<? } ?>>水平向内分开</option>
<option value='16' <? if($tag_config['effectid']==16) { ?>selected<? } ?>>水平向外分开</option>
<option value='17' <? if($tag_config['effectid']==17) { ?>selected<? } ?>>左下条状</option>
<option value='18' <? if($tag_config['effectid']==18) { ?>selected<? } ?>>左上条状</option>
<option value='19' <? if($tag_config['effectid']==19) { ?>selected<? } ?>>右下条状</option>
<option value='20' <? if($tag_config['effectid']==20) { ?>selected<? } ?>>右上条状</option>
<option value='21' <? if($tag_config['effectid']==21) { ?>selected<? } ?>>随机的水平栅栏</option>
<option value='22' <? if($tag_config['effectid']==22) { ?>selected<? } ?>>随机的垂直栅栏</option>
<option value='23' <? if($tag_config['effectid']==23) { ?>selected<? } ?>>随机任意的上述一种效果</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod, 'tag_special_slide', 'tag_config[templateid]', $tag_config['templateid'] ,' id="templateid" ')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选中模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=phpcms&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr>
      <td class="tablerow"></td>
      <td class="tablerow"><input type="submit" name="dosubmit" value=" 保存 "  onclick="$('action').value='copy';">
&nbsp;
<input name="submit" type="submit" onclick="$('action').value='preview';" value=" 预览 ">
&nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>