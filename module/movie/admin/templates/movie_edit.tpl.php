<?php 
	defined('IN_PHPCMS') or exit('Access Denied');
	include admintpl('header');
?>
<?=$menu?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script>
<script type="text/javascript">
function ruselinkurl(){
	if($('islink').checked==true){
		$('linkurl').disabled=false;
	}else{
		$('linkurl').disabled=true;
	}
}

function doCheck(){
	if ($F('title')=="") {
		alert("请输入标题");
		$('title').focus();
		return false;
	}
}

function SelectPic(){
  var arr=Dialog('?mod=phpcms&file=file_select&channelid=<?=$channelid?>&type=thumb','',820,600);
  if(arr!=null){
    var s=arr.split('|');
    $('thumb').value=s[0];
  }
}
function SelectBigPic(){
  var arr=Dialog('?mod=phpcms&file=file_select&channelid=<?=$channelid?>&type=thumb','',820,600);
  if(arr!=null){
    var s=arr.split('|');
    $('bigthumb').value=s[0];
  }
}
function CutPic(){
  var thumb=$('thumb').value;
	if(thumb=='')
	{
		alert('请先上传小缩略图');
		$('thumb').focus();
		return false;
	}
  var arr=Dialog('corpandresize/ui.php?<?=$PHPCMS[siteurl]?>'+thumb,'',700,500);
  if(arr!=null){
    $('thumb').value=arr;
  }
}
function CutBigPic(){
  var thumb=$('bigthumb').value;
	if(thumb=='')
	{
		alert('请先上传大缩略图');
		$('bigthumb').focus();
		return false;
	}
  var arr=Dialog('corpandresize/ui.php?<?=$PHPCMS[siteurl]?>'+thumb,'',700,500);
  if(arr!=null){
    $('bigthumb').value=arr;
  }
}
function SelectKeywords(){	
  var s=Dialog('?mod=phpcms&file=keywords&keyid=<?=$channelid?>&select=1','',700,500);
  if(s!=null){
	  if($('keywords').value == '')
	  {
		  $('keywords').value = s;
	  }
	  else if($('keywords').value.indexOf(s) == -1)
	  {
		  $('keywords').value += ','+s;
	  }
  }
  $('keywords').select();
}
function doKeywords(ID)
{
	$(ID).value = $F(ID).replace(new RegExp('，',"gm"),',');
	$(ID).value = $F(ID).replace(new RegExp(' ',"gm"),',');
}
function setid()
{
	str='';
	if(!$F('num'))
	$F('num')=1;
	for(i=$F('num');i<=$F('endnum');i++)
	{
	if($F('endnum')<10)
	{
	str+='<input type="text" name="url[]" size=50 value="'+$F('pc_movieieurl')+''+i+''+$F('pc_vodie')+'" class="Input">&nbsp;前台显示<input name="txt[]" type="text" value="'+i+'" size="4" class="Input"/><br>';
	}
	else if($F('endnum')<100)
	{
	if(i<10)
	{
	str+='<input type="text" name="url[]" size=50 value="'+$F('pc_movieieurl')+''+'0'+i+''+$F('pc_vodie')+'" class="Input">&nbsp;前台显示<input name="txt[]" type="text" value="'+i+'" size="4" class="Input"/><BR>';
	}
	else
	{
	str+='<input type="text" name="url[]" size=50 value="'+$F('pc_movieieurl')+''+i+''+$F('pc_vodie')+'" class="Input">&nbsp;前台显示<input name="txt[]" type="text" value="'+i+'" size="4" class="Input"/><BR>';
	}
	} 
	else if($F('endnum')<1000)
	{
	if(i<10)
	{
	str+='<input type="text" name="url[]" size=50 value="'+$F('pc_movieieurl')+''+'00'+i+''+$F('pc_vodie')+'" class="Input">&nbsp;前台显示<input name="txt[]" type="text" value="'+i+'" size="4" class="Input"/><BR>';
	} 
	else if(i<100)
	{
	str+='<input type="text" name="url[]" size=50 value="'+$F('pc_movieieurl')+''+'0'+i+''+$F('pc_vodie')+'" class="Input">&nbsp;前台显示<input name="txt[]" type="text" value="'+i+'" size="4" class="Input"/><BR>';
	}
	else
	{
	str+='<input type="text" name="url[]" size=50 value="'+$F('pc_movieieurl')+''+i+''+$F('pc_vodie')+'" class="Input">&nbsp;前台显示<input name="txt[]" type="text" value="'+i+'" size="4" class="Input"/><BR>';
	}
	}
	}
	$('upid').innerHTML=str+'<br>';
} 
</script>
<?=segment_word()?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
	<tr>
		<td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">影片首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&movieid=<?=$movieid?>&catid=<?=$catid?>&channelid=<?=$channelid?>">编辑影片</a> &gt;&gt; <?=$CAT['catname']?> &gt;&gt; </td>
		<td class="tablerow" align="right">	  
		<?php echo $category_jump; ?></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td height="10"> </td>
	</tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr align="center" height="24">
		<td id="TabTitle0" class="title2" onclick="ShowTabs(0)">基本信息</td>
		<td id="TabTitle1" class="title1" onclick="ShowTabs(1)">高级设置</td>
		<td id="TabTitle2" class="title1" onclick="ShowTabs(2)">权限与收费</td>
		<td>&nbsp;</td>
	</tr>
