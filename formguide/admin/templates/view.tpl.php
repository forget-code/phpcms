<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="searchform" method="get">
<input type="hidden" name="formid" value="<?=$formid?>">
<input type="hidden" name="mod" value="<?=$mod?>">
<input type="hidden" name="file" value="search">
<table cellpadding="0" cellspacing="1" class="table_form">
	<tr>
		<th class="align_l">
            <strong>提交信息会员名称：</strong>
            <input type="text" name="userid" />
            <strong>提交信息IP：</strong>
            <input type="text" name="ip" />
			<?php $i = 1 ?>
            <?php foreach($where as $field=>$r) { $i++; ?>
            <strong><?=$r[name]?>：</strong><?=$r[form]?><?=($i % 3 ==0)?'<br />': ''?>
            <?php } ?>
            <input type="submit" name="dosubmit" value="搜索">
        </th>
	</tr>
</table>
</form>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=view&action=delete&formid=<?=$formid?>">

<table cellpadding="0" cellspacing="1" class="table_list">
	<caption><?=$formname?></caption>
    <tr>
		<th width="5%"><strong>选中</strong></th>
		<th><strong>用户名</strong></th>
        <th width="10%"><strong>用户IP</strong></th>		
        <th width="15%"><strong>时间</strong></th>
    	<?php
			foreach($forminfos as $forminfo)
			{	
				if($forminfo['islistbackgroud'])
				{
    	?>
        <th><strong><?=$forminfo[name]?></strong></th>
		<?php
				}
			}
		?>
        <th width="10%"><strong>相关操作</strong></th>
	</tr>
	
    <?php
		foreach($result as $r)
		{
			$dataid = $r['dataid'];
	?>
    <tr>
		<td class="align_c"><input type="checkbox" name="dataid[]" id="checkbox" value="<?=$r['dataid']?>"></td>       
		<td class="align_c"><a href="<?=member_view_url($r['userid'])?>" title="<?=username($r['userid'])?>"><?=username($r['userid'])?></a></td>
		<td class="align_c"><a href="<?=ip_url($r['ip'])?>"><?=$r['ip']?></a></td>
		<td class="align_c"><?=date('Y-m-d H:i', $r['datetime'])?></td>
		<?php 
			$r = $formguide_output->get($r);
			foreach($forminfos as $forminfo)
			{	
				if($forminfo['islistbackgroud'])
				{
    	?>
		<td><?=$r[$forminfo['field']]?></td>
		<?php
				}
			}
		?>
        <td class="align_c">
		<a href="?mod=formguide&file=viewinfo&formid=<?=$formid?>&dataid=<?=$dataid?>">查看</a>
		</td>
    </tr>
    <?php
		}
	?>
</table>
<div class="button_box">
	<input name='button' type='button' class="button_style" id='chkall' onclick='checkall()' value='全选'>
	<input name="button2" type="submit"  value="删除">
</div>
</form>
<div id="pages">
	<?=$formguide_fields->pages?>
</div>
</body>
</html>