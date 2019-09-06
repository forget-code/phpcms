<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>执行SQL</caption>
  <form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=executesql&operation=sql">
     <tr> 
      <td height="25">请把要执行的SQL语句粘贴到下面的文本框<br />
	  <textarea name="sql" style="width:100%;height:200px"><?=$sql?></textarea></td>
    </tr>
   <tr> 
      <td height="40" class="align_c"> <input type="submit" name="dosubmit" value=" 执行SQL "></td>
    </tr>
  </form>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>上传SQL文件并立即执行</caption>
	<form name="upload" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=executesql&operation=file" enctype="multipart/form-data">
  <tr>
    <td>
	        上传SQL文件：
             <input name="uploadfile" type="file" size="25">
             <input type="hidden" name="MAX_FILE_SIZE" value="4096000">
             <input type="submit" name="dosubmit" value=" 上传并执行 "><br>只允许上传SQL格式的文件，上传成功后文件中的SQL语句将被立即执行
	</td>
  </tr>
  </form>
</table>
<?php if($data){?>
<table cellpadding="0" cellspacing="1" class="table_list">
	<tr>
	<?php foreach($data[0] as $k=>$v){?>
		<td><?=$k?></td>
	<?php }?>
	</tr>
	<?php foreach($data as $row){?>
		<tr>
			<?php foreach($row as $v){?>
				<td><?=$v?></td>
			<?php }?>
		</tr>
	<?php }?>
</table>
<?php }?>
</body>
</html>