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
?><div class="pad-10">
    <form
        action="<?php echo $post_url;?>"
        method="post" enctype="multipart/form-data" name="myform"
        id="myform">
        <input type="hidden" name="action" id="action" value="batch_insert" />
        <input type="hidden" name="domain" id="domain" value="<?php echo $rows['domain']?>" />
        <input type="hidden" name="code" id="code" value="<?php echo $rows['code']?>" />
        <input type="hidden" name="sdid" id="sdid" value="<?php echo $rows['sdid']?>" />
        <input type="hidden" name="group_addr" id="group_addr" value="<?php echo $rows['group_addr']?>" />
        <input type="hidden" name="hash" id="hash" value="<?php echo $hash;?>" />
        <input type="hidden" name="back_url" value="<?php echo $pos_url . '&url=' . $en_url;?>" />
        <input name="menuid" type="hidden" value="<?php echo $menuid;?>" />
        <table width="100%" border="0" cellspacing="0" cellpadding="0"
            id="rss_setting">
            <tr class="table_form">
                <td width="4%">&nbsp;</td>
                <td width="96%"><b><?php echo L('subscribe_user')?>:</b></td>
            </tr>
            <tr class="table_form">
                <td height="59">&nbsp;</td>
                <td><div
                        style="background: none repeat scroll 0 0 #FFF8DB; padding: 10px 20px 5px; width: 600px; line-height: 30px">
				  <?php echo L('base')?>

                      <br />
                    <?php echo L('subscribe_count')?>：<font
                            color="#2279D4"><?php echo $row['brief_info']['base_total_account']?></font><?php echo L('p')?>   <?php echo L('unsubscribe_count')?>：<font
                            color="#2279D4"><?php echo $row['brief_info']['base_total_unsubscriber']?></font><?php echo L('p')?>   <?php echo L('theme')?>：<font
                            color="#2279D4"><?php echo $row['brief_info']['base_total_issued']?></font><?php echo L('a')?>   <?php echo L('send_count')?>：<font
                            color="#2279D4"><?php echo $row['brief_info']['base_total_success_mail']?></font>
                        <hr size="1" color="#CCCCCC" />
					<?php echo L('week_data')?> （<font color="#999999"><?php echo $row['brief_info']['weekly_start_date'] . L('to') . $row['brief_info']['weekly_end_date'];?></font>）<br>

<?php echo L('week_add_user')?>：<font color="#2279D4"><?php echo $row['brief_info']['weekly_new_account']?></font><?php echo L('p')?>   <?php echo L('week_unsubscribe_user')?>：<font
                            color="#2279D4"><?php echo $row['brief_info']['weekly_unsubscriber']?></font><?php echo L('p')?>   <?php echo L('week_theme')?>：<font
                            color="#2279D4"><?php echo $row['brief_info']['weekly_issued']?></font>
                        <br>
                    </div></td>
            </tr>
            <tr class="table_form">
                <td height="42" valign="top">&nbsp;</td>
                <td><b><?php echo L('batch_import')?>：</b></td>
            </tr>
            <tr class="table_form">
                <td style="line-height: 24px">&nbsp;</td>
                <td style="line-height: 30px"><input type="file"
                    name="user_list" /> &nbsp; <input type="submit"
                    id="dosubmit"
                    name="dosubmit" style="width: 90px; height: 20px"
                    value="<?php echo L('upload')?>" /> <br> <font
                    color="#999999"><?php echo L('batch_import_tips')?></font>
                    <br />
                <a href="<?php echo L('o_web_url')?>" target="_blank"
                    style="color: #0066FF"><?php echo L('o_web_tips')?></a></td>
            </tr>
            <tr class="table_form">
                <td>&nbsp;</td>
                <td><br /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </form>
</div>