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
        action="?m=maillist&c=maillist&a=maillist_mgr&menuid=<?php echo $menuid;?>&pc_hash=<?php echo $pc_hash;?>"
        name="myform" id="myform" method="post">
        <input name="menuid" type="hidden" value="<?php echo $menuid;?>" />
        <table border="0" cellpadding="1" cellspacing="1"
            class="table_form" width="100%">

            <tr>
                <td align="right" width=180><?php echo L('group_name'); ?>：</td>
                <td><input name="group_name" type="text"
                    class="input-text" id="group_name" value="<?php echo $row['group_name']?>" size="30" /></td>
            </tr>
            <tr>
                <td align="right"><?php echo L('group_addr'); ?>：</td>
                <td><input name="addr" type="text" class="input-text"
                    id="addr" size="30" value="<?php echo $row['group_addr']?>" disabled /> </td>
            </tr>
            <tr>
                <td align="right"><?php echo L('send_email'); ?>：</td>
                <td><input name="email" type="text" class="input-text"
                    id="email" size="30" value="<?php echo $row['email']?>"  disabled />
                    </span>
                    </td>
            </tr>
            <tr>
                <td align="right" valign="top"><?php echo L('group_intro'); ?>：</td>
                <td valign="top"><textarea name="descs" cols="" rows=""
                        id="descs" style="width: 300px; height: 60px;"><?php echo $row['descs']?></textarea></td>
            </tr>
            <tr>
                <td height="64" align="right" class="t">&nbsp;</td>
                <td><input type="submit" class="button"
                    onclick="return checkSubmit()" id="dosubmit"
                    name="dosubmit" style="width:90px" value="<?php echo L('submit'); ?>" />
                    <span style="color:#ff0000; padding-left:20px"><?php
                    $email = explode('@', $row['email']);
                    $domain = $email[1];
                    echo $row['is_activate'] == 0 ? L('has_activate') . ' <a target="_blank" style="color:#0033FF" href="http://'. ((strtolower($domain) == 'gmail.com') ? 'www.' : 'mail.'). $domain .'">' . L('now_activate') . '</a>' : '' 
                    ?>
                    </td>
            </tr>
			<tr>
                <td height="77" align="right" class="t">&nbsp;</td>
                <td><a style="color: #2279D4" target="_blank" href="<?php echo L('o_web_url') ?>"><?php echo L('maillist_url_tips');?></a></td>
            </tr>
        </table>
    </form>
</div>
<script language="javascript" type="text/javascript"
    src="<?php echo JS_PATH; ?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript"
    src="<?php echo JS_PATH; ?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
	function trim(str){
	    return str ? str.replace(/^\s+|\s+$/g, "") : str;
	}
	
    $(document).ready(function(){
		var group_name_tips = "<?php echo L('group_name_tips') ?>";
		var descs_tips = "<?php echo L('group_intro_tips') ?>";

        $.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
		$("#group_name").formValidator({onshow: group_name_tips,onfocus: group_name_tips}).inputValidator({min:1, max:20,onerror:group_name_tips});
        $("#descs").formValidator({onshow: descs_tips,onfocus: descs_tips}).inputValidator({min:1,max:200,onerror: descs_tips});
    });

    function checkSubmit()
    {
        var flag = $('#username').val() == '' || $('#password').val() == '' || $('#group_name').val() == '' || $('#addr').val() == '' || $('#email').val() == '';
		if (flag) {
			return true;
		}
		/*
		flag = false;
		$('#dosubmit').attr('disabled', true);
		$('#dosubmit').val("loading...");
		$.ajax({
				dataType: "json",
				timeout: 40,
				async : false,
	    		url : $('#myform').attr('action'),
	    		type: "POST",
	    		data: {
		    		act: "update", 
		    		check_object: "username",
		    		snda_user_has: $('#snda_user').val(),
		    		pwd: $('#password').val(),
		    		pwd2: $('#password2').val()
		    	},
	    		success : function(data){
	                if (data.status) {
	                   
	                }
	                flag = data.status;
	    		}
		});
		$('#dosubmit').attr('disabled', false);
		$('#dosubmit').val("<?php echo L('submit') ?>");
		alert(flag);
		return false;*/
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
		
		function submitCheck()
		{
			if ($('#snda_user').val() == '1') {
				
			}
		}
	}
</script>