</table>

<form action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&movieid=<?=$movieid?>&channelid=<?=$channelid?>&catid=<?=$catid?>&dosubmit=1" method="post" name="myform" onsubmit="return doCheck();">
<input type="hidden" name="referer" value="<?=$referer?>" />
<input type="hidden" name="movie[username]" value="<?=$_username?>" />
<input type="hidden" name="ishtmled" value="<?=$ishtml?>" />
<input type="hidden" name="old_arrposid"value="<?=$arrposid?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
<tbody id="Tabs0" style="display:">
<tr>
<th colspan=2>基本信息</th>
</tr>
<tr> 
<td width="15%" class="tablerow">所属栏目</td>
<td class="tablerow"><font color="#FF0000"><?=$CAT['catname']?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="blue">Tips:</font><a href="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&action=move&movetype=1&movieids=<?=$movieid?>&referer=<?=urlencode("?mod=$mod&file=$file&action=edit&catid=$catid&movieid=$movieid&channelid=$channelid")?>">如果需要改变所属栏目，请点这里...</td>
</tr>
<tr> 
<td width="15%" class="tablerow">地区</td>
<td class="tablerow"><?=$type_select?></td>
</tr>
<tr> 
<td width="15%" class="tablerow">播放器</td>
<td class="tablerow">
<table width="40%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td><span style="display:<?if($autoselect) echo 'none';?>" id="autoselect"><?=$player_select?></span></TD>
	<td><input name="movie[autoselect]" type="radio"  value="1"  <?if($autoselect) echo 'checked';?> onclick="$('autoselect').style.display='none'"/> 自动
<input name="movie[autoselect]" type="radio"  value="0" <?if(!$autoselect) echo 'checked';?> onclick="$('autoselect').style.display='block'"/> 手动</td>
</tr>
</table>
</td>
</tr>
<tr> 
<td class="tablerow">标题 <font color="#FF0000">*</font></td>
<td class="tablerow"> <input name="movie[title]" type="text" id="title" size="44" maxlength="100" class="inputtitle" value="<?=$title?>" onBlur="segment_word(this);"> <?=$style_edit?> <input type="button" value="检查同名标题" onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checktitle&channelid=<?=$channelid?>&title='+$('title').value+'','','300','40','no')" style="width:90px;"></td>
</tr>
<tr> 
<td width="15%" class="tablerow">开头字母</td>
<td class="tablerow"><input name="movie[letter]" type="text" id="letter" size="5" value="<?=$letter?>"> 程序会自动添加标题的第一个字符</td>
</tr>
<tr <?php if(!$MOD['keywords_show']){ ?>style="display:none"<?php } ?>> 
<td class="tablerow">关键字</td>
<td class="tablerow"><input name="movie[keywords]" type="text" id="keywords" size="40" title="提示:多个关键字请用半角逗号“,”或空格隔开" onblur="doKeywords(this);" value="<?=$keywords?>">
<?=$keywords_select?>
<input type="checkbox" name="addkeywords" value="1" <?php if($MOD['keywords_add']){ ?>checked<?php } ?>> 添加至关键字列表中 =&gt;<a href="###" onclick="SelectKeywords();">更多关键字</a></td>
</tr>

<tr> 
<td class="tablerow">观看方式</td>
<td class="tablerow">
<input type="checkbox" name="movie[onlineview]" value="1" <?if($onlineview) echo 'checked';?>> 在线播放
<input type="checkbox" name="movie[allowdown]" value="1" <?if($allowdown) echo 'checked';?>> 允许下载

