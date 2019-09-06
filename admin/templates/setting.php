<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script type="text/javascript" src="<?=PHPCMS_PATH?>fckeditor/fckeditor.js"></script>
<script type="text/javascript">
	var editorBasePath = '<?=PHPCMS_PATH?>fckeditor/';
	var ChannelId = <?=$channelid?> ;
</script>

<script type="text/javascript">
window.onload = function()
{
	var oFCKeditor = new FCKeditor('copyright',450,200,'Basic') ;
	oFCKeditor.BasePath	= editorBasePath ;
	oFCKeditor.ReplaceTextarea() ;
}
</script>

<body>
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
<td id='TabTitle7' class='title1' onclick='ShowTabs(7)'>论坛整合</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">

  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
    <tr>
      <td width='40%' class='tablerow'><strong>网站名称</strong></td>
      <td class='tablerow'><input name='setting[sitename]' type='text' id='sitename' value='<?=$sitename?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>网站地址</strong><br>请添写完整URL地址</td>
      <td class='tablerow'><input name='setting[siteurl]' type='text' id='siteurl' value='<?=$siteurl?>' size='40' maxlength='255'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><font color=red><strong>安装目录</strong><br>系统安装目录（相对于根目录的位置）<br>系统会自动获得正确的路径，但需要手工保存设置。</font></td>
      <td class='tablerow'><input name='newrootpath' type='text' id='newrootpath' value='<?=$rootpath?>' size='40' maxlength='30' readonly></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>LOGO地址</strong><br>请添写完整URL地址</td>
      <td class='tablerow'><input name='setting[logo]' type='text' id='logo' value='<?=$logo?>' size='40' maxlength='255'> <input type="button" value=" 上传 " onClick="javascript:openwinx('?mod=phpcms&file=uppic&channelid=<?=$channelid?>&uploadtext=logo&width=88&height=31','upload','350','200')"></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>友情链接LOGO地址</strong><br>请添写完整URL地址，一般为 88*31 px</td>
      <td class='tablerow'><input name='setting[linklogo]' type='text' id='linklogo' value='<?=$linklogo?>' size='40' maxlength='255'> <input type="button" value=" 上传 " onClick="javascript:openwinx('?mod=phpcms&file=uppic&channelid=<?=$channelid?>&uploadtext=linklogo&width=88&height=31','upload','350','200')"></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>Title（网站标题）</strong><br>针对搜索引擎设置的网页标题</td>
      <td class='tablerow'><input name='setting[meta_title]' type='text' id='meta_title' value='<?=$meta_title?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>Meta Keywords（网页关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='setting[meta_keywords]' cols='60' rows='2' id='meta_keywords'><?=$meta_keywords?></textarea></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>Meta Description（网页描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='setting[meta_description]' cols='60' rows='2' id='meta_description'><?=$meta_description?></textarea></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>管理员信箱</strong></td>
      <td class='tablerow'><input name='setting[webmasteremail]' type='text' id='webmasteremail' value='<?=$webmasteremail?>' size='40' maxlength='100'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>版权信息</strong><br>将显示在网站底部</td>
      <td class='tablerow'>        <textarea name='setting[copyright]' id="copyright" style='display:none' ><?=$copyright?></textarea>
	  </td> 
	  </tr>
  </tbody>

  <tbody id='Tabs1' style='display:none'>
    <th colspan=2>网站设置</th>
	<tr>
      <td width='40%' class='tablerow'><strong>附件目录</strong></td>
      <td class='tablerow'><input name='setting[uploaddir]' type='text' id='uploaddir' value='<?=$uploaddir?>' size='40' maxlength='50'></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>允许上传的附件类型</strong></td>
      <td class='tablerow'><input name='setting[uploadfiletype]' type='text' id='uploadfiletype' value='<?=$uploadfiletype?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>页面Gzip压缩</strong><br>
	  将页面内容以gzip压缩后传输，可以加快传输速度，需PHP 4.0.4以上且支持Zlib模块才能使用
	  </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enablegzip]' value='1'  <?php if($enablegzip){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablegzip]' value='0'  <?php if(!$enablegzip){ ?>checked <?php } ?>> 否
     </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>信息列表最大页数</strong><br></td>
      <td class='tablerow'><input name='setting[maxpage]' type='text' id='maxpage' value='<?=$maxpage?>' size='40' maxlength='255'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>信息列表每页默认信息条数</strong><br></td>
      <td class='tablerow'><input name='setting[pagesize]' type='text' id='pagesize' value='<?=$pagesize?>' size='40' maxlength='255'></td>
    </tr>
  </tbody>

  <tbody id='Tabs2' style='display:none'>
      <th colspan=2>搜索设置</th>
    <tr>
      <td width='40%' class='tablerow'><strong>每次搜索时间间隔</strong><br>
	  设置合理的每次搜索时间间隔，可以避免恶意搜索而消耗大量系统资源</td>
      <td class='tablerow'><input name='setting[searchtime]' type='text' id='searchtime' value='<?=$searchtime?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>搜索返回最多的结果数</strong><br>
	  返回搜索的结果数和消耗的资源成正比，请合理设置，建议不要设置过大</td>
      <td class='tablerow'><input name='setting[maxsearchresults]' type='text' id='maxsearchresults' value='<?=$maxsearchresults?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>每页信息数</strong></td>
      <td class='tablerow'><input name='setting[searchperpage]' type='text' id='searchperpage' value='<?=$searchperpage?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>是否启用全文搜索</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[searchcontent]' value='1'  <?php if($searchcontent){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[searchcontent]' value='0'  <?php if(!$searchcontent){ ?>checked <?php } ?>> 否
</td>
    </tr>
  </tbody>

  <tbody id='Tabs3' style='display:none'>
      <th colspan=2>安全设置</th>
    <tr>
      <td width='40%' class='tablerow'><strong>允许访问后台的IP列表</strong><br/>
	  只有当管理员处于本列表中的 IP 地址时才可以访问网站后台，列表以外的地址访问将无法访问，但仍可访问网站前台界面，请务必慎重使用本功能。每个 IP 一行，既可输入完整地址，也可只输入 IP 开头，例如 "192.168." 可匹配 192.168.0.0~192.168.255.255 范围内的所有地址<br/><font color="red">留空则所有 IP 均可访问网站后台</font>
	  </td>
      <td class='tablerow'>
	  <textarea name='setting[adminaccessip]' cols='60' rows='8' id='adminaccessip'><?=$adminaccessip?></textarea>
	  </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>后台最大登陆失败次数</strong><br/>登陆失败次数超过后系统将自动锁定该IP，0表示不限制次数</td>
      <td class='tablerow'>
	  <input name='setting[maxfailedtimes]' type='text' id='maxfailedtimes' value='<?=$maxfailedtimes?>' size='10' maxlength='2'> 次
	  </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>IP锁定时间</strong><br/>超过锁定时间后该IP将自动解锁</td>
      <td class='tablerow'>
        <input name='setting[maxlockedtime]' type='text' id='maxlockedtime' value='<?=$maxlockedtime?>' size='10' maxlength='5'> 小时
      </td>
	</tr>
    <tr>
      <td width='40%' class='tablerow'><strong>IP访问禁止</strong><br/>可按IP或者IP段设置禁止访问站点，此功能会消耗一定的服务器资源</td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enablebanip]' value='1'  <?php if($enablebanip){ ?>checked <?php } ?>> 启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablebanip]' value='0'  <?php if(!$enablebanip){ ?>checked <?php } ?>> 禁用
      </td>
	</tr>
    <tr>
      <td width='40%' class='tablerow'><strong>后台登录验证码</strong><br/><?php if($enablegd){ ?>您的空间支持GD库，建议开启，这样有利于加强系统安全。 <?php }else{ ?>您的空间不支持GD库，无法开启。 <?php } ?> </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enableadmincheckcode]' value='1'  <?php if($enableadmincheckcode){ ?>checked <?php } ?> <?php if(!$enablegd){ ?>disabled<?php } ?>> 启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableadmincheckcode]' value='0'  <?php if(!$enableadmincheckcode){ ?>checked <?php } ?>> 禁用
      </td>
	</tr>
  </tbody>

    <tbody id='Tabs4' style='display:none'>
      <th colspan=2>图片处理</th>
	 <tr>
      <td width='40%' class='tablerow'><strong>PHP图形处理（GD库）功能检测</strong></td>
      <td class='tablerow'>
	  <?=$gd?>
     </td>
    </tr>
	 <tr>
      <td width='40%' class='tablerow'><strong>是否启用缩略图</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enablethumb]' value='1'  <?php if($enablegd && $enablethumb){ ?>checked <?php } ?>> 启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablethumb]' value='0'  <?php if(!$enablegd || !$enablethumb){ ?>checked <?php } ?>> 禁用&nbsp;&nbsp;&nbsp;&nbsp;
     </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>缩略图默认宽度</strong></td>
      <td class='tablerow'><input name='setting[thumb_width]' type='text' id='thumb_width' value='<?=$thumb_width?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>缩略图默认高度</strong></td>
      <td class='tablerow'><input name='setting[thumb_height]' type='text' id='thumb_height' value='<?=$thumb_height?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>缩略图算法</strong></td>
      <td class='tablerow'>
       宽和高都大于0时，缩小成指定大小，其中一个为0时，按比例缩小<br>
      </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>水印类型</strong></td>
      <td class='tablerow'>
	  <input type='radio' name='setting[water_type]' value='0'  <?php if(!$enablegd || $water_type==0){ ?>checked <?php } ?>> 不启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[water_type]' value='1'  <?php if($enablegd && $water_type==1){ ?>checked <?php } ?>> 文字水印&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[water_type]' value='2'  <?php if($enablegd && $water_type==2){ ?>checked <?php } ?>> 图片水印
     </td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>水印文字</strong></td>
      <td class='tablerow'><input name='setting[water_text]' type='text' id='water_text' value='<?=$water_text?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>文字字体</strong></td>
      <td class='tablerow'><input name='setting[water_font]' type='text' id='water_font' value='<?=$water_font?>' size='40' maxlength='50'></td>
    </tr>
	    <tr>
      <td width='40%' class='tablerow'><strong>文字大小</strong><br> 若使用文字水印，请将字体上传到对应位置</td>
      <td class='tablerow'><input name='setting[water_fontsize]' type='text' id='water_fontsize' value='<?=$water_fontsize?>' size='40' maxlength='50'></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>文字颜色</strong></td>
      <td class='tablerow'><input name='setting[water_fontcolor]' type='text' id='water_fontcolor' value='<?=$water_fontcolor?>' size='40' maxlength='50'><?=color_select("fontcolor","颜色",$water_fontcolor,0," onchange='myform.water_fontcolor.value=this.value'") ?></td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>水印图片</strong></td>
      <td class='tablerow'><input name='setting[water_image]' type='text' id='water_image' value='<?=$water_image?>' size='40' maxlength='50'>
	  <input type="button" value="上传图片" onClick="javascript:openwinx('?mod=phpcms&file=uppic&uploadtext=water_image','upload','350','350')">
	  </td>
    </tr>
	    <tr>
      <td width='40%' class='tablerow'><strong>水印位置</strong><br>
	  您可以设置自动为用户上传的 JPG/PNG/GIF 图片附件添加水印，请在此选择水印添加的位置(3x3 共 9 个位置可选)。本功能需要 GD 库支持才能使用，暂不支持动画 GIF 格式。附加的水印图片位于 ./images/watermark.gif，您可替换此文件以实现不同的水印效果
	  </td>
      <td class='tablerow'>
	  
	  <table cellspacing="1" cellpadding="4" width="150" bgcolor="#dddddd">
	  <tr align="center"  bgcolor="#ffffff"><td><input type="radio" name="setting[water_pos]" value="1" <?php if($water_pos==1){ ?>checked <?php } ?>> #1</td><td><input type="radio" name="setting[water_pos]" value="2" <?php if($water_pos==2){ ?>checked <?php } ?>> #2</td><td><input type="radio" name="setting[water_pos]" value="3" <?php if($water_pos==3){ ?>checked <?php } ?>> #3</td></tr>
	  <tr align="center"  bgcolor="#ffffff"><td><input type="radio" name="setting[water_pos]" value="4" <?php if($water_pos==4){ ?>checked <?php } ?>> #4</td><td><input type="radio" name="setting[water_pos]" value="5" <?php if($water_pos==5){ ?>checked <?php } ?>> #5</td><td><input type="radio" name="setting[water_pos]" value="6" <?php if($water_pos==6){ ?>checked <?php } ?>> #6</td></tr>
	  <tr align="center" bgcolor="#ffffff"><td><input type="radio" name="setting[water_pos]" value="7" <?php if($water_pos==7){ ?>checked <?php } ?>> #7</td><td><input type="radio" name="setting[water_pos]" value="8" <?php if($water_pos==8){ ?>checked <?php } ?>> #8</td><td><input type="radio" name="setting[water_pos]" value="9" <?php if($water_pos==9){ ?>checked <?php } ?>> #9</td></tr>
	  </table>

    </tr>
  </tbody>

   <tbody id='Tabs5' style='display:none'>
	  <th colspan=2>邮件设置</th>
    <tr>
      <td class="tablerow"><b>发送方式</b></td>
      <td class="tablerow">
	  <input type="radio" name="setting[sendmailtype]"  value="smtp" <?php if($sendmailtype=="smtp"){ ?>checked <?php } ?> />SMTP方式
      <input type="radio" name="setting[sendmailtype]" value="mail"  <?php if($sendmailtype=="mail"){ ?>checked <?php } ?>/>Mail函数（Windows服务器不支持）
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>邮箱SMTP</b><br>SMTP服务器，只有正确设置才能使用发邮件功能</td>
      <td  class="tablerow"><input name="setting[smtphost]" type="text" size="40" value="<?=$smtphost?>"></td>
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
  </tbody>

    <tbody id='Tabs6' style='display:none'>
	  <th colspan=2>ftp设置</th>
	<tr>
      <td width='45%' class='tablerow'><strong>是否启用FTP功能</strong><br>开启FTP功能后，phpcms将采用ftp方式建立目录和修改权限<br/>
     <?php if(!function_exists('ftp_connect')){ ?><font color="red">当前PHP环境不支持FTP功能！</font><?php }?>
	 <?php if(strpos(strtolower($PHP_OS),"win")===false){ ?><font color="red">当前服务器操作系统为非WINDOWS系统，建议设置好ftp并启用FTP功能。<br/></font>
	 <?php }else{ ?>
        <font color="red">当前服务器操作系统为WINDOWS系统，您不需要启用FTP功能。<br/></font>
	 <?php } ?>
     <?php if($safe_mode){ ?><font color="red">php正以安全模式运行，请开启并配置好ftp，否则可能导致无法正常使用phpcms！</font><?php }?>
	  </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[enableftp]' value='1'  <?php if($enableftp){ ?>checked <?php } ?>> 启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableftp]' value='0'  <?php if(!$enableftp){ ?>checked <?php } ?>> 禁用&nbsp;&nbsp;&nbsp;&nbsp;
     </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>ftp主机</b></td>
      <td class="tablerow"><input name="setting[ftphost]" id="ftphost" type="text" size="40" value="<?=$ftphost?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>ftp帐号</b></td>
      <td  class="tablerow"><input name="setting[ftpuser]" id="ftpuser" type="text" size="40" value="<?=$ftpuser?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>ftp密码</b><br></td>
      <td  class="tablerow"><input name="setting[ftppass]" id="ftppass" type="password" size="40" value="<?=$ftppass?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>PHPCMS根目录相对FTP根目录的路径</b><br>有很多虚拟主机的ftp根目录与web根目录不一样<br/>您需要正确设置才能使用ftp功能</td>
      <td class="tablerow"><input name="setting[ftpwebpath]" id="ftpwebpath" type="text" size="40" value="<?=$ftpwebpath?>"><br>注意以“/”结尾，例如有的是 wwwroot/ 或者 www/<br/>留空则表示ftp根目录与phpcms根目录路径相同</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>测试ftp连接</b><br></td>
      <td  class="tablerow"><input name="testftp" type="button" size="40" value="点击测试ftp连接是否正确" onClick="javascript:openwinx('?mod=phpcms&file=setting&action=testftp&ftphost='+myform.ftphost.value+'&ftpuser='+myform.ftpuser.value+'&ftppass='+myform.ftppass.value+'&ftpwebpath='+myform.ftpwebpath.value,'testftp','450','180')"></td>
    </tr>
  </tbody>

  <tbody id='Tabs7' style='display:none'>
    <th colspan=2>论坛整合</th>
    <tr> 
      <td class="tablerow" width="40%"><b>是否整合论坛</b><br>请先安装好论坛，整合后phpcms将与论坛统一注册和登录</td>
      <td  class="tablerow"><input type="radio" name="setting[enablepassport]" value="1" <?php if($enablepassport){?>checked<?php }?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[enablepassport]" value="0" <?php if(!$enablepassport){?>checked<?php }?>>否</td>
    </tr>
	    <tr> 
      <td class="tablerow"><b>论坛接口地址</b><br>请填写论坛接口访问的网址</td>
      <td  class="tablerow"><input name="setting[passport_url]" type="text" size="50" value="<?=$passport_url?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>论坛认证密钥</b><br>请填写论坛验证的密钥</td>
      <td  class="tablerow"><input name="setting[passport_key]" type="text" size="30" value="<?=$passport_key?>"></td>
    </tr>
  </tbody>
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<input name='setting[version]' type='hidden' id='version' value='<?=PHPCMS_VERSION?>'>
	<input type="submit" name="Submit" value="保存基本配置">
	</td>
  </tr>
</table>
</form>
</body>
</html>