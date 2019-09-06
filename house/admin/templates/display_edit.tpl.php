<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script src="<?=PHPCMS_PATH?>include/js/checkform.js"></script>
<script language='JavaScript' type='text/JavaScript'>

function CheckForm(){
	var cf = new Check("myform");
	//cf.isnumber('price','价格格式不正确，应为整数或小数','required')
	cf.must('name','商品名称不得为空');
	cf.must('develop','开发商名称不得为空');
	cf.must('areaid','所在区域不得为空');	
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
var imgn=0;
function addInputFile(obj)
{
	imgn++;
    var src   = obj.parentNode.parentNode;
    var idx   = rowindex(src);
    var tbl   = document.getElementById('household_image');
    var row   = tbl.insertRow(idx + 1);
    var cell  = row.insertCell(-1);
    var createtd="<table cellpadding=\"2\" cellspacing=\"1\" border=\"0\"><tr><td>房型标题:<input type=\"text\" name=\"householdimage_title[]\" size=\"18\"  value=\"__室__厅__卫__厨\"/>&nbsp;&nbsp;面积:<input type=\"text\" name=\"householdimage_area[]\" size=\"10\" />㎡&nbsp;&nbsp;图片:<input type=\"text\" name=\"householdimage_url[]\"  size=\"20\" id=\"household_image\" />&nbsp;<input type=\"button\" value=\" 上传 / 预览 \" onclick=\"javascript:openwinx('?mod=<?=$mod?>&file=uppic&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>&uploadtext=household_image','upload','350','200')\">&nbsp;&nbsp;</td><td><input type=\"button\" onclick=\"deleteInputFile(this)\" value=\"删除该项目\"></td></tr></table>";
    cell.innerHTML=createtd.replace(/(.*)(household_image)(.*)(household_image)/,"$1household_image"+imgn+"$3household_image"+imgn);
    cell.className = 'tablerow';       
}
function deleteInputFile(obj)
{
    var row = rowindex(obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode);
    var tbl = document.getElementById('household_image');
    tbl.deleteRow(row);
}
function deleteAddedInputFile(obj)
{
    var row = rowindex(obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode);
    var tbl = document.getElementById('household_image_added');
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
</script>
<body>
<?=$menu?>

<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0" class="tableborder">
  <tr>
     <td width='80%' class="tablerow">当前位置： 编辑新楼盘&gt;&gt;</td>
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
<input name='display[addtime]' type='hidden' id='addtime' value='<?=$addtime?>'>
<input name='displayid' type='hidden' id='displayid' value='<?=$displayid?>'>
<input type="hidden" name="ishtmled" value="<?=$ishtml?>" />
<input type="hidden" name="old_arrposid" value="<?=$arrposid?>">
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本信息</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>图片信息</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>联系信息</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>户型图片</td>
<td id='TabTitle4' class='title1' onclick='ShowTabs(4)'>生成页面</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
  <tr>
  <td width='151' class='tablerow'><span class="td_left"><strong>楼盘名称：</strong></span></td>
  <td class='tablerow'>
<span class="td_left">
<input name="display[name]" type="text" id="name" size="30" value="<?=$name?>">
</span>  <font color="red">*</font>&nbsp;&nbsp;&nbsp;<?=$style_edit?>
  </td>
  </tr>
    <tr>
      <td class='tablerow'><span class="td_left"><strong>开发商：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <input name="display[develop]" type="text" id="develop" size="40" value="<?=$develop?>">
        <font color="red">*</font> </span></td>
    </tr>
    <tr>
      <td  class='tablerow'><span class="td_left"><strong>所在区域：</strong></span><br>  </td>
      <td class='tablerow'><span class="td_left">
	  <span onclick="this.style.display='none';$('select_area').style.display='';" style="cursor:pointer;"><?=$AREA[$areaid]['areaname']?> <font color="red">点击重选</font></span><span id="select_area" style="display:none;">
      <?=ajax_area_select('display[areaid]', $mod, $areaid)?>
        <span style="color:red; ">*</span></span></td>
    </tr>
            <tr> 
      <td class="tablerow"><strong>推荐位置</strong></td>
      <td class="tablerow">
<?=$position?>
      </td>
	  </tr>
    <tr>
      <td  class='tablerow'><span class="td_left"><strong>物业类别：</strong></span><br>  </td>
      <td class='tablerow'><span class="td_left">
        <select name="display[housetype]" id="housetype" >
          <option value="" selected>-- 请选择 --</option>
           <?php foreach ($PARS['type'] as $k=>$v){
          echo '<option value="'.$v.'"';
		  if($v==$housetype) echo ' selected ';
		  echo '>'.$k.'</option>';
             } ?>
         
        </select>
      </span>
      </td>
    </tr>
        <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>起始价格：</strong></span></td>
      <td class='tablerow'>
        <span class="td_left">
        <INPUT name="display[startprice]" type="text" size="8" id="startprice" value="<?=$startprice?>">
元/㎡</span></td>
    </tr>
    	<tr>
      <td class='tablerow'><span class="td_left"><strong>平均价格：</strong></span></td>
      <td class='tablerow'>
        <span class="td_left">
        <INPUT name="display[avgprice]" type="text" size="8" id="avgprice"  value="<?=$avgprice?>">
元/㎡ </span></td>
</tr>

        <tr>
      <td  class='tablerow'><span class="td_left"><strong>详细地址：</strong></span><br></td>
      <td class='tablerow'><span class="td_left">
        <input name="display[address]" type="text" id="address" size="40" value="<?=$address?>">
      </span></td>
        </tr>
    <tr>
      <td class='tablerow'><span class="td_left"><strong>物业管理费：</strong></span><br>  </td>
      <td class='tablerow'><span class="td_left">
        <input name="display[managefee]" type="text" id="managefee" size="10" value="<?=$managefee?>">
      </span></td>
    </tr>
    	<tr>
      <td class='tablerow'><span class="td_left"><strong>开盘时间：</strong></span></td>
      <td class='tablerow'>
        <span class="td_left">
        <input name="display[starttime]" type="text" id="starttime" size="20" value="<?=$starttime?>">
        </span></td>
    </tr>
    	<tr>
      <td class='tablerow'><span class="td_left"><strong>入住时间：</strong></span></td>
      <td class='tablerow'>
        <span class="td_left">
        <input name="display[staytime]" type="text" id="staytime" size="20" value="<?=$staytime?>">
        </span>	  </td>
    </tr>
    <tr>
      <td class='tablerow'><span class="td_left"><strong>容积率：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <INPUT name="display[capacity]"  type="text" id="capacity" size=10 value="<?=$capacity?>">
      </span></td>
    </tr>
    <tr>
      <td class='tablerow'><span class="td_left"><strong>绿化率：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <INPUT name="display[green]"   type="text" id="green"  size=10 value="<?=$green?>">
      </span></td>
    </tr>	
	<tr>
      <td class='tablerow'><span class="td_left"><strong>建筑面积：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <INPUT  type="text" size=10 id="buildarea" name="display[buildarea]"  value="<?=$buildarea?>">
        ㎡</span></td>
    </tr>	
	<tr>
      <td class='tablerow'><span class="td_left"><strong>占地面积：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <INPUT  type="text" size=10 id="display[area]" name="display[area]"  value="<?=$area?>">
        ㎡</span></td>
    </tr>	
	<tr>
      <td class='tablerow'><span class="td_left"><strong>预售许可证：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <input name="display[licence]" type="text" id="licence" size="38" value="<?=$licence?>">
      </span></td>
    </tr>	
	<tr>
      <td class='tablerow'><span class="td_left"><strong>公交状况：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <input name="display[transit]" type="text" id="transit" size="50" value="<?=$transit?>">
      </span></td>
    </tr>	
	<tr>
      <td class='tablerow'><span class="td_left"><strong>周边配套：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <input name="display[peripheral]" type="text" id="peripheral" size="50" value="<?=$peripheral?>">
      </span></td>
    </tr>	
		  <tr>
      <td class='tablerow'><span class="td_left"><strong>楼盘简介：</strong></span></td>
      <td class='tablerow'><textarea name='display[introduce]' cols='80' rows='6' id='introduce'><?=$introduce?></textarea></td>
    </tr>
  </tbody>
  
  <tbody id='Tabs1' style='display:none'>
      <th colspan=2>图片信息</th>
    <tr>
      <td width='151' class='tablerow'><strong>楼盘示意图：</strong></td>
      <td width='849' class='tablerow'><span class="td_left">
        <input  name="display[image]"  type="text" id="image" size="40" readonly  value="<?=$image?>">
        <input name="btn12" type="button" onClick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&&uploadtext=image&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','360','300')" value="上传">
请到模块配置内更改默认生成缩略图高宽      </span></td>
    </tr>
	 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>位置图:</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <input  name="display[img1]"  type="text" id="img1" size="40" readonly value="<?=$img1?>">
        <input name="btn22" type="button" onClick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=img1&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','360','300')" value="上传">
</span></td>
    </tr>
	 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>环境图:</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <input  name="display[img2]"  type=text id="img2" size=40 readonly value="<?=$img2?>">
        <input name="btn32" type="button" onClick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=img2&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','360','300')" value="上传">
</span></td>
    </tr>
	 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>室内图:</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <input  name="display[img3]"  type=text id="img3" size=40 readonly value="<?=$img3?>">
        <input name="btn42" type="button" onClick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=img3&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','360','300')" value="上传">
      </span></td>
    </tr>		
  </tbody>
  
  <tbody id='Tabs2' style='display:none'>
    <th colspan=2>联系信息</th>    
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>售楼地址：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <INPUT  name="display[saleaddress]"  type=text id="saleaddress" size='40' value="<?=$saleaddress?>">
      </span></td>
    </tr>
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>售楼热线：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <input  name="display[saletele]"  type=text id="saletele" size='20'  value="<?=$saletele?>">
      </span></td>
    </tr>
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>联 系 人：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <INPUT  name="display[contract]"  type=text id="contract" size='20' value="<?=$contract?>">
      </span></td>
    </tr>
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>电子邮件：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <INPUT  name="display[email]"  type=text id="email" size='20'  value="<?=$email?>">
      </span></td>
    </tr>
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>楼盘网址：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <INPUT  name="display[url]"  type='text' id="url" size='40'  value="<?=$url?>">
      </span></td>
    </tr>
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>传&nbsp;&nbsp;&nbsp;&nbsp;真：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <INPUT  name="display[fax]"  type='text' id="fax" size='20' value="<?=$fax?>">
      </span></td>
    </tr>
  </tbody>
  
  
    <tbody id='Tabs3' style='display:none'>
    <th colspan=2>户型图片</th>
    <tr>
    	<td colspan='2' class='tablerow'>    	 
        	<table cellpadding="2" cellspacing="1"  border="0"  id="uploadimage" align="center" width="100%"  style="background:white;border:#F1F3F5 1px solid;">
			<tr>
			<td class='tablerow' valign="middle" colspan="6">&nbsp;<strong>已上传的图片：</strong></td>
			</tr>
			<?php
			if(is_array($holdimages))
			{
				foreach ($holdimages as $k=>$uploadimage)
				{
				?>
			<tr>
			<td class='tablerow' valign="middle">
			<?php echo ++$k;?>、房型标题<input type="text" name="householdimage_title[]" size="18" value="<?=$uploadimage['title']?>"/>&nbsp;&nbsp;面积:<input type="text" name="householdimage_area[]"  value="<?=$uploadimage['area']?>" size="10" />㎡&nbsp;&nbsp;图片:<input type="text" name="householdimage_url[]"  size="34" id="household_image"  value="<?=$uploadimage['image']?>"/>&nbsp;<input type="button" value=" 上传 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=household_image&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','350','200')">&nbsp;<input type="button" value=" 删 除 " onclick="javascript:deleteAddedInputFile(this)">
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
			<td class='tablerow' valign="middle" id='createtd'><table cellpadding="2" cellspacing="1" border="0"><tr><td>
			房型标题:<input type="text" name="householdimage_title[]" size="18" value="__室__厅__卫__厨"/>&nbsp;&nbsp;面积:<input type="text" name="householdimage_area[]" size="10" />㎡&nbsp;&nbsp;图片:<input type="text" name="householdimage_url[]"  size="20" id="household_image"/>&nbsp;<input type="button" value=" 上传 " onclick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=household_image&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','350','200')">&nbsp;&nbsp;</td><td><input type="button"  onclick="addInputFile(this)" value="增加房型图" style="color:blue;"></td></tr></table></td>
			</tr>
			</table>
    	</td>
    </tr>  
      <tbody id='Tabs4' style='display:none'>
    <th colspan=2>生成页面</th>
    	 <tr> 
      <td class="tablerow">是否生成</td>
      <td class="tablerow"><input type="radio" name="display[ishtml]" value="1" <?php if($ishtml==1) {?>checked <?php } ?> id="ishtml"  onclick="$('htmlrule').style.display='';$('htmlprefix').style.display='';$('htmldir').style.display='';$('phprule').style.display='none';"> 是 <input type="radio" name="display[ishtml]" value="0" <?php if($ishtml==0) {?>checked <?php } ?> onclick="$('htmlrule').style.display='none';$('htmldir').style.display='none';$('htmlprefix').style.display='none';$('phprule').style.display='';"> 否</td>
    </tr>
		<tr id="htmldir" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件生成目录</td>
		  <td class="tablerow"><input type="text" name="display[htmldir]" value="<?=$htmldir?>" id="htmldir" ></td>
		</tr>
		<tr id="htmlprefix" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件名前缀</td>
		  <td class="tablerow"><input type="text" name="display[prefix]" id="prefix" value="<?=$prefix?>"></td>
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



</body>
</html>