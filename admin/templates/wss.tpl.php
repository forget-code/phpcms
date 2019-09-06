<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_info">
    <caption>CNZZ 统计配置</caption>
  <tr>
     <td>
	<form action="?mod=phpcms&file=wss&action=setting" method="post">
	  <label>
	 <input type="radio" name="wss_enable" value="1" <?php if($PHPCMS['wss_enable']) echo 'checked';?>> 开启统计 
	 <input type="radio" name="wss_enable" value="0" <?php if(!$PHPCMS['wss_enable']) echo 'checked';?>> 关闭统计
	 </label>
	  <input type="submit" name="dosubmit" value=" 更新配置 ">
	</form>	 </td>
	<td>统计代码：
	  <input type="text" style="width:80%" value="&lt;script src='http://pw.cnzz.com/c.php?id=<?=$wss_site_id?>&amp;l=2' language='JavaScript' charset='gb2312'&gt;&lt;/script&gt;" size="60"></td>
   </tr>
   <tr><td colspan="2">默认情况下：将代码放置到：templates/default/phpcms/footer.html最下面即可</td></tr>
</table>

</body>
</html>