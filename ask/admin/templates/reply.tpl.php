<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>查看咨询</th>
  </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="left">咨询主题：[<?=$STATUS[$subject['status']]?>] <?=$subject['subject']?></td>
   </td>
    <tr> 
      <td class="tablerow" width="25%">
	<table cellpadding="2" cellspacing="1"  width="96%">
	<tr>
	<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($subject['username'])?>" target="_blank"><font color="blue"><strong><?=$subject['username']?></strong></font></a></td>
	</tr>
	<tr>
	<td><?=$subject['groupname']?><?=$subject['arrgroupname']?></td>
	</tr>
	<tr>
	<td>回复时间：<?=$subject['addtime']?></td>
	</tr>
	<tr>
	<td>IP：<?=$subject['ip']?> -- <?=$subject['iparea']['country']?></td>
	</tr>
	<tr>
	<td align="center"><?php if($subject['userface']){ ?><img src="<?=$subject['userface']?>"><?php } ?></td>
	</tr>
	</table>
      </td>
      <td class="tablerow" valign="top"><?=$subject['content']?></td>
    </tr>
<?php 
foreach($replys as $reply)
{
?>
    <tr> 
      <td class="tablerow">
	<table cellpadding="2" cellspacing="1"  width="96%">
	<tr>
	<td><a href="?mod=member&file=member&action=view&username=<?=urlencode($reply['username'])?>" target="_blank"><font color="blue"><strong><?=$reply['username']?></strong></font></a></td>
	</tr>
	<tr>
	<td><?=$reply['groupname']?><?=$reply['arrgroupname']?></td>
	</tr>
	<tr>
	<td>回复时间：<?=$reply['addtime']?></td>
	</tr>
	<tr>
	<td>IP：<?=$reply['ip']?> -- <?=$reply['iparea']['country']?></td>
	</tr>
	<tr>
	<td align="center"><?php if($reply['userface']){ ?><img src="<?=$reply['userface']?>"><?php } ?></td>
	</tr>
	</table>
	  </td>
      <td class="tablerow"  valign="top"><?=$reply['reply']?></td>
    </tr>
<?php
}
?>
</table>
<br />
<table cellpadding="2" cellspacing="1" class="tableborder">
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=status&askid=<?=$askid?>" method="post" name="status">
	<tr>
		<th>处理状态设置</th>
	</tr>
    <tr>
         <td class="tablerow" align="center">
		<input type='radio' name='status' value='0' <?=($subject['status'] == 0 ? 'checked' : '')?>> 未处理 &nbsp;&nbsp;&nbsp;&nbsp; 
		<input type='radio' name='status' value='1' <?=($subject['status'] == 1 ? 'checked' : '')?>> 处理中 &nbsp;&nbsp;&nbsp;&nbsp; 
		<input type='radio' name='status' value='2' <?=($subject['status'] == 2 ? 'checked' : '')?>> 已处理 &nbsp;&nbsp;&nbsp;&nbsp; 
		<input type='radio' name='status' value='3' <?=($subject['status'] == 3 ? 'checked' : '')?>> 拒绝处理 &nbsp;&nbsp;&nbsp;&nbsp; 
		<input type="submit" name="dosubmit" value=" 确定 "> 
		</td>
   </tr>
  </form>
</table>
<br />
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>咨询回复</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=reply&askid=<?=$askid?>" method="post" name="myform">
    <tr> 
      <td class="tablerow" width="25%">回复内容：</td>
      <td class="tablerow">
        <textarea name="reply"></textarea> <?=editor('reply', 'introduce', 550, 200)?>
   </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"><input type="submit" name="dosubmit" value=" 确定 "></td>
    </tr>
  </form>
</table>
</body>
</html>
