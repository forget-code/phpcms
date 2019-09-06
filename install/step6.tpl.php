<?php include PHPCMS_ROOT.'install/header.tpl.php';?>
<div class="content">
<form id="install" name="myform" action="install.php?" method="post">

<table width="100%" cellspacing="1" cellpadding="0" >
<caption>填写数据库信息</caption>
<tr>
<th width="30%" align="right" >数据库主机：</th>
<td><label>
  <input name="dbhost" type="text" id="dbhost" value="<?=DB_HOST?>" style="width:120px" />
</label></td>
</tr>
<tr>
<th align="right">数据库帐号：</th>
<td><input name="dbuser" type="text" id="dbuser" value="<?=DB_USER?>" style="width:120px" /></td>
</tr>
<tr>
<th align="right">数据库密码：</th>
<td><input name="dbpw" type="password" id="dbpw" value="<?=DB_PW?>" style="width:120px" /></td>
</tr>
<tr>
<th align="right">数据库名称：</th>
<td><input name="dbname" type="text" id="dbname" value="<?=DB_NAME?>" style="width:120px" /></td>
</tr>
<tr>
<th align="right">数据表前缀：</th>
<td><input name="tablepre" type="text" id="tablepre" value="<?=DB_PRE?>" style="width:120px" />  <img src="install/images/help.png" style="cursor:pointer;" title="如果一个数据库安装多个phpcms，请修改表前缀" align="absmiddle" />
<span id='helptablepre'></span></td>
</tr>
<tr>
<th align="right">数据库字符集：</th>
<td>
<input name="dbcharset" type="radio" id="dbcharset" value="utf8" <?php if(strtolower(DB_CHARSET)=='') echo ' checked '?>/>默认
<input name="dbcharset" type="radio" id="dbcharset" value="gbk" <?php if(strtolower(DB_CHARSET)=='gbk') echo ' checked '?> disabled/>GBK
<input name="dbcharset" type="radio" id="dbcharset" value="utf8" <?php if(strtolower(DB_CHARSET)=='utf8') echo ' checked '?>/>utf8 
<input name="dbcharset" type="radio" id="dbcharset" value="latin1" <?php if(strtolower(DB_CHARSET)=='latin1') echo ' checked '?> />latin1 
<img src="install/images/help.png" style="cursor:pointer;" title="如果Mysql版本为4.0.x，则请选择默认；&#10;如果Mysql版本为4.1.x或以上，则请选择其他字符集（一般选GBK）" align="absmiddle" />
<span id='helpdbcharset'></span>
</td>
</tr>
<tr>
<th align="right">启用持久连接：</th>
<td><input name="pconnect" type="radio" id="pconnect" value="1" 
<?php if(DB_PCONNECT==1) echo ' checked '?>/>是&nbsp;&nbsp;
<input name="pconnect" type="radio" id="pconnect" value="0" 
<?php if(DB_PCONNECT==0) echo ' checked '?>/>否
<img src="install/images/help.png" style="cursor:pointer;" title="如果启用持久连接，则数据库连接上后不释放，保存一直连接状态；如果不启用，则每次请求都会重新连接数据库，使用完自动关闭连接。" align="absmiddle" /><span id='helppconnect'></span>
<span id='helptablepre'></span></td>
</tr>
</table>

<table width="100%" cellspacing="1" cellpadding="0">
<caption>填写创始人信息</caption>
  <tr>
	<th width="30%" align="right">超级管理员帐号：</th>
	<td><input name="username" type="text" id="username" value="phpcms" style="width:120px" /> 2到20个字符，不含非法字符！</td>
  </tr>
  <tr>
	<th align="right">密码：</th>
	<td><input name="password" type="password" id="password" value="phpcms" style="width:120px" /> 6到20个字符<font color="FFFF00">（默认为 phpcms）</font></td>
  </tr>
  <tr>
	<th align="right">确认密码：</th>
	<td><input name="pwdconfirm" type="password" id="pwdconfirm" value="phpcms" style="width:120px"/></td>
  </tr>
  <tr>
	<th align="right">E-mail：</th>
	<td><input name="email" type="text" id="email" style="width:120px"/>
		<input type="hidden" name="selectmod" value="<?=$selectmod?>" />
		<input type="hidden" name="step" value="7"></td>
  </tr>
   <tr>
	<th align="right">会员密码密钥：</th>
	<td><input name="password_key" type="text" id="password_key" value="<?=PASSWORD_KEY?>" style="width:120px"/> <font color="#FFFF00">加强密码强度防止暴力破解，不可更改，请牢记</font>
	<input type="hidden" name="testdata" value="<?=$testdata?>" />
	</td>
  </tr>
</table>
</form>
<a href="javascript:history.go(-1);" class="btn">返回上一步：<?php echo $steps[--$step];?></a>
<a onClick="checkform()" class="btn"><span>下一步</span></a>
</div>
</div>
</div>
<script language="JavaScript">
<!--
var errmsg = new Array();
errmsg[0] = '您已经安装过Phpcms，系统会自动删除老数据！是否继续？';
errmsg[2] = '无法连接数据库服务器，请检查配置！';
errmsg[3] = '成功连接数据库，但是指定的数据库不存在并且无法自动创建，请先通过其他方式建立数据库！';
errmsg[6] = '数据库版本低于Mysql 4.0，无法安装Phpcms，请升级数据库版本！';

function checkform() 
{
	if($('#username').val().length<2 || $('#username').val().length>20)
	{
		alert('超级管理员帐号不能少于2个字符或者大于20个字符');
		return false;
	}
	if($('#password').val().length<6 || $('#username').val().length>20)
	{
		alert('超级管理员密码不能少于6个字符或者大于20个字符');
		return false;
	}
	if($('#password').val()!=$('#pwdconfirm').val())
	{
		alert('两次输入密码不一致！');
		return false;
	}
	if($('#dbname').val()=='')
	{
		alert('请输入数据库名称！');
		$('#dbname').focus();
		return false;
	}
	if($('#email').val()=='')
	{
		alert('请输入E-mail！');
		$('#email').focus();
		return false;
	}
	else
	{
		var emailPattern = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
		if (emailPattern.test($('#email').val())==false)
		{
			alert('请填写正确的E-mail！');
			return false;
		}
	}

	var url = '?step=dbtest&dbhost='+$('#dbhost').val()+'&dbuser='+$('#dbuser').val()+'&dbpw='+$('#dbpw').val()+'&dbname='+$('#dbname').val()+'&tablepre='+$('#tablepre').val()+'&sid='+Math.random()*5;
    $.get(url, function(data){
		if(data > 1)
		{
			alert(errmsg[data]);
			return false;
		}
		else if(data == 1 || (data == 0 && confirm(errmsg[0])))
		{
			$('#install').submit();
		}
	});
    return false;
}
//-->
</script>
</body>
</html>