<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script language='JavaScript' type='text/JavaScript'>
function CheckForm()
{
	if(document.all.siteSiteName.value=='')
	{
		ShowTabs(0);
		alert('请添加站点名称！');
		document.myform.siteSiteName.focus();
		return false;
	}
	//下面合成标签数组
	var rulekey=""; //用于保存用户标签的key 用|分割
	var rulelabelname=""; //用户标签名
	var elts= document.getElementsByName("userlabelid");
	var elts_cnt  = (typeof(elts.length) != 'undefined')? elts.length: 0;

	for (var i = 0; i < elts_cnt; i++)
	{
		rulekey=rulekey+"|"+elts[i].value;
		rulelabelname=rulelabelname+"|"+document.getElementById('rule'+elts[i].value+'name').innerHTML;
	} // en
	document.myform.ruleKey.value=rulekey;
	document.myform.ruleLabelName.value=rulelabelname;
}


function ShowLabel(objname)
{
	var obj = document.getElementById(objname);
	var objtrim = document.getElementById(objname+"trim");
	var objimg = document.getElementById(objname+"img");
	var objtrimhtml = document.getElementById(objname+"trimhtml");
	if(obj.style.display=="none")
	{
		obj.style.display = "block";
		objtrim.style.display = "block";
		objtrimhtml.style.display = "block";
		objimg.src="<?=PHPCMS_PATH?>images/icon/open.gif";
	}
	else
	{
		obj.style.display="none";
		objtrim.style.display="none";
		objtrimhtml.style.display="none";
		objimg.src="<?=PHPCMS_PATH?>images/icon/close.gif";
	}
}
function checkDeleteUserLabel()
{
	if(confirm("确认删除该标签吗？"))
	return true;
	else return false;
}
function  DeleteUserLabel(mylabelnum)
{
	//删除自定义标签
	var zhu=document.getElementById("zhu"+mylabelnum);
	var fu=document.getElementById("fu"+mylabelnum);
	zhu.innerHTML="";
	zhu.style.display="none";
	fu.innerHTML ="";
	fu.style.display="none";

}

function HtmlTrimSelect(i,status)
{
	var obj = document.getElementById("label"+i+"HtmlTrim");

	var elts= document.myform.elements["rule[HtmlTrim]["+i+"][]"];
	var elts_cnt  = (typeof(elts.length) != 'undefined')
	? elts.length
	: 0;

	if (elts_cnt) {
		for (var i = 0; i < elts_cnt; i++) {
			elts[i].checked = (status=="all")?true:false;
		} // end for
	} else {
		elts.checked        = true;
	} // end if... else

}

