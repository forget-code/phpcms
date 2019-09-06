<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>fckeditor/fckeditor.js"></script>
<script type="text/javascript">
	var editorBasePath = '<?=PHPCMS_PATH?>fckeditor/';
	var ChannelId = <?=$channelid?> ;
</script>

<script type="text/javascript">
window.onload = function()
{
	var oFCKeditor = new FCKeditor('content') ;
	oFCKeditor.BasePath	= editorBasePath ;
	oFCKeditor.ReplaceTextarea() ;
}
</script>

<script language="javascript" type="text/javascript">
function ruselinkurl(){
  if(document.myform.uselinkurl.checked==true){
    document.myform.linkurl.disabled=false;
  }else{
    document.myform.linkurl.disabled=true;
  }
}
//自动添加点数
function setff(catid)
{
	var arr=new Array();
	<?php echo $cats; ?>
	document.getElementById("readpoint").value=arr[catid];
}

function doCheck(){

// 检测表单的有效性
	if (document.myform.catid.value=='0'){
	alert('请选择栏目！');
	return false;
	}
	if (myform.title.value=="") {
	alert("请输入标题！");
	return false;
	}
    for(var i=0;i<document.myform.PictureUrl.length;i++){
      if (document.myform.pictureurls.value=='') document.myform.pictureurls.value=document.myform.PictureUrl.options[i].value;
      else document.myform.pictureurls.value+="\n"+document.myform.PictureUrl.options[i].value;
    }
}
</script>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<form action="?mod=picture&file=picture&action=<?=$action?>&pictureid=<?=$pictureid?>&submit=1&channelid=<?=$channelid?>" method="post" name="myform" onsubmit="return doCheck();">
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<input name="referer" type="hidden" value="<?=$referer?>" />
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本信息</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>权限与收费</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>高级设置</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>自定义选项</td>
<td>&nbsp;</td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" class="tableborder">
<!-- 基本信息 -->
<tbody id='Tabs0' style='display:'>
  <tr>
    <th colspan=2>基本信息</th>
  </tr>
    <tr> 
      <td class="tablerow">所属栏目 <font color='#FF0000'>*</font></td>
      <td class="tablerow">
		<?=$cat_select?>
	</td>
    </tr>
	
	<tr> 
      <td class="tablerow">所属专题</td>
      <td class="tablerow">
		<?=$special_select?>
	</td>
    </tr>

    <tr> 
      <td class="tablerow">标题 <font color='#FF0000'>*</font></td>
      <td width="90%" class="tablerow">
	  <input name='title' type='text' id='title' value='' size='44' maxlength='100' class='inputtitle'>
<?php
echo $titlefontcolor;
echo $fonttype; 
?>

 <input type="button" value="检查是否有同名标题" onclick="openwinx('?mod=picture&file=picture&action=checktitle&channelid=<?=$channelid?>&title='+document.myform.title.value+'','检查是否有同名标题','300','80')">
	 
     </td>
    </tr>
	
    <tr> 
      <td class="tablerow">关键词</td>
      <td class="tablerow">
	  <input name="keywords" type="text" id="keywords" size="45" value='' title='提示;多个关键词请用半角逗号“,”隔开'>
		<?=$keyword_select?>
		<input type="checkbox" name="addkeywords" value="1" checked> 添加所填关键字至关键字列表中 =&gt;<a href="#" onclick="openwinx('?mod=phpcms&file=keywords&action=manage&channelid=<?=$channelid?>','关键字管理','720','500')">关键字管理</a>
		</td>
    </tr>
	
    <tr> 
      <td class="tablerow">作者</td>
      <td class="tablerow">
	  <input name='author' type='text' id='author' value='' size='45' maxlength='30'>
	  <?=$author_select?>
		<input type="checkbox" name="addauthors" value="1"  checked> 添加所填作者至作者列表中
		=&gt;<a href="#" onclick="openwinx('?mod=phpcms&file=author&action=manage&channelid=<?=$channelid?>','作者管理','720','500')">作者管理</a>
	  </td>
    </tr>
	
    <tr> 
      <td class="tablerow">来源</td>
      <td class="tablerow">
		<table width='100%' border='0' cellpadding='0' cellspacing='0'>
      	<tr>
	  	<td class="tablerow">名称 
	  	<input name='copyfromname' type='text' id='copyfromname' value='' size='15' maxlength='50'>  
	  	</td>
	  	<td class="tablerow">地 址 
	  	<input name='copyfromurl' type='text' id='copyfromurl'  value='' size='30' maxlength='200'>
		<?=$copyfrom_select?>
		<input type="checkbox" name="addcopyfroms" value="1" checked> 添加所填来源至来源列表中
		=&gt;<a href="#" onclick="openwinx('?mod=phpcms&file=copyfrom&action=manage&channelid=<?=$channelid?>','来源管理','720','500')">来源管理</a>   
	  	</td>
	  	</tr>
		</table>
	  </td>
    </tr>
	
	<tr> 
      <td class="tablerow">图片介绍 <font color='#FF0000'>*</font></td>
      <td class="tablerow">	<textarea name="content" cols="70" rows="5"></textarea></td>
    </tr>
  <tr>
    <td class="tablerow">缩略图 <font color='#FF0000'>*</font></td>
    <td class="tablerow">
	<input name="thumb" type="text" id="thumb" size="50" value="<?php echo $thumb; ?>"/>
	<input type="button" name="uploadpic" type="button" id="uploadpic" value="上传图片" onclick="javascript:openwinx('?mod=phpcms&file=uppic&channelid=<?php echo $channelid; ?>&uploadtext=thumb&action=thumb&type=thumb&width=150&height=150','upload','350','350')"/>&nbsp;
    <input name="fromupload" type="button" id="fromupload" value=" 从已经上传的图片中选择 " onclick='SelectPic()'/>
	</td>
  </tr>
  <tr>
    <td class="tablerow">图片地址 <font color='#FF0000'>*</font></td>
    <td class="tablerow">
