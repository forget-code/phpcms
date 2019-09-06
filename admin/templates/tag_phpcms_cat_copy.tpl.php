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

function showcat(keyid,catid)
{
    var url = "<?=$PHP_SELF?>";
    var pars = "mod=phpcms&file=tag&action=category_select&catid="+catid+"&keyid="+keyid;
	var myAjax = new Ajax.Updater(
					'category_select',
					url,
					{
					method: 'get',
					parameters: pars
					}
	             ); 
}
</script>

<body onload="showcat('<?=$keyid?>', '<?=$tag_config['catid']?>')">
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
      <td class="tablerow" width="40%"><b>所属模块/频道</b></td>
      <td  class="tablerow"><input name="tag_config[keyid]" id="keyid" type="text" size="15" value="<?=$tag_config['keyid']?>" onchange="showcat(this.value, 0)"> 
<?=keyid_select('setkeyid', '请选择模块/频道', '', 'onchange="javascript:myform.keyid.value=this.value;showcat(this.value, 0);"')?>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"  width="40%"><b>调用哪个栏目的子栏目列表</b></td>
      <td  class="tablerow">
	 <input name="tag_config[catid]" id="catid" type="text" size="10" value="<?=$tag_config['catid']?>"/>
	<span id="category_select"></span>
<input name='tag_config[child]' type='checkbox' value='1' <?php if($tag_config['child']){ ?>checked <?php } ?>>是否显示子栏目的下级栏目
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>栏目显示方式</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showtype]" value="0" <?php if($tag_config['showtype'] == 0){ ?>checked <?php } ?>> 树型导航菜单样式&nbsp;&nbsp;<input name='tag_config[open]' type='checkbox' value='1' checked>是否默认展开所有栏目<br>
                            <input type="radio" name="tag_config[showtype]" value="1" <?php if($tag_config['showtype'] == 1){ ?>checked <?php } ?>> <b>子栏目一</b>：下级栏目一&nbsp;|&nbsp;下级栏目二<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>子栏目二</b>：下级栏目一&nbsp;|&nbsp;下级栏目二<br>
                            <input type="radio" name="tag_config[showtype]" value="2" <?php if($tag_config['showtype'] == 2){ ?>checked <?php } ?>> <b>子栏目一</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>子栏目二</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;子栏目一下级&nbsp;&nbsp;子栏目一下级

      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod, 'tag_cat', 'tag_config[templateid]', $tag_config['templateid'] ,' id="templateid" ')?>
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