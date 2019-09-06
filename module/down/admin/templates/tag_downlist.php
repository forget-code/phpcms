<?php include admintpl('header');?>
<?=$menu?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/tag.js"></script>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center><?=$_CHA['channelname']?>频道 - <?=$funcs[$func]?>管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=set&func=<?=$func?>&channelid=<?=$channelid?>">添加<?=$funcs[$func]?></a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&func=<?=$func?>&channelid=<?=$channelid?>">管理<?=$funcs[$func]?></a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2><?=$funcs[$func]?>设置</th>
  </tr>
  <form name="myform" method="get" action="?" onsubmit="javascript:return doCheck();">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="channelid" type="hidden" value="<?=$channelid?>">
   <input name="action" type="hidden" value="save">
   <input name="tagid" type="hidden" value="<?=$tagid?>">
   <input name="func" type="hidden" value="<?=$func?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
    <tr> 
      <td class="tablerow" width="40%"><b>配置名称</b><font color="red">*</font><br/>只能由字母、数字和下划线组成，例如：new_down</td>
      <td  class="tablerow">
	  <input name="tag" id="tag" type="text" size="20" value="<?=$my?><?=$tag?>" <?php if($tagid){?>disabled<?php } ?>> <input type="button" name="submit" value=" 检查是否已经存在 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=<?=$file?>&action=tag_exists&tag='+myform.tag.value,'tag_exists','450','160')"> <br/>
	  为避免与系统内置标签冲突，自定义标签配置名前面会自动加上 <font color="red">my_</font> 为前缀
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>配置说明</b><font color="red">*</font><br/>对标签进行简单描述（可用中文），例如：最新下载</td>
      <td  class="tablerow"><input name="tagname" id="tagname" type="text" size="60" value="<?=$tagname?>"></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>调用文章所属频道ID</b><br>如果多个频道共用同一个模板，则请使用变量<a href="#" onclick="myform.setchannelid.value='$channelid'"><font color=red>$channelid</font></a>作为参数</td>
      <td  class="tablerow">
<input name="newdata[channelid]" type="text" size="15" value="<?=$data[channelid]?>" id="setchannelid">
<br>
<select name='selectchannelid' onchange="javascript:myform.setchannelid.value=this.value">
<option>请选择频道</option>
<option value='$channelid'>$channelid</option>
<?php 
foreach($_CHANNEL as $id=>$channel)
{
	if($channel[channeltype] && $channel[module]==$mod)
	{
?>
<option value='<?=$id?>'><?=$channel[channelname]?></option>
<?php 
	}
}
?>
</select>
选择时频道ID会自动加入到表单中
</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>调用下载所属栏目ID</b><br>
      多个ID之前用半角逗号隔开，0表示不限栏目<br>某些情况下可使用变量<a href="#" onClick="myform.catid.value='$catid'"><font color=red>$catid</font></a>作为参数</td>
      <td  class="tablerow">
<input name="newdata[catid]" type="text" size="15" value="<?php echo $data['catid']; ?>" id="catid">
调用子栏目下载<input name="newdata[child]" type="checkbox" value="1" <?php if($data['child']==1 ) { ?> checked="checked" <?php } ?>>（单个栏目ID有效）
<br />
<select name='selectcatid' onchange="javascript:ChangeInput(this,document.myform.catid)">
<option>请选择栏目</option>
<option value='$catid'>$catid</option>
<option value='0'>不限栏目</option>
<?=$cat_option?>
</select>
选择时栏目ID会自动加入到表单中</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>调用下载所属专题ID</b><br>
      多个ID之前用半角逗号隔开，0表示不限专题<br>某些情况下可使用变量<a href="#" onClick="myform.specialid.value='$specialid'"><font color=red>$specialid</font></a>作为参数</td>
      <td  class="tablerow">