var labelnum=0;
function AddLabel(labelname,lnum)
{
	if(labelname==''){
		alert('请输入标签名称！');
		document.myform.userlabelname.focus();
		return;
	}

	//判断标签是否已经添加
	var elt= document.getElementsByName("userlabelid");
	var elt_cnt  = (typeof(elt.length) != 'undefined')? elt.length: 0;

	for (var i = 0; i < elt_cnt; i++)
	{
		if(labelname==document.getElementById('rule'+elt[i].value+'name').innerHTML)
		{
			alert('该标签已经存在，请更改名称！');
			document.myform.userlabelname.focus();
			return;
		}
	} // en


	labelnum=(labelnum<lnum)?lnum:labelnum+1;
	var  labelhtml="";
	labelhtml+="<tr bgcolor=\"#CCFFBB\" style=\"cursor:hand\" onClick=\"ShowLabel('label"+labelnum+"');\" >";
	labelhtml+="<td  width=\"100\"><img src=\"<?=PHPCMS_PATH?>images/icon/open.gif\" width=\"18\" height=\"18\" id='label"+labelnum+"img'><strong id='rule"+labelnum+"name'>";
	labelhtml+=labelname;
	labelhtml+="</strong>:[点击打开/隐藏标签] </td><td colspan=\"3\">&nbsp;</td>";
	labelhtml+="<td  width='80' align='right'><a href='#' onClick='if(checkDeleteUserLabel()) DeleteUserLabel("+labelnum+");'>删除</a>&nbsp;No."+labelnum+"&nbsp;</td></tr>";
	labelhtml+="<tr id='label"+labelnum+"' style='display:block'>";
	labelhtml+="<td width=\"100\" class='tablerow' align=\"center\"><font color=blue>匹配信息</font></td>";
	labelhtml+="<td align=\"left\" class='tablerow'><table width=\"98%\"  border=\"0\">";
	labelhtml+="<tr>";
	labelhtml+="<td width=\"13\">从</td>";
	labelhtml+="<td ><textarea name=\"rule[StartStr]["+labelnum+"]\" cols=\"26\" rows=\"4\" id=\"rule"+labelnum+"StartStr\"></textarea></td>";
	labelhtml+="<td width=\"13\">到</td>";
	labelhtml+="<td width=\"200\"><textarea name=\"rule[EndStr]["+labelnum+"]\" cols=\"26\" rows=\"4\" id=\"rule"+labelnum+"EndStr\"></textarea></td><td  width=\"150\">&nbsp;通配符: <a href=\"javascript:AddOnPos(document.myform.rule"+labelnum+"StartStr,'(*)');\"  style='color:#3300FF;'>(*)</a><br>";
	labelhtml+="&nbsp;通配符:<a  href=\"javascript:AddOnPos(document.myform.rule"+labelnum+"EndStr,'(*)');\"  style=\"color:#3300FF;\">(*)</a></td> ";
	labelhtml+="</tr>";
	labelhtml+="</table> </td>";
	labelhtml+="</tr>";
	labelhtml+="<tr id='label"+labelnum+"trim' style='display:block'>";
	labelhtml+="<td class='tablerow'  align=\"center\"><font color=blue>信息替换删除<br>";
	labelhtml+="</font> 后项可留空，替换为空即相当于删除 <br>";
	labelhtml+="</td>";
	labelhtml+="<td align=\"left\" class='tablerow'><table width=\"98%\"  border=\"0\">";
	labelhtml+="<tr>";
	labelhtml+="<td width=\"13\">将</td>";
	labelhtml+="<td><textarea name=\"rule[TrimStart]["+labelnum+"]\" cols=\"26\" rows=\"5\" id=\"rule"+labelnum+"TrimStarta\"></textarea></td>";
	labelhtml+="<td width=\"13\">替换为 </td>";
	labelhtml+="<td width=\"200\"><textarea name=\"rule[TrimEnd]["+labelnum+"]\" cols=\"26\" rows=\"5\" id=\"rule"+labelnum+"TrimEnda\"></textarea></td><td  width=\"150\">  替换代码通配符: <a href=\"javascript:AddOnPos(document.myform.rule"+labelnum+"TrimStarta,'(*)');\"  style='color:#3300FF;'>(*)</a><br>";
	labelhtml+="&nbsp;多个替换条件间隔符:<a  href=\"javascript:AddSeperate(document.myform.rule"+labelnum+"TrimStarta,document.myform.rule"+labelnum+"TrimEnda,'(|)')\"  style=\"color:#3300FF;\">(|)</a></td>";
	labelhtml+="</tr>";
	labelhtml+="</table></td>";
	labelhtml+="</tr>";
	labelhtml+="<tr id='label"+labelnum+"trimhtml' style='display:block'>";
	labelhtml+="<td class='tablerow'  align=\"center\"><font color=blue>Html自动清除<br>";
	labelhtml+="</font> </td>";
	labelhtml+="<td class='tablerow'>&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"0\" id=\"rule["+labelnum+"][HtmlTrim][]\">";
	labelhtml+=" 链接&lt;a&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"1\">";
	labelhtml+="换行&lt;br&gt;&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"2\">";
	labelhtml+="表格&lt;table&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"3\">";
	labelhtml+="表格行&lt;tr&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"4\">";
	labelhtml+="单元&lt;td&nbsp;&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"5\">";
	labelhtml+="段落&lt;p&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"6\">";
	labelhtml+="字体&lt;font&nbsp;";
	labelhtml+="<input name=\"buttonall"+labelnum+"\" type=\"button\" onClick=\"HtmlTrimSelect("+labelnum+",'all');\" value=\"全选\">";
	labelhtml+="<br>";
	labelhtml+="&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"7\">";
	labelhtml+="层&lt;div&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"8\">";
	labelhtml+="Span&lt;span&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"9\">";
	labelhtml+="表格体&lt;tbody&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"10\">";
	labelhtml+="加粗&lt;b&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"11\">";
	labelhtml+="图象&lt;img&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"12\">";
	labelhtml+="空格&amp;&nbsp;";
	labelhtml+="<input type=\"checkbox\" name=\"rule[HtmlTrim]["+labelnum+"][]\" value=\"13\">";
	labelhtml+="脚本&lt;script&nbsp;";
	labelhtml+="<input name=\"buttonnone"+labelnum+"\" type=\"button\" onClick=\"HtmlTrimSelect("+labelnum+",'none');\" value=\"全空\">";
	labelhtml+="<input type=\"hidden\" name=\"userlabelid\" value='"+labelnum+"'></td>";
	labelhtml+="</tr>";

	document.all.userlabel.innerHTML+="<div id=\"zhu"+labelnum+"\" style=\"display:block\"><table cellpadding='0' cellspacing='0' border='0' width='96%' class='border' align='center' >"+labelhtml+"</table>";
	document.all.userlabel.innerHTML+="<div id=\"fu"+labelnum+"\"  style=\"display:block\"><table width='100%' align='center'><tr ><td background='<?=PHPCMS_PATH?>/images/spacer.gif'></td></tr></table>";
	//document.all.userlabel.innerHTML+=labelhtml;
	//document.all.userlabel.innerHTML+="</table>";
	//alert(document.all.userlabel.innerHTML);
}

