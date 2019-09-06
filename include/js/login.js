function checklogin()
{
	if(document.login.username.value=="")
	{
		alert("请输入用户名！");
		document.login.username.focus();
		return false;
	}
	if(document.login.password.value == "")
	{
		alert("请输入密码！");
		document.login.password.focus();
		return false;
	}
    document.login.phpcms_user.value = escape(document.login.username.value);
    return true;
}

username = getcookie("phpcms_user");
if(username==null)
{
	cookietime = getcookie("cookietime");
	select = new Array(3)
	select[86400] = cookietime == 86400 ? "selected" : ""
	select[2592000] = cookietime == 2592000 ? "selected" : ""
	select[31536000] = cookietime == 31536000 ? "selected" : ""

	document.write('<form id="login" name="login" method="post" action="'+phpcms_path+'member/login.php" onsubmit="return checklogin();" target="_self">&nbsp;用户名：<input type="text" name="username" id="username" size="12" class="inp" /><input type="hidden" name="phpcms_user" id="phpcms_user" /> 密码：<input name="password" type="password" id="password" size="12" class="inp" /> <select name="cookietime" id="cookietime" class="inp" ><option value="0">不保存</option><option value="86400" '+select[86400]+'>保存一天</option><option value="2592000" '+select[2592000]+'>保存一月</option><option value="31536000" '+select[31536000]+'>保存一年</option></select><input name="referer" type="hidden" id="referer" value=""> <input type="submit" name="loginsubmit" value="登 录" class="btn" /> &nbsp;&nbsp;<a href="'+phpcms_path+'member/register.php">免费注册</a> | <a href="'+phpcms_path+'member/getpassword.php">忘记密码</a></form>');
}
else
{
	username = unescape(username);
	document.write('&nbsp;<a href="'+phpcms_path+'member/member.php?username='+username+'"><b>'+username+'</b></a>，欢迎您光临！ <a href="'+phpcms_path+'member/">会员中心</a> | <a href="'+phpcms_path+'member/logout.php">退出登录</a>');
}