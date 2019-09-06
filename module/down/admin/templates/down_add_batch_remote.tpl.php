<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">下载首页</a> &gt;&gt; 从远程FTP服务器批量添加 </td>
  </tr>
</table>
<script type="text/javascript">
function doCheck(){
	if ($F('dir')=="") {
		alert("请输入目录");
		$('dir').focus();
		return false;
	}
	if ($F('catid')==0) {
		alert("请选择栏目");
		$('catid').focus();
		return false;
	}

}
</script>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=add_batch_remote&channelid=<?=$channelid?>" method="post" name="myform" onsubmit="return doCheck();">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="2">从远程FTP服务器批量添加</th>
  </tr>

  <tr> 
      <td class="tablerowhighlight"  width="20%" >ftp主机</td>
      <td class="tablerow"><input name="batch[ftphost]" id="ftphost" type="text" size="40" value="www.phpcms.cn"></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight">ftp帐号</td>
      <td class="tablerow"><input name="batch[ftpuser]" id="ftpuser" type="text" size="40" value="phpcms"></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight">ftp密码<br></td>
      <td class="tablerow"><input name="batch[ftppass]" id="ftppass" type="password" size="40" value="123456"></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" ><b>PHPCMS根目录相对FTP根目录的路径</b></td>
      <td class="tablerow"><input name="batch[ftpwebpath]" id="ftpwebpath" type="text" size="40" value="httpdocs/"><br>有很多虚拟主机的ftp根目录与web根目录不一样，您需要正确设置才能使用ftp功能<br>注意以“/”结尾，例如有的是 /wwwroot/ 或者 /httpdocs/，留空则表示ftp根目录与phpcms根目录路径相同</td>
    </tr>

<tr>
<td class="tablerowhighlight">指定目录</td>
<td class="tablerow"><input type="input" name="batch[dir]" size="40" id="dir" value="files/"/><br /><font color="red">例如:</font>您指定的目录在 '<font color="blue">网站根目录/down/uploadfiles/books/</font>' 则请填写<font color="green">网站根目录/down/uploadfiles/books/</font></td>
</tr>

<tr>
<td class="tablerowhighlight">指定目录http访问地址</td>
<td class="tablerow"><input type="input" name="batch[httppath]" size="40" id="httppath" value="http://www.phpcms.cn/"/> <input type="checkbox" value="1" name="ifftp" id="ifftp"  onclick="$('useftp').style.display=this.checked ? '' : 'none';"> 无http地址,用ftp地址下载<br /><font color="red">例如:</font>指定目录phpcms/可以通过http://phpcms.cn/phpcms/访问,则请填写http://phpcms.cn/</td>
</tr>
<tr id="useftp" style="display:none">
<td class="tablerowhighlight"> </td>
<td class="tablerow"><font color="red">说明:</font>如果选中无http地址,用ftp地址下载,则<br>
<font color="blue">匿名ftp服务器</font>构造如ftp://phpcms.cn/phpcms.zip的下载地址<br>
<font color="blue">非匿名ftp服务器</font>构造如ftp://username:password@phpcms.cn/phpcms.zip的下载地址</td>
</tr>

<tr>
<td class="tablerowhighlight">地址正确性测试</td>
<td class="tablerow"><input type="button" value="点击测试" onclick="doTest();"/><span id="test"></span></td>
</tr>
<script type="text/javascript">
function doTest()
{
	var d = '';
	var f = $('ftphost').value+'/'+$('ftpwebpath').value+$('dir').value;
	var h = $('httppath').value+$('dir').value;
	if($('ifftp').checked)
	{
		if($('ftpuser').value=='')
		{
			d = f;
		}
		else
		{
			d = 'ftp://'+$('ftpuser').value+':'+$('ftppass').value+'@'+f;
		}
	}
	else
	{
		d = h;
	}
	$('test').innerHTML='<font color=blue><br>FTP地址:ftp://'+f+'<br>HTTP地址:'+h+'<br>下载地址:'+d+'<br></font><font color=red>如果你已经确认FTP和HTTP地址均能正常访问指定目录,请继续,否则请修改</font>'
}
</script>
<tr>
<td class="tablerowhighlight">指定文件后缀</td>
<td class="tablerow"><input type="input" name="batch[ext]" size="40" /> 多个后缀请用"|"隔开,例如:zip|rar|exe,留空表示所有文件</td>
</tr>
<tr>
<td class="tablerowhighlight">所属栏目</td>
<td class="tablerow"><?=$category_select?></td>
</tr>

 <tr> 
      <td class="tablerowhighlight">是否生成</td>
      <td class="tablerow"><input type="radio" name="batch[ishtml]" value="1" <?php if($CHA['ishtml']==1) {?>checked <?php } ?>  onclick="$('htmlrule').style.display='';$('phprule').style.display='none';"> 是 <input type="radio" name="batch[ishtml]" value="0" <?php if($CHA['ishtml']==0) {?>checked <?php } ?> onclick="$('htmlrule').style.display='none';$('phprule').style.display='';"> 否</td>
 </tr>
<tbody id="htmlrule" style="display:<?php if($CHA['ishtml']==0) {?>none<?php }?>"> 
<tr> 
		  <td class="tablerowhighlight">html文件生成目录</td>
		  <td class="tablerow"><input type="text" name="batch[htmldir]" ></td>
		</tr>
		<tr> 
		  <td class="tablerowhighlight">html文件名前缀</td>
		  <td class="tablerow"><input type="text" name="batch[prefix]"></td>
		</tr>
		<tr> 
		  <td class="tablerowhighlight">url规则（生成html）</td>
		  <td class="tablerow"><?=$html_urlrule?></td>
		</tr>
</tbody>
<tbody id="phprule" style="display:<?php if($CHA['ishtml']==1) {?>none<?php }?>">
		<tr> 
		  <td class="tablerowhighlight">url规则（不生成html）</td>
		  <td class="tablerow"><?=$php_urlrule?></td>
		</tr>
</tbody>
 <tr>
      <td class="tablerowhighlight">允许查看的会员组</td>
      <td class="tablerow"><?=$showgroup?></td>
    </tr>
    <tr>
      <td class="tablerowhighlight">阅读所需点数</td>
      <td class="tablerow">&nbsp;<input size="5" name="batch[readpoint]" type="input" /> 点</td>
    </tr>

	 <tr> 
      <td class="tablerowhighlight">下载状态</td>
		<td class="tablerow">
		<input name="batch[status]" type="radio" value="3" checked> 已通过&nbsp;
		<input name="batch[status]" type="radio" value="1"> 待审核&nbsp;</td>
	  </tr>


  <tr>
    <td class="tablerowhighlight"> </td>
    <td class="tablerow">
	<input type="submit" name="dosubmit" value=" 确定 " />
	&nbsp;&nbsp;
<font color="red">Tips:</font>此功能对同一目录可反复使用,系统会自动监测文件是否已经被添加过
	</td>
  </tr>
</table>


</body>
</html>