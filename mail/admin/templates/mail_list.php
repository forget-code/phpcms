<?php include admintpl('header'); ?>

<?php echo $menu; ?>

<?php 
if($fnumber>0) 
{
?>
<form action="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=deleteall" method="post" name="formmails" id="formmails">
  <table align="center" cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="7">已经存在的邮件列表文件</th>
    </tr>
    <tr align="center">
      <td class="tablerowhighlight">选中</td>
      <td class="tablerowhighlight">序号</td>
      <td class="tablerowhighlight">文件</td>
      <td class="tablerowhighlight">大小</td>
      <td class="tablerowhighlight">Email个数</td>
      <td class="tablerowhighlight">创建时间</td>
      <td class="tablerowhighlight">操作</td>
    </tr>	
	<?php foreach($mailfiles as $i=>$f)  { ?>
    <tr onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgcolor="#F1F3F5">
      <td>&nbsp;
	  <input name="mail[]" id="mail<?php echo $i; ?>" type="checkbox" value="<?php echo $f; ?>" title="选择此文件" />	  </td>
      <td onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);"><?php echo $i+1; ?></td>
      <td onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);">
	  <a title="打开此文件" href="<?php echo $mail_datadir.$f; ?>" target="_blank"><?php echo $f; ?></a></td>
	  <td onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);"><?php echo round(filesize($mail_datadir.$f)/(1024),2); ?> KB</td>
	  <td align="center" onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);"><?php echo count(file($mail_datadir.$f)); ?></td>
	  <td align="center" onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);"><?php echo date("Y-m-d H:i:s",filemtime($mail_datadir.$f)); ?></td>
	  <td align="center" onMouseDown="document.getElementById('mail<?php echo $i; ?>').checked = (document.getElementById('mail<?php echo $i; ?>').checked ? false : true);">&nbsp;<a href="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=send&filename=<?php echo urlencode($f); ?>">发 送</a>&nbsp; &nbsp;
        <a href="?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=down&mail=<?php echo urlencode($f); ?>" >下 载</a>&nbsp; &nbsp; 
        <a href="#" onclick="javascript:confirmurl('?mod=<?php echo $mod; ?>&file=<?php echo $file; ?>&action=delete&mail=<?php echo urlencode($f); ?>',' 确定要删除这个邮件列表文件 <?php echo $f; ?> 么？')">删 除</a>	  </td>
    </tr>
	<?php } ?>
 
    <tr>
      <td colspan="7" class="tablerow">
	  <input name="chkall" type="checkbox" id="chkall" onclick="checkall(this.form)" value="checkbox" title="全部选中">
	  全选/反选
	  <input name="submit" type="submit" id="submit" value=" 删除所选 " />	  </td>
    </tr>
  </table>
</form>
<?php
}
else
{
	echo '<center><strong>暂无邮件列表文件</strong></center>';
}
?>
<br />
<form action="?mod=<?php echo $mod; ?>&amp;file=mail&amp;action=save&amp;submit=1" method="post" enctype="multipart/form-data" name="formimport" id="formimport" >
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="3">导入列表</th>
    </tr>
    <tr>
      <td colspan="2" class="tablerow">导入邮件列表文件</td>
      <td class="tablerow">
	  <input name="uploadfile" type="file" id="uploadfile" size="40" />
	  文件扩展名必须为 txt ，上传前请自行确保其格式正确。 </td>
    </tr>
    <tr>
      <td colspan="2" class="tablerow">操作</td>
      <td class="tablerow">
	  <input name="submit" type="submit" id="submit" value=" 上 传 " />&nbsp;
	  <input name="reset" type="reset" id="reset" value=" 清 除 " />
      </td>
    </tr>
  </table>
</form>

</body>
</html>