</td>
</tr>
<tr> 
<td class="tablerow">连载状态</td>
<td class="tablerow">
<input name="movie[serialization]" type="radio"  value="0" <?if(!$serialization) echo 'checked';?>/> 连载中
<input name="movie[serialization]" type="radio"  value="1" <?if($serialization) echo 'checked';?>/> 连载完成
</td>
</tr>
<tr> 
<td class="tablerow">大缩略图</td>
<td class="tablerow"><input name="movie[bigthumb]" type="text" id="bigthumb" size="58" value="<?=$bigthumb?>">  <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&channelid=<?=$channelid?>&uploadtext=bigthumb&type=thumb&width=<?=$MOD['bigthumb_width']?>&height=<?=$MOD['bigthumb_height']?>','upload_bigthumb','350','350')">
<input name="fromuploadbig" type="button" id="fromuploadbig" value="从已经上传的图片中选择" onclick="SelectBigPic()" style="width:150px;"/>
<input name="cutpic" type="button" id="cutBigpic" value="裁剪图片" onclick="CutBigPic()"/>
</td>
</tr>
<tr> 
<td class="tablerow">小缩略图</td>
<td class="tablerow"><input name="movie[thumb]" type="text" id="thumb" size="58" value="<?=$thumb?>">  <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&channelid=<?=$channelid?>&uploadtext=thumb&type=thumb&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload_thumb','350','350')">
<input name="fromupload" type="button" id="fromupload" value="从已经上传的图片中选择" onclick="SelectPic()" style="width:150px;"/>
<input name="cutpic" type="button" id="cutpic" value="裁剪图片" onclick="CutPic()"/>
</td>
</tr>
<tr> 
<td class="tablerow">影片服务器</td>
<td class="tablerow">
<?=$server_select?>
</td>
</tr>
<tr> 
<td class="tablerow">播放地址</td>
<td class="tablerow">
<input name="pc_movieieurl" type="text" class="Input" id="pc_movieieurl" size="35" />
开始集数：
<input name="num" type="text" class="Input" id="num" value="<?=$editEndnum?>" size="4" />
结束
<label>
<input name="enum" type="text" class="Input" id="endnum" value="<?=$editEndnum?>" size="4">
</label>
节目格式：
<input name="pc_vodie" type="text" class="Input" id="pc_vodie" value=".<?=$MOD['extension']?>" size="6" />
<input name="Submit2" type="button" class="Button" onClick="setid();" value="设定" />
</td>
</tr>
<tr> 
<td class="tablerow"></td>
<td class="tablerow"><?=$movieUrlEdit?>
</td>
</tr>
<tr> 
<td class="tablerow"></td>
<td class="tablerow" id="upid">
</td>
</tr>
<tr> 
<td class="tablerow">简介</td>
<td class="tablerow">
<table width="100%"  border="0" cellpadding="0" cellspacing="2">
<tr>
<td valign="top">
<textarea name="movie[introduce]" id="introduce" cols="100" rows="25"><?=$introduce?></textarea> <?=editor("introduce", $MOD['editor_mode'],$MOD['editor_width'],$MOD['editor_height'])?>
</td>
</tr>
</table>
</td>
</tr>
<tr> 
      <td class="tablerow">转向链接</td>
      <td class="tablerow">
       <input type="text" name="movie[linkurl]" id="linkurl"  size="50" maxlength="255"<? if(!$islink) { ?>disabled<? } ?> value="<? if($islink) { ?><?=$linkurl?><? } ?>"><input name="movie[islink]" type="checkbox" id="islink" value="1" onclick="ruselinkurl();" <? if($islink) { ?>checked<? } ?>><font color="#FF0000">转向链接</font>
	   <br/><font color="#FF0000">如果使用转向链接则点击标题就直接跳转而内容设置无效</font>
     </td>
    </tr>
  <tr> 
      <td class="tablerow">推荐位置</td>
      <td class="tablerow">
	<?=$position?>
      </td>
	  </tr>
    <tr> 
      <td class="tablerow">添加到自由调用</td>
      <td class="tablerow"><?=freelink_select('freelink', '请选择调用类型')?></td>
	</tr>
	    	<tr>
	  <td class="tablerow">评分等级</td>
	  <td class="tablerow">
	  <select name="movie[stars]" id="stars">
          <option value="5" <?php if($stars==5) echo 'selected="selected"'; ?> >★★★★★</option>
          <option value="4" <?php if($stars==4) echo 'selected="selected"'; ?> >★★★★</option>
          <option value="3" <?php if($stars==3) echo 'selected="selected"'; ?> >★★★</option>
          <option value="2" <?php if($stars==2) echo 'selected="selected"'; ?> >★★</option>
          <option value="1" <?php if($stars==1) echo 'selected="selected"'; ?> >★</option>
      </select>	  </td>
    </tr>

