<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body onload="ShowTabs(<?=$tab?>);">
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?file=setting&action=save">
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本信息</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>网站设置</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>搜索设置</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>安全设置</td>
<td id='TabTitle4' class='title1' onclick='ShowTabs(4)'>图片处理</td>
<td id='TabTitle5' class='title1' onclick='ShowTabs(5)'>邮件设置</td>
<td id='TabTitle6' class='title1' onclick='ShowTabs(6)'>FTP设置</td>
<td id='TabTitle7' class='title1' onclick='ShowTabs(7)'>通行证</td>
<td id='TabTitle8' class='title1' onclick='ShowTabs(8)'>扩展设置</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">

  <tbody id='Tabs0' style='display:'>
  <th colspan=3>基本信息</th>
    <tr>
      <td width='43%' class='tablerow'><strong>网站名称</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[sitename]' type='text' id='sitename' value='<?=$sitename?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>网站地址</strong><br>请添写完整URL地址</td>
      <td colspan="2" class='tablerow'><input name='setting[siteurl]' type='text' id='siteurl' value='<?=$siteurl?>' size='40' maxlength='255'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>LOGO地址</strong><br>请添写完整URL地址</td>
      <td colspan="2" class='tablerow'><input name='setting[logo]' type='text' id='logo' value='<?=$logo?>' size='40' maxlength='255'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>友情链接LOGO地址</strong><br>请添写完整URL地址，一般为 88*31 px</td>
      <td colspan="2" class='tablerow'><input name='setting[linklogo]' type='text' id='linklogo' value='<?=$linklogo?>' size='40' maxlength='255'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>网站ICP备案序号</strong><br>请在信息产业部管理网站申请<br><a href="http://www.miibeian.gov.cn" target="_blank">http://www.miibeian.gov.cn</a></td>
      <td colspan="2" class='tablerow'><input name='setting[icpno]' type='text' id='linklogo' value='<?=$icpno?>' size='40' maxlength='255'></td>
    </tr>
        <tr>
      <td width='43%' class='tablerow'><strong>备案证书 bazs.cert文件</strong><br></td>
      <td colspan="2" class='tablerow'><input name='setting[bazscert]' type='text' id='bazscert' value='<?=$bazscert?>' size='40' maxlength='255'> </td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>Title（网站标题）</strong><br>针对搜索引擎设置的网页标题</td>
      <td colspan="2" class='tablerow'><input name='setting[seo_title]' type='text' id='seo_title' value='<?=$seo_title?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>Meta Keywords（网页关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td colspan="2" class='tablerow'><textarea name='setting[seo_keywords]' cols='60' rows='2' id='seo_keywords'><?=$seo_keywords?></textarea></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>Meta Description（网页描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td colspan="2" class='tablerow'><textarea name='setting[seo_description]' cols='60' rows='2' id='seo_description'><?=$seo_description?></textarea></td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>首页是否生成html</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[ishtml]' value='1'  <?php if($ishtml){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ishtml]' value='0'  <?php if(!$ishtml){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>生成文件名</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[index]' type='text' id='index' value='<?=$index?>' size='8' maxlength='10'> . <?=fileext_select('setting[fileext]',$fileext)?></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>管理员信箱</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[webmasteremail]' type='text' id='webmasteremail' value='<?=$webmasteremail?>' size='40' maxlength='100'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>版权信息</strong><br>将显示在网站底部</td>
      <td colspan="2" class='tablerow'><textarea name='setting[copyright]' id="copyright" cols="60" rows="4"><?=$copyright?></textarea> <?=editor('copyright','introduce',400,200)?>
	  </td> 
	  </tr>
  </tbody>

  <tbody id='Tabs1' style='display:none'>
    <th colspan=3>网站设置</th>
	<tr>
      <td width='43%' class='tablerow'><strong>是否启用可视化编辑器</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[enableeditor]' value='1'  <?php if($enableeditor){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableeditor]' value='0'  <?php if(!$enableeditor){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>是否启用模板缓存自动更新</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setconfig[templaterefresh]' value='1'  <?php if($templaterefresh){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[templaterefresh]' value='0'  <?php if(!$templaterefresh){ ?>checked <?php } ?>> 否&nbsp;&nbsp;&nbsp;&nbsp;（如果网站模板已经做好，建议您关闭此功能）
	  </td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>是否显示程序执行时间与SQL查询数</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setconfig[debug]' value='1'  <?php if($debug){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[debug]' value='0'  <?php if(!$debug){ ?>checked <?php } ?>> 否&nbsp;&nbsp;&nbsp;&nbsp;（此功能只对前台php动态页面有效）
	  </td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>是否启用数据库查询结果缓存</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setconfig[dbiscache]' value='1'  <?php if($dbiscache){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[dbiscache]' value='0'  <?php if(!$dbiscache){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>数据库查询结果缓存更新周期</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='text' name='setconfig[dbexpires]' value='<?=$dbexpires?>' size='5'> 秒
	  </td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>php 缓存类型</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setconfig[phpcache]' value='2'  <?php if($phpcache == 2){ ?>checked <?php } ?>> 开启php页面缓存&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[phpcache]' value='1'  <?php if($phpcache == 1){ ?>checked <?php } ?>> 开启标签缓存&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[phpcache]' value='0'  <?php if($phpcache == 0){ ?>checked <?php } ?>> 关闭缓存
	  </td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>php 缓存更新周期</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='text' name='setconfig[phpcacheexpires]' value='<?=$phpcacheexpires?>' size='5'> 秒
	  </td>
    </tr>
<?php if($LICENSE['type'] != 'free'){ ?>
	<tr>
      <td width='43%' class='tablerow'><strong>是否启用自动提取关键词功能</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[enablegetkeywords]' value='1'  <?php if($enablegetkeywords){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablegetkeywords]' value='0'  <?php if(!$enablegetkeywords){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
<?php } ?>
	<tr>
      <td width='43%' class='tablerow'><strong>网站默认地区</strong></td>
      <td colspan="2" class='tablerow'>
<select name="setting[province]" id="province" onchange="javascript:loadcity(this.value);">
<option value="0" selected="selected">请选择</option>
</select>

<select name="setting[city]" id="city" onchange="javascript:loadarea($('province').value, this.value);">
<option value="0" selected="selected">请选择</option>
</select>

<select name="setting[area]" id="area">
<option value="0" selected="selected">请选择</option>
</select>

<script language="javascript">
var phpcms_path = '<?=PHPCMS_PATH?>';
var selectedprovince = '<?=$province?>';
var selectedcity = '<?=$city?>';
var selectedarea = '<?=$area?>';
</script>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/area.js"></script>

	  </td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>附件目录</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[uploaddir]' type='text' id='uploaddir' value='<?=$uploaddir?>' size='40' maxlength='50'></td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>允许上传的附件类型</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[uploadfiletype]' type='text' id='uploadfiletype' value='<?=$uploadfiletype?>' size='40' maxlength='50'></td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>附件上传函数选择</strong><br/>如果上传的文件无法查看，请选择 copy 函数</td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[uploadfunctype]' value='1'  <?php if($uploadfunctype){ ?>checked <?php } ?>> move_uploaded_file&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[uploadfunctype]' value='0'  <?php if(!$uploadfunctype){ ?>checked <?php } ?>> copy
	  </td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>页面Gzip压缩</strong><br>
	  将页面内容以gzip压缩后传输，可以加快传输速度，需PHP 4.0.4以上且支持Zlib模块才能使用
	  </td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[enablegzip]' value='1'  <?php if($enablegzip){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablegzip]' value='0'  <?php if(!$enablegzip){ ?>checked <?php } ?>> 否
     </td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>信息列表最大页数</strong><br></td>
      <td colspan="2" class='tablerow'><input name='setting[maxpage]' type='text' id='maxpage' value='<?=$maxpage?>' size='5' maxlength='255'> 页</td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>信息列表每页默认信息条数</strong><br></td>
      <td colspan="2" class='tablerow'><input name='setting[pagesize]' type='text' id='pagesize' value='<?=$pagesize?>' size='5' maxlength='255'> 条</td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>发布信息时栏目列表自动更新页数</strong><br></td>
      <td colspan="2" class='tablerow'><input name='setting[autoupdatepagenum]' type='text' id='autoupdatepagenum' value='<?=$autoupdatepagenum?>' size='5' maxlength='1'> 页 （建议不要超过 5 页）</td>
    </tr>
  </tbody>

  <tbody id='Tabs2' style='display:none'>
      <th colspan=3>搜索设置</th>
    <tr>
      <td width='43%' class='tablerow'><strong>每次搜索时间间隔</strong><br>
	  设置合理的每次搜索时间间隔，可以避免恶意搜索而消耗大量系统资源</td>
      <td colspan="2" class='tablerow'><input name='setting[searchtime]' type='text' id='searchtime' value='<?=$searchtime?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>搜索返回最多的结果数</strong><br>
	  返回搜索的结果数和消耗的资源成正比，请合理设置，建议不要设置过大</td>
      <td colspan="2" class='tablerow'><input name='setting[maxsearchresults]' type='text' id='maxsearchresults' value='<?=$maxsearchresults?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>每页信息数</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[searchperpage]' type='text' id='searchperpage' value='<?=$searchperpage?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>是否启用全文搜索</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[searchcontent]' value='1'  <?php if($searchcontent){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[searchcontent]' value='0'  <?php if(!$searchcontent){ ?>checked <?php } ?>> 否
</td>
    </tr>
  </tbody>

  <tbody id='Tabs3' style='display:none'>
      <th colspan=3>安全设置</th>
    <tr>
      <td width='43%' class='tablerow'><strong>网站安全密钥</strong></td>
      <td colspan="2" class='tablerow'>
	  <input name='setting[authkey]' type='text' id='authkey' value='<?=$authkey?>' size='30' maxlength='20'>
	  </td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>是否启用后台管理操作日志</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setconfig[enableadminlog]' value='1'  <?php if($enableadminlog){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[enableadminlog]' value='0'  <?php if(!$enableadminlog){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>允许访问后台的IP列表</strong><br/>
	  只有当管理员处于本列表中的 IP 地址时才可以访问网站后台，列表以外的地址访问将无法访问，但仍可访问网站前台界面，请务必慎重使用本功能。每个 IP 一行，既可输入完整地址，也可只输入 IP 开头，例如 "192.168." 可匹配 192.168.0.0~192.168.255.255 范围内的所有地址<br/><font color="red">留空则所有 IP 均可访问网站后台</font>
	  </td>
      <td colspan="2" class='tablerow'>
	  <textarea name='setting[adminaccessip]' cols='60' rows='8' id='adminaccessip'><?=$adminaccessip?></textarea>
	  </td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>后台最大登陆失败次数</strong><br/>登陆失败次数超过后系统将自动锁定该IP，0表示不限制次数</td>
      <td colspan="2" class='tablerow'>
	  <input name='setting[maxfailedtimes]' type='text' id='maxfailedtimes' value='<?=$maxfailedtimes?>' size='10' maxlength='2'> 次
	  </td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>IP锁定时间</strong><br/>超过锁定时间后该IP将自动解锁</td>
      <td colspan="2" class='tablerow'>
        <input name='setting[maxlockedtime]' type='text' id='maxlockedtime' value='<?=$maxlockedtime?>' size='10' maxlength='5'> 小时
      </td>
	</tr>
    <tr>
      <td width='43%' class='tablerow'><strong>IP访问禁止</strong><br/>可按IP或者IP段设置禁止访问站点，此功能会消耗一定的服务器资源</td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[enablebanip]' value='1'  <?php if($enablebanip){ ?>checked <?php } ?>> 启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablebanip]' value='0'  <?php if(!$enablebanip){ ?>checked <?php } ?>> 禁用
      </td>
	</tr>
    <tr>
      <td width='43%' class='tablerow'><strong>后台登录验证码</strong><br/><?php if($enablegd){ ?>您的空间支持GD库，建议开启，这样有利于加强系统安全。 <?php }else{ ?>您的空间不支持GD库，无法开启。 <?php } ?> </td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[enableadmincheckcode]' value='1'  <?php if($enableadmincheckcode){ ?>checked <?php } ?> <?php if(!$enablegd){ ?>disabled<?php } ?>> 启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableadmincheckcode]' value='0'  <?php if(!$enableadmincheckcode){ ?>checked <?php } ?>> 禁用
      </td>
	</tr>
  </tbody>

    <tbody id='Tabs4' style='display:none'>
      <th colspan=3>图片处理</th>
	 <tr>
      <td width='43%' class='tablerow'><strong>PHP图形处理（GD库）功能检测</strong></td>
      <td colspan="2" class='tablerow'>
	  <font color="red"><?=$gd?></font>
     </td>
    </tr>
	 <tr>
      <td width='43%' class='tablerow'><strong>是否启用缩略图</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[enablethumb]' value='1'  <?php if($enablegd && $enablethumb){ ?>checked <?php } ?>> 启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablethumb]' value='0'  <?php if(!$enablegd || !$enablethumb){ ?>checked <?php } ?>> 禁用&nbsp;&nbsp;&nbsp;&nbsp;
     </td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>缩略图默认宽度</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[thumb_width]' type='text' id='thumb_width' value='<?=$thumb_width?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>缩略图默认高度</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[thumb_height]' type='text' id='thumb_height' value='<?=$thumb_height?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>缩略图算法</strong></td>
      <td colspan="2" class='tablerow'>
       宽和高都大于0时，缩小成指定大小，其中一个为0时，按比例缩小<br>
      </td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>水印类型</strong></td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[water_type]' value='0'  <?php if(!$enablegd || $water_type==0){ ?>checked <?php } ?>> 不启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[water_type]' value='1'  <?php if($enablegd && $water_type==1){ ?>checked <?php } ?>> 文字水印&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[water_type]' value='2'  <?php if($enablegd && $water_type==2){ ?>checked <?php } ?>> 图片水印
     </td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>水印文字</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[water_text]' type='text' id='water_text' value='<?=$water_text?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='43%' class='tablerow'><strong>文字字体</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[water_font]' type='text' id='water_font' value='<?=$water_font?>' size='30' maxlength='100'> <?php if(!file_exists(PHPCMS_ROOT.'/'.$water_font)){ ?><font color="red">字体不存在，上传后才能使用文字水印功能。</font><?php } ?></td>
    </tr>
	    <tr>
      <td width='43%' class='tablerow'><strong>文字大小</strong><br> 若使用文字水印，请将字体上传到对应位置</td>
      <td colspan="2" class='tablerow'><input name='setting[water_fontsize]' type='text' id='water_fontsize' value='<?=$water_fontsize?>' size='40' maxlength='50'></td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>文字颜色</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[water_fontcolor]' type='text' id='water_fontcolor' value='<?=$water_fontcolor?>' size='40' maxlength='50' style='color:<?=$water_fontcolor?>'></td>
    </tr>
	<tr>
      <td width='43%' class='tablerow'><strong>水印图片</strong></td>
      <td colspan="2" class='tablerow'><input name='setting[water_image]' type='text' id='water_image' value='<?=$water_image?>' size='40' maxlength='50'>
	  
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>水印透明度</strong><br/>范围为 1~100 的整数，数值越小水印图片越透明</td>
      <td colspan="2" class='tablerow'><input name='setting[water_transition]' type='text' id='water_image' value='<?=$water_transition?>' size='40' maxlength='50'>
	  </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>JPEG 水印质量</strong><br/>范围为 0~100 的整数，数值越大结果图片效果越好，但尺寸也越大</td>
      <td colspan="2" class='tablerow'><input name='setting[water_jpeg_quality]' type='text' id='water_image' value='<?=$water_jpeg_quality?>' size='40' maxlength='50'>
	  </td>
    </tr>

	<tr>
      <td class='tablerow'><strong>图片处理条件</strong><br/>图片处理的最小宽度或长度，宽度或者高度小于此值将不做处理</td>
      <td colspan="2" class='tablerow'><input name='setting[water_min_wh]' type='text' id='water_image' value='<?=$water_min_wh?>' size='40' maxlength='50'>
	  </td>
    </tr>

	    <tr>
      <td width='43%' class='tablerow'><strong>水印位置</strong><br>
	  您可以设置自动为用户上传的 JPG/PNG/GIF 图片附件添加水印，请在此选择水印添加的位置(3x3 共 9 个位置可选)。本功能需要 GD 库支持才能使用，暂不支持动画 GIF 格式。附加的水印图片位于 ./images/watermark.gif，您可替换此文件以实现不同的水印效果
	  </td>
      <td colspan="2" class='tablerow'>
	  
	  <table cellspacing="1" cellpadding="4" width="150" bgcolor="#dddddd">
	  <tr align="center"  bgcolor="#ffffff"><td><input type="radio" name="setting[water_pos]" value="1" <?php if($water_pos==1){ ?>checked <?php } ?>> #1</td><td><input type="radio" name="setting[water_pos]" value="2" <?php if($water_pos==2){ ?>checked <?php } ?>> #2</td><td><input type="radio" name="setting[water_pos]" value="3" <?php if($water_pos==3){ ?>checked <?php } ?>> #3</td></tr>
	  <tr align="center"  bgcolor="#ffffff"><td><input type="radio" name="setting[water_pos]" value="4" <?php if($water_pos==4){ ?>checked <?php } ?>> #4</td><td><input type="radio" name="setting[water_pos]" value="5" <?php if($water_pos==5){ ?>checked <?php } ?>> #5</td><td><input type="radio" name="setting[water_pos]" value="6" <?php if($water_pos==6){ ?>checked <?php } ?>> #6</td></tr>
	  <tr align="center" bgcolor="#ffffff"><td><input type="radio" name="setting[water_pos]" value="7" <?php if($water_pos==7){ ?>checked <?php } ?>> #7</td><td><input type="radio" name="setting[water_pos]" value="8" <?php if($water_pos==8){ ?>checked <?php } ?>> #8</td><td><input type="radio" name="setting[water_pos]" value="9" <?php if($water_pos==9){ ?>checked <?php } ?>> #9</td></tr>
	  </table>

    </tr>
  </tbody>

   <tbody id='Tabs5' style='display:none'>
	  <th colspan=3>邮件设置</th>
    <tr>
      <td class="tablerow"><b>发送方式</b></td>
      <td colspan="2" class="tablerow">
	  <input type="radio" name="setting[sendmailtype]"  value="smtp" <?php if($sendmailtype=="smtp"){ ?>checked <?php } ?> />SMTP方式
      <input type="radio" name="setting[sendmailtype]" value="mail"  <?php if($sendmailtype=="mail"){ ?>checked <?php } ?>/>Mail函数（Windows服务器不支持）
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="43%"><b>邮箱SMTP</b><br>SMTP服务器，只有正确设置才能使用发邮件功能</td>
      <td class="tablerow"><input name="setting[smtphost]" type="text" size="40" value="<?=$smtphost?>"></td>
      
    </tr>
    <tr> 
      <td class="tablerow"><b>邮箱帐号</b><br>SMTP服务器的用户帐号，只有正确设置才能使用发邮件功能</td>
      <td  class="tablerow"><input name="setting[smtpuser]" type="text" size="40" value="<?=$smtpuser?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>邮箱密码</b><br></td>
      <td  class="tablerow"><input name="setting[smtppass]" type="password" size="40" value="<?=$smtppass?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>SMTP端口</b><br>默认为25，一般不需要改</td>
      <td  class="tablerow"><input name="setting[smtpport]" type="text" size="40" value="<?=$smtpport?>"></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>检查邮件设置</b></td>
      <td  class="tablerow"><input name="testemail" type="text" id="testemail" value="@" size="30">
      <input name="button" type="button" onClick="javascript:openwinx('?mod=mail&file=send&type=1&SingleEmail='+$('testemail').value+'&title=<?=urlencode($PHPCMS['sitename']."--发送测试邮件")?>&content=<?=urlencode($PHPCMS['sitename']."--测试邮件内容")?>&dosubmit=1','发送邮件测试','350','350')" value="发送测试邮件"></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>邮件内是否携带签名</b></td>
      <td  class="tablerow"><input type="radio" name="setting[enablesignature]"  value="1" <?php if($enablesignature=="1"){ ?>checked <?php } ?> />是
      <input type="radio" name="setting[enablesignature]" value="0"  <?php if($enablesignature=="0"){ ?>checked <?php } ?>/>否</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>邮件签名</b></td>
      <td  class="tablerow"><textarea name="setting[signature]" id="signature" cols="50" rows="5" ><?=$signature?></textarea><?=editor('signature','introduce',360,150)?>
      </td>
    </tr>
  </tbody>

    <tbody id='Tabs6' style='display:none'>
	  <th colspan=3>ftp设置</th>
	<tr>
      <td width='43%' class='tablerow'><strong>是否启用FTP功能</strong><br>开启FTP功能后，phpcms将采用ftp方式建立目录和修改权限<br/>
     <?php if(!function_exists('ftp_connect')){ ?><font color="red">当前PHP环境不支持FTP功能！</font><?php }?>
	 <?php if(strpos(strtolower(PHP_OS),"win")===false){ ?><font color="red">当前服务器操作系统为非WINDOWS系统，建议设置好ftp并启用FTP功能。<br/></font>
	 <?php }else{ ?>
        <font color="red">当前服务器操作系统为WINDOWS系统，您不需要启用FTP功能。<br/></font>
	 <?php } ?>
     <?php if($safe_mode){ ?><font color="red">php正以安全模式运行，请开启并配置好ftp，否则可能导致无法正常使用phpcms！</font><?php }?>
	  </td>
      <td colspan="2" class='tablerow'>
	  <input type='radio' name='setting[enableftp]' value='1'  <?php if($enableftp){ ?>checked <?php } ?>> 启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableftp]' value='0'  <?php if(!$enableftp){ ?>checked <?php } ?>> 禁用&nbsp;&nbsp;&nbsp;&nbsp;
     </td>
    </tr>
    <tr> 
      <td class="tablerow" width="43%"><b>ftp主机</b></td>
      <td colspan="2" class="tablerow"><input name="setting[ftphost]" id="ftphost" type="text" size="40" value="<?=$ftphost?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="43%"><b>ftp端口</b></td>
      <td colspan="2" class="tablerow"><input name="setting[ftpport]" id="ftpport" type="text" size="40" value="<?=$ftpport?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>ftp帐号</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[ftpuser]" id="ftpuser" type="text" size="40" value="<?=$ftpuser?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>ftp密码</b><br></td>
      <td colspan="2"  class="tablerow"><input name="setting[ftppass]" id="ftppass" type="password" size="40" value="<?=$ftppass?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="43%"><b>PHPCMS根目录相对FTP根目录的路径</b><br>有很多虚拟主机的ftp根目录与web根目录不一样<br/>您需要正确设置才能使用ftp功能</td>
      <td colspan="2" class="tablerow"><input name="setting[ftpwebpath]" id="ftpwebpath" type="text" size="40" value="<?=$ftpwebpath?>"><br>注意以“/”结尾，例如有的是 wwwroot/ 或者 www/<br/>留空则表示ftp根目录与phpcms根目录路径相同</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>测试ftp连接</b><br></td>
      <td colspan="2"  class="tablerow"><input name="testftp" type="button" size="40" value="点击测试ftp连接是否正确" onClick="javascript:openwinx('?mod=phpcms&file=setting&action=testftp&ftphost='+myform.ftphost.value+'&ftpport='+myform.ftpport.value+'&ftpuser='+myform.ftpuser.value+'&ftppass='+myform.ftppass.value+'&ftpwebpath='+myform.ftpwebpath.value,'testftp','450','180')"></td>
    </tr>
  </tbody>

  <tbody id='Tabs7' style='display:none'>
    <th colspan=3>通行证设置</th>
    <tr> 
      <td colspan="3" class="tablerowhighlight" align="center">正向通行证设置</td>
    </tr>
    <tr> 
      <td class="tablerow" width="35%"><b>是否启用正向通行证</b><br>以PHPCMS作为整合的服务器端</td>
      <td colspan="2"  class="tablerow"><input type="radio" name="setting[enablepassport]" value="1" <?php if($enablepassport){?>checked<?php }?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[enablepassport]" value="0" <?php if(!$enablepassport){?>checked<?php }?>>否</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>整合程序</b></td>
      <td colspan="2" class="tablerow">
	  <script type="text/javascript">
	  function set_passport(str)
	  {
		  if(str == 'discuz') $('passport_url').value='http://www.***.com/bbs/api/passport.php';
		  else if(str == 'phpwind') $('passport_url').value='http://www.***.com/bbs/';
	  }
	  function fill_passport(str)
	  {
		  if(str == 'phpwind')
		  {
			  $('passport_serverurl').value='http://www.***.com/bbs/';
			  $('passport_registerurl').value='register.php';
			  $('passport_loginurl').value='login.php';
			  $('passport_logouturl').value='login.php?action=quit';
			  $('passport_getpasswordurl').value='sendpwd.php';
		  }
		  else if(str == 'lxblog')
		  {
			  $('passport_serverurl').value='http://www.***.com/blog/';
			  $('passport_registerurl').value='register.php';
			  $('passport_loginurl').value='login.php';
			  $('passport_logouturl').value='login.php?action=quit';
			  $('passport_getpasswordurl').value='sendpwd.php';
		  }
		  else if(str == 'lxshop')
		  {
			  $('passport_serverurl').value='http://www.***.com/shop/';
			  $('passport_registerurl').value='register.php';
			  $('passport_loginurl').value='login.php';
			  $('passport_logouturl').value='login.php?action=quit';
			  $('passport_getpasswordurl').value='sendpwd.php';
		  }
		  else if(str == 'shopex')
		  {
			  $('passport_serverurl').value='http://www.***.com/shop/';
			  $('passport_registerurl').value='index.php?gOo=register.dwt';
			  $('passport_loginurl').value='index.php?gOo=login.dwt';
			  $('passport_logouturl').value='index.php?gOo=logout_act.do';
			  $('passport_getpasswordurl').value='index.php?gOo=forget.dwt';
		  }
	  }
	  </script>
	  <select name="setting[passport_file]" onchange="set_passport(this.value);">
	  <?php 
	  $passports = glob(PHPCMS_ROOT.'/member/passport/*.php');
	  foreach($passports as $passport)
	  {
		  $passport = str_replace('.php', '', basename($passport));
		  echo '<option value="'.$passport.'" '.($passport_file == $passport ? 'selected' : '').'>'.$passport.'</option>';
	  }
	  ?>
	  </select>
	  </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>整合程序字符集</b></td>
      <td colspan="2" class="tablerow">
	  <select name="setting[passport_charset]">
	  <option value="gbk" <?=($passport_charset == 'gbk' ? 'selected' : '')?>>GBK/GB2312</option>
	  <option value="utf-8" <?=($passport_charset == 'utf-8' ? 'selected' : '')?>>UTF-8</option>
	  <option value="big5" <?=($passport_charset == 'big5' ? 'selected' : '')?>>BIG5</option>
	  </select>
	  </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>通行证接口地址</b><br>多个接口地址请用逗号“,”分隔</td>
      <td colspan="2"  class="tablerow"><input name="setting[passport_url]" type="text" size="75" value="<?=$passport_url?>" id="passport_url"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>通行证私有密钥</b><br>请填写通行证私有密钥</td>
      <td colspan="2"  class="tablerow"><input name="setting[passport_key]" type="text" size="30" value="<?=$passport_key?>"></td>
    </tr>
    <tr> 
      <td colspan="3" class="tablerowhighlight" align="center">反向通行证设置</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否启用反向通行证</b><br>以PHPCMS作为整合的客户端</td>
      <td colspan="2" class="tablerow"><input type="radio" name="setting[enableserverpassport]" value="1" <?php if($enableserverpassport){?>checked<?php }?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[enableserverpassport]" value="0" <?php if(!$enableserverpassport){?>checked<?php }?>>否&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="blue">整合程序：</font><a href="###" onclick="javascript:fill_passport('phpwind')">Phpwind</a>/<a href="###" onclick="javascript:fill_passport('lxblog')">Lxblog</a>/<a href="###" onclick="javascript:fill_passport('lxshop')">Lxshop</a>/<a href="###" onclick="javascript:fill_passport('shopex')">Shopex</a></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>通行证接口地址</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[passport_serverurl]" id="passport_serverurl" type="text" size="50" value="<?=$passport_serverurl?>"></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>通行证会员注册地址</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[passport_registerurl]" id="passport_registerurl" type="text" size="50" value="<?=$passport_registerurl?>"></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>通行证会员登录地址</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[passport_loginurl]" id="passport_loginurl" type="text" size="50" value="<?=$passport_loginurl?>"></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>通行证会员退出地址</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[passport_logouturl]" id="passport_logouturl" type="text" size="50" value="<?=$passport_logouturl?>"></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>通行证会员找回密码地址</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[passport_getpasswordurl]" id="passport_getpasswordurl" type="text" size="50" value="<?=$passport_getpasswordurl?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>通行证私有密钥</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[passport_serverkey]" type="text" size="30" value="<?=$passport_serverkey?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>验证字串有效期(秒):</b><br>设置应用程序发送过来的用户验证字串的有效期，超过此有效期验证字串将失效。建议设置为 3600，既可保证安全又可避免因不同服务器间时间差而产生无法登录的问题</td>
      <td colspan="2"  class="tablerow"><input name="setting[passport_expire]" type="text" size="30" value="<?=$passport_expire?>"></td>
    </tr>
  </tbody>

  <tbody id='Tabs8' style='display:none'>
    <th colspan=3>在线客服</th>
    <tr> 
      <td colspan="3" class="tablerowhighlight" align="center">即时通讯软件</td>
    </tr>
    <tr> 
      <td class="tablerow" width="25%"><b>是否启用</b></td>
      <td colspan="2"  class="tablerow"><input type="radio" name="setting[enabletm]" value="1" <?php if($enabletm){?>checked<?php }?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[enabletm]" value="0" <?php if(!$enabletm){?>checked<?php }?>>否&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">注意：多个帐号之间请用逗号“,”分隔</font></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>QQ</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[qq]" type="text" size="75" value="<?=$qq?>">&nbsp;&nbsp;<a href="http://im.qq.com/" target="_blank">免费申请</a></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>MSN</b></td>
      <td colspan="2" class="tablerow"><input name="setting[msn]" type="text" size="75" value="<?=$msn?>">&nbsp;&nbsp;<a href="http://messenger.live.cn/" target="_blank">免费申请</a></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>SKYPE</b></td>
      <td colspan="2" class="tablerow"><input name="setting[skype]" type="text" size="75" value="<?=$skype?>">&nbsp;&nbsp;<a href="http://www.skype.com/" target="_blank">免费申请</a></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>阿里旺旺（淘宝版）</b></td>
      <td colspan="2" class="tablerow"><input name="setting[taobao]" type="text" size="75" value="<?=$taobao?>">&nbsp;&nbsp;<a href="http://www.taobao.com/wangwang/" target="_blank">免费申请</a></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>阿里旺旺（贸易通版）</b></td>
      <td colspan="2" class="tablerow"><input name="setting[alibaba]" type="text" size="75" value="<?=$alibaba?>">&nbsp;&nbsp;<a href="http://alitalk.alibaba.com.cn/" target="_blank">免费申请</a></td>
    </tr>
    <tr> 
      <td colspan="3" class="tablerowhighlight" align="center">53KF 网上客服</td>
    </tr>
    <tr> 
      <td colspan="3" class="tablerow">
	  网上客服（53KF）是完全基于WEB实现的一款免费网页对话系统，简洁明快，无需安装任何插件。在提升服务质量的同时，也为使用者带来了新的客户来源和订单。 
免费申请：<a href="http://www.53kf.com/index.htm?from=phpcms" target="_blank">http://www.53kf.com/</a>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否启用</b></td>
      <td colspan="2"  class="tablerow"><input type="radio" name="setting[enable53kf]" value="1" <?php if($enable53kf){?>checked<?php }?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[enable53kf]" value="0" <?php if(!$enable53kf){?>checked<?php }?>>否</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>53KF帐号</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[kf_arg]" type="text" size="50" value="<?=$kf_arg?>"></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>风格号</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[kf_style]" type="text" size="50" value="<?=$kf_style?>"></td>
    </tr>
	<td colspan=3 class="tablerowhighlight" align="center">CC视频联盟</td>
	<tr> 
      <td class="tablerow"><b>您在CC联盟的数字ID</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[cc_uid]" type="text" size="5" value="<?=$cc_uid?>" id="cc_uid"> <a href="http://union.bokecc.com/signup.bo" target="_blank">如果你还没有注册CC联盟，请点这里注册</a></td>
    </tr>
	<tr> 
      <td class="tablerow"><b>发视频按钮样式</b></td>
      <td colspan="2"  class="tablerow"><input name="setting[cc_style]" type="text" size="5" value="<?=$cc_style?>" id="cc_style" onkeyup="cc_preview(this.value);"> 请填写1-16的数字</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>按钮样式预览</b>
	  </td>
      <td colspan="2" class="tablerow" id="cc_preview"> </td>
    </tr>
  </tbody>
</table>
	  <script type="text/javascript">
	  function cc_preview(style)
	  {
		  var str = (style>16 || style<1) ? '<font color="red">参数错误</font>' : '按钮样式 <object width="86" height="22"><param name="wmode" value="transparent" /><param name="allowScriptAccess" value="always" /><param name="movie" value="http://union.bokecc.com/flash/plugin_'+style+'.swf?userID='+$('cc_uid').value+'&type=Phpcms" /><embed src="http://union.bokecc.com/flash/plugin_'+style+'.swf?userID='+$('cc_uid').value+'&type=Phpcms" type="application/x-shockwave-flash" width="86" height="22" allowScriptAccess="always"></embed></object>';
		  $('cc_preview').innerHTML = str;
	  }
	  cc_preview($('cc_style').value);
	  </script>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'><input name='setting[version]' type='hidden' id='version' value='<?=PHPCMS_VERSION?>'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>