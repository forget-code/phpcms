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
        document.all.subspecial.innerHTML+="<div id='subspecial"+i+"'><input name='newsubspecialname[]' type='text' size='50' maxlength='50'></div>";
     }
	 function DelItem(myid)
	 {
		 i--;
		 setidval(myid,'');
	 }
	function ResetItem()
    { 
		document.all.subspecial.innerHTML= old;
		i=k;
    }
</script>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>专题添加</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=edit&keyid=<?=$keyid?>&specialid=<?=$specialid?>" method="post" name="myform">
      <input name='special[keyid]' type='hidden' id='keyid' value='<?=$keyid?>'>
      <input name='special[addtime]' type='hidden' id='addtime' value='<?=$addtime?>'>
    <tr> 
      <td class="tablerow" width="25%"><b>专题名称</b></td>
      <td class="tablerow"><input size=50 name="special[specialname]" type=text value="<?=$specialname?>"> <?=style_edit('special[style]',$style)?></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>专题图片</b></td>
      <td class="tablerow">
	  <input size="50" name="special[specialpic]" id="specialpic" type=text value="<?=$specialpic?>"> <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=phpcms&file=uppic&keyid=<?=$keyid?>&uploadtext=specialpic&action=thumb&width=300&height=250','upload','350','350')">
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>专题横幅</b></td>
      <td class="tablerow">
	  <input size="50" name="special[specialbanner]" id="specialbanner" type=text value="<?=$specialbanner?>"> <input type="button" value="上传图片" onclick="javascript:openwinx('?mod=phpcms&file=uppic&keyid=<?=$keyid?>&uploadtext=specialbanner&action=thumb&width=760&height=90','upload','350','350')">
    </td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>专题页html前缀</strong></td>
      <td class="tablerow">
	  <input type="text" name="special[prefix]" id="prefix" value="<?=$prefix?>" size=30> </td>
    </tr>
    <tr> 
      <td class="tablerow"><b>专题介绍</b></td>
      <td class="tablerow"><textarea name="special[introduce]" cols='60' rows='5' id="introduce"><?=$introduce?></textarea>  <?=editor('introduce','introduce',400,200)?></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>SEO Title（专题标题）</strong><br>针对搜索引擎设置的标题</td>
      <td class='tablerow'><input name='special[seo_title]' type='text' id='seo_title' size='50' maxlength='50' value="<?=$seo_title?>"></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>SEO Keywords（专题关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='special[seo_keywords]' cols='60' rows='3' id='seo_keywords'><?=$seo_keywords?></textarea></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>SEO Description（专题描述）</strong><br>针对搜索引擎设置的网页描述</td>
      <td class='tablerow'><textarea name='special[seo_description]' cols='60' rows='3' id='seo_description'><?=$seo_description?></textarea></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>专题模板</b></td>
      <td class="tablerow"><?=$templateid?></td>
    </tr>
    <tr> 
      <td class="tablerow"><b>专题风格</b></td>
      <td class="tablerow"><?=$skinid?></td>
    </tr>
    <tr> 
      <td class="tablerow"><strong>专题子分类</strong>(<a href="javascript:AddItem()"><font color="red">增加+</font></a>)</td>
      <td class="tablerow">
	  <div id="subspecial">
	  <?php 
	  foreach($special['subspecial'] as $subspecialid=>$sub)
	  {
	  ?>
	  <input type="text" name="subspecialname[<?=$subspecialid?>]" value="<?=$sub['specialname']?>" size=50> <input type="checkbox" name="delete[<?=$subspecialid?>]" value="1"> 删除<br/>
	  <?php 
	  }
	  ?>
	  
	  </div></td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="submit" name="dosubmit" value=" 确定 "> &nbsp;&nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>