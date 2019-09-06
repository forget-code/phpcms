<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<?=$menu?>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=update">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption><?=$roleid ? $ROLE[$roleid] : '管理员'?> 列表</caption>
<tr>
    <th width="5%"><strong>ID</strong></th>
    <th width="10%"><strong>用户名</strong></th>
    <th width="15%"><strong>所属角色</strong></th>
    <th width="18%"><strong>最后登录IP</strong></th>
    <th width="15%"><strong>最后登录时间</strong></th>
    <th width="8%"><strong>登录次数</strong></th>
    <th><strong>管理操作</strong></th>
</tr>
<?php
if(is_array($admins))
{
	foreach($admins as $admin)
    {
?>
<tr>
    <td class="align_c"><?=$admin['userid']?></td>
    <td class="align_c"><a href="<?=member_view_url($admin['userid'])?>"><?=$admin['username']?></a></td>
    <td class="align_c"><?=$admin['roles']?></td>
    <td class="align_c"><a href='<?=ip_url($admin['lastloginip'])?>'><?=$admin['lastloginip']?></a></td>
    <td class="align_c"><?=$admin['lastlogintime'] ? date('Y-m-d H:i', $admin['lastlogintime']) : ''?></td>
    <td class="align_c"><?=$admin['logintimes']?></td>
    <td class="align_c">
    <a href='?mod=<?=$mod?>&file=<?=$file?>&action=view&userid=<?=$admin['userid']?>'>查看</a> | 
    <?php
	$admin_founders = explode(',',ADMIN_FOUNDERS);
	if(!in_array(1, $admin['roleids']) || !in_array($admin['userid'],$admin_founders)) { ?>
        <a href='?mod=<?=$mod?>&file=<?=$file?>&action=edit&userid=<?=$admin['userid']?>'>修改</a> | 
        <?php if($admin['disabled']){ ?>
        <a href='?mod=<?=$mod?>&file=<?=$file?>&action=disable&userid=<?=$admin['userid']?>&disabled=0'><font color="red">解锁</font></a> | 
        <?php }else{ ?>
        <a href='?mod=<?=$mod?>&file=<?=$file?>&action=disable&userid=<?=$admin['userid']?>&disabled=1'>锁定</a> | 
        <?php } ?>
        <a href="javascript:confirmurl('?mod=phpcms&file=admin&action=delete&userid=<?=$admin['userid']?>', '你确认撤销管理员“<?=$admin['username']?>”吗？');">撤消</a>
    <?php }else{ ?>
    <font color="#cccccc">修改 | 锁定 | 撤消</font>
    <?php } ?>
	 | <a href='?mod=phpcms&file=log&action=manage&userid=<?=$admin['userid']?>'>日志</a>
    </td>
</tr>
<?php 
	}
}
?>
</table>
</form>
<div id="pages"><?=$a->pages?></div>
</body>
</html>