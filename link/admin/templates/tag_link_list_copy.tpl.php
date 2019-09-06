<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/tag.js"></script>
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
<table cellpadding="2" cellspacing="1" border="0" class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>">管理标签</a></td>
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
   <input name="action" type="hidden" value="<?=$action?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
   <input name="forward" type="hidden" value="<?=$forward?>"> 
    <tr> 
      <td class="tablerow" width="40%"><b>新标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input type="text" name="tagname" size="20"/>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>标签说明</b><br/>例如：首页推荐链接，10条</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="50" value="<?=$tag_config['introduce']?>" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
    
    <tr> 
      <td class="tablerow" width="40%"><b>链接类型</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[linktype]" value="0" <?php if(!$tag_config['linktype']) echo 'checked="checked"';?> /> 文字链接&nbsp;&nbsp;
                            <input type="radio" name="tag_config[linktype]" value="1" <?php if($tag_config['linktype']) echo 'checked="checked"';?>> Logo链接<br>
      </td>
    </tr>

    <tr> 
      <td class="tablerow" width="40%"><b>所属分类</b></td>
      <td  class="tablerow"><input name="tag_config[typeid]" type="text" size="15"  id="typeid" value="<?=$tag_config['typeid']?>">&nbsp;
<?=type_select('selecttypeid','请选择分类',$tag_config['typeid'],'onchange="ChangeInput(this,document.myform.typeid)"')?> 【为0则调用所有】
      </td>
    </tr>
	 <tr> 
      <td class="tablerow" width="40%"><b>是否显示点击次数</b></td>
      <td  class="tablerow">
	  <input type="radio" name="tag_config[showhits]" value="1" <?php if($tag_config['showhits']) echo 'checked="checked"';?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="radio" name="tag_config[showhits]" value="0" <?php if(!$tag_config['showhits']) echo 'checked="checked"';?>> 否
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每页显示链接数</b></td>
      <td  class="tablerow"><input name="tag_config[linknum]" type="text" size="5" value="<?=$tag_config['linknum']?>" > </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每行显示链接列数</b></td>
      <td  class="tablerow">
<select name='tag_config[cols]'>
<option value='1' <?php if($tag_config['cols']==1) { ?>selected<? } ?>>1列</option>
<option value='2' <?php if($tag_config['cols']==2) { ?>selected<? } ?>>2列</option>
<option value='3' <?php if($tag_config['cols']==3) { ?>selected<? } ?>>3列</option>
<option value='4' <?php if($tag_config['cols']==4) { ?>selected<? } ?>>4列</option>
<option value='5' <?php if($tag_config['cols']==5) { ?>selected<? } ?>>5列</option>
<option value='6' <?php if($tag_config['cols']==6) { ?>selected<? } ?>>6列</option>
<option value='7' <?php if($tag_config['cols']==7) { ?>selected<? } ?>>7列</option>
<option value='8' <?php if($tag_config['cols']==8) { ?>selected<? } ?>>8列</option>
<option value='9' <?php if($tag_config['cols']==9) { ?>selected<? } ?>>9列</option>
<option value='10' <?php if($tag_config['cols']==10) { ?>selected<? } ?>>10列</option>
<option value='1' <?php if($tag_config['cols']==11) { ?>selected<? } ?>>11列</option>
<option value='2' <?php if($tag_config['cols']==12) { ?>selected<? } ?>>12列</option>
<option value='3' <?php if($tag_config['cols']==13) { ?>selected<? } ?>>13列</option>
<option value='4' <?php if($tag_config['cols']==14) { ?>selected<? } ?>>14列</option>
<option value='5' <?php if($tag_config['cols']==15) { ?>selected<? } ?>>15列</option>
<option value='6' <?php if($tag_config['cols']==16) { ?>selected<? } ?>>16列</option>
<option value='7' <?php if($tag_config['cols']==17) { ?>selected<? } ?>>17列</option>
<option value='8' <?php if($tag_config['cols']==18) { ?>selected<? } ?>>18列</option>
<option value='9' <?php if($tag_config['cols']==19) { ?>selected<? } ?>>19列</option>
<option value='10' <?php if($tag_config['cols']==20) { ?>selected<? } ?>>20列</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod,'tag_link_list','tag_config[templateid]',$tag_config['templateid'],'id=templateid')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=link&referer=<?=urlencode($PHP_URL)?>'"> 【注:只能修改非默认模板】
      </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="dosubmit" value=" 保存 " onclick="$('action').value='copy';">   &nbsp; 
         <input type="submit" name="dopreview" value=" 预览 " onclick="$('action').value='preview';">  &nbsp; 
         <input type="reset" name="reset" value=" 重置 "> </td>
    </tr>
  </form>
</table>
</body>
</html>