<table cellpadding='0' cellspacing='0' border='0' width='100%'>
<tr>
<td>
<input type="hidden" name="pictureurls">
<select id='PictureUrl' name='PictureUrl' style='width:400;height:100' size='2' ondblclick='return ModifyUrl();'></select>
</td>
<td>
<input type='button' name='Softselect' value='从已上传文件中选择' onclick='SelectFile()'><br><br>
<input type='button' name='addurl' value='添加外部地址' onclick='AddUrl();'><br>
<input type='button' name='modifyurl' value='修改当前地址' onclick='return ModifyUrl();'><br>
<input type='button' name='delurl' value='删除当前地址' onclick='DelUrl();'>
<script language = 'JavaScript'>
function SelectPic(){
  var arr=showModalDialog('?mod=phpcms&file=file_select&channelid=<?=$channelid?>&type=thumb', '', 'dialogWidth:820px; dialogHeight:600px; help: no; scroll: yes; status: no');
  if(arr!=null){
    var ss=arr.split('|');
    document.myform.thumb.value=ss[0];
  }
}
function SelectFile(){
  var arr=showModalDialog('?mod=phpcms&file=file_select&channelid=<?=$channelid?>&type=file', '', 'dialogWidth:820px; dialogHeight:600px; help: no; scroll: yes; status: no');
  if(arr!=null){
    var ss=arr.split('|');
    strSoftUrl=ss[0];
    var url='图片地址'+(document.myform.PictureUrl.length+1)+'|'+strSoftUrl;
    document.myform.PictureUrl.options[document.myform.PictureUrl.length]=new Option(url,url);
    document.myform.filesize.value=ss[1];
  }
}
function AddUrl(){
  var thisurl='图片地址'+(document.myform.PictureUrl.length+1)+'|http://'; 
  var url=prompt('请输入图片地址名称和链接，中间用“|”隔开：',thisurl);
  if(url!=null&&url!=''){document.myform.PictureUrl.options[document.myform.PictureUrl.length]=new Option(url,url);}
}
function ModifyUrl(){
  if(document.myform.PictureUrl.length==0) return false;
  var thisurl=document.myform.PictureUrl.value; 
  if (thisurl=='') {alert('请先选择一个图片地址，再点修改按钮！');return false;}
  var url=prompt('请输入图片地址名称和链接，中间用“|”隔开：',thisurl);
  if(url!=thisurl&&url!=null&&url!=''){document.myform.PictureUrl.options[document.myform.PictureUrl.selectedIndex]=new Option(url,url);}
}
function DelUrl(){
  if(document.myform.PictureUrl.length==0) return false;
  var thisurl=document.myform.PictureUrl.value; 
  if (thisurl=='') {alert('请先选择一个图片地址，再点删除按钮！');return false;}
  document.myform.PictureUrl.options[document.myform.PictureUrl.selectedIndex]=null;
}
</script>
</td>
</tr>
</table>
	</td>
  </tr>
  <tr>
    <td class="tablerow">上传图片</td>
    <td class="tablerow">
