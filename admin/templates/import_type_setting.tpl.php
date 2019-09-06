<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myfrom" method="post" action="?=<?=$mod?>&file=<?=$file?>&action=<?=$action?>">
<input name="setting[modelid]" type="hidden" value="<?=$setting[$name][modelid]?>">
<input name="setting[dataname]" type="hidden" value="<?=$setting[$name][dataname]?>">
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption><?=$name?>设置</caption>
    <tr>
    	<th><strong>配置名称：</strong><br />只能由小写字母和数字组成</th>
        <td><input type="text" name="setting[name]" value="<?=$name?>"></td>
    </tr>
    <tr>
    	<th><strong>配置说明：</strong></th>
        <td><input type="text" name="setting[note]" value="<?=$setting[note]?>" size="40"></td>
    </tr>
    <tr>
    	<th><strong>选择的数据源：</strong></th>
        <td><?=$dataname?></td>
    </tr>
    <tr>
    	<th><strong>数据表</strong></th>
        <td><input type="text" name="setting[table]" value="<?=$setting[table]?$setting[table]:$data[tablename]?>" size="40" />多个表请用逗号分隔</td>
    </tr>
	<tr>
		<th><strong>数据提取条件</strong></th>
		<td><input type="text" name="setting[condition]" value="<?=$setting[condition]?$setting[condition]:''?>" size="40" /></td>
	</tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>数据表字段对应关系</caption>
    <tr>
    	<th><strong><?=$MODEL[$modelid][name]?>模型字段</strong></th>
        <th><strong>需导入文章字段</strong></th>
        <th><strong>处理函数</strong></th>
    </tr>
    <?php
		if(is_array($fields) && !empty($fields))
		{
			foreach($fields as $k=>$field)
			{
	?>
    <tr>
    	<th><strong><?=$field[name]?>&nbsp;(<?=$k?>)：</strong></th>
        <td><input name="setting[<?=$k?>][field]" type="text" value="<?=$setting[$k][field]?$setting[$k][field]:''?>" ></td>
        <td><input name="setting[<?=$k?>][func]" type="text" value="<?=$setting[$k][func]?$setting[$k][func]:''?>" /></td>
    </tr>
    <?php
			}
		}
	?>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>栏目对应关系</caption>
    <tr>
    	<th><strong>导入到栏目：</strong></th>
        <td>
        <?=form::select($arr_cat, 'setting[defaultcatid]')?>
        </td>
    </tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>文章数据导入执行设置</caption>
    <tr>
    	<th><strong>每次提取并导入数据条数</strong></th>
        <td><input type="text" name="setting[number]" value="<?=$setting[number]?$setting[number]:100?>" size="20"> 条</td>
    </tr>
    <tr>
    	<th class="align_l"><strong>php脚本执行超时时限</strong><br />当数据较多时程序执行时间会较长</th>
        <td><input type="text" name="setting[expire]" value="<?=$setting[expire]?$setting[expire]:90?>"</td>
    </tr>
    <tr>
    	<th></th>
        <td colspan="2">
        <input type="submit" name="dosubmit" value="提交">
        <input type="reset" name="reset" value="取消">
        </td>
    </tr>
</table>
</form>
</body>
</html>