<tr> 
      <td class="tablerow">影片状态</td>
      <td class="tablerow">

<?if($status==3){?>
<input name="movie[status]" type="radio" value="3" checked> 已通过&nbsp;
<input name="movie[status]" type="radio" value="1" disabled> 待审核&nbsp;
<input name="movie[status]" type="radio" value="0" disabled> 草稿&nbsp;
<input name="movie[status]" type="radio" value="2" disabled> 退槁&nbsp;
<? } else {?>
<input name="movie[status]" type="radio" value="3" disabled> 已通过&nbsp;
<input name="movie[status]" type="radio" value="1" <?if($status==1){?>checked<?}?>> 待审核&nbsp;
<input name="movie[status]" type="radio" value="0" <?if($status==0){?>checked<?}?>> 草稿&nbsp;
<input name="movie[status]" type="radio" value="2" <?if($status==2){?>checked<?}?>> 退槁&nbsp;
<?}?>
	  
	  </td>
	  </tr>
<tr> 
<td class="tablerowhighlight"> </td>
<td class="tablerowhighlight">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?mod=phpcms&file=field&channelid=<?=$channelid?>&tablename=<?=channel_table('movie', $channelid)?>" target="_blank">自定义选项 进入管理</a></td>
</tr>
<?=$fields?>
</tbody>

<tbody id="Tabs1" style="display:none">
<tr>
<th colspan=2>高级设置</th>
</tr>

<tr> 
<td width="15%" class="tablerow">添加日期</td>
<td class="tablerow"><?=date_select('movie[addtime]', $addtime,'%Y-%m-%d %H:%M:%S')?></td>
</tr>
  <tr> 
      <td class="tablerow">是否生成</td>
      <td class="tablerow"><input type="radio" name="movie[ishtml]" value="1" <?php if($ishtml==1) {?>checked <?php } ?>  onclick="$('htmlrule').style.display='';$('htmldir').style.display='';$('htmlprefix').style.display='';$('phprule').style.display='none';"> 是 <input type="radio" name="movie[ishtml]" value="0" <?php if($ishtml==0) {?>checked <?php } ?> onclick="$('htmlrule').style.display='none';$('htmldir').style.display='none';$('htmlprefix').style.display='none';$('phprule').style.display='';"> 否</td>
    </tr>
	
		<tr id="htmldir" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件生成目录</td>
		  <td class="tablerow"><input type="text" name="movie[htmldir]" value="<?=$htmldir?>" id="htmldir" ></td>
		</tr>

		<tr id="htmlprefix" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件名前缀</td>
		  <td class="tablerow"><input type="text" name="movie[prefix]" id="prefix" value="<?=$prefix?>"></td>
		</tr>
		<tr id="htmlrule" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">url规则（生成html）</td>
		  <td class="tablerow"><?=$html_urlrule?></td>
		</tr>
		<tr id="phprule" style="display:<?php if($ishtml==1) {?>none<?php }?>"> 
		  <td class="tablerow">url规则（不生成html）</td>
		  <td class="tablerow"><?=$php_urlrule?></td>
		</tr>
    <tr> 
      <td class="tablerow">选择模板</td>
      <td class="tablerow"><?=$showtpl?></td>
    </tr>
	<tr> 
      <td class="tablerow">选择风格</td>
      <td class="tablerow"><?=$showskin?></td>
    </tr>
</tbody>


<tbody id="Tabs2" style="display:none">
  <tr>
    <th colspan=2>权限与收费</th>
  </tr>
    <tr>
      <td width="15%" class="tablerow" >允许查看的会员组</td>
      <td class="tablerow"><?=$showgroup?></td>
    </tr>
    <tr>
      <td class="tablerow" >阅读所需点数</td>
      <td class="tablerow">&nbsp;<input size="5" name="movie[readpoint]" type="input" value="<?=$readpoint?>" /> 点</td>
    </tr>

</tbody>

</table>
<table width="100%" height="40" align="center" cellpadding="2" cellspacing="1" >
  <tr>
    <td width="15%">
	</td>
    <td>
	<input type="submit" value=" 确定 " />
	&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" value=" 清除 " />
	</td>
  </tr>
</table>
  </form>
</body>
</html>