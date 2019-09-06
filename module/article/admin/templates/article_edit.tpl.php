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
	<?php if($MOD['editor_mode']!='editor') echo "clipboardData.setData('text',FCKeditorAPI.GetInstance('content').GetXHTML());";?>

	return true;
}

function SelectPic(){
  var arr=Dialog('?mod=phpcms&file=file_select&channelid=<?=$channelid?>&type=thumb','',700,500);
  if(arr!=null){
    var s=arr.split('|');
    $('thumb').value=s[0];
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
function doKeywords(ID)
{
	$(ID).value = $F(ID).replace(new RegExp('，',"gm"),',');
	$(ID).value = $F(ID).replace(new RegExp(' ',"gm"),',');
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
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">文章首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&articleid=<?=$articleid?>&catid=<?=$catid?>&channelid=<?=$channelid?>">编辑文章</a> &gt;&gt; <?=$title?></td>
    <td class="tablerow" align="right"><?php echo $category_jump; ?></td>
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

<form action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&catid=<?=$catid?>&articleid=<?=$articleid?>&channelid=<?=$channelid?>&dosubmit=1" method="post" name="myform" onsubmit="return doCheck();">
<input type="hidden" name="referer" value="<?=$referer?>" />
<input type="hidden" name="article[catid]" value="<?=$catid?>" />
<input type="hidden" name="ishtmled" value="<?=$ishtml?>" />
<input type="hidden" name="old_arrposid"value="<?=$arrposid?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id="Tabs0" style="display:">
  <tr>
    <th colspan=2>基本信息</th>
  </tr>
    <tr> 
      <td width="19%" class="tablerow">所属栏目</td>
      <td class="tablerow"><font color="#FF0000"><?=$CAT['catname']?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="blue">Tips:</font><a href="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&action=move&movetype=1&articleids=<?=$articleid?>&referer=<?=urlencode("?mod=$mod&file=$file&action=edit&catid=$catid&articleid=$articleid&channelid=$channelid")?>">如果需要改变所属栏目，请点这里...</td>
    </tr>
    <tr> 
      <td class="tablerow">标题</td>
      <td class="tablerow"><?=$type_select?> <input name="article[title]" type="text" id="title" size="44" maxlength="100" class="inputtitle" value="<?=$title?>" onBlur="segment_word(this);"> <font color="#FF0000">*</font> <?=$style_edit?> <input type="button" value="检查同名标题" onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checktitle&channelid=<?=$channelid?>&title='+$('title').value+'','','300','40','no')" style="width:90px;"></td>
    </tr>


     <tr> 
      <td class="tablerow">标题图片</td>
      <td class="tablerow" title="如果设置标题图片，则可以在首页以及栏目页以图片方式链接到文章"><input name="article[thumb]" type="text" id="thumb" size="53" value="<?=$thumb?>">  <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&channelid=<?=$channelid?>&uploadtext=thumb&type=thumb&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','350','350')">
	   <input name="fromupload" type="button" id="fromupload" value="从已经上传的图片中选择" onclick="SelectPic()" style="width:150px;"/>
      </td>
    </tr>

	<tr <?php if(!$MOD['keywords_show']){ ?>style="display:none"<?php } ?>> 
      <td class="tablerow">关键字</td>
      <td class="tablerow"><input name="article[keywords]" type="text" id="keywords" size="40" value="<?=$keywords?>" title="提示:多个关键字请用半角逗号“,”或空格隔开" onblur="doKeywords(this);">
		<?=$keywords_select?>
		<input type="checkbox" name="addkeywords" value="1" <?php if($MOD['keywords_add']){ ?>checked<?php } ?>> 添加至关键字列表中 =&gt;<a href="###" onclick="SelectKeywords();">更多关键字</a></td>
    </tr>

 <tr <?php if(!$MOD['author_show']){ ?>style="display:none"<?php } ?>> 
      <td class="tablerow">作者</td>
      <td class="tablerow"><input name="article[author]" type="text" id="author" size="40" maxlength="30" value="<?=$author?>">
	  <?=$author_select?>
		<input type="checkbox" name="addauthor" value="1" <?php if($MOD['author_add']){ ?>checked<?php } ?>> 添加至作者列表中
		=&gt;<a href="###" onclick="SelectAuthor();">更多作者</a>
	  </td>
    </tr>
    <tr <?php if(!$MOD['copyfrom_show']){ ?>style="display:none"<?php } ?>> 
      <td class="tablerow" >来源</td>
      <td class="tablerow"><input name="article[copyfrom]" type="text" id="copyfrom" value="<?=$copyfrom?>" size="40">
		<?=$copyfrom_select?>
		<input type="checkbox" name="addcopyfrom" value="1" <?php if($MOD['copyfrom_add']){ ?>checked<?php } ?>> 添加至来源列表中
		=&gt;<a href="###" onclick="SelectCopyfrom();">更多来源</a></td>
    </tr>


    <tr> 
      <td class="tablerow" title="此项可在模块配置设置">文章内容<br/><br/><br/><input name="save_remotepic" type="checkbox"  value="1" >保存远程图片<br/><font color="red">自动下载内容中的远程图片</font><br/><br/>
	  <input name="add_introduce" type="checkbox"  value="1" >是否截取内容<br><input type="text" name="introcude_length" value="<?=$MOD['introcude_length']?>" size="3">字符至内容摘要
	   <br/><br/>
	  <input name="auto_thumb" type="checkbox"  value="1">是否获取内容第<br><input type="text" name="auto_thumb_no" value="1" size="1">张图片作为标题图片
	  </td>
      <td class="tablerow">

	  <table width="100%" border="0" cellpadding="0" cellspacing="2">
	  <tr>
	  <td valign="top">
        <textarea name="article[content]" id="content"  cols="100" rows="25"><?=$content?></textarea> <?=editor("content", $MOD['editor_mode'],$MOD['editor_width'],$MOD['editor_height'])?>
    </td>
</tr>
</table>

   </td>
    </tr>
    <tr> 
      <td class="tablerow">分页方式 </td>
      <td class="tablerow">
            <select name="article[paginationtype]" id="paginationtype" onchange="if(this.value==1)paginationtype1.style.display=''; else paginationtype1.style.display='none';">
                <option value="0" <? if($paginationtype==0) { ?>selected<? } ?>>不分页</option>
                <option value="1" <? if($paginationtype==1) { ?>selected<? } ?>>自动分页</option>
                <option value="2" <? if($paginationtype==2) { ?>selected<? } ?>>手动分页</option>
            </select>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="###" onclick="clipboardData.setData('text','[next]');alert('[next]已经复制到您的剪切板，Ctrl+V粘贴即可使用！');"><strong><font color="#0000FF">注：</font></strong><font color="#0000FF">手动分页符标记为“</font> [next] <font color="#0000FF">”，注意大小写，点击复制</font></a>
   </td>
    </tr>
    <tr id="paginationtype1" style="display:<? if($paginationtype!=1) { ?>none<? } ?>"> 
      <td class="tablerow"></td>
      <td class="tablerow">
自动分页时的每页大约字符数（包含HTML标记）<strong> <input name="article[maxcharperpage]" type="text" id="maxcharperpage" size="8" maxlength="8" value="<?=$maxcharperpage?>"></strong>
   </td>
    </tr>
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
      <td class="tablerow">文章状态</td>
      <td class="tablerow">

<?if($status==3){?>
<input name="article[status]" type="radio" value="3" checked> 已通过&nbsp;
<input name="article[status]" type="radio" value="1" disabled> 待审核&nbsp;
<input name="article[status]" type="radio" value="0" disabled> 草稿&nbsp;
<input name="article[status]" type="radio" value="2" disabled> 退槁&nbsp;
<? } else {?>
<input name="article[status]" type="radio" value="3" disabled> 已通过&nbsp;
<input name="article[status]" type="radio" value="1" <?if($status==1){?>checked<?}?>> 待审核&nbsp;
<input name="article[status]" type="radio" value="0" <?if($status==0){?>checked<?}?>> 草稿&nbsp;
<input name="article[status]" type="radio" value="2" <?if($status==2){?>checked<?}?>> 退槁&nbsp;
<?}?>
	  
	  </td>
	  </tr>
</tbody>

<tbody id="Tabs1" style="display:none">
  <tr>
    <th colspan=2>高级设置</th>
  </tr>
<tr> 
      <td width="18%" class="tablerow">标题</td>
      <td class="tablerow">
<table width="100%" border="0" cellpadding="0" cellspacing="2">
<tr>
<td width="64">完整标题</td>
<td class="tablerow"><input name="article[titleintact]" type="text" id="titleintact" size="80" maxlength="255" value="<?=$titleintact?>"></td>
</tr>
<tr>
<td width="64">副 标 题</td>
<td class="tablerow"><input name="article[subheading]" type="text" id="subheading" size="80" maxlength="255" value="<?=$subheading?>"></td>
</tr>
<tr>
<td class="tablerow">&nbsp;</td>
<td class="tablerow"><input name="article[showcommentlink]" type="checkbox" id="showcommentlink" value="1" <? if($showcommentlink) { ?>checked<? } ?>>显示文章列表时在标题旁显示评论链接</td>
</tr>
</table>
    </td>
    </tr>
    <tr> 
      <td class="tablerow">内容摘要</td>
      <td class="tablerow">
    <textarea name="article[introduce]" cols="70" rows="5"><?=$introduce?></textarea>
    </td>
    </tr>
	<tr> 
      <td class="tablerow">添加日期</td>
      <td class="tablerow"><?=date_select('article[addtime]', $addtime)?>&nbsp;格式：yyyy-mm-dd</td>
    </tr>
   <tr> 
      <td class="tablerow">转向链接</td>
      <td class="tablerow">
       <input type="text" name="article[linkurl]" id="linkurl"  size="50" maxlength="255"<? if(!$islink) { ?>disabled<? } ?> value="<? if($islink) { ?><?=$linkurl?><? } ?>"><input name="article[islink]" type="checkbox" id="islink" value="1" onclick="ruselinkurl();" <? if($islink) { ?>checked<? } ?>><font color="#FF0000">转向链接</font>
	   <br/><font color="#FF0000">如果使用转向链接则点击标题就直接跳转而内容设置无效</font>
     </td>
    </tr>
	
    <tr> 
      <td class="tablerow">是否生成</td>
      <td class="tablerow"><input type="radio" name="article[ishtml]" value="1" <?php if($ishtml==1) {?>checked <?php } ?>  onclick="$('htmlrule').style.display='';$('htmldir').style.display='';$('htmlprefix').style.display='';$('phprule').style.display='none';"> 是 <input type="radio" name="article[ishtml]" value="0" <?php if($ishtml==0) {?>checked <?php } ?> onclick="$('htmlrule').style.display='none';$('htmldir').style.display='none';$('htmlprefix').style.display='none';$('phprule').style.display='';"> 否</td>
    </tr>
	
		<tr id="htmldir" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件生成目录</td>
		  <td class="tablerow"><input type="text" name="article[htmldir]" value="<?=$htmldir?>" id="htmldir" ></td>
		</tr>

		<tr id="htmlprefix" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件名前缀</td>
		  <td class="tablerow"><input type="text" name="article[prefix]" id="prefix" value="<?=$prefix?>"></td>
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
      <td width="18%" class="tablerow" >允许查看的会员组</td>
      <td class="tablerow"><?=$showgroup?></td>
    </tr>
    <tr>
      <td class="tablerow" >阅读所需点数</td>
      <td class="tablerow">&nbsp;<input size="5" name="article[readpoint]" type="input" value="<?=$readpoint?>" /> 点</td>
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
    <td width="18%">
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