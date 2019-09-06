<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<?=$menu?>
<script language="javascript">
<!--

function update(jobid)
{
	var checkurl = '<?=$SITEURL?>/yp/admin.php';
	var pars = "file=<?=$file?>&action=update&jobid="+jobid;
	var myAjax = new Ajax.Request(checkurl, {method: 'post', parameters: pars, onComplete: alertmessage});
}

function alertmessage(Request)
{
	alert('更新成功');
	window.location.reload();
}

//-->
</script>
<form action="" method="post" name="myform" >
<table width="100%"  border="0" cellpadding="2" cellspacing="1" class="tableborder">
<th colspan=7>招聘信息管理</th>
<tr align="center">
<td width="30" class="tablerowhighlight">选中</td>
<td width="40" class="tablerowhighlight">ID</td>
<td width="150" class="tablerowhighlight">所属岗位</td>
<td class="tablerowhighlight">标题</td>
<td width="80" class="tablerowhighlight">发表时间</td>
<td width="40" class="tablerowhighlight">点击</td>
<td width="70" class="tablerowhighlight">管理操作</td>
</tr>
<? if(is_array($jobs)) foreach($jobs AS $job) { ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'"  onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5' title="招聘信息ID:<?=$job['jobid']?>&#10;添加时间:<?=$job['addtime']?>&#10;审核:<?=$job['checker']?>&#10;审核时间:<?=$job['checktime']?>&#10;编辑:<?=$job['editor']?>&#10;编辑时间:<?=$job['edittime']?>" ondblclick="$('job_<?=$job['jobid']; ?>').checked = ($('job_<?=$job['jobid']; ?>').checked ? false : true);">

<td><input name="jobid[]" type="checkbox" value="<?=$job['jobid']?>" id="job_<?=$job['jobid']?>"></td>

<td><?=$job['jobid']?></td>
<td><?=$job['station']?></td>

<td align="left"><a href="<?=$job['linkurl']?>" target="_blank"><span style="<?=$job['style']?>"><?=$job['title']?></span></a>
</td>

<td><?=$job['addtime']?></td>
<td><?=$job['hits']?></td>
<td>
<a href="?file=<?=$file?>&action=edit&jobid=<?=$job['jobid']?>" title="编辑招聘信息">编辑</a> | 
<a href="javascript:update(<?=$job['jobid']?>);" title="刷新招聘信息，将企业招聘信息排到前面">刷新</a>
</td>
</tr>
<? } ?>
</table>

<table width="100%" align="center" cellpadding="2" cellspacing="1" >
   <tr>
    <td width="100"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check'>全选/反选</td>
    <td>
	<?php
	if($status==-1)
	{?>
		<input type='submit' value='删除招聘信息' onClick="document.myform.action='?file=<?=$file?>&action=delete'">
	<?php } else {?>
		<input type='submit' value='删除招聘信息' onClick="document.myform.action='?file=<?=$file?>&action=status&status=-1'">
		<?php
		}
		?>
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


</body>
</html>
