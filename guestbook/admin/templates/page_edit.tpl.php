<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<?=$menu?>
<script type="text/javascript">
function doCheck(){
	if ($('title').value=='') {
	alert("请输入标题");
	$('title').focus();
	return false;
	}
}
function ruselinkurl(){
	if($('uselinkurl').checked==true){
		$('linkurl').style.display='';
		$('page').style.display='none';
	}else{
		$('linkurl').style.display='none';
		$('page').style.display='';
	}
}
</script>

<body onload="ruselinkurl();">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan="2">单网页</th>
  </tr>
  <form name="myform" id="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&keyid=<?=$keyid?>" onsubmit="return doCheck();">
  <input type="hidden" name="pageid" value="<?=$pageid?>">
  <input type="hidden" name="passed" value="<?=$passed?>">
  <input type="hidden" name="oldpath" value="<?=$filepath?>">
    <tr> 
      <td width="20%" class="tablerow"><b>标题</b><font color="red">*</font></td>
      <td width="80%" class="tablerow">
	  <input name="title" type="text" size="60" id="title" value="<?=$title?>">
	  <input name='uselinkurl' type='checkbox' id='uselinkurl' value='1' onclick='ruselinkurl();' <?php if($linkurl) { ?>checked<?php } ?>><font color='#FF0000'>转向链接</font>
	  </td>
    </tr>
	 <tr style="display:none" id="linkurl" > 
      <td class="tablerow"><b>转向链接</b></td>
      <td class="tablerow"><input name="linkurl" type="text" size="60" value="<?=$linkurl?>"> </td>
    </tr>

	<tbody id="page">
    <tr> 
      <td class="tablerow"><b>网页内容</b><font color="red">*</font></td>
      <td class="tablerow">
        <textarea name="content" id="content" style="display:none"><?=$content?></textarea>
		<?=editor('content', 'phpcms', 550, 400)?>
      </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>存放路径</b><font color="red">*</font><br>例如:about/ </td>
      <td class="tablerow"><input name="fpath" type="text" size="60" value="<?=$fpath?>"><br>如果不设置则系统默认生成到网站根目录page/目录下 ， 注意以"/"结尾</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>文件名</b><font color="red">*</font><br>例如:about.html</td>
      <td class="tablerow"><input name="fname" type="text" size="60" value="<?=$fname?>"><br>如果不设置则系统以按ID生成类似page_3.html的文件，文件名必须是英文、数字和下划线的组合。</td>
    </tr>
    <tr title="将显示到浏览器标题栏，所有搜索引擎均重视此项内容,如果不设置则系统以标题代替此项"> 
      <td class="tablerow"><b>SEO标题</b></td>
      <td class="tablerow"><input name="seo_title" type="text" size="60" value="<?=$seo_title?>"></td>
    </tr>
    <tr title="不显示，部分搜索引擎重视此项内容,如果不设置则系统以网站关键词代替此项"> 
      <td class="tablerow"><b>SEO关键词</b></td>
      <td class="tablerow"><input name="seo_keywords" type="text" size="60"  value="<?=$seo_keywords?>"></td>
    </tr>
    <tr title="不显示，GOOGLE搜索重视此项内容,如果不设置则系统以网站描述代替此项"> 
      <td class="tablerow"><b>SEO描述</b></td>
      <td class="tablerow"><input name="seo_description" type="text" size="60"  value="<?=$seo_description?>"><br></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>网页模板</b></td>
      <td class="tablerow"><?=$showtpl?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选中模板" onclick="window.location='?mod=phpcms&file=template&channelid=<?=$channelid?>&action=edit&templateid='+myform.templateid.value+'&module=<?=$mod?>&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
     </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>网页风格</b></td>
      <td class="tablerow"><?=$showskin?></td>
    </tr>
	</tbody>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
        <input type="submit" name="dosubmit" value=" 确定 " > &nbsp;
        <input type="reset" name="Reset" value=" 清除 ">
      </td>
    </tr>
  </form>
</table>
</body>
</html> 