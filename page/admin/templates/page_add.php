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

<body>
<?=$menu?>
<script language=JavaScript>

// 表单提交检测
function doCheck(){

	// 检测表单的有效性
	// 如：标题不能为空，内容不能为空，等等....
	if (myform.title.value=="") {
	alert("请输入标题");
	return false;
	}
}
</script>

<script language = 'JavaScript'>
function ruselinkurl(){
  if(document.myform.uselinkurl.checked==true){
    document.myform.linkurl.disabled=false;
     page.style.display='none';
  }else{
    document.myform.linkurl.disabled=true;
    page.style.display='';
  }
}
</script>

<body>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>单网页</th>
  </tr>
  <form name="myform" id="myform" method="post" action="?mod=page&file=page&action=<?=$action?>&submit=1&channelid=<?=$channelid?>&pageid=<?=$pageid?>" onsubmit="return doCheck();">
    <tr> 
      <td width="30%" class="tablerow"><b>标题</b><font color="red">*</font></td>
      <td width="70%" class="tablerow"><input name="title" type="text" size="60" value="<?=$title?>"></td>
    </tr>
	 <tr> 
      <td width="30%" class="tablerow"><b>外部链接</b></td>
      <td width="70%" class="tablerow"><input name="linkurl" type="text" size="60" value="<?if(!$linkurl) {?>http://<? } else { ?><?=$linkurl?><? } ?>" <?if(!$linkurl) {?>disabled<?}?>><input name='uselinkurl' type='checkbox' id='uselinkurl' value='1' onClick='ruselinkurl();' <?if ($linkurl) { ?>checked<? } ?>><font color='#FF0000'>转向链接</font> </td>
    </tr>

	<tbody style="display:'<?=$display?>'" id="page">
    <tr> 
      <td class="tablerow"><b>网页内容</b><font color="red">*</font></td>
      <td class="tablerow">
        <textarea name="content" style="display:none"><?=$content?></textarea>
      </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>存放路径</b><font color="red">*</font><br>例如:about/ </td>
      <td class="tablerow"><input name="path" type="text" size="60" value="<?=$path?>"><br>如果不设置则系统默认生成到网站根目录page/目录下 ， 注意以"/"结尾</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>文件名</b><font color="red">*</font><br>例如:about.html</td>
      <td class="tablerow"><input name="filename" type="text" size="60" value="<?=$filename?>"><br>如果不设置则系统以按ID生成类似page_3.html的文件，文件名必须是英文、数字和下划线的组合。</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>网页标题</b><br>将显示到浏览器标题栏，所有搜索引擎均重视此项内容</td>
      <td class="tablerow"><input name="meta_title" type="text" size="60" value="<?=$meta_title?>"><br>如果不设置则系统以标题代替此项</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>网页关键词</b><br>不显示，部分搜索引擎重视此项内容</td>
      <td class="tablerow"><input name="meta_keywords" type="text" size="60" value="<?=$meta_keywords?>"><br>如果不设置则系统以网站关键词代替此项</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>网页描述</b><br>不显示，GOOGLE搜索重视此项内容</td>
      <td class="tablerow"><input name="meta_description" type="text" size="60" value="<?=$meta_description?>"><br>如果不设置则系统以网站描述代替此项</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>网页模板</b> 此网页套用的模板</td>
      <td class="tablerow"><?=$showtpl?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选中模板" onclick="window.location='?mod=phpcms&file=template&channelid=<?=$channelid?>&action=edit&templateid='+myform.templateid.value+'&module=<?=$mod?>&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
     </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>网页风格</b> 此网页套用的风格</td>
      <td class="tablerow"><?=$showskin?></td>
    </tr>
	</tbody>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
        <input type="submit" name="Submit" value=" 确定 " > &nbsp;
        <input type="reset" name="Reset" value=" 清除 ">
      </td>
    </tr>
  </form>
</table>
</body>
</html> 