function ShowItem(objname)
{
	var obj = document.getElementById(objname);
	obj.style.display = "block";
}

function HideTabTitle(displayValue,tempType)
{
	for (var i = 1; i < 5; i++)
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

function AddOnPos(obj, charvalue)
{
	//obj代表要插入字符的输入框
	//value代表要插入的字符

	obj.focus();
	var r = document.selection.createRange();
	var ctr = obj.createTextRange();
	var i;
	var s = obj.value;

	//注释掉的这种方法只能用在单行的输入框input内
	//对多行输入框textarea无效
	//r.setEndPoint("StartToStart", ctr);
	//i = r.text.length;
	//取到光标位置----Start----
	var ivalue = "&^asdjfls2FFFF325%$^&";
	r.text = ivalue;
	i = obj.value.indexOf(ivalue);
	r.moveStart("character", -ivalue.length);
	r.text = "";
	//取到光标位置----End----
	//插入字符
	obj.value = s.substr(0,i) + charvalue + s.substr(i,s.length);
	ctr.collapse(true);
	ctr.moveStart("character", i + charvalue.length);
	ctr.select();
}

function AddSeperate(objstart,objend,charvalue)
{
	objstart.value=objstart.value+charvalue;
	objend.value=objend.value+charvalue;
	objstart.focus();
}

</script>
<style type="text/css">
<!--
.style1 {
	font-family: "fixedsys";
	font-size: 24px;
}
-->
</style>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&id=<?=$id?>" >
<table width='100%' border='0' cellpadding='0' cellspacing='0' >
<tr align='center' height='24'>
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>基本信息</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>站点规则</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
    <tr> 
      <td class="tablerow">站点名称</td>
      <td class="tablerow">
      <input size=40 name="site[SiteName]" id="siteSiteName" type="text"> <font color="red">*</font>
     </td>
    </tr>
	<tr> 
	<td class="tablerow">站点URL</td>
	<td class="tablerow">
	<input size=60 name="site[SiteUrl]" type="text" value="http://">
	</td>
	</tr>
	<tr> 
	<td class="tablerow">站点描述</td>
	<td class="tablerow">
	<textarea name='site[Description]' cols='64' rows='10' id='code'></textarea>
	</td>
	</tr>
 
  <tr>
    <td>
  <tbody id='Tabs1' style='display:none'>
  <th colspan=2>站点规则 (可选，可以在任务中重新编辑)</th>
    <tr>
    <td  class='tablerow'><strong>规则说明</strong>:<br></td>
    <td class='tablerow'><font color="red"><strong>添加好整个站点的规则后，添加采集任务的规则即可从所属的站点规则中直接派生！</strong></font><br>
	<font color="blue">匹配信息</font><br>填入能够包裹起匹配的前后两段唯一字符串<br>
	<font color="blue">信息替换删除</font><br>1、替换为排除和合并在一起的，将第二项留空，替换为空即相当于排除<br>
		2、不用使用用正则，变动的代码使用(*)代替即可<br>
		3、当替换次数不止一次时，两项均使用(|)分割多个替换条件。如配置abcd(|)xyz替换为1(|)2即将abcd替换为1，xyz替换为2</td>
  </tr>
  <?php   
  $i=0;
  if(is_array($labels)){
  	foreach($labels as $label){
  		$i++;
?>
  <tr bgcolor="#CCFFCC">
    <td colspan="2"  style="cursor:hand" onClick="ShowLabel('<?=$label["name"]?>');"><table width="100%"  border="0">
        <tr>
          <td width="78%"><img src="<?=PHPCMS_PATH?>images/icon/<?=$label["imgstatus"]?>.gif" width="18" height="18" id="<?=$label["name"]?>img">
		  <strong  id='rule<?=$i?>name'><?=$label["name"]?></strong>: [点击打开/隐藏标签] </td>
          <td width="22%" align="right">No.<?=$i?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  <tr  id="<?=$label["name"]?>" style="display:<?=$label["displaystatus"]?>">
    <td width="90" class='tablerow' align="center"><font color=blue>匹配信息</font></td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">从</td>
        <td width="223"><textarea name="rule[StartStr][<?=$i?>]" cols="30" rows="4" id="rule<?=$i?>StartStr"></textarea></td>
        <td width="13">到</td>
        <td width="223"><textarea name="rule[EndStr][<?=$i?>]" cols="30" rows="4" id="rule<?=$i?>EndStr"></textarea></td>
        <td width="349">通配符:<a href="javascript:AddOnPos(document.myform.rule<?=$i?>StartStr,'(*)');" style="color:#3300FF;">(*)</a>
		&nbsp; 通配符:<a href="javascript:AddOnPos(document.myform.rule<?=$i?>EndStr,'(*)');" style="color:#3300FF;">(*)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="<?=$label["name"]?>trim" style="display:<?=$label["displaystatus"]?>">
    <td class='tablerow'  align="center"><font color=blue>信息替换删除<br>
      </font> 后项可留空，替换为空即相当于删除 <br>
    </td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">将</td>
        <td width="223">
		<textarea name="rule[TrimStart][<?=$i?>]" cols="30" rows="5" id="rule<?=$i?>TrimStart"></textarea> </td>
        <td width="13">替换为 </td>
        <td width="223"><textarea name="rule[TrimEnd][<?=$i?>]" cols="30" rows="5" id="rule<?=$i?>TrimEnd"></textarea>          </td>
        <td width="349">替换代码通配符:<a href="javascript:AddOnPos(document.myform.rule<?=$i?>TrimStart,'(*)');"  style="color:#3300FF;">(*)</a>
		&nbsp; 多个替换条件间隔符:<a href="javascript:AddSeperate(document.myform.rule<?=$i?>TrimStart,document.myform.rule<?=$i?>TrimEnd,'(|)');" style="color:#3300FF;">(|)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="<?=$label["name"]?>trimhtml" style="display:<?=$label["displaystatus"]?>">
    <td class='tablerow'  align="center"><font color=blue>Html自动清除<br>
    </font> </td>
    <td class='tablerow'>&nbsp;
        <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="0" id="rule<?=$i?>HtmlTrim">
      链接&lt;a&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="1">
      换行&lt;br&gt;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="2">
      表格&lt;table&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="3">
      表格行&lt;tr&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="4">
      单元&lt;td&nbsp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="5">
      段落&lt;p&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="6">
      字体&lt;font&nbsp;
      <input name="buttonall<?=$i?>" type="button" onClick="HtmlTrimSelect(<?=$i?>,'all');" value="全选">
      <br>
&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="7">
      层&lt;div&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="8">
      Span&lt;span&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="9">
      表格体&lt;tbody&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="10">
      加粗&lt;b&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="11">
      图象&lt;img&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="12">
      空格&amp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$i?>][]" value="13">
      脚本&lt;script&nbsp;
      <input name="buttonnone<?=$i?>" type="button" onClick="HtmlTrimSelect(<?=$i?>,'none');" value="全空">
	  <input type="hidden" name="userlabelid" value="<?=$i?>"></td>
  </tr>
  <?php
  	}
  }
  ?>
  <tr>
    <td colspan="2" class='tablerow'><strong>自定义标签名称:</strong>
        <input name='userlabelname' type='text' id='userlabelname' size='10' value="简介">
