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
		<td></td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>编辑<?=$functions[$function]?>标签</th>
  </tr>
  <form name="myform" method="get" action="?">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>" id="action">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input name="tagname" id="tagname" type="text" size="20"  value="<?=$tagname?>"> <input name="button" type="button" value="(标签名称不可再编辑) " >	  <br/>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>标签说明</b><br/>例如：首页中介列表，10位</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="60"  value="<?=$tag_config['introduce']?>" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>       
	<tr> 
      <td class="tablerow"><b>调用的会员类型</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[membertype]" value="1" <?php if($tag_config['membertype']==1){ ?>checked<?php } ?>>个人用户&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="tag_config[membertype]" value="2"  <?php if($tag_config['membertype']==2){ ?>checked<?php } ?>>中介机构&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="tag_config[membertype]" value="3"  <?php if($tag_config['membertype']==3){ ?>checked<?php } ?>>房地产开发商&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
		
    <tr> 
      <td class="tablerow"><b>会员排序方式</b></td>
      <td  class="tablerow">
<select name="tag_config[ordertype]">
<option value="0"  <?php if($tag_config['ordertype']==0){ ?>selected<?php } ?>>按注册时间降序</option>
<option value="1"  <?php if($tag_config['ordertype']==1){ ?>selected<?php } ?>>按注册时间升序</option>
<option value="2"  <?php if($tag_config['ordertype']==2){ ?>selected<?php } ?>>按发布点数降序</option>
<option value="3"  <?php if($tag_config['ordertype']==3){ ?>selected<?php } ?>>按发布点数升序</option>
</select>
      </td>
    </tr>  
	    <tr>
      <td class="tablerow"><b>调用会员数</b></td>
      <td  class="tablerow"><input name="tag_config[membernum]" type="text" size="10" value="<?=$tag_config['membernum']?>"></td>
    </tr>
    <tr>
      <td class="tablerow"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="$page" <?php if($tag_config['page']){ ?>checked<?php } ?>>
        是&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="tag_config[page]" value="0" <?php if(!$tag_config['page']){ ?>checked<?php } ?>>        否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1" <?php if($tag_config['target']){ ?>checked<?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[target]" value="0" <?php if(!$tag_config['target']){ ?>checked<?php } ?>>否</td>
    </tr>
   
    <tr> 
      <td class="tablerow"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
	<?=showtpl($mod,'tag_member_list','tag_config[templateid]',$tag_config['templateid'],' id="templateid" ')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=<?=$mod?>&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
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