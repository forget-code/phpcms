<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script language='JavaScript' type='text/JavaScript'>
function CheckForm()
{
  if(document.all.jobJobName.value=='')
  {
  	ShowTabs(0);
    alert('请添加任务名称！');
    document.myform.jobJobName.focus();
    return false;   
  }
  if(document.myform.jobSiteId.value=='0')
  {
  	ShowTabs(0);
    alert('请选择该任务所属的站点！');
    document.myform.jobSiteId.focus();
    return false;   
  }
 
  var radio=document.getElementsByName("StartStyle");
  if(radio[1].checked)
  {
   if(document.myform.MultiUrl.value==''||document.myform.MultiUrl.value=='http://')
   {
    ShowTabs(0);
    alert('您选择的多网页采集网址的形式，请填写网页地址！');
    document.myform.MultiUrl.focus();
    return false;
   }
  }
  else if(radio[2].checked)
  {
   if(document.myform.SimilarUrl.value==''||document.myform.SimilarUrl.value=='http://')
   {
    ShowTabs(0);
    alert('您选择的采集相似网页网址的形式，请填写网页地址格式！');
    document.myform.SimilarUrl.focus();
    return false;
   }
   if(document.myform.SimilarUrl.value.indexOf('(*)')<0)
   {
    ShowTabs(0);
    alert("您的网页地址格式中不包含通配符(*)，请更改或选择其他的网址样式！");
    document.myform.SimilarUrl.focus();
    return false;
   }
   if(document.myform.StarNumStart.value==""||document.myform.StarNumEnd.value==""||isNaN(document.myform.StarNumStart.value)||isNaN(document.myform.StarNumEnd.value))
   {
    ShowTabs(0);
    alert('通配符范围不为空且应为数字！');
    document.myform.StarNumStart.focus();
    return false;
   }
    if(document.myform.StarNumStart.value==""||document.myform.StarNumEnd.value==""||isNaN(document.myform.StarNumStart.value)||isNaN(document.myform.StarNumEnd.value))
   {
    ShowTabs(0);
    alert('通配符范围不为空且应为数字！');
    document.myform.StarNumStart.focus();
    return false;
   }
   if(document.myform.StarNumTime.value==""||isNaN(document.myform.StarNumTime.value))
   {
    ShowTabs(0);
    alert('通配符范围的步长倍数不为空且应为数字！');
    document.myform.StarNumTime.focus();
    return false;
   }
   
  }
  else if(document.myform.SingleUrl.value==''||document.myform.SingleUrl.value=='http://')
   {
    ShowTabs(0);
    alert('您选择的单网页采集网址的形式，请填写网页地址！');
    document.myform.SingleUrl.focus();
    return false;  
  }
  	var img= document.getElementById("jobDownImg");
  	img.value=(img.checked==true)?1:0;
  	var swf= document.getElementById("jobDownSwf");
  	swf.value=(swf.checked==true)?1:0;
  	var oth= document.getElementById("jobDownOther");
  	oth.value=(oth.checked==true)?1:0;
 
  //下面合成采集起开始地址 
  var starturl="";
  var ckBackSort=document.getElementById("ckBackSort").checked;
  if(radio[1].checked)
  {
  starturl=document.myform.MultiUrl.value;
   }
  else if(radio[2].checked)
  {
  starturl=document.myform.SimilarUrl.value;
  starturl+="♀"+document.myform.StarNumStart.value+","+document.myform.StarNumEnd.value+","+document.myform.StarNumTime.value+","+ckBackSort+"";
  }
  else starturl=document.myform.SingleUrl.value; 
  //合成起始地址赋给hidden表单变量
  //var hiddenstarturl=
  document.myform.jobStartUrl.value=starturl;
  
  
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
 labelhtml+="<tr bgcolor=\"#CCFFBB\">";
    labelhtml+="<td colspan=\"2\"  width='80%' style=\"cursor:hand\" onClick=\"ShowLabel('label"+labelnum+"');\" ><img src=\"<?=PHPCMS_PATH?>images/icon/open.gif\" width=\"18\" height=\"18\" id='label"+labelnum+"img'><strong id='rule"+labelnum+"name'>";
      labelhtml+=labelname;
      labelhtml+="</strong>:[点击打开/隐藏标签] </td>";
  labelhtml+="<td colspan=\"2\" align='right'><a href='#' onClick='if(checkDeleteUserLabel()) DeleteUserLabel("+labelnum+");'>删除</a>&nbsp;&nbsp;No."+labelnum+"&nbsp;&nbsp;&nbsp;</td></tr>";
  labelhtml+="<tr id='label"+labelnum+"' style='display:block'>";
    labelhtml+="<td width=\"120\" class='tablerow' align=\"center\"><font color=blue>匹配信息</font></td>";
    labelhtml+="<td align=\"right\" class='tablerow'><table width=\"98%\"  border=\"0\">";
      labelhtml+="<tr>";
        labelhtml+="<td width=\"13\">从</td>";
        labelhtml+="<td width=\"223\"><textarea name=\"rule[StartStr]["+labelnum+"]\" cols=\"30\" rows=\"4\" id=\"rule"+labelnum+"StartStr\"></textarea></td>";
        labelhtml+="<td width=\"13\">到</td>";
        labelhtml+="<td width=\"223\"><textarea name=\"rule[EndStr]["+labelnum+"]\" cols=\"30\" rows=\"4\" id=\"rule"+labelnum+"EndStr\"></textarea></td><td  width=\"30%\">&nbsp;</td><td  width=\"30%\">    通配符: <a href=\"javascript:AddOnPos(document.myform.rule"+labelnum+"StartStr,'(*)');\"  style='color:#3300FF;'>(*)</a>";
        labelhtml+="&nbsp;通配符:<a href=\"javascript:AddOnPos(document.myform.rule"+labelnum+"EndStr,'(*)');\"  style='color:#3300FF;'>(*)</a></td>";
      labelhtml+="</tr>";
    labelhtml+="</table>      </td>";
    labelhtml+="</tr>";
  labelhtml+="<tr id='label"+labelnum+"trim' style='display:block'>";
    labelhtml+="<td class='tablerow'  align=\"center\"><font color=blue>信息替换删除<br>";
      labelhtml+="</font> 后项可留空，替换为空即相当于删除 <br>";
    labelhtml+="</td>";
    labelhtml+="<td align=\"right\" class='tablerow'><table width=\"98%\"  border=\"0\">";
      labelhtml+="<tr>";
        labelhtml+="<td width=\"13\">将</td>";
        labelhtml+="<td width=\"223\"><textarea name=\"rule[TrimStart]["+labelnum+"]\" cols=\"30\"  rows=\"5\" id=\"rule"+labelnum+"TrimStarta\"></textarea></td>";
        labelhtml+="<td width=\"13\">替换为 </td>";
        labelhtml+="<td width=\"223\"><textarea name=\"rule[TrimEnd]["+labelnum+"]\" cols=\"30\" rows=\"5\" id=\"rule"+labelnum+"TrimEnda\"></textarea></td><td  width=\"30%\">    替换代码通配符: <a href=\"javascript:AddOnPos(document.myform.rule"+labelnum+"TrimStarta,'(*)');\"   style='color:#3300FF;'>(*)</a>";
        labelhtml+="&nbsp;多个替换条件间隔符:<a  href=\"javascript:AddSeperate(document.myform.rule"+labelnum+"TrimStarta,document.myform.rule"+labelnum+"TrimEnda,'(|)')\"  style=\"color:#3300FF;\">(|)</a></td>";
      labelhtml+="</tr>";
    labelhtml+="</table>      </td>";
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
function AddSeperate(objstart,objend,charvalue)
{
	objstart.value=objstart.value+charvalue;
	objend.value=objend.value+charvalue;
	objstart.focus();
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

</script>
<style type="text/css">
<!--
.style1 {
	font-family: "fixedsys";
	font-size: 24px;
}
-->
</style>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=modify&save=1" >
<table width='100%' border='0' cellpadding='0' cellspacing='0' >
<tr align='center' height="24">
<td id='TabTitle0' class='title2' onclick='ShowTabs(0)'>网址采集</td>
<td id='TabTitle1' class='title1' onclick='ShowTabs(1)'>内容规则</td>
<td id='TabTitle2' class='title1' onclick='ShowTabs(2)'>高级设置</td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tbody id='Tabs0' style='display:'>
  <th colspan=2>基本信息</th>
    <tr>
    <td width="192"  class='tablerow'><strong>任务名称:</strong>      </td>
    <td width="*" class='tablerow'><input name='job[JobName]' type='text' id='jobJobName' value="<?=$job_JobName?>" size='20'>&nbsp;<font color='#FF0000'>*</font></td>
      </tr>
	    <tr>
    <td width="192"  class='tablerow'><strong>所属站点:</strong>      </td>
    <td width="*" class='tablerow'><?=$site_select?></td>
      </tr>
	  <tr>
    <td width="192"  class='tablerow'><strong>简单描述:</strong>      </td>
    <td width="*" class='tablerow'><textarea name="job[JobDescription]" cols="40" rows="5" id="jobJobDescription"><?=$job_JobDescription?></textarea></td>
      </tr>
	  
  <th colspan=2>网址采集</th>
  <tr>
<td width="192"  class='tablerow'><strong>起始地址:</strong><?php if(strpos($job_StartUrl,"\n")<1&strpos($job_StartUrl,'(*)')<1) $startstyle=0; else if(strpos($job_StartUrl,"\n")>1) $startstyle=1; else if(strpos($job_StartUrl,'(*)')>1) $startstyle=2; ?></td>
    <td width="1024" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="20%"><input name='StartStyle' type='radio' id='StartStyle0' onClick="addresssingle.style.display='block';addressmulti.style.display='none';addresssimilar.style.display='none';" value=<?php if($startstyle==0) echo "\"0\" checked"; else echo"\"\"";?>>
从单一网页</td>
        <td width="20%"><input name='StartStyle' id='StartStyle1' type='radio' onClick="addresssingle.style.display='none';addressmulti.style.display='block';addresssimilar.style.display='none';" value=<?php if($startstyle==1)  echo "\"0\" checked";  else echo"\"\"";?>>
从多个网页</td>
        <td width="60%"><input name='StartStyle' id='StartStyle2' type='radio' onClick="addresssingle.style.display='none';addressmulti.style.display='none';addresssimilar.style.display='block';" value=<?php if($startstyle==2)  echo "\"0\" checked";  else echo"\"\"";?>>
从序列相似网址</td>
      </tr>
      <tr style="display:<?php if($startstyle==0) echo "block"; else echo "none";?>" id="addresssingle">
        <td colspan="3">网页地址:
          <input name='SingleUrl' type='text' id='SingleUrl' value="<?php if($startstyle==0) echo $job_StartUrl; else echo 'http://';?>" size='60'></td>
        </tr>
      <tr style="display:<?php if($startstyle==1) echo "block"; else echo "none";?>" id="addressmulti">
        <td colspan="3"><table width="98%"  border="0">
          <tr>
            <td width="80">网页地址：</td>
            <td width="40%"><textarea name="MultiUrl" id="MultiUrl" cols="60" rows="6" ><?php if($startstyle==1) echo $job_StartUrl; else echo "";?></textarea></td>
            <td width="*">(一行一个）</td>
          </tr>
        </table></td>
        </tr>
      <tr  style="display:<?php if($startstyle==2) echo "block"; else echo "none"; ?>" id="addresssimilar">
	  <?php 
	  if($startstyle==2) 
	  $su=explode("♀",$job_StartUrl);
	  if(isset($su[1])) $sn=explode(",",$su[1]);
	  ?>
        <td colspan="3"><input name='SimilarUrl' type='text' id='SimilarUrl' value="<? if(isset($su[0])) echo $su[0]; else echo "http://";?>" size='60'>
          &nbsp;通配符: <a href="javascript:AddOnPos(document.myform.SimilarUrl,'(*)');"  style="color:#3300FF;">(*)</a> <br>
通配符范围: 从
<input name='StarNumStart' type='text' id='StarNumStart' size='4' value="<? if(isset($sn[0])) echo $sn[0]; else echo "";?>">
到
<input name='StarNumEnd' type='text' id='StarNumEnd' size='4' value="<? if(isset($sn[1])) echo $sn[1]; else echo "";?>">
&nbsp;&nbsp;&nbsp;&nbsp;步长倍数:
<input name='StarNumTime' type='text' id='StarNumTime' size='4' value="<? if(isset($sn[2])) echo $sn[2]; else echo "";?>">
&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="ckBackSort" <? if(isset($sn[3])) if($sn[3]=="true") echo "checked";?>>
倒序生成</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td  class='tablerow'><strong>文章网址筛选</strong>:<br></td>
    <td class='tablerow'>&nbsp;网址中必须包含
        <input name='job[ContentPageMust]' type='text' id='job_ContentPageMust' size='30' value='<?=$job_ContentPageMust?>'>
&nbsp;&nbsp;&nbsp;网址中不得包含
      <input name='job[ContentPageForbid]' type='text' id='jobContentPageForbid' size='30'  value='<?=$job_ContentPageForbid?>'></td>
  </tr>
  <tr>
    <td  class='tablerow'><strong>页面某一区域内获取网址:</strong></td>
    <td class='tablerow'><table width="98%"  border="0">
        <tr>
          <td width="628">从
        <textarea name="job[ListUrlStart]" cols="30" rows="5" id="jobListUrlStart"><?=$job_ListUrlStart?></textarea>
      到
      <textarea name="job[ListUrlEnd]" cols="30" rows="5" id="jobListUrlEnd"><?=$job_ListUrlEnd?></textarea></td>
          <td width="205"  style='display:none'><a href="#" class="style1">测试网址采集</a></td>
          </tr></table>
          </td>
  </tr>
  <tr>
    <td  class='tablerow'><strong>采集登陆网站:</strong></td>
    <td class='tablerow'>使用已有的COOKIE:
        <input name='job[Cookie]' type='text' id='job[Cookie]' size='66' value='<?=$job_Cookie?>'></td>
  </tr>
  <tr>
    <td colspan="2"  class='tablerow'>&nbsp;</td>
  </tr>
  <tr>
    <td>
  <tbody id='Tabs1' style='display:none'>
  <th colspan=2>内容规则</th>
  <tr>
    <td  class='tablerow'><strong>规则说明</strong>:<br></td>
    <td class='tablerow'><font color="blue">匹配信息</font><br>填入能够包裹起匹配的前后两段唯一字符串<br>
	<font color="blue">信息替换删除</font><br>1、替换为排除和合并在一起的，将第二项留空，替换为空即相当于排除<br>
		2、不用使用用正则，变动的代码使用(*)代替即可<br>
		3、当替换次数不止一次时，两项均使用(|)分割多个替换条件。如配置abcd(|)xyz替换为1(|)2即将abcd替换为1，xyz替换为2</td>
  </tr>
<?php 
  if(is_array($rule['LabelName']))
   		@extract($rule['LabelName'],EXTR_PREFIX_ALL,"label");
 if(is_array($labelkeys))
 {
	for($k=0;$k<count($labelkeys);$k++)
		{
?>
<tr bgcolor="#CCFFCC">
    <td colspan="2"  style="cursor:hand" onClick="ShowLabel('<?=${"label_".$labelkeys[$k]}?>');"><table width="100%"  border="0">
        <tr>
          <td width="78%"><img src="<?=PHPCMS_PATH?>images/icon/open.gif" width="18" height="18" id="<?=${"label_".$labelkeys[$k]}?>img">
		  <strong  id='rule<?=$labelkeys[$k]?>name'><?=${"label_".$labelkeys[$k]}?></strong>: [点击打开/隐藏标签] </td>
          <td width="22%" align="right">No.<?=$labelkeys[$k]?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  <tr  id="<?=${"label_".$labelkeys[$k]}?>" style="display:block">
    <td width="140" class='tablerow' align="center"><font color=blue>匹配信息</font></td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">从</td>
        <td width="223"><textarea name="rule[StartStr][<?=$labelkeys[$k]?>]" cols="30" rows="4" id="rule<?=$labelkeys[$k]?>StartStr"><?=$rule['StartStr'][$labelkeys[$k]]?></textarea></td>
        <td width="13">到</td>
        <td width="803"><textarea name="rule[EndStr][<?=$labelkeys[$k]?>]" cols="30" rows="4" id="rule<?=$labelkeys[$k]?>EndStr"><?=$rule['EndStr'][$labelkeys[$k]]?></textarea>
        通配符: <a href="javascript:AddOnPos(document.myform.rule<?=$labelkeys[$k]?>StartStr,'(*)');"  style="color:#3300FF;">(*)</a>
          &nbsp; 通配符:<a href="javascript:AddOnPos(document.myform.rule<?=$labelkeys[$k]?>EndStr,'(*)');"  style="color:#3300FF;">(*)</a>
          </td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="<?=${"label_".$labelkeys[$k]}?>trim" style="display:block">
    <td class='tablerow'  align="center"><font color=blue>信息替换删除<br>
      </font> 后项可留空，替换为空即相当于删除 <br>
    </td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">将</td>
        <td width="223">
		<textarea name="rule[TrimStart][<?=$labelkeys[$k]?>]" cols="30" rows="3" id="rule<?=$labelkeys[$k]?>TrimStart"><?=$rule['TrimStart'][$labelkeys[$k]]?></textarea> </td>
        <td width="13">替换为 </td>
        <td width="576"><textarea name="rule[TrimEnd][<?=$labelkeys[$k]?>]" cols="30" rows="3" id="rule<?=$labelkeys[$k]?>TrimEnd"><?=$rule['TrimEnd'][$labelkeys[$k]]?></textarea>           
          通配符: <a href="javascript:AddOnPos(document.myform.rule<?=$labelkeys[$k]?>TrimStart,'(*)');"  style="color:#3300FF;">(*)</a>
          &nbsp; 间隔符:<a href="javascript:AddSeperate(document.myform.rule<?=$labelkeys[$k]?>TrimStart,document.myform.rule<?=$labelkeys[$k]?>TrimEnd,'(|)');"  style="color:#3300FF;">(|)</a></td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="<?=${"label_".$labelkeys[$k]}?>trimhtml" style="display:block">
    <td class='tablerow'  align="center"><font color=blue>Html自动清除<br>
    </font> </td>
    <td class='tablerow'>&nbsp;
	<? isset($rule['HtmlTrim'][$labelkeys[$k]])?$htmltrim=explode(',',$rule['HtmlTrim'][$labelkeys[$k]]):$htmltrim=array();?>
			<input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="0" id="rule<?=$labelkeys[$k]?>HtmlTrim" <?php if(in_array(0,$htmltrim)) echo "checked"; else echo "";?>>
      链接&lt;a&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="1"  <?php if(in_array(1,$htmltrim)) echo "checked"; else echo "";?>>
      换行&lt;br&gt;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="2"  <?php if(in_array(2,$htmltrim)) echo "checked"; else echo "";?>>
      表格&lt;table&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="3"  <?php if(in_array(3,$htmltrim)) echo "checked"; else echo "";?>>
      表格行&lt;tr&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="4"  <?php if(in_array(4,$htmltrim)) echo "checked"; else echo "";?>>
      单元&lt;td&nbsp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="5"  <?php if(in_array(5,$htmltrim)) echo "checked"; else echo "";?>>
      段落&lt;p&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="6"  <?php if(in_array(6,$htmltrim)) echo "checked"; else echo "";?>>
      字体&lt;font&nbsp;
      <input name="buttonall<?=$labelkeys[$k]?>" type="button" onClick="HtmlTrimSelect(<?=$labelkeys[$k]?>,'all');" value="全选">
      <br>
&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="7"  <?php if(in_array(7,$htmltrim)) echo "checked"; else echo "";?>>
      层&lt;div&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="8"  <?php if(in_array(8,$htmltrim)) echo "checked"; else echo "";?>>
      Span&lt;span&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="9"  <?php if(in_array(9,$htmltrim)) echo "checked"; else echo "";?>>
      表格体&lt;tbody&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="10"  <?php if(in_array(10,$htmltrim)) echo "checked"; else echo "";?>>
      加粗&lt;b&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="11"  <?php if(in_array(11,$htmltrim)) echo "checked"; else echo "";?>>
      图象&lt;img&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="12"  <?php if(in_array(12,$htmltrim)) echo "checked"; else echo "";?>>
      空格&amp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][<?=$labelkeys[$k]?>][]" value="13"  <?php if(in_array(13,$htmltrim)) echo "checked"; else echo "";?>>
      脚本&lt;script&nbsp;
      <input name="buttonnone<?=$labelkeys[$k]?>" type="button" onClick="HtmlTrimSelect(<?=$labelkeys[$k]?>,'none');" value="全空">
	  <input type="hidden" name="userlabelid" value="<?=$labelkeys[$k]?>"></td>
  </tr>
  <?php
  }
  }
  ?>
  <tr>
    <td colspan="2" class='tablerow'><strong>自定义标签名称:</strong>
        <input name='userlabelname' type='text' id='userlabelname' size='10' value="简介">
&nbsp;
      <input name="buttonaddlabel" type="button" onClick="AddLabel(document.myform.userlabelname.value,<?=++$labelkeys[$k-1]?>);" value="添加标签"></td>
  </tr>
  <tr><td  class='tablerow' colspan="2" >
    <div id='userlabel'></div>
  </td></tr>
  <tr>
    <td class='tablerow'><strong>文章分页合并</strong></td>
    <td valign="middle" class='tablerow'><table width="98%"  border="0">
        <tr>
          <td width="100">分页代码：从</td>
          <td width="223"><textarea name="job[DividePageStart]" cols="26" rows="4" id="jobDividePageStart"><?=$job_DividePageStart?></textarea>            </td>
          <td width="13">到</td>
          <td width="223"><textarea name="job[DividePageEnd]" cols="26" rows="4" id="jobDividePageEnd"><?=$job_DividePageEnd?></textarea></td>
          <td width="220"><input type='radio' name='job[DividePageStyle]' value='0' <? if($job_DividePageStyle==0) echo "checked"; else echo "";?>>
全部列出模式
  <br>
  <input type='radio' name='job[DividePageStyle]' value='1'  <? if($job_DividePageStyle==1) echo "checked"; else echo "";?>>
上下页模式</td>

<td width="150">
通配符:<a href="javascript:AddOnPos(document.myform.jobDividePageStart,'(*)');" style="color:#3300FF;">(*)</a><br><br>
通配符:<a href="javascript:AddOnPos(document.myform.jobDividePageEnd,'(*)');" style="color:#3300FF;">(*)</a>
		</td>
          </tr>
      </table>            </td>
    </tr>    
    	<tr  style='display:none'>
    <td width="192"  class='tablerow'><strong>测试地址:</strong>      </td>
    <td width="*" class='tablerow'><input name='job[TestPageUrl]' type='text' id='jobTestPageUrl' size='66' value="<?=$job_TestPageUrl?>">
      <input name="buttontestrule" type="button" onClick="buttontestrule();" value="测试规则"></td>
      </tr>
	

  <tr>
    <td>
  <tbody id='Tabs2' style='display:none'>
  <th colspan=2>高级设置</th>
  <tr>
    <td class='tablerow'><strong>编码设置</strong></td>
    <td class='tablerow'>
      <input type='radio' name='job[SourceEncode]' value='0' <? if($job_SourceEncode==0) echo "checked"; else echo "";?>>
      GB2312&nbsp;&nbsp;&nbsp;&nbsp;
      <input type='radio' name='job[SourceEncode]' value='1' <? if($job_SourceEncode==1) echo "checked"; else echo "";?>>
      UTF8&nbsp;&nbsp;&nbsp;&nbsp;
      <input type='radio' name='job[SourceEncode]' value='2' <? if($job_SourceEncode==2) echo "checked"; else echo "";?>>
      BIG5 </td>
  </tr>
  <tr>
    <td  class='tablerow'><strong>下载图片</strong></td>
    <td class='tablerow'><input type="checkbox" name="job[DownImg]" id="jobDownImg" <? if($job_DownImg==1) echo " value=\"1\" checked"; else echo " value=\"0\"";?> >
      下载采集内容中的图片资源，自动保存到本地服务器</td>
  </tr>
  <tr>
    <td  class='tablerow'><strong>下载Flash</strong></td>
    <td class='tablerow'><input type="checkbox" name="job[DownSwf]" id="jobDownSwf"  <? if($job_DownSwf==1) echo " value=\"1\" checked"; else echo " value=\"0\"";?>>
      下载采集内容中的Flash资源 ，自动保存到本地服务器 </td>
  </tr>
      <tr>
    <td  class='tablerow'><strong>下载其他文件</strong></td>
    <td class='tablerow'>是否下载<input type="checkbox" name="job[DownOther]" id="jobDownOther"  <? if($job_DownOther==1) echo " value=\"1\" checked"; else echo " value=\"0\"";?>> 
     文件后缀形式:<input type="text" name="job[OtherFileType]" id="jobOtherFileType" value="<?=$job_OtherFileType?>">
      <font color="#AAAAAA">只适用于下载显示真实地址的文件，文件不宜过大</font></td>
  </tr>
   <tr>
    <td  class='tablerow'><strong>多线程设置</strong></td>
    <td class='tablerow'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    线程数:<input name='job[ThreadNum]' type='text' id='jobThreadNum' size='8' value='<?=$job_ThreadNum?>'><br />
    每个线程同时请求连接数:<input name='job[ThreadRequest]' type='text' id='jobThreadRequest' size='8' ' value='<?=$job_ThreadRequest?>'><br />
    线程间隔时间(单位为秒):<input name='job[ThreadSleep]' type='text' id='jobThreadSleep' size='8' ' value='<?=$job_ThreadSleep?>'><br /></td>
  </tr>
   <tr>
    <td  class='tablerow'><strong>超时时间</strong></td>
    <td class='tablerow'><input name='job[TimeOut]' type='text' id='jobTimeOut' size='6'   value='<?=$job_TimeOut?>'>秒 (0为无限大)</td>
  </tr>
  <tr>
    <td>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<input type="hidden" name="job[StartUrl]" id="jobStartUrl" value="">
	<input type="hidden" name="ruleKey" id="ruleKey" value="">
	<input type="hidden" name="ruleLabelName" id="ruleLabelName" value="">
	<input type="hidden" name="jobid" id="jobid" value="<?=$jobid?>">
	<input type="hidden" name="channelid" id="channelid" value="<?=$channelid?>">
	<input type="submit" name="Submit" value="修改设置" onClick="return CheckForm()"></td>
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
      <font color="blue">网址采集:</font>获取要采集的内容页的地址<br>
      <font color="blue">内容规则:</font>设置规则，从内容页里提取结构化的信息<br>
      <font color="blue">高级设置:</font>是否下载图片,Flash及采集线程设置的开关	<br>
    </td>
  </tr>
</table>
</body>
</html>