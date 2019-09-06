<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script >
function CheckedRev(fieldid, titleid)
{
	var fieldids = '#'+fieldid;
    var titleids = '#'+titleid;
    var inputfieldids = 'input[boxid='+fieldid+']';
    if($(fieldids).attr('checked')==false)
    {
        $(inputfieldids).attr('checked',true);
        $(titleids).val("取消全选");

    }
    else
    {
        $(inputfieldids).attr('checked',false);
        $(titleids).val("全选");
    }
}
</script>
<body>
<form method="post" id="myform" name="myform" >
<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>phpcms备份的SQL文件</caption>
	<tr>
		<th width="8%">选中</th>
		<th>文件名</th>
		<th width="10%">文件大小</th>
		<th width="20%">备份时间</th>
		<th width="10%">卷号</th>
		<th width="15%">操作</th>
	</tr>
<?php
if(is_array($infos)){
	foreach($infos as $id => $info){
$id++;
?>
  <tr bgcolor="<?=$info['bgcolor']?>" >
    <td class="align_c"><input type="checkbox" name="filenames[]" value="<?=$info['filename']?>" id="sql_phpcms" boxid="sql_phpcms"></td>
    <td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&filename=<?=$info['filename']?>"><?=$info['filename']?></a></td>
    <td class="align_c"><?=$info['filesize']?> M</td>
	<td class="align_c"><?=$info['maketime']?></td>
    <td class="align_c"><?=$info['number']?></td>
    <td class="align_c">
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&pre=<?=$info['pre']?>&dosubmit=1">导入</a> |
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&filename=<?=$info['filename']?>">下载</a>
	</td>
</tr>
<?php
	}
}
?>
</table>
<div class="button_box" style="padding-left:20px">
<input name='phpcms_all' title="全部" type='button' id='phpcms_all' onclick="CheckedRev('sql_phpcms','phpcms_all')"  value="全选" />
&nbsp;&nbsp;
	<select name="tocharset">
	<option value="">不进行字符集转换</option>
	<option value="gbk2utf-8">GBK 转 UTF-8</option>
	<option value="utf-82gbk">UTF-8 转 GBK</option>
	<option value="big52utf-8">BIG5 转 UTF-8</option>
	<option value="utf-82big5">UTF-8 转 BIG5</option>
	</select>
	<input type="submit" name="submit1" value=" 字符集转换 " title="转换完毕后以新字符集为前缀保存" onclick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=changecharset'">
&nbsp;&nbsp;
    <input type="submit" name="submit2" value=" 删除选中的备份 " onclick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">
</div>
</form>

<form method="post" name="myform1" id="myform1" action="?mod=<?=$mod?>&file=<?=$file?>&action=delete">
<table cellpadding="0" cellspacing="1" class="table_list">
    <caption>非phpcms备份的SQL文件</caption>
	<tr>
	<th>选中</th>
	<th>ID</th>
	<th>文件名</th>
	<th>文件大小</th>
	<th>备份时间</th>
	<th>操作</th>
	</tr>
<?php
if(is_array($others)){
	foreach($others as $id => $other){
$id++;
?>
  <tr>
    <td class="align_c">
    <input type="checkbox" name="filenames[]" value="<?=$other['filename']?>" id="sql_other" boxid="sql_other">
	</td>
    <td><?=$id?></td>
    <td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&filename=<?=$other['filename']?>"><?=$other['filename']?></a></td>
    <td><?=$other['filesize']?> M</td>
	<td><?=$other['maketime']?></td>
    <td class="align_c">
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&filename=<?=$other['filename']?>&dosubmit=1">导入</a> |
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&filename=<?=$other['filename']?>">下载</a>
	</td>
</tr>
<?php
	}
}
?>
</table>
<div class="button_box" style="padding-left:20px">
<input name='other_all' type='button' id='other_all' onclick="CheckedRev('sql_other','other_all')"  value="全选" />
&nbsp;&nbsp;
   <select name="tocharset">
	<option value="">不进行字符集转换</option>
	<option value="gbk2utf-8">GBK 转 UTF-8</option>
	<option value="utf-82gbk">UTF-8 转 GBK</option>
	<option value="big52utf-8">BIG5 转 UTF-8</option>
	<option value="utf-82big5">UTF-8 转 BIG5</option>
	</select>
	<input type="submit" name="submit1" value=" 字符集转换 " title="转换完毕后以新字符集为前缀保存" onclick="document.myform1.action='?mod=<?=$mod?>&file=<?=$file?>&action=changecharset'">
&nbsp;&nbsp;
    <input type="submit" name="submit2" value=" 删除选中的备份 " onclick="document.myform1.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">
</div>
</form>

<form name="upload" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=uploadsql" enctype="multipart/form-data">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>上传数据库备份文件</caption>
  <tr>
    <td>
	        上传SQL文件：
             <input name="uploadfile" type="file" size="25">
             <input type="hidden" name="MAX_FILE_SIZE" value="4096000">
             <input type="submit" name="submit" value=" 上传 "><br>只允许上传SQL格式的文件，上传成功后文件将自动在备份文件列表中显示
	</td>
  </tr>
</table>
</form>
<?php if(!function_exists("mb_convert_encoding")){ ?>
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>提示信息</caption>
  <tr>
    <td>强烈建议您加载PHP的mb_string扩展，否则此操作十分消耗资源（难以对大于1M的文件进行字符集转换）。</td>
  </tr>
</table>
<?php } ?>
</body>
</html>