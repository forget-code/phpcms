<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
include(PHPCMS_ROOT."/include/htmlframe.inc.php");
loadMtir();
?>
<script src="<?=PHPCMS_PATH?>include/js/checkform.js"></script>
<script language='JavaScript' type='text/JavaScript'>

function CheckForm(){
	var cf = new Check("myform");
	cf.isnumber('pdt_price','商品价格格式不正确，应为整数或小数','required')
	cf.must('pdt_name','商品名称不得为空');
	//cf.notequal('pdt_catid','0','请选择商品分类');
	cf.must('pdt_price','商品价格不得为空');
	//cf.must('introduce','商品介绍不得为空');
	return cf.passed();
}
function HideTabTitle(displayValue,tempType)
{
	for (var i = 0; i < 5; i++)
	{
		var tt=document.getElementById("TabTitle"+i);
		if(tempType==0&&i==2)
		{
			tt.style.display='none';
		}
		else
		{
			tt.style.display=displayValue;
		}
	}
}
function LoadAttList(pro_id)
{
	 document.getElementById('product_type').location("<?php echo "?mod=$mod&file=attribute&action=list&pro_id="; ?>"+pro_id);
}
var imgn=0;
function addInputFile(obj)
{
	imgn++;
    var src   = obj.parentNode.parentNode;
    var idx   = rowindex(src);
    var tbl   = document.getElementById('product_image');
    var row   = tbl.insertRow(idx + 1);
    var cell  = row.insertCell(-1);
    var createtd="<table cellpadding=\"2\" cellspacing=\"1\" border=\"0\"><tr><td>图片描述 <input type=\"text\" name=\"productimage_intro[]\" size=\"20\" />&nbsp;&nbsp;图片地址 <input type=\"text\" name=\"productimage_url[]\"  size=\"30\" id=\"pdt_images\" />&nbsp;<input type=\"button\" value=\" 上传 / 预览 \" onclick=\"javascript:openwinx('?mod=<?=$mod?>&file=uppic&type=both&width=<?=$MOD['thumbwidth']?>&height=<?=$MOD['thumbheight']?>&uploadtext=pdt_images','upload','350','200')\">&nbsp;&nbsp;</td><td><input type=\"button\" onclick=\"deleteInputFile(this)\" value=\"删除该项目\"></td></tr></table>";
    cell.innerHTML=createtd.replace(/(.*)(pdt_images)(.*)(pdt_images)/,"$1pdt_images"+imgn+"$3pdt_images"+imgn);
    cell.className = 'tablerow';       
}
function deleteInputFile(obj)
{
    var row = rowindex(obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode);
    var tbl = document.getElementById('product_image');
    tbl.deleteRow(row);
}
function deleteUploadImage(obj)
{
	var row = rowindex(obj.parentNode.parentNode);
    var tbl = document.getElementById('uploadimage');
    tbl.deleteRow(row);	
}
function rowindex(tr)
{
    if (Browser.isIE)
    {
        return tr.rowIndex;
    }
    else
    {
      table = tr.parentNode.parentNode;
      for (i = 0; i < table.rows.length; i++)
      {
          if (table.rows[i] == tr)
          {
              return i;
              break;
          }
      }
    }
}
/*生成一个商品编号
*/
function GetneratePdtNo()
{
	var str="";
	var d = new Date();
	str = "PCSPDT"+d.getTime();
	$('pdt_No').value = str.substring(0, 16);		
}

</script>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr>
     <td width='80%' class="tablerow">当前位置： <?=$cat_pos?></td>
     <td></td>
  </tr>
</table>
<table width="100%" height="12" border="0" cellpadding="0" cellspacing="0" >
  <tr>
     <td width='80%'>&nbsp;</td>
     <td></td>
  </tr>
</table>

<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=edit" onsubmit="return CheckForm();" enctype="multipart/form-data">
<input name='pdt[catid]' type='hidden' id='catid' value='<?=$catid?>'>
<input name='pdt[addtime]' type='hidden' id='catid' value='<?=$addtime?>'>
<input name='productid' type='hidden' id='productid' value='<?=$productid?>'>
<input type="hidden" name="ishtmled" value="<?=$ishtml?>" />
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本设置</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>属性参数</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>商品图片</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>生成页面</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
  <tr>
  <td width='190' class='tablerow'><strong>商品名称</strong></td>
  <td class='tablerow'>
