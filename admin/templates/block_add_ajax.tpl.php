<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&ajax=<?=$ajax?>" method="post" name="myform">
<input type="hidden" name="forward" value="<?=$forward?>"> 
<input type="hidden" name="info[pageid]" value="<?=$pageid?>"> 
<input type="hidden" name="info[blockno]" value="<?=$blockno?>"> 
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>添加碎片</caption>
      <th width="20%"><font color="red">*</font> <strong>碎片名称</strong></th>
      <td><input type="text" name="info[name]" size="40" require="true" datatype="limit" min="2" max="20" msg="不得少于2个或超过20个字符！"></td>
    </tr>
	<tr> 
      <th><font color="red">*</font> <strong>排序权值</strong><br /> 越小排序越靠前</th>
      <td><input type="text" name="info[listorder]" id="listorder" size="5" value="<?=$listorder?>"></td>
    </tr>
	<tr> 
      <th><font color="red">*</font> <strong>碎片格式</strong></th>
      <td>
	  <input type="radio" name="info[isarray]" id="isarray" value="1" checked onclick="$('#data_rows').show();"> 格式化碎片（输入标题、链接、缩略图、日期、简介）<br/>
	  <input type="radio" name="info[isarray]" id="isarray" value="0" onclick="$('#data_rows').hide();"> 代码碎片（输入html代码）
	  </td>
    </tr>
	<tbody id="data_rows" style="display:">
	<tr> 
      <th><font color="red">*</font> <strong>数据行数</strong></th>
      <td><input type="text" name="info[rows]" id="rows" size="5" value="6" require="true" datatype="integer" msg="请输入整数！"> 行</td>
    </tr>
	</tbody>
	<tr> 
      <th><strong>更新权限</strong></th>
      <td><?=form::checkbox($ROLE, 'roleids', 'roleids', '', 5);?></td>
    </tr>
    <tr> 
      <td></td>
      <td> 
      <input type="submit" name="dosubmit" value=" 下一步 "> 
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
      
	  </td>
    </tr>
</table>
</form>
<script type="text/javascript">
$().ready(function(){
	$('form').checkForm(1);
});
</script>
</body>
</html>