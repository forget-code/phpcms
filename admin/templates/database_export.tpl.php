<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
	<?php
		foreach($alltables as $name=>$tables) if($tables){
	?>
	<table cellpadding="0" cellspacing="1" class="table_list">
	  	<caption><?=$name=='phpcmstables' ? 'Phpcms' : '其它'?>数据库备份</caption>
		<form method="post" name="myform<?=$name?>" id="myform<?=$name?>" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&tabletype=<?=$name?>">
		<tr>
			<th width="15%"><a href="###" onClick="javascript:$('input[type=checkbox]').attr('checked', true)">全选</a>/<a href="###" onClick="javascript:$('input[type=checkbox]').attr('checked', false)">取消</a></th>
			<th>数据库表</th>
			<th width="10%">记录条数</th>
			<th width="15%">使用空间</th>
		</tr>
		<?php
		if(is_array($tables)) foreach($tables as $k => $tableinfo){
		?>
	 	<tr>
		    <td class="align_c"><input type="checkbox" name="tables[]" value="<?=$tableinfo['name']?>" checked /></td>
		    <td class="align_l"><?=$tableinfo['name']?></td>
		    <td class="align_c"><?=$tableinfo['rows']?></td>
			<td class="align_l"><?php echo sizecount($tableinfo['size']);?></td>
		</tr>
		<?php
		}
		?>
	  	<tr>
	    	<td class="tablerowhighlight" colspan=4>分卷备份设置</th>
	  	</tr>
	  	<tr>
		    <td class="align_r">每个分卷文件大小：</td>
		    <td colspan=3><input type=text name="sizelimit" value="2048" size=5> K</td>
	  	</tr>
	   	<tr>
		    <td class="align_r">建表语句格式：</td>
		    <td colspan=3><input type="radio" name="sqlcompat" value="" checked> 默认 &nbsp; <input type="radio" name="sqlcompat" value="MYSQL40"> MySQL 3.23/4.0.x &nbsp; <input type="radio" name="sqlcompat" value="MYSQL41"> MySQL 4.1.x/5.x &nbsp;</td>
	  	</tr>
	   	<tr>
		    <td class="align_r">强制字符集：</td>
		    <td colspan=3><input type="radio" name="sqlcharset" value="" checked> 默认 &nbsp; <input type="radio" name="sqlcharset" value="latin1"> LATIN1 &nbsp; <input type="radio" name="sqlcharset" value='utf8'> UTF-8</option></td>
	  	</tr>
	  	<tr>
		    <td></td>
		    <td colspan=3><input type="submit" name="dosubmit" value=" 开始备份数据 "></td>
	  	</tr>
		</form>
	</table>
	<?php
		}
	?>
</body>
</html>