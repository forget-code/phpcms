<?php
/**
 * Description:
 * 
 * Encoding:    UTF-8
 * Created on:  2012-4-16-下午5:48:04
 * Autdor:      kangyun
 * Email:       KangYun.Yun@Snda.Com
 */

defined ( 'IN_ADMIN' ) or exit ( 'No permission resources.' );

include $this->admin_tpl ( 'header', 'admin' );
?>


<div class="pad-10">
    <form
        action="?m=maillist&c=maillist&a=send_setting&menuid=<?php echo $menuid;?>&pc_hash=<?php echo $pc_hash;?>"
        name="myform" id="myform" method="post">
        <input type="hidden" name="act" id="act" value="update" />
        <input type="hidden" name="menuid" id="menuid" value="<?php echo $menuid;?>" />
        <input type="hidden" name="pc_hash" id="pc_hash" value="<?php echo $pc_hash;?>" />
        <table border="0" cellpadding="1" cellspacing="1"
            class="table_form" width="100%">
            <tr>
                <td style="padding-left: 16%"><label><?php echo L('rss_enabled')?></label>&nbsp;&nbsp;&nbsp;<input
                    type="radio" name="rss_enabled"
                    id="rss_enabled_true" <?php echo $row['rss_enabled'] ? 'checked' : '' ?> class="radio"
                    onchange="isEnabledRss()" value="1" />&nbsp;<label><?php echo L('rss_enabled_open')?></label><input
                    onchange="isEnabledRss()" <?php echo !$row['rss_enabled'] ? 'checked' : '' ?> type="radio" value="0"
                    id="rss_enabled_false" name="rss_enabled"
                    class="radio" />&nbsp;<label><?php echo L('rss_enabled_close')?></label></td>
            </tr>
            <tr>
                <td><table width="100%" border="0" cellspacing="0"
                        cellpadding="0" id="rss_setting">
                        <tr class="table_form">
                            <td width="15%">&nbsp;</td>
                            <td width="85%" style="color: #999999"><?php echo L('rss_enabled_tips')?></td>
                        </tr>
                        <!-- 
                        <tr class="table_form">
                            <td height="59">&nbsp;</td>
                            <td style="padding-bottom: 10px"><b><?php echo L('rss_source')?>：</b><br />
                                <select name="sys_rss" id="sys_rss" onchange="getRssItem(this.value)">
                                    <option value="">-<?php echo L('rss_source_option')?>-</option>
                            </select>
                                <div id="item_list"
                                    style="width: 300px; margin-top: 15px">
                                </div>
                                
                                </td>
                        </tr>
                         -->
                        <tr class="table_form">
                            <td valign="top">&nbsp;</td>
                            <td valign="top"><b><?php echo L('rss_url')?>：</b><br>
                                <textarea name="rss_url" cols="" rows=""
                                    id="rss_url"
                                    style="width: 400px; height: <?php $pos = substr_count($row['rss_url'], ";"); echo ($pos > 0) ? ($pos * 18) + 10 : 50 ?>px;"><?php echo str_replace(";", ";\n", str_replace(array("\r\n", "\r", "\n"), "", $row['rss_url']));?></textarea>
                                <!-- <br /> <span style="color: #999999"><?php echo L('rss_url_tips')?></span> --></td>
                        </tr>
                        <tr class="table_form">
                            <td style="line-height: 24px">&nbsp;</td>
                            <td style="line-height: 24px"><b><?php echo L('rss_rate')?>：</b><br />
                    <?php echo L('rss_rate_option')?>：
                    <select name="bind_rss_rate" id="bind_rss_rate">
                                    <option selected="" value="0"><?php echo L('rss_day')?></option>
                                    <option value="1"><?php echo L('rss_week')?></option>
                                    <option value="2"><?php echo L('rss_month')?></option>
                            </select> <br />
                    <?php echo L('rss_number_option')?>：
                    <select name="bind_rss_number" id="bind_rss_number">
                                    <option value="1"><?php echo L('rss_one')?></option>
                                    <option selected="" value="2"><?php echo L('rss_two')?></option>
                                    <option value="3"><?php echo L('rss_three')?></option>
                                    <option value="4"><?php echo L('rss_four')?></option>
                                    <option value="5"><?php echo L('rss_five')?></option>
                                    <option value="6"><?php echo L('rss_six')?></option>
                                    <option value="7"><?php echo L('rss_seven')?></option>
                                    <option value="8"><?php echo L('rss_eight')?></option>
                                    <option value="9"><?php echo L('rss_nine')?></option>
                                    <option value="10"><?php echo L('rss_ten')?></option>
                            </select></td>
                        </tr>
                        <tr class="table_form">
                            <td>&nbsp;</td>
                            <td><br /> <input type="submit"
                                class="button"
                                id="dosubmit" name="dosubmit"
                                style="width: 90px"
                                value="<?php echo L('submit')?>" />
                                <div
                                    style="background: #E2F0FF; padding: 20px; margin: 10px; width: 450px; line-height: 20px">
                                    <p>
                                        <strong><?php echo L('rss_tips1')?>：</strong>
                                    </p>
                                    <p> <?php echo L('rss_tips2')?> <a
                                            href="<?php echo L('o_web_url')?>"
                                            target="_blank"
                                            style="color: #0066FF">o.sdo.com</a>
                                    </p>
                                    <p><?php echo ''?></p>
                                </div></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table></td>
            </tr>
        </table>
    </form>
