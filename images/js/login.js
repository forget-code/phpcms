function loginSubmit(login, uc)
{
	var username = login.elements['username'];
	var password = login.elements['password'];
    if(!loginCheck(login)) return false;
	if(uc == 1) return true;
	$.post(login.action, 'action=ajax&username='+username.value+'&password='+password.value, function(data){
		if(data == 1)
		{
			$('#logined_username').html(username.value);
			$('#div_login').hide();
			$('#div_logined').show();
		}
		else
		{
			alert('登录失败');
			redirect(login.action);
		}
		username.value = password.value = '';
	});
	return false;
}

function logout(url)
{
	$.get(url+'&id='+Math.random()*5, function(data){
		if(data != 1) alert(data);
	});
	$('#div_logined').hide();
	$('#div_login').show();
}

function loginshow()
{
	var auth = getcookie('auth');
	if(auth != null)
	{
		$('#logined_username').html(getcookie('username'));
		$('#div_login').hide();
		$('#div_logined').show();
	}
	else
	{
		$('#div_logined').hide();
		$('#div_login').show();
	}
}

$(function(){
   loginshow();
});