系统提供的上传功能只适合上传比较小的文件。如果软件比较大（2M以上），请先使用FTP上传，而不要使用系统提供的上传功能，以免上传出错或过度占用服务器的CPU资源。FTP上传后请点“添加外部地址”输入名称和图片地址。<br/>
<iframe id="upload" src="?mod=<?=$mod?>&file=upload&channelid=<?=$channelid?>" border="0" vspace="0" hspace="0" marginwidth="0" marginheight="0" framespacing="0" frameborder="0" scrolling="no" width="450" height="50"></iframe>
	</td>
  </tr>

    <tr> 
      <td class="tablerow">属性</td>
      <td class="tablerow">
<input name='ontop' type='checkbox' id='ontop' value='1' >
固顶&nbsp;&nbsp;&nbsp;&nbsp; 
<input name='elite' type='checkbox' id='elite' value='1' >
推荐&nbsp;&nbsp;&nbsp;&nbsp;
评分等级
<select name='stars' id='stars'>
	<option value='0' selected>无</option>
	<option value='5' >★★★★★</option>
	<option value='4' >★★★★</option>
	<option value='3' >★★★</option>
	<option value='2' >★★</option>
	<option value='1'>★</option>

</select>
   </td>
    </tr> 

	<tr> 
      <td class="tablerow">状态</td>
      <td class="tablerow">
<input name='status' type='radio' value='3' <?php if($_grade<4){?>checked<?php }else{ ?>disabled<?php } ?>> 已通过&nbsp;
<input name='status' type='radio' value='1' <?php if($_grade==4){?>checked<?php } ?>> 待审核&nbsp;
<input name='status' type='radio' value='0'> 草稿&nbsp;
<input name='status' type='radio' value='2'  disabled> 退槁&nbsp;
   </td>
    </tr> 	
</tbody>

<tbody id='Tabs1' style='display:none'>
  <tr>
    <th colspan=2>权限与收费</th>
  </tr>
    <tr>
      <td width='15%' class="tablerow" >允许查看的会员组</td>
      <td class="tablerow"><?=$showgroup?></td>
    </tr>

    <tr>
      <td width='300' class="tablerow" >阅读所需点数</td>
      <td class="tablerow">&nbsp;<input size=5 name="readpoint" type=text value="<?=$_CAT[defaultpoint]?>"> 点</td>
    </tr>
</tbody>

<tbody id='Tabs2' style='display:none'>
  <tr>
    <th colspan=2>高级设置</th>
  </tr>
	
	<tr> 
      <td width='15%' class="tablerow">选择风格</td>
      <td class="tablerow">
       <?=$showskin?>
   </td>
    </tr> 

	<tr> 
      <td class="tablerow">选择模板</td>
      <td class="tablerow">
       <?=$showtpl?>
   </td>
    </tr>
    <tr> 
      <td class="tablerow">转向链接</td>
      <td class="tablerow">
       <input type='text' name='linkurl' id='linkurl' value='<? if($linkurl=='') { ?>http://<? } else { ?><?=$linkurl?><? } ?>' size='50' maxlength='255' <? if($linkurl=='') { ?>disabled<? } ?>><input name='uselinkurl' type='checkbox' id='uselinkurl' value='1' onClick='ruselinkurl();' <? if($linkurl!='') { ?>checked<? } ?>><font color='#FF0000'>转向链接</font>
	   <br/><font color='#FF0000'>如果使用转向链接则点击标题就直接跳转而内容设置无效</font>
     </td>
    </tr>
</tbody>

<tbody id='Tabs3' style='display:none'>
  <tr>
    <th colspan=2>自定义选项</th>
  </tr>
<?=$fields?>
</tbody>
</table>
<table width="100%" height="40" align="center" cellpadding="2" cellspacing="1" >
  <tr>
    <td width="10%">
	</td>
    <td>
	<input type="hidden" name="referer" id="referer" value="<?=$referer?>" />
	<input type="submit" name="Submit" id="Submit" value=" 确定 " />
	&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="Reset" id="Reset" value=" 清除 " />
	</td>
  </tr>
</table>
  </form>
</body>
</html>