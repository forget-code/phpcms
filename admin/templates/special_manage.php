<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=5>专题管理</th>
  </tr>
<tr align=center>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="20%" class="tablerowhighlight">专题名称</td>
<td width="20%" class="tablerowhighlight">专题图片</td>
<td width="25%" class="tablerowhighlight">专题说明</td>
<td width="30%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($specials)){
	foreach($specials as $special){
?>
<tr align=center onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td class=forumrow ><?=$special['specialid']?></td>
<td class=forumrow  align=left><a href='<?=$special['url']?>' target='_blank'><?=$special[specialname]?></a></td>
<td class=forumrow><a href='<?=$special['url']?>' target='_blank'><img src="<?=$special[specialpic]?>" width="146" height="112" border="0"></a></td>
<td align="left" class=forumrow><a href='<?=$special['url']?>' target='_blank'><?=$special[introduce]?></a></td>
<td class=forumrow> 
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=special&action=edit&specialid=<?=$special[specialid]?>'>修改</a> | 
<?php if($special[elite]){ ?>
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=special&action=elite&value=0&specialid=<?=$special[specialid]?>'>取消</a>
<?php }else{ ?>
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=special&action=elite&value=1&specialid=<?=$special[specialid]?>'>推荐</a>
<?php } ?> | 
<?php if($special[closed]){?>
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=special&action=close&value=0&specialid=<?=$special[specialid]?>'>解锁</a>
<?php }else{ ?>
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=special&action=close&value=1&specialid=<?=$special[specialid]?>'>锁定</a>
<?php } ?> | 
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=special&action=delete&specialid=<?=$special[specialid]?>'>删除</a> | 
<a href='?mod=<?=$mod?>&channelid=<?=$channelid?>&file=special&action=recycle&specialid=<?=$special[specialid]?>'>清空</a>
</td>
</tr>
<?php 
	}
}
?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>
</body>
</html>