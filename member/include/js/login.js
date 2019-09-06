function login()
{
	var phpcms_auth = getcookie('phpcms_auth');
	var action = phpcms_auth ? 'logined' : 'login_form';
    var url = phpcms_path + 'member/login.php';
    var pars = 'action='+action+'&auth='+phpcms_auth;
	var myAjax = new Ajax.Updater(
					'loginstats',
					url,
					{
					method: 'post',
					parameters: pars
					}
	             ); 
}

function loging()
{
	if($F('username') == '') 
	{
		alert('用户名不能为空！');
		return false;
	}
	else if($F('password') == '') 
	{
		alert('密码不能为空！');
		return false;
	}
	else
	{
		var loginurl = phpcms_path + "member/login.php";
		var pars = "action=login_ajax&username="+$F('username')+"&password="+$F('password')+"&cookietime="+$F('cookietime');
		var myAjax = new Ajax.Request(loginurl, {method: 'post', parameters: pars, onComplete: logindo});
	}
}

function logindo(Request)
{
	if(Request.responseText != '') alert(Request.responseText);
    login();
}

function logouting()
{
    var loginurl = phpcms_path + "member/logout.php";
    var pars = "action=logout_ajax";
    var myAjax = new Ajax.Request(loginurl, {method: 'post', parameters: pars, onComplete: logoutdo});
}

function logoutdo(Request)
{
	if(Request.responseText != '') alert(Request.responseText);
    login();
}
