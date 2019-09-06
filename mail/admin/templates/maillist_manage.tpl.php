<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" language="JavaScript" >
function del_customer()
{
	var mycoler = document.getElementsByName("mail[]");
	var flag = false;
	for(var i = 0; i< mycoler.length ;i++){
		if(mycoler[i].checked){
			flag = true;
			break;
		}
	}
	if(!flag){
		alert("请选择要删除的对象");
		return false;
	}
	var msg = "你真的要删除吗!!!";
	if(! window.confirm(msg)){
		return false;
	}
	document.getElementsByName("thisForm").submit();
}

function CheckedRev()
{
	var arr = $(':checkbox');
	for(var i=0;i<arr.length;i++)
	{
		if (arr[i].checked = ! arr[i].checked)
		{
			$("#selectall").val("取消全选");
		}else
		{
			$("#selectall").val("全选");
		}

	}
}
</script>
<?=$menu?>
<form action="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=delete" method="post" name="formmails" id="formmails" onsubmit="return del_customer();" >
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>邮件列表</caption>
  <tr>
    <th style="width:40px">选中</th>
    <th style="width:40px">序号</th>
    <th>文件</th>
    <th style="width:100px">大小</th>
    <th style="width:60px">E-mail</th>
    <th style="width:150px">创建时间</th>
    <th style="width:180px">操作</th>
  </tr>
  <?php foreach($mailfiles as $i=>$f)  { ?>
    <tr>
      <td>&nbsp;
	    <input name="mail[]" id="mail<?php echo $i; ?>" type="checkbox" value="<?php echo $f; ?>" title="选择此文件" />
      </td>
      <td onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);"><?php echo $i+1; ?>
      </td>
      <td onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);">
	    <a title="打开此文件" href="<?php echo $dir.$f; ?>" target="_blank"><?php echo $f; ?></a>
      </td>
	  <td onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);"><?php echo round(filesize($mail_datadir.$f)/(1024),2); ?> KB
      </td>
	  <td align="center" onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);"><?php echo count(file($mail_datadir.$f)); ?>
      </td>
	  <td align="center" onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);"><?php echo date("Y-m-d H:i:s",filemtime($mail_datadir.$f)); ?>
      </td>
	  <td align="center" onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);">&nbsp;
        <a href="?mod=<?php echo $mod; ?>&file=send&type=3&filename=<?php echo urlencode($f); ?>">发送</a>&nbsp;|
        <a title="打开此文件" href="<?php echo $dir.$f; ?>" target="_blank">打开</a>&nbsp;|
	    <a href="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=down&filename=<?php echo urlencode($f); ?>" >下载</a>&nbsp;|
        <a href="#" onclick="javascript:confirmurl('?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=delete&filename=<?php echo urlencode($f); ?>',' 确定要删除这个邮件列表文件 <?php echo $f; ?> 么？')">删除</a>
     </td>
    </tr>
	<?php } ?>
</table>
<div class="button_box">
  <input type="button" name="button" onclick="javascript:CheckedRev();" id="selectall" value="全选" />
  <input type="submit" name="dosubmit" id="button" value="删除所选" />
</div>
</form>


<form action="?mod=<?php echo $mod; ?>&file=<?=$file?>&action=upload" method="post" enctype="multipart/form-data" name="formimport" id="formimport" >
<table cellpadding="0" cellspacing="1" class="table_form">
<caption>上传文件</caption>
  <tr>
    <th width="25%"><strong>导入邮件列表文件</strong></th>
    <td width="75%"> <input name="uploadfile" type="file" id="uploadfile" />
	  扩展名必须为txt ，一行一个email地址，上传前请自行确保其格式正确。</td>
  </tr>
  <tr>
    <th><strong>操作</strong></th>
    <td><input name="dosubmit" type="submit" id="submit" value=" 上 传 " />&nbsp;
	  <input name="reset" type="reset" id="reset" value=" 清 除 " /></td>
  </tr>
</table></form>