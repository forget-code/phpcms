<?php
/**
 * Description:
 * 
 * Encoding:    GBK
 * Created on:  2012-4-16-下午5:48:04
 * Autdor:      kangyun
 * Email:       KangYun.Yun@Snda.Com
 */

defined ( 'IN_ADMIN' ) or exit ( 'No permission resources.' );

include $this->admin_tpl ( 'header', 'admin' );
?>


<div class="pad-10">
    <form
        action="?m=maillist&c=maillist&a=maillist_create&menuid=<?php echo $menuid;?>&pc_hash=<?php echo $pc_hash;?>"
        name="myform" id="myform" method="post">
        <input type="hidden" name="snda_user" id="snda_user" value="0" />
        <input type="hidden" name="sndaid" id="sndaid" value="" />
        <input type="hidden" name="is_activate" id="is_activate" value="0" />
        <input type="hidden" name="menuid" id="menuid" value="<?php echo $menuid;?>" />
        <input type="hidden" name="pc_hash" id="pc_hash" value="<?php echo $pc_hash;?>" />
        <table border="0" cellpadding="1" cellspacing="1"
            class="table_form" id="step1" width="100%">        
                    <tr>
                <td width="180" align="right">&nbsp;<?php echo L('input_email')?></td>
                <td><input name="email_addr" id="email_addr" size="30" type="text" /><div id="email_addrTip" class="onShow"><?php echo L('input_email_tips')?></div></td>
            </tr>
            <tr>
                <td height="64" align="right">&nbsp;</td>
                <td><input type="button" class="button"
                    onclick="createNext()" id="dosubmit1"
                    name="dosubmit1" style="width:90px" value="<?php echo L('next_step')?>" /></td>
            </tr>
        </table>    
        
        <table  id="step2" border="0" cellpadding="1" cellspacing="1"
            class="table_form" width="100%" style="display:none">
           
            
            <tr>
                <td width="15%" align="right">&nbsp;email：</td>
                <td width="85%" id="email_addr2" style="font-weight:bold">&nbsp;</td>
            </tr>
           <!--
            <tr id="pwd1" style="display:none">
                <td width="15%" align="right"><?php echo L('username'); ?>：</td>
                <td width="85%"><input name="username" type="text"
                    class="input-text" id="username" size="30"
                    maxlength="16" /></td>
            </tr> -->
            <tr id="pwd1" style="display:none">
                <td align="right"><?php echo L('password'); ?>：</td>
                <td><input name="password" type="password"
                    class="input-text" id="password" value="" size="30" /></td>
            </tr>
            <tr id="pwd2" style="display:none">
                <td align="right"><?php echo L('password_cfm'); ?>：</td>
                <td><input name="password2" type="password"
                    class="input-text" id="password2" value="" size="30" /></td>
            </tr>
            
            
            <tr>
                <td align="right"><?php echo L('group_name'); ?>：</td>
                <td><input name="group_name" type="text"
                    class="input-text" id="group_name" size="30" /></td>
            </tr>
            <tr>
                <td align="right"><?php echo L('group_addr'); ?>：</td>
                <td><input name="addr" type="text" class="input-text"
                    id="addr" style="width: 180px" />@o.sdo.com</td>
            </tr>
            <!-- 
            <tr>
                <td align="right"><?php echo L('send_email'); ?>：</td>
                <td><input name="email" type="text" class="input-text"
                    id="email" size="30" /></td>
            </tr>
             -->
            <tr>
                <td align="right" valign="top"><?php echo L('group_intro'); ?>：</td>
                <td valign="top"><textarea name="descs" cols="" rows=""
                        id="descs" style="width: 300px; height: 60px;"></textarea></td>
            </tr>
            <tr>
                <td height="64" align="right" class="t">&nbsp;</td>
                <td>
                <input type="submit" class="button" onclick="return checkSubmit2()" id="dosubmit9" name="dosubmit9" style="width:90px" value="<?php echo L('submit') ?>" /> 
                <input type="button" class="button" onclick="createPrev()" id="dosubmit3" name="dosubmit3" style="width:90px" value="<?php echo L('prev_step')?>" />
									  
					</td>
            </tr>

        </table>
		
			<table border="0" cellpadding="1" cellspacing="1"
             id="step3" width="100%" style="display:none">        
                    <tr>
                      <td width="19%" height="58" align="center">&nbsp;</td>
                <td colspan="2" align="right" nowrap="nowarp"><div class="onCorrect" style="white-space:word-warp"><span id="step3_group_name"></span><?php echo L('complete_tips')?><span id="step3_email"></span> <?php echo L('activate')?></div>                  </td>
                <td width="40%" align="left">&nbsp;</td>
              </tr>
                    <tr>
                      <td align="center">&nbsp;</td>
                      <td colspan="2" align="right">
					  <a id="activate_email_href" onclick="return activateEmail()" href="" style="text-decoration:none" target="_blank" class="button"><?php echo L('now_activate')?></a>
