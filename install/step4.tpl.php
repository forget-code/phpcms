<?php include PHPCMS_ROOT.'install/header.tpl.php';?>
	<div class="content">
	<form id="install" action="install.php?" method="post">
<input type="hidden" name="step" value="5">
<table width="100%" cellpadding="0" cellspacing="0">
<caption>核心模块</caption>
<tr><td><input type="checkbox" name="phpcms" value="phpcms" checked disabled><span class="disabletxt">Phpcms 主框架</span></td></tr>
<tr><td><input type="checkbox" name="member" value="member" checked  disabled><span class="disabletxt">会员模型</span></td></tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
<caption>功能模块，请选择需要安装的功能模块</caption>
<tbody id="openmodule" width="100%">
<?php
$count = count($PHPCMS_MODULES['name']);
$j = 0;
foreach($PHPCMS_MODULES['name'] as  $i=>$module)
{
	if($j%5==0) echo "<tr >";
?>
<td onmouseout="document.getElementById('introducetd').style.color='#ffff00';document.getElementById('introducetd').innerHTML='移动鼠标指针查看相应模块的描述';" onmouseover="showdescription('<font color=#ffffff><?=addslashes($PHPCMS_MODULES['introduce'][$i])?></font>');"><input type="checkbox" name="selectmod[]" value="<?=$module?>" checked <?php if($module=='pay'){?>disabled<?php } ?>><?=$PHPCMS_MODULES['modulename'][$i]?>模块</td>
<?php
	if($j%5==4) echo "</tr>";
$j++;
}
?>
</tbody>
</table>
<div id="introducetd"><font color="#ffff00">移动鼠标查看相应模块的描述</font></div>

 <table width="100%" cellpadding="0" cellspacing="0">
<caption>可选数据</caption>
<tr><td><input type="checkbox" name="testdata" value="1" checked><span class="disabletxt">默认测试数据</span> （用于新手和调试用户）</td></tr>
</table>
</form>
 </div>

<a href="javascript:history.go(-1);" class="btn">返回上一步：<?php echo $steps[--$step];?></a>
<a onClick="$('#install').submit();" class="btn"><span>下一步</span></a>
  </div>
</div>
</body>
</html>
