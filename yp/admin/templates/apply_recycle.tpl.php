<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage">企业求职首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&apply=manage">管理求职</a>  </td>
	</td>
  </tr>
</table>
<form action="" method="post" name="myform" >
<BR>
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=10>求职管理</th>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="120" class="tablerowhighlight">欲从事岗位</td>
<td width="100" class="tablerowhighlight">求职者</td>
<td class="tablerowhighlight">毕业学校</td>
<td class="tablerowhighlight">所学专业</td>
<td width="40" class="tablerowhighlight">性质</td>
<td width="40" class="tablerowhighlight">学历</td>
<td width="80" class="tablerowhighlight">毕业时间</td>
<td width="70" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($applys)) foreach($applys AS $apply) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' ondblclick="$('apply_<?=$apply['applyid']; ?>').checked = ($('apply_<?=$apply['applyid']; ?>').checked ? false : true);">

<td><input name="applyid[]" type="checkbox" value="<?=$apply['applyid']?>" id="apply_<?=$apply['applyid']?>"></td>
<td><?=$apply['applyid']?></td>
<td><?=$apply['station']?></td>

<td><a href="<?=$apply['linkurl']?>" target="_blank" ><?=$apply['truename']?></a>
<?php if($apply['status']==5) { ?> <font color="blue">荐</font><?php } ?>
</td>

<td><a href="<?=$apply['domain']?>" target="_blank" alt="信息发布企业：<?=$apply['companyname']?>&#10;&nbsp;&nbsp;作者：<font color='#ff0000'><?=$apply['username']?></font>&nbsp;&nbsp;添加时间：<font color='#ff0000'><?=$apply['addtime']?></font>&#10;&nbsp;&nbsp;编辑：<?=$apply['editor']?>&nbsp;&nbsp;编辑时间：<?=$apply['edittime']?> &#10;"><?=$apply['school']?></a></td>
<td><?=$apply['specialty']?></td>
<td><?=$apply['worktype']?></td>
<td><?=$apply['edulevel']?></td>
<td><?=$apply['graduatetime']?></td>
<td>
<input name='listorder[<?=$apply['applyid']?>]' type='hidden' value='' />
<a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&applyid=<?=$apply['applyid']?>" title="编辑求职">编辑</a>
</td>
</tr>
<? } ?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1">
   <tr>
    <td width="100"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
	<input type='submit' value='清空回收站' onClick="if(confirm('确认批量删除所有回收站的求职信息吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=truncate'">
	<input type='submit' value='还原求职信息' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=3'">
	<input type='submit' value='删除求职信息' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">
</td>
  </tr>
</table>
</form>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
</form>
<br />
<table width="100%" cellpadding="0" cellspacing="0" class="tableborder">
<form method="get" name="search" action="?">
  <tr>
    <td height="30" class="tablerow" align="center">
	<input name='mod' type='hidden' value='<?=$mod?>'>
	<input name='file' type='hidden' value='<?=$file?>'>
	<input name='action' type='hidden' value='<?=$action?>'>
	<select name="srchtype">
	<option value="1" <?if($srchtype==1){?>selected<?}?>>按毕业学校</option>
	<option value="2" <?if($srchtype==2){?>selected<?}?>>按所学专业</option>
	<option value="3" <?if($srchtype==3){?>selected<?}?>>按学历</option>
	</select>
	<input name='keyword' type='text' size='20' value='<?if(isset($keyword)){echo $keyword;}?>' onclick="this.value='';" title="关键词...">&nbsp;

	<input name='pagesize' type='text' size='3' value='<?if(isset($pagesize)){echo $pagesize;}?>' title="每页显示的数据数目,最大值为500" maxlength="3"> 条数据/页
	<input type='submit' value=' 搜索 '></td>
  </tr>
</form>
</table>

</body>
</html>
