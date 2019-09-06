<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：房产首页 &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=tohtml">发布网页</a> </td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>


<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=4>更新房产信息html（包括<?php foreach($INFOtype as $v) echo $v.",";?>等的更新）</th>
  </tr>
<tr align="center">
<td width="25%" class="tablerowhighlight">房产信息起始ID</td>
<td width="25%" class="tablerowhighlight">房产信息结束ID</td>
<td width="20%" class="tablerowhighlight">每轮生成html数</td>
<td width="30%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform2" action="?mod=<?=$mod?>&file=<?=$file?>">
<input type="hidden" name="action" value="showinfo" id="action">
  <tr align="center">
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minhouseid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxhouseid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value='生成房产html页'>&nbsp;&nbsp;<input type="submit" onclick="$('action').value='urlinfo';" value="更新地址" >
</td>
  </tr>
</form>
</table>
<br />


<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="3">更新房产信息列表html（包括<?php foreach($INFOtype as $v) echo $v.",";?>等的更新）</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">选择</td>
<td width="40%" class="tablerowhighlight">名称</td>
<td width="50%" class="tablerowhighlight">管理操作</td>
</tr>
<?php foreach($CAT as $i=>$c) { ?>
<tr align="center">
    <td class="tablerow"><input type='checkbox' name='infocats[]' value='<?=$i?>'></td>
    <td class="tablerow"><a href="<?=$c['linkurl']?>" target="_blank"><?=$c['name']?></a></td>
    <td class="tablerow"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=listinfo&infocat=<?=$i?>">生成列表</a></td>
</tr>
<?php } ?>

  <tr>
    <td class="tablerow"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td class="tablerow" colspan="2">&nbsp;&nbsp;
	<input type="submit" name="submit1" value="生成列表" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=listinfos'">
  </td>
  </tr>
</form>

</table>
<br />

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=4>更新新楼盘html</th>
  </tr>
  <tr align="center">
    <td width="25%" class="tablerowhighlight">新楼盘起始ID</td>
    <td width="25%" class="tablerowhighlight">新楼盘结束ID</td>
    <td width="20%" class="tablerowhighlight">每轮生成html数</td>
    <td width="30%" class="tablerowhighlight">管理操作</td>
  </tr>
  <form method="post" name="myform3" action="?mod=<?=$mod?>&file=<?=$file?>">
  <input type="hidden" name="action" value="newhouse" id="house_action">
    <tr align="center">
      <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$mindisplayid?>"></td>
      <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxdisplayid?>"></td>
      <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
      <td class="tablerow"><input name='submit' type='submit' value='生成楼盘html页'>&nbsp;&nbsp;<input type="submit" onclick="$('house_action').value='urlhouse';" value="更新地址" ></td>
    </tr>
  </form>
</table>
<br/>

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan="3">更新新楼盘信息列表html</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">选择</td>
<td width="40%" class="tablerowhighlight">名称</td>
<td width="50%" class="tablerowhighlight">管理操作</td>
</tr>
<tr align="center">
    <td class="tablerow">-</td>
    <td class="tablerow"><a href="<?=$MOD['display_list_url']?>" target="_blank">新楼盘</a></td>
    <td class="tablerow"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=listdisplay">生成列表</a></td>
</tr>
</table>
<br />

<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th>提示信息</th>
  </tr>
  <tr>
    <td class="tablerow">
如果你更换服务器空间或者更换了模板，希望所有网页重新生成，请依次重新生成所有html
	</td>
  </tr>
</table>
</body>
</html>