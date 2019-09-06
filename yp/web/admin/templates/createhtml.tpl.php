<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="4">更新企业新闻</th>
  </tr>
<tr align="center">
<td width="25%" class="tablerowhighlight">新闻起始ID</td>
<td width="25%" class="tablerowhighlight">新闻结束ID</td>
<td width="25%" class="tablerowhighlight">每轮生成新闻数</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform1" action="?file=<?=$file?>">
<input type="hidden" name="action" value="show" id="action">
<input type="hidden" name="label" value="article" id="label">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minarticleid?>" disabled></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxarticleid?>" disabled></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="50" disabled></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成新闻'></td>
  </tr>
</form>
</table>

<BR>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="4">更新企业产品</th>
  </tr>
<tr align="center">
<td width="25%" class="tablerowhighlight">产品起始ID</td>
<td width="25%" class="tablerowhighlight">产品结束ID</td>
<td width="25%" class="tablerowhighlight">每轮生成产品数</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform2" action="?file=<?=$file?>">
<input type="hidden" name="action" value="show" id="action2">
<input type="hidden" name="label" value="product" id="label">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minproductid?>" disabled></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxproductid?>" disabled></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="50" disabled></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成产品' ></td>
  </tr>
</form>
</table>
<BR>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="4">更新企业招聘</th>
  </tr>
<tr align="center">
<td width="25%" class="tablerowhighlight">招聘起始ID</td>
<td width="25%" class="tablerowhighlight">招聘结束ID</td>
<td width="25%" class="tablerowhighlight">每轮生成招聘数</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform3" action="?file=<?=$file?>">
<input type="hidden" name="action" value="show" id="action3">
<input type="hidden" name="label" value="job" id="label">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minjobid?>" disabled></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxjobid?>" disabled></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="50" disabled></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成招聘'></td>
  </tr>
</form>
</table>
</body>
</html>