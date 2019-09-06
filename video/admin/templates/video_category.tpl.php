<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/form.js"></script>
<script type="text/javascript" src="images/js/jqModal.js"></script>
<script type="text/javascript" src="images/js/jqDnR.js"></script>
<body>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&catid=<?=$catid?>&modelid=<?=$modelid?>" method="post" name="myform"  enctype="multipart/form-data">
<div id='Tabs0' style='display:'>
<input type="hidden" name="dosubmit" value="1" />
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>上传视频-选择栏目</caption>
<tr>
      <th width="20%"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <strong><?=$info['name']?></strong> <br />
	  <?=$info['tips']?>
	  </th>
      <td><?=$info['form']?> </td>
    </tr>
</table>
</div>

</body>
</html>