&nbsp;
      <input name="buttonaddlabel" type="button" onClick="AddLabel(document.myform.userlabelname.value,<?=++$i?>);" value="添加标签"></td>
  </tr>
  <tr><td  class='tablerow' colspan="2" >
    <div id='userlabel'></div>
  </td></tr>
  <tr>
    <td class='tablerow'><strong>文章分页合并</strong></td>
    <td valign="middle" class='tablerow'><table width="98%"  border="0">
        <tr>
          <td width="100">分页代码：从</td>
          <td width="223"><textarea name="rule[DividePageStart]" cols="26" rows="4" id="ruleDividePageStart"></textarea>            </td>
          <td width="13">到</td>
          <td width="223"><textarea name="rule[DividePageEnd]" cols="26" rows="4" id="ruleDividePageEnd"></textarea></td>
          <td width="220"><input type='radio' name='rule[DividePageStyle]'  value='0' checked>
全部列出模式
  <br>
  <input type='radio' name='rule[DividePageStyle]' value='1'>上下页模式</td>
<td width="150">
通配符:<a href="javascript:AddOnPos(document.myform.ruleDividePageStart,'(*)');" style="color:#3300FF;">(*)</a><br><br>
通配符:<a href="javascript:AddOnPos(document.myform.ruleDividePageEnd,'(*)');" style="color:#3300FF;">(*)</a>
		</td>
          </tr>		  
      </table>            </td>
    </tr>
	<tr style="display:none ">
    <td width="192"  class='tablerow'><strong>测试地址:</strong>      </td>
    <td width="*" class='tablerow'><input name='job[TestPageUrl]' type='text' id='jobTestPageUrl' size='66'>
      <input name="buttontestrule" type="button" onClick="buttontestrule();" value="测试规则"></td>
      </tr>
	
  <tr>
    <td>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<input type="hidden" name="ruleKey" id="ruleKey" value="">
	<input type="hidden" name="ruleLabelName" id="ruleLabelName" value="">
	<input type="submit" name="Submit" value="保存设置" onClick="return CheckForm();"></td>
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
      因为一般站点的规则都比较统一，建议在添加好站点的基本信息后添加整个站点的规则！
    </td>
  </tr>
</table>
</body>
</html>