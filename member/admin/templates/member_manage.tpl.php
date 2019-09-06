<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>
  会员管理
  </caption>
    <tr>
		<td>会员模型：
		<?php foreach($member->MODEL as $id=>$m)
		{
		?>
		<a href="<?=url_par("modelid=$id")?>" title="<?=$m['name']?>"><?php echo $m['name']; ?></a>
		<?php 
		}	
		?>
		</td>
	</tr>
    <tr>
		<td>主会员组：
		<?php
		foreach($GROUP as $id=>$groupname)
		{
			if(!$id || $id>6) continue;
		?>
		<a href="?mod=member&file=member&action=manage&groupid=<?=$id?>" id="groupinfo_<?=$id?>" title="<?=$groupname?>"><?php echo $groupname; ?></a>
		<?php 
		}	
		?>
		</td>
	</tr>
    <tr>
    	<td>扩展会员组：
        <?php
		foreach($ext_group as $ext_id=>$ext_groupname)
		{
		?>
        <a href="<?=url_par("groupid=$ext_id")?>" id="ext_groupid_<?=$ext_id?>" title="<?=$ext_groupname?>"><?php echo $ext_groupname; ?></a>
        <?php
		}
		?>
        </td>
    </tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_list">
<form method="post" name="myform">
  <caption>
  <?php if($modelid) echo $MODEL[$modelid]['name']; ?>   <?php if($groupid) echo $GROUP[$groupid]; ?> <?php if($extgroup) echo '扩展会员组:'.$GROUP[$extgroup];?> 会员列表
  </caption>
    <tr align="center">
        <th width="5%"><strong>选中</strong></th>
        <th>
        	<strong>
            	<a href="<?=($orderby=='m.username ASC')? url_par("orderby=m.username DESC") : url_par("orderby=m.username ASC")?>" title="按用户名排序">用户名</a>
            </strong>
        </th>
        <th width="10%"><strong>会员组</strong></th>
        <th width="10%"><strong>会员模型</strong></th>
        <th width="10%">
        	<strong>
            	<a href="<?=($orderby=='m.amount ASC')? url_par("orderby=m.amount DESC") : url_par("orderby=m.amount ASC")?>" title="按资金排序">资金</a>
        	</strong>
        </th>
        <th width="10%">
        	<strong>
            	<a href="<?=($orderby=='m.point ASC')? url_par("orderby=m.point DESC") : url_par("orderby=m.point ASC")?>" title="按点数排序">点数</a>
            </strong>
        </th>
        <th width="15%">
        	<strong>
            	<a href="<?=($orderby=='i.lastlogintime ASC')? url_par("orderby=i.lastlogintime DESC") : url_par("orderby=i.lastlogintime ASC")?>" title="按登录时间排序">最后登录</a>
            </strong>
        </th>
        <th width="20%"><strong>管理操作</strong></th>
    </tr>
<?php 
	if(is_array($members) && !empty($members))
	{
	foreach($members as $member){ 
?>
    <tr>
        <td class="align_c"><input type="checkbox" name="userid[]"  id="checkbox" value="<?=$member['userid']?>" <?=($member['userid'] == $_userid ? 'disabled' : '')?> <?php if(in_array($member['userid'], $arr_founder)) { echo 'disabled'; }?>></td>
        <td class="align_c" onClick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=view&userid=<?=$member['userid']?>&forward=<?=urlencode(URL)?>'" align="center"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=view&userid=<?=$member['userid']?>" title="点击查看会员资料&#10ID:<?=$member['userid']?>&#10最后登录时间：<?=$member['lastlogintime']?>&#10最后登录IP：<?=$member['lastloginip']?>&#10登录次数：<?=$member['logintimes']?>"><?=$member['username']?></a></td>
        <td class="align_c"><a href="<?=url_par("groupid=$member[groupid]")?>" title="列出<?=$GROUP[$member['groupid']]?>会员"><?=$GROUP[$member['groupid']]?></a></td>
        <td class="align_c"><a href="<?=url_par("modelid=$member[modelid]")?>" title="列出<?=$MODEL[$member['modelid']]['name']?>会员"><?=$MODEL[$member['modelid']]['name']?></a></td>
        <td class="align_c"><?=$member['amount']?>元</td>
        <td  class="align_c"><?=$member['point']?>点</td>
        <td title="最后登录IP：<?=$member['lastloginip']?>&#10登录次数：<?=$member['logintimes']?>" class="align_c"><?=$member['lastlogintime']?></td>
        <td class="align_c">
         <?php
			 if(in_array($member['userid'], $arr_founder) && $member['userid'] != $_userid)
			{
		 ?>
         	<font color="#CCCCCC">修改</font>
         <?php
		 	}
			else
			{
         ?>
         	<a href="?mod=<?=$mod?>&file=member&action=edit&userid=<?=$member['userid']?>">修改</a>
         <?php
		 	}
		 ?>
		 | 
        <a href="?mod=<?=$mod?>&file=member&action=note&userid=<?=$member['userid']?>" title="关于该会员的备注">备注</a>
         | 
          <?php
			 if(in_array($member['userid'], $arr_founder) || $member['userid'] == $_userid)
			{
		 ?>
         <font color="#CCCCCC"><?=$member['disabled'] ? '启用':'禁用'?></font>
         <?php
		 	}
			else
			{
		 ?>
        <a href="?mod=<?=$mod?>&file=member&action=lock&userid=<?=$member['userid']?>&val=<?=($member['disabled']) ? '0' : '1'?>"><?=($member['disabled']==1 ? '<font color="blue">启用</font>' : '禁用')?></a>
        <?php
			}
		?>
         | 
        <?php  if(in_array($member['userid'], $arr_founder) || $member['userid'] == $_userid) { ?>
        <font color="#CCCCCC">删除</font>
        <?php } else { ?>
            <a href="#" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=member&action=delete&userid=<?=$member['userid']?>', '是否删除该会员')">删除</a>
        <?php } ?>
        </td>
    </tr>
<?php } 
}
?>
</table>
<div class="button_box">
	<input name='button2' type='button' class="button_style" id='chkall' onclick='checkall()' value='全选'>
	<input type="submit" name="button2" class="button_style" value="批量锁定" id="button" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>	&action=lock&val=1'">
	<input type="submit" name="submit2" class="button_style" value="批量解锁" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=lock&val=0'">
	<input type="submit" name="submit3" class="button_style" value="批量移动" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=move'">
	<input type="submit" name="submit4" class="button_style" value="批量删除" onClick="if(confirm('确认批量删除这些会员吗？')) document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete&dosubmit=1'">
</div>
<div id="pages"><?=$pages?></div>
</form>
<table cellpadding="0" cellspacing="1" class="table_form">
<caption>
	会员搜索
</caption>
<form method="get" name="search" action="?">
<tr>
<td  class="align_c">
会员组：<?=form::select($GROUP, 'groupid', 'groupid', $groupid)?> 
状态：
<select name='disabled'>
<option value='-1'>不限</option>
<option value='0'>正常</option>
<option value='1'>锁定</option>
</select> 
会员名：<?=form::text('username', '', $username, 'text', '20')?>
<input name='mod' type='hidden' value='<?=$mod?>'>
<input name='file' type='hidden' value='<?=$file?>'>
<input name='action' type='hidden' value='<?=$action?>'>
<input name='submit' class="button_style" type='submit' value=' 搜索 '>&nbsp;
</td>
</tr>
</form>
</table>
</body>
</html>
<script language="javascript">
$('#modelid').change(function(){
	location="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&modelid="+this.value;
});
$('#selectgroupid').change(function(){
	location="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&groupid="+this.value;
});
</script>