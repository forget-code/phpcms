<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本配置</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>新楼盘html</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>出租等html</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>收费设置</td>
<td id='TabTitle4' class='title1' onclick='ShowTabs(4)'>RSS配置</td>
<td>&nbsp;</td>
</tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
  <tr>
    <td width='200' class='tablerow'><strong>Meta Title（房产标题）</strong><br>
      针对搜索引擎设置的标题</td>
    <td class='tablerow'><textarea name='setting[seo_title]' cols='60' rows='2' id='seo_title'><?=$seo_title?>
</textarea></td>
  </tr>
  <tr>
    <td width='200' class='tablerow'><strong>Meta Keywords（网页关键词）</strong><br>
      针对搜索引擎设置的关键词</td>
    <td class='tablerow'><textarea name='setting[seo_keywords]' cols='60' rows='2' id='seo_keywords'><?=$seo_keywords?>
</textarea></td>
  </tr>
  <tr>
    <td width='200' class='tablerow'><strong>Meta Description（网页描述）</strong><br>
      针对搜索引擎设置的网页描述</td>
    <td class='tablerow'><textarea name='setting[seo_description]' cols='60' rows='2' id='seo_description'><?=$seo_description?>
</textarea></td>
  </tr>
  <tr>
    <td width='200' class='tablerow'><strong>模块绑定域名</strong><br>
      最后不带反斜线'/'</td>
    <td class='tablerow'><input name='setting[moduledomain]' type='text' id='moduledomain' value='<?=$moduledomain?>' size='40' maxlength='50'></td>
  </tr>
  <tr>
    <td class="tablerow"><strong>默认缩略图设置</strong></td>
    <td class="tablerow"> 宽度:
        <input type="text" name="setting[thumb_width]" value="<?=$thumb_width?>" size="4">
      px 高度:
      <input type="text" name="setting[thumb_height]" value="<?=$thumb_height?>" size="4">
      px </td>
  </tr>
  <tr>
    <td class="tablerow"><strong>允许游客发布信息</strong></td>
    <td class="tablerow">
      <input type="radio" name="setting[enable_guest_add]" value="1"  <?php if($enable_guest_add){ ?>checked <?php } ?>>
      是 &nbsp;&nbsp;
      <input type="radio" name="setting[enable_guest_add]" value="0"  <?php if(!$enable_guest_add){ ?>checked <?php } ?>>
      否 </td>
  </tr>
  <tr>
    <td class="tablerow"><strong>会员发布信息是否需要审核再显示</strong></td>
    <td class="tablerow">
      <input type="radio" name="setting[enablecheck]" value="1"  <?php if($enablecheck){ ?>checked <?php } ?>>
      是 &nbsp;&nbsp;
      <input type="radio" name="setting[enablecheck]" value="0"  <?php if(!$enablecheck){ ?>checked <?php } ?>>
      否 </td>
  </tr>
  <tr>
    <td class="tablerow"><strong>会员发布信息是否自动生成html(在设置为html时)</strong></td>
    <td class="tablerow">
      <input type="radio" name="setting[autohtml]" value="1"  <?php if($autohtml){ ?>checked <?php } ?>>
      是 &nbsp;&nbsp;
      <input type="radio" name="setting[autohtml]" value="0"  <?php if(!$autohtml){ ?>checked <?php } ?>>
      否 </td>
  </tr>
  <tr>
    <td class="tablerow"><strong>关闭前台提交信息</strong></td>
    <td class="tablerow">
      <input type="radio" name="setting[enablecontribute]" value="0"  <?php if($enablecontribute==0){ ?>checked <?php } ?>>
      是 &nbsp;&nbsp;
      <input type="radio" name="setting[enablecontribute]" value="1"  <?php if($enablecontribute==1){ ?>checked <?php } ?>>
      否 </td>
  </tr>
  <tr>
    <td class="tablerow"><strong>前台是否显示浏览次数</strong></td>
    <td class="tablerow">
      <input type="radio" name="setting[showhits]" value="1"  <?php if($showhits==1){ ?>checked <?php } ?>>
      是 &nbsp;&nbsp;
      <input type="radio" name="setting[showhits]" value="0"  <?php if($showhits==0){ ?>checked <?php } ?>>
      否 </td>
  </tr>
  <tr>
    <td class="tablerow"><strong>添加信息增加点数</strong></td>
    <td class="tablerow"><input type="text" name="setting[add_point]" value="<?=$add_point?>" size="5">
      0表示不增加 </td>
  </tr>
  <tr>
    <td class="tablerow"><strong>发布信息时是否启用验证码</strong></td>
    <td class="tablerow">
      <input type="radio" name="setting[enablecheckcode]" value="1"  <?php if($enablecheckcode){ ?>checked <?php } ?>>
      是 &nbsp;&nbsp;
      <input type="radio" name="setting[enablecheckcode]" value="0"  <?php if(!$enablecheckcode){ ?>checked <?php } ?>>
      否</td>
  </tr>
  <tr>
    <td width='200' class='tablerow'><strong>房产附件目录</strong></td>
    <td class='tablerow'><input name='setting[uploaddir]' type='text' id='uploaddir' value='<?=$uploaddir?>' size='40' maxlength='50'></td>
  </tr>
  <tr>
    <td width='200' class='tablerow'><strong>允许上传的附件类型</strong><br/>
      在允许上传文件的前提下生效</td>
    <td class='tablerow'><input name='setting[uploadfiletype]' type='text' id='uploadfiletype' value='<?=$uploadfiletype?>' size='40' maxlength='50'></td>
  </tr>
  <tr>
    <td class="tablerow"><strong>首页是否生成html</strong></td>
    <td class="tablerow">
      <input type="radio" name="setting[ishtml]" value="1"  <?php if($ishtml){ ?>checked <?php } ?>>
      是 &nbsp;&nbsp;
      <input type="radio" name="setting[ishtml]" value="0"  <?php if(!$ishtml){ ?>checked <?php } ?>>
      否</td>
  </tr>
  <tr>
    <td width='200' class='tablerow'><strong>信息列表最大页数</strong><br></td>
    <td class='tablerow'><input name='setting[maxpage]' type='text' id='maxpage' value='<?=$maxpage?>' size='20' maxlength='255'></td>
  </tr>
  <tr>
    <td width='200' class='tablerow'><strong>信息列表每页默认信息条数</strong><br></td>
    <td class='tablerow'><input name='setting[pagesize]' type='text' id='pagesize' value='<?=$pagesize?>' size='20' maxlength='255'></td>
  </tr>
  <tbody id='Tabs1' style='display:none;'>
  <th colspan=2>新楼盘html</th>
  <tr>
    <td width='200' class='tablerow'><strong>添加新楼盘后是否生成html</strong> </td>
    <td class='tablerow'>
      <input type='radio' name='setting[displayishtml]' value='1'  <?php if($displayishtml){ ?>checked <?php } ?>>
      是&nbsp;&nbsp;&nbsp;&nbsp;
      <input type='radio' name='setting[displayishtml]' value='0'  <?php if(!$displayishtml){ ?>checked <?php } ?>>
      否 </td>
  </tr>
    <tr>
    <td width='200' class='tablerow'><strong>新楼盘列表是否生成html</strong> </td>
    <td class='tablerow'>
      <input type='radio' name='setting[createlistdisplay]' value='1'  <?php if($createlistdisplay){ ?>checked <?php } ?>>
      是&nbsp;&nbsp;&nbsp;&nbsp;
      <input type='radio' name='setting[createlistdisplay]' value='0'  <?php if(!$createlistdisplay){ ?>checked <?php } ?>>
      否 </td>
  </tr>
      <tr>
    <td width='200' class='tablerow'><strong>新楼盘信息列表页html存放目录</strong><br></td>
    <td class='tablerow'><input name='setting[listdisplaydir]' type='text' id='listdisplaydir' value='<?=$listdisplaydir?>' size='20' ></td>
  </tr>
        <tr>
    <td width='200' class='tablerow'><strong>新楼盘信息列表生成html前缀</strong><br></td>
    <td class='tablerow'><input name='setting[listdisplayprefix]' type='text' id='listdisplayprefix' value='<?=$listdisplayprefix?>' size='20' ></td>
  </tr>
  <tr>
    <td class='tablerow'><strong>楼盘列表url规则(生成html)</strong></td>
    <td class='tablerow'>
      <?=$displaylist_html_urlrule?>
    </td>
  </tr>
  <tr>
    <td class='tablerow'><strong><strong>楼盘</strong>内容url规则(生成html)</strong></td>
    <td class='tablerow'>
      <?=$displayitem_html_urlrule?>
    </td>
  </tr>
  <tr>
    <td class='tablerow'><strong><strong>楼盘列表</strong>url规则(不生成html)</strong></td>
    <td class='tablerow'>
      <?=$displaylist_php_urlrule?>
    </td>
  </tr>
  <tr>
    <td class='tablerow'><strong><strong><strong>楼盘</strong>内容</strong>url规则(不生成html)</strong></td>
    <td class='tablerow'>
      <?=$displayitem_php_urlrule?>
    </td>
  </tr>
  <tr>
    <td class='tablerow'><strong>把以上设置应用到所有楼盘</strong></td>
    <td class='tablerow'><input type="radio" name="displaycreatetype_application" value="1" />
      是
        <input type="radio" name="displaycreatetype_application" value="0" checked />
      否</td>
  </tr>
  <tbody id='Tabs2' style='display:none;'>
  <th colspan=2>出租等html（包括
          <?php foreach($INFOtype as $v) echo $v.",";?>
          等信息）</th>
  <tr>
    <td width='200' class='tablerow'><strong>房产信息是否生成html</strong> </td>
    <td class='tablerow'>
      <input type='radio' name='setting[houseishtml]' value='1'  <?php if($houseishtml){ ?>checked <?php } ?>>
      是&nbsp;&nbsp;&nbsp;&nbsp;
      <input type='radio' name='setting[houseishtml]' value='0'  <?php if(!$houseishtml){ ?>checked <?php } ?>>
      否 </td>
  </tr>
    <tr>
    <td width='200' class='tablerow'><strong>房产信息列表是否生成html</strong> </td>
    <td class='tablerow'>
      <input type='radio' name='setting[createlistinfo]' value='1'  <?php if($createlistinfo){ ?>checked <?php } ?>>
      是&nbsp;&nbsp;&nbsp;&nbsp;
      <input type='radio' name='setting[createlistinfo]' value='0'  <?php if(!$createlistinfo){ ?>checked <?php } ?>>
      否 </td>
  </tr>

    <tr>
    <td width='200' class='tablerow'><strong>房产信息列表页html存放目录</strong><br></td>
    <td class='tablerow'><input name='setting[listinfodir]' type='text' id='listinfodir' value='<?=$listinfodir?>' size='20' ></td>
  </tr>


  <tr>
    <td class='tablerow'><strong>信息列表页url规则(生成html)</strong></td>
    <td class='tablerow'><?=$houselist_html_urlrule?></td>
  </tr>
  <tr>
    <td class='tablerow'><strong>信息内容页url规则(生成html)</strong></td>
    <td class='tablerow'>
      <?=$houseitem_html_urlrule?>
    </td>
  </tr>
  <tr>
    <td class='tablerow'><strong>信息列表页url规则(不生成html)</strong></td>
    <td class='tablerow'>
      <?=$houselist_php_urlrule?>
    </td>
  </tr>
  <tr>
    <td class='tablerow'><strong>信息内容页url规则(不生成html)</strong></td>
    <td class='tablerow'>
      <?=$houseitem_php_urlrule?>
    </td>
  </tr>
  <tr>
    <td class='tablerow'><strong>把以上设置应用到全部房产信息</strong></td>
    <td class='tablerow'><input type="radio" name="housecreatetype_application" value="1" />
      是
        <input type="radio" name="housecreatetype_application" value="0" checked />
      否</td>
  </tr>
  </tbody>
  <tbody id='Tabs3' style='display:none;'>
  <th colspan=2>出租等（包括
          <?php foreach($INFOtype as $v) echo $v.",";?>
          信息收费设置）</th>
  <tr>
    <td width='200' class='tablerow'><strong>信息浏览权限：</strong><br>
    </td>
    <td class='tablerow'>
      <table>
        <tr>
          <td width='92' valign='top'><input type='radio' name='setting[enablepurview]' value='0'  <?php if($enablepurview==0){ ?>checked <?php } ?>>
            开放</td>
          <td width="419">任何人（包括游客）可以浏览</td>
        </tr>
        <tr>
          <td width='92' valign='top'><input type='radio' name='setting[enablepurview]' value='1' <?php if($enablepurview==1){ ?>checked <?php } ?>>
            收费/认证</td>
          <td>游客不能浏览，并在下面指定允许浏览的会员组。“生成HTML”选项只能设为“不生成HTML”。</td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td class="tablerow"><strong>查看信息扣点数</strong></td>
    <td class="tablerow"><input type="text" name="setting[readpoint]" value="<?=$readpoint?>" size="5"> 0表示不扣点 </td>
  </tr>
  
    <tr>
      <td class='tablerow'><strong>重复收费设置</strong></td>
      <td class='tablerow'>
	    <input name='setting[chargedays]' type='text' value='<?=$chargedays?>' size='4' maxlength='4' style='text-align:center'> 天内不重复收费&nbsp;&nbsp;
        <font color="red">0 表示每阅读一次就重复收费一次（建议不要使用）</font></td>
    </tr>

  <tr>
    <td class='tablerow'><strong>允许浏览信息的会员组：</strong><br>
    </td>
    <td class='tablerow'>
      <?=$arrgroupid_browse?>
    </td>
  </tr>
  <tr>
    <td width='200' class='tablerow'><strong>无权限浏览信息时的提示信息：</strong><br>
      支持HTML代码，可使用类似{$_groupid}格式的变量</td>
    <td class='tablerow'><textarea name='setting[purview_message]' cols='70' rows='5'><?=$purview_message?>
