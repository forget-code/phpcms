<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style type="text/css">
*{padding:0; margin:0; font-size:12px;}
a{ color:#333; text-decoration:none;}
a:hover{ color:#f90;}
li{ display:block; width:300px; height:60px; float:left; list-style:none; margin:10px 30px 10px 0;}
.clear{clear:both; }
.hr11{ background:#ccc; height:1px; overflow:hidden;}
dt{font-weight:bold;}
dl{background:url(yp/images/bg_yp_2.gif) no-repeat 8px 5px; padding-left:64px; height:60px; padding-top:6px;}
li.bk{background:url(yp/images/bg_yp.gif) no-repeat 8px 5px;}
#fast_b li a:hover{background:url(yp/images/bg_yp.gif) no-repeat 2px 0px; cursor:pointer;display:block;}
#fast_a,#fast_b{padding-left:120px;}
#fast_a li{ width:320px;}
#fast_b li{ height:59px; padding-left:6px;width:234px; padding-top:5px;}
dt,dd,li{ line-height:24px;}
.yp_icon1,.yp_icon2,.yp_icon3,.yp_icon4,.yp_icon5,.yp_icon6,.yp_icon7,.yp_icon8,.yp_icon9,.yp_icon10,.yp_icon11,.yp_icon12{background:url(yp/images/hy_icon.png) no-repeat 14px 14px;*background:url(yp/images/hy_icon.gif) no-repeat 14px 14px;height:60px;}
.yp_icon2{background-position:14px -80px;}
.yp_icon3{background-position:14px -170px;}
.yp_icon4{background-position:14px -270px;}
.yp_icon5{background-position:14px -360px;}
.yp_icon6{background-position:14px -450px;}
.yp_icon7{background-position:14px -530px;}
.yp_icon8{background-position:14px -620px;}
.yp_icon9{background-position:14px -705px;}
.yp_icon10{background-position:14px -795px;}
.yp_icon11{background-position:14px -885px;}
.yp_icon12{background-position:14px -985px;}
.icon_yp1,.icon_yp2,.icon_yp3,.icon_yp4{background:url(yp/images/icon_yp.jpg) no-repeat}
.icon_yp1{background-position:0 -318px}
.icon_yp3{background-position:0 -118px}
.icon_yp4{background-position:0 -220px}
</style>
<body>
<table width="800" cellpadding="3" cellspacing="1"  class="table_form">
<caption>快捷面板</caption>
<tr><td>
<ul id="fast_a">
<li><dl class="icon_yp1"><dt>公司产品</dt><dd><a href="?mod=yp&file=product&action=manage&job=check">审核<span>(<?=$number['product'][0]?>)</span></a> ｜ <a href="?mod=yp&file=product&action=manage">管理<span>(<?=$number['product'][1]?>)</span></a></dd></dl></li>
<li><dl class="icon_yp2"><dt>人才招聘</dt><dd><a href="?mod=yp&file=job&action=manage&job=check">审核<span>(<?=$number['job'][0]?>)</span></a> ｜ <a href="?mod=yp&file=job&action=manage">管理<span>(<?=$number['job'][1]?>)</span></a> ｜ <a href="?mod=yp&file=talent">人才库<span>(<?=$number['job'][2]?>)</span></a></dd></dl></li>
<li><dl class="icon_yp3"><dt>商机</dt><dd><a href="?mod=yp&file=buy&action=manage&job=check">审核<span>(<?=$number['buy'][0]?>)</span></a> ｜ <a href="?mod=yp&file=buy&action=manage">管理<span>(<?=$number['buy'][1]?>)</span></a></dd></dl></li>
<li><dl class="icon_yp4"><dt>公司新闻</dt><dd><a href="?mod=yp&file=news&action=manage&job=check">审核<span>(<?=$number['news'][0]?>)</span></a> ｜ <a href="?mod=yp&file=news&action=manage">管理<span>(<?=$number['news'][1]?>)</span></a></dd></dl></li>
</ul></td></tr>
<tr><td>
<ul id="fast_b">
<li class="on"><a href="?mod=yp&file=setting"><dl class="yp_icon1"><dt>模块配置</dt><dd>配置模块参数</dd></dl></a></li>
<li class="on"><a href="?mod=yp&file=priv"><dl class="yp_icon2"><dt>权限设置</dt><dd>设置黄页用户权限</dd></dl></a></li>
<li class="on"><a href="?mod=yp&file=category"><dl class="yp_icon3"><dt>分类管理</dt><dd>黄页分类管理</dd></dl></a></li>
<li class="on"><a href="?mod=yp&file=model"><dl class="yp_icon4"><dt>黄页模型管理</dt><dd>黄页模型参数管理</dd></dl></a></li>
<li class="on"><a href="?mod=yp&file=company"><dl class="yp_icon5"><dt>管理公司</dt><dd>管理加入的公司活企业信息</dd></dl></a></li>
<li class="on"><a href="?mod=yp&file=certificate"><dl class="yp_icon6"><dt>管理证书</dt><dd>管理企业用户的证书等信息</dd></dl></a></li>
<li class="on"><a href="?mod=yp&file=announce"><dl class="yp_icon7"><dt>远程公告</dt><dd>远程公告</dd></dl></a></li>
<li class="on"><a href="?mod=yp&file=collect"><dl class="yp_icon9"><dt>收藏统计</dt><dd>统计用户收藏的公司</dd></dl></a></li>
<li class="on"><a href="?mod=yp&file=template"><dl class="yp_icon11"><dt>公司模板管理</dt><dd>管理公司主页的模板</dd></dl></a></li>
<li class="on"><a href="?mod=yp&file=station"><dl class="yp_icon12"><dt>招聘岗位管理</dt><dd>招聘岗位管理</dd></dl></a></li>
</ul>
</td></tr>
</table>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(document).ready(function(){
	$('li.on').hover(
	  function(){
		  $(this).addClass("bk");},
	  function(){
			  $(this).removeClass("bk");
		  }
   )
  }
)
//-->
</SCRIPT>
</body>
</html>