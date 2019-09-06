<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan='10'>待审核会员列表</th>
  </tr>
<tr align='center'>
<td width="5%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="12%" class="tablerowhighlight">帐号</td>
<td width="8%" class="tablerowhighlight">姓名</td>
<td width="5%" class="tablerowhighlight">性别</td>
<td width="15%" class="tablerowhighlight">所在地区</td>
<td width="13%" class="tablerowhighlight">E-mail</td>
<td width="12%" class="tablerowhighlight">注册时间</td>
<td width="10%" class="tablerowhighlight">注册IP</td>
<td width="15%" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($members))
{
    foreach($members as $member){ ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="userid[]"  id="userid[]" value="<?=$member['userid']?>"></td>
<td><?=$member['userid']?></td>
<td><a href="<?=$MOD['linkurl']?>member.php?action=show&username=<?=urlencode($member['username'])?>" target="_blank"><?=$member['username']?></a></td>
<td><?=$member['truename']?></td>
<td><?=$genders[$member['gender']]?></td>
<td><?=$member['province']?>-<?=$member['city']?></td>
<td><?=$member['email']?></td>
<td><?=date('Y-m-d', $member['regtime'])?></td>
<td><?=$member['regip']?></td>
<td align="center">
<a href='?mod=<?=$mod?>&file=member&action=view&userid=<?=$member['userid']?>' title="点击查看会员资料&#10最后登录时间：<?=$member['lastlogintime']?>&#10最后登录IP：<?=$member['lastloginip']?>&#10登录次数：<?=$member['logintimes']?>">查看</a> | 
<a href='?mod=<?=$mod?>&file=member&action=note&userid=<?=$member['userid']?>' title="关于该会员的管理笔记都记在这里">备注</a> | 
<a href='?mod=<?=$mod?>&file=member&action=edit&userid=<?=$member['userid']?>'>修改</a>
</td>
</tr>
<?php } 
}
?>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全选/反选</td>
    <td>
<input type="submit" name="submit" value="批量批准" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=check&dosubmit=1'">&nbsp;&nbsp;
<input type="submit" name="submit" value="批量删除" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">&nbsp;&nbsp;
</td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>
</form>
</body>
</html>