</td>
                      <td align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="center">&nbsp;</td>
                      <td colspan="2" align="right"><hr size="1" color="#CCCCCC" /></td>
                      <td align="left">&nbsp;</td>
                    </tr>
                    <tr id="activate_email" style="display:none">
                      <td align="center">&nbsp;</td>
                      <td colspan="2" align="right"><?php echo L('repeat_send_tips')?>&nbsp;&nbsp;
                      <input type="button" class="button"
                    onclick="repeatSendEmail()" id="dosubmit32"
                    name="dosubmit322"  style="width:90px" value="<?php echo L('repeat_send')?>" /></td>
                      <td align="left">&nbsp;</td>
                    </tr>
                    <tr id="change_email" style="display:none">
                      <td align="center">&nbsp;</td>
                      <td colspan="2" align="right"><br />
                        <?php echo L('change_email_tips')?><br />
                      <input type="text" name="new_email" id="new_email" />
                      <input type="button" class="button"
                    onclick="changeEmail()" id="dosubmit322"
                    name="dosubmit3222"  style="width:90px" value="<?php echo L('change_email')?>" /></td>
                      <td align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="center">&nbsp;</td>
                      <td colspan="2" align="center"><div id="message2" style="margin-top:10px;color:red"></div></td>
                      <td align="left">&nbsp;</td>
                    </tr>
        </table>
        <div id="message" style="margin-top:10px; margin-left: 18%; color:#FF0000"></div>	
    </form>
