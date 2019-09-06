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
    <th colspan=2>编辑<?=$functions[$function]?>标签</th>
  </tr>
  <form name="myform" method="get" action="?">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>" id="action">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input name="tagname" id="tagname" type="text" size="20"  value="<?=$tagname?>" readonly>
        <input name="button" type="button" value="(标签名称不可再编辑) " > <br/>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>标签说明</b><br/>例如：首页最新楼盘，10套</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="60" value="<?=$tag_config['introduce']?>"  /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
        <tr> 
      <td class="tablerow"><b>调用楼盘所属区域</b><br><font color="blue">多个ID之前用半角逗号隔开，0或空表示不限栏目</font><br>某些情况下可使用变量<a href="#" onclick="$('areaid').value='$areaid'"><font color="red">$areaid</font></a>作为参数</td>
      <td  class="tablerow">
<input name="tag_config[areaid]" type="text" size="10"  id="areaid" value="<?=$tag_config['areaid']?>">&nbsp;
<?=area_select('setareaid', '不限', $tag_config['areaid'], 'onchange="document.myform.areaid.value=this.value"')?>
&nbsp;选择时区域ID会自动加入到表单中
</td>
</tr>
        <tr> 
      <td class="tablerow"><b>调用楼盘所属的开发商</b></td>
      <td  class="tablerow"><input name="tag_config[develop]" id="develop" type="text" size="60"  value="<?=$tag_config['develop']?>"/>
</td>
</tr>

    <tr> 
      <td class="tablerow"><strong>列出该起始价格范围内的楼盘 </strong><br>0表示不限</td>
      <td class="tablerow">从 
        <input name="tag_config[startpricestart]" type="text" size="8" id="startpricestart"  value="<?=$tag_config['startpricestart']?>"> 
        到 
        <input name="tag_config[startpriceend]" type="text" size="8" id="startpriceend" value="<?=$tag_config['startpriceend']?>"></td>
    </tr>
	    <tr> 
      <td class="tablerow"><strong>列出该平均价格范围内的楼盘 </strong><br>0表示不限</td>
      <td class="tablerow">从 
        <input name="tag_config[avgpricestart]" type="text" size="8" id="avgpricestart"  value="<?=$tag_config['avgpricestart']?>"> 
        到 
        <input name="tag_config[avgpriceend]" type="text" size="8" id="avgpriceend" value="<?=$tag_config['avgpriceend']?>"></td>
    </tr>
 <tr style="display:none;"> 
 <td class="tablerow"><b>调用楼盘所属附属分类</b><br></td>
 <td  class="tablerow">
<input name="tag_config[typeid]" type="text" size="5"  id="typeid" value="<?=$tag_config['typeid']?>">&nbsp;

<?=$type_select?> &nbsp;选择时附属分类ID会自动加入到表单中
</td>
</tr>

  
	<tr> 
      <td class="tablerow"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="$page"  <?php if($tag_config['page']){ ?>checked<?php } ?> >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" <?php if(!$tag_config['page']){ ?>checked<?php } ?>>否 仅当栏目ID为单个时有效</td>
    </tr>
		<tr> 
      <td class="tablerow"><b>是否显示价格</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showprice]" value="1" <?php if($tag_config['showprice']){ ?>checked<?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showprice]" value="0"  <?php if(!$tag_config['showprice']){ ?>checked<?php } ?>>否</td>
    </tr>
			<tr> 
      <td class="tablerow"><b>是否显示点击数</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showhits]" value="1"  <?php if($tag_config['showhits']){ ?>checked<?php } ?> >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showhits]" value="0"  <?php if(!$tag_config['showhits']){ ?>checked<?php } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>调用楼盘数或每页楼盘数</b></td>
      <td  class="tablerow"><input name="tag_config[displaynum]" type="text" size="10" value="<?=$tag_config['displaynum']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>楼盘标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[titlelen]" type="text" size="10" value="<?=$tag_config['titlelen']?>"> 一个汉字为2个字符</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>内容摘要最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[descriptionlen]" type="text" size="10" value="<?=$tag_config['descriptionlen']?>"> 如果设置为0则表示不显示内容摘要</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>推荐位置</b></td>
      <td  class="tablerow"><?=pos_select($mod, "tag_config[posid]", "不限", $tag_config['posid'],  'onchange="ChangeInput(this,document.myform.posid)"')?></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>发布多少天以内的楼盘</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="5" value="<?=$tag_config['datenum']?>" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name="selectdatenum" onchange="$('datenum').value=this.value">
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
      <td class="tablerow"><b>楼盘排序方式</b></td>
      <td  class="tablerow">
<select name="tag_config[ordertype]">
<option value='0' <? if($tag_config['ordertype']==0) { ?>selected<? } ?>>按楼盘排序排序</option>
<option value='1' <? if($tag_config['ordertype']==1) { ?>selected<? } ?>>按更新时间降序</option>
<option value='2' <? if($tag_config['ordertype']==2) { ?>selected<? } ?>>按更新时间升序</option>
<option value='3' <? if($tag_config['ordertype']==3) { ?>selected<? } ?>>按浏览次数降序</option>
<option value='4' <? if($tag_config['ordertype']==4) { ?>selected<? } ?>>按浏览次数升序</option>
<option value="5" <? if($tag_config['ordertype']==5) { ?>selected<? } ?>>按评论次数降序</option>
<option value="6" <? if($tag_config['ordertype']==6) { ?>selected<? } ?>>按评论次数升序</option>
<option value="7" <? if($tag_config['ordertype']==7) { ?>selected<? } ?>>按起始价格降序</option>
<option value="8" <? if($tag_config['ordertype']==8) { ?>selected<? } ?>>按起始价格升序</option>
<option value="9" <? if($tag_config['ordertype']==9) { ?>selected<? } ?>>按平均价格降序</option>
<option value="10" <? if($tag_config['ordertype']==10) { ?>selected<? } ?>>按平均价格升序</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>时间显示格式</b></td>
      <td  class="tablerow">
	  <select name="tag_config[datetype]">
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
      <td class="tablerow"><b>是否在楼盘标题前显示区域名称</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showareaidname]" value="1"  <?php if($tag_config['showareaidname']){ ?>checked<?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showareaidname]" value="0"  <?php if(!$tag_config['showareaidname']){ ?>checked<?php } ?>>否</td>
    </tr>    
    <tr> 
      <td class="tablerow"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1"  <?php if($tag_config['target']){ ?>checked<?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[target]" value="0"   <?php if(!$tag_config['target']){ ?>checked<?php } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>每行显示链接列数</b></td>
      <td  class="tablerow"><input name="tag_config[cols]" type="text" size="5" id="cols" value="<?=$tag_config['cols']?>">&nbsp;<select name="selectcols" onchange="$('cols').value=this.value">
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
      <td class="tablerow"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
	<?=showtpl($mod,'tag_display_list','tag_config[templateid]',$tag_config['templateid'],' id="templateid" ')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=<?=$mod?>&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>

    <tr>
      <td class="tablerow"></td>
      <td class="tablerow"><input type="submit" name="dosubmit" value=" 保存 "  onclick="$('action').value='edit';">
&nbsp;
<input name="submit" type="submit" onclick="$('action').value='preview';" value=" 预览 ">
&nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>