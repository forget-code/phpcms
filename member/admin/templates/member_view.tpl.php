<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" class="table_info">
	<caption>相关操作</caption>
    <tr>
    	<td><input type="button" value="修改资料" onClick="location.href='?mod=member&file=member&action=edit&userid=<?=$userid?>&forward=<?=urlencode("?mod=member&file=member&action=view&userid=$userid")?>'" />&nbsp;<input type="button" value="修改模型" onClick="location.href='?mod=member&file=member&action=model_edit&modelid=<?=$modelid?>&userid=<?=$userid?>&forward=<?=urlencode("?mod=member&file=member&action=view&userid=$userid")?>'">
		<?php if(!in_array($userid, $arr_founder) || $userid != $_userid) 
			{
		?>
		&nbsp;<input type="button" value="修改会员组" onClick="location.href='?mod=member&file=member&action=move&userid=<?=$userid?>&forward=<?=urlencode("?mod=member&file=member&action=view&userid=$userid")?>'" />
		&nbsp;<input type="button" value="删除" onClick="javascript:confirmurl('?mod=member&file=member&action=delete&userid=<?=$userid?>', '是否删除该会员')" />&nbsp;<input type="button" value="<?=$disabled?'启用':'禁用'?>" onClick="location.href='?mod=member&file=member&action=lock&userid=<?=$userid?>&val=<?=$disabled?'0':'1'?>&forward=<?=urlencode("?mod=member&file=member&action=view&userid=$userid")?>'" /><?php
			}
		?>&nbsp;<input type="button" value="备注" onClick="location.href='?mod=member&file=member&action=note&userid=<?=$userid?>&forward=<?=urlencode("?mod=member&file=member&action=view&userid=$userid")?>'" />
        <?php if($groupid == 1) {?><input type="button" value="日志" onClick="location.href='?mod=phpcms&file=log&action=manage&userid=1'"><?php } ?>
    </tr>
    <tr>    	
    	<td>
    	<?php
			foreach($arr_menu as $menu)
			{
				if($menu[isfront])
				{
		?>
<input type="button" onClick="location.href='<?=$menu[url]?><?=($menu[key]=='userid') ? $userid : $username?>'" value="<?=$menu[name]?>" title="<?=$menu[name]?>">
    	<?php
				}
				else
				{
		?>
        		<input type="button" onClick="javascript:openwinx('<?=$menu[url]?><?=($menu[key]=='userid') ? $userid : $username?>','upload','650','550')" value="<?=$menu[name]?>" title="<?=$menu[name]?>">
		<?php
				}
			}
		?>
      </td>
    </tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption><?=$username?> 详细信息</caption>
  <tr>
    <th width="15%"><strong>用户名：</strong></th>
    <td width="30%"><?=$username?></td>
    <th width="15%"><strong>会员类型：</strong></th>
    <td width="30%"><?=$MODEL[$modelid][name]?></td>
    <td  class="align_c" rowspan="5" width="15%"><img src="<?=($avatar ? $avatar : 'images/nophoto.gif')?>" width="120" height="120" /></td>
  </tr>
  <tr>
    <th><strong>会员组：</strong></th>
    <td><?=$GROUP[$groupid]?></td>
	<th><strong>扩展会员组：</strong></th>
    <td>
	<?php
	foreach($arr_ext_group as $ext_group)
	{
	?>
	<?=$GROUP[$ext_group['groupid']]?>&nbsp;
	<?php
	}
	?>
	</td>
  </tr>
  <tr>
    <th><strong>余额：</strong></th>
    <td><?=$amount?></td>
    <th><strong>点数：</strong></th>
    <td><?=$point?></td>
  </tr>
  <tr>
    <th><strong>最后登录IP：</strong></th>
    <td><a href="<?=ip_url($lastloginip)?>" title="点击查看IP地区"><?=$lastloginip?></a></td>
    <th><strong>最后登录时间：</strong></th>
    <td><?=$lastlogintime?></td>
  </tr>
  <tr>
    <th><strong>注册IP：</strong></th>
    <td><a href="<?=ip_url($lastloginip)?>" title="点击查看IP地区"><?=$regip?></a></td>
    <th><strong>注册时间：</strong></th>
   	<td><?=$regtime?></td>
  </tr>
  <tr>
	<th><strong>地区：</strong></th>
    <td colspan="4"><?=$AREA[$areaid][name]?></td>
  </tr>
  <tr>
	<th><strong>邮件：</strong></th>
	<td colspan="4"><a href="?mod=mail&file=send&email=<?=$email?>" title="给<?=$username?>发送邮件"><?=$email?></a></td>
  </tr>
  <tr>
  	<th><strong>备注：</strong></th>
    <td colspan="4"><?=$note?></td>
  </tr>
  <?php
	if(is_array($forminfos) && !empty($forminfos))
	{
		foreach($forminfos as $k=>$v)
		{
	?>
	<tr>
		<th><strong><?=$k?>：</strong></th>
        <td colspan="4"><?=$v?></td>
	</tr>
	<?php
		}
	}
	?>
</table>
<?php
if($arr_ext_group) { 
?>
<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>所拥有的服务</caption>
	<tr>
		<th width="20%"><strong>服务名称</strong></th>
		<th><strong>服务简介</strong></th>
		<th width="15%"><strong>管理操作</strong></th>
	</tr>
<?php 
		foreach($arr_ext_group as $ext_group)
		{
?>
	<tr>
		<td><?=$GROUP[$ext_group['groupid']]?></td>
		<td><?php $result = $group_admin->get($ext_group['groupid']); echo $result['description'];?></td>
		<td class="align_c">
			<?php $result = $group_admin->extend_get($userid, $ext_group['groupid'], 'a.disabled'); $disabled = $result['disabled']; ?><a href="?mod=member&file=group&action=extenddisable&groupid=<?=$ext_group['groupid']?>&userid=<?=$userid?>&disable=<?=$disabled?0:1?>"><?php if($disabled) {?>启用<?php }else{ ?>禁用<?php } ?>服务</a>
			| <a href="?mod=member&file=group&action=extenddelete&groupid=<?=$ext_group['groupid']?>&userid=<?=$userid?>">删除服务</a>
		</td>
	</tr>
<?php 
		}
	
?>
</table>
<?php
	}
?>
</body>
</html>