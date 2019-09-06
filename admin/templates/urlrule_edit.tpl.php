<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form action="?mod=phpcms&file=urlrule&action=edit&urlruleid=<?=$urlruleid?>" method="post" name="myform">
<table cellpadding="2" cellspacing="1" class="table_form">
    <caption>修改URL规则</caption>
    <tr>
      <th width="20%"><strong>URL规则名称</strong></th>
      <td><input type="text" name="data[file]" value="<?=$file?>" size="30" require="true" datatype="require" msg="URL名称不能为空"><font color="red">*</font></td>
    </tr>
    <tr>
    <th><strong>模块名称</strong></th>
    <td>
     <select name="data[module]" require="true" msg="请选择模块" datatype="custom"  regexp="[^0\s*]$">
        <option value='-1'>不限</option>
        <?php
        if(is_array($MODULE)){
            foreach($MODULE as $k=>$m){
                $selected = $module==$k ? "selected" : "";
                echo "<option value='".$k."' $selected>".trim($m['name'])."</option>\n";
            }
        }
        ?>
        </select>
       </td>
     </tr>
     <tr>
      <th ><strong>静态URL规则</strong><br/>生成静态页面调用的URL规则</th>
      <td>
        <input type="radio" value="1" name="data[ishtml]"  <?php if ($ishtml == 1){ ?>checked="checked"<?php }?> class="radio_style"/>是
        <input type="radio" value="0" name="data[ishtml]" <?php if ($ishtml == 0){?>checked="checked"<?php }?> class="radio_style"/>否
    </td>
    </tr>
    <tr>
      <th><strong>URL规则</strong></th>
      <td>
      <input type="text" name="data[urlrule]" value="<?=$urlrule?>" style="width:90%" require="true" datatype="require" msg="URL规则不能为空" />
      </td>
    </tr>
    <tr>
      <th><strong>URL规则样例</strong></th>
      <td>
      <input type="text" name="data[example]" value="<?=$example?>" style="width:90%" /></td>
    </tr>
    <tr>
      <th></th>
      <td>
	  <input type="hidden" name="forward" value="?mod=phpcms&file=urlrule&action=manage">
	  <input type="submit" name="dosubmit" value=" 确定 ">
      &nbsp; <input type="reset" name="reset" value=" 清除 ">
	  </td>
    </tr>	
</table>
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
$().ready(function() {
	 $('form').checkForm(1);
	});
</script>