<input name='pdt[pdt_name]' type='text' id='pdt_name' size='40' maxlength='50' value="<?=$pdt_name?>"/>  <font color="red">*</font>&nbsp;&nbsp;&nbsp;<?=$style_edit?>&nbsp;&nbsp;&nbsp;<input type="button" value="检查同名商品" onclick="Dialog('?mod=<?=$mod?>&file=<?=$file?>&action=checktitle&title='+$('pdt_name').value+'','','300','40','no')" style="width:90px;">
  </td>
  </tr>
    <tr>
      <td class='tablerow'><strong>商品编号</strong><br> 不填将自动生成</td>
      <td class='tablerow'><input name='pdt[pdt_No]' type='text' id='pdt_No' size='40' maxlength='50' value="<?=$pdt_No?>"/> <input type="button" onclick="GetneratePdtNo();" value="生成编号"></td>
    </tr>
    <tr>
      <td  class='tablerow'><strong>附属分类</strong><br>  </td>
      <td class='tablerow'><?=$subtypeselect?></td>
    </tr>
            <tr> 
      <td class="tablerow"><strong>推荐位置</strong></td>
      <td class="tablerow">
<?=$position?>
      </td>
	  </tr>
    <tr>
      <td  class='tablerow'><strong>商品品牌</strong><br>  </td>
      <td class='tablerow'>
      <input style="width:120px;height:20px;" value="<?=$brand_name?>"  id="textUin" name="pdt[pdt_brand]" onclick="value=''" value="">
		<span style="position:absolute;margin:1px 1px 1px -6px">
		<select style="margin-left:-122px;width:140px;" id="uinSelector" onchange="document.getElementById('textUin').value=value;">
		<option selected>——直接填写或选择——</option>
		<?=$brandselect?>
		</select>
		</span> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="openwinx('?mod=<?=$mod?>&file=brand&action=manage','品牌管理','720','500')" value="品牌管理" /></td>
    </tr>
        <tr>
      <td width='190' class='tablerow'><strong>价格</strong></td>
      <td class='tablerow'>
<input name='pdt[price]' type='text' id='pdt_price' size='20' maxlength='50' value="<?=$price?>"/> 元<font color="red">*</font>
	  </td>
    </tr>
    	<tr>
      <td class='tablerow'><strong>市场价格</strong></td>
      <td class='tablerow'>
<input name='pdt[marketprice]' type='text' id='marketprice' size='20' maxlength='50' value="<?=$marketprice?>"/> 元
	  </td>
	  <tr>
      <td class='tablerow'><strong>商品描述</strong><br>简介，用于需要在列表时显示</td>
      <td class='tablerow'><textarea name='pdt[pdt_description]' cols='50' rows='3' id='pdt_description'><?=$pdt_description?></textarea></td>
    </tr>
        <tr>
      <td  class='tablerow'><strong>商品缩略图</strong><br></td>
      <td class='tablerow'><input name='pdt[pdt_img]' type='text' id='pdt_img' size='40' maxlength='50'  value="<?=$pdt_img?>"/>&nbsp;&nbsp; 
      <input type="button" value=" 上传 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=pdt_img&type=thumb&width=<?=$MOD['thumbwidth']?>&height=<?=$MOD['thumbheight']?>','upload','350','200')">
      &nbsp;&nbsp;请到模块配置内更改默认生成缩略图高宽</td>
    </tr>
    <tr>
      <td class='tablerow'><strong>立即上架</strong><br>  </td>
      <td class='tablerow'><input type='radio' name='pdt[onsale]' id='onsale' value='1' <?php if($onsale) echo "checked";?>>√&nbsp;&nbsp;<input type='radio' name='pdt[onsale]' id='onsale' value='0' <?php if(!$onsale) echo "checked";?>>×
		<font color="red">*</font></td>
    </tr>
    </tr>
    	<tr>
      <td class='tablerow'><strong>重量</strong></td>
      <td class='tablerow'>
<input name='pdt[pdt_weight]' type='text' id='pdt_weight' size='20' maxlength='50'  value="<?=$pdt_weight?>"/> 千克
	  </td>
    </tr>
    	<tr>
      <td class='tablerow'><strong>计量单位</strong></td>
      <td class='tablerow'>
