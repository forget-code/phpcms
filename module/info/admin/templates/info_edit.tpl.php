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
function doKeywords(ID)
{
	$(ID).value = $F(ID).replace(new RegExp('，',"gm"),',');
	$(ID).value = $F(ID).replace(new RegExp(' ',"gm"),',');
}
</script>
<?=segment_word()?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">信息首页</a> &gt;&gt; <a href="?mod=<?=$mod?>&file=<?=$file?>&action=edit&infoid=<?=$infoid?>&catid=<?=$catid?>&channelid=<?=$channelid?>">编辑信息</a> &gt;&gt; <?=$title?></td>
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

<form action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&catid=<?=$catid?>&infoid=<?=$infoid?>&channelid=<?=$channelid?>&dosubmit=1" method="post" name="myform" onsubmit="return doCheck();">
<input type="hidden" name="referer" value="<?=$referer?>" />
<input type="hidden" name="info[catid]" value="<?=$catid?>" />
<input type="hidden" name="ishtmled" value="<?=$ishtml?>" />
<input type="hidden" name="old_arrposid"value="<?=$arrposid?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id="Tabs0" style="display:">
  <tr>
    <th colspan=2>基本信息</th>
  </tr>
    <tr> 
      <td width="15%" class="tablerow">所属栏目</td>
      <td class="tablerow"><font color="#FF0000"><?=$CAT['catname']?></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="blue">Tips:</font><a href="?mod=<?=$mod?>&file=<?=$file?>&channelid=<?=$channelid?>&action=move&movetype=1&infoids=<?=$infoid?>&referer=<?=urlencode("?mod=$mod&file=$file&action=edit&catid=$catid&infoid=$infoid&channelid=$channelid&mode=$mode")?>">如果需要改变所属栏目，请点这里...</td>
    </tr>

    <tr>
      <td class="tablerow">标题</td>
      <td class="tablerow"><?=$type_select?> <input name="info[title]" type="text" id="title" size="44" maxlength="100" class="inputtitle" value="<?=$title?>" onBlur="segment_word(this);"> <font color="#FF0000">*</font> <?=$style_edit?> <input type="button" value="检查同名标题" onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checktitle&channelid=<?=$channelid?>&title='+$('title').value+'','','300','40','no')" style="width:90px;"></td>
    </tr>

 <tr> 
      <td class="tablerow">所在地 <font color="#FF0000">*</font></td>
      <td class="tablerow"><span onclick="this.style.display='none';$('select_area').style.display='';" style="cursor:pointer;"><?=$AREA[$areaid]['areaname']?> <font color="red">点击重选</font></span><span id="select_area" style="display:none;"><?=ajax_area_select('info[areaid]',$channelid, $areaid);?></span></td>
    </tr>

	 <tr> 
      <td class="tablerow">缩略图</td>
      <td class="tablerow"><input name="info[thumb]" type="text" id="thumb" size="58" value="<?=$thumb?>">  <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&channelid=<?=$channelid?>&uploadtext=thumb&type=thumb&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload_thumb','350','350')">
	   <input name="fromupload" type="button" id="fromupload" value="从已经上传的图片中选择" onclick="SelectPic()" style="width:150px;"/>
      </td>
    </tr>

     <tr <?php if(!$MOD['keywords_show']){ ?>style="display:none"<?php } ?>> 
      <td class="tablerow">关键字</td>
      <td class="tablerow"><input name="info[keywords]" type="text" id="keywords" value="<?=$keywords?>" size="40" title="提示:多个关键字请用半角逗号“,”或空格隔开" onblur="doKeywords(this);">
		<?=$keywords_select?>
		<input type="checkbox" name="addkeywords" value="1" <?php if($MOD['keywords_add']){ ?>checked<?php } ?>> 添加至关键字列表中 =&gt;<a href="###" onclick="SelectKeywords();">更多关键字</a></td>
    </tr>

    <tr> 
      <td class="tablerow">内容 <font color="#FF0000">*</font></td>
      <td class="tablerow">

	  <table width="100%"border="0" cellpadding="0" cellspacing="2">
	  <tr>
	  <td valign="top">
        <textarea name="info[content]" id="content" cols="100" rows="25"><?=$content?></textarea> <?=editor("content", $MOD['editor_mode'],$MOD['editor_width'],$MOD['editor_height'])?>
    </td>
	</tr>
	</table>
   </td>
    </tr>

    <tr> 
      <td class="tablerow">地址</td>
      <td class="tablerow"><input name="info[address]" type="text" id="address" size="40" maxlength="30" value="<?=$address?>"></td>
    </tr>

    <tr> 
      <td class="tablerow">联系人</td>
      <td class="tablerow"><input name="info[author]" type="text" id="author" size="40" maxlength="30" value="<?=$author?>"></td>
    </tr>

    <tr> 
      <td class="tablerow">电话</td>
      <td class="tablerow"><input name="info[telephone]" type="text" id="telephone" size="40" value="<?=$telephone?>"></td>
    </tr>

	    <tr> 
      <td class="tablerow">Email</td>
      <td class="tablerow"><input name="info[email]" type="text" id="email" size="40" value="<?=$email?>"></td>
    </tr>

	    <tr> 
      <td class="tablerow">QQ</td>
      <td class="tablerow"><input name="info[qq]" type="text" id="qq" size="40" value="<?=$qq?>"></td>
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
      <td class="tablerow">信息状态</td>
      <td class="tablerow">


