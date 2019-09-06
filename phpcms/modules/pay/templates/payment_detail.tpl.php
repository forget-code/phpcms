<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script type="text/javascript">
<!--
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#name").formValidator({onshow:"<?php echo L('input').L('payment_mode').L('name')?>",onfocus:"<?php echo L('payment_mode').L('name').L('empty')?>"}).inputValidator({min:1,max:999,onerror:"<?php echo L('payment_mode').L('name').L('empty')?>"});
})
//-->
</script>
<div class="pad-10">
<div class="common-form">
<form name="myform" action="?m=pay&c=payment&a=<?php echo $_GET['a']?>" method="post" id="myform">
<fieldset>
<legend><?php echo L('basic_config')?></legend>
<table width="100%" class="table_form">
<tr>
<td  width="120"><?php echo L('payment_mode')?></td> 
<td><?php echo $pay_name?></td>
</tr>
<tr>
<td  width="120"><?php echo L('payment_mode').L('name')?></td> 
<td><input type="text" name="name" value="<?php echo $name ? $name : $pay_name?>" class="input-text" id="name"></input></td>
</tr>
<tr>
<td><?php echo L('payment_mode').L('desc')?></td> 
<td>
<textarea name="description" rows="2" cols="10" id="description" class="inputtext" style="height:100px;width:300px;"><?php echo $pay_desc?></textarea>
<?php echo form::editor('description', 'desc');?>
</td>
</tr>
<tr>
<td  width="120"><?php echo L('listorder')?></td> 
<td><input type="text" name="pay_order" value="<?php echo $pay_order?>" class="input-text" id="pay_order" size="3"></input></td>
</tr>
<tr>
<td  width="120"><?php echo L('online')?>?</td> 
<td><?php echo $is_online ? L('yes'):L('no')?></td>
</tr>
<tr>
<td  width="120"><?php echo L('pay_factorage')?>：</td> 
<td id="paymethod"><input name="pay_method" value="0" type="radio" <?php echo ($pay_method == 1) ? '': 'checked'?>> <?php echo L('pay_method_rate')?>&nbsp;&nbsp;&nbsp;<input name="pay_method" value="1" type="radio" <?php echo ($pay_method == 0) ? '': 'checked'?>> <?php echo L('pay_method_fix')?>&nbsp;&nbsp;&nbsp; </td>
</tr>
<tr><td></td>
<td>
<div id="rate" <?php echo ($pay_method == 0) ? '': 'class="hidden"'?>>
<?php echo L('pay_rate')?><input type="text" size="3" value="<?php echo $pay_fee?>" name="pay_rate">&nbsp;%&nbsp;&nbsp;&nbsp;&nbsp;<?php echo L('pay_method_rate_desc')?>
</div>
<div id="fix" <?php echo ($pay_method == 1) ? '': 'class="hidden"'?>>
<?php echo L('pay_fix')?><input type="text" name="pay_fix" size="3" value="<?php echo $pay_fee?>">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo L('pay_method_fix_desc')?>
</div>
</td>
</tr>
</table>
</fieldset>
<div class="bk15"></div>
<fieldset>
<legend><?php echo L('parameter_config')?></legend>
<table width="100%" class="table_form">
<?php foreach ($config as $conf => $name) {?>
 <tr>
  <td><?php echo $name['name']?></td>
	<td>
	<?php if($name['type'] == 'text'){?>
	<input type="text"  class="input-text" name="config_value[]" id="<?php echo $conf?>" value="<?php echo $name['value']?>" size="40"></input>
	<?php } elseif($name['type'] == 'select') { ?>
		<select name="config_value[]" value="0">
		 <?php foreach ($name['range'] as $key => $v) {?>
		<option value="<?php echo $key?>" <?php if($key == $name['value']){ ?> selected="" <?php } ?> ><?php echo $v?></option>
		 <?php }?>
		</select>
	<?php }?>
	<input type="hidden" value="<?php echo $conf?>" name="config_name[]"/>
	</td>
 </tr>
<?php }?>
	</table>
</fieldset>

    <div class="bk15"></div>
	<input type="hidden"  name="pay_name" value="<?php echo $pay_name?>" />
	<input type="hidden"  name="pay_id" value=<?php echo $pay_id?> />
	<input type="hidden"  name="pay_code" value=<?php echo $pay_code?> />
	<input type="hidden"  name="is_cod" value=<?php echo $is_cod?> />
	<input type="hidden"  name="is_online" value=<?php echo $is_online?> />
<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="dialog" id="dosubmit">
</form>
</div></div>
</body>
</html>
<script type="text/javascript">

$(document).ready(function() {
	$("#paymethod input[type='radio']").click( function () {
		if($(this).val()== 0){
			$("#rate").removeClass('hidden');
			$("#fix").addClass('hidden');
			$("#rate input").val('0');
		} else {
			$("#fix").removeClass('hidden');
			$("#rate").addClass('hidden');
			$("#fix input").val('0');
		}	
	});
});
function category_load(obj)
{
	var modelid = $(obj).attr('value');
	$.get('?m=admin&c=position&a=public_category_load&modelid='+modelid,function(data){
			$('#load_catid').html(data);
		  });
}
</script>


