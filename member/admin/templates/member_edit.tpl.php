<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script language="javascript" type="text/javascript">
function areaid_load(id)
{
	$.get("<?=PHPCMS_PATH?>load.php", { field: 'areaid', id: id },
		function(data){
			$('#load_areaid').append(data);
			  });
}

function areaid_reload()
{
	$('#load_areaid').html('');
	areaid_load(0);
}
areaid_reload();
</script>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<input type="hidden" name="action" id="action" value="<?=$action?>" />
<input type="hidden" name="info[modelid]" value="<?=$modelid?>" />
<input type="hidden" name="groupid" value="<?=$groupid?>" />
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>修改会员信息</caption>
  <tr>
  		<th width="20%"><strong>用户名：</strong></th>
        <td width="80%">
			<input type="text" name="info[username]" id="username" value="<?=$username?>" size="16" maxlength="20" require="true" datatype="limit|ajax" url="?mod=member&file=member&action=checkuser&userid=<?=$userid?>" min="2" max="20" msg="用户名不得少于3个字符超过20个字符|">
        </td>
      </tr>
	  <?php
		if(!$PHPCMS['uc'])
		{
	  ?>
      <tr>
        <th><strong>密码：</strong><br></th>
        <td>
        	<?=form::text('info[password]', 'password', '', 'password', 16, '', 'maxlength="16" require="false" datatype="limit" min="6" max="16" msg="密码不得少于6个字符或超过16个字符！" size="20" maxlength="16"')?>
            <span id="password_notice">6到20个字符</span>
        </td>
      </tr>
	  
	  <tr>
        <th><strong>确认密码：</strong></th>
        <td>
        	<?=form::text('info[pwdconfirm]', 'pwdconfirm', '', 'password', 16, '','require="false" datatype="repeat" to="info[password]" msg="两次输入的密码不一致"')?>
        </td>
      </tr>
	  <?php
	   }
	  ?>
	  <tr>
        <th><strong>E-mail：</strong></th>
        <td>
		<input type="text" name="info[email]" id="email" size="30" maxlength="50"  require="true" datatype="email|ajax" url="?mod=member&file=member&action=checkemail&userid=<?=$userid?>" msg="邮件格式不正确|" value="<?=$email?>">
        </td>
      </tr>
      <tr>
        <th><strong>会员组：</strong></th>
        <td>
		<?php
		if($groupid == 1)
		{
		?>
		管理员
		<?php
		if($userid != $_userid)
		{
		?>
		<a href="javascript:confirmurl('?mod=phpcms&file=admin&action=delete&userid=<?=$userid?>', '你确认撤销管理员“<?=$username?>”吗？');">撤销管理员</a>
		<?php
		}
		?>
		<?php
		}
		else
		{
		?>
		<?=form::select($GROUP, 'info[groupid]', 'groupid', $groupid)?></td>
		<?php
		}
		?>
	  </tr>
      <tr>
      	<th><strong>地区：</strong><br /><a href="?mod=phpcms&file=area&action=add&forward=<?=urlencode(URL)?>">添加地区</a></th>
        <td>
        	<?php 
				if($areaid)
				{
			?>
            	<input type="hidden" name="info[areaid]" id="areaid" value="<?=$areaid?>">
				<span onClick="this.style.display='none';$('#reselect_areaid').show();" style="cursor:pointer;"><?=$AREA[$areaid][name]?> <font color="red">点击重选</font></span>
			    <span id="reselect_areaid" style="display:none;">
			    <span id="load_areaid"></span> 
			    <a href="javascript:areaid_reload();">重选</a>
                </span>
            <?php
				}
				else
				{
			?>
					<input type="hidden" name="info[areaid]" id="areaid" value="<?=$areaid?>">
					<span id="load_areaid"></span>
					<a href="javascript:areaid_reload();">&nbsp;重选&nbsp;</a>
			<?php
                }
			?>
        </td>
      </tr>
       <tr>
		<th><strong>用户模型：</strong></th>
		<td><?=$MODEL[$modelid][name]?>&nbsp;&nbsp;&nbsp;<a href="?mod=<?=$mod?>&file=<?=$file?>&action=model_edit&modelid=<?=$modelid?>&userid=<?=$userid?>&forward=<?=urlencode(URL)?>">修改模型</a></td>
	  </tr>
	  <?php
		if($M['enableQchk'])
		{
	  ?>
	  <tr>
    	<th><strong>密码提示问题：</strong></th>
        <td>
        <select name="info[question]" id="question" tabindex=4 alt="密码查询问题:无内容">
            <option selected value="">请您选择</option>
            <option value="我手机号码的后6位？">我手机号码的后6位？</option>
            <option value="我母亲的生日？">我母亲的生日？</option>
            <option value="我父亲的生日？">我父亲的生日？</option>
            <option value="我最好朋友的生日？">我最好朋友的生日？</option>
            <option value="我儿时居住地的地址？">我儿时居住地的地址？</option>
            <option value="我小学校名全称？">我小学校名全称？</option>
            <option value="我中学校名全称？">我中学校名全称？</option>
            <option value="离我家最近的医院全称？">离我家最近的医院全称？</option>
            <option value="离我家最近的公园全称？">离我家最近的公园全称？</option>
            <option value="我的座右铭是？">我的座右铭是？</option>
            <option value="我最喜爱的电影？">我最喜爱的电影？</option>
            <option value="我最喜爱的歌曲？">我最喜爱的歌曲？</option>
            <option value="我最喜爱的食物？">我最喜爱的食物？</option>
            <option value="我最大的爱好？">我最大的爱好？</option>
            <option value="我最喜欢的小说？">我最喜欢的小说？</option>
            <option value="我最喜欢的运动队？">我最喜欢的运动队？</option>
          </select>
        </td>
    </tr>
    <tr>
    	<th><strong>问题答案：</strong></th>
        <td>
			<input type="text" name="info[answer]" id="answer" size="30" />
        </td>
    </tr>
	<?php
		}
	?>
    <?php
	if(is_array($forminfos) && !empty($forminfos))
	{
    	foreach($forminfos as $forminfo)
       	{
    ?>
    <tr>
    	<th><strong><?=$forminfo[name]?>：</strong></th><td><?=$forminfo[form]?></td>
    </tr>
    <?php
    		}
		}
    ?>
    <tr>
		<th></th>
      	<td>
    	<?=form::text('info[userid]', 'userid', $userid, 'hidden', 10, '', '')?>
		<input type="hidden" name="forward" value="<?=$forward?>" >
		<input type="submit" name="dosubmit" value=" 修改 ">
    	<input type="reset" name="reset" value=" 重置 "></td>
		</td>
      </tr>
</table>
</form>
</body>
</html>
<script LANGUAGE="javascript">
<!--
$().ready(function() {
	  $('form').checkForm(1);
});
function ShowTab(id)
{
	var tabs = '#Tabs' + id;
	var menu_tab = '#menu_tab' + id;
	for(i = 0; i < 2; i++)
	{
		var utab = '#Tabs' + i;
		var umenu_tab = '#menu_tab' + i;
		$(utab).hide();
		$(umenu_tab).removeClass('selected');
	}
	$(menu_tab).addClass('selected');
	$(tabs).show();
}
//-->
</script>