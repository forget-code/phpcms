<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>关于 Google Sitemaps</th>
  </tr>
  <tr>
     <td class="tablerow">
<b>提高您的网址在 Google 的可见度</b><br/> 

Google Sitemaps 是您向 Google 索引提交所有网址并详细了解您网页在 Google 可见度的一条捷径。通过 Google Sitemaps，Google 始终可以自动得到您所有网页的信息及您更改网页的时间，帮助您提高在 Google 抓取中的覆盖率。 <p>

<b>通过 Google Sitemaps，您可以获得：</b> <br/>

1、更大的抓取范围，更新的搜索结果 – 帮助网友找到更多您的网页。<br/> 
2、更为智能的抓取 – 因为我们可以得知您网页的最新修改时间或网页的更改频率。<br/> 
3、详细的报告 – 详细说明 Google 如何将网友的点击指向您的网站及 Googlebot 如何看到您的网页。<p> 

<font color="red">PHPCMS可自动生成网站的Google Sitemaps，但是您还需要向google提交Google Sitemaps的访问地址。</font><br/>
<font color="blue">您的网站的 Google Sitemaps 访问地址为：</font><a href="http://<?=$PHP_DOMAIN?><?=PHPCMS_PATH?>sitemap.xml" target="_blank" title="点击查看Google Sitemaps">http://<?=$PHP_DOMAIN?><?=PHPCMS_PATH?>sitemap.xml</a><br/>
<font color="blue">更多关于Google Sitemaps的信息：</font><a href="https://www.google.com/webmasters/sitemaps/login?hl=zh_CN" target="_blank" title="点击了解更多关于Google Sitemaps的信息">https://www.google.com/webmasters/sitemaps/login?hl=zh_CN</font>
	 </td>
   </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="5">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>生成 Google Sitemaps</th>
  </tr>
	<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
  <tr>
     <td class="tablerow" width="40%" height="30">
	 您希望生成多少天以内的信息链接：
	</td>
     <td class="tablerow" height="30">
	         <input type="text" name="maxdaynumber" value="90"> 天以内
	</td>
   </tr>
  <tr>
     <td class="tablerow" height="30">
	 每个栏目生成前多少条信息的链接：
	</td>
     <td class="tablerow" height="30">
	   <input type="text" name="maxnumber" value="500"> 条信息 
	</td>
   </tr>
  <tr>
     <td class="tablerow"></td>
     <td class="tablerow"><input type="submit" name="submit" value=" 生成google地图 "></td>
   </tr>
	</form>
</table>

</body>
</html>