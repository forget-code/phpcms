<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本配置</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>RSS配置</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">

  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
      <tr>
      <td width='40%' class='tablerow'><strong>是否生成html</strong>
	  </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[ishtml]' value='1'  <?php if($ishtml){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[ishtml]' value='0'  <?php if(!$ishtml){ ?>checked <?php } ?>> 否
     </td>
    </tr>
    <tr>
      <td class='tablerow'><strong>栏目列表分页url规则(生成html)</strong></td>
      <td class='tablerow'>
	  <?=$cat_html_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>商品内容分页url规则(生成html)</strong></td>
      <td class='tablerow'>
	  <?=$item_html_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>栏目列表分页url规则(不生成html)</strong></td>
      <td class='tablerow'>
	  <?=$cat_php_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>商品内容分页url规则(不生成html)</strong></td>
      <td class='tablerow'>
	  <?=$item_php_urlrule?>
	 </td>
    </tr>
	<tr>
      <td class='tablerow'><strong>把以上设置应用到子栏目和商品</strong></td>
      <td class='tablerow'><input type="radio" name="createtype_application" value="1" /> 是 <input type="radio" name="createtype_application" value="0" checked /> 否</td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>Meta Title（商城标题）</strong><br>针对搜索引擎设置的标题</td>
      <td class='tablerow'><textarea name='setting[seo_title]' cols='60' rows='2' id='seo_title'><?=$seo_title?></textarea></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>Meta Keywords（网页关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='setting[seo_keywords]' cols='60' rows='2' id='seo_keywords'><?=$seo_keywords?></textarea></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>Meta Description（网页描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='setting[seo_description]' cols='60' rows='2' id='seo_description'><?=$seo_description?></textarea></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>模块绑定域名</strong><br>最后不带反斜线'/'</td></td>
      <td class='tablerow'><input name='setting[moduledomain]' type='text' id='moduledomain' value='<?=$moduledomain?>' size='40' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>选择模版</strong><br></td>
      <td class='tablerow'><?=$showtpl?>
	</td>
    </tr>
    <tr>
      <td width='25%' class='tablerow'><strong>选择风格</strong></td>
      <td class='tablerow'>
