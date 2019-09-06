<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_info">
    <caption>关于 网站地图</caption>
  <tr>
     <td>
	<b>网站地图：</b>
	网站地图（维基百科）：网站地图描述了一个网站的架构。 它可以使一个任意形式的文档，用作网页设计的设计工具，也可以是列出网站中所有页面的一个网页，通常采用分级形式。这有助于访问者以及搜索引擎的机器人找到网站中的页面。而且方便访问者更加快速清晰的浏览你的网站，给用户更好的用户体验。 <p>
<font color="blue">您的网站地图访问地址为：</font><a href="<?=SITE_URL?>sitemap.html" target="_blank" ><?=SITE_URL?>sitemap.html</a><br/>
	 </td>
   </tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
<tr>
     <td class="align_c">
	 <form action="" method="post">
	 <input type="submit" name="dosubmit" value=" 更新网站地图 ">
	 </form>
     </td>
   </tr>
</table>

</body>
</html>