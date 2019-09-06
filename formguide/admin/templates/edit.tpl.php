<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="">
	<table cellpadding="0" cellspacing="1" class="table_form">
    	<caption>修改表单<?=$name?></caption>
    	<tr>
    		<th><font color="red">*</font><strong>名称</strong></th>
    		<td>
       	 		<input type="text" name="info[name]" require="true" datatype="limit|ajax" min="1" max="10" msg="表单名称必须为大于1且小于10的字节数|" url="?mod=<?=$mod?>&file=<?=$file?>&action=checkmodel&formid=<?=$formid?>" value="<?=$name?>" />
        </td>
        	</td>
    	</tr>
    	<tr>
    		<th><font color="red">*</font><strong>表名</strong></th>
        	<td>
        		<input type="text" name="info[tablename]" require="true" datatype="limit|ajax" min="1" max="20" msg="表名必须为大于1且小于20的字节数|" url="?mod=<?=$mod?>&file=<?=$file?>&action=checktable&formid=<?=$formid?>" value="<?=$tablename?>" msgid="msgid2" readonly />
        	</td>
    	</tr>
    	<tr>
    		<th><strong>简介</strong></th>
        	<td>
        		<?=form::textarea('info[introduce]', 'introduce', $introduce, 10, 40)?>
        	</td>
    	</tr>
        <tr>
    		<th><strong>时间限制</strong></th>
        	<td>
        		<?=form::radio(array(1=>'启用', 0=>'不启用'), 'setting[enabletime]', 'enabletime', $enabletime)?>
        	</td>
    	</tr>
        <tr>
        	<th><strong>开始时间</strong></th>
            <td>
            	<?=form::date('setting[starttime]', $starttime)?>
            </td>
        </tr>
        <tr>
        	<th><strong>结束时间</strong></th>
            <td>
            	<?=form::date('setting[endtime]', $endtime)?>
            </td>
        </tr>
    	<tr>
    		<th><strong>允许发送邮件</strong></th>
       		<td>
        		<input type='radio' name='setting[allowsendemail]' value='1'  <?php if($allowsendemail){ ?>checked <?php } ?>>是
				<input type='radio' name='setting[allowsendemail]' value='0'  <?php if(!$allowsendemail){ ?>checked <?php } ?>>否
        	</td>
    	</tr>
    	<tr>
    		<th><strong>发送邮件的地址</strong></th>
        	<td>
        		<?=form::text('setting[email]', 'email', $email)?>  多个地址请用逗号隔开
        	</td>
    	</tr>
        <tr>
    		<th><strong>模板管理</strong></th>
        	<td>
        		<?=form::select_template($mod, 'info[template]', 'template', $template, '', 'form')?> &nbsp;<input type="button" value="修改选中模板" title="修改选中模板" onClick="location.href='?mod=phpcms&file=template&action=edit&template='+ $('#template').val()+'&module=<?=$mod?>&forward=<?=urlencode(URL)?>'">&nbsp;<input type="button" value="添加模板" title="添加模板" onClick="location.href='?mod=phpcms&file=template&action=add&module=<?=$mod?>&forward=<?=urlencode(URL)?>'">
        	</td>
    	</tr>
    	<tr>
    		<th></th>
        	<td><input type="submit" name="dosubmit" value="提交" />  <input type="reset" name="reset" value="重置" /></td>
    	</tr>
	</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
$('form').ready(function() {
  $('form').checkForm(1);
});
</script>