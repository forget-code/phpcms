<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
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
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
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
    <th colspan=2>复制<?=$functions[$function]?>标签 {tag_<?=$tagname?>} </th>
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
      <td class="tablerow" width="40%"><b>新标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input type="text" name="tagname" size="20"/>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>标签说明</b><br/>例如：首页最新推荐商品，10篇</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="60" value="<?=$tag_config['introduce']?>" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan="2" align="center"><b>标签参数设置</b></td>
    </tr>
	<tr> 
	<td class="tablerow"><b>调用商品所属栏目ID</b><br><font color="blue">多个ID之前用半角逗号隔开，0表示不限栏目</font><br>某些情况下可使用变量<a href="###" onclick="$('catid').value='$catid'"><font color="red">$catid</font></a>作为参数</td>
	<td  class="tablerow">
	<input name="tag_config[catid]" type="text" size="15"  id="catid" value="<?=$tag_config['catid']?>">&nbsp;
	<select name='selectcatid' onchange="ChangeInput(this,document.myform.catid)">
	<option value="0">不限栏目</option>z
	<option value='$catid'>$catid</option>
	<?=$category_select?> &nbsp;选择时栏目ID会自动加入到表单中
	</td>
	</tr>
	
<tr> 
 <td class="tablerow"><b>调用商品所属品牌ID</b><br><font color="blue">多个ID之前用半角逗号隔开，0或空表示不限栏目</font></td>
 <td  class="tablerow">
<input name="tag_config[brand_id]" type="text" size="15"  id="brand_id" value="<?=$tag_config['brand_id']?>">&nbsp;
<?=$brand_select?> &nbsp;选择时品牌ID会自动加入到表单中
</td>
</tr>
 <tr> 
 <td class="tablerow"><b>调用商品所属附属分类</b><br></td>
 <td  class="tablerow">
<input name="tag_config[typeid]" type="text" size="15"  id="typeid" value="<?=$tag_config['typeid']?>">&nbsp;

