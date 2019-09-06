<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form action="?" method="get">
<input name="mod" type="hidden" value="<?=$mod?>">
<input name="file" type="hidden" value="<?=$file?>">
<input name="action" type="hidden" value="manage">
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>广告搜索</caption>
<tr>
<th width="10%">广告位</th>
<th width="35%">广告状态</th>
<th width="15%">审核状态</th>
<th width="15%">客户状态</th>
<th width="15%">客户名</th>
<th>操作</th>
</tr>
<tr>
	<td class="align_c">
	<?=form::select($place, 'adsplaceid', 'adsplaceid', $adsplaceid, 1, '', "onchange='location.href=\"?mod=ads&file=ads&action=manage&expired=$expired&adsplaceid=\"+this.value'")?>
	</td><td class="align_c">
    <?=form::radio($expireds, 'expired', 'expired', $expired, 5, '', "onclick='location.href=\"?mod=ads&file=ads&action=manage&adsplaceid=$adsplaceid&expired=\"+this.value'")?>
	</td>
    <td class="align_c">
    <span style="width: 100px;">
    <input type="radio" <?php if($passid == '1'){?> checked=""<? }?> value="1" id="" name="passid" />审核</span>
    <span style="width: 100px;">
    <input type="radio" <?php if($passid == '0' && isset($passid)){?> checked=""<? }?> value="0" id="" name="passid" />未审核</span>
    </td>
    <td class="align_c">
     <span style="width: 100px;">
    <input type="radio" <?php if($status == '1'){?> checked=""<? }?> value="1" name="status" />正常</span>
    <span style="width: 100px;">
    <input type="radio" <?php if($status == '0' && isset($status)){?> checked=""<? }?> value="0" name="status" />关闭</span>
    </td>
    <td class="align_c"> <input type="text" value="<?=$username?>" id="username" name="username" /></td>
    <td class="align_c"><input type="submit" value="搜索"/></td>
</tr>
</table>
</form>
<table cellpadding="3" cellspacing="1" class="table_list"><form method="post" name="myform">
  <caption>管理广告</caption>
<tr>
	<th width="5%">选中</th>
	<th>广告名称</th>
	<th>所属广告位</th>
	<th width="10%">当前客户</th>
	<th width="10%">起始日期</th>
	<th width="10%">结束日期</th>
	<th width="5%">审核</th>
	<th width="7%">客户状态</th>
	<th width="60">管理操作</th>
</tr>
<?php
if(is_array($adssigns)){
	foreach($adssigns as $value){
?>
<tr>
<td class="align_c"><input type="checkbox" name="adsid[]"  id="checkbox" value="<?=$value['adsid']?>"></td>
<td class="align_left">&nbsp;<a href="?mod=ads&file=<?php echo $file?>&action=view&adsid=<?=$value['adsid']?>" target="_blank" title="点击预览"><?=$value['adsname']?></a></td>
<td class="align_c"><?=$place[$value['placeid']]?></td>
<td class="align_c"><?=$value['username']?></td>
<td class="align_c"><?php echo date("Y.m.d",$value['fromdate'])?></td>
<td class="align_c"><?php echo date("Y.m.d",$value['todate'])?></td>
<td class="align_c" ><?php if($value['passed']) { ?><font color="#00ee00">通过</font><?php } else { ?><font color="#ee0000">未通过</font><?php }?></td>
<td class="align_c"><?php if($value['status']) { ?><font color="#00ee00">正常</font><?php } else { ?><font color="#ee0000">关闭</font><?php }?></td>
<td>
<A HREF="?mod=ads&file=<?=$file?>&action=edit&adsid=<?=$value['adsid']?>">修改</A>|<A HREF="?mod=ads&file=<?=$file?>&action=stat&adsid=<?=$value['adsid']?>">统计</A>
</td>
</tr>
<?php
	}
}
?>
</table>
<div class="button_box">
	<input type="button" value="全选" onClick="checkall()">
	<input TYPE="hidden" name="referer" value="<?=$referer?>">
	<input type="submit" name="submit" value="批量审核通过" onClick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=passed&val=1';return confirm('您确定要审核吗？');">
	<input type="submit" name="submit" value="批量取消审核" onClick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=passed&val=0';return confirm('您确定要取消审核吗？');">
	<input type="submit" name="submit" value="批量删除" onClick="myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=delete';return confirm('您确定要删除吗？');">
</div>
</form>
<div id="pages"><?=$pages?></div>
</body>
</html>