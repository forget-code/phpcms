<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<table cellpadding="3" cellspacing="1" class="table_list">
	<tr>
		<th colspan="10">问题管理</th>
	</tr>
	<tr>
		<th>选</td>
		<th>ID</td>
		<th>所有类别</td>
		<th class="align_left">标题</td>
		<th>作者</td>
		<th>提问时间</td>
		<th>悬赏</td>
		<th>状态</td>
		<th>管理操作</td>
	</tr>
		<form method="post" name="myform"  action="?mod=<?=$mod?>&file=<?=$file?>&action=delete">
<?php
	foreach ($infos as $info) {
?>
		<tr align="center" bgColor='#F1F3F5'>
		  <td class="align_c"><input type="checkbox" name="id[]"  id="checkbox" value="<?=$info['askid']?>"></td>
			<td class="align_c"><?=$info['askid']?></td>
			<td class="align_c"><?=$CATEGORY[$info['catid']]['catname']?></td>
			<td class="align_c"><a href="<?=$M['url']?>show.php?id=<?=$info['askid']?>" target="_blank"><?=$info['title']?></a></td>
			<td class="align_c"><?=$info['username']?></td>
			<td class="align_c"><?=date('m-d H:i',$info['addtime'])?></td>
			<td class="align_c"><?=$info['reward']?></td>
			<td class="align_c">待审核</td>
			<td class="align_c">
			<a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&id=<?=$info['askid']?>">查看</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&id=<?=$info['askid']?>" onclick="return confirm('您确定要删除此项吗？')">删除</a>
			</td>
		</tr>
<?php
}
?>		
</tbody>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td width="100%" align="left" height="40" valign="middle" colspan="8"><input name='chkall' id="chkall" type='button' onclick="checkall()" value='全部选中'>
		<input type="hidden" name="dosubmit" value="submitted">
		<input type="submit" name="dosubmit" value="删除选定" onclick="return confirm('您确定要删除吗？')">
		<input type='submit' value='通过审核' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=check'">
		<input type='submit' value='移动问题' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=move'">
		</td>
	</tr>
</table>
</form>
<div id="pages"><?=$ask->pages?></div>
</body>
</html>