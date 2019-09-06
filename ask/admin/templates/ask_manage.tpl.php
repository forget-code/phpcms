<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<?=$menu?>
 <form method="get" name="search" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>查询问题</caption> 
  <tr>
    <td class="align_c" width="20%">
		用户名：<input type="text" name="username" value="<?=$username?>" />
	</td>	
	<td width="30%">
	标题：<input type="text" name="keywords" value="<?=$keywords?>" />&nbsp;
		<input type="submit" name="search" value=" 搜索 ">		
	</td>
	<td>
	<?=form::select_category($mod, 0, 'category[parentid]', 'parentid', '请选择栏目进行管理', $catid,"onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&action=$action&job=$job&elite=$elite&catid='+this.value;}\"")?>
	</td>
  </tr> 
</table>
 </form>
<form method="post" name="myform" action="?mod=<?=$mod?>&file=<?=$file?>&action=delete">
<table width="100%" cellpadding="3" cellspacing="1"  class="table_list">
<caption>管理问题</caption>
	<tr>
		<th>选</th>
		<th>ID</th>
		<th>所有类别</th>
		<th>标题</th>
		<th>作者</th>
		<th>提问时间</th>
		<th>悬赏</th>
		<th>回复数</th>
		<th>状态</th>
		<th>管理操作</th>
	</tr>
<?php
	foreach ($infos as $info) {
?>
		<tr>
		   <td  valign="middle"><input type="checkbox" name="id[]"  id="checkbox" value="<?=$info['askid']?>" ></td>
			<td class="align_c"><?=$info['askid']?></td>
			<td class="align_c"><a href="<?=$CATEGORY[$info['catid']]['url']?>" target="_blank"><?=$CATEGORY[$info['catid']]['catname']?></a></td>
			<td class="align_left" width="40%"><a href="<?=$M['url']?>show.php?id=<?=$info['askid']?>" target="_blank"><?=$info['title']?></a><?php if($info['flag']==3) echo "<sup>荐</sup>";?></td>
			<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></a></td>
			<td class="align_c"><?=date('m-d H:i',$info['addtime'])?></td>
			<td class="align_c"><?=$info['reward']?></td>
			<td class="align_c"><?=$info['answercount']?></td>
			<td class="align_c"><?php if($info['status']==3) echo "<font color=#009900>待解决</font>";else if($info['status']==5) echo "<font color=#FF9900>已解决</font>";else if($info['status']==6) echo "<font color=#3300FF>已关闭</font>";?></td>
			<td class="align_c">
			<a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&id=<?=$info['askid']?>">查看</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=delete&id=<?=$info['askid']?>" onclick="return confirm('您确定要删除此项吗？')">删除</a>
			</td>
		</tr>
<?php
}
?>
</tbody>
</table>
<div class="button_box">
<input name='chkall' id="chkall" type='button' onclick="checkall()" value='全部选中'>
<input type="hidden" name="dosubmit" value="submitted">
<input type='submit' value='推荐问题' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&flag=1'">
<input type='submit' value='取消推荐' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=elite&flag=0'">
<input type="submit" name="dosubmit" value="删除选定"  onclick="return confirm('您确定要删除吗？')">
<input type='submit' value='移动问题' onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=move'">
</div>
</form>
<div id="pages"><?=$ask->pages?></div>
</body>
</html>