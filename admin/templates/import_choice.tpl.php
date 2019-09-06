<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>" >
<input type="hidden" name="name" value="<?=$name?>" >
<input type="hidden" name="type" value="<?=$type?>" >
<input type="hidden" name="action" value="setting">
	<table cellpadding="0" cellspacing="1" class="table_form">
    	<caption>外部数据导入配置</caption>
    	<tr>
        	<th width="15%"><strong>选择要导入的模型</strong></th>
			<td>
            	<?php
					if($type == 'content')
					{
				?>
					<?=form::select_model('contentmodelid', 'contentmodelid', '请选择', $modelid, '')?>
            	<?php
					}elseif($type == 'member'){
				?>
					<?=form::select_member_model('membermodelid', 'membermodelid', '请选择', $modelid, '')?>
                <?php
					}
				?>
            </td>
        </tr>
        <tr>
			<td></td>
            <td>
            <input type="submit" name="submit" value="提交" />
            <input type="reset" name="reset" value="重置" />
            </td>
        </tr>
    </table>
</form>
</body>
</html>