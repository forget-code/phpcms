<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<body>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">企业管理首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&channelid=<?=$channelid?>">管理企业</a>  </td>
    <td class="tablerow" align="right"><?php echo $type_jump; ?><?php echo $category_jump; ?>
	</td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan=9>审核企业</th>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="40" class="tablerowhighlight">排序</td>
<td class="tablerowhighlight">所属分类</td>
<td class="tablerowhighlight">企业名称</td>
<td width="90" class="tablerowhighlight">用户名</td>
<td width="80" class="tablerowhighlight">加入时间</td>
<td width="50" class="tablerowhighlight">点击</td>
<td width="70" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($companys)) foreach($companys AS $company) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' ondblclick="$('company_<?=$company['companyid']; ?>').checked = ($('company_<?=$company['companyid']; ?>').checked ? false : true);">

<td><input name="companyid[]" type="checkbox" value="<?=$company['companyid']?>" id="company_<?=$company['companyid']?>"></td>

<td><?=$company['companyid']?></td>
<td><input name='listorder[<?=$company['companyid']?>]' type='input' value='<?=$company['listorder']?>' size="3" /></td>
<td><?=$TRADE[$company['tradeid']]['tradename']?></td>
<td><a href="<?=$company['linkurl']?>" target="_blank"><?=$company['companyname']?></a> <?php if($company['elite']) echo '<font color="green">荐</font>'; ?></td>
<td title="查看会员资料"><a href="?mod=member&file=member&action=view&username=<?=$company['username']?>"><?=$company['username']?></a></td>
<td title="审核:<?=$company['checker']?>&#10;审核时间:<?=$company['checktime']?>&#10;编辑:<?=$company['editor']?>&#10;编辑时间:<?=$company['edittime']?>" ><?=$company['addtime']?></td>
<td><?=$company['hits']?></td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&companyid=<?=$company['companyid']?>">编辑</a></td>
</tr>
<?php
}
?>
</table>


<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0" >
<tr>
    <td><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
	<input type='submit' value='通过审核' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=3'" >&nbsp;		
	<input type='submit' value='推荐企业' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&elite=1'" >&nbsp;
	<input type='submit' value='取消推荐' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&elite=0'" >&nbsp;
	<input type='submit' value='删除企业' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=status&status=-1'">&nbsp;
    <input type='submit' value='移动企业' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=move&movetype=1'">
  
	</td>
  </tr>
</table>
</form>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align='center'><?=$pages?></td>
  </tr>
</table>
<br />
<table width="100%" cellpadding="0" cellspacing="0" class="tableborder">
<form method="get" name="search" action="?">
  <tr>
    <td height="30" class="tablerow" align="center">
	<input name='mod' type='hidden' value='<?=$mod?>'>
	<input name='file' type='hidden' value='<?=$file?>'>
	<input name='action' type='hidden' value='<?=$action?>'>
	<input name='job' type='hidden' value='<?=$job?>'>
	<input name='catid' type='hidden' value='<?=$catid?>'>
	<select name="srchtype">
	<option value="0" <?if($srchtype==0){?>selected<?}?>> 按企业 </option>
	<option value="1" <?if($srchtype==1){?>selected<?}?>> 按会员 </option>
	</select>&nbsp;<input name='keyword' type='text' size='20' value='<?if(isset($keyword)){echo $keyword;}?>' onclick="this.value='';" title="关键词...">&nbsp;
	<?php echo $category_select; ?>
	<?php echo $type_select?>
	<input name='pagesize' type='text' size='3' value='<?if(isset($pagesize)){echo $pagesize;}?>' title="每页显示的数据数目,最大值为500" maxlength="3"> 条数据/页
	<input type='submit' value=' 搜索 '></td>
  </tr>
</form>
</table>
</body>
</html>