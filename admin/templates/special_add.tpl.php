<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script language="javascript">
     var i=1;
	 var k=i;
     function AddItem()
     { 
        i++;
		if(i>50)
		{
			alert("参数过多！");
			return;
		}
        document.all.type.innerHTML+="<div id='subspecial"+i+"'><input name='subspecialname[]' type='text' size='50' maxlength='50'></div>";
     }
	 function DelItem(myid)
	 {
		 i--;
		 setidval(myid,'');
	 }
	function ResetItem()
    { 
		document.all.type.innerHTML= old;
		i=k;
    }
</script>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>专题添加</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=special&action=add&keyid=<?=$keyid?>" method="post" name="myform">
   <input name='special[keyid]' type='hidden' id='keyid' value='<?=$keyid?>'>
   <input name="forward" type='hidden' id="forward" value='<?=$forward?>'>
	<tr> 
      <td class="tablerow" width="25%"><strong>专题名称</strong></td>
      <td class="tablerow"><input type="text" name="special[specialname]" size=50></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>专题图片</strong></td>
      <td class="tablerow">
	  <input type="text" name="special[specialpic]" id="specialpic" size=50> <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=phpcms&file=uppic&keyid=<?=$keyid?>&uploadtext=specialpic&action=thumb&width=300&height=250','upload','350','350')">
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>专题横幅</strong></td>
      <td class="tablerow">
	  <input type="text" name="special[specialbanner]" id="specialbanner" size=50> <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=phpcms&file=uppic&keyid=<?=$keyid?>&uploadtext=specialbanner&action=thumb&width=760&height=90','upload','350','350')">
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>专题页html前缀</strong></td>
      <td class="tablerow">
	  <input type="text" name="special[prefix]" id="prefix" value="special_" size=30> </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>专题介绍</strong></td>
      <td class="tablerow"><textarea name="special[introduce]" cols="60" rows="5" id="introduce"></textarea>  <?=editor('introduce','introduce',400,200)?></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>SEO Title（专题标题）</strong><br>针对搜索引擎设置的标题</td>
      <td class='tablerow'><input name='special[seo_title]' type='text' id='seo_title' size='50' maxlength='50'></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>SEO Keywords（专题关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='special[seo_keywords]' cols='60' rows='3' id='seo_keywords'></textarea></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>SEO Description（专题描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='special[seo_description]' cols='60' rows='3' id='seo_description'></textarea></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>专题模板</strong></td>
      <td class="tablerow"><?=$templateid?></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>专题风格</strong></td>
      <td class="tablerow"><?=$skinid?></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>专题子分类</strong>(<a href="javascript:AddItem()"><font color="red">增加+</font></a>)</td>
      <td class="tablerow"><div id="type"><input type="text" name="subspecialname[]" size=50></div></td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="submit" name="dosubmit" value=" 确定 "> &nbsp;&nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>