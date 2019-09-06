<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding='2' cellspacing='1' border='0' align='center' class='tableBorder'>
  <tr>
    <td class='pagemenu' align="center"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" class='pagelink'>所有会员</a>
<?php 
if(is_array($GROUP))
{
    foreach($GROUP as $gid=>$group)
	{
?>
	| <a href="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&groupid=<?=$gid?>" class='pagelink'><?=$group['groupname']?></a>
<?php 
	} 
}
?>
	</td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<form method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="12">会员管理</th>
  </tr>
<tr align="center">
<td width="5%" class="tablerowhighlight">选中</td>
<td width="12%" class="tablerowhighlight">用户名</td>
<td width="10%" class="tablerowhighlight">用户组</td>
<td width="7%" class="tablerowhighlight">资金</td>
<td width="7%" class="tablerowhighlight">消费</td>
<td width="7%" class="tablerowhighlight">积分</td>
<td width="8%" class="tablerowhighlight">计费方式</td>
<td width="7%" class="tablerowhighlight">点数</td>
<td width="7%" class="tablerowhighlight">有效期</td>
<td width="10%" class="tablerowhighlight">最后登录</td>
<td width="10%" class="tablerowhighlight">介绍人</td>
<td width="*" class="tablerowhighlight">管理操作</td>
</tr>
<?php 
if(is_array($members))
{
foreach($members as $member){ ?>
<tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td><input type="checkbox" name="userid[]"  id="userid[]" value="<?=$member['userid']?>" <?=($member['userid'] == $_userid ? 'disabled' : '')?>></td>
<td onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=view&userid=<?=$member['userid']?>&forward=<?=urlencode($PHP_URL)?>'"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&userid=<?=$member['userid']?>" title="点击查看会员资料&#10ID:<?=$member['userid']?>&#10最后登录时间：<?=$member['lastlogintime']?>&#10最后登录IP：<?=$member['lastloginip']?>&#10登录次数：<?=$member['logintimes']?>"><?=$member['username']?></a></td>
<td><?=$GROUP[$member['groupid']]['groupname']?></td>
<td><?=$member['money']?>元</td>
<td><?=$member['payment']?>元</td>
<td><?=$member['credit']?>分</td>
<td><?=($member['chargetype'] ? '<font color="blue">有效期</font>' : '<font color="red">扣点数</font>')?></td>
<td><?=$member['point']?>点</td>
<td><?=$member['validdatenum']?></td>
<td title="最后登录IP：<?=$member['lastloginip']?>&#10登录次数：<?=$member['logintimes']?>"><?=$member['lastlogintime']?></td>
<td><?=$member['introducer']?></td>
<td align="center">
<a href="?mod=<?=$mod?>&file=member&action=note&userid=<?=$member['userid']?>" title="关于该会员的管理笔记都记在这里">备注</a> | 
<a href="?mod=<?=$mod?>&file=member&action=edit&userid=<?=$member['userid']?>">修改</a>
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
<input type="submit" name="submit1" value="批量锁定" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=1'">&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit2" value="批量解锁" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=0'">&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit3" value="批量移动" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=move'">&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit4" value="批量删除" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete'">&nbsp;&nbsp;
</td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="30">
  <tr>
    <td align="center"><?=$pages?></td>
  </tr>
</table>
</form>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=8>会员搜索</th>
  </tr>
<form method="get" name="search" action="?">
<tr>
<td align="center" width="8%" class="tablerowhighlight">用户名</td>
<td width="12%" class="tablerow"><input name='username' type='text' size='12' value='<?=$username?>'></td>
<td align="center" width="8%" class="tablerowhighlight">真实姓名</td>
<td width="12%" class="tablerow"><input name='truename' type='text' size='12' value='<?=$truename?>'></td>
<td align="center" width="8%" class="tablerowhighlight">用户组</td>
<td width="15%" class="tablerow"><?=$groupids?></td>
<td align="center" width="8%" class="tablerowhighlight">会员状态</td>
<td width="*" class="tablerow">
<select name='locked'>
<option value='-1'>不限</option>
<option value='0'>正常</option>
<option value='1'>锁定</option>
</select>
<input name='mod' type='hidden' value='<?=$mod?>'>
<input name='file' type='hidden' value='<?=$file?>'>
<input name='action' type='hidden' value='<?=$action?>'>
<input name='submit' type='submit' value=' 搜索 '>
</td>
</tr>
</form>
</table>
</body>
</html>
