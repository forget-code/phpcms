<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&confirm=1" method="post" name="myform">
  <tr>
    <th colspan=2>安装模块</th>
  </tr>
    <tr>
    <td class="tablerowhighlight" colspan=2>第一步：填写模块目录</td>
  </tr>
	<tr> 
      <td class="tablerow">模块目录</td>
      <td class="tablerow">
          <input type="text" name="installdir" size="30">
       </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> 
	  <input type="submit" name="submit" value=" 下一步 "> 
      &nbsp; <input type="button" name="cancel" value=" 取消安装 " onclick="window.location='?mod=<?=$mod?>&file=module'">
	  </td>
    </tr>
	</form>
</table>
<br />
<table cellpadding="2" cellspacing="1" class="tableborder">
<tr>
    <th colspan=2>操作说明</th>
  </tr>
  <tr> 
      <td class="tablerow">注意：安装模块前，请确认将该模块文件夹上传至服务器上，一般模块位于网站根目录，可复制频道模块位于根目录Module文件夹内。<br/>
      模块目录填写的是该模块相对于根目录的路径，如产品模块：product，采集模块：spider，而文章模块为module/article，下载模块为module/down。
       </td>
    </tr>
  </table>
</body>
</html>