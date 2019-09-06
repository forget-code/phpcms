<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<table cellpadding="0" cellspacing="1" class="table_info">
    <caption>关于 Sitemaps/互联网新闻开放协议</caption>
  <tr>
     <td>
<b>Sitemaps</b><br/>
Sitemaps 服务旨在使用 Feed 文件 sitemap.xml 通知 Google、Yahoo! 以及 Microsoft 等 Crawler(爬虫)网站上哪些文件需要索引、这些文件的最后修订时间、更改频度、文件位置、相对优先索引权，这些信息将帮助他们建立索引范围和索引的行为习惯。详细信息请查看 sitemaps.org 网站上的说明。<p>

<b>通过Sitemaps，您可以获得：</b> <br/>
1、更大的抓取范围，更新的搜索结果 – 帮助网友找到更多您的网页。<br/>
2、更为智能的抓取 – 因为我们可以得知您网页的最新修改时间或网页的更改频率。<br/>
3、详细的报告 – 详细说明 Google 如何将网友的点击指向您的网站及 Googlebot 如何看到您的网页。<p>
<b>互联网新闻开放协议：</b> <br/>
1、互联网新闻开放协议》是百度新闻搜索制定的搜索引擎新闻源收录标准，网站可将发布的新闻内容制作成遵循此开放协议的XML格式的网页（独立于原有的新闻发布形式）供搜索引擎索引。

<font color="red">PHPCMS可自动生成网站的Sitemaps，但是您还需要向google或者baidu提交Sitemaps的访问地址。</font><br/>
<font color="blue">您的网站的Sitemaps 访问地址为：</font><a href="<?=SITE_URL?>sitemaps.xml" target="_blank" title="点击查看Google Sitemaps"><?=SITE_URL?>sitemaps.xml</a><br/>
<font color="red">PHPCMS可自动生成网站的<<互联网新闻开放协议>>，但是您还需要向baidu提交访问地址。</font><br/>
<font color="blue">您的网站的Sitemaps 访问地址为：</font><a href="<?=SITE_URL?>baidunews.xml" target="_blank" title="互联网新闻开放协议"><?=SITE_URL?>baidunews.xml</a><br/>
<font color="blue">更多关于Google Sitemaps的信息：</font><a href="https://www.google.com/webmasters/sitemaps/login?hl=zh_CN" target="_blank" title="点击了解更多关于Google Sitemaps的信息">https://www.google.com/webmasters/sitemaps/login?hl=zh_CN</font><br />
<font color="blue">更多关于<<互联网新闻开放协议>>的信息：</font><a href="http://news.baidu.com/newsop.html#kg" target="_blank" title="点击了解更多关于<<互联网新闻开放协议>>的信息">http://news.baidu.com/newsop.html#kg</font>
	 </td>
   </tr>
</table>
	<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>生成 Sitemaps</caption>
    <tr >
    <th width="20%"><strong>更新频率</strong></th>
    <td >
    <select name="content_priority">
    <option value="1">1</option><option value="0.9">0.9</option>
    <option value="0.8">0.8</option><option selected="" value="0.7">0.7</option>
    <option value="0.6">0.6</option><option value="0.5">0.5</option>
    <option value="0.4">0.4</option><option value="0.3">0.3</option>
    <option value="0.2">0.2</option><option value="0.1">0.1</option>
    </select>
    <select name="content_changefreq">
    <option value="always">一直更新</option><option value="hourly">小时</option>
    <option value="daily">天</option><option selected="" value="weekly">周</option>
    <option value="monthly">月</option><option value="yearly">年</option>
    <option value="never">从不更新</option>
    </select>
    </td>
</tr>
<tr>
    <th><strong>生成数量</strong></th>
    <td><input type="text" name="baidunum" value="20" /></td>
</tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption>生成 互联网新闻开放协议</caption>
    <tr>
    <th width="20%"><strong>是否生成</strong></th>
    <td><input type="radio" name="mark" value="1" checked=""/>是&nbsp;&nbsp;<input type="radio" value="0" name="mark"/>否</td>
   </tr>
   <tr>
    <th><strong>更新周期</strong></th>
    <td><input type="text" name="time" value="40"/><font style="color:red">分</font></td>
   </tr>
   <tr>
    <th><strong>Email</strong></th>
    <td><input type="text" name="email" value="<?=$_email?>"/></td>
   </tr>
<tr>
  <th><strong>生成数量</strong></th>
  <td><input type="text" name="num" value="100" /></td>
</tr>
</table>
<tr>
   <th></th>
   <td><input type="submit" name="dosubmit" value=" 生成sitemap地图 "></td>
</tr>

</form>
</body>
</html>