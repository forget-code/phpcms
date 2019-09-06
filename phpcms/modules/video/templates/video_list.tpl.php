<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header','admin');
?>
<div class="pad_10">
<div class="table-list">
<form name="searchform" action="" method="get" >
<input type="hidden" value="video" name="m">
<input type="hidden" value="video" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $_GET['menuid']?>" name="menuid">
<div class="explain-col search-form">
<select name="type" ><option value=""><?php echo L('please_select')?></option><option value="1" <?php if ($_GET['type']==1) {?>selected<?php }?>><?php echo L('video_id');?></option><option value="2" <?php if ($_GET['type']==2) {?>selected<?php }?>><?php echo L('video_title')?></option></select> <input type="text" value="<?php echo $_GET['q']?>" class="input-text" name="q"> 
<?php echo L('addtime')?>  <?php echo form::date('start_addtime',$_GET['start_addtime'])?><?php echo L('to')?>   <?php echo form::date('end_addtime',$_GET['end_addtime'])?> 
<?php echo form::select($trade_status,$status,'name="status"', L('all_status'))?> <label title="<?php echo L('site_upload');?>"><?php echo L('original');?> <input type="checkbox" name="userupload" value="1" id="userupload"<?php if($userupload){ ?> checked<?php }?>></label> &nbsp;&nbsp;
<input type="submit" value="<?php echo L('search')?>" class="button" name="dosubmit">
</div>
</form>
    <table width="100%" cellspacing="0">
        <thead>
            <tr>
            <th width="6%">ID</th>
            <th><?php echo L('video_title')?></th>
            <th width="20%">vid</th>
            <th width="12%"><?php echo L('addtime')?></th>
            <th width="15%"><?php echo L('tags');?></th>
            <th width="8%"><?php echo L('status')?></th>
            <th width="10%"><?php echo L('operations_manage')?></th>
            </tr>
        </thead>
    <tbody>
 <?php 
if(is_array($infos)){
	foreach($infos as $info){
		$status_arr = pc_base::load_config('ku6status_config');
?>   
	<tr>
	<td align="center"><?php echo $info['videoid']?></td>
	<td><?php echo $info['title']?> <?php if($info['userupload']){?><img src="<?php echo IMG_PATH; ?>yc.jpg" height="16"><?php }?></td>
	<td align="center"><?php echo $info['vid'];?></td>
	<td align="center"><?php echo date('Y-m-d H:i', $info['addtime'])?></td>
	<td align="center"><?php echo $info['keywords']?></td>
	<td align="center"><?php if($info['status']<0 || $info['status']==24) { ?><font color="#ff5c5c"><?php } elseif ($info['status']==21) {?><font color="#3a895d"><?php }?><?php echo $status_arr[$info['status']]?> <?php if($info['status']<0 || $info['status']==24 || $info['status']==21) { ?></font><?php }?></td>
	<td align="center"><a href="index.php?m=video&c=video&a=edit&vid=<?php echo $info['videoid']?>&menuid=<?php echo $_GET['menuid']?>"><?php echo L('edit');?></a><?php if($info['status']>=0 && $info['status']!=24) {?> | <a href="javascript:confirmurl('index.php?m=video&c=video&a=delete&vid=<?php echo $info['videoid']?>&menuid=<?php echo $_GET['menuid']?>', '是否删除该管理员?')"><?php echo L('delete');?></a><?php }?></td>
	</tr>
<?php 
	}
}
?>
    </tbody>
    </table>
<div class="btn text-r">

</div>
 <div id="pages"> <?php echo $pages?></div>
</div>
</div>
</form>
</body>
</html>
<script type="text/javascript">
<!--
	function discount(id, name) {
	window.top.art.dialog({title:'<?php echo L('discount')?>--'+name, id:'discount', iframe:'?m=pay&c=payment&a=discount&id='+id ,width:'500px',height:'200px'}, 	function(){var d = window.top.art.dialog({id:'discount'}).data.iframe;
	var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'discount'}).close()});
}
function detail(id, name) {
	window.top.art.dialog({title:'<?php echo L('discount')?>--'+name, id:'discount', iframe:'?m=pay&c=payment&a=public_pay_detail&id='+id ,width:'500px',height:'550px'});
}
//-->
</script>