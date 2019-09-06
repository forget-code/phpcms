<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form name="myform" method="post" action="?file=setting&action=save" id="sys_setting">
<div class="tag_menu" style="width:99%;margin-top:10px;">
<ul>
  <li><a href="#" id='TabTitle0' onclick='ShowTabs(0)' class="selected">基本信息</a></li>
  <li><a href="#" id='TabTitle1' onclick='ShowTabs(1)'>网站设置</a></li>
  <li><a href="#" id='TabTitle2' onclick='ShowTabs(2)'>性能优化</a></li>
  <li><a href="#" id='TabTitle3' onclick='ShowTabs(3)'>安全设置</a></li>
  <li><a href="#" id='TabTitle4' onclick='ShowTabs(4)'>附件设置</a></li>
  <li><a href="#" id='TabTitle5' onclick='ShowTabs(5)'>邮件设置</a></li>
  <li><a href="#" id='TabTitle6' onclick='ShowTabs(6)'>FTP设置</a></li>
  <li><a href="#" id='TabTitle7' onclick='ShowTabs(7)'>通行证</a></li>
  <li><a href="#" id='TabTitle8' onclick='ShowTabs(8)'>扩展设置</a></li>
</ul>
</div>
<table cellpadding="0" cellspacing="1" class="table_form">
  <tbody id='Tabs0' style='display:'>
    <tr>
      <th width="35%"><strong>Phpcms 官方网站帐号</strong><br />在线升级等在线服务将基于此帐号，请正确填写</th>
      <td><input name='setting[phpcmsusername]' type='text' id='phpcms_username' value='<?=$phpcmsusername?>' size='20' maxlength='20' datatype="limit" require="true" min="3" max="20" msg="Phpcms 官方网站帐号必须是3到20个字符" mode=2> <a href="http://www.phpcms.cn/member/register.php" target="_blank" style="color:red">点击免费注册</a></td>
    </tr>
    <tr>
      <th><strong>Phpcms 官方网站密码</strong></th>
      <td><input name='setting[phpcmspassword]' type='password' id='phpcms_password' value='<?=$phpcmspassword?>' size='20' class="noime" maxlength='32' datatype="limit" require="true" min="4" max="32" msg="Phpcms 官方网站密码必须是4到32个字符" mode=2> <input type="button" name="check_user" value="检测帐号密码" onClick="test_user();"></td>
    </tr>
    <tr>
      <th width="35%"><strong>网站名称</strong></th>
      <td><input name='setting[sitename]' type='text' id='sitename' value='<?=$sitename?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <th><strong>网站地址</strong><br>请填写完整URL地址，以“/”结尾</th>
      <td><input name='setting[siteurl]' type='text' id='siteurl' value='<?=$siteurl?>' size='40' class="noime" maxlength='255' datatype="custom" require="true" regexp=".+\/$" msg="URL地址不能为空且要以 / 结束 "> </td>
    </tr>
	<tr>
      <th><strong>生成Html</strong></th>
      <td>
	  <input type='radio' name='setting[ishtml]' value='1' <?php if($ishtml){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ishtml]' value='0' <?php if(!$ishtml){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
    <tr>
      <th><strong>生成文件扩展名</strong></th>
      <td><?=fileext_select('setting[fileext]', $fileext)?></td>
    </tr>
	<tr>
      <th><strong>启用内容页URL加密转换</strong></th>
      <td>
	  <input type='radio' name='setting[enable_urlencode]' value='1'  <?php if($enable_urlencode){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enable_urlencode]' value='0'  <?php if(!$enable_urlencode){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
    <tr>
      <th><strong>Title（网站标题）</strong><br>针对搜索引擎设置的网页标题</th>
      <td><input name='setting[meta_title]' type='text' id='seo_title' value='<?=$meta_title?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <th><strong>Meta Keywords（网页关键词）</strong><br>针对搜索引擎设置的关键词</th>
      <td><textarea name='setting[meta_keywords]' cols='60' rows='2' id='seo_keywords'><?=$meta_keywords?></textarea></td>
    </tr>
    <tr>
      <th><strong>Meta Description（网页描述）</strong><br>针对搜索引擎设置的网页描述</th>
      <td><textarea name='setting[meta_description]' cols='60' rows='2' id='seo_description'><?=$meta_description?></textarea></td>
    </tr>
    <tr>
      <th><strong>版权信息</strong><br>将显示在网站底部</th>
      <td><textarea name='setting[copyright]' id="copyright" cols="60" rows="4"><?=$copyright?></textarea> <?=form::editor('copyright','introduce','100%',200)?>
	  </td>
	</tr>
    <tr>
      <th><strong>网站ICP备案序号</strong><br>请在信息产业部管理网站申请<br><a href="http://www.miibeian.gov.cn" target="_blank">http://www.miibeian.gov.cn</a></th>
      <td><input name='setting[icpno]' type='text' id='linklogo' value='<?=$icpno?>' size='40' maxlength='255'></td>
    </tr>
  </tbody>

  <tbody id='Tabs1' style='display:none'>
	<tr>
      <th width="35%"><strong>切换分页方式</strong></th>
      <td>
  <label onclick="javascript:$('#pagemode').hide();"><input type='radio' name='setting[pagemode]' value='1'  <?php if($pagemode){ ?>checked <?php } ?>> 多页显示方式</label>&nbsp;&nbsp;&nbsp;&nbsp;
  <label onclick="javascript:$('#pagemode').show();"><input type='radio' name='setting[pagemode]' value='0'  <?php if(!$pagemode){ ?>checked <?php } ?>> 上下分页方式</label>
  </td>
    </tr>
    <tr id="pagemode" style="display:<?php if($pagemode) echo 'none';?>">
      <th width="35%"><strong>分页代码</strong><br />可自定义分页html代码， {$name} 格式的字符串是变量</th>
      <td><textarea name='setting[pageshtml]' cols='60' rows='5' id='pageshtml' style="width:100%;height:130px"><?=$pageshtml?></textarea></td>
    </tr>
	<tr>
      <th><strong>中文分词方式</strong></th>
      <td>
	  <input type='radio' name='setting[segmentclass]' value='segment' <?=$segmentclass=='segment' ? 'checked' : ''?> /> 系统自带分词 <br/>
	  <input type='radio' name='setting[segmentclass]' value='scws'  <?=$segmentclass == 'scws' ? 'checked' : ''?> <?=extension_loaded('scws') ? '' : 'disabled'?>/> SCWS分词扩展
	  </td>
    </tr>
	<tr>
		<th><strong>开启后台左侧菜单滚动条</strong></th>
		<td>
		<input type='radio' name='setting[enablegetscrollbar]' value='1'  <?php if($enablegetscrollbar){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='setting[enablegetscrollbar]' value='0'  <?php if(!$enablegetscrollbar){ ?>checked <?php } ?>> 否
		</td>
	</tr>
	<tr>
      <th><strong>启用自动提取关键词功能</strong></th>
      <td>
	  <input type='radio' name='setting[enablegetkeywords]' value='1'  <?php if($enablegetkeywords){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enablegetkeywords]' value='0'  <?php if(!$enablegetkeywords){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
	<tr>
      <th><strong>网站默认地区</strong></th>
      <td>
<input type="hidden" name="setting[areaid]" id="areaid" value="<?=$areaid?>">
<?php if($areaid){ ?>
<span onClick="this.style.display='none';$('#reselect_areaid').show();" style="cursor:pointer;"><?=$AREA[$areaid]['name']?><font color="red">点击重选</font></span>
<span id="reselect_areaid" style="display:none;">
<?php } ?>
<span id="load_areaid"></span>
<a href="javascript:areaid_reload();">重选</a>
<?php if($areaid){ ?>
</span>
<?php } ?>
<script type="text/javascript">
function areaid_load(id)
{
	$.get('load.php', { field: 'areaid', id: id },
		  function(data){
			$('#load_areaid').append(data);
		  });
}
function areaid_reload()
{
	$('#load_areaid').html('');
	areaid_load(0);
}
areaid_load(0);
</script>
	  </td>
    </tr>
	<tr>
      <th><strong>数据恢复保留时间</strong><br>编辑器数据自动保存的最长时间</th>
      <td><select name='setting[editor_max_data_hour]' >
	<option value="1" <?php if($editor_max_data_hour==1)echo('selected');?>> 1小时</option>
	<option value="2" <?php if($editor_max_data_hour==2)echo('selected');?>> 2小时</option>
	<option value="3" <?php if($editor_max_data_hour==3)echo('selected');?>> 3小时</option>
	<option value="4" <?php if($editor_max_data_hour==4)echo('selected');?>> 4小时</option>
	<option value="5" <?php if($editor_max_data_hour==5)echo('selected');?>> 5小时</option>
	<option value="6" <?php if($editor_max_data_hour==6)echo('selected');?>> 6小时</option>
	</select></td>
    </tr>
		<tr>
      <th><strong>数据恢复自动保存时间间隔</strong></th>
      <td><input type="text" name="setting[editor_interval_data]" value="<?php echo($editor_interval_data);?>" size="3"> 秒</td>
    </tr>
     <tr>
      <th><strong>开启栏目统计</strong><br />开启栏目统计，会对栏目的访问量进行统计</th>
      <td><input name='setting[category_count]' type='checkbox' id='category_count' value='1' <?php if ($category_count){echo 'checked';}?>></td>
    </tr>
	<tr>
      <th><strong>显示浏览次数</strong></th>
      <td><input name='setting[show_hits]' type='checkbox' id='show_hits' value='1' <?php if ($show_hits){echo 'checked';}?>></td>
    </tr>
     <tr>
      <th><strong>开启定时发布</strong><br />发布时间大于系统时间的文章将会定时发布</th>
      <td><input name='setting[publish]' type='checkbox' id='publish' value='1' <?php if ($publish){echo 'checked';}?>></td>
    </tr>
  </tbody>

  <tbody id='Tabs2' style='display:none'>
  	<tr>
      <th width="35%"><strong>启用模板缓存自动更新</strong><br />关闭此功能可明显提高速度和系统负载，但是如果模板被修改系统不会自动更新缓存，必须手动更新模板缓存。</th>
      <td>
	  <input type='radio' name='setconfig[TPL_REFRESH]' value='1'  <?php if(TPL_REFRESH){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[TPL_REFRESH]' value='0'  <?php if(!TPL_REFRESH){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
    <tr>
      <th><strong>启用页面Gzip压缩</strong><br>
	  将页面内容以gzip压缩后传输，可加快传输速度
	  </th>
      <td>
	  <input type='radio' name='setconfig[GZIP]' value='1'  <?php if(GZIP){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[GZIP]' value='0'  <?php if(!GZIP){ ?>checked <?php } ?>> 否
     </td>
    </tr>
    <tr>
      <th><strong>列表页最大页数</strong><br></th>
      <td><input name='setting[maxpage]' type='text' id='maxpage' value='<?=$maxpage?>' size='5' maxlength='255'> 页</td>
    </tr>
    <tr>
      <th><strong>列表页默认信息数(条)</strong><br />至少为1,否则可能导致列表页错误发生</th>
      <td><input name='setting[pagesize]' type='text' id='pagesize' value='<?=$pagesize?>' size='5' maxlength='255' require="true" datatype="compare" compare=">0" msg="不能为空且必须大于0"> </td>
    </tr>
    <tr>
      <th><strong>更新内容时列表页自动生成页数</strong><br></th>
      <td><input name='setting[autoupdatelist]' type='text' id='autoupdatelist' value='<?=$autoupdatelist?>' size='5' maxlength='1' require="true" datatype="compare" compare=">0" msg="不能为空且要大于0"> 页 （建议不要超过 5 页）</td>
    </tr>
    <tr>
      <td colspan="3" class="tablerowhighlight" align="center">缓存设置</td>
    </tr>
	<tr>
      <th><strong>启用PHP页面缓存</strong><br />不生成静态页时缓存PHP动态页面，仅对前台有效</th>
      <td>
	  <input type='radio' name='setconfig[CACHE_PAGE]' value='1'  <?php if(CACHE_PAGE == 1){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[CACHE_PAGE]' value='0'  <?php if(CACHE_PAGE == 0){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
	<tr>
      <th><strong>页面缓存默认更新周期</strong></th>
      <td>
	  <input type='text' name='setconfig[CACHE_PAGE_TTL]' value='<?=CACHE_PAGE_TTL?>' size='6'> 秒
	  </td>
    </tr>
	<tr>
      <th><strong>网站首页缓存更新周期</strong></th>
      <td>
	  <input type='text' name='setconfig[CACHE_PAGE_INDEX_TTL]' value='<?=CACHE_PAGE_INDEX_TTL?>' size='6'> 秒
	  </td>
    </tr>
	<tr>
      <th><strong>栏目首页缓存更新周期</strong></th>
      <td>
	  <input type='text' name='setconfig[CACHE_PAGE_CATEGORY_TTL]' value='<?=CACHE_PAGE_CATEGORY_TTL?>' size='6'> 秒
	  </td>
    </tr>
	<tr>
      <th><strong>信息列表页缓存更新周期</strong></th>
      <td>
	  <input type='text' name='setconfig[CACHE_PAGE_LIST_TTL]' value='<?=CACHE_PAGE_LIST_TTL?>' size='6'> 秒
	  </td>
    </tr>
	<tr>
      <th><strong>内容页缓存更新周期</strong></th>
      <td>
	  <input type='text' name='setconfig[CACHE_PAGE_CONTENT_TTL]' value='<?=CACHE_PAGE_CONTENT_TTL?>' size='6'> 秒
	  </td>
    </tr>
    <tr>
      <td colspan="3" class="tablerowhighlight" align="center">搜索设置</td>
    </tr>
    <tr>
      <th><strong>搜索时间间隔</strong><br>
	  设置合理的每次搜索时间间隔，可以避免恶意搜索而消耗大量系统资源</th>
      <td><input name='setting[search_time]' type='text' id='search_time' value='<?=$search_time?>' size='5' maxlength='4'> 秒</td>
    </tr>
    <tr>
      <th><strong>搜索返回最多的结果数</strong><br>
	  返回搜索的结果数和消耗的资源成正比，请合理设置，建议不要设置过大</th>
      <td><input name='setting[search_maxresults]' type='text' id='search_maxresults' value='<?=$search_maxresults?>' size='5' maxlength='50'> 条</td>
    </tr>
    <tr>
      <th><strong>每页信息数</strong><br />至少为1,否则可能导致列表页错误发生</th>
      <td><input name='setting[search_pagesize]' type='text' id='search_pagesize' value='<?=$search_pagesize?>' size='5' maxlength='50'> 条</td>
    </tr>
  </tbody>

  <tbody id='Tabs3' style='display:none'>
    <tr>
      <th width="35%"><strong>网站安全密钥</strong></th>
      <td>
	  <input name='setconfig[AUTH_KEY]' type='text' id='auth_key' value='<?=AUTH_KEY?>' size='30' maxlength='20'>
	  </td>
    </tr>
	<tr>
      <th><strong>启用后台管理操作日志</strong></th>
      <td>
	  <input type='radio' name='setconfig[ADMIN_LOG]' value='1'  <?php if(ADMIN_LOG){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[ADMIN_LOG]' value='0'  <?php if(!ADMIN_LOG){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
    <tr>
      <th><strong>允许访问后台的IP列表</strong><br/>
	  只有当管理员处于本列表中的 IP 地址时才可以访问网站后台，列表以外的地址访问将无法访问，但仍可访问网站前台界面，请务必慎重使用本功能。每个 IP 一行，既可输入完整地址，也可只输入 IP 开头，例如 "192.168." 可匹配 192.168.0.0~192.168.255.255 范围内的所有地址<br/><font color="red">留空则所有 IP 均可访问网站后台</font>
	  </th>
      <td>
	  <textarea name='setting[adminaccessip]' cols='30' rows='8' id='adminaccessip'><?=$adminaccessip?></textarea>
	  </td>
    </tr>
    <tr>
      <th><strong>后台最大登陆失败次数</strong><br/>登陆失败次数超过后系统将自动锁定该IP，0表示不限制次数</th>
      <td>
	  <input name='setting[maxloginfailedtimes]' type='text' id='maxloginfailedtimes' value='<?=$maxloginfailedtimes?>' size='5' maxlength='2'> 次
	  </td>
    </tr>
    <tr>
      <th><strong>IP锁定时间</strong><br/>超过锁定时间后该IP将自动解锁</th>
      <td>
        <input name='setting[maxiplockedtime]' type='text' id='maxiplockedtime' value='<?=$maxiplockedtime?>' size='5' maxlength='5'> 小时
      </td>
	</tr>
    <tr>
      <th><strong>IP访问禁止</strong><br/>可按IP或者IP段设置禁止访问站点，此功能会消耗一定的服务器资源</th>
      <td>
	  <input type='radio' name='setting[enable_ipbanned]' value='1'  <?php if($enable_ipbanned){ ?>checked <?php } ?>> 启用&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enable_ipbanned]' value='0'  <?php if(!$enable_ipbanned){ ?>checked <?php } ?>> 禁用
      </td>
	</tr>
    <tr>
      <th><strong>连续两次刷新最短时间间隔</strong><br/>0 表示不开启，可防CC攻击，建议只在受攻击情况下开启</th>
      <td>
        <input name='setting[minrefreshtime]' type='text' id='minrefreshtime' value='<?=$minrefreshtime?>' size='5' maxlength='5'> 秒
      </td>
	</tr>
    <tr>
    <td class="tablerowhighlight" align="center" colspan=3>非法信息处理设置</th>
    </tr>
    <tr>
      <th><strong>开启</strong></th>
      <td>
	  <input type='radio' name='setconfig[FILTER_ENABLE]' value='1'  <?php if(FILTER_ENABLE == 1){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[FILTER_ENABLE]' value='0'  <?php if(FILTER_ENABLE == 0){ ?>checked <?php } ?>> 否
      </td>
	</tr>
    <tr>
      <th><strong>非法词语列表</strong><br/>
	   请输入需要屏蔽的非法词语，每行一个<br />
	   “*”为通配符</font>
	  </th>
      <td>
	  <textarea name='setting[filter_word]' cols='50' rows='8' id='filter_word'><?=$filter_word?></textarea><img src="admin/skin/images/illegalwords.gif">
	  </td>
    </tr>
  </tbody>

    <tbody id='Tabs4' style='display:none'>
    <tr>
      <th width="35%"><strong>允许前台上传附件</strong></th>
      <td>
	  <input type='radio' name='setconfig[UPLOAD_FRONT]' value='1'  <?php if(UPLOAD_FRONT){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[UPLOAD_FRONT]' value='0'  <?php if(!UPLOAD_FRONT){ ?>checked <?php } ?>> 否
     </td>
    </tr>
	<tr>
      <th><strong>附件URL访问路径</strong></th>
      <td><input name='setconfig[UPLOAD_URL]' type='text' id='UPLOAD_URL' value='<?=UPLOAD_URL?>' size='40' maxlength='50'> 如：uploadfile/</td>
    </tr>
	<tr>
      <th><strong>允许上传的附件类型</strong></th>
      <td><input name='setconfig[UPLOAD_ALLOWEXT]' type='text' id='UPLOAD_ALLOWEXT' value='<?=UPLOAD_ALLOWEXT?>' size='40'></td>
    </tr>
	<tr>
      <th><strong>允许上传的附件大小</strong></th>
      <td><input name='setconfig[UPLOAD_MAXSIZE]' type='text' id='UPLOAD_MAXSIZE' value='<?=UPLOAD_MAXSIZE?>' size='15' maxlength='10'> Bytes</td>
    </tr>
	<tr>
      <th><strong>前台同一IP 24小时内允许上传附件的最大个数</strong></th>
      <td><input name='setconfig[UPLOAD_MAXUPLOADS]' type='text' id='UPLOAD_MAXUPLOADS' value='<?=UPLOAD_MAXUPLOADS?>' size='5' maxlength='5'></td>
    </tr>
	<tr>
      <th><strong>前台是否允许游客上传附件</strong></th>
      <td><input name='setting[allowtourist]' type='radio' value='1' <?php if($allowtourist){ ?>checked <?php } ?>>  是
	  &nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[allowtourist]' value='0'  <?php if($allowtourist == 0){ ?>checked <?php } ?>> 否</td>
    </tr>
    <tr>
      <td colspan="3" class="tablerowhighlight" align="center">图片附件处理</td>
    </tr>
	 <tr>
      <th><strong>PHP图形处理（GD库）功能检测</strong></th>
      <td>
	  <font color="red"><?=$gd?></font>
     </td>
    </tr>
	 <tr>
      <th><strong>启用缩略图功能</strong></th>
      <td>
	  <input type='radio' name='setting[thumb_enable]' value='1'  <?php if($enablegd && $thumb_enable){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[thumb_enable]' value='0'  <?php if(!$enablegd || !$thumb_enable){ ?>checked <?php } ?>> 否
     </td>
    </tr>
    <tr>
      <th><strong>缩略图大小</strong><br />
	  设置缩略图的大小，小于此尺寸的图片附件将不生成缩略图</th>
      <td><input name='setting[thumb_width]' type='text' id='thumb_width' value='<?=$thumb_width?>' size='5' maxlength='5'> X <input name='setting[thumb_height]' type='text' id='thumb_height' value='<?=$thumb_height?>' size='5' maxlength='5'> px</td>
    </tr>
    <tr>
      <th><strong>缩略图算法</strong></th>
      <td>
       宽和高都大于0时，缩小成指定大小，其中一个为0时，按比例缩小<br>
      </td>
    </tr>
    <tr>
      <th><strong>启用图片水印功能</strong></th>
      <td>
	  <input type='radio' name='setting[watermark_enable]' value='1'  <?php if($enablegd && $watermark_enable==1){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[watermark_enable]' value='0'  <?php if($enablegd && $watermark_enable==0){ ?>checked <?php } ?>> 否
     </td>
    </tr>
	<tr>
      <th><strong>水印添加条件</strong></th>
      <td><input name='setting[watermark_minwidth]' type='text' id='watermark_minwidth' value='<?=$watermark_minwidth?>' size='5' maxlength='5'> X <input name='setting[watermark_minheight]' type='text' id='watermark_minheight' value='<?=$watermark_minheight?>' size='5' maxlength='5'> px</td>
    </tr>
	<tr>
      <th><strong>水印图片路径</strong><br />
	  您可替换水印文件以实现不同的水印效果。
	  </th>
      <td>
	  <input name='setting[watermark_img]' type='text' id='watermark_img' value='<?=$watermark_img?>' size='30' maxlength='255'> <a href="###" onClick="javascript:$('#watermark_img').val('images/watermark.gif');">Gif</a> / <a href="###" onClick="javascript:$('#watermark_img').val('images/watermark.png');">Png</a>
	  </td>
    </tr>
	<tr>
      <th><strong>水印透明度</strong><br/>范围为 1~100 的整数，数值越小水印图片越透明</th>
      <td><input name='setting[watermark_pct]' type='text' id='watermark_pct' value='<?=$watermark_pct?>' size='10' maxlength='10'>
	  </td>
    </tr>
	<tr>
      <th><strong>JPEG 水印质量</strong><br/>范围为 0~100 的整数，数值越大结果图片效果越好，但尺寸也越大</th>
      <td><input name='setting[watermark_quality]' type='text' id='watermark_quality' value='<?=$watermark_quality?>' size='10' maxlength='10'>
	  </td>
    </tr>
	    <tr>
      <th><strong>水印添加位置</strong><br>
	  您可以设置自动为用户上传的 JPG/PNG/GIF 图片附件添加水印，请在此选择水印添加的位置(3x3 共 9 个位置可选)。本功能需要 GD 库支持才能使用，暂不支持动画 GIF 格式。附加的水印图片位于 ./images/watermark.gif，您可替换此文件以实现不同的水印效果
	  </th>
      <td>

	  <table cellspacing="1" cellpadding="4" width="160" bgcolor="#dddddd">
	  <tr align="center"  bgcolor="#ffffff"><td><input type="radio" name="setting[watermark_pos]" value="1" <?php if($watermark_pos==1){ ?>checked <?php } ?>> #1</td><td><input type="radio" name="setting[watermark_pos]" value="2" <?php if($watermark_pos==2){ ?>checked <?php } ?>> #2</td><td><input type="radio" name="setting[watermark_pos]" value="3" <?php if($watermark_pos==3){ ?>checked <?php } ?>> #3</td></tr>
	  <tr align="center"  bgcolor="#ffffff"><td><input type="radio" name="setting[watermark_pos]" value="4" <?php if($watermark_pos==4){ ?>checked <?php } ?>> #4</td><td><input type="radio" name="setting[watermark_pos]" value="5" <?php if($watermark_pos==5){ ?>checked <?php } ?>> #5</td><td><input type="radio" name="setting[watermark_pos]" value="6" <?php if($watermark_pos==6){ ?>checked <?php } ?>> #6</td></tr>
	  <tr align="center" bgcolor="#ffffff"><td><input type="radio" name="setting[watermark_pos]" value="7" <?php if($watermark_pos==7){ ?>checked <?php } ?>> #7</td><td><input type="radio" name="setting[watermark_pos]" value="8" <?php if($watermark_pos==8){ ?>checked <?php } ?>> #8</td><td><input type="radio" name="setting[watermark_pos]" value="9" <?php if($watermark_pos==9){ ?>checked <?php } ?>> #9</td></tr>
	  </table>
    </tr>

<tr>
      <th width="35%"><strong>启用附件FTP上传功能</strong><br>开启附件FTP功能后，phpcms将采用ftp方式上传附件<br/>
     <?php if(!function_exists('ftp_connect')){ ?><font color="red">当前PHP环境不支持FTP功能！</font><?php }?>
	  </th>
      <td>
	  <input type='radio' name='setconfig[UPLOAD_FTP_ENABLE]' value='1'  <?php if(UPLOAD_FTP_ENABLE){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[UPLOAD_FTP_ENABLE]' value='0'  <?php if(!UPLOAD_FTP_ENABLE){ ?>checked <?php } ?>> 否&nbsp;&nbsp;&nbsp;&nbsp;
     </td>
    </tr>
    <tr>
      <th><strong>FTP主机</strong></th>
      <td><input name="setconfig[UPLOAD_FTP_HOST]" id="upload_ftp_host" type="text" size="40" value="<?=UPLOAD_FTP_HOST?>"></td>
    </tr>
    <tr>
      <th><strong>FTP端口</strong></th>
      <td><input name="setconfig[UPLOAD_FTP_PORT]" id="upload_ftp_port" type="text" size="40" value="<?=UPLOAD_FTP_PORT?>"></td>
    </tr>
    <tr>
      <th><strong>FTP帐号</strong></th>
      <td><input name="setconfig[UPLOAD_FTP_USER]" id="upload_ftp_user" type="text" size="40" value="<?=UPLOAD_FTP_USER?>"></td>
    </tr>
    <tr>
      <th><strong>FTP密码</strong><br></th>
      <td><input name="setconfig[UPLOAD_FTP_PW]" id="upload_ftp_pw" type="password" size="40" value="<?=UPLOAD_FTP_PW?>" onBlur="upload_ftpdir_list('/')"></td>
    </tr>
    <tr>
      <th><strong>FTP域名</strong><br>上传附件通过此域名访问</th>
      <td><input name="setconfig[UPLOAD_FTP_DOMAIN]" type="text" size="40" value="<?=UPLOAD_FTP_DOMAIN?>">	注意以“/”结尾</td>
    </tr>
    <tr>
      <th><strong>Phpcms目录</strong><br>有很多虚拟主机的FTP根目录与Web根目录不一样<br/>您需要正确设置才能使用FTP功能</th>
      <td><input name="setconfig[UPLOAD_FTP_PATH]" id="upload_ftp_path" type="text" size="20" value="<?=UPLOAD_FTP_PATH?>"> <span id="upload_ftpdir_list"></span>
	  <br/>注意以“/”结尾，例如有的是 /wwwroot/ 或者 /www/<br/>留空则表示ftp根目录与phpcms根目录路径相同</td>
    </tr>
    <tr>
      <th><strong>FTP连接测试</strong><br></th>
      <td><input name="upload_ftp_test" type="button" size="40" value="点击测试 FTP 连接" onClick="javascript:upload_test_ftp();"></td>
    </tr>

  </tbody>

   <tbody id='Tabs5' style='display:none'>
    <tr>
      <th width="35%"><strong>发送方式</strong></th>
      <td>
	  <input type="radio" name="setting[mail_type]" id="mail_type" value="1" <?php if($mail_type==1){ ?>checked <?php } ?> onClick="$('#mail_server').attr('disabled', false);$('#mail_port').attr('disabled', false);$('#mail_user').attr('disabled', false);$('#mail_password').attr('disabled', false);"/> 通过SMTP协议发送(支持ESMTP验证) <br />
	  <input type="radio" name="setting[mail_type]" id="mail_type" value="2" <?php if($mail_type==2){ ?>checked <?php } ?> onClick="$('#mail_server').attr('disabled', true);$('#mail_port').attr('disabled', true);$('#mail_user').attr('disabled', true);$('#mail_password').attr('disabled', true);" <?php if(substr(strtolower(PHP_OS), 0, 3) == 'win') echo 'disabled'; ?>/> 通过mail函数发送(仅*unix类主机支持，请配置php.ini sendmail_path 参数) <br />
      <input type="radio" name="setting[mail_type]" id="mail_type" value="3"  <?php if($mail_type==3){ ?>checked <?php } ?> onClick="$('#mail_server').attr('disabled', false);$('#mail_port').attr('disabled', false);$('#mail_user').attr('disabled', true);$('#mail_password').attr('disabled', true);" <?php if(substr(strtolower(PHP_OS), 0, 3) != 'win') echo 'disabled'; ?>/> 通过SOCKET连接SMTP服务器发送(仅Windows主机支持, 不支持ESMTP验证)<br />
	  </td>
    </tr>
    <tr>
      <th><strong>邮件服务器</strong><br>SMTP服务器，只有正确设置才能使用发邮件功能</th>
      <td><input name="setting[mail_server]" id="mail_server" type="text" size="40" value="<?=$mail_server?>"></td>
    </tr>
    <tr>
      <th><strong>邮件发送端口</strong><br>默认为25，一般不需要改</th>
      <td><input name="setting[mail_port]" id="mail_port" type="text" size="40" value="<?=$mail_port?>"></td>
    </tr>
    <tr>
      <th><strong>邮箱帐号</strong><br>SMTP服务器的用户帐号(完整的电子邮件地址如user@domain.com)，只有正确设置才能使用发邮件功能</th>
      <td><input name="setting[mail_user]" id="mail_user" type="text" size="40" value="<?=$mail_user?>"></td>
    </tr>
    <tr>
      <th><strong>邮箱密码</strong><br></th>
      <td><input name="setting[mail_password]" id="mail_password" type="password" size="40" value="<?=$mail_password?>"></td>
    </tr>
	<tr>
      <th><strong>邮件签名</strong></th>
      <td><textarea name="setting[mail_sign]" id="mail_sign" cols="50" rows="5" ><?=$mail_sign?></textarea><?=form::editor('mail_sign','introduce','100%',150)?>
      </td>
    </tr>
	<tr>
      <th><strong>邮件设置测试</strong><br />
	   请填写接受测试邮件的E-mail地址
	  </th>
      <td><input name="email_to" type="text" id="email_to" value="" size="30">
      <input name="button" type="button" onClick="javascript:test_mail();" value="发送测试邮件"></td>
    </tr>
  </tbody>

    <tbody id='Tabs6' style='display:none'>
	<tr>
      <th width="35%"><strong>启用FTP功能</strong><br>开启FTP功能后，phpcms将采用ftp方式建立目录和修改权限<br/>
     <?php if(!function_exists('ftp_connect')){ ?><font color="red">当前PHP环境不支持FTP功能！</font><?php }?>
	  </th>
      <td>
	  <input type='radio' name='setconfig[FTP_ENABLE]' value='1'  <?php if(FTP_ENABLE){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setconfig[FTP_ENABLE]' value='0'  <?php if(!FTP_ENABLE){ ?>checked <?php } ?>> 否&nbsp;&nbsp;&nbsp;&nbsp;
     </td>
    </tr>
    <tr>
      <th><strong>FTP主机</strong></th>
      <td><input name="setconfig[FTP_HOST]" id="ftp_host" type="text" size="40" value="<?=FTP_HOST?>"></td>
    </tr>
    <tr>
      <th><strong>FTP端口</strong></th>
      <td><input name="setconfig[FTP_PORT]" id="ftp_port" type="text" size="40" value="<?=FTP_PORT?>"></td>
    </tr>
    <tr>
      <th><strong>FTP帐号</strong></th>
      <td><input name="setconfig[FTP_USER]" id="ftp_user" type="text" size="40" value="<?=FTP_USER?>"></td>
    </tr>
    <tr>
      <th><strong>FTP密码</strong><br></th>
      <td><input name="setconfig[FTP_PW]" id="ftp_pw" type="password" size="40" value="<?=FTP_PW?>" onBlur="ftpdir_list('/')"></td>
    </tr>
    <tr>
      <th><strong>Phpcms目录</strong><br>有很多虚拟主机的FTP根目录与Web根目录不一样<br/>您需要正确设置才能使用FTP功能</th>
      <td><input name="setconfig[FTP_PATH]" id="ftp_path" type="text" size="20" value="<?=FTP_PATH?>"> <span id="ftpdir_list"></span>
	  <br/>注意以“/”结尾，例如有的是 /wwwroot/ 或者 /www/<br/>留空则表示ftp根目录与phpcms根目录路径相同</td>
    </tr>
    <tr>
      <th><strong>FTP连接测试</strong><br></th>
      <td><input name="ftp_test" type="button" size="40" value="点击测试 FTP 连接" onClick="javascript:test_ftp();"></td>
    </tr>
  </tbody>

  <tbody id='Tabs7' style='display:none'>
    <tr>
      <td colspan="3" class="tablerowhighlight" align="center">正向通行证设置</td>
    </tr>
    <tr>
      <th width="35%"><strong>是否启用正向通行证</strong><br>以PHPCMS作为整合的服务器端</th>
      <td><input type="radio" name="setting[enablepassport]" value="1" <?php if($enablepassport){?>checked<?php }?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[enablepassport]" value="0" <?php if(!$enablepassport){?>checked<?php }?>>否</td>
    </tr>
	<tr>
      <th><strong>整合程序</strong></th>
      <td>

	  <select name="setting[passport_file]" onChange="set_passport(this.value);">
	  <?php
	  $passports = glob(PHPCMS_ROOT.'member/api/passport_server_*.php');
	  foreach($passports as $passport)
	  {
		  $passport = substr(basename($passport), 16, -4);
		  echo '<option value="'.$passport.'" '.($passport_file == $passport ? 'selected' : '').'>'.$passport.'</option>';
	  }
	  ?>
	  </select>
	  </td>
    </tr>
	<tr>
      <th><strong>整合程序字符集</strong></th>
      <td>
	  <select name="setting[passport_charset]">
	  <option value="gbk" <?=($passport_charset == 'gbk' ? 'selected' : '')?>>GBK/GB2312</option>
	  <option value="utf-8" <?=($passport_charset == 'utf-8' ? 'selected' : '')?>>UTF-8</option>
	  <option value="big5" <?=($passport_charset == 'big5' ? 'selected' : '')?>>BIG5</option>
	  </select>
	  </td>
    </tr>
	<tr>
      <th><strong>通行证接口地址</strong><br>多个接口地址请用逗号“,”分隔</th>
      <td><input name="setting[passport_url]" type="text" size="75" value="<?=$passport_url?>" id="passport_url"></td>
    </tr>
    <tr>
      <th><strong>通行证私有密钥</strong><br>请填写通行证私有密钥</th>
      <td><input name="setting[passport_key]" type="text" size="30" value="<?=$passport_key?>"></td>
    </tr>
    <tr>
      <td colspan="3" class="tablerowhighlight" align="center">反向通行证设置</td>
    </tr>
    <tr>
      <th><strong>是否启用反向通行证</strong><br>以PHPCMS作为整合的客户端</th>
      <td><input type="radio" name="setting[enableserverpassport]" value="1" <?php if($enableserverpassport){?>checked<?php }?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[enableserverpassport]" value="0" <?php if(!$enableserverpassport){?>checked<?php }?>>否&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="blue">整合程序：</font><a href="###" onClick="javascript:fill_passport('phpwind')">Phpwind</a></td>
    </tr>
	<tr>
      <th><strong>通行证接口地址</strong></th>
      <td><input name="setting[passport_serverurl]" id="passport_serverurl" type="text" size="50" value="<?=$passport_serverurl?>"></td>
    </tr>
	<tr>
      <th><strong>通行证会员注册地址</strong></th>
      <td><input name="setting[passport_registerurl]" id="passport_registerurl" type="text" size="50" value="<?=$passport_registerurl?>"></td>
    </tr>
	<tr>
      <th><strong>通行证会员登录地址</strong></th>
      <td><input name="setting[passport_loginurl]" id="passport_loginurl" type="text" size="50" value="<?=$passport_loginurl?>"></td>
    </tr>
	<tr>
      <th><strong>通行证会员退出地址</strong></th>
      <td><input name="setting[passport_logouturl]" id="passport_logouturl" type="text" size="50" value="<?=$passport_logouturl?>"></td>
    </tr>
	<tr>
      <th><strong>通行证会员找回密码地址</strong></th>
      <td><input name="setting[passport_getpasswordurl]" id="passport_getpasswordurl" type="text" size="50" value="<?=$passport_getpasswordurl?>"></td>
    </tr>
    <tr>
      <th><strong>通行证私有密钥</strong></th>
      <td><input name="setting[passport_serverkey]" type="text" size="30" value="<?=$passport_serverkey?>"></td>
    </tr>
    <tr>
      <th><strong>验证字串有效期(秒):</strong><br>设置应用程序发送过来的用户验证字串的有效期，超过此有效期验证字串将失效。建议设置为 3600，既可保证安全又可避免因不同服务器间时间差而产生无法登录的问题</th>
      <td><input name="setting[passport_expire]" type="text" size="30" value="<?=$passport_expire?>"></td>
    </tr>
        <tr>
      <td colspan="3" class="tablerowhighlight" align="center">Ucenter Client 配置</td>
    </tr>
    <tr>
    <th><strong>启用</strong></th>
    <td><input type="radio" name="setting[uc]" id="enableuc" value="1" <?=$uc?'checked':''?>>是&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[uc]" id="enableuc" value="0" <?=$uc?'':'checked'?>> 否</td>
    </tr>
    <tr>
    <th><strong>Ucenter api 地址</strong><br>如 <strong>http://www.domain.com/ucenter</strong> 最后不要带斜线</th>
    <td><input type="text" name="setting[uc_api]" value="<?=$uc_api?>" size="50"></td>
    </tr>
    <tr>
    <th><strong>Ucenter 主机IP地址</strong><br>一般不用填写,遇到无法同步时,请填写ucenter主机的IP地址</th>
    <td><input type="text" name="setting[uc_ip]" value="<?=$uc_ip?>" size="50"></td>
    </tr>
     <tr>
    <th><strong>Ucenter 数据库主机名</strong></th>
    <td><input type="text" name="setting[uc_dbhost]" value="<?=$uc_dbhost?>" id="uc_dbhost" size="50"></td>
    </tr>
	<tr>
    <th><strong>Ucenter 数据库用户名</strong></th>
    <td><input type="text" name="setting[uc_dbuser]" value="<?=$uc_dbuser?>" size="50" id="uc_dbuser"></td>
    </tr>
	<tr>
    <th><strong>Ucenter 数据库密码</strong></th>
    <td><input type="password" name="setting[uc_dbpwd]" value="<?=$uc_dbpwd?>" size="50" id="uc_dbpwd"></td>
    </tr>
     <tr>
    <th><strong>Ucenter 数据库名</strong></th>
    <td><input type="text" name="setting[uc_dbname]" value="<?=$uc_dbname?>" id="uc_dbname" size="50"></td>
    </tr>        
     <tr>
    <th><strong>Ucenter 数据库表前缀</strong></th>
    <td>
    <input type="text" name="setting[uc_dbpre]" id="uc_dbpre" value="<?=$uc_dbpre?>" size="50">
    <input type="button" id="test_uc" value="测试数据库连接" />
    </td>
    </tr>
    <tr>
    	<th><strong>Ucenter 数据库字符集</strong></th>
        <td>
        <select name="setting[uc_charset]" id="uc_charset">
	  		<option value="gbk" <?=($uc_charset == 'gbk' ? 'selected' : '')?>>GBK/GB2312</option>
	  		<option value="utf8" <?=($uc_charset == 'utf8' ? 'selected' : '')?>>UTF-8</option>
	  		<option value="big5" <?=($uc_charset == 'big5' ? 'selected' : '')?>>BIG5</option>
	  	</select>
        </td>
    </tr>
     <tr>
    <th><strong>应用id(APP ID)</strong></th>
    <td><input type="text" name="setting[uc_appid]" value="<?=$uc_appid?>" size="50"></td>
    </tr>
     <tr>
    <th><strong>Ucenter 通信密钥</strong></th>
    <td><input type="text" name="setting[uc_key]" value="<?=$uc_key?>" size="50"></td>
    </tr>
  </tbody>

  <tbody id='Tabs8' style='display:none'>
    <tr>
      <td colspan="3" class="tablerowhighlight" align="center">即时通讯软件</td>
    </tr>
    <tr>
      <th width="35%"><strong>启用</strong></th>
      <td><input type="radio" name="setting[enabletm]" value="1" <?php if($enabletm){?>checked<?php }?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[enabletm]" value="0" <?php if(!$enabletm){?>checked<?php }?>>否&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="red">注意：多个帐号之间请用逗号“,”分隔</font></td>
    </tr>
	<tr>
      <th><strong>QQ</strong></th>
      <td><input name="setting[qq]" type="text" size="75" value="<?=$qq?>">&nbsp;&nbsp;<a href="http://im.qq.com/" target="_blank">免费申请</a></td>
    </tr>
	<tr>
      <th><strong>MSN</strong></th>
      <td><input name="setting[msn]" type="text" size="75" value="<?=$msn?>">&nbsp;&nbsp;<a href="http://messenger.live.cn/" target="_blank">免费申请</a></td>
    </tr>
	<tr>
      <th><strong>SKYPE</strong></th>
      <td><input name="setting[skype]" type="text" size="75" value="<?=$skype?>">&nbsp;&nbsp;<a href="http://www.skype.com/" target="_blank">免费申请</a></td>
    </tr>
	<tr>
      <th><strong>阿里旺旺（淘宝版）</strong></th>
      <td><input name="setting[taobao]" type="text" size="75" value="<?=$taobao?>">&nbsp;&nbsp;<a href="http://www.taobao.com/wangwang/" target="_blank">免费申请</a></td>
    </tr>
	<tr>
      <th><strong>阿里旺旺（贸易通版）</strong></th>
      <td><input name="setting[alibaba]" type="text" size="75" value="<?=$alibaba?>">&nbsp;&nbsp;<a href="http://alitalk.alibaba.com.cn/" target="_blank">免费申请</a></td>
    </tr>
  </tbody>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width="35%"><input name='setting[version]' type='hidden' id='version' value='<?=PHPCMS_VERSION?>'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
<input type="hidden" name="setting[wss_enable]" value="<?=$wss_enable?>">
<input type="hidden" name="setting[wss_site_id]" value="<?=$wss_site_id?>">
<input type="hidden" name="setting[wss_password]" value="<?=$wss_password?>">
</form>
</body>
</html>
<script type="text/javascript">
function ftpdir_list(path)
{
    $.post('?file=setting&action=ftpdir_list&path='+path+'&ftp_host='+$('#ftp_host').val()+'&ftp_port='+$('#ftp_port').val()+'&ftp_pw='+$('#ftp_pw').val(), {ftp_user:$('#ftp_user').val()}, function(data){
		if(data != 0) $('#ftpdir_list').append(data);
	});
}

function upload_ftpdir_list(path)
{
    $.post('?file=setting&action=ftpdir_list&path='+path+'&ftp_host='+$('#upload_ftp_host').val()+'&ftp_port='+$('#upload_ftp_port').val()+'&ftp_pw='+$('#upload_ftp_pw').val(), {ftp_user:$('#upload_ftp_user').val()}, function(data){
		if(data != 0) $('#upload_ftpdir_list').append(data);
	});
}

function test_user()
{
	if($('#phpcms_username').val() == '')
	{
		alert('请填写帐号');
		$('#phpcms_username').focus();
		return false;
	}
	if($('#phpcms_password').val() == '')
	{
		alert('请填写密码');
		$('#phpcms_password').focus();
		return false;
	}
    $.post('?file=setting&action=test_user', {phpcms_username:$('#phpcms_username').val(), phpcms_password:$('#phpcms_password').val()}, function(data){
		if(data == 0) alert('通信失败');
		else if(data == 1) alert('帐号密码不匹配');
		else if(data == 2) alert('验证成功');
	});
}

function test_mail()
{
    $.get('?mod=phpcms&file=setting&action=test_mail&mail_type='+$('#mail_type').val()+'&mail_server='+$('#mail_server').val()+'&mail_port='+$('#mail_port').val()+'&mail_user='+$('#mail_user').val()+'&mail_password='+$('#mail_password').val()+'&email_to='+$('#email_to').val(), function(data){
		alert(data);
	});
}

function test_ftp()
{
    $.post('?mod=phpcms&file=setting&action=test_ftp', {ftp_host:$('#ftp_host').val(), ftp_port: $('#ftp_port').val(), ftp_pw:$('#ftp_pw').val(), ftp_user:$('#ftp_user').val(), ftp_path: $('#ftp_path').val()}, function(data){
		alert(data);
	});
}

function upload_test_ftp()
{
    $.post('?mod=phpcms&file=setting&action=test_ftp', {ftp_host:$('#upload_ftp_host').val(), ftp_port: $('#upload_ftp_port').val(), ftp_pw:$('#upload_ftp_pw').val(), ftp_user:$('#upload_ftp_user').val(), ftp_path: $('#upload_ftp_path').val()}, function(data){
		alert(data);
	});
}

var passports={
	phpwind : {serverurl:'http://www.***.com/bbs/', registerurl:'register.php', loginurl : 'login.php', logouturl : 'login.php?action=quit', getpasswordurl : 'sendpwd.php'},
	lxblog :      {serverurl:'http://www.***.com/blog/', registerurl:'register.php', loginurl : 'login.php',logouturl : 'login.php?action=quit', getpasswordurl : 'sendpwd.php'},
	lxshop :     {serverurl:'http://www.***.com/shop/', registerurl:'register.php', loginurl : 'login.php',logouturl : 'login.php?action=quit', getpasswordurl : 'sendpwd.php'},
	shopex :    {serverurl:'http://www.***.com/shop/', registerurl:'index.php?gOo=register.dwt', loginurl : 'index.php?gOo=login.dwt',logouturl : 'index.php?gOo=logout_act.do', getpasswordurl : 'index.php?gOo=forget.dwt'}
};

function set_passport(str)
{
  if(str == 'discuz') $('#passport_url').val('http://www.***.com/bbs/api/passport.php');
  else if(str == 'phpwind') $('#passport_url').val('http://www.***.com/bbs/');
}

function fill_passport(str) {
  if(typeof(passports[str])!='object') return ;
  $('#passport_serverurl').val(passports[str]['serverurl']);
  $('#passport_registerurl').val(passports[str]['registerurl']);
  $('#passport_loginurl').val(passports[str]['loginurl']);
  $('#passport_logouturl').val(passports[str]['logouturl']);
  $('#passport_getpasswordurl').val(passports[str]['getpasswordurl']);
  return ;
}

$('input[name="setting[uc]"]').click(function(){
	$('input[name^="setting[uc_"]').attr({readonly:(this.value=='0'?'true':'')});
});

$('input[name="setting[uc]"][value="<?=intval($uc)?>"]').click();

$('#test_uc').click(function () {
	$(this).val("正在检测,请稍候 ...").attr({disabled:'true'});
	var uc='';
	uc='&uc_dbhost='+$('#uc_dbhost').val();
	uc+='&uc_dbuser=' + $('#uc_dbuser').val();
	uc+='&uc_dbpwd=' + $('#uc_dbpwd').val();
	uc+='&uc_dbname='+$('#uc_dbname').val();
	uc+='&uc_dbpre=' +  $('#uc_dbpre').val();
	
	$.ajax({
	 url : '?mod=phpcms&file=setting&action=test_uc'+uc,
	 cache : false,
	 timeout: 2000,
	 type : 'GET',
	 async : false,
	 dataType : 'html',
	 processData : false,
	 success :function(datas){
		 $('#test_uc').attr({disabled:''}).val("测试数据库连接");
		if(datas=='success') {
			alert("数据库连接正常");
			return ;
		}
		 alert("设置有误  \n"+datas);
	 }
	});
});

$(function(){
    ShowTabs(<?=$tab?>);
<?php if($mail_type==2){ ?>
	$('#mail_server').attr('disabled', true);
    $('#mail_port').attr('disabled', true);
    $('#mail_user').attr('disabled', true);
    $('#mail_password').attr('disabled', true);
<?php }elseif($mail_type==3){ ?>
    $('#mail_user').attr('disabled', true);
    $('#mail_password').attr('disabled', true);
<?php } ?>
});

$('#Tabs2').find('input').css({'ime-mode':'disabled'});
$('#sys_setting').checkForm(1);
</script>
