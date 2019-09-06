<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<script type="text/javascript">
function doCheck(){
	if($F('tagname')==''){
		alert('标签名称不能为空');
		$('tagname').focus();
		return false;
	}
	if($F('setchannelid')=='' || $F('setchannelid')=='0'){
		alert('频道ID不能为空和0！');
		$('setchannelid').focus();
		return false;
	}
	return true;
}
function showcat(keyid,catid)
{
    var url = "<?=$PHP_SELF?>";
    var pars = "mod=phpcms&file=tag&action=category_select&catid="+catid+"&keyid="+keyid;
	var myAjax = new Ajax.Updater(
					'category_select',
					url,
					{
					method: 'get',
					parameters: pars
					}
	             ); 
}
</script>
<table cellpadding="2" cellspacing="1" border="0" align="center" class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>&channelid=<?=$channelid?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>&channelid=<?=$channelid?>">管理标签</a></td>
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
  <form name="myform" method="get" action="?"   onsubmit="return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="channelid" type="hidden" value="<?=$channelid?>">
   <input name="action" type="hidden" value="<?=$action?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
   <input type="hidden" name="tag_config[func]" value="<?=$function?>">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input name="tagname" id="tagname" type="text" size="20" value="<?=$tagname?>"> <input type="button" value=" 检查是否已经存在 " onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checkname&channelid=<?=$channelid?>&tagname='+$('tagname').value+'','','300','40','no')"> <br/>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>标签说明</b><br/>例如：首页最新推荐信息，10篇</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="50" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>所属频道</b></td>
      <td  class="tablerow"><input name="tag_config[channelid]" id="setchannelid" type="text" size="15" value="<?=$channelid?>"> 
<select name='selectchannelid' onchange="$('setchannelid').value=this.value;showcat(this.value, 0)">
<option>请选择频道</option>
<option value='$channelid'>$channelid</option>
<?php 
foreach($CHANNEL as $id=>$channel)
{
	if($channel['islink'] || $channel['module'] != $mod) continue;
    $selected = $id == $channelid ? "selected" : "";
?>
<option value='<?=$id?>' <?=$selected?>><?=$channel['channelname']?></option>
<?php 
}
?>
</select>
	  </td>
    </tr>
        <tr> 
      <td class="tablerow"><b>调用信息所属栏目ID</b><br><font color="blue">多个ID之前用半角逗号隔开，0表示不限栏目</font><br>某些情况下可使用变量<a href="###" onclick="$('catid').value='$catid'"><font color="red">$catid</font></a>作为参数</td>
      <td  class="tablerow">
<input name="tag_config[catid]" type="text" size="15"  id="catid" value="0">&nbsp;
<span id="category_select">
<select name='selectcatid' onchange="ChangeInput(this,document.myform.catid)">
<option value="0">不限栏目</option>
<option value='$catid'>$catid</option>
<?=$category_select?></span> &nbsp;选择时栏目ID会自动加入到表单中
</td>
</tr>

    <tr> 
      <td class="tablerow"><b>是否调用子栏目信息</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[child]" value="1" checked>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[child]" value="0">否 仅当栏目ID为单个时有效</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>所属专题</b></td>
      <td  class="tablerow">
	  <input name="tag_config[specialid]" id="specialid" type="text" size="15" value="0"> 
		<select onchange="$('specialid').value=this.value">
		<option value="0">不限专题</option>
		<option value='$specialid'>$specialid</option>
		<?=$special_select?>
	</td>
	</tr>
    <tr> 
      <td class="tablerow"><b>调用信息数</b></td>
      <td  class="tablerow"><input name="tag_config[infonum]" type="text" size="10" value="5"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>信息标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[titlelen]" type="text" size="10" value="30"> 一个汉字为2个字符</td>
    </tr>
			    <tr> 
      <td class="tablerow"><b>附属分类</b></td>
      <td  class="tablerow"><input name="tag_config[typeid]" type="text" size="10" value="0" id="typeid"> <?=type_select('', '请选择', 0, 'onchange="$(\'typeid\').value=this.value"')?></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>推荐位置</b></td>
      <td  class="tablerow"><?=pos_select($channelid, "tag_config[posid]", "不限", 0)?></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>多少天以内的信息</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="10" value="0" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
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
      <td class="tablerow"><b>信息排序方式</b></td>
      <td  class="tablerow">
<select name="tag_config[ordertype]">
<option value="0">按信息排序排序</option>
<option value="1">按更新时间降序</option>
<option value="2">按更新时间升序</option>
<option value="3">按浏览次数降序</option>
<option value="4">按浏览次数升序</option>
<option value='5'>按评论次数降序</option>
<option value='6'>按评论次数升序</option>
</select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>图片宽度</b></td>
      <td  class="tablerow"><input type="input" name="tag_config[imgwidth]" value="200" size="5"> px </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>图片高度</b></td>
      <td  class="tablerow"><input type="input" name="tag_config[imgheight]" value="200" size="5"> px </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>图片播放间隔时间</b></td>
      <td  class="tablerow"><input type="input" name="tag_config[timeout]" value="5" size="5"> 秒 </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>图片播放过渡效果</b></td>
      <td  class="tablerow">
<select name='tag_config[effectid]'>
<option value='-1' >随机综合效果</option>
<option value='0' >矩形缩小</option>
<option value='1' >矩形扩大</option>
<option value='2' >圆形缩小</option>
<option value='3' >圆形扩大</option>
<option value='4' >向上擦除</option>
<option value='5' >向下擦除</option>
<option value='6' >向右擦除</option>
<option value='7' >向左擦除</option>
<option value='8' >垂直百页</option>
<option value='9' >水平百页</option>
<option value='10' >棋盘状通过</option>
<option value='11' >棋盘状向下</option>
<option value='12' >随机融化</option>
<option value='13' >垂直向内分开</option>
<option value='14' >垂直向外分开</option>
<option value='15' >水平向内分开</option>
<option value='16' >水平向外分开</option>
<option value='17' >左下条状</option>
<option value='18' >左上条状</option>
<option value='19' >右下条状</option>
<option value='20' >右上条状</option>
<option value='21' >随机的水平栅栏</option>
<option value='22' >随机的垂直栅栏</option>
<option value='23' >随机任意的上述一种效果</option>
</select></td>
    </tr>

	 <tr> 
  <td class="tablerow"><b>会员名称</b></td>
  <td  class="tablerow"><input name="tag_config[username]" id="username" type="text" size="15" /> 可调用单个会员的文章</td>
</tr>

    <tr> 
      <td class="tablerow"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
	<?=showtpl($mod,'tag_info_slide','tag_config[templateid]',0,'id="templateid"')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=info&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="dosubmit" value=" 保存 "  onclick="$('action').value='add';">   &nbsp; 
         <input type="submit" value=" 预览 " onclick="$('action').value='preview';">  &nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>