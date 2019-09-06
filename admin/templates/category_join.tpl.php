<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=phpcms&file=category&action=join" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
<caption>
  合并栏目
</caption>
<tr>
<th width="45%"><strong>源栏目</strong></td>
<td>
<?=form::select_category($mod, 0, 'sourcecatid', 'sourcecatid', '请选择', '')?>  <font color="red">*</font>
</td>
</tr>
<tr>
<th><strong>目标栏目</strong></th>
<td width="60%">
<?=form::select_category($mod, 0, 'targetcatid', 'targetcatid', '请选择', '', 'onchange=\'check_category(this.value);\'')?>  <font color="red">*</font>
</td></tr>
<tr >
<th></th>
	<td>
		<input type="submit" id="dosubmit" name="dosubmit" value=" 合 并 " onClick="if(confirm('确认合并栏目吗？')) document.myform.action='?mod=phpcms&file=category&action=join';else return false;">
        <input type="reset" name="reset" value=" 重 置 ">
	</td>
</tr>
</table>
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function check_category(value)
	{
		var sourcecatid = $('#sourcecatid').val();
		$.ajax({
			type: "POST",
			url: '?',
			data:'mod=phpcms&file=category&action=checkcategory&sourcecatid='+sourcecatid+'&targetcatid='+value,
			success: function(msg){
			if(msg==-1)
			{
				alert('目标栏目必须与源栏目属于同一种模型');
				$('#dosubmit').attr('disabled','disabled');
			}
			else if(msg==-2)
			{
				alert('目标栏目下面有子栏目，请重新选择');
				$('#dosubmit').attr('disabled','disabled');
			}
			else if(msg==-3)
			{
				alert('目标栏目与源栏目相同，无需合并');
				$('#dosubmit').attr('disabled','disabled');
			}
			else if(msg==-4)
			{
				alert('父栏目不允许合并到子栏目，请重新选择');
				$('#dosubmit').attr('disabled','disabled');
			}
			else
			{
				$('#dosubmit').attr('disabled','');
			}
		}	
		}); 
	}
//-->
</SCRIPT>
<table cellpadding="0" cellspacing="1" class="table_info">
	<caption>提示信息</caption>
    <tr>
    	<td>源栏目的信息全部转入目标栏目，同时删除源栏目和其子栏目</td>
    </tr>
</table>
</body>
</html>