<input name="newdata[specialid]" type="text" size="20" value="<?php echo $data[specialid]; ?>" id="specialid">
<br />
<?php echo $special_select; ?>
选择时专题ID会自动加入到表单中</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否分页显示</b><br>只对单个栏目有效</td>
      <td  class="tablerow"><input type="radio" name="newdata[page]" value="$page" <? if($data[page]) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="newdata[page]" value="0" <? if(!$data[page]) { ?>checked<? } ?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>每页下载数</b></td>
      <td  class="tablerow"><input name="newdata[downnum]" type="text" id="newdata[downnum]" value="<?php echo $data['downnum']; ?>" size="10"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>下载标题最大字符数</b></td>
      <td  class="tablerow">
	  <input name="newdata[titlelen]" type="text" size="10" value="<?php echo $data['titlelen']; ?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>下载简介最大字符数</b></td>
      <td  class="tablerow">
	  <input name="newdata[descriptionlen]" type="text" size="10" value="<?php echo $data['descriptionlen']; ?>"></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否为推荐下载</b></td>
      <td  class="tablerow">
	  <input type="radio" name="newdata[iselite]" value="1" <?php if($data['iselite']) echo 'checked="checked"';?> />是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="newdata[iselite]" value="0" <?php if(!$data['iselite']) echo 'checked="checked"';?> />否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>多少天以内的下载</b></td>
      <td  class="tablerow"><input name="newdata[datenum]" type="text" size="5" value="<?php echo $data['datenum']; ?>" id="datenum"> 
      天&nbsp;&nbsp;&nbsp;&nbsp;
<select name='selectdatenum' onclick="javascript:myform.datenum.value=this.value">
<option value='0' <?php if($data['datenum']==0) echo 'selected="selected"';?> >不限天数</option>
<option value='3' <?php if($data['datenum']==3) echo 'selected="selected"';?>>3天以内</option>
<option value='7' <?php if($data['datenum']==7) echo 'selected="selected"';?>>一周以内</option>
<option value='14' <?php if($data['datenum']==14) echo 'selected="selected"';?>>两周以内</option>
<option value='30' <?php if($data['datenum']==30) echo 'selected="selected"';?>>一个月内</option>
<option value='60' <?php if($data['datenum']==60) echo 'selected="selected"';?>>两个月内</option>
<option value='90' <?php if($data['datenum']==90) echo 'selected="selected"';?>>三个月内</option>
<option value='180' <?php if($data['datenum']==180) echo 'selected="selected"';?>>半年以内</option>
<option value='365' <?php if($data['datenum']==365) echo 'selected="selected"';?>>一年以内</option>
</select>
您可以从下拉框中选择</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>下载排序方式</b></td>
      <td  class="tablerow">
<select name='newdata[ordertype]'>
<option value='1' <?php if($data['ordertype']==1) echo 'selected="selected"'; ?>>按信息ID降序</option>
<option value='2' <?php if($data['ordertype']==2) echo 'selected="selected"'; ?>>按信息ID升序</option>
<option value='3' <?php if($data['ordertype']==3) echo 'selected="selected"'; ?>>按更新时间降序</option>
<option value='4' <?php if($data['ordertype']==4) echo 'selected="selected"'; ?>>按更新时间升序</option>
<option value='5' <?php if($data['ordertype']==5) echo 'selected="selected"'; ?>>按下载次数降序</option>
<option value='6' <?php if($data['ordertype']==6) echo 'selected="selected"'; ?>>按下载次数升序</option>
</select>      </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>时间显示格式</b></td>
      <td  class="tablerow">
