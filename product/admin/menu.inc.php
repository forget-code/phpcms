<?php
$modtitle[$mod] = "商城管理";
$menu[$mod][] = array("<font color=red>商品管理首页</font>","?mod=".$mod."&file=product&action=main");
$menu[$mod][] = array("商品分类","?mod=".$mod."&file=category&action=manage");
$menu[$mod][] = array("商品列表","?mod=".$mod."&file=product&action=manage");
$menu[$mod][] = array('更新商品html','?mod='.$mod.'&file=createhtml');
$menu[$mod][] = array("商品类型/属性","?mod=".$mod."&file=property&action=manage");
$menu[$mod][] = array("商品品牌","?mod=".$mod."&file=brand&action=manage");
$menu[$mod][] = array("订单列表","?mod=".$mod."&file=order&action=manage");
$menu[$mod][] = array("商品公告","?mod=announce&file=announce&action=manage&keyid=".$mod);
$menu[$mod][] = array("附属分类","?mod=phpcms&file=type&action=setting&keyid=".$mod);
$menu[$mod][] = array("推荐位置","?mod=phpcms&file=position&keyid=".$mod);
$menu[$mod][] = array("模块配置","?mod=".$mod."&file=setting");
$menu[$mod][] = array("商品模板","?mod=phpcms&file=template&module=$mod");
$menu[$mod][] = array("商品标签调用","?mod=$mod&file=tag");
?>