</div>

<script type="text/javascript">
	var rss_enabled = '<?php echo empty($row['rss_enabled']) ? '0' : $row['rss_enabled'] ?>';
	var rss_source = '<?php echo $row['rss_sys_source'] ?>';
	var rss_item = '<?php echo $row['rss_sys_item'] ?>,';
	var rss_rate = '<?php echo $row['rss_rate'] ?>';
	var rss_number = '<?php echo $row['rss_number'] ?>';
	var rss_url = '<?php echo str_replace(array("\r\n", "\n", "\r"), '', join(';', $row['rss_array']));?>'

	$(document).ready(function(){
		$('#bind_rss_rate').val(rss_rate);
		$('#bind_rss_number').val(rss_number);
		$('#sys_rss').val(rss_source);
		isEnabledRss();
		//getRssItem('0');
	});
	
	function isEnabledRss()
	{
		var is_disabled = true;
		var color = "#cccccc";
		if ($('#rss_enabled_true').attr('checked')) {
		 	is_disabled = false;
			color = "#333333";
		}

		$('#rss_setting input').attr("disabled",  is_disabled).css("color",  color);
		$('#rss_setting textarea').attr("disabled",  is_disabled).css("color", color);
		$('#rss_setting select').attr("disabled",  is_disabled).css("color", color);
		$('#dosubmit').attr('disabled', false).css("color", '#333333');
	}

	function getRssItem(value)
	{
		if (value == '') {
			$('#item_list').html('');
			return false;
		}
		
		$('#item_list').html('loading...');
		$.ajax({
			dataType: "json",
    		url : $('#myform').attr('action'),
    		type: "POST",
    		data: {
	    		act: "get_rss_item", 
	    		cat_id: value
	    	},
    		success : function(data){
    			$('#item_list').html('');
    			var rss = data.rss_array;
        		if (value == '0') {
            		var id = 0;
        			var option = '<option value="">-<?php echo L('rss_source_option')?>-</option>';
        			for (var i = 0; i < rss.length; i++) {
        				option += '<option value="'+ rss[i].id + '"';
        				option += '>' + rss[i].name + '</option>';
        			}
        			$('#sys_rss').empty();
        			$('#sys_rss').append(option);
       			
        			return;
        		}
    			
    			var html = '';
    			var urls = $("#rss_url").val();
    			var reg = new RegExp("\n", "g");
    			urls = urls.replace(reg, "");
    			rss_url = urls + rss_url;
    			var rss_items = [];
    			if (rss_url != '') {
        			var items = rss_url.split(';');
        			for (var i = 0; i < items.length; i++) {
            			if (items[i] != '') {
            				rss_items.push(items[i]);
            			}
            		}
        		}
        
    			for (var i = 0; i < rss.length; i++) {
        			html += '<div style="width: 150px; float: left"><input onchange="selectRss(this)" type="checkbox" name="rss_sys_item[]" value="'+ rss[i].url +'" ';
        			for (var k = 0; k < rss_items.length; k++) {
            			if (rss[i].url == rss_items[k]) {
            				html += 'checked ';
            				break;
            			}
        			}
        			html += '/> '+ rss[i].name + '</div>';
    			}	
    			$('#item_list').html(html);
    			isEnabledRss();
    		}
		});
	}

	function selectRss(obj)
	{
		var urls = $('#rss_url').val();
		if (urls == '') {
			$('#rss_url').val(obj.value + ";\n");
			return true;
		}
		var reg = new RegExp("\n", "g");
		urls = urls.replace(reg, "");
		if (urls.substr(urls.length - 1, urls.length) != ';') {
			urls += ';';
		}
		var data = urls.split(';');
		var result = [];
		var flag = false;
		for (var i = 0; i < data.length; i++) {
			if (data[i] == obj.value) {
				flag = true;
				break;
			}
		}

		if (obj.checked && !flag) {
			$('#rss_url').val(data.join(";\n") + obj.value + ";\n");
			$('#rss_url').css('height', data.length * 18 + 10);
		} else if (!obj.checked && flag) {
			data[i] = '';
			for (var k = 0; k < data.length; k++) {
				if (data[k] != '') {
					result.push(data[k]);
				}
			}
			$('#rss_url').val(result.join(";\n"));
			$('#rss_url').val($('#rss_url').val() + ";");
			$('#rss_url').css('height', result.length * 18 + 10);
		}

	}
	
	
</script>
