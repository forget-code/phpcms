<?php include admintpl('header');?>
<?=$menu?>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/tag.js"></script>
<body>
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
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=6><?=$_CHA['channelname']?>频道 - <?=$funcs[$func]?>管理</th>
  </tr>
<form method="post" name="myform">
<tr align="center">
<td class="tablerowhighlight" width="20%">标签名称</td>
<td class="tablerowhighlight" width="65%">调用标签（请复制标签插入到模板中的相应位置）</td>
<td class="tablerowhighlight" width="15%">管理操作</td>
</tr>
<? if(is_array($tags)) foreach($tags AS $tag) { ?>
<tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="left" height="60">
<a href='?mod=<?=$mod?>&file=<?=$file?>&action=set&tagid=<?=$tag[tagid]?>&func=<?=$tag[func]?>&channelid=<?=$channelid?>' title="<?=$tag[alt]?>">
<?php if($tag[type]){ ?><font color="red"><?=$tag[tagname]?></font><?php }else{ ?><?=$tag[tagname]?><?php } ?>
</a>
</td>
<td align="left">
<font color="red">短标签：</font><input type='text' value="{$tag[<?=$tag[tag]?>]}" size='80' name='tag<?=$tag[tagid]?>a' onfocus="document.myform.elements['tag<?=$tag[tagid]?>a'].select();"><br/>
长标签：<input type='text' value="{$<?=$tag[tagcode]?>}" size='80' name='tag<?=$tag[tagid]?>b' onfocus="document.myform.elements['tag<?=$tag[tagid]?>b'].select();"><br/>
<font color="blue">JS调用：</font><input type='text' value="<script language='javascript' src='<?=$PHP_SITEURL?><?=($channelid ? $_CHA[channeldir]."/" : "")?>js.php?tag=<?=$tag[tag]?>'></script>" size='80' name='js<?=$tag[tagid]?>' onfocus="document.myform.elements['js<?=$tag[tagid]?>'].select();">
</td>
<td><a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&tagid=<?=$tag[tagid]?>&func=<?=$tag[func]?>" target="_blank" title="提示:您可以先在左边输入框中修改相关参数后再预览效果!">预览</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=set&tagid=<?=$tag[tagid]?>&func=<?=$tag[func]?>&channelid=<?=$channelid?>'>修改</a> | <a href="#" onClick="javascript:confirmurl('?mod=<?=$mod?>&file=<?=$file?>&action=delete&tagid=<?=$tag[tagid]?>&channelid=<?=$channelid?>&referer=<?=urlencode($PHP_URL)?>','确认删除此标签吗？如果您在模板中使用了短标签或JS调用，则请不要删除！')">删除</a></td>
</tr>
<? } ?>
<tr align="center" onMouseOut="this.style.backgroundColor='#F1F3F5'" onMouseOver="this.style.backgroundColor='#BFDFFF'" bgColor='#F1F3F5'>
<td align="left"><font color='red'>标签参数参考 =&gt</font></td>
<td align="left" colspan='4'><input type='text' value='<?=$tag_function?>' size='110'></td>
</tr>
</table>
</form>
<br/>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align=center>提示信息</td>
  </tr>
  <tr>
    <td class="tablerow">
	您可以先设置好参数，然后把标签或者JS代码复制粘贴到模板中的相应位置，这样就可以在该位置显示信息。标签和JS调用显示的结果相同，您需要根据实际情况来决定选择哪一种调用方式。下面就标签调用与JS调用特点做一下讲解：<p>
	
	<b>标签调用：</b><br/>
	优点：在调用页产生html，有利于搜索收录，下载速度快<br/>
	缺点：如果您设置了生成html，html生成速度慢，需要经常更新页面才能保持最新，不能跨站或者跨频道调用<br/>
	<font color="red">短标签和长标签有什么区别？</font><br/>
	<font color="blue">
	1、短标签更加简短，在进行模板编辑的时候不会让模板变形，通过短标签的英文名很容易知道该标签的意义；<br/>
	2、短标签一旦插入到模板就可以通过<font color="red">后台修改标签参数来控制前台显示</font>了；<br/>
	3、短标签和后台有关联，因此<font color="red">不能在后台删除正在使用的短标签</font>，否则会导致短标签无法调出数据并显示空白。<br/></font>
	4、长标签是phpcms 2.4版本开始采用的标签方式，3.0仍然支持这种标签。<br/>
	5、长标签插入模板后如果要修改参数则需要找到模板中该标签位置，并找到对应的参数进行修改，没有短标签方便。<br/>
	<font color="red">建议：如果您希望更好地控制标签参数，请使用短标签；如果您打算发布您的模板，请使用长标签（因为短标签还和标签数据关联，不方便发布）</font>
	<p>
	
	<b>JS调用：</b><br/>
	优点：可以跨站调用，自动更新，html生成速度快<br/>
	缺点：搜索收录差，速度相对html要慢一点（相差不大）<p>

	<b>我们的建议：</b><br/>
    在首页、栏目首页、专题首页使用标签调用；<br/>栏目信息列表、信息具体页中的推荐信息、热点信息等使用JS调用
	</td>
  </tr>
</table>
</body>
</html>