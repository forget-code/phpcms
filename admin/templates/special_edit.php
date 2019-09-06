<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>专题添加</th>
  </tr>
   <form action="?mod=<?=$mod?>&channelid=<?=$channelid?>&file=special&action=edit&specialid=<?=$specialid?>" method="post" name="myform">
    <tr> 
      <td class="tablerow"><b>专题名称</b></td>
      <td class="tablerow">
<input size=50 name="specialname" type=text value="<?=$specialname?>">
</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>专题图片</b></td>
      <td class="tablerow">
	  <input size=50 name="specialpic" type=text value="<?=$specialpic?>"> <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=phpcms&file=uppic&channelid=<?=$channelid?>&uploadtext=specialpic&action=thumb&width=150&height=150','upload','350','350')">
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>专题横幅</b></td>
      <td class="tablerow">
	  <input size=50 name="specialbanner" type=text value="<?=$specialbanner?>"> <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=phpcms&file=uppic&channelid=<?=$channelid?>&uploadtext=specialbanner&action=thumb&width=760&height=90','upload','350','350')">
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>专题说明</b></td>
      <td class="tablerow"><textarea name='introduce' cols='60' rows='5' id='introduce'><?=$introduce?></textarea></td>
    </tr>
    <tr>
      <td  class='tablerow'><b>专题关键词</b><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><input name='meta_keywords' type='text' id='meta_keywords' size='50' maxlength='30'  value="<?=$keywords?>"></td>
    </tr>
    <tr>
      <td  class='tablerow'><b>专题内容描述</b><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='meta_description' cols='60' rows='5' id='meta_description'><?=$description?></textarea></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>专题模板</b></td>
      <td class="tablerow">
<?=$templateid?>
</td>
    </tr>
    <tr> 
      <td class="tablerow"><b>专题风格</b></td>
      <td class="tablerow">
<?=$skinid?>
</td>
    </tr>
   <tr >
         <td class="tablerow"><b>是否推荐</b></td>
         <td class="tablerow">
		 <input type='radio' name='elite' value='1' <?php if($elite){?>checked<?php }?>> 是 
		 <input type='radio' name='elite' value='0' <?php if(!$elite){?>checked<?php }?>> 否</td>
   </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="Submit" name="submit" value=" 确定 "> 
        &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>