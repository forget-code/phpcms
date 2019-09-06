<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>

<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>
  基本信息
  </caption>
  <tr>
    <th width="30%"><strong>前台最大充值次数</strong>
    <br />前台超过最大充值次数后系统将自动锁定该IP，0表示不限制次数</th>
    <td>
        <input type='text' name='setting[maxtopfailedtimes]' value="<?=$maxtopfailedtimes ?>" />
    </td>
  </tr>
  <tr>
   <th><strong>IP锁定时间</strong><br/>超过锁定时间后该IP将自动解锁</th>
      <td>
        <input type="text" maxlength="5" size="5" value="<?=$maxiplockedtime?>" id="maxiplockedtime" name="setting[maxiplockedtime]" /> 小时
      </td>
	</tr>
  <tr>
    <th>&nbsp;</th>
    <td><input type="submit" name="dosubmit" value=" 确定 ">
	</td>
  </tr>
</table></form></body>
</html>