<?=$showskin?>
	  </td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>商品附件目录</strong></td>
      <td class='tablerow'><input name='setting[uploaddir]' type='text' id='uploaddir' value='<?=$uploaddir?>' size='40' maxlength='50'></td>
    </tr>
    	<tr>
      <td width='40%' class='tablerow'><strong>是否允许上传文件</strong></td>
      <td class='tablerow'>
      <input type='radio' name='setting[enableupload]' value='1'  <?php if($enableupload){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[enableupload]' value='0'  <?php if(!$enableupload){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
	<tr>
      <td width='40%' class='tablerow'><strong>允许上传的附件类型</strong><br/>在允许上传文件的前提下生效</td>
      <td class='tablerow'><input name='setting[uploadfiletype]' type='text' id='uploadfiletype' value='<?=$uploadfiletype?>' size='40' maxlength='50'></td>
    </tr>
    
    <tr>
      <td width='40%' class='tablerow'><strong>商品缩略图宽度</strong></td>
      <td class='tablerow'><input name='setting[thumbwidth]' type='text' id='thumbwidth' value='<?=$thumbwidth?>' size='20' maxlength='50'></td>
    </tr>
    
    <tr>
      <td width='40%' class='tablerow'><strong>商品缩略图高度</strong></td>
      <td class='tablerow'><input name='setting[thumbheight]' type='text' id='thumbheight' value='<?=$thumbheight?>' size='20' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>信息列表最大页数</strong><br></td>
      <td class='tablerow'><input name='setting[maxpage]' type='text' id='maxpage' value='<?=$maxpage?>' size='20' maxlength='255'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>信息列表每页默认信息条数</strong><br></td>
      <td class='tablerow'><input name='setting[pagesize]' type='text' id='pagesize' value='<?=$pagesize?>' size='20' maxlength='255'></td>
    </tr>
     <tr>
      <td width='40%' class='tablerow'><strong>订单打印模板</strong></td></td>
      <td class='tablerow'><input type="button" value="点击修改打印模板" onclick="location='?mod=phpcms&file=filemanager&action=edit&fname=./<?=$mod?>/admin/templates/order_print.tpl.php&dir=./<?=$mod?>/admin/templates/'"></td>
    </tr>
     <tr>
      <td width='40%' class='tablerow'><strong>订单完成了是否自动发送邮件给用户</strong></td></td>
      <td class='tablerow'><input type='radio' name='setting[issendemail]' value='1'  <?php if($issendemail){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[issendemail]' value='0'  <?php if(!$issendemail){ ?>checked <?php } ?>> 否
	  </td>
    </tr>
     <tr>
      <td width='40%' class='tablerow'><strong>订单email邮件模板</strong></td></td>
      <td class='tablerow'><input type="button" value="点击修改邮件模板" onclick="location='?mod=phpcms&file=template&action=edit&template=ordermailtpl&module=<?=$mod?>&project=default'"></td>
    </tr>
      <tr>
      <td width='40%' class='tablerow'><strong>显示多少条用户浏览过的商品数</strong></br>最大值：100</td></td>
      <td class='tablerow'><input name='setting[visitednum]' type='text' id='visitednum' value='<?=$visitednum?>' size='20' maxlength='255'></td>
    </tr>
          <tr>
      <td width='40%' class='tablerow'><strong>搜索结果页面是否显示搜索框</strong>
	  </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[showsearchtable]' value='1'  <?php if($showsearchtable){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[showsearchtable]' value='0'  <?php if(!$showsearchtable){ ?>checked <?php } ?>> 否
     </td>
    </tr>
          <tr>
      <td width='40%' class='tablerow'><strong>搜索结果页面是否显示商品简介</strong>
	  </td>
      <td class='tablerow'>
	  <input type='radio' name='setting[showsearchintroduce]' value='1'  <?php if($showsearchintroduce){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[showsearchintroduce]' value='0'  <?php if(!$showsearchintroduce){ ?>checked <?php } ?>> 否
     </td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>搜索结果页面商品简介长度</strong></td>
      <td class='tablerow'><input name='setting[searchintroducenum]' type='text' id='visitednum' value='<?=$searchintroducenum?>' size='10' maxlength='255'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>是否显示商品对比栏</strong><br />栏目列表生成静态的请重新生成</td>
      <td class='tablerow'>
	  <input type='radio' name='setting[showcompare]' value='1'  <?php if($showcompare){ ?>checked <?php } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type='radio' name='setting[showcompare]' value='0'  <?php if(!$showcompare){ ?>checked <?php } ?>> 否
      </td>
    </tr>
  </tbody>
  
  <tbody id='Tabs1' style='display:none;'>
  <th colspan=2>RSS配置</th>
  <tr>
      <td class="tablerow"><strong>是否启用</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[enable_rss]" value="1"  <?php if($enable_rss){ ?>checked <?php } ?>> 是
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[enable_rss]" value="0"  <?php if(!$enable_rss){ ?>checked <?php } ?>> 否
	 </td>
   </tr>
	<tr>
      <td class="tablerow"><strong>输出</strong></td>
      <td class="tablerow">
	  <input type="radio" name="setting[rss_mode]" value="1"  <?php if($rss_mode){ ?>checked <?php } ?>> 全文
	  &nbsp;&nbsp;
	  <input type="radio" name="setting[rss_mode]" value="0"  <?php if(!$rss_mode){ ?>checked <?php } ?>> 摘要
	 </td>
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
	  <input type="text" name="setting[rss_length]" value="<?=$rss_length?>" size="5"> 留空表示不截取
	 </td>
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