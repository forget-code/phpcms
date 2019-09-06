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
    <th colspan=2>添加
        <?=$functions[$function]?>
      标签</th>
  </tr>
  <form name="myform" method="get" action="?">
    <input name="mod" type="hidden" value="<?=$mod?>">
    <input name="file" type="hidden" value="<?=$file?>">
    <input name="action" type="hidden" value="<?=$action?>" id="action">
    <input name="function" type="hidden" value="<?=$function?>">
    <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
    <input name="tag_config[func]" type="hidden" value="<?=$function?>">
    <tr>
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>
        可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
        <input name="tagname" id="tagname" type="text" size="20">
        <input name="button" type="button" onClick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checkname&tagname='+$('tagname').value+'','','300','40','no')" value=" 检查是否已经存在 ">
        <br/>
      </td>
    </tr>
    <tr>
   <td class="tablerow"><b>标签说明</b><br/>
      例如：首页最新出租，10条</td>
   <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="60" /></td>
    </tr>
    <tr>
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
    <tr>
      <td class="tablerow"><b>信息类别</b></td>
      <td  class="tablerow"><input name="tag_config[infocat]" type="text" size="8"  id="infocat" value="0">
        <select name='select' onChange="document.myform.infocat.value=this.value">
          <option value="0">不限类别</option>
          <?=$infocat_select?>
          &nbsp;选择时区域ID会自动加入到表单中
        </select></td>
    </tr>
    <tr>
      <td class="tablerow"><b>调用信息所属区域</b><br>
某些情况下可使用变量<a href="#" onClick="$('areaid').value='$areaid'"><font color="red">$areaid</font></a>作为参数</td>
      <td  class="tablerow">
	  <input name="tag_config[areaid]" type="text" size="5" id="areaid" value="<?=$areaid?>">
	   <?=ajax_area_select('tag_config[areaid]', 'house', $areaid)?>      
       </td>
    </tr>
    <tr>
      <td class="tablerow"><strong>列出该交易价格范围内的信息</strong><br>
        0表示不限</td>
      <td class="tablerow">从
          <input name="tag_config[pricestart]" type="text" size="8" id="startpricestart"  value="0">
        到
        <input name="tag_config[priceend]" type="text" size="8" id="startpriceend" value="0"></td>
    </tr>
    <tr style="display:none;">
      <td class="tablerow"><b>调用<b>信息</b>所属附属分类</b><br></td>
      <td  class="tablerow">
        <input name="tag_config[typeid]" type="text" size="15"  id="typeid" value="0">
&nbsp;
        <?=$type_select?>
&nbsp;选择时附属分类ID会自动加入到表单中 </td>
    </tr>
    <tr>
      <td class="tablerow"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="$page" >
        是&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="tag_config[page]" value="0" checked>        否 仅当栏目ID为单个时有效</td>
    </tr>
    <tr>
      <td class="tablerow"><b>是否显示价格</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showprice]" value="1"  checked >
        是&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="tag_config[showprice]" value="0">        否</td>
    </tr>
    <tr>
      <td class="tablerow"><b>是否显示点击数</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showhits]" value="1" >
        是&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="tag_config[showhits]" value="0" checked>        否</td>
    </tr>
    <tr>
      <td class="tablerow"><b>调用信息数或每页<b>信息</b>数</b></td>
      <td  class="tablerow"><input name="tag_config[housenum]" type="text" size="10" value="10"></td>
    </tr>
    <tr>
      <td class="tablerow"><b><b>房产信息</b>标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[titlelen]" type="text" size="10" value="30">
        一个汉字为2个字符</td>
    </tr>
    <tr>
      <td class="tablerow"><b>信息介绍最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[descriptionlen]" type="text" size="10" value="0">
        如果设置为0则表示不显示内容摘要</td>
    </tr>
    <tr>
      <td class="tablerow"><b>推荐位置</b></td>
      <td  class="tablerow"><input name="tag_config[posid]" type="text" size="10" value="0" id="posid">          <?=pos_select($mod, "tag_config[posid]", "请选择", 0,  'onchange="ChangeInput(this,document.myform.posid)"')?></td>
    </tr>
	 <tr>
      <td class="tablerow"><b>发布人</b></td>
      <td  class="tablerow"><input name="tag_config[username]" type="text" size="10" value="0" id="username"/></td>
    </tr>
    <tr>
      <td class="tablerow"><b>发布多少天以内的信息</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="5" value="0" id="datenum">
        天&nbsp;&nbsp;
        <select name="selectdatenum" onChange="$('datenum').value=this.value">
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
        您可以从下拉框中选择 </td>
    </tr>
    <tr>
      <td class="tablerow"><b><b><b>房产信息</b></b>排序方式</b></td>
      <td  class="tablerow">
        <select name="tag_config[ordertype]">
          <option value="0">按信息排序排序</option>
          <option value="1">按更新时间降序</option>
          <option value="2">按更新时间升序</option>
          <option value="3">按浏览次数降序</option>
          <option value="4">按浏览次数升序</option>
          <option value="5">按评论次数降序</option>
          <option value="6">按评论次数升序</option>
          <option value="7">按交易价格降序</option>
          <option value="8">按交易价格升序</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="tablerow"><b>时间显示格式</b></td>
      <td  class="tablerow">
        <select name="tag_config[datetype]">
          <option value="0">不显示时间</option>
          <option value="1">格式：
          <?=date("Y-m-d",$PHP_TIME)?>
          </option>
          <option value="2">格式：
          <?=date("m-d",$PHP_TIME)?>
          </option>
          <option value="3">格式：
          <?=date("Y/m/d",$PHP_TIME)?>
          </option>
          <option value="4">格式：
          <?=date("Y.m.d",$PHP_TIME)?>
          </option>
          <option value="5">格式：
          <?=date("Y-m-d H:i:s",$PHP_TIME)?>
          </option>
          <option value="6">格式：
          <?=date("Y-m-d H:i",$PHP_TIME)?>
          </option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="tablerow"><b>是否在<b><b>房产信息</b></b>标题前显示区域名称</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showareaidname]" value="1"  checked>
        是&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="tag_config[showareaidname]" value="0">
        否</td>
    </tr>
    <tr>
      <td class="tablerow"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1">
        是&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="tag_config[target]" value="0" checked>
        否</td>
    </tr>
    <tr>
      <td class="tablerow"><b>每行显示链接列数</b></td>
      <td  class="tablerow"><input name="tag_config[cols]" type="text" size="5" id="cols" value="1">
&nbsp;
        <select name="selectcols" onChange="$('cols').value=this.value">
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
        <?=showtpl($mod,'tag_house_list','tag_config[templateid]',0,' id="templateid" ')?>
&nbsp;&nbsp;
        <input type="button" name="edittpl" value="修改选择的模板" onClick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=<?=$mod?>&referer=<?=urlencode($PHP_URL)?>'">
        [注:只能修改非默认模板] </td>
    </tr>
    <tr>
      <td class="tablerow"></td>
      <td class="tablerow"><input type="submit" name="dosubmit" value=" 保存 "  onClick="$('action').value='add';">
&nbsp;
        <input name="submit" type="submit" onClick="$('action').value='preview';" value=" 预览 ">
&nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>