</div>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH; ?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH; ?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
	function trim(str){
	    return str ? str.replace(/^\s+|\s+$/g, "") : str;
	}
	
    $(document).ready(function(){
		var username_tips = "<?php echo L('username_tips'); ?>";
		var password_tips = "<?php echo L('password_tips'); ?>";
		var password2_tips = "<?php echo L('password_cfm_tips'); ?>"; 
		var pwd_confirm = "<?php echo L('password_same_tips'); ?>";
		var group_name_tips = "<?php echo L('group_name_tips') ?>";
		var addr_tips = "<?php echo L('group_addr_tips') ?>";
		var email_tips = "<?php echo L('send_email_tips') ?>";
		var email_error_tips = "<?php echo L('send_email_tips') ?>";
		var descs_tips = "<?php echo L('group_intro_tips') ?>";

        $.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
        $("#password").formValidator({onshow: password_tips,onfocus: password_tips}).inputValidator({min:6, max:30,onerror:password_tips});
		$("#password2").formValidator({onshow: password2_tips,onfocus: password2_tips}).compareValidator({desid:"password",operateor:"=",onerror: pwd_confirm});
		$("#group_name").formValidator({onshow: group_name_tips,onfocus: group_name_tips}).inputValidator({min:1, max:20,onerror:group_name_tips});
		
		$("#addr").formValidator({onshow: addr_tips,onfocus: addr_tips}).inputValidator({min:5, max:16,onerror: addr_tips}).functionValidator({
            fun:function(val,elem){
                if(!new RegExp(/\-\-/).test(val)){
                    return true;
                }else{
                    return addr_tips
                }
            }
        });
        var show = '<?php echo L('input_email_tips')?>';
        $("#descs").formValidator({onshow: descs_tips,onfocus: descs_tips}).inputValidator({min:1,max:200,onerror: descs_tips});
    });


    function validEmail(t) {
    	return new RegExp(/^\w+([-+._]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/).test(t);
    }
    
    function createNext()
    {
    	$('#message').html('');
		var email = $('#email_addr').val();
		if (email == '' || !validEmail(email)) {
			$('#email_addrTip').removeClass();
			$('#email_addrTip').addClass('onError');
			$('#email_addrTip').html('<?php echo L('send_email_tips')?>');
			return false
		}
		$('#email_addrTip').removeClass();
		$('#email_addrTip').addClass('onCorrect');
		$('#email_addrTip').html('');
		$('#dosubmit1').attr('disabled', true);
		$('#dosubmit1').val('loading...');
		$('#dosubmit3').css('display', 'none');
		$.ajax({
			dataType: "json",
    		url : $('#myform').attr('action'),
    		type: "POST",
    		data: {
	    		act: "check_email", 
	    		email: email
	    	},
    		success: function(data){
    			$('#dosubmit1').attr('disabled', false);
    			$('#dosubmit1').val('<?php echo L('next_step')?>');
    			$('#step1').css('display', 'none');
    			$('#dosubmit3').css('display', '');
				$('#step2').css('display', 'table');
    			$('#email_addr2').html(email);
                if (data.sdid == undefined) {
            		$('#pwd1,#pwd2').css('display', '');
                }
    		},
    		error: function() {
    			$('#dosubmit1').attr('disabled', false);
    			$('#dosubmit1').val('<?php echo L('next_step')?>');
    			$('#email_addrTip').removeClass('onCorrect');
    			$('#email_addrTip').addClass('onError');
    			$('#email_addrTip').html('<?php echo L('sys_error')?>');
    		}
		});
    }

	function createPrev()
	{
		$('#step2').css('display', 'none');
		$('#pwd1,#pwd2').css('display', 'none');
		$('#step1').show('slow');
		$('#message').html('');
	}



    
    function checkSubmit2()
    {
        var flag = $('#username').val() == '' || $('#group_name').val() == '' || $('#addr').val() == '' || $('#email').val() == '';
		if (flag) {
			return true;
		}
		if ($('#pwd1').css('display') != 'none' && $('#password').val() == '') {
			return true;
		}
		$('#dosubmit9').val("loading...");
		$('#dosubmit9,#dosubmit3').attr('disabled', true);
		$('#message').html('');
		
			$.ajax({
				dataType: "json",
	    		url : $('#myform').attr('action'),
	    		cache: false,
	    		type: "POST",
	    		data: {
		    		act: "create", 
		    		email: $('#email_addr').val(),
		    		group_name: encodeURIComponent(trim($('#group_name').val())),
		    		group_addr: trim($('#addr').val()),
		    		descs: encodeURIComponent(trim($('#descs').val())),
		    		pwd: $('#password').val(),
		    		pwd2: $('#password2').val()
		    	},
	    		success : function(data){
					if (!data.status) {
						$('#message').html(data.message);
					} else {
						$('#step2').css('display', 'none');
						$('#step3').css('display', 'table');
						$('#step3_group_name').html(trim($('#group_name').val()));
						$('#step3_email').html($('#email_addr').val());
					}
					$('#dosubmit9,#dosubmit3').attr('disabled', false);
	    			$('#dosubmit9').val("<?php echo L('submit') ?>");
	    		},
	    		error: function() {
	    			$('#dosubmit9,#dosubmit3').attr('disabled', false);
	    			$('#dosubmit9').val("<?php echo L('submit') ?>");
	    			$('#message').html('<?php echo L('sys_error')?>');
		    	}
		});

		$('#activate_email_href').html('<?php echo L('now_activate')?>');
		$('#is_activate').val('0');
		return false;
    }
	
	function isSndaUser() {
		var snda_user = "<?php echo L('snda_user') ?>";
		var not_snda_user = "<?php echo L('not_snda_user') ?>";
		if ($('#pass_confirm').css('display') == 'table-row') {
			$('#is_snda_user_tips').html(not_snda_user);
			$('#pass_confirm').css('display', 'none');
			$('#snda_user').val(1);
			$("#password2").attr("disabled",true).unFormValidator(true);
		} else {
			$('#is_snda_user_tips').html(snda_user);
			$('#pass_confirm').css('display', 'table-row');
			$('#snda_user').val(0);
			$("#password2").attr("disabled",false).unFormValidator(false);
		}

	}
	
	function activateEmail()
	{
		if ($('#is_activate').val() == '1') {
			$.ajax({
				dataType: "json",
	    		url : $('#myform').attr('action'),
	    		type: "POST",
	    		data: {
		    		act: "activate"
		    	},
	    		success : function(data){
					if (!data.status) {
						$('#message').html(data.message);
						return false;
					}
					location.href = '?m=maillist&c=maillist&a=maillist_mgr&menuid=' + $('#menuid').val() + '&pc_hash=' + $('#pc_hash').val();
	    		}
			});
			return false;
		}
		var email = $('#email_addr').val();
		if (email.indexOf('@') == -1) {
			return false;
		}
		var emails = email.split('@');
		domain = emails[1].toLowerCase();		
		
		var url = 'http://' + (domain == 'gmail.com' ? 'www.' : 'mail.') + domain;
		$('#activate_email_href').attr('href', url);
		$('#is_activate').val('1');
		$('#activate_email_href').html('<?php echo L('activate')?>');
		$('#activate_email').css('display', 'table-row');
		$('#change_email').css('display', 'table-row');
	}

	function repeatSendEmail()
	{
		$.ajax({
			dataType: "json",
    		url:$('#myform').attr('action'),
    		type:"POST",
    		data:{act: "repeat_send_email",email: $('#email_addr').val()},
    		success: function(data){
				if (!data.status) {
					$('#message').html(data.message);
					return false;
				}
				$('#activate_email_href').html('<?php echo L('now_activate')?>');
				$('#is_activate').val('0');
				$('#activate_email').css('display', 'none');
				$('#change_email').css('display', 'none');
    		}
		});
		return true;
	}

	function changeEmail()
	{
		var email = $('#new_email').val();
		$('#email_addr').val(email);
		$('#step3').css('display', 'none');
		$('#activate_email').css('display', 'none');
		$('#change_email').css('display', 'none');
		createPrev();
	}	
</script>