<select name='newdata[datetype]'>
<option value='0' <?php if($data['datetype']==0) echo 'selected="selected"'; ?>>不显示时间</option>
<option value='1' <?php if($data['datetype']==1) echo 'selected="selected"'; ?>>格式：<?php echo date('Y-m-d',$timestamp); ?></option>
<option value='2' <?php if($data['datetype']==2) echo 'selected="selected"'; ?>>格式：<?php echo date('m-d',$timestamp); ?></option>
<option value='3' <?php if($data['datetype']==3) echo 'selected="selected"'; ?>>格式：<?php echo date('Y/m/d',$timestamp); ?></option>
<option value='4' <?php if($data['datetype']==4) echo 'selected="selected"'; ?>>格式：<?php echo date('Y.m.d',$timestamp); ?></option>
</select>
	</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在下载标题前显示栏目名称</b></td>
      <td  class="tablerow">
	  <input type="radio" name="newdata[showcatname]" value="1" <?php if($data['showcatname']) echo 'checked="checked"'; ?> />是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="newdata[showcatname]" value="0" <?php if(!$data['showcatname']) echo 'checked="checked"'; ?> />否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在标题后面显示作者</b></td>
      <td  class="tablerow">
	  <input type="radio" name="newdata[showauthor]" value="1" <?php if($data['showauthor']) echo 'checked="checked"'; ?> />是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="newdata[showauthor]" value="0" <?php if(!$data['showauthor']) echo 'checked="checked"'; ?> />否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在标题后面显示下载次数</b></td>
      <td  class="tablerow">
	  <input type="radio" name="newdata[showdowns]" value="1" <?php if($data['showdowns']) echo 'checked="checked"'; ?> />是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="newdata[showdowns]" value="0" <?php if(!$data['showdowns']) echo 'checked="checked"'; ?> />否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在标题后面显示下载大小</b></td>
      <td  class="tablerow">
	  <input type="radio" name="newdata[showsize]" value="1" <?php if($data['showsize']) echo 'checked="checked"'; ?> />是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="newdata[showsize]" value="0" <?php if(!$data['showsize']) echo 'checked="checked"'; ?> />否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在标题后面显示评分等级</b></td>
      <td  class="tablerow">
	  <input type="radio" name="newdata[showstars]" value="1" <?php if($data['showstars']) echo 'checked'; ?> />是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="newdata[showstars]" value="0" <?php if(!$data['showstars']) echo 'checked'; ?> />否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow">
	  <input type="radio" name="newdata[target]" value="1" <?php if($data['target']) echo 'checked="checked"'; ?>/>是&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="radio" name="newdata[target]" value="0" <?php if(!$data['target']) echo 'checked="checked"'; ?> />否
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>每行显示下载标题列数</b></td>
      <td  class="tablerow">
<select name='newdata[cols]'>
<option value='1' <?php if($data['cols']==1) echo 'selected="selected"'; ?>>1列</option>
<option value='2' <?php if($data['cols']==2) echo 'selected="selected"'; ?>>2列</option>
<option value='3' <?php if($data['cols']==3) echo 'selected="selected"'; ?>>3列</option>
<option value='4' <?php if($data['cols']==4) echo 'selected="selected"'; ?>>4列</option>
<option value='5' <?php if($data['cols']==5) echo 'selected="selected"'; ?>>5列</option>
<option value='6' <?php if($data['cols']==6) echo 'selected="selected"'; ?>>6列</option>
<option value='7' <?php if($data['cols']==7) echo 'selected="selected"'; ?>>7列</option>
<option value='8' <?php if($data['cols']==8) echo 'selected="selected"'; ?>>8列</option>
<option value='9' <?php if($data['cols']==9) echo 'selected="selected"'; ?>>9列</option>
<option value='10' <?php if($data['cols']==10) echo 'selected="selected"'; ?>>10列</option>
</select>      </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=$showtpl?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选中模板" onclick="window.location='?mod=phpcms&file=template&channelid=<?=$channelid?>&action=edit&templateid='+myform.templateid.value+'&module=<?=$mod?>&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
	  </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
       <input type="submit" name="submit" value=" 保存 " onclick="javascript:doSave();" />   &nbsp; 
       <input type="submit" name="preview" value=" 预览 " onclick="return doPreview();" />  &nbsp; 
       <input type="reset" name="reset" value=" 重置 " />
	   </td>
    </tr>
</table>
</form>

</body>
</html>