<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<style>
.inp{
	background:#ff0000;
	color:#ffffff;
	padding-top:2px;
}
</style>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th>提示信息</th>
  </tr>
  <tr>
    <td class="tablerow">
	<font color="red">1、一般情况下只需要通过点击下面“快捷更新”中的“更新频道”来发布网页，当然您还可以点击“快捷更新”的其他链接来进行分项更新。</font><br>
	2、如果单个栏目下文章过多（例如超过1万篇）而导致栏目更新困难，您可以通过下面的栏目进行分栏目更新。<br>
	3、如果你更换服务器空间或者更换了模板，希望所有网页重新生成，那么可以通过“更新频道”、“更新文章”、“更新专题”来重新生成所有html
	</td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=6>更新栏目</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">选中</td>
<td width="5%" class="tablerowhighlight">ID</td>
<td width="25%" class="tablerowhighlight">栏目名称</td>
<td width="15%" class="tablerowhighlight">栏目目录</td>
<td width="10%" class="tablerowhighlight">是否已生成</td>
<td width="35%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform">
<? if(is_array($_CAT)) foreach($_CAT AS $cat) {
$p->set_type("path");
$p->set_catid($cat[catid]);
$cat[caturl] = $p->get_caturl();
$p->set_type("url");
$p->set_catid($cat[catid]);
$cat[url] = $p->get_listurl();
if($cat[cattype]){
?>
  <tr align=center>
    <td class="tablerow"><input type="checkbox" name="catid[]"  id="catid[]" value="<?=$cat[catid]?>"></td>
	<td class="tablerow"><?=$cat[catid]?></td>
    <td class="tablerow"><a href='<?=$cat[url]?>' title='<?=$cat[catname]?>' target='_blank'><?=$cat[catname]?></a></td>
    <td class="tablerow"><?=$cat[catdir]?></td>
    <td class="tablerow"><? if(file_exists($cat[caturl])) { ?>是<? } else { ?><font color='red'>否</font><? } ?></td>
    <td class="tablerow"><a href='?mod=<?=$mod?>&file=<?=$file?>&action=category&catid=<?=$cat[catid]?>&channelid=<?=$channelid?>'>生成栏目列表</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=catpicture&catid=<?=$cat[catid]?>&channelid=<?=$channelid?>'>生成图片</a> | <a href='?mod=<?=$mod?>&file=<?=$file?>&action=createcatdir&catid=<?=$cat[catid]?>&channelid=<?=$channelid?>'>生成栏目目录</a></td>
  </tr>
<?} } ?>

  <tr>
    <td class="tablerow"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td class="tablerow" colspan=5>&nbsp;&nbsp;
	<input type="submit" name="submit1" value="生成列表" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=category&channelid=<?=$channelid?>'">&nbsp;&nbsp;
	<input type="submit" name="submit2" value="生成图片" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=catpicture&channelid=<?=$channelid?>'">&nbsp;&nbsp;
	<input type="submit" name="submit3" value="生成栏目目录" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=createcatdir&channelid=<?=$channelid?>'">&nbsp;&nbsp;
	<input type="submit" name="submit4" value="删除栏目目录" onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=deletecatdir&channelid=<?=$channelid?>'">&nbsp;&nbsp;
	<a href='?mod=phpcms&file=category&action=manage&channelid=<?=$channelid?>'><b>进入栏目管理&gt;&gt;</b></a>
  </td>
  </tr>
</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=4>更新图片</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">图片起始ID</td>
<td width="45%" class="tablerowhighlight">图片结束ID</td>
<td width="15%" class="tablerowhighlight">每轮生成图片数</td>
<td width="30%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform2" action="?mod=<?=$mod?>&file=<?=$file?>&action=picture&channelid=<?=$channelid?>">
  <tr align=center>
    <td class="tablerow"><input name="fid" type="text" size="15" value="<?=$minpictureid?>"></td>
    <td class="tablerow"><input name="tid" type="text" size="15" value="<?=$maxpictureid?>"></td>
    <td class="tablerow"><input name="pernum" type="text" size="15" value="100"></td>
    <td class="tablerow"><input name='submit' type='submit' value=' 生成html '>&nbsp;&nbsp;<a href='?mod=<?=$mod?>&file=picture&action=manage&channelid=<?=$channelid?>'><b>进入图片管理&gt;&gt;</b></a></td>
  </tr>
</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <th colspan=4>更新专题</th>
  </tr>
<tr align="center">
<td width="10%" class="tablerowhighlight">选中</td>
<td width="45%" class="tablerowhighlight">专题名称</td>
<td width="15%" class="tablerowhighlight">是否已生成</td>
<td width="25%" class="tablerowhighlight">管理操作</td>
</tr>
<form method="post" name="myform1">
<? if(is_array($specials)) foreach($specials AS $special) { ?>
  <tr>
    <td class="tablerow"><input type="checkbox" name="specialid[]"  id="specialid[]" value="<?=$special[specialid]?>"></td>
    <td class="tablerow"><a href="<?=$special[url]?>" target="_blank"><?=$special[specialname]?></a></td>
    <td class="tablerow" align=center><? if(file_exists($special[path])) { ?>是<? } else { ?><font color='red'>否</font><? } ?></td>
    <td class="tablerow" align=center><a href='?mod=phpcms&file=<?=$file?>&action=special,special_show&specialid=<?=$special[specialid]?>&channelid=<?=$channelid?>'>生成专题</a></td>
  </tr>

<? } ?>

  <tr>
    <td class="tablerow"><input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='checkbox'>全部选中</td>
    <td class="tablerow" colspan=3>
<input type="submit" name="submit1" value="生成专题" onClick="document.myform1.action='?mod=phpcms&file=<?=$file?>&action=special,special_show&channelid=<?=$channelid?>'">&nbsp;&nbsp;<a href='?mod=phpcms&file=special&action=manage&channelid=<?=$channelid?>'><b>进入专题管理&gt;&gt;</b></a>
</td>
  </tr>
</form>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
</body>
</html>