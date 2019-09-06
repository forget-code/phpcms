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

<?=$menu?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/MyCalendar.js"></script> 
<script language = 'JavaScript'>
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
// 表单提交检测
function doCheck(){

// 检测表单的有效性
// 如：标题不能为空，内容不能为空，等等....
        if (document.myform.catid.value=='0'){
            alert('指定的栏目不允许添加文章！只允许在其子栏目中添加文章。');
            document.myform.catid.focus();
            return false;
        }
		if (myform.title.value=="") {
		    alert("请输入标题");
			document.myform.title.focus();
		    return false;
		}
}

function SelectPic(){
  var arr=showModalDialog('?mod=phpcms&file=file_select&channelid=<?=$channelid?>&type=thumb', '', 'dialogWidth:820px; dialogHeight:600px; help: no; scroll: yes; status: no');
  if(arr!=null){
    var ss=arr.split('|');
    document.myform.thumb.value=ss[0];
  }
}
</script>

<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本信息</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>权限与收费</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>高级设置</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>自定义选项</td>
<td>&nbsp;</td>
</tr>
</table>

<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>&articleid=<?=$articleid?>&submit=1&referer=<?=$referer?>" method="post" name="myform" onsubmit="return doCheck();">

<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id='Tabs0' style='display:'>
  <tr>
    <th colspan=2>基本信息</th>
  </tr>
    <tr> 
      <td width="15%" class="tablerow">所属栏目</td>
      <td class="tablerow">
		<?=$cat_select?>
		<font color='#FF0000'>*</font>
	</td>
    </tr>
    <tr> 
      <td class="tablerow">所属专题</td>
      <td class="tablerow"><?=$special_select?></td>
    </tr>
    <tr> 
      <td class="tablerow">标题</td>
      <td class="tablerow">
<select name='includepic'>
<option value='0' >[类别]</option>
<option value='1' >[图文]</option>
<option value='2' >[组图]</option>
<option value='3' >[推荐]</option>
<option value='4' >[注意]</option>
</select>
                 <input name='title' type='text' id='title' value='<?=$article[title]?>' size='44' maxlength='100' class='inputtitle'>
                 <font color='#FF0000'>*</font>
              <?=$color_select?>
              <?=$fonttype_select?>
			  <input type="button" value="检查是否有同名标题" onclick="openwinx('?mod=<?=$mod?>&file=<?=$file?>&action=checktitle&channelid=<?=$channelid?>&title='+document.myform.title.value+'','检查是否有同名标题','300','80')"> 

    </td>
    </tr>
     <tr> 
      <td class="tablerow">标题图片</td>
      <td class="tablerow"><input name='thumb' type='text' id='thumb' size='45'>  <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=phpcms&file=uppic&channelid=<?=$channelid?>&uploadtext=thumb&action=thumb&type=thumb&width=150&height=150','upload','350','350')">
	   <input name="fromupload" type="button" id="fromupload" value=" 从已经上传的图片中选择 " onclick='SelectPic()'/>
	  <br/>如果设置标题图片，则可以在首页以及栏目页以图片方式链接到文章
      </td>
    </tr>
    <tr> 
      <td class="tablerow">关键词</td>
      <td class="tablerow"><input name="keywords" type="text" id="keywords" size="40" title='提示;多个关键词请用半角逗号“,”隔开'>
		<?=$keyword_select?>
		<input type="checkbox" name="addkeywords" value="1" checked> 添加至关键字列表中 =&gt;<a href="#" onclick="openwinx('?mod=phpcms&file=keywords&action=manage&channelid=<?=$channelid?>','关键字管理','720','500')">关键字管理</a></td>
    </tr>

    <tr> 
      <td class="tablerow">作者</td>
      <td class="tablerow"><input name='author' type='text' id='author' size='40' maxlength='30' value='<?=$_username?>'>
	  <?=$author_select?>
		<input type="checkbox" name="addauthors" value="1" checked> 添加至作者列表中
		=&gt;<a href="#" onclick="openwinx('?mod=phpcms&file=author&action=manage&channelid=<?=$channelid?>','作者管理','720','500')">作者管理</a>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow">来源名称</td>
      <td class="tablerow">
		<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
		<td><input name='copyfromname' type='text' id='copyfromname' value='<?=$article[copyfromname]?>' size='15' maxlength='50'></td>
		<td class="tablerow">地址
		<input name='copyfromurl' type='text' id='copyfromurl'  value='<?=$article[copyfromurl]?>' size='20' maxlength='200'>
		<?=$copyfrom_select?>
		<input type="checkbox" name="addcopyfroms" value="1" checked> 添加至来源列表中
		=&gt;<a href="#" onclick="openwinx('?mod=phpcms&file=copyfrom&action=manage&channelid=<?=$channelid?>','来源管理','720','500')">来源管理</a></td></tr>
		</table>
		</td>
    </tr>

    <tr> 
      <td class="tablerow">文章内容<br/><br/><br/><input name='is_saveremotefiles' type='checkbox' id='is_saveremotefiles' value='1'>保存远程图片<br/><font color="red">自动下载内容中的远程图片</font></td>
      <td class="tablerow">

	  <table width='100%' height="350" border='0' cellpadding='0' cellspacing='2'>
	  <tr>
	  <td valign="top">
        <textarea name="content"></textarea>
    </td>
