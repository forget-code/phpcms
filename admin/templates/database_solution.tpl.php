<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<form name="myform" action="" method="post" target="">
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>数据库策略</caption>
    <tr>
    	<th width="10%"><strong>选择方式：</strong></th>
        <td>
        <input type="radio" name="dbsolution" value="1" title="高速模式适合使用独立主机的用户，可以最大限度提升系统速度，但比较占用数据库容量" onclick="alert(this.title);" checked>高速模式
		<input type="radio" name="dbsolution" value="0" title="高效模式适合使用虚拟主机商用户，在不减少功能的前提下尽可能缩小数据库节约用户成本" onclick="alert(this.title);">高效模式
        </td>
    </tr>
    <tr>
    	<th><strong></strong></th>
        <td>
        <input type="submit" name="dosubmit" value=" 提 交 " />
        <input type="reset" name="reset" value="重置"  />
        </td>
    </tr>
</table>
</form>
<table cellpadding="0" cellspacing="1" class="table_info">
	<caption>提 示</caption>
    <tr>
    	<td>
        <font color="red">运行该命令会明显增大服务器压力，请谨慎使用。</font><br />
        高速模式适合使用独立主机的用户，可以最大限度提升系统速度，但比较占用数据库。<br />
        高效模式适合使用虚拟主机商用户，在不减少功能的前提下尽可能缩小数据库节约用户成本。
        </td>
    </tr>
</table>
</body>
</html>