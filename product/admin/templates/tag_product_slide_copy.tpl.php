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
	<option value="0">不限栏目</option>
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
      <td class="tablerow" width="40%"><b>每页商品数</b></td>
      <td  class="tablerow"><input name="tag_config[productnum]" type="text" size="10" value="<?=$tag_config['productnum']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>商品标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[titlelen]" type="text" size="10" value="<?=$tag_config['titlelen']?>"> 一个汉字为2个字符</td>
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
      <td class="tablerow"><b>是否显示商品标题</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showtitle]" value="1" <? if($tag_config['showtitle']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showtitle]" value="0" <? if(!$tag_config['showtitle']) { ?>checked<? } ?>>否</td>
    </tr>    
    <tr> 
      <td class="tablerow"><b>是否显示作者、更新时间、点击数等提示信息</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showalt]" value="1" <? if($tag_config['showalt']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showalt]" value="0" <? if(!$tag_config['showalt']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>图片宽度</b></td>
      <td  class="tablerow"><input type="input" name="tag_config[imgwidth]" value="<?=$tag_config['imgwidth']?>" size="5"> px </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>图片高度</b></td>
      <td  class="tablerow"><input type="input" name="tag_config[imgheight]" value="<?=$tag_config['imgheight']?>" size="5"> px </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>图片播放间隔时间</b></td>
      <td  class="tablerow"><input type="input" name="tag_config[timeout]" value="<?=$tag_config['timeout']?>" size="5"> 秒 </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>图片播放过渡效果</b></td>
      <td  class="tablerow">
<select name='tag_config[effectid]'>
<option value='-1' <?php if($tag_config['effectid']==-1) { ?>selected<?php } ?>>随机综合效果</option>
<option value='0' <?php if($tag_config['effectid']==0) { ?>selected<?php } ?>>矩形缩小</option>
<option value='1' <?php if($tag_config['effectid']==1) { ?>selected<?php } ?>>矩形扩大</option>
<option value='2' <?php if($tag_config['effectid']==2) { ?>selected<?php } ?>>圆形缩小</option>
<option value='3' <?php if($tag_config['effectid']==3) { ?>selected<?php } ?>>圆形扩大</option>
<option value='4' <?php if($tag_config['effectid']==4) { ?>selected<?php } ?>>向上擦除</option>
<option value='5' <?php if($tag_config['effectid']==5) { ?>selected<?php } ?>>向下擦除</option>
<option value='6' <?php if($tag_config['effectid']==6) { ?>selected<?php } ?>>向右擦除</option>
<option value='7' <?php if($tag_config['effectid']==7) { ?>selected<?php } ?>>向左擦除</option>
<option value='8' <?php if($tag_config['effectid']==8) { ?>selected<?php } ?>>垂直百页</option>
<option value='9' <?php if($tag_config['effectid']==9) { ?>selected<?php } ?>>水平百页</option>
<option value='10' <?php if($tag_config['effectid']==10) { ?>selected<?php } ?>>棋盘状通过</option>
<option value='11' <?php if($tag_config['effectid']==11) { ?>selected<?php } ?>>棋盘状向下</option>
<option value='12' <?php if($tag_config['effectid']==12) { ?>selected<?php } ?>>随机融化</option>
<option value='13' <?php if($tag_config['effectid']==13) { ?>selected<?php } ?>>垂直向内分开</option>
<option value='14' <?php if($tag_config['effectid']==14) { ?>selected<?php } ?>>垂直向外分开</option>
<option value='15' <?php if($tag_config['effectid']==15) { ?>selected<?php } ?>>水平向内分开</option>
<option value='16' <?php if($tag_config['effectid']==16) { ?>selected<?php } ?>>水平向外分开</option>
<option value='17' <?php if($tag_config['effectid']==17) { ?>selected<?php } ?>>左下条状</option>
<option value='18' <?php if($tag_config['effectid']==18) { ?>selected<?php } ?>>左上条状</option>
<option value='19' <?php if($tag_config['effectid']==19) { ?>selected<?php } ?>>右下条状</option>
<option value='20' <?php if($tag_config['effectid']==20) { ?>selected<?php } ?>>右上条状</option>
<option value='21' <?php if($tag_config['effectid']==21) { ?>selected<?php } ?>>随机的水平栅栏</option>
<option value='22' <?php if($tag_config['effectid']==22) { ?>selected<?php } ?>>随机的垂直栅栏</option>
<option value='23' <?php if($tag_config['effectid']==23) { ?>selected<?php } ?>>随机任意的上述一种效果</option>
</select></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
	<?=showtpl($mod,'tag_product_slide','tag_config[templateid]',$tag_config['templateid'],'id="templateid"')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=product&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
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