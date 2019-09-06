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
    <th colspan=2>修改<?=$functions[$function]?>标签</th>
  </tr>
  <form name="myform" method="get" action="?" onsubmit="javascript:return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>" id="action">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input name="tagname" id="tagname" type="text" size="20" value="<?=$tagname?>" readonly> <input type="button" value="(标签名称不可再编辑) " > <br/>
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
      <td class="tablerow" width="40%"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="$page" <? if($tag_config['page']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" <? if(!$tag_config['page']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每页专题数</b></td>
      <td  class="tablerow"><input name="tag_config[specialnum]" type="text" size="10" value="<?=$tag_config['specialnum']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>专题名称最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[specialnamelen]" type="text" size="10" value="<?=$tag_config['specialnamelen']?>"> 一个汉字=两个英文字符，若为0，则不显示专题名称</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>专题介绍最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[descriptionlen]" type="text" size="10" value="<?=$tag_config['descriptionlen']?>"> 一个汉字=两个英文字符，若为0，则不显示专题简介</td>
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
      <td class="tablerow" width="40%"><b>显示方式</b></td>
      <td  class="tablerow">
<input type="radio" name="tag_config[showtype]" value="1" <? if($tag_config['showtype']==1) { ?>checked<? } ?>>图片+专题名称+专题简介：上下排列<br>
<input type="radio" name="tag_config[showtype]" value="2" <? if($tag_config['showtype']==2) { ?>checked<? } ?>>（图片+专题名称：上下排列）+专题简介：左右排列<br>
<input type="radio" name="tag_config[showtype]" value="3" <? if($tag_config['showtype']==3) { ?>checked<? } ?>>图片+（专题名称+专题简介：上下排列）：左右排列<br>
<input type="radio" name="tag_config[showtype]" value="4" <? if($tag_config['showtype']==4) { ?>checked<? } ?>>专题名称+（图片+专题简介：左右排列）：上下排列<br>
<input type="radio" name="tag_config[showtype]" value="5" <? if($tag_config['showtype']==5) { ?>checked<? } ?>>专题名称+（图片+专题简介：混合排列）：上下排列<br>
<input type="radio" name="tag_config[showtype]" value="6" <? if($tag_config['showtype']==6) { ?>checked<? } ?>>专题名称+专题简介：上下排列
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片宽度</b></td>
      <td  class="tablerow"><input name="tag_config[imgwidth]" type="text" size="5" value="<?=$tag_config['imgwidth']?>"> px</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片高度</b></td>
      <td  class="tablerow"><input name="tag_config[imgheight]" type="text" size="5" value="<?=$tag_config['imgheight']?>"> px</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>显示专题列数</b></td>
      <td  class="tablerow">
<select name="tag_config[cols]">
<option value='1' <? if($tag_config['cols']==1) { ?>selected<? } ?>>1列</option>
<option value='2' <? if($tag_config['cols']==2) { ?>selected<? } ?>>2列</option>
<option value='3' <? if($tag_config['cols']==3) { ?>selected<? } ?>>3列</option>
<option value='4' <? if($tag_config['cols']==4) { ?>selected<? } ?>>4列</option>
<option value='5' <? if($tag_config['cols']==5) { ?>selected<? } ?>>5列</option>
<option value='6' <? if($tag_config['cols']==6) { ?>selected<? } ?>>6列</option>
<option value='7' <? if($tag_config['cols']==7) { ?>selected<? } ?>>7列</option>
<option value='8' <? if($tag_config['cols']==8) { ?>selected<? } ?>>8列</option>
<option value='9' <? if($tag_config['cols']==9) { ?>selected<? } ?>>9列</option>
<option value='10' <? if($tag_config['cols']==10) { ?>selected<? } ?>>10列</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod, 'tag_special_list', 'tag_config[templateid]', $tag_config['templateid'] ,' id="templateid" ')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选中模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=phpcms&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr>
      <td class="tablerow"></td>
      <td class="tablerow"><input type="submit" name="dosubmit" value=" 保存 "  onclick="$('action').value='edit';">
&nbsp;
<input name="submit" type="submit" onclick="$('action').value='preview';" value=" 预览 ">
&nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>