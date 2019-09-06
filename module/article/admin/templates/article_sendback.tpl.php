<?php include admintpl('header');?>
<?=$menu?>
<table width="100%" height="25" border="0" cellpadding="3" cellspacing="0" class="tableborder">
  <tr>
    <td class="tablerow"> <img src="<?=PHPCMS_PATH?>admin/skin/images/pos.gif" align="absmiddle" alt="当前位置" > 当前位置：<a href="?mod=<?=$mod?>&file=<?=$file?>&action=main&channelid=<?=$channelid?>">文章首页</a> &gt;&gt; 文章退稿 &gt;&gt; <?=$article['title']?></td>
  </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td height="10"> </td>
</tr>
</table>
<form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>&articleid=<?=$articleid?>&dosubmit=1" method="post" name="myform">
<input type="hidden" name="referer" value="<?=$referer?>" />
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>文章退稿</th>
  </tr>
    <tr> 
      <td class="tablerow">文章标题</td>
      <td class="tablerow"><a href="?mod=<?=$mod?>&file=<?=$file?>&action=preview&channelid=<?=$channelid?>&articleid=<?=$articleid?>" title="预览文章"><?=$article['title']?>（预览）</a></td>
    </tr>
    <tr> 
      <td class="tablerow">所属栏目</td>
      <td class="tablerow"><?=$CAT['catname']?></td>
    </tr>
	<tr> 
      <td class="tablerow">会员名称</td>
      <td class="tablerow"><?=$article['username']?><input name='username' type='hidden' value='<?=$article['username']?>'> </td>
    </tr>
    <tr> 
      <td class="tablerow">短信通知</td>
      <td width="90%" class="tablerow">
	  <input name='ifpm' type='radio' id='ifpm' value='1'checked> 是
	  <input name='ifpm' type='radio' id='ifpm' value='0'> 否
	  <input name='ifemail' type='checkbox' id='ifemail' value='1' checked> 同时发送到该会员电子邮箱
	  </td>
    </tr>
    <tr> 
      <td class="tablerow">短信标题</td>
      <td class="tablerow"><input name="title" type="text" id="title" size="60" value="很抱歉！您提交的文章《<?=$article['title']?>》被退回！"></td>
    </tr>
    <tr> 
      <td class="tablerow">短信内容 </td>
      <td class="tablerow">
        <textarea name="content" id="content" cols="60" rows="4"><?=$CHA['emailofreject']?></textarea> <?=editor("content","introduce",400,200)?>
    </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
        <input type="submit" value=" 确定 " > &nbsp;
        <input type="reset" value=" 返回 " onclick="history.go(-1);">
     </td>
    </tr>
  </form>
</table>
</body>
</html>