<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&placeid=<?=$placeid?>&dosubmit=1" method="post" name="myform">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>编辑广告位</caption>
    <tr>
      <th width="25%"><strong>广告位名称</strong></th>
      <td>
        <input size=40 name="place[placename]" type="text" value="<?php echo $place['placename']; ?>" require="true" datatype="require" msg="广告位名称不能为空">
    </td>
    </tr>
   <tr>
	<th><strong>广告位介绍</strong></th>
	<td><input size=60 name="place[introduce]" type="text" value="<?php echo $place['introduce']; ?>"></td>
	</tr>
	<tr>
	<th><strong>广告价格</strong></th>
	<td>
	   <input size=6 name="place[price]" type="text" value="<?php echo $place['price']; ?>" require="false" datatype="double" msg="请输入正确的格式" msgid="msgid1"> 元/月<span id="msgid1"/>
	</td>
	</tr>
	<tr>
      <th><strong>广告位模板</strong></th>
      <td>
	  <?=form::select_template('ads', 'place[template]', 'template', $place['template'], '', 'ads');?>
    </td>
    </tr>
    <tr>
      <th><strong>广告位高度</strong></th>
      <td><input size=5 name="place[height]" type="text" value="<?php echo $place['height']; ?>" require="true" datatype="number" msg="请输入数字" msgid="height"> px<span id="height"/></td>
    </tr>
    <tr>
      <th><strong>广告位宽度</strong></th>
      <td><input size=5 name="place[width]" type="text" value="<?php echo $place['width']; ?>" require="true" datatype="number" msg="请输入数字" msgid="width"> px <span id="width"/></td>
    </tr>

	<tr>
       <th><strong>多个广告时</strong></th>
       <td><input type='radio' name='place[option]' value='1' <?php if($place['option']) { ?>checked<?php } ?>> 全部列出 <input type='radio' name='place[option]' value='0' <?php if($place['option']==0) { ?>checked<?php } ?>> 随机列出一个</td>
     </tr>
     <tr>
       <th><strong>是否启用</strong></th>
       <td><input type='radio' name='place[passed]' value='1' <?php if($place['passed']) { ?>checked<?php } ?>>是<input type='radio' name='place[passed]' value='0' <?php if($place['passed']==0) { ?>checked<?php } ?>>否</td>
     </tr>
   <tr>
     <th></th>
     <td><input type="submit" name="submit" value=" 修改 ">&nbsp;<input type="reset" name="reset" value=" 清除 "></td>
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