<input name="info[status]" type="radio" value="3" <?if($status==3){?>checked<?}?>> 已通过&nbsp;
<input name="info[status]" type="radio" value="1" <?if($status==1){?>checked<?}?>> 待审核&nbsp;
<input name="info[status]" type="radio" value="0" <?if($status==0){?>checked<?}?>> 草稿&nbsp;

	  
	  </td>
	  </tr>

	    <tr> 
	  <td class="tablerowhighlight"> </td>
      <td class="tablerowhighlight">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?mod=phpcms&file=field&channelid=<?=$channelid?>&tablename=<?=channel_table('info', $channelid)?>">自定义选项 进入管理</a></td>
	  </tr>
<?=$fields?>

</tbody>

<tbody id="Tabs1" style="display:none">
  <tr>
    <th colspan=2>高级设置</th>
  </tr>

	<tr> 
      <td class="tablerow">添加日期</td>
      <td class="tablerow"><?=date_select('info[addtime]', $addtime)?>&nbsp;格式：yyyy-mm-dd</td>
    </tr>

	<tr> 
      <td class="tablerow">截至日期</td>
      <td class="tablerow"><?=date_select('info[endtime]', $endtime)?>&nbsp;格式：yyyy-mm-dd 留空表示不限</td>
    </tr>

   <tr> 
      <td class="tablerow">转向链接</td>
      <td class="tablerow">
       <input type="text" name="info[linkurl]" id="linkurl"  size="50" maxlength="255"<? if(!$islink) { ?>disabled<? } ?> value="<? if($islink) { ?><?=$linkurl?><? } ?>"><input name="info[islink]" type="checkbox" id="islink" value="1" onclick="ruselinkurl();" <? if($islink) { ?>checked<? } ?>><font color="#FF0000">转向链接</font>
	   <br/><font color="#FF0000">如果使用转向链接则点击标题就直接跳转而内容设置无效</font>
     </td>
    </tr>
	
    <tr> 
      <td class="tablerow">是否生成</td>
      <td class="tablerow"><input type="radio" name="info[ishtml]" value="1" <?php if($ishtml==1) {?>checked <?php } ?>  onclick="$('htmlrule').style.display='';$('htmldir').style.display='';$('htmlprefix').style.display='';$('phprule').style.display='none';"> 是 <input type="radio" name="info[ishtml]" value="0" <?php if($ishtml==0) {?>checked <?php } ?> onclick="$('htmlrule').style.display='none';$('htmldir').style.display='none';$('htmlprefix').style.display='none';$('phprule').style.display='';"> 否</td>
    </tr>
	
		<tr id="htmldir" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件生成目录</td>
		  <td class="tablerow"><input type="text" name="info[htmldir]" value="<?=$htmldir?>" id="htmldir" ></td>
		</tr>

		<tr id="htmlprefix" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件名前缀</td>
		  <td class="tablerow"><input type="text" name="info[prefix]" id="prefix" value="<?=$prefix?>"></td>
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
      <td class="tablerow">&nbsp;<input size="5" name="info[readpoint]" type="input" value="<?=$readpoint?>" /> 点</td>
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