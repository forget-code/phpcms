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

function SelectFile(){
  var arr=Dialog('?mod=phpcms&file=file_select&channelid=<?=$channelid?>&type=file','',820,600);
  if(arr!=null){
    var s=arr.split('|');
	var ss = $("downurls").value == '' ? '' : "\n";
	$('downurls').value += ss+'下载地址|'+s[0];
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
</script>

<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">下载首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&catid=<?=$catid?>&channelid=<?=$channelid?>">添加下载</a> &gt;&gt; <?=$CAT['catname']?> &gt;&gt; </td>
    <td class="tablerow" align="right">	  
	<?php if($mode){ ?>
	  <input type="button"  onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>&catid=<?=$catid?>&mode=0';" value="切换到普通模式">
	  <?php } else { ?>
	  <input type="button"  onclick="window.location='?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>&catid=<?=$catid?>&mode=1';" value="切换到镜像模式">
	  <?php } ?>&nbsp;&nbsp;<?php echo $category_jump; ?></td>
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

<form action="?mod=<?=$mod?>&file=<?=$file?>&action=add&channelid=<?=$channelid?>&catid=<?=$catid?>&mode=<?=$mode?>&dosubmit=1" method="post" name="myform" onsubmit="return doCheck();">
<input type="hidden" name="down[catid]" value="<?=$catid?>" />
<input type="hidden" name="down[username]" value="<?=$_username?>" />
<input type="hidden" name="down[mode]" value="<?=$mode?>" />
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id="Tabs0" style="display:">
  <tr>
    <th colspan=2>基本信息</th>
  </tr>
    <tr> 
      <td width="15%" class="tablerow">所属栏目</td>
      <td class="tablerow"><font color="#FF0000"><?=$CAT['catname']?></font></td>
    </tr>

	

    <tr> 
      <td class="tablerow">标题 <font color="#FF0000">*</font></td>
      <td class="tablerow"><?=$type_select?> <input name="down[title]" type="text" id="title" size="44" maxlength="100" class="inputtitle"> <?=$style_edit?> <input type="button" value="检查同名标题" onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checktitle&channelid=<?=$channelid?>&title='+$('title').value+'','','300','40','no')" style="width:90px;"></td>
    </tr>
    <tr <?php if(!$MOD['keywords_show']){ ?>style="display:none"<?php } ?>> 
      <td class="tablerow">关键字</td>
      <td class="tablerow"><input name="down[keywords]" type="text" id="keywords" size="40" title="提示;多个关键字请用半角逗号“,”隔开">
		<?=$keywords_select?>
		<input type="checkbox" name="addkeywords" value="1" <?php if($MOD['keywords_add']){ ?>checked<?php } ?>> 添加至关键字列表中 =&gt;<a href="###" onclick="SelectKeywords();">更多关键字</a></td>
    </tr>

    <tr> 
      <td class="tablerow">作者/厂商</td>
      <td class="tablerow">
	  <input name="down[author]" type="text" id="author" size="20">
	  官方主页：<input name="down[homepage]" type="text" id="homepage" size="40" value="http://www.">
		
	  </td>
    </tr>

    <tr> 
      <td class="tablerow">简介</td>
      <td class="tablerow">

	  <table width="100%"  border="0" cellpadding="0" cellspacing="2">
	  <tr>
	  <td valign="top">
        <textarea name="down[introduce]" id="content" cols="100" rows="25"></textarea> <?=editor("content", $MOD['editor_mode'],$MOD['editor_width'],$MOD['editor_height'])?>
    </td>
</tr>
</table>

   </td>
 </tr> 
     <tr> 
      <td class="tablerow">缩略图</td>
      <td class="tablerow"><input name="down[thumb]" type="text" id="thumb" size="58">  <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&channelid=<?=$channelid?>&uploadtext=thumb&type=thumb&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload_thumb','350','350')">
	   <input name="fromupload" type="button" id="fromupload" value="从已经上传的图片中选择" onclick="SelectPic()" style="width:150px;"/>
      </td>
    </tr>


<?php if($mode){ ?>

	<tr>
	<td class="tablerow">下载地址 <font color="#FF0000">*</font></td>
	<td class="tablerow"><input name="down[downurls]" type="text" id="downurls" size="58">  <a href="?mod=<?=$mod?>&file=mirror_server&channelid=<?=$channelid?>" title="管理镜像服务器">相对于镜像服务器根目录的地址(开始不要加“/”)</a></td>
	</tr>

<?php } else { ?>

	<tr>
	<td class="tablerow">下载名称|地址 <font color="#FF0000">*</font><br/>
		<a href="###" onclick="clipboardData.setData('text','[d]');alert('[d]已经复制到您的剪切板，Ctrl+V粘贴到需要删除的地址末尾即可彻底删除该地址！');" title="不建议直接在编辑框删除，否则不能删除对应文件！&#10;如果您不慎上传错了文件，此功能将十分有用！&#10;点击复制[d]"><font color="blue">Tips：</font>如果需要彻底删除某个下载地址（包括文件），请在其后加标识符[d]</a></td>
	<td class="tablerow">
		<table cellpadding="0" cellspacing="1" width="100%">
		<tr>
		<td colspan="2"><font color="red">下载地址举例：</font>下载说明|下载地址 <a href="###" onclick="alert('PHPCMS简体中文版|http://soft.phpcms.cn/phpcms_gbk.zip\nPHPCMS繁体中文版|http://soft.phpcms.cn/phpcms_big5.zip\nPHPCMS一键安装包|http://soft.phpcms.cn/pc_server.exe');">一个下载文件占一行，点这里查看实例</a></td>
		</tr>
		<tr> 
		<td width="500"><textarea name="down[downurls]" cols="70" rows="6" id="downurls" style="width:500px;height:100px;overflow:visible;"></textarea></td>
		<td valign="top" style="light-height:22px;">
		<input type="button" value="从已上传文件中选择" style="width:150px;" onclick="SelectFile()"><br/><br/>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	<tr title="Tips:系统提供的上传功能只适合上传比较小的文件（2M以内）。如果软件比较大，请先使用FTP上传，而不要使用系统提供的上传功能，以免上传出错或过度占用服务器的CPU资源。">
	<td class="tablerow"><a href="?mod=<?=$mod?>&file=upload&channelid=<?=$channelid?>" target="upload">上传文件</a></td>
	<td class="tablerow">
	<iframe id="upload" name="upload" src="?mod=<?=$mod?>&file=upload&channelid=<?=$channelid?>" border="0" vspace="0" hspace="0" marginwidth="0" marginheight="0" framespacing="0" frameborder="0" scrolling="no" width="100%" height="50"></iframe>
	</td>
	</tr>
<?php } ?>


    <tr> 
      <td class="tablerow">文件大小</td>
      <td class="tablerow"><input name="down[filesize]" type="text" id="filesize" size="15"> <select name="filesizetype"><option value="0">单位</option><option value="B">B</option><option value="Kb" selected>Kb</option><option value="M">M</option><option value="G">G</option><option value="T">T</option></select> 如大小未知，请留空，如不选择单位，系统将自动计算</td>
	  </tr>
    <tr> 
      <td class="tablerow">推荐位置</td>
      <td class="tablerow"><?=$position?></td>
	  </tr>

	  	<tr>
	  <td class="tablerow">评分等级：</td>
	  <td class="tablerow">
	  <select name="down[stars]" id="stars">
          <option value="5">★★★★★</option>
          <option value="4">★★★★</option>
          <option value="3" selected>★★★</option>
          <option value="2">★★</option>
          <option value="1">★</option>
      </select>	  </td>
    </tr>

    <tr> 
      <td class="tablerow">下载状态</td>
      <td class="tablerow">

<input name="down[status]" type="radio" value="3" <?php if($_grade<4){?>checked<?php }else{ ?>disabled<?php } ?>> 已通过&nbsp;
<input name="down[status]" type="radio" value="1" <?php if($_grade==4){?>checked<?php } ?>> 待审核&nbsp;
<input name="down[status]" type="radio" value="0"> 草稿&nbsp;
	  
	  </td>
	  </tr>
    <tr> 
	  <td class="tablerowhighlight"> </td>
      <td class="tablerowhighlight">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?mod=phpcms&file=field&channelid=<?=$channelid?>&tablename=<?=channel_table('down', $channelid)?>">自定义选项 进入管理</a></td>
	  </tr>
<?=$fields?>
</tbody>

<tbody id="Tabs1" style="display:none">
  <tr>
    <th colspan=2>高级设置</th>
  </tr>

	<tr> 
      <td class="tablerow">添加日期</td>
      <td class="tablerow"><?=date_select('down[addtime]', $today)?>&nbsp;格式：yyyy-mm-dd</td>
    </tr>
    <tr> 
      <td class="tablerow">转向链接</td>
      <td class="tablerow">
       <input type="text" name="down[linkurl]" id="linkurl"  size="50" maxlength="255" disabled value="http://"><input name="down[islink]" type="checkbox" id="islink" value="1" onclick="ruselinkurl();" ><font color="#FF0000">转向链接</font>
	   <br/><font color="#FF0000">如果使用转向链接则点击标题就直接跳转而内容设置无效</font>
     </td>
    </tr>
	
    <tr> 
      <td class="tablerow">是否生成</td>
      <td class="tablerow"><input type="radio" name="down[ishtml]" value="1" <?php if($CAT['ishtml']==1) {?>checked <?php } ?>  onclick="$('htmlrule').style.display='';$('htmlprefix').style.display='';$('htmldir').style.display='';$('phprule').style.display='none';"> 是 <input type="radio" name="down[ishtml]" value="0" <?php if($CAT['ishtml']==0) {?>checked <?php } ?> onclick="$('htmlrule').style.display='none';$('htmldir').style.display='none';$('htmlprefix').style.display='none';$('phprule').style.display='';"> 否</td>
    </tr>
		<tr id="htmldir" style="display:<?php if($CAT['ishtml']==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件生成目录</td>
		  <td class="tablerow"><input type="text" name="down[htmldir]" value="<?=$CAT['item_htmldir']?>" id="htmldir" ></td>
		</tr>
		<tr id="htmlprefix" style="display:<?php if($CAT['ishtml']==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件名前缀</td>
		  <td class="tablerow"><input type="text" name="down[prefix]" id="prefix" value="<?=$CAT['item_prefix']?>"></td>
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
      <td class="tablerow">&nbsp;<input size="5" name="down[readpoint]" type="input" /> 点</td>
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