<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>待审核会员列表</caption>
<tr>
<th width="5%">选中</th>
<th width="5%">ID</th>
<th width="12%">用户名</th>
<th width="15%">所在地区</th>
<th width="12%"><a href="<?=($orderby=='i.regtime ASC')? url_par("orderby=i.regtime DESC") : url_par("orderby=i.regtime ASC")?>" title="按注册时间排序">注册时间</a></th>
<th width="10%">注册IP</th>
<th width="15%">管理操作</th>
</tr>
<?php 
if(is_array($members))
{
    foreach($members as $member){ ?>
<tr>
    <td class="align_c"><input type="checkbox" name="userid[]"  id="checkbox" value="<?=$member['userid']?>"></td>
    <td class="align_c"><?=$member['userid']?></td>
    <td class="align_c"><a href="<?=$MOD['url']?>member.php?action=show&username=<?=urlencode($member['username'])?>" target="_blank"><?=$member['username']?></a></td>
    <td class="align_c"><?=$ARAE[$member['areaid']]['name']?></td>
    <td class="align_c"><?=date('Y-m-d H:i', $member['regtime'])?></td>
    <td class="align_c"><?=$member['regip']?></td>
    <td class="align_c">
    <a href='?mod=<?=$mod?>&file=member&action=view&userid=<?=$member['userid']?>' title="点击查看会员资料&#10最后登录时间：<?=$member['lastlogintime']?>&#10最后登录IP：<?=$member['lastloginip']?>&#10登录次数：<?=$member['logintimes']?>">查看</a> | 
    <a href='?mod=<?=$mod?>&file=member&action=note&userid=<?=$member['userid']?>' title="关于该会员的管理笔记都记在这里">备注</a> | 
    <a href='?mod=<?=$mod?>&file=member&action=edit&userid=<?=$member['userid']?>'>修改</a>
    </td>
</tr>
<?php } 
}
?>
</table>
<div class="button_box"
		<input name='button2' type='button' class="button_style" id='chkall' onclick='checkall();' value='全选'>
		<input type="submit" name="dosubmit" value="批量批准" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=check&dosubmit=1'">&nbsp;&nbsp;
		<input type="submit" name="dosubmit" value="批量删除" onClick="if(confirm('确认批量删除这些用户吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&dosubmit=1'">&nbsp;&nbsp;
</div>
<div id="pages"><?=$pages?></div>
</form>
</body>
</html>
