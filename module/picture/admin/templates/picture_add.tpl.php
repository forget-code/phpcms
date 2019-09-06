<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
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
function CutPic(){
  var thumb=$('thumb').value;
	if(thumb=='')
	{
		alert('请先上传标题图片');
		$('thumb').focus();
		return false;
	}
  var arr=Dialog('corpandresize/ui.php?<?=$PHPCMS[siteurl]?>'+thumb,'',700,500);
  if(arr!=null){
    $('thumb').value=arr;
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
function SelectAuthor(){	
  var s=Dialog('?mod=phpcms&file=author&keyid=<?=$channelid?>&select=1','',700,500);
  if(s!=null){
	$('author').value = s;
  }
  $('author').select();
}
function SelectCopyfrom(){	
  var s=Dialog('?mod=phpcms&file=copyfrom&keyid=<?=$channelid?>&select=1','',700,500);
  if(s!=null){
	$('copyfrom').value = s;
  }
  $('copyfrom').select();
}
function SelectFile(){
  var arr=Dialog('?mod=phpcms&file=file_select&channelid=<?=$channelid?>&type=thumb&realdir=<?=$MOD['upload_dir']?>','',820,600);
  if(arr!=null){
    var s=arr.split('|');
	var ss = $("pictureurls").value == '' ? '' : "\n";
	$('pictureurls').value += ss+'图片说明|'+s[0].replace(/<?=$PHPCMS['uploaddir']?>\/<?=$CHA['channeldir']?>\/<?=$MOD['upload_dir']?>\//g, '');
  }
}
function ShowPreview(){
	var obj = $('pictureurls');
	var r = document.selection.createRange();
	var s = "TMP";
	var rt = r.text;
	var rv = rt+s;
	r.text = rt+s;
	var i = obj.value.indexOf(rv);
	obj.value = obj.value.replace(s, '');
	obj.blur();
	var str;
	if(obj.value.indexOf("\r") == -1){
		str = "\n";
	}else{
		str = "\r\n";
	}
	var p = obj.value.substring(obj.value.lastIndexOf("|", i)+1, i)+obj.value.substring(i, obj.value.indexOf(str, i));
	var l = obj.value.substring(i, obj.value.length);
	if(l.indexOf("\n")==-1) p = obj.value.substring(obj.value.lastIndexOf("|", i)+1, i)+l;
	var u = <?php echo "'";echo imgurl($PHPCMS['uploaddir'].'/'.$CHA['channeldir'].'/'.$MOD['upload_dir'].'/');echo "'"; ?>;
	if(p.indexOf("://") != -1) u = '';
	var m = p.match(/^[^\r\n\|]+\.(jpg|gif|png|bmp)$/);
	if(m != null)
	{
		window.open(u+p);
	}
}
function doKeywords(ID)
{
	$(ID).value = $F(ID).replace(new RegExp('，',"gm"),',');
	$(ID).value = $F(ID).replace(new RegExp(' ',"gm"),',');
}
</script>
<?=segment_word()?>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">图片首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&catid=<?=$catid?>&channelid=<?=$channelid?>">添加图片</a> &gt;&gt; <?=$CAT['catname']?> &gt;&gt; </td>
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
<td id="TabTitle3" class="title1" onclick="ShowTabs(3)">自定义选项</td>
<td>&nbsp;</td>
</tr>
</table>

<form action="?mod=<?=$mod?>&file=<?=$file?>&action=add&channelid=<?=$channelid?>&dosubmit=1" method="post" name="myform" onsubmit="return doCheck();">
<input type="hidden" name="picture[username]" value="<?=$_username?>" />
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id="Tabs0" style="display:">
  <tr>
    <th colspan="2">基本信息</th>
  </tr>
    <tr> 
      <td width="15%" class="tablerow">所属栏目</td>
      <td class="tablerow"><?=$this_category?></td>
    </tr>
    <tr> 
      <td class="tablerow">标题 <font color="#FF0000">*</font></td>
      <td class="tablerow"><?=$type_select?> <input name="picture[title]" type="text" id="title" size="44" maxlength="100" class="inputtitle" onBlur="segment_word(this);"> <?=$style_edit?> <input type="button" value="检查同名标题" onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checktitle&channelid=<?=$channelid?>&title='+$('title').value+'','','300','40','no')" style="width:90px;"></td>
    </tr>
      <tr <?php if(!$MOD['keywords_show']){ ?>style="display:none"<?php } ?>> 
      <td class="tablerow">关键字</td>
      <td class="tablerow"><input name="picture[keywords]" type="text" id="keywords" size="40" title="提示:多个关键字请用半角逗号“,”或空格隔开" onblur="doKeywords(this);">
		<?=$keywords_select?>
		<input type="checkbox" name="addkeywords" value="1" <?php if($MOD['keywords_add']){ ?>checked<?php } ?>> 添加至关键字列表中 =&gt;<a href="###" onclick="SelectKeywords();">更多关键字</a></td>
    </tr>

    <tr <?php if(!$MOD['author_show']){ ?>style="display:none"<?php } ?>> 
      <td class="tablerow">作者</td>
      <td class="tablerow"><input name="picture[author]" type="text" id="author" size="40" maxlength="30">
	  <?=$author_select?>
		<input type="checkbox" name="addauthor" value="1" <?php if($MOD['author_add']){ ?>checked<?php } ?>> 添加至作者列表中
		=&gt;<a href="###" onclick="SelectAuthor();">更多作者</a>
	  </td>
    </tr>
    <tr <?php if(!$MOD['copyfrom_show']){ ?>style="display:none"<?php } ?>> 
      <td class="tablerow" >来源</td>
      <td class="tablerow"><input name="picture[copyfrom]" type="text" id="copyfrom" size="40">
		<?=$copyfrom_select?>
		<input type="checkbox" name="addcopyfrom" value="1" <?php if($MOD['copyfrom_add']){ ?>checked<?php } ?>> 添加至来源列表中
		=&gt;<a href="###" onclick="SelectCopyfrom();">更多来源</a></td>
    </tr>
    <tr> 
      <td class="tablerow">简介</td>
      <td class="tablerow">

	  <table width="100%"  border="0" cellpadding="0" cellspacing="2">
	  <tr>
	  <td valign="top">
        <textarea name="picture[introduce]" id="content" cols="100" rows="25"></textarea><?=editor("content", $MOD['editor_mode'],$MOD['editor_width'],$MOD['editor_height'])?>
    </td>
</tr>
</table>
   </td>
</tr>
     <tr> 
      <td class="tablerow">标题图片</td>
      <td class="tablerow"><input name="picture[thumb]" type="text" id="thumb" size="58">  <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&channelid=<?=$channelid?>&uploadtext=thumb&type=thumb&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload_thumb','350','350')">
	   <input name="fromupload" type="button" id="fromupload" value="从已经上传图片中选择" onclick="SelectPic()" style="width:150px;"/>
	   <input name="cutpic" type="button" id="cutpic" value="裁剪图片" onclick="CutPic()"/>
      </td>
    </tr>
	<tr>
	<td class="tablerow">图片名称|地址 <font color="#FF0000">*</font><br/>
		<a href="###" onclick="clipboardData.setData('text','[d]');alert('[d]已经复制到您的剪切板，Ctrl+V粘贴到需要删除的地址末尾即可彻底删除该地址！');" title="不建议直接在编辑框删除，否则不能删除对应图片！&#10;如果您不慎上传错了图片，此功能将十分有用！&#10;点击复制[d]"><font color="blue">Tips：</font>如果需要彻底删除某个图片地址（包括图片），请在其后加标识符[d]</a></td>
	<td class="tablerow">
		<table cellpadding="0" cellspacing="1" width="100%">
		<tr>
		<td colspan="2"><font color="red">图片地址举例：</font>图片说明|图片地址 <a href="###" onclick="alert('PHPCMS简体中文版|http://soft.phpcms.cn/phpcms_gbk.jpg\nPHPCMS繁体中文版|http://soft.phpcms.cn/phpcms_big5.jpg\nPHPCMS一键安装包|http://soft.phpcms.cn/pc_server.jpg\n\n提示:在图片名上双击鼠标可在新窗口中弹出图片！');">一个图片图片占一行，点这里查看实例</a></td>
		</tr>
		<tr>
		<td width="500"><textarea name="picture[pictureurls]" cols="70" rows="6" id="pictureurls" style="width:500px;height:100px;overflow:visible;" ondblclick="ShowPreview();" title="提示:如果您使用的是IE6+浏览器，在图片名上双击鼠标可在新窗口中弹出图片..."></textarea></td>
		<td valign="top" style="light-height:22px;">
		<input type="button" value="从已上传图片中选择" style="width:150px;" onclick="SelectFile()"><br/><br/>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	<tr title="Tips:系统提供的上传功能只适合上传比较小的图片（2M以内）。如果软件比较大，请先使用FTP上传，而不要使用系统提供的上传功能，以免上传出错或过度占用服务器的CPU资源。">
	<td class="tablerow"><a href="?mod=<?=$mod?>&file=upload&channelid=<?=$channelid?>" target="upload">上传图片</a></td>
	<td class="tablerow">
	<iframe id="uploads" name="uploads" src="?mod=<?=$mod?>&file=upload&channelid=<?=$channelid?>" border="0" vspace="0" hspace="0" marginwidth="0" marginheight="0" framespacing="0" frameborder="0" scrolling="no" width="100%" height="50"></iframe>
	</td>
	</tr>
<tr> 
      <td class="tablerow">转向链接</td>
      <td class="tablerow">
       <input type="text" name="picture[linkurl]" id="linkurl"  size="50" maxlength="255" disabled value="http://"><input name="picture[islink]" type="checkbox" id="islink" value="1" onclick="ruselinkurl();" ><font color="#FF0000">转向链接</font>
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
      <td class="tablerow">图片状态</td>
      <td class="tablerow">

<input name="picture[status]" type="radio" value="3" <?php if($_grade<4){?>checked<?php }else{ ?>disabled<?php } ?>> 已通过&nbsp;
<input name="picture[status]" type="radio" value="1" <?php if($_grade==4){?>checked<?php } ?>> 待审核&nbsp;
<input name="picture[status]" type="radio" value="0"> 草稿&nbsp;
<input name="picture[status]" type="radio" value="2"  disabled> 退槁&nbsp;
	  
	  </td>
	  </tr>
</tbody>

<tbody id="Tabs1" style="display:none">
  <tr>
    <th colspan=2>高级设置</th>
  </tr>

	<tr> 
      <td width="15%" class="tablerow">添加日期</td>
      <td class="tablerow"><?=date_select('picture[addtime]', $today,'%Y-%m-%d %H:%M:%S')?></td>
    </tr>
    <tr> 
      <td class="tablerow">是否生成</td>
      <td class="tablerow"><input type="radio" name="picture[ishtml]" value="1" <?php if($CAT['ishtml']==1) {?>checked <?php } ?>  onclick="$('htmlrule').style.display='';$('htmlprefix').style.display='';$('htmldir').style.display='';$('phprule').style.display='none';"> 是 <input type="radio" name="picture[ishtml]" value="0" <?php if($CAT['ishtml']==0) {?>checked <?php } ?> onclick="$('htmlrule').style.display='none';$('htmldir').style.display='none';$('htmlprefix').style.display='none';$('phprule').style.display='';"> 否</td>
    </tr>
		<tr id="htmldir" style="display:<?php if($CAT['ishtml']==0) {?>none<?php }?>"> 
		  <td class="tablerow">html图片生成目录</td>
		  <td class="tablerow"><input type="text" name="picture[htmldir]" value="<?=$CAT['item_htmldir']?>" id="htmldir" ></td>
		</tr>
		<tr id="htmlprefix" style="display:<?php if($CAT['ishtml']==0) {?>none<?php }?>"> 
		  <td class="tablerow">html图片名前缀</td>
		  <td class="tablerow"><input type="text" name="picture[prefix]" id="prefix" value="<?=$CAT['item_prefix']?>"></td>
		</tr>
		<tr id="htmlrule" style="display:<?php if($CAT['ishtml']==0) {?>none<?php }?>"> 
		  <td class="tablerow">url规则（生成html）</td>
		  <td class="tablerow"><?=$html_urlrule?></td>
		</tr>
		<tr id="phprule" style="display:<?php if($CAT['ishtml']==1) {?>none<?php }?>"> 
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
      <td class="tablerow">&nbsp;<input size="5" name="picture[readpoint]" type="input" value="<?=$CAT['defaultpoint']?>" /> 点</td>
    </tr>

</tbody>

<tbody id="Tabs3" style="display:none">
  <tr>
    <th colspan=2>自定义选项</th>
  </tr>
<?=$fields?>
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