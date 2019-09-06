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
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>&keyid=<?=$keyid?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>&keyid=<?=$keyid?>">管理标签</a></td>
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
   <input name="keyid" type="hidden" value="<?=$keyid?>">
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
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="60" value="<?=$tag_config['introduce']?>" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
    
    <tr> 
      <td class="tablerow" width="40%"><b>是否分页</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="1" <?php if($tag_config['page']) echo 'checked="checked"';?>> 是&nbsp;&nbsp;
                            <input type="radio" name="tag_config[page]" value="0" <?php if(!$tag_config['page']) echo 'checked="checked"';?>> 否<br>
      </td>
    </tr>

    <tr> 
      <td class="tablerow" width="40%"><b>所属模块或频道id</b><br>某些情况下可使用变量<a href="###" onclick="$('keytype').value='$channelid'"><font color="red">$channelid</font></a>作为参数</td></td>
      <td  class="tablerow"><input name="tag_config[keyid]" type="text" size="35" value="<?=$tag_config['keyid']?>" id="keytype"> <?=keyid_select('qw','','','onchange="$(\'keytype\').value=this.value"')?> 【 0 则调用所有】</td>
	</tr>
	
	<tr> 
      <td class="tablerow" width="40%"><b>每页显示投票数</b></td>
      <td  class="tablerow"><input name="tag_config[votenum]" type="text" size="5" value="<?=$tag_config['votenum']?>"> </td>
    </tr>
	 <tr> 
      <td class="tablerow" width="40%"><b>投票标题长度</b></td>
      <td  class="tablerow"><input name="tag_config[subjectlen]" type="text" size="5" value="<?=$tag_config['subjectlen']?>"> </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每行显示投票列数</b></td>
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
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod,'tag_vote_list','tag_config[templateid]',$tag_config['templateid'],'id=templateid')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=vote&referer=<?=urlencode($PHP_URL)?>'"> 【注:只能修改非默认模板】
      </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="dosubmit" value=" 保存 " onclick="$('action').value='copy';">   &nbsp; 
         <input type="submit" name="dopreview" value=" 预览 " onclick="$('action').value='preview';">  
          <input type="reset" name="reset" value=" 重置 "> </td>
    </tr>
  </form>
</table>
</body>
</html>