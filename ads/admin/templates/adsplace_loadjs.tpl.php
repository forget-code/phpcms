<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder"><form method="post" name="myform">
<tr>
<th><?php echo $loadadsplace['placename']; ?>&nbsp;广告位代码调用</th>
</tr>
<tr>
<td class="tablerow" height="60">
<b>调用说明：</b><br />
1、调用方式一对服务器环境无特殊要求，可统计广告展示次数和自动判断广告是否过期，但是消耗服务器资源，访问速度慢，不支持Google等JS类代码广告；<br />
2、调用方式二对服务器环境无特殊要求，消耗服务器资源少，访问速度快，但是不能统计广告展示次数和自动判断广告有效期，不支持Google等JS类代码广告；<br />
3、shtml调用消耗服务器资源少，访问速度快，支持Google等JS类代码广告，但是不能统计广告展示次数和自动判断广告有效期，需要服务器支持shtml，建议大型站点采用这种调用方式；如果您的站点网页后缀为.html，则需要设置服务器让.html后缀的网页也支持嵌入功能；<a href="http://help.phpcms.cn/2007/0529/help_614.html" target="_blank" style="color:blue">点这里了解shtml技术 >></a><br />
4、根据自身情况选择一种调用方式，然后把调用代码复制粘贴到需要显示广告的模板再更新相关网页即可。
</td>
</tr>
<tr>
<td class="tablerowhighlight">调用方式一：JS调用代码（PHP动态调用）</td>
</tr>
<tr>
<td class="tablerow" height="60" align="center"><input name="jscode1" id="jscode1" value='<script language="javascript" src="<?=$PHP_SITEURL?>data/<?=$MOD['htmldir']?>.php?id=<?=$placeid?>"></script>' size="100">
<br><input type="button" onclick="document.all.jscode1.select();document.execCommand('Copy');" value=" 复制代码至剪贴板 ">
&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.open('?mod=ads&file=adsplace&action=view&placeid=<?=$placeid?>');" value="预览广告位"></td>
</tr>
<tr>
<td class="tablerowhighlight">调用方式二：JS调用代码（JS静态调用）</td>
</tr>
<tr>
<td class="tablerow" height="60" align="center"><input name="jscode2" id="jscode2" value='<script language="javascript" src="<?=$PHP_SITEURL?>data/<?=$MOD['htmldir']?>/<?=$placeid?>.js"></script>' size="100">
<br><input type="button" onclick="document.all.jscode2.select();document.execCommand('Copy');" value=" 复制代码至剪贴板 ">
&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.open('?mod=ads&file=adsplace&action=view&placeid=<?=$placeid?>');" value="预览广告位"></td>
</tr>
<tr>
<td class="tablerowhighlight">调用方式三：shtml嵌入代码</td>
</tr>
<tr>
<td class="tablerow" height="100" align="center">
<textarea name="shtmlcode" cols="100" rows="5">{if defined('CREATEHTML')}
<!--#include file="<?=PHPCMS_PATH?>data/<?=$MOD['htmldir']?>/<?=$placeid?>.html"-->
{else}
{include PHPCMS_ROOT.'/data/<?=$MOD['htmldir']?>/<?=$placeid?>.html'}
{/if}</textarea>
<br><input type="button" onclick="document.all.shtmlcode.select();document.execCommand('Copy');" value=" 复制代码至剪贴板 ">
&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="window.open('?mod=ads&file=adsplace&action=view&placeid=<?=$placeid?>');" value="预览广告位"></td>
</tr>
</table>
</body>
</html>