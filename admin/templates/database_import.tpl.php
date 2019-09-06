<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>phpcms备份的SQL文件</th>
  </tr>
<form method="post" name="myform" >
<tr align="center">
<td width="12%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="30%" class="tablerowhighlight">文件名</td>
<td width="10%" class="tablerowhighlight">文件大小</td>
<td width="20%" class="tablerowhighlight">备份时间</td>
<td width="10%" class="tablerowhighlight">卷号</td>
<td width="13%" class="tablerowhighlight">操作</td>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $id => $info){
$id++;
?>
  <tr bgcolor="<?=$info['bgcolor']?>" >
    <td align="center"><input type="checkbox" name="filenames[]" value="<?=$info['filename']?>"></td>
    <td align="center"><?=$id?></td>
    <td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&filename=<?=$info['filename']?>"><?=$info['filename']?></a></td>
    <td align="center"><?=$info['filesize']?> M</td>
	<td align="center"><?=$info['maketime']?></td>
    <td align="center"><?=$info['number']?></td>
    <td align="center">
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&pre=<?=$info['pre']?>&dosubmit=1">导入</a> | 
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&filename=<?=$info['filename']?>">下载</a>
	</td>
</tr>
<?php 
	}
}
?>
  <tr>
    <td class="tablerow" align="center"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td colspan=3 class="tablerow">
	<select name="tocharset">
	<option value="">不进行字符集转换</option>
	<option value="gbk2utf8">GBK 转 UTF-8</option>
	<option value="utf82gbk">UTF-8 转 GBK</option>
	<option value="big52utf8">BIG5 转 UTF-8</option>
	<option value="utf82big5">UTF-8 转 BIG5</option>
	<option value="gbk2big5">简体中文 转 繁体中文</option>
	<option value="big52gbk">繁体中文 转 简体中文</option>
	</select>
	<input type="submit" name="submit1" value=" 字符集转换 " title="转换完毕后以新字符集为前缀保存" onclick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=changecharset'">
	<br/><?php if(!function_exists("mb_convert_encoding")){ ?>我们强烈建议您加载PHP的mb_string扩展，否则此操作十分消耗资源（难以对大于1M的文件进行字符集转换）。<?php } ?>
	</td>
	<td colspan=3 valign="top" class="tablerow"><input type="submit" name="submit2" value=" 删除选中的备份 " onclick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'"></td>
  </tr>
	</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=7>非phpcms备份的SQL文件</th>
  </tr>
<form method="post" name="myform1" action="?mod=<?=$mod?>&file=<?=$file?>&action=delete">
<tr align="center">
<td width="12%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="30%" class="tablerowhighlight">文件名</td>
<td width="10%" class="tablerowhighlight">文件大小</td>
<td width="20%" class="tablerowhighlight">备份时间</td>
<td width="13%" class="tablerowhighlight">操作</td>
</tr>
<?php 
if(is_array($others)){
	foreach($others as $id => $other){
$id++;
?>
  <tr>
    <td class="tablerow" align="center">
<input type="checkbox" name="filenames[]" value="<?=$other['filename']?>">
	</td>
    <td class="tablerow" align="center"><?=$id?></td>
    <td class="tablerow"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&filename=<?=$other['filename']?>"><?=$other['filename']?></a></td>
    <td class="tablerow" align="center"><?=$other['filesize']?> M</td>
	<td class="tablerow" align="center"><?=$other['maketime']?></td>
    <td class="tablerow" align="center">
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&filename=<?=$other['filename']?>&dosubmit=1">导入</a> | 
	<a href="?mod=<?=$mod?>&file=<?=$file?>&action=down&filename=<?=$other['filename']?>">下载</a>
	</td>
</tr>
<?php 
	}
}
?>
  <tr>
    <td class="tablerow" align="center"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td colspan=3 class="tablerow">
	<select name="tocharset">
	<option value="">不进行字符集转换</option>
	<option value="gbk2utf8">GBK 转 UTF-8</option>
	<option value="utf82gbk">UTF-8 转 GBK</option>
	<option value="big52utf8">BIG5 转 UTF-8</option>
	<option value="utf82big5">UTF-8 转 BIG5</option>
	<option value="gbk2big5">简体中文 转 繁体中文</option>
	<option value="big52gbk">繁体中文 转 简体中文</option>
	</select>
	<input type="submit" name="submit1" value=" 字符集转换 " title="转换完毕后以新字符集为前缀保存" onclick="document.myform1.action='?mod=<?=$mod?>&file=<?=$file?>&action=changecharset'">
	<br/><?php if(!function_exists("mb_convert_encoding")){ ?>我们强烈建议您加载PHP的mb_string扩展，否则此操作十分消耗资源（难以对大于1M的文件进行字符集转换）。<?php } ?>
	</td>
	<td colspan=3 valign="top" class="tablerow"><input type="submit" name="submit2" value=" 删除选中的备份 " onclick="document.myform1.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'"></td>
  </tr>
	</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>上传数据库备份文件</th>
  </tr>
	<form name="upload" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=uploadsql" enctype="multipart/form-data">
  <tr>
    <td height="30" class="tablerow" align="center">
	        上传SQL文件：
             <input name="uploadfile" type="file" size="25">
             <input type="hidden" name="MAX_FILE_SIZE" value="4096000">
             <input type="submit" name="submit" value=" 上传 "><br>只允许上传SQL格式的文件，上传成功后文件将自动在备份文件列表中显示
	</td>
  </tr>
  </form>
</table>
</body>
</html>