<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=listorder&keyid=<?=$keyid?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6>专题管理</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">排序</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="80%" class="tablerowhighlight">专题信息</td>
<td width="10%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($specials)){
	foreach($specials as $special){
?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="text" name="listorder[<?=$special['specialid']?>]" value="<?=$special['listorder']?>" size="3"></td>
<td><?=$special['specialid']?></td>
<td align="left">
<a href="<?=$special['linkurl']?>" target="_blank"><img src="<?=imgurl($special['specialpic'])?>" width="146" height="112" border="0" align="left"></a>
·<a href="?mod=<?=$module?>&file=special&action=manage&channelid=<?=$channelid?>&specialid=<?=$special['specialid']?>"><span style="<?=$special['style']?>"><?=$special['specialname']?></span></a> [<?=date('Y-m-d',$special['addtime'])?>]  [<a href="?mod=<?=$module?>&file=special&action=manage&channelid=<?=$channelid?>&specialid=<?=$special['specialid']?>"><font color="red">管理</font></a>] [<a href="<?=$special['linkurl']?>" target="_blank"><font color="blue">查看</font></a>]<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<?=str_cut($special['introduce'],250)?>
</td>
<td> 
<span style="height:22"><a href='?mod=<?=$mod?>&keyid=<?=$keyid?>&file=special&action=edit&specialid=<?=$special['specialid']?>'>修改</a></span><br/> 
<span style="height:22">
<?php if($special['elite']){ ?>
<a href='?mod=<?=$mod?>&keyid=<?=$keyid?>&file=special&action=elite&value=0&specialid=<?=$special['specialid']?>'><font color="red">取消</font></a></span><br/>
<?php }else{ ?>
<a href='?mod=<?=$mod?>&keyid=<?=$keyid?>&file=special&action=elite&value=1&specialid=<?=$special['specialid']?>'>推荐</a></span><br/>
<?php } ?>  
<span style="height:22">
<?php if($special['closed']){?>
<a href='?mod=<?=$mod?>&file=<?=$file?>&action=close&keyid=<?=$keyid?>&value=0&specialid=<?=$special['specialid']?>'><font color="blue">解锁</font></a></span><br/>
<?php }else{ ?>
<a href='?mod=<?=$mod?>&file=<?=$file?>&action=close&keyid=<?=$keyid?>&value=1&specialid=<?=$special['specialid']?>'>锁定</a></span><br/>
<?php } ?> 
<span style="height:22">
<a href='?mod=<?=$mod?>&keyid=<?=$keyid?>&file=special&action=recycle&specialid=<?=$special['specialid']?>'>清空</a></span><br/>
<span style="height:22">
<a href="javascript:confirmurl('?mod=<?=$mod?>&keyid=<?=$keyid?>&file=special&action=delete&specialid=<?=$special['specialid']?>','确认删除吗？')">删除</a></span>
</td>
</tr>
<?php 
	}
}
?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td><input type="submit" name="dosubmit" value=" 排序 "></td>
  </tr>
</table>
</form>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>
</body>
</html>