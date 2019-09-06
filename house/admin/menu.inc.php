<?php
$modtitle[$mod] = "房产管理";
$menu[$mod][] = array("<font color='blue'>更新房产html</font>","?mod=".$mod."&file=createhtml");
$menu[$mod][] = array("出租信息","?mod=".$mod."&file=infomgr&typeid=1&action=manage");
$menu[$mod][] = array("求租信息","?mod=".$mod."&file=infomgr&typeid=2&action=manage");
$menu[$mod][] = array('合租信息','?mod='.$mod.'&file=infomgr&typeid=3&action=manage');
$menu[$mod][] = array("出售信息","?mod=".$mod."&file=infomgr&typeid=4&action=manage");
$menu[$mod][] = array("求购信息","?mod=".$mod."&file=infomgr&typeid=5&action=manage");
$menu[$mod][] = array("置换信息","?mod=".$mod."&file=infomgr&typeid=6&action=manage");
$menu[$mod][] = array("新楼盘","?mod=".$mod."&file=display&action=manage");
$menu[$mod][] = array("区域管理","?mod=phpcms&file=area&action=manage&keyid=".$mod);
$menu[$mod][] = array("推荐位置","?mod=phpcms&file=position&keyid=".$mod);
$menu[$mod][] = array("<font color='red'>默认选项</font>","?mod=".$mod."&file=setting&action=option");
$menu[$mod][] = array("<font color='red'>模块配置</font>","?mod=".$mod."&file=setting");
$menu[$mod][] = array("房产公告","?mod=announce&file=announce&keyid=".$mod);
$menu[$mod][] = array("房产投票","?mod=vote&file=vote&keyid=".$mod);
$menu[$mod][] = array("房产单网页","?mod=page&file=page&keyid=".$mod);
$menu[$mod][] = array("房产评论","?mod=comment&file=comment&keyid=".$mod);
$menu[$mod][] = array("房产留言","?mod=guestbook&file=guestbook&keyid=".$mod);
$menu[$mod][] = array("房产模板","?mod=phpcms&file=template&module=$mod");
$menu[$mod][] = array("房产标签调用","?mod=$mod&file=tag");
?>