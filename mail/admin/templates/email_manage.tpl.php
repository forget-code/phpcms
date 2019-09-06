<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript">
function checkform()
{
    if(!Common.isemail($('#searchemail').val()))
        {
            alert('请输入正确的email！');
            $('#searchemail').val("");
            $('#searchemail').focus();
        }
        else
	    location='?mod=<?=$mod?>&file=<?=$file?>&action=list&searchemail='+$('#searchemail').val();
}
</script>
<body>
<?=$menu?>
<form method="get" action="?">
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="<?=$file?>">
<input type="hidden" name="action" value="list">
<table class="table_list" cellpadding="0" cellspacing="1">
	<caption>查询订阅</caption>
    <tr>
    <th>邮箱</th>
    <th>订阅时间</th>
    <th>类型</th>
    <th>操作</th>
    </tr>
    <tr>
	  <td style="text-align:center;"><input type="text" name="searchemail" id="searchemail" value="<?=$searchemail?>"/></td>
	   <td style="text-align:center;"><?=form::date('starttime' )?>-<?=form::date('endtime')?></td>
	   <td style="text-align:center;"><?=form::select_type('mail','typeid', 'typeid', '选择类型',$typeid,"onchange=location='?mod=mail&file=email&action=list&typeid='+this.value")?></td>
        <td style="text-align:center;"><input type="submit"  value="搜 索" /></td>
	 </tr>
  </table>
</form>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=list">
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption>管理订阅邮箱</caption>
  <tr>
    <!--th>全选</th-->
    <th>Email</th>
    <th style="width:80px;">用户名</th>
    <th>订阅者IP</th>
    <th>订阅时间</th>
    <th style="width:50px;">状态</th>
    <th style="width:80px;">管理操作</th>
  </tr>
	<?php
	foreach($emails['info'] as $email)
	{
	?>
    <tr>
		<!--td><input type="checkbox" name="checkbox" id="checkbox" /></td-->
		<td style="text-align:center;"><a href="?mod=<?=$mod?>&file=send&type=1&email=<?=$email['email']?>" title="点击发送邮件"><?=$email['email']?></a></td>
        <?php if ( $email['userid'] ) {?>
            <td style="text-align:center;"><a href="?mod=member&amp;file=member&amp;action=view&userid=<?=$email['userid']?>"><?=$email['username']?></a></td>
        <?php }else{?>
            <td style="text-align:center;"><?=$email['username']?></td>
        <?php }?>
		<td style="text-align:center;" title="<?=$email['area']?>"><?=$email['ip']?></td>
		<td style="text-align:center;"><?=$email['addtime']?></td>
		<td style="text-align:center;"><?=$email['state_description']?></td>
		<td style="text-align:center;">
		<?php if ('0' == $email['status']) {?>
		<a href="javascript:if(confirm('确定审核激活该条记录吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=verify&email=<?=$email['email']?>'">
        <span style="color:red">激活</span></a>|<?php }?>
		<a href="javascript:if(confirm('确定删除该条记录吗？')) location='?mod=<?=$mod?>&file=<?=$file?>&action=delete&email=<?=$email['email']?>'">删除</a>
		</td>
	</tr>
    <?php
	}
	?>
</table></form>
<div id="pages"><?=$pages?></div>
</body>
</html>