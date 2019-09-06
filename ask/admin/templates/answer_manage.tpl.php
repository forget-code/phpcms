<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
<form method="post" name="search" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>答案查询</caption>  
  <tr>
    <td width="20%">
		问题ID：<input type="text" name="askid" value="<?=$askid?>">
	</td>
	<td>
		回答者：<input type="text" name="username" value="<?=$username?>">
	<input type="hidden" name="job" value="<?=$job?>">
	<input type="submit" name="search" value=" 搜索 ">
	</td>
  </tr> 
</table>
</form>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=delete">
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>管理问题答案</caption>
	<tr>
		<th>选</td>
		<th>ID</td>
		<th>问题ID</td>
		<th width="50%">回复内容摘要</th>
		<th>回答者</td>
		<th>回答时间</td>
		<th>状态</td>
		<th>管理操作</td>
	</tr>
<?php
	foreach ($infos as $info) {
?>
		<tr>
		   <td><input type="checkbox" name="id[]"  id="checkbox" value="<?=$info['pid']?>"></td>
			<td class="align_c"><?=$info['pid']?></td>
			<td class="align_c"><?=$info['askid']?></td>
			<td class="align_left"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&id=<?=$info['pid']?>"><?=str_cut($info['message'],150)?></a></td>
			<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></a></td>
			<td class="align_c"><?=date('m-d H:i',$info['addtime'])?></td>
			<td class="align_c"><?php if($info['optimal']) echo "<font color=#009900>已采纳</font>";else echo '未采纳';?></td>
			<td class="align_c"><a href="?mod=<?=$mod?>&file=ask&action=view&id=<?=$info['askid']?>">原帖</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&id=<?=$info['pid']?>" onclick="return confirm('您确定要删除此项吗？')">删除</a>
			</td>
		</tr>
<?php
}
?>
</tbody>
</table>
<div class="button_box">
<input name='chkall' id="chkall" type='button' onclick='checkall();' value='全选'>&nbsp;<input type="hidden" name="dosubmit" value="submitted">
<input type="submit" name="dosubmit" value="删除选定" onclick="return confirm('您确定要删除吗？')">
<?php if(isset($job)){ ?>
<input type='submit' value='通过审核' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=check'">
<?php }?>
</div>
</form>
<div id="pages"><?=$answer->pages?></div>
</body>
</html>