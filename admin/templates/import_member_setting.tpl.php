<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myfrom" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<input name="setting[modelid]" type="hidden" value="<?=$setting['modelid']?>">
<input name="setting[dataname]" type="hidden" value="<?=$setting['dataname']?>">
<input name="type" type="hidden" value="<?=$type?>">
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>会员数据导入配置</caption>
    <tr>
    	<th width="20%"><strong>配置名称：</strong><br />只能由小写字母和数字组成</th>
        <td><input type="text" name="setting[name]" value="<?=$name?>" require="true"  msg="不得为空"  datatype="limit" min="1" max="50" ></td>
    </tr>
    <tr>
    	<th><strong>配置说明：</strong></th>
        <td><input type="text" name="setting[note]" value="<?=$setting[note]?>" size="40" require="true"  msg="不得为空"  datatype="limit" min="1" max="50" ></td>
    </tr>
    <tr>
    	<th><strong>选择的数据库类型：</strong></th>
        <td>
		<select name="setting[dbtype]" id="dbtype" >
			<option value="mysql" <?=$setting[dbtype]=='mysql' ? 'selected' : ''?> >mysql</option>
			<option value="access" <?=$setting[dbtype]=='access' ? 'selected' : ''?>>access</option>
			<option value="mssql" <?=$setting[dbtype]=='mssql' ? 'selected' : ''?>>mssql</option>
		</select>
		</td>
    </tr>
	<tr>
		<th><strong>数据库主机：</strong></th>
		<td><input type="text" id="dbhost" name="setting[dbhost]" value="<?=$setting[dbhost]?>" size="20" require="true"  msg="不得为空"  datatype="limit" min="1" max="50" ></td>
	</tr>
	<tr>
		<th><strong>数据库用户名：</strong></th>
		<td><input type="text" id="dbuser" name="setting[dbuser]" value="<?=$setting[dbuser]?>" size="20" require="<?=($setting[dbhost]=='mysql')? 'true': 'false'?>"  msg="不得为空"  datatype="limit" min="1" max="50" ></td>
	</tr>
	<tr>
		<th><strong>数据库密码：</strong></th>
		<td><input type="text" id="dbpw" name="setting[dbpw]"  require="<?=($setting[dbhost]=='mysql')? 'true': 'false'?>"  msg="不得为空"  datatype="limit" min="1" max="50" value="<?=$setting[dbpw]?>" size="20" onblur="if($('#dbtype').val() == 'mysql') {$('#database_seleced').load('?mod=phpcms&file=import&action=get_database&dbhost='+$('#dbhost').val()+'&dbtype='+$('#dbtype').val()+'&dbuser='+$('#dbuser').val()+'&dbpw='+$('#dbpw').val()+'&dbname=&charset='+$('#charset').val());$('#database_seleced').show();}"></td>
	</tr>
	<tr id="db_charset">
		<th><strong>数据库字符集：</strong></th>
		<td>
		<?=form::radio(array('gbk'=>'GBK', 'gb2312'=>'gb2312', 'utf8'=>'UTF8','latin1'=>'latin1'), 'setting[charset]', 'dbcharset', $setting['charset'], 5, '' , '', 65)?>
		</td>
	</tr>
	<tr>
		<th><strong>数据库名称：</strong></th>
		<td><input type="text" id="dbname" name="setting[dbname]" value="<?=$setting[dbname]?>" size="20" require="true"  msg="不得为空"  datatype="limit" min="1" max="50" onchange="get_tables(this.value)" >&nbsp;<select id="database_seleced" style="display:none" onchange="$('#dbname').val(this.value);get_tables();"></select>&nbsp;<a href="#" id="testdb">测试连接数据库</a></td>
	</tr>
    <tr>
    	<th><strong>数据表：</strong></th>
        <td><input type="text" id="db_tables" name="setting[table]" value="<?=$setting[table]?>" size="40" require="true"  msg="不得为空"  datatype="limit" min="1" max="50"  /> <span id="select_tables"></span> <input type="button" value="查询" onclick="get_tables()"> 多个表请用逗号分隔</td>&nbsp;
    </tr>
	<tr>
		<th><strong>数据提取条件：</strong></th>
		<td><input type="text" name="setting[condition]" value="<?=$setting[condition]?>" size="40" /></td>
	</tr>
	<tr>
		<th><strong>上次导入最大ID：</strong></th>
		<td><input type="text" name="setting[maxid]" value="<?=$setting['maxid'] ? $setting['maxid'] : 0?>" size="10" /></td>
	</tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>数据表字段对应关系</caption>
    <tr>
    	<th width="25%"><strong class="align_right"><?=$MODEL[$modelid][name]?>模型字段</strong></th>
        <th class="align_left"><strong>源数据表用户字段</strong></th>
		<th width="15%" class="align_left"><strong>默认值</strong></th>
        <th width="25%" class="align_left"><strong>处理函数</strong></th>
    </tr>
    <?php
		if(is_array($fields) && !empty($fields))
		{
			foreach($fields as $k=>$field)
			{
	?>
    <tr>
    	<th><strong><?=$field[name]?>&nbsp;(<?=$k?>)：</strong></th>
        <td class="list_fields"><input name="setting[<?=$k?>][field]" id="field_<?=$k?>" class="fields" type="text" value="<?=$setting[$k][field]?$setting[$k][field]:''?>" > <span></span></td>
		<td><input type="text" name="setting[<?=$k?>][value]" value="<?=$setting[$k][value]?$setting[$k][value]:''?>" ></td>
        <td><input require="false" datatype="ajax" url="?mod=<?=$mod?>&file=<?=$file?>&action=test_func" msg="" name="setting[<?=$k?>][func]" type="text" value="<?=$setting[$k]['func']?$setting[$k]['func']:''?>" /></td>
    </tr>
    <?php
			}
		}
	?>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>用户组对应关系</caption>
    <tr>
    	<th width="20%"><strong>默认导入到用户组：</strong></th>
        <td>
        <?=form::select($GROUP, 'setting[defaultgroupid]')?>
        </td>
    </tr>
    <tr>
    	<th class="align_right"><strong>phpcms 会员组</strong></th>
        <th class="align_l"><strong>原系统会员组 ID</strong></th>
    </tr>
    <?php 
	foreach($GROUP as $k=>$g)
	{
	?>
    <tr>
    	<th><strong><?=$g?></strong></th>
        <td><input type="text" name="setting[groupids][<?=$k?>]" size="15" <?php if(isset($setting['groupids'][$k])){?>value="<?=$setting['groupids'][$k]?>" <?php } ?>> 多个ID请用逗号分隔</td>
    </tr>
    <?php
	}
	?>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>用户数据导入执行设置</caption>
	<tr>
		<th width="25%"><strong>是否检查同名帐号或同名邮件</strong><br>如果选“是”，则系统会自动丢弃同名帐号</th>
		<td><input type="radio" name='setting[membercheck]' value='1' <? if($setting['membercheck'] || empty($setting['membercheck'])) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name='setting[membercheck]' value='0' <? if($setting['membercheck'] == 0) { ?>checked<? } ?>> 否 </td>
	</tr>
    <tr>
    	<th><strong>每次提取并导入数据条数</strong></th>
        <td><input type="text" name="setting[number]" value="<?=$setting[number]?$setting[number]:100?>" size="20"> 条</td>
    </tr>
    <tr>
    	<th><strong>php脚本执行超时时限</strong><br />当数据较多时程序执行时间会较长</th>
        <td><input type="text" name="setting[expire]" value="<?=$setting[expire]?$setting[expire]:90?>"</td>
    </tr>
    <tr>
    	<th></th>
        <td colspan="2">
        <input type="submit" name="dosubmit" value=" 保存 "> &nbsp;&nbsp;
        <input type="reset" name="reset" value=" 清除 ">
        </td>
    </tr>
