<?php
$modtitle[$mod] = "企业黄页";
$menu[$mod][] = array("<font color='0000ff'>更新链接</font>","?mod=".$mod."&file=createhtml");
$menu[$mod][] = array("<font color='#CC0000'>管理企业</font>","?mod=".$mod."&file=company&action=manage");
$menu[$mod][] = array("<font color='#CC0000'>新闻管理</font>","?mod=".$mod."&file=article&action=manage");
$menu[$mod][] = array("<font color='#CC0000'>产品管理</font>","?mod=".$mod."&file=product&action=manage");
$menu[$mod][] = array("<font color='#CC0000'>求购管理</font>","?mod=".$mod."&file=buy&action=manage");
$menu[$mod][] = array("<font color='#CC0000'>促销管理</font>","?mod=".$mod."&file=sales&action=manage");
$menu[$mod][] = array("<font color='#CC0000'>招聘管理</font>","?mod=".$mod."&file=job&action=manage");
$menu[$mod][] = array("<font color='#CC0000'>求职管理</font>","?mod=".$mod."&file=apply&action=manage");
$menu[$mod][] = array("新闻分类管理","?mod=".$mod."&file=trade&action=manage&script=article");
$menu[$mod][] = array("产品分类管理","?mod=".$mod."&file=category&action=manage");
$menu[$mod][] = array("促销分类管理","?mod=".$mod."&file=trade&action=manage&script=sales");
$menu[$mod][] = array("求购分类管理","?mod=".$mod."&file=trade&action=manage&script=buy");
$menu[$mod][] = array("行业分类管理","?mod=".$mod."&file=trade&action=manage&script=trade");
$menu[$mod][] = array("区域管理","?mod=phpcms&file=area&action=manage&keyid=".$mod);
$menu[$mod][] = array("模块配置","?mod=".$mod."&file=setting");
$menu[$mod][] = array("产品自定义字段","?mod=phpcms&file=field&action=manage&keyid=yp&tablename=".$CONFIG['tablepre']."yp_product");
$menu[$mod][] = array("求购自定义字段","?mod=phpcms&file=field&action=manage&keyid=yp&tablename=".$CONFIG['tablepre']."yp_buy");
$menu[$mod][] = array("促销自定义字段","?mod=phpcms&file=field&action=manage&keyid=yp&tablename=".$CONFIG['tablepre']."yp_sales");
$menu[$mod][] = array("企业自定义字段","?mod=phpcms&file=field&action=manage&keyid=yp&tablename=".$CONFIG['tablepre']."member_company");
$menu[$mod][] = array("标签调用管理","?mod=".$mod."&file=tag");
$menu[$mod][] = array("黄页频道模板","?mod=phpcms&file=template&module=".$mod);
$menu[$mod][] = array("企业模板","?mod=".$mod."&file=companytpl");
$menu[$mod][] = array("黄页公告","?mod=announce&file=announce&action=manage&keyid=".$mod);
$menu[$mod][] = array("黄页投票","?mod=vote&file=vote&keyid=$mod");
?>