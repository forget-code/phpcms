<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body <?php if(!$parentid){?>onload="getchild(<?=$parentid?>)"<?php }?>>
<script type="text/javaScript">
function getchild(parentid)
{
	$.ajax({
	  url: '?',
	  data: "mod=<?=$mod?>&file=<?=$file?>&action=getchild&parentid="+parentid,
	  cache: false,
	  success: function(html)
	  {
		  parentid == 0 ?  $('#parent').html(html) : $('#parent').append(html); 
	  }
	});
}
</script>
<table cellpadding="2" cellspacing="1" class="table_form">
   <caption>添加菜单</caption>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform">
	<tr> 
      <th><strong>上级菜单</strong></th>
      <td><input name="info[parentid]" id="parentid" type="hidden" value="<?=$parentid?>"><?php if($parentname){?><span id="parentname"><?=$parentname?></span><?php }?><span id="parent"></span> <a href="###" onclick="javascript:getchild(0);$('#parentname').hide();">重选</a></td>
    </tr>
	<tr> 
      <th><font color="red">*</font> <strong>菜单名称</strong></th>
      <td><input name="info[name]" type="text" value="<?=$name?>" size="20" maxlength="20" require="true" datatype="limit" min="2" max="20" msg="不得少于2个字符超过20个字符|"></td>
    </tr>
	<tr> 
      <th><strong>链接地址</strong></th>
      <td><input name="info[url]" type="text" value="<?=$url?>" maxlength="100" style="width:80%"></td>
    </tr>
    <tr> 
      <th><strong>打开窗口</strong></th>
      <td><?=form::select($TARGET, 'info[target]', 'target', $target)?></td>
    </tr>
    <tr> 
      <th><strong>CSS样式</strong></th>
      <td><input name="info[style]" type="text" size="15" value="<?=$style?>"></td>
    </tr>
    <tr> 
      <th><strong>JS事件代码</strong></th>
      <td><input name="info[js]" type="text" size="50" value="<?=$js?>" maxlength="100" style="width:80%"></td>
    </tr>
    <tr>
      <th><strong>用户组浏览权限</strong><br /> 如果都不选，则表示不限制</th>
      <td><?=form::checkbox($GROUP, 'groupids', 'groupid', '', 5, '', '', 100);?></td>
    </tr>
    <tr>
      <th><strong>管理员浏览权限</strong><br /> 如果都不选，则表示不限制</th>
      <td><?=form::checkbox($ROLE, 'roleids', 'roleid', '', 5, '', '', 100);?></td>
    </tr>
    <tr> 
      <th></th>
      <td>
	    <input type="hidden" name="forward" value="<?=$forward?>"> 
	    <input type="Submit" name="dosubmit" value=" 确定 "> 
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>
<script language="javascript" type="text/javascript">
$().ready(function() {
	  $('form').checkForm(1);
	});
</script>