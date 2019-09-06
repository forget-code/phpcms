<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
	<form name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" >
    <input type="hidden" name="uc_dbhost" value="<?=$uc_dbhost?>" />
    <input type="hidden" name="uc_dbuser" value="<?=$uc_dbuser?>" />
    <input type="hidden" name="uc_dbname" value="<?=$uc_dbname?>" />
    <input type="hidden" name="uc_dbpwd" value="<?=$uc_dbpwd?>" />
    <input type="hidden" name="uc_dbpre" value="<?=$uc_dbpre?>" />
    <input type="hidden" name="uc_charset" value="<?=$uc_charset?>" />
    <input type="hidden" name="uc_appid" value="<?=$uc_appid?>" />
	<table cellpadding="0" cellspacing="1" class="table_info">
    	<caption>PHPCMS导入UCENTER会员工具</caption>
        <tr>
        	<td>
            使用环境：<br />
           	&nbsp;&nbsp; &nbsp;操作系统：Windows/*unix <br />
            &nbsp;&nbsp; &nbsp;Web服务器：Apache/IIS <br />
			&nbsp;&nbsp; &nbsp;PHP：4.3.0 及以上 <br />
			&nbsp;&nbsp; &nbsp;Mysql：4.1.0 及以上<br />
			功能介绍：<br />
            &nbsp;&nbsp; &nbsp;当需要将PHPCMS用户导入到Ucenter时需要使用到本工具。当使用本工具后该系统的原有会员信息将会转移到Ucenter里面。以供用户的同步<br />
            </td>
        </tr>
	</table>
    <div class="button_box">
            <input type="submit" name="dosubmit" value="开始转移">
            <input type="button" name="back" value="返回上一页" onClick="javascript:history.go(-1);" >
    </div>
    </form>
</body>
</html>