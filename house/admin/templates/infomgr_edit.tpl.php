<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script src="<?=PHPCMS_PATH?>include/js/checkform.js"></script>
<script language='JavaScript' type='text/JavaScript'>

function CheckForm(){
	var cf = new Check("myform");
	cf.must('validperiod','有效期不得为空');
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
     <td width='80%' class="tablerow">当前位置： 编辑<?=$infotypename?>信息&gt;&gt;</td>
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
<input name='house[addtime]' type='hidden' id='addtime' value='<?=$addtime?>'>
<input name='houseid' type='hidden' id='houseid' value='<?=$houseid?>'>
<input name='typeid' type='hidden' id='typeid' value='<?=$typeid?>'>
<input type="hidden" name="ishtmled" value="<?=$ishtml?>" />
<input type="hidden" name="old_arrposid" value="<?=$arrposid?>">
<table width='100%' border='0' cellpadding='0' cellspacing='0'>
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本信息</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>图片信息</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>联系信息</td>
<td id='TabTitle3' class='title1' onclick='ShowTabs(3)'>生成页面</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
  <tr>
  <td width='151' class='tablerow'><span class="td_left"><strong>信息类别：</strong></span></td>
  <td class='tablerow'>
<span class="td_left">
<font color="red"><strong><?=$infotypename?></strong></font></span>&nbsp;</td>
  </tr>
    <tr>
      <td class='tablerow'><span class="td_left"><strong>有效期：</strong></span></td>
      <td class='tablerow'><span class="td_left">
		<select name="house[validperiod]" id="validperiod">
          <option value="">-- 请选择 --</option>                       
             <?php foreach ($PARS['period'] as $k=>$v){
          echo '<option value="'.$v.'"';
		  if($v==$validperiod) echo ' selected ';
		  echo '>'.$k.'</option>';
             } ?>
        </select>
        <span style="color:red; ">*</span></span></td>
    </tr>
	<?php if($typeid==3){?>
    <tr>
      <td  class='tablerow'><span class="td_left"><strong>是否有房：</strong></span><br>  </td>
      <td class='tablerow'><span class="td_left">
        <input name="coop[havehouse]" type="radio" value="1"  <?php if (1==$havehouse) echo " checked ";?>>有
		<input type="radio" name="coop[havehouse]" value="0"  <?php if (0==$havehouse) echo " checked ";?>>无 </span></td>
    </tr>
	        <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>我的性别：</strong></span></td>
      <td class='tablerow'>
        <span class="td_left">
        <select name="coop[mygender]" id="mygender">
          <option value="">-- 不限 --</option>
          <option value="1" <?php if ('1'==$mygender) echo " selected ";?>>男</option>
          <option value="2" <?php if ('2'==$mygender) echo " selected ";?>>女</option>
        </select>
        </span></td>
    </tr>
    	<tr>
      <td class='tablerow'><span class="td_left"><strong>你的性别：</strong></span></td>
      <td class='tablerow'>
        <span class="td_left">
        <select name="coop[yourgender]" id="yourgender">
          <option value="">-- 不限 --</option>
          <option value="1"  <?php if ('1'==$yourgender) echo " selected ";?>>男</option>
          <option value="2"  <?php if ('1'==$yourgender) echo " selected ";?>>女</option>
        </select>
        </span></td>
</tr>
<? } ?>
            <tr> 
      <td class="tablerow"><strong>推荐位置</strong></td>
      <td class="tablerow">
<?=$position?>
      </td>
	  </tr>
    <tr>
      <td  class='tablerow'><span class="td_left"><strong>房&nbsp;&nbsp;型：</strong></span><br>  </td>
      <td class='tablerow'><span class="td_left">
        <select name="type_1" id="select4" style="FONT-SIZE: 9pt; WIDTH: 40px">
          <option <?php if (''==$type_1) echo " selected ";?>>不限</option>
          <option value="〇" <?php if ('〇'==$type_1) echo " selected ";?>>〇</option>
          <option value="一" <?php if ('一'==$type_1) echo " selected ";?>>一</option>
          <option value="二" <?php if ('二'==$type_1) echo " selected ";?>>二</option>
          <option value="三" <?php if ('三'==$type_1) echo " selected ";?>>三</option>
          <option value="四" <?php if ('四'==$type_1) echo " selected ";?>>四</option>
          <option value="五" <?php if ('五'==$type_1) echo " selected ";?>>五</option>
          <option value="六" <?php if ('六'==$type_1) echo " selected ";?>>六</option>
          <option value="七" <?php if ('七'==$type_1) echo " selected ";?>>七</option>
          <option value="八" <?php if ('八'==$type_1) echo " selected ";?>>八</option>
          <option value="九" <?php if ('九'==$type_1) echo " selected ";?>>九</option>
          <option value="十" <?php if ('十'==$type_1) echo " selected ";?>>十</option>
        </select>
室
<select name="type_2" id="select4" style="FONT-SIZE: 9pt; WIDTH: 40px">
          <option <?php if (''==$type_2) echo " selected ";?>>不限</option>
          <option value="〇" <?php if ('〇'==$type_2) echo " selected ";?>>〇</option>
          <option value="一" <?php if ('一'==$type_2) echo " selected ";?>>一</option>
          <option value="二" <?php if ('二'==$type_2) echo " selected ";?>>二</option>
          <option value="三" <?php if ('三'==$type_2) echo " selected ";?>>三</option>
          <option value="四" <?php if ('四'==$type_2) echo " selected ";?>>四</option>
          <option value="五" <?php if ('五'==$type_2) echo " selected ";?>>五</option>
          <option value="六" <?php if ('六'==$type_2) echo " selected ";?>>六</option>
          <option value="七" <?php if ('七'==$type_2) echo " selected ";?>>七</option>
          <option value="八" <?php if ('八'==$type_2) echo " selected ";?>>八</option>
          <option value="九" <?php if ('九'==$type_2) echo " selected ";?>>九</option>
          <option value="十" <?php if ('十'==$type_2) echo " selected ";?>>十</option>
        </select>
厅
<select name="type_3" id="select4" style="FONT-SIZE: 9pt; WIDTH: 40px">
          <option <?php if (''==$type_3) echo " selected ";?>>不限</option>
          <option value="〇" <?php if ('〇'==$type_3) echo " selected ";?>>〇</option>
          <option value="一" <?php if ('一'==$type_3) echo " selected ";?>>一</option>
          <option value="二" <?php if ('二'==$type_3) echo " selected ";?>>二</option>
          <option value="三" <?php if ('三'==$type_3) echo " selected ";?>>三</option>
          <option value="四" <?php if ('四'==$type_3) echo " selected ";?>>四</option>
          <option value="五" <?php if ('五'==$type_3) echo " selected ";?>>五</option>
        </select>
卫
<select name="type_4" id="select4" style="FONT-SIZE: 9pt; WIDTH: 40px">
          <option <?php if (''==$type_4) echo " selected ";?>>不限</option>
          <option value="〇" <?php if ('〇'==$type_4) echo " selected ";?>>〇</option>
          <option value="一" <?php if ('一'==$type_4) echo " selected ";?>>一</option>
          <option value="二" <?php if ('二'==$type_4) echo " selected ";?>>二</option>
          <option value="三" <?php if ('三'==$type_4) echo " selected ";?>>三</option>
          <option value="四" <?php if ('四'==$type_4) echo " selected ";?>>四</option>
          <option value="五" <?php if ('五'==$type_4) echo " selected ";?>>五</option>
        </select>
阳台<span style="color:red; ">*</span></span></td>
    </tr>


        <tr>
      <td  class='tablerow'><span class="td_left"><strong>所在区域：</strong></span><br></td>
      <td class='tablerow'><span class="td_left">
	  <span onclick="this.style.display='none';$('select_area').style.display='';" style="cursor:pointer;"><?=$AREA[$areaid]['areaname']?> <font color="red">点击重选</font></span><span id="select_area" style="display:none;">
      <?=ajax_area_select('house[areaid]', $mod, $areaid)?>
        <span style="color:red; ">*</span> </span></td>
        </tr>
    <tr>
      <td class='tablerow'><span class="td_left"><strong>
	  <? if ($typeid==2||$typeid==5){?>期望商圈/区域：<? }else{?>物业地址：<? }?>
	  </strong></span><br>  </td>
      <td class='tablerow'><span class="td_left">
        <input name="house[name]" type="text" id="name" size="20"  value="<?=$name?>">
&nbsp;
<?=$style_edit?>
</span></td>
    </tr>
    	<tr>
      <td class='tablerow'><span class="td_left"><strong>所在楼层：</strong></span></td>
      <td class='tablerow'>
        <span class="td_left">
        第
        <INPUT name="house[currentfloor]" type="text" id="currentfloor" size=2  value="<?=$currentfloor?>">
层/共
<INPUT  type="text" name="house[totalfloor]" id="totalfloor" size=2   value="<?=$totalfloor?>">
层</span></td>
    </tr>
    	<tr>
      <td class='tablerow'><span class="td_left"><strong>建筑面积：</strong></span></td>
      <td class='tablerow'>
        <span class="td_left">
        <INPUT  type="text" size=10 id="buildarea" name="house[buildarea]"   value="<?=$buildarea?>">
        <FONT 
            face=宋体 size=3>㎡</FONT></span>	  </td>
    </tr>
    <tr>
      <td class='tablerow'><span class="td_left"><strong>使用面积：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <INPUT   type="text" size=10 id="usearea" name="house[usearea]" value="<?=$usearea?>">
        <FONT 
            face=宋体 size=3>㎡</FONT></span></td>
    </tr>
    <tr>
      <td class='tablerow'><span class="td_left"><strong>装潢程度：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <select name="house[decorate]" id="decorate">
          <option value="">-- 请选择 --</option>                       
             <?php foreach ($PARS['decorate'] as $k=>$v){
          echo '<option value="'.$v.'"';
		  if($v==$decorate) echo ' selected ';
		  echo '>'.$k.'</option>';
             } ?>
        </select>
        <span style="color:red; ">*</span></span></td>
    </tr>	
	<tr>
      <td class='tablerow'><span class="td_left"><strong>物业管理：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <input name="house[manage]" type="radio" value="1"  <?php if (1==$manage) echo " checked ";?>>有
<input type="radio" name="house[manage]" value="0" <?php if (0==$manage) echo " checked ";?>>无</span></td>
    </tr>	
	<tr>
      <td class='tablerow'><span class="td_left"><strong>房产类型：</strong></span></td>
      <td class='tablerow'><span class="td_left">
			    <select name="house[propertytype]" id="propertytype">
          <option value="">-- 请选择 --</option>                       
             <?php foreach ($PARS['type'] as $k=>$v){
          echo '<option value="'.$v.'"';
		  if($v==$propertytype) echo ' selected ';
		  echo '>'.$k.'</option>';
             } ?>
        </select>
        <span style="color:red; ">*</span> </span></td>
    </tr>	
	<tr>
      <td class='tablerow'><span class="td_left"><strong>建成时间：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <INPUT type="text" size="6" name="house[buildtime]" value="<?=$buildtime?>">
        年左右</span></td>
    </tr>	
	<tr>
      <td class='tablerow'><span class="td_left"><strong>房屋朝向：</strong></span></td>
      <td class='tablerow'><span class="td_left">
		 <select name="house[towards]" id="towards">
          <option value="">-- 请选择 --</option>                       
             <?php foreach ($PARS['towards'] as $k=>$v){
          echo '<option value="'.$v.'"';
		  if($v==$towards) echo ' selected ';
		  echo '>'.$k.'</option>';
             } ?>
        </select>
      </span></td>
    </tr>	
	<tr>
      <td class='tablerow'><span class="td_left"><strong><? if($typeid==1||$typeid==2||$typeid==3){?>租&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;金：<? }else{?>交易价格：<? }?></strong></span></td>
      <td class='tablerow'><span class="td_left">
        <INPUT name="house[price]" type="text" size="8" value="<?=$price?>">
        <select name="house[unit]" id="unit" >
          <option value="1" <?php if (1==$unit) echo " selected ";?>>元/月</option>
          <option value="2" <?php if (2==$unit) echo " selected ";?>>元/季度</option>
          <option value="3" <?php if (3==$unit) echo " selected ";?>>元/年</option>
          <option value="4" <?php if (4==$unit) echo " selected ";?>>元/天</option>
          <option value="5" <?php if (5==$unit) echo " selected ";?>>元/平米*天</option>
          <option value="6" <?php if (6==$unit) echo " selected ";?>>元</option>
          <option value="7" <?php if (7==$unit) echo " selected ";?>>万元</option>
        </select>
(0为面议)<span style="color:red; ">*</span></span></td>
    </tr>	
	
	<tr>
      <td class='tablerow'><span class="td_left"><strong>基础设施：</strong></span></td>
      <td class='tablerow'><span class="td_left">
	  <?php foreach ($PARS['infrastructure'] as $k=>$v){
          echo '<input type="checkbox" value="'.$v.'" name="house[infrastructure][]" ';
		  if (in_array($v,$infrastructure)) echo " checked ";
		  echo ">".$k;
           } ?>
		</span></td>
    </tr>	
		<tr>
      <td class='tablerow'><span class="td_left"><strong>室内设施：</strong></span></td>
      <td class='tablerow'><span class="td_left">
	  <?php foreach ($PARS['indoor'] as $k=>$v){
          echo '<input type="checkbox" value="'.$v.'" name="house[indoor][]" ';
		  if (in_array($v,$indoor)) echo " checked ";
		  echo ">".$k;
           } ?>
</span></td>
    </tr>	
		<tr>
      <td class='tablerow'><span class="td_left"><strong>周边设施：</strong></span></td>
      <td class='tablerow'><span class="td_left">
	   <?php foreach ($PARS['peripheral'] as $k=>$v){
          echo '<input type="checkbox" value="'.$v.'" name="house[peripheral][]" ';
		  if (in_array($v,$peripheral)) echo " checked ";
		  echo ">".$k;
           } ?>
</span></td>
    </tr>	
			<tr>
      <td class='tablerow'><span class="td_left"><strong>公交状况：</strong></span></td>
      <td class='tablerow'><span class="td_left">
        <input name="house[transit]" type="text" id="house[transit]" size="60" value="<?=$transit?>">
      </span></td>
    </tr>	
		  <tr>
      <td class='tablerow'><span class="td_left"><strong>其他描述：</strong></span></td>
      <td class='tablerow'><textarea name='house[description]' cols='80' rows='6' id='description'> <?=$description?> </textarea></td>
    </tr>
  </tbody>
  
  <tbody id='Tabs1' style='display:none'>
      <th colspan=2>图片信息</th>
    <tr>
      <td width='151' class='tablerow'><strong>位置图：</strong></td>
      <td width='849' class='tablerow'><span class="td_left">
        <input  name="house[img1]"  type="text" id="image" size="40" readonly  value="<?=$img1?>">
        <input name="btn12" type="button" onClick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=img1&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','360','300')" value="上传">
请到模块配置内更改默认生成缩略图高宽      </span></td>
    </tr>
	 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>环境图:</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <input  name="house[img2]"  type="text" id="img2" size="40" readonly value="<?=$img2?>">
        <input name="btn22" type="button" onClick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=img2&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','360','300')" value="上传">
</span></td>
    </tr>
	 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>室内图:</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <input  name="house[img3]"  type=text id="img3" size=40 readonly value="<?=$img2?>">
        <input name="btn32" type="button" onClick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=img3&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','360','300')" value="上传">
</span></td>
    </tr>
	 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>户型图:</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <input  name="house[img4]"  type=text id="img4" size=40 readonly value="<?=$img3?>">
        <input name="btn42" type="button" onClick="javascript:openwinx('?mod=<?=$mod?>&file=uppic&uploadtext=img4&type=both&width=<?=$MOD['thumb_width']?>&height=<?=$MOD['thumb_height']?>','upload','360','300')" value="上传">
      </span></td>
    </tr>		
  </tbody>
  
  <tbody id='Tabs2' style='display:none'>
    <th colspan=2>联系信息</th>    
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>联 系 人：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <INPUT  name="house[contract]"  type=text id="contract" size='40' value="<?=$contract?>">
      </span></td>
    </tr>
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>联系电话：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <input  name="house[telephone]"  type=text id="telephone" size='20'  value="<?=$telephone?>">
      </span></td>
    </tr>
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>电子邮件：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <INPUT  name="house[email]"  type=text id="email" size='20' value="<?=$email?>">
      </span></td>
    </tr>
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>手&nbsp;&nbsp;&nbsp;&nbsp;机：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <INPUT  name="house[mobile]"  type=text id="mobile" size='20'  value="<?=$mobile?>">
      </span></td>
    </tr>
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>QQ：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <INPUT  name="house[qq]"  type='text' id="qq" size='40'  value="<?=$qq?>">
      </span></td>
    </tr>
		 <tr>
      <td width='151' class='tablerow'><span class="td_left"><strong>MSN：</strong></span></td>
      <td width='849' class='tablerow'><span class="td_left">
        <INPUT  name="house[msn]"  type='text' id="msn" size='20' value="<?=$msn?>">
      </span></td>
    </tr>
  </tbody>
  
  
      <tbody id='Tabs3' style='display:none'>
    <th colspan=2>生成页面</th>
    	 <tr> 
      <td class="tablerow">是否生成</td>
      <td class="tablerow"><input type="radio" name="house[ishtml]" value="1" <?php if($ishtml==1) {?>checked <?php } ?> id="ishtml"  onclick="$('htmlrule').style.display='';$('htmlprefix').style.display='';$('htmldir').style.display='';$('phprule').style.display='none';"> 是 <input type="radio" name="house[ishtml]" value="0" <?php if($ishtml==0) {?>checked <?php } ?> onclick="$('htmlrule').style.display='none';$('htmldir').style.display='none';$('htmlprefix').style.display='none';$('phprule').style.display='';"> 否</td>
    </tr>
		<tr id="htmldir" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件生成目录</td>
		  <td class="tablerow"><input type="text" name="house[htmldir]" value="<?=$htmldir?>" id="htmldir" ></td>
		</tr>
		<tr id="htmlprefix" style="display:<?php if($ishtml==0) {?>none<?php }?>"> 
		  <td class="tablerow">html文件名前缀</td>
		  <td class="tablerow"><input type="text" name="house[prefix]" id="prefix" value="<?=$prefix?>"></td>
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