</textarea></td>
  </tr><tr>
    <td width='200' class='tablerow'><strong>信息需要扣点数时的提示信息：</strong><br>
      支持HTML代码，可使用类似{$readpoint}格式的变量</td>
    <td class='tablerow'><textarea name='setting[point_message]' cols='70' rows='5'><?=$point_message?>
</textarea></td>
  </tr>
  </tbody>

  <tbody id='Tabs4' style='display:none;'>
  <th colspan=2>RSS配置</th>
  <tr>
    <td class="tablerow"><strong>是否启用</strong></td>
    <td class="tablerow">
      <input type="radio" name="setting[enable_rss]" value="1"  <?php if($enable_rss){ ?>checked <?php } ?>>
      是 &nbsp;&nbsp;
      <input type="radio" name="setting[enable_rss]" value="0"  <?php if(!$enable_rss){ ?>checked <?php } ?>>
      否 </td>
  </tr>
  <tr>
    <td class="tablerow"><strong>输出</strong></td>
    <td class="tablerow">
      <input type="radio" name="setting[rss_mode]" value="1"  <?php if($rss_mode){ ?>checked <?php } ?>>
      全文 &nbsp;&nbsp;
      <input type="radio" name="setting[rss_mode]" value="0"  <?php if(!$rss_mode){ ?>checked <?php } ?>>
      摘要 </td>
  </tr>
  <tr>
    <td class="tablerow"><strong>输出条数</strong></td>
    <td class="tablerow">
      <input type="text" name="setting[rss_num]" value="<?=$rss_num?>" size="5">
    </td>
  </tr>
  <tr>
    <td class="tablerow"><strong>输出(内容/摘要)截取长度</strong></td>
    <td class="tablerow">
      <input type="text" name="setting[rss_length]" value="<?=$rss_length?>" size="5">
      留空表示不截取 </td>
  </tr>
</tbody>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确 定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 "></td>
  </tr>
</table>
</form>
</body>
</html>