<input name='pdt[pdt_unit]' type='text' id='pdt_unit' size='20' maxlength='50'  value="<?=$pdt_unit?>"/>
	  </td>
    </tr>
    <tr>
      <td class='tablerow'><strong>SEO Keywords（商品关键词）</strong><br>针对搜索引擎设置的关键词</td>
      <td class='tablerow'><textarea name='pdt[pdt_keyword]' cols='60' rows='2' id='pdt_keyword'><?=$pdt_keyword?></textarea></td>
    </tr>
    <tr>
      <td class='tablerow'><strong>商品介绍</td>
      <td class='tablerow'><textarea name='pdt[introduce]' cols='80' rows='8' id='introduce'><?=$introduce?></textarea><?=editor('introduce','introduce',400,200)?>  <font color="red">*</font></td>
    </tr>	
  </tbody>
  
  <tbody id='Tabs1' style='display:none'>
    <th colspan=2>属性参数</th>
    <tr>
      <td width='20%' class='tablerow' height='40'>&nbsp;<strong>您选择的商品类型</strong></td>
      <td width='80%' class='tablerow'><?=$producttypeselect?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="openwinx('?mod=<?=$mod?>&file=attribute&action=manage&pro_id='+$F('propertyselect'),'管理该类型属性','720','500')" value="管理该类型属性"></td>
    </tr>
     <tr>
      <td colspan='2' class='tablerow'>  
   <?php
   setMtirFrame("product_type");
   ?>
  </td>
    </tr>    
  </tbody>
  
    <tbody id='Tabs2' style='display:none'>
    <th colspan=2>商品图片</th>
    <tr>
    	<td colspan='2' class='tablerow'>    	 
        	<table cellpadding="2" cellspacing="1"  border="0"  id="uploadimage" align="center" width="100%"  style="background:white;border:#F1F3F5 1px solid;">
			<tr>
			<td class='tablerow' valign="middle" colspan="6">&nbsp;<strong>已上传的图片：</strong></td>
			</tr>
			<?php
			if(is_array($uploadimages))
			{
				foreach ($uploadimages as $k=>$uploadimage)
				{
				?>
			<tr>
			<td class='tablerow' valign="middle">
			<?php echo ++$k;?>、图片描述 <input type="text" name="productimage_intro[]" size="20" value="<?=$uploadimage['introduce']?>"/>&nbsp;&nbsp;
			图片地址 <input type="text" name="productimage_url[]"  size="30" id="pdt_imagespre<?php echo $k;?>"  value="<?=$uploadimage['imgurl']?>"/>
			&nbsp;<input type="button" value=" 上传 / 预览 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=pdt_imagespre<?php echo $k;?>&type=both&width=<?=$MOD['thumbwidth']?>&height=<?=$MOD['thumbheight']?>','upload','350','200')">
			&nbsp;<input type="button" value=" 删 除 " onclick="javascript:deleteUploadImage(this)">
			</td>
			</tr>
			
			<?php
				}
			}
			?>
			</table>
    	</td>
    </tr>
    <tr>
	<td class='tablerow'colspan="6">&nbsp;&nbsp;<strong>继续上传图片：</strong></td>
	</tr>
    <tr>
    	<td colspan='2' class='tablerow'>    	 
        	<table cellpadding="2" cellspacing="1" id="product_image" border="0" align="center" width="100%" style="background:#CCCCCC;border:#F1F3F5 1px solid;">
        	<tr>
			<td class='tablerow' valign="middle" id='createtd'><table cellpadding="2" cellspacing="1" border="0"><tr><td>图片描述 <input type="text" name="productimage_intro[]" size="20" />&nbsp;&nbsp;图片地址 <input type="text" name="productimage_url[]"  size="30" id="pdt_images"/>&nbsp;<input type="button" value=" 上传 / 预览 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=pdt_images&type=both&width=<?=$MOD['thumbwidth']?>&height=<?=$MOD['thumbheight']?>','upload','350','200')">&nbsp;&nbsp;</td><td><input type="button"  onclick="addInputFile(this)" value="增加上传框" style="color:blue;"></td></tr></table></td>
			</tr>
			</table>
    	</td>
    </tr>  
      <tbody id='Tabs3' style='display:none'>
    <th colspan=2>生成页面</th>
    	 <tr> 
      <td class="tablerow">是否生成</td>
      <td class="tablerow"><input type="radio" name="pdt[ishtml]" value="1" <?php if($ishtml==1) {?>checked <?php } ?>  onclick="$('htmlrule').style.display='';$('htmlprefix').style.display='';$('htmldir').style.display='';$('phprule').style.display='none';"> 是 <input type="radio" name="pdt[ishtml]" value="0" <?php if($ishtml==0) {?>checked <?php } ?> onclick="$('htmlrule').style.display='none';$('htmldir').style.display='none';$('htmlprefix').style.display='none';$('phprule').style.display='';"> 否</td>
    </tr>
		<tr id="htmldir" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件生成目录</td>
		  <td class="tablerow"><input type="text" name="pdt[htmldir]" value="<?=$htmldir?>" id="htmldir" ></td>
		</tr>
		<tr id="htmlprefix" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件名前缀</td>
		  <td class="tablerow"><input type="text" name="pdt[prefix]" id="prefix" value="<?=$prefix?>"></td>
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
  
</table>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='30%'></td>
     <td><input type="submit" name="submit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
<?php
loadMtirPage('product_type',"?mod=$mod&file=attribute&action=list&pro_id=$pro_id&productid=$productid","请选择商品类型，生成属性列表框<br>",0);
?>
</body>
</html>