<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<body>
<script type="text/javascript">
function doCheck(){
	if($F('tagname')==''){
		alert('标签名称不能为空');
		$('tagname').focus();
		return false;
	}
	return true;
}
</script>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>">管理标签</a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>添加<?=$functions[$function]?>标签</th>
  </tr>
  <form name="myform" method="get" action="?" onsubmit="return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>" id="action">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input name="tagname" id="tagname" type="text" size="20" value="<?=$tagname?>"> <input type="button" value=" 检查是否已经存在 " onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checkname&channelid=<?=$channelid?>&tagname='+$('tagname').value+'','','300','40','no')"> <br/>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>标签说明</b><br/>例如：首页最新推荐商品，10篇</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="50" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
        <tr> 
      <td class="tablerow"><b>调用商品所属栏目ID</b><br><font color="blue">多个ID之前用半角逗号隔开，0或空表示不限栏目</font><br>某些情况下可使用变量<a href="#" onclick="$('catid').value='$catid'"><font color="red">$catid</font></a>作为参数</td>
      <td  class="tablerow">
<input name="tag_config[catid]" type="text" size="15"  id="catid" value="0">&nbsp;
<select name='selectcatid' onchange="ChangeInput(this,document.myform.catid)">
<option value="0">不限栏目</option>
<option value='$catid'>$catid</option>
<?=$category_select?> &nbsp;选择时栏目ID会自动加入到表单中
</td>
</tr>

 <tr> 
 <td class="tablerow"><b>调用商品所属品牌ID</b><br><font color="blue">多个ID之前用半角逗号隔开，0或空表示不限栏目</font></td>
 <td  class="tablerow">
<input name="tag_config[brand_id]" type="text" size="15"  id="brand_id" value="0">&nbsp;

<?=$brand_select?> &nbsp;选择时品牌ID会自动加入到表单中
</td>
</tr>

 <tr> 
 <td class="tablerow"><b>调用商品所属附属分类</b><br></td>
 <td  class="tablerow">
<input name="tag_config[typeid]" type="text" size="15"  id="typeid" value="0">&nbsp;

<?=$type_select?> &nbsp;选择时附属分类ID会自动加入到表单中
</td>
</tr>

    <tr> 
      <td class="tablerow"><b>是否调用子栏目商品</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[child]" value="1" checked>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[child]" value="0">否 仅当栏目ID为单个时有效</td>
    </tr>
	
	<tr> 
      <td class="tablerow"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="1" >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" checked>否 仅当栏目ID为单个时有效</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>调用商品数或每页商品数</b></td>
      <td  class="tablerow"><input name="tag_config[productnum]" type="text" size="10" value="10"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>商品标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[titlelen]" type="text" size="10" value="30"> 一个汉字为2个字符</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>内容摘要最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[descriptionlen]" type="text" size="10" value="0"> 如果设置为0则表示不显示内容摘要</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>推荐位置</b></td>
      <td  class="tablerow"><input name="tag_config[posid]" type="text" size="10" value="0" id="posid"> <?=pos_select($mod, "tag_config[posid]", "请选择", 0,  'onchange="ChangeInput(this,document.myform.posid)"')?></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>多少天以内的商品</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="5" value="0" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name="selectdatenum" onchange="$('datenum').value=this.value">
<option value="0">不限天数</option>
<option value="3">3天以内</option>
<option value="7">一周以内</option>
<option value="14">两周以内</option>
<option value="30">一个月内</option>
<option value="60">两个月内</option>
<option value="90">三个月内</option>
<option value="180">半年以内</option>
<option value="365">一年以内</option>
</select>
您可以从下拉框中选择
</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>商品排序方式</b></td>
      <td  class="tablerow">
<select name="tag_config[ordertype]">
<option value="0">按商品排序排序</option>
<option value="1">按更新时间降序</option>
<option value="2">按更新时间升序</option>
<option value="3">按浏览次数降序</option>
<option value="4">按浏览次数升序</option>
<option value="5">按评论次数降序</option>
<option value="6">按评论次数升序</option>
<option value="7">按卖出次数降序</option>
<option value="8">按卖出次数升序</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>时间显示格式</b></td>
      <td  class="tablerow">
	  <select name="tag_config[datetype]">
	<option value="0">不显示时间</option>
	<option value="1">格式：<?=date("Y-m-d",$PHP_TIME)?></option>
	<option value="2">格式：<?=date("m-d",$PHP_TIME)?></option>
	<option value="3">格式：<?=date("Y/m/d",$PHP_TIME)?></option>
	<option value="4">格式：<?=date("Y.m.d",$PHP_TIME)?></option>
	<option value="5">格式：<?=date("Y-m-d H:i:s",$PHP_TIME)?></option>
	<option value="6">格式：<?=date("Y-m-d H:i",$PHP_TIME)?></option>
	</select>
      </td>
    </tr>
     <tr> 
      <td class="tablerow"><b>是否在商品标题前显示栏目名称</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showcatname]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showcatname]" value="0" checked>否</td>
    </tr>
   <tr> 
      <td class="tablerow"><b>是否在显示品牌名称</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showbrand]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showbrand]" value="0" checked>否</td>
    </tr>
    <tr>
      <td class="tablerow"><b>是否在标题后面显示浏览次数</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showhits]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showhits]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否显示本店价格信息</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showprice]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showprice]" value="0" checked>否</td>
    </tr>
     <tr> 
      <td class="tablerow"><b>是否显示市场价格信息</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showmarketprice]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showmarketprice]" value="0" checked>否</td>
    </tr>
        <tr> 
      <td class="tablerow"><b>是否在展示列表时显示放入购物车连接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showcartlink]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showcartlink]" value="0"  checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在展示列表时显示查看商品连接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showviewlink]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showviewlink]" value="0"  checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[target]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>每行显示链接列数</b></td>
      <td  class="tablerow"><input name="tag_config[cols]" type="text" size="5" id="cols" value="2">&nbsp;<select name="selectcols" onchange="$('cols').value=this.value">
<option value="1">1列</option>
<option value="2">2列</option>
<option value="3">3列</option>
<option value="4">4列</option>
<option value="5">5列</option>
<option value="6">6列</option>
<option value="7">7列</option>
<option value="8">8列</option>
<option value="9">9列</option>
<option value="10">10列</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
	<?=showtpl($mod,'tag_product_list','tag_config[templateid]',0,' id="templateid" ')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=<?=$mod?>&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>列出该商品价格范围内的商品 </strong><br>0表示不限</td>
      <td class="tablerow">从 
        <input name="tag_config[fromprice]" type="text" size="8" id="fromprice"  value="0"> 
        到 
        <input name="tag_config[toprice]" type="text" size="8" id="toprice" value="0"></td>
    </tr>
    <tr>
      <td class="tablerow"></td>
      <td class="tablerow"><input type="submit" name="dosubmit" value=" 保存 "  onclick="$('action').value='add';">
&nbsp;
<input name="submit" type="submit" onclick="$('action').value='preview';" value=" 预览 ">
&nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>