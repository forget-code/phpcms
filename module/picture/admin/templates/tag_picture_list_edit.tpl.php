<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script type="text/javascript">
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

<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
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
    <th colspan=2>修改<?=$functions[$function]?>标签</th>
  </tr>
  <form name="myform" method="get" action="?">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="channelid" type="hidden" value="<?=$channelid?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
   <input type="hidden" name="tag_config[func]" value="<?=$function?>">
   <input name="tagname" type="hidden" value="<?=$tagname?>">
   <input name="action" type="hidden" value="edit">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input type="text" size="20" value="<?=$tagname?>" disabled title="标题不可再修改" />
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>标签说明</b><br/>例如：首页最新推荐图片，10篇</td>
      <td class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="50" value="<?=$tag_config['introduce']?>" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan="2" align="center"><b>标签参数设置</b></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>所属频道</b></td>
      <td  class="tablerow"><input name="tag_config[channelid]" id="setchannelid" type="text" size="15" value="<?=$tag_config['channelid']?>"> 
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
	<td class="tablerow"><b>调用图片所属栏目ID</b><br><font color="blue">多个ID之前用半角逗号隔开，0表示不限栏目</font><br>某些情况下可使用变量<a href="###" onclick="$('catid').value='$catid'"><font color="red">$catid</font></a>作为参数</td>
	<td  class="tablerow">
	<input name="tag_config[catid]" type="text" size="15"  id="catid" value="<?=$tag_config['catid']?>">&nbsp;
	<span id="category_select">
	<select name='selectcatid' onchange="ChangeInput(this,document.myform.catid)">
	<option value="0">不限栏目</option>
	<option value='$catid'>$catid</option>
	<?=$category_select?></span> &nbsp;选择时栏目ID会自动加入到表单中
	</td>
	</tr>
    <tr> 
      <td class="tablerow"><b>是否调用子栏目图片</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[child]" value="1" <?php if($tag_config['child']){ ?>checked<?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[child]" value="0" <?php if(!$tag_config['child']){ ?>checked<?php } ?>>否 仅当栏目ID为单个时有效</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>所属专题</b></td>
      <td  class="tablerow">
	  <input name="tag_config[specialid]" id="specialid" type="text" size="15" value="<?=$tag_config['specialid']?>"> 
		<select onchange="$('specialid').value=this.value">
		<option value="0">不限专题</option>
		<option value='$specialid'>$specialid</option>
		<?=$special_select?>
	</td>
	</tr>

    <tr> 
      <td class="tablerow" width="40%"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="$page" <? if($tag_config['page']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" <? if(!$tag_config['page']) { ?>checked<? } ?>>否 仅当栏目ID为单个时有效</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每页图片数</b></td>
      <td  class="tablerow"><input name="tag_config[picturenum]" type="text" size="10" value="<?=$tag_config['picturenum']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>图片标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[titlelen]" type="text" size="10" value="<?=$tag_config['titlelen']?>"> 一个汉字为2个字符</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>内容摘要最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[introducelen]" type="text" size="10" value="<?=$tag_config['introducelen']?>"> 如果设置为0则表示不显示内容摘要</td>
    </tr>
	
    <tr> 
      <td class="tablerow"><b>附属分类</b></td>
      <td  class="tablerow"><input name="tag_config[typeid]" type="text" size="10" value="<?=$tag_config['typeid']?>" id="typeid"> <?=type_select('', '请选择', 0, 'onchange="$(\'typeid\').value=this.value"')?></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>推荐位置</b></td>
      <td  class="tablerow"><?=pos_select($channelid, "tag_config[posid]", "不限", $tag_config['posid'])?></td>
    </tr>

    <tr> 
      <td class="tablerow"><b>多少天以内的图片</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="10" value="<?=$tag_config['datenum']?>" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
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
      <td class="tablerow" width="40%"><b>图片排序方式</b></td>
      <td  class="tablerow">
<select name='tag_config[ordertype]'>
<option value='0' <? if($tag_config['ordertype']==0) { ?>selected<? } ?>>按图片排序排序</option>
<option value='1' <? if($tag_config['ordertype']==1) { ?>selected<? } ?>>按更新时间降序</option>
<option value='2' <? if($tag_config['ordertype']==2) { ?>selected<? } ?>>按更新时间升序</option>
<option value='3' <? if($tag_config['ordertype']==3) { ?>selected<? } ?>>按浏览次数降序</option>
<option value='4' <? if($tag_config['ordertype']==4) { ?>selected<? } ?>>按浏览次数升序</option>
<option value='5' <? if($tag_config['ordertype']==5) { ?>selected<? } ?>>按评论次数降序</option>
<option value='6' <? if($tag_config['ordertype']==6) { ?>selected<? } ?>>按评论次数升序</option>
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
      <td class="tablerow" width="40%"><b>是否在图片标题前显示栏目名称</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showcatname]" value="1" <? if($tag_config['showcatname']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showcatname]" value="0" <? if(!$tag_config['showcatname']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否在标题后面显示作者</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showauthor]" value="1" <? if($tag_config['showauthor']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showauthor]" value="0" <? if(!$tag_config['showauthor']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否在标题后面显示浏览次数</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[hits]" value="1" <? if($tag_config['hits']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[hits]" value="0" <? if(!$tag_config['hits']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1" <? if($tag_config['target']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[target]" value="0" <? if(!$tag_config['target']) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每行显示链接列数</b></td>
      <td  class="tablerow"><input type="text" size="5" name='tag_config[cols]' value="<?=$tag_config['cols']?>"> 列
      </td>
    </tr>

	<tr> 
  <td class="tablerow"><b>会员名称</b></td>
  <td  class="tablerow"><input name="tag_config[username]" id="username" type="text" size="15" value="<?=$tag_config['username']?>"/> 可调用单个会员的文章</td>
</tr>

    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
	<?=showtpl($mod,'tag_picture_list','tag_config[templateid]',$tag_config['templateid'],'id="templateid"')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=picture&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="dosubmit" value=" 保存 "  onclick="$('action').value='edit';">   &nbsp; 
         <input type="submit" name="dopreview" value=" 预览 " onclick="$('action').value='preview';">  &nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>