</table>
</form>
</body>
</html>
<script type="text/javascript">
$('#testdb').click(function(){
	$.get("?mod=<?=$mod?>&file=<?=$file?>&action=test", {dbtype:$('#dbtype').val(), dbhost:$('#dbhost').val(), dbuser:$('#dbuser').val(), dbpw:$('#dbpw').val(), dbname:$('#dbname').val()}, function(data) {
	if(data=='OK') 
	{
		alert('连接成功');
	}
	else
	{
		alert('连接失败');
	}
	});
});
var html='';
var id = '';
$(document).ready(function(){
$('form').checkForm(1);
if($("#dbtype").val()=='mysql')
{
	$("#db_charset").show();
}
else
{
	$("#db_charset").hide();
}
$(".fields").click(function(){
	$(".list_fields").children('span').html('&nbsp;');
	id = $(this).attr('id');
	if(html!='' && html != 'no')
	{
		$(this).parent('td').children('span').html(html);
	}
	else
	{
		html = $.ajax({
		type: "GET",
		url:"<?php echo SCRIPT_NAME ?>", 
		data:'mod=phpcms&file=import&action=get_fields&dbtype='+$('#dbtype').val()+'&dbhost='+$('#dbhost').val()+'&dbuser='+$('#dbuser').val()+'&dbpw='+$('#dbpw').val()+'&dbname='+$('#dbname').val()+'&charset='+$('#charset').val()+'&tables='+$('#db_tables').val()+'',
		async: false 
		}).responseText;
		if(html!='' && html != 'no')
		{
			$(this).parent('td').children('span').html(html);
		}
	}
});
})

$('#dbtype').change(function() {
	if(this.value == 'mysql')
	{
		$('#dbuser').attr('require', 'true');
		$('dbpw').attr('require', 'true');
	}
	else
	{	
		$('#dbuser').attr('require', 'false');
		$('dbpw').attr('require', 'false');
	}
});

function get_tables()
{
	if($('#dbtype').val() != 'mysql') return false;
	$.get("?mod=phpcms&file=import&action=get_tables",{dbtype:$('#dbtype').val(), dbhost:$('#dbhost').val(), dbuser:$('#dbuser').val(), dbpw:$('#dbpw').val(), dbname:$('#dbname').val(), charset:$('#charset').val()}, function(data){
		$("#select_tables").html(data);
	});
}

function put_fields(obj)
{
	if(obj!='')
	{
		$("#"+id).val(obj);
	}
}

function in_tables(val)
{
	if($('#db_tables').val()!='')
	{
		$('#db_tables').val($('#db_tables').val()+','+val);
	}
	else
	{
		$('#db_tables').val(val);
	}
}
</script>
