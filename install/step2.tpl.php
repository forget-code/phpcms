<?php include PHPCMS_ROOT.'install/header.tpl.php';?>
	<div class="content" style="height:350px; overflow:auto;"><?php echo format_textarea($license)?></div>
	<form id="install" action="install.php?" method="post">
<input type="hidden" name="step" value="3">
 </form>
<a href="javascript:history.go(-1);" class="btn">返回上一步：<?php echo $steps[--$step];?></a>
<a onClick="$('#install').submit();" class="btn"><span>同意协议，下一步</span></a>
  </div>
</div>
</body>
</html>