<?=$type_select?> &nbsp;选择时附属分类ID会自动加入到表单中
</td>
</tr>
    <tr>
      <td class="tablerow"><b>是否调用子栏目商品</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[child]" value="1" <?php if($tag_config['child']){ ?>checked<?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[child]" value="0" <?php if(!$tag_config['child']){ ?>checked<?php } ?>>否 仅当栏目ID为单个时有效</td>
    </tr>


    <tr> 
      <td class="tablerow" width="40%"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="$page" <? if($tag_config['page']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" <? if(!$tag_config['page']) { ?>checked<? } ?>>否 仅当栏目ID为单个时有效</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每页商品数</b></td>
      <td  class="tablerow"><input name="tag_config[productnum]" type="text" size="10" value="<?=$tag_config['productnum']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>商品标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[titlelen]" type="text" size="10" value="<?=$tag_config['titlelen']?>"> 一个汉字为2个字符</td>
    </tr>
    <tr>
      <td class="tablerow" width="40%"><b>内容摘要最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[descriptionlen]" type="text" size="10" value="<?=$tag_config['descriptionlen']?>"> 如果设置为0则表示不显示内容摘要</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>推荐位置</b></td>
      <td  class="tablerow"><input name="tag_config[posid]" type="text" size="5" value="<?=$tag_config['posid']?>" id="posid"> <?=pos_select($mod, "tag_config[posid]", "请选择", 0,  'onchange="ChangeInput(this,document.myform.posid)"')?></td>
    </tr>

    <tr> 
      <td class="tablerow" width="40%"><b>多少天以内的商品</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="5" value="<?=$tag_config['datenum']?>" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name='selectdatenum' onclick="javascript:myform.datenum.value=this.value">
<option value='0' <? if($tag_config['datenum']==0) { ?>selected<? } ?>>不限天数</option>
<option value='3' <? if($tag_config['datenum']==3) { ?>selected<? } ?>>3天以内</option>
<option value='7' <? if($tag_config['datenum']==7) { ?>selected<? } ?>>一周以内</option>
<option value='14' <? if($tag_config['datenum']==14) { ?>selected<? } ?>>两周以内</option>
<option value='30' <? if($tag_config['datenum']==30) { ?>selected<? } ?>>一个月内</option>
<option value='60' <? if($tag_config['datenum']==60) { ?>selected<? } ?>>两个月内</option>
<option value='90' <? if($tag_config['datenum']==90) { ?>selected<? } ?>>三个月内</option>
<option value='180' <? if($tag_config['datenum']==180) { ?>selected<? } ?>>半年以内</option>
<option value='365' <? if($tag_config['datenum']==365) { ?>selected<? } ?>>一年以内</option>
</select>
您可以从下拉框中选择
</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>商品排序方式</b></td>
      <td  class="tablerow">
<select name='tag_config[ordertype]'>
<option value='0' <? if($tag_config['ordertype']==0) { ?>selected<? } ?>>按商品排序排序</option>
<option value='1' <? if($tag_config['ordertype']==1) { ?>selected<? } ?>>按更新时间降序</option>
<option value='2' <? if($tag_config['ordertype']==2) { ?>selected<? } ?>>按更新时间升序</option>
<option value='3' <? if($tag_config['ordertype']==3) { ?>selected<? } ?>>按浏览次数降序</option>
<option value='4' <? if($tag_config['ordertype']==4) { ?>selected<? } ?>>按浏览次数升序</option>
<option value="5" <? if($tag_config['ordertype']==5) { ?>selected<? } ?>>按评论次数降序</option>
<option value="6" <? if($tag_config['ordertype']==6) { ?>selected<? } ?>>按评论次数升序</option>
<option value="7" <? if($tag_config['ordertype']==7) { ?>selected<? } ?>>按卖出次数降序</option>
<option value="8" <? if($tag_config['ordertype']==8) { ?>selected<? } ?>>按卖出次数升序</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>时间显示格式</b></td>
      <td  class="tablerow">
<select name='tag_config[datetype]'>
<option value="0" <? if($tag_config['datetype']==0) { ?>selected<? } ?>>不显示时间</option>
<option value="1" <? if($tag_config['datetype']==1) { ?>selected<? } ?>>格式：<?=date('Y-m-d',$PHP_TIME)?></option>
<option value="2" <? if($tag_config['datetype']==2) { ?>selected<? } ?>>格式：<?=date('m-d',$PHP_TIME)?></option>
<option value="3" <? if($tag_config['datetype']==3) { ?>selected<? } ?>>格式：<?=date('Y/m/d',$PHP_TIME)?></option>
<option value="4" <? if($tag_config['datetype']==4) { ?>selected<? } ?>>格式：<?=date('Y.m.d',$PHP_TIME)?></option>
<option value="5" <? if($tag_config['datetype']==5) { ?>selected<? } ?>>格式：<?=date("Y-m-d H:i:s",$PHP_TIME)?></option>
<option value="6" <? if($tag_config['datetype']==6) { ?>selected<? } ?>>格式：<?=date("Y-m-d H:i",$PHP_TIME)?></option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否在商品标题前显示栏目名称</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showcatname]" value="1" <? if($tag_config['showcatname']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showcatname]" value="0" <? if(!$tag_config['showcatname']) { ?>checked<? } ?>>否</td>
    </tr>
     <tr> 
      <td class="tablerow"><b>是否在显示品牌名称</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showbrand]" value="1"  <? if($tag_config['showbrand']) { ?>checked<? } ?> >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showbrand]" value="0" <? if(!$tag_config['showbrand']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否在标题后面显示浏览次数</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showhits]" value="1" <? if($tag_config['showhits']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showhits]" value="0" <? if(!$tag_config['showhits']) { ?>checked<? } ?>>否</td>
    </tr>
     <tr> 
      <td class="tablerow"><b>是否显示本店价格信息</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showprice]" value="1" <? if($tag_config['showprice']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showprice]" value="0" <? if(!$tag_config['showprice']) { ?>checked<? } ?>>否</td>
    </tr>
     <tr> 
      <td class="tablerow"><b>是否显示市场价格信息</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showmarketprice]" value="1" <? if($tag_config['showmarketprice']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showmarketprice]" value="0" <? if(!$tag_config['showmarketprice']) { ?>checked<? } ?>>否</td>
    </tr>
     <tr> 
      <td class="tablerow"><b>是否在展示列表时显示放入购物车连接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showcartlink]" value="1" <? if($tag_config['showcartlink']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showcartlink]" value="0" <? if(!$tag_config['showcartlink']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在展示列表时显示查看商品连接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showviewlink]" value="1" <? if($tag_config['showviewlink']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showviewlink]" value="0"  <? if(!$tag_config['showviewlink']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1" <? if($tag_config['target']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[target]" value="0" <? if(!$tag_config['target']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每行显示链接列数</b></td>
      <td  class="tablerow">
<select name='tag_config[cols]'>
<option value='1' <? if($tag_config['cols']==1) { ?>selected<? } ?>>1列</option>
<option value='2' <? if($tag_config['cols']==2) { ?>selected<? } ?>>2列</option>
<option value='3' <? if($tag_config['cols']==3) { ?>selected<? } ?>>3列</option>
<option value='4' <? if($tag_config['cols']==4) { ?>selected<? } ?>>4列</option>
<option value='5' <? if($tag_config['cols']==5) { ?>selected<? } ?>>5列</option>
<option value='6' <? if($tag_config['cols']==6) { ?>selected<? } ?>>6列</option>
<option value='7' <? if($tag_config['cols']==7) { ?>selected<? } ?>>7列</option>
<option value='8' <? if($tag_config['cols']==8) { ?>selected<? } ?>>8列</option>
<option value='9' <? if($tag_config['cols']==9) { ?>selected<? } ?>>9列</option>
<option value='10' <? if($tag_config['cols']==10) { ?>selected<? } ?>>10列</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
	<?=showtpl($mod,'tag_product_list','tag_config[templateid]',$tag_config['templateid'],' id="templateid" ')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=product&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>列出该商品价格范围内的商品 </strong><br>0表示不限</td>
      <td class="tablerow">从 
        <input name="tag_config[fromprice]" type="text" size="8" id="fromprice"  value="<?=$tag_config['fromprice']?>" /> 
        到 
        <input name="tag_config[toprice]" type="text" size="8" id="toprice"  value="<?=$tag_config['toprice']?>" /></td>
    </tr>
    <tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="dosubmit" value=" 保存 "   onclick="$('action').value='copy';">   &nbsp;
         <input type="submit" name="dopreview" value=" 预览 " onclick="$('action').value='preview';">  &nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>