<?php
$modtitle[$mod] = "表单向导";
$menu[$mod][] = array("表单管理","?mod=".$mod."&file=form&action=manage");
$menu[$mod][] = array('表单模板','?mod=phpcms&file=template&module='.$mod);
$menu[$mod][] = array('表单标签调用','?mod='.$mod.'&file=tag');
$menu[$mod][] = array('模块配置','?mod='.$mod.'&file=setting');
?>