</tr>
</table>

   </td>
    </tr>
    <tr> 
      <td class="tablerow">分页方式 </td>
      <td class="tablerow">
            <select name='paginationtype' id='paginationtype' onchange="if(this.value==1)paginationtype1.style.display=''; else paginationtype1.style.display='none';">
                <option value='0'>不分页</option>
                <option value='1'>自动分页</option>
                <option value='2'>手动分页</option>
            </select>
&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color="#0000FF">注：</font></strong><font color="#0000FF">手动分页符标记为“</font> [next] <font color="#0000FF">”，注意大小写</font>
   </td>
    </tr>
    <tr id='paginationtype1' style="display:none"> 
      <td class="tablerow"></td>
      <td class="tablerow">
自动分页时的每页大约字符数（包含HTML标记）<strong> <input name='maxcharperpage' type='text' id='maxcharperpage' value='10000' size='8' maxlength='8'></strong>
   </td>
    </tr>
    <tr> 
      <td class="tablerow">文章性质</td>
      <td class="tablerow">
<input name='ontop' type='checkbox' id='ontop' value='1' >固顶文章&nbsp;&nbsp;
<input name='elite' type='checkbox' id='elite' value='1' >推荐文章&nbsp;&nbsp;
评分等级
	  <select name="stars" id="stars">
          <option value="5">★★★★★</option>
          <option value="4">★★★★</option>
          <option value="3">★★★</option>
          <option value="2">★★</option>
          <option value="1">★</option>
          <option value="0" selected>无</option>
      </select>
   </td>
    </tr>
    <tr> 
      <td class="tablerow">文章状态</td>
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
      <td class="tablerow" >阅读所需点数</td>
      <td class="tablerow">&nbsp;<input size=5 name="readpoint" type=text> 点</td>
    </tr>

</tbody>
<tbody id='Tabs2' style='display:none'>
  <tr>
    <th colspan=2>高级设置</th>
  </tr>
<tr> 
      <td class="tablerow">标题</td>
      <td width="90%" class="tablerow">
<table width='100%' border='0' cellpadding='0' cellspacing='2'>
<tr>
<td width='64'>完整标题</td>
<td class="tablerow"><input name='titleintact' type='text' id='titleintact' size='80' maxlength='255'></td>
</tr>
<tr>
<td width='64'>副 标 题</td>
<td class="tablerow"><input name='subheading' type='text' id='subheading' size='80' maxlength='255'></td>
</tr>
<tr>
<td class="tablerow">&nbsp;</td>
<td class="tablerow"><input name='showcommentlink' type='checkbox' id='showcommentlink' value='1'>显示文章列表时在标题旁显示评论链接</td>
</tr>
</table>
    </td>
    </tr>
    <tr> 
      <td class="tablerow">内容摘要</td>
      <td class="tablerow">
    <textarea name="description" cols="70" rows="5"></textarea>
    </td>
    </tr>
	<tr> 
      <td class="tablerow">添加日期</td>
      <td class="tablerow"><script language=javascript>var dateFrom=new MyCalendar("addtime","<?=$today?>","选择,年,月,日,上一年,下一年,上个月,下个月,一,二,三,四,五,六"); dateFrom.display();</script>&nbsp;格式：yyyy-mm-dd</td>
    </tr>
    <tr> 
      <td class="tablerow">转向链接</td>
      <td class="tablerow">
       <input type='text' name='linkurl' id='linkurl' value='<? if($linkurl=='') { ?>http://<? } else { ?><?=$linkurl?><? } ?>' size='50' maxlength='255' <? if($linkurl=='') { ?>disabled<? } ?>><input name='uselinkurl' type='checkbox' id='uselinkurl' value='1' onClick='ruselinkurl();' <? if($linkurl!='') { ?>checked<? } ?>><font color='#FF0000'>转向链接</font>
	   <br/><font color='#FF0000'>如果使用转向链接则点击标题就直接跳转而内容设置无效</font>
     </td>
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

<tbody id='Tabs3' style='display:none'>
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
	<input type="submit" name="Submit" id="Submit" value=" 确定 " />
	&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="Reset" id="Reset" value=" 清除 " />
	</td>
  </tr>
</table>
  </form>
</body>
</html>