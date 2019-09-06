<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<div align="center">
  <?=$menu?>
  <table cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan=2>公告内容</th>
    </tr>
    <tr>
      <td width="20%" align="right"  class="tablerowhighlight">标 题：</td>
      <td width="80%" align="left" class="tablerow"><?=$announce[title]?></td>
    </tr>
    <tr>
      <td align="right" class="tablerowhighlight">添加时间：</td>
      <td align="left" class="tablerow"><?=$announce[addtime]?></td>
    </tr>
    <tr>
      <td align="right" class="tablerowhighlight">开始日期：</td>
      <td align="left" class="tablerow"><?=$announce[fromdate]?></td>
    </tr>
    <tr>
      <td align="right" class="tablerowhighlight">结束日期：</td>
      <td align="left" class="tablerow"><?=$announce[todate]?></td>
    </tr>
    <tr>
      <td align="right" class="tablerowhighlight">发布人：</td>
      <td align="left" class="tablerow"><?=$announce[username]?></td>
    </tr>
	<tr>
      <td align="right" class="tablerowhighlight">浏览次数：</td>
      <td align="left" class="tablerow"><?=$announce[hits]?></td>
    </tr>
    <tr>
	 <td align="right" class="tablerowhighlight">公告内容：</td>
      <td class="tablerow"><?=$announce[content]?></td>
    </tr>
  </table>
</div>
</body>
</html>