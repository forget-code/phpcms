<?php include PHPCMS_ROOT.'install/header.tpl.php';?>
    <div id="installmessage" style="height:200px; overflow:auto;" class="content">正在准备安装 ...<br /></div>
	<span id="finish" style="display:none">&nbsp;&nbsp;&nbsp;<a href="javascript:history.go(-1);" class="btn">上一步：配置帐号</a></span>
	<span id="login" style="display:none">
	<div id="introducetd">
	<p class="suc">
	后台管理地址：<a href="admin.php"><?php echo $siteUrl;?>/admin.php</a><br />
	前台访问地址：<a href="<?=$siteUrl?>/"><?=$siteUrl?>/</a>
	</p>
	</div>
	</span>
  </div>
</div>
<form id="install" action="install.php?" method="post">
<input type="hidden" name="module" id="module" value="<?=$module?>" />
<input type="hidden" name="testdata" id="testdata" value="<?=$testdata?>" />
<input type="hidden" id="selectmod" name="selectmod" value="<?=$selectmod?>" />
<input type="hidden" name="step" value="7">
</form>
</div>
<script language="JavaScript">
<!--
$().ready(function() {
reloads();
})
var n = 0;
var setting =  new Array();
setting['phpcms'] = 'PHPCMS系统模块安装成功...';
setting['member'] = '会员模型安装成功...';
setting['ads'] = '广告模块安装成功...';
setting['link'] = '友情链接模块安装成功...';
setting['space'] = '个人空间模块安装成功...';
setting['announce'] = '公告模块安装成功...';
setting['vote'] = '投票模块安装成功...';
setting['order'] = '订单模块安装成功...';
setting['mood'] = '心情指数模块安装成功...';
setting['comment'] = '评论模块安装成功...';
setting['message'] = '短消息模块安装成功...';
setting['pay'] = '支付模块安装成功...';
setting['mail'] = '邮件模块安装成功...';
setting['page'] = '单网页模块安装成功...';
setting['guestbook'] = '留言本模块安装成功...';
setting['ask'] = '问吧模块安装成功...';
setting['digg'] = '顶一下模块安装成功...';
setting['search'] = '全站搜索模块安装成功...';
setting['special'] = '专题模块安装成功...';
setting['error_report'] = '错误报告模块安装成功...';
setting['formguide'] = '表单向导模块安装成功...';
setting['yp'] = '企业黄页模块安装成功...';
setting['spider'] = '采集模块安装成功...';
setting['video'] = '视频模块安装成功...';
var dbhost = '<?=$dbhost?>';
var dbuser = '<?=$dbuser?>';
var dbpw = '<?=$dbpw?>';
var dbname = '<?=$dbname?>';
var tablepre = '<?=$tablepre?>';
var dbcharset = '<?=$dbcharset?>';
var pconnect = '<?=$pconnect?>';
var username = '<?=$username?>';
var password = '<?=$password?>';
var email = '<?=$email?>';
var ftp_user = '<?=$dbuser?>';
var password_key = '<?=$password_key?>';

function reloads() {
var module = $('#selectmod').val();
m_d = module.split(',');

$.ajax({
	   type: "POST",
	   url: 'install.php',
	   data: "step=installmodule&module="+m_d[n]+"&dbhost="+dbhost+"&dbuser="+dbuser+"&dbpw="+dbpw+"&dbname="+dbname+"&tablepre="+tablepre+"&dbcharset="+dbcharset+"&pconnect="+pconnect+"&username="+username+"&password="+password+"&email="+email+"&ftp_user="+ftp_user+"&password_key="+password_key+"&sid="+Math.random()*5,
	   success: function(msg){
		   if(msg==1) {
			   alert('指定的数据库不存在，系统也无法创建，请先通过其他方式建立好数据库！');
		   } else if(msg==2) {
			   document.getElementById('installmessage').innerHTML += "<font color='#ff0000'>"+m_d[n]+"/install/mysql.sql 数据库文件不存在</font>";
		   } else if(msg.length>20) {
		       document.getElementById('installmessage').innerHTML += "<font color='#ff0000'>错误信息：</font>"+msg;
		   } else {
			   document.getElementById('installmessage').innerHTML += setting[m_d[n]] + msg + "<br>";
			   
				n++;
				if(n < m_d.length)
				{
					reloads();
				}
				else
				{
					$('#').load('?step=cache_all&sid='+Math.random()*5);
					var testdata = $('#testdata').val();
					if(testdata == 1)
					{
						$('#').load('?step=testdata&sid='+Math.random()*5);
						document.getElementById('installmessage').innerHTML += "测试数据安装完成<br>";
					}
					document.getElementById('installmessage').innerHTML += "<font color='yellow'>缓存更新成功</font><br>";
					document.getElementById('installmessage').innerHTML += "<font color='yellow'>安装完成</font>";
					$('#finish').css('display','none');
					$('#login').css('display','');
				}
				document.getElementById('installmessage').scrollTop = document.getElementById('installmessage').scrollHeight;
		   }	
	}	
	});
}
//-->
</script>
</body>
</html>