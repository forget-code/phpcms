<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
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
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>&channelid=<?=$channelid?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>&channelid=<?=$channelid?>">管理标签</a></td>
  </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
<tr>
<td></td>
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
      <td class="tablerow" width="40%"><b>标签说明</b><br/>例如：首页最新推荐图片，10篇</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="50" value="<?=$tag_config['introduce']?>" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan="2" align="center"><b>标签参数设置</b></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>所属频道</b> 如无特殊需要，请保持默认</td>
      <td  class="tablerow"><input name="tag_config[channelid]" id="setchannelid" type="text" size="15" value="<?=$tag_config['channelid']?>"> 
<select name='selectchannelid' onchange="$('setchannelid').value=this.value">
<option>请选择频道</option>
<option value='$channelid'>$channelid</option>
<?php 
foreach($CHANNEL as $id=>$channel)
{
	if($channel['islink'] || $channel['module'] != $mod) continue;
    $selected = $id == $channelid ? "selected" : "";
?>
<option value='<?=$id?>' <?=$selected?>><?=$channel['channelname']?></option>
<?php 
}
?>
</select>
	  </td>
    </tr>

	     <tr> 
      <td class="tablerow"><b>图片ID</b> 如无特殊需要，请保持默认</td>
      <td  class="tablerow"><input name="tag_config[pictureid]" type="text" size="30" value="<?=$tag_config['pictureid']?>"></td>
    </tr> 

     <tr> 
      <td class="tablerow"><b>关键字</b> 如无特殊需要，请保持默认</td>
      <td  class="tablerow"><input name="tag_config[keywords]" type="text" size="30"  value="<?=$tag_config['keywords']?>"></td>
    </tr>  
    <tr> 
      <td class="tablerow"><b>调用图片数</b></td>
      <td  class="tablerow"><input name="tag_config[picturenum]" type="text" size="10"  value="<?=$tag_config['picturenum']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>图片标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[titlelen]" type="text" size="10"  value="<?=$tag_config['titlelen']?>"> 一个汉字为2个字符</td>
    </tr>
   
    <tr> 
      <td class="tablerow"><b>时间显示格式</b></td>
      <td  class="tablerow">
<select name='tag_config[datetype]'>
<option value="0" <? if($tag_config['datetype']==0) { ?>selected<? } ?>>不显示时间</option>
<option value="1" <? if($tag_config['datetype']==1) { ?>selected<? } ?>>格式：<?=date('Y-m-d',$PHP_TIME)?></option>
<option value="2" <? if($tag_config['datetype']==2) { ?>selected<? } ?>>格式：<?=date('m-d',$PHP_TIME)?></option>
<option value="3" <? if($tag_config['datetype']==3) { ?>selected<? } ?>>格式：<?=date('Y/m/d',$PHP_TIME)?></option>
<option value="4" <? if($tag_config['datetype']==4) { ?>selected<? } ?>>格式：<?=date('Y.m.d',$PHP_TIME)?></option>
<option value="5" <? if($tag_config['datetype']==5) { ?>selected<? } ?>>格式：<?=date("Y-m-d H:i:s",$PHP_TIME)?></option>
<option value="6" <? if($tag_config['datetype']==6) { ?>selected<? } ?>>格式：<?=date("Y-m-d H:i",$PHP_TIME)?></option>
</select>
      </td>
    </tr>
  

    <tr> 
      <td class="tablerow"><b>此标签调用的模板</b></td>
      <td  class="tablerow">		<?=showtpl($mod,'tag_picture_related','tag_config[templateid]',$tag_config['templateid'],'id="templateid"')?>&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=picture&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="dosubmit" value=" 保存 " onclick="$('action').value='copy';">   &nbsp; 
         <input type="submit" value=" 预览 " onclick="$('action').value='preview';">  &nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>