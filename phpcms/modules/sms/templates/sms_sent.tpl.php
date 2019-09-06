<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header', 'admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script type="text/javascript">
  var charset = '<?php echo CHARSET?>';
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#mobile").formValidator({onshow:"<?php echo L('input').L('mobile')?>",onfocus:"<?php echo L('one_msg').L('mobile')?>"}).inputValidator({min:11,max:110000,onerror:"<?php echo L('one_msg').L('mobile')?>"});
  });
</script>
<div class="pad-10">

<form name="smsform" action="index.php?m=sms&c=sms&a=exportmobile" method="post" >
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">		
			<?php echo L('regtime')?>：
			<?php echo form::date('start_time', $start_time)?>-
			<?php echo form::date('end_time', $end_time)?>

			<?php echo form::select($modellist, $modelid, 'name="modelid"', L('member_model'))?>
			<?php echo form::select($grouplist, $groupid, 'name="groupid"', L('member_group'))?>
			<input type="submit" name="search" class="button" value="<?php echo L('exportmobile')?>" />
		</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
<div class="common-form">
<form name="myform" action="?m=sms&c=sms&a=sms_sent" method="post" id="myform">
<table width="100%" class="table_form">

<tr>
<td width="120"><?php echo L('content')?></td> 
<td><textarea name="content" style="width:200px; height:100px" id="content" onkeyup="strlen_verify(this, 'content_len', 120)"></textarea> 还可输入<B><span id="content_len">120</span></B> 个字符  </td>
</tr>
<tr>
<td width="120"><?php echo L('mobile')?></td> 
<td><textarea name="mobile" style="width:200px; height:100px" id="mobile"></textarea></td>
</tr>
<tr>
<tr>
<td width="120"><?php echo L('sendtime')?></td> 
<td>
<?php echo form::date('sendtime', date('Y-m-d H:i:s', SYS_TIME), 1)?>
</td>
</tr>
</table>

<div class="btn text-l">
	<input name="dosubmit" type="submit" value="<?php echo L('submit')?>" class="button" id="dosubmit">
	注意：群发100条以上的短信，建议先测试发送内容，以防有非法内容被屏蔽。
</div>
<div class="bk15"></div>

</form>
</div>
</body>
</html>