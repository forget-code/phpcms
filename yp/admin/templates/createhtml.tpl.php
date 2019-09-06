<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$mod?>&action=manage">企业黄页首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=tohtml">发布网页</a> </td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="4">更新企业主页</th>
  </tr>
<tr align="center">
<td width="25%" class="tablerowhighlight">企业主页起始ID</td>
<td width="25%" class="tablerowhighlight">企业主页结束ID</td>
<td width="25%" class="tablerowhighlight">每轮生成企业首页数目</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform1" action="?mod=yp&file=updateurls">
<input type="hidden" name="action" value="CompanyIndexHtml" id="action">
<input type="hidden" name="label" value="article" id="label">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$mincompanyid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxcompanyid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成首页'>&nbsp;&nbsp;<input type="submit" onclick="$('action').value='company';" value="更新地址" ></td>
  </tr>
</form>
</table>

<BR>
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
<form method="post" name="myform1" action="?mod=<?=$mod?>&file=<?=$file?>">
<input type="hidden" name="action" value="show" id="action">
<input type="hidden" name="label" value="article" id="label">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minarticleid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxarticleid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成新闻'>&nbsp;&nbsp;<input type="submit" onclick="$('action').value='url';" value="更新地址" ></td>
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
<form method="post" name="myform2" action="?mod=<?=$mod?>&file=<?=$file?>">
<input type="hidden" name="action" value="show" id="action1">
<input type="hidden" name="label" value="product" id="label">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minproductid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxproductid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成产品'>&nbsp;&nbsp;<input type="submit" onclick="$('action1').value='url';" value="更新地址" ></td>
  </tr>
</form>
</table>
<BR>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="4">更新求购信息</th>
  </tr>
<tr align="center">
<td width="25%" class="tablerowhighlight">求购起始ID</td>
<td width="25%" class="tablerowhighlight">求购结束ID</td>
<td width="25%" class="tablerowhighlight">每轮生成求购数</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform2" action="?mod=<?=$mod?>&file=<?=$file?>">
<input type="hidden" name="action" value="show" id="action2">
<input type="hidden" name="label" value="buy" id="label">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minbuyid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxbuyid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成求购'>&nbsp;&nbsp;<input type="submit" onclick="$('action2').value='url';" value="更新地址" ></td>
  </tr>
</form>
</table>
<BR>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="4">更新促销信息</th>
  </tr>
<tr align="center">
<td width="25%" class="tablerowhighlight">促销起始ID</td>
<td width="25%" class="tablerowhighlight">促销结束ID</td>
<td width="25%" class="tablerowhighlight">每轮生成促销数</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform2" action="?mod=<?=$mod?>&file=<?=$file?>">
<input type="hidden" name="action" value="show" id="action3">
<input type="hidden" name="label" value="sales" id="label">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minsalesid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxsalesid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成促销'>&nbsp;&nbsp;<input type="submit" onclick="$('action3').value='url';" value="更新地址" ></td>
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
<form method="post" name="myform3" action="?mod=<?=$mod?>&file=<?=$file?>">
<input type="hidden" name="action" value="show" id="action3">
<input type="hidden" name="label" value="job" id="label">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minjobid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxjobid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成招聘'>&nbsp;&nbsp;<input type="submit" onclick="$('action3').value='url';" value="更新地址" ></td>
  </tr>
</form>
</table>

</body>
</html>