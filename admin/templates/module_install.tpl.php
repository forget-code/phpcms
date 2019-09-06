<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_form">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&confirm=1" method="post" name="myform">
    <caption>第一步：填写模块目录</caption>
	<tr> 
      <th><strong>模块目录</strong></th>
      <td>
          <input type="text" name="installdir" size="30">
       </td>
    </tr>
    <tr> 
      <td></td>
      <td> 
	  <input type="submit" name="submit" value=" 下一步 "> 
      &nbsp; <input type="button" name="cancel" value=" 取消安装 " onClick="window.location='?mod=<?=$mod?>&file=module'">
	  </td>
    </tr>
	</form>
</table>
<br />
<table cellpadding="2" cellspacing="1" class="table_info">
<tr>
    <caption>操作说明</caption>
  <tr> 
      <td>注意：安装模块前，请确认将该模块文件夹上传至服务器上，模块位于网站根目录。<br/>
      模块目录填写的是该模块相对于根目录的路径，如友情链接模块：link，问吧模块：ask。
       </td>
    </tr>
  </table>
</body>
</html>