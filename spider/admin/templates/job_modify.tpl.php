<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<style type="text/css">
<!--
.style1 {
	font-family: "fixedsys";
	font-size: 24px;
}
.selected
{
background-color:#0099FF;
color: #ffffff;
padding-top:2px;
cursor:pointer;
text-align:center;
}
-->
</style>
<script type="text/javaScript" src="/include/js/prototype.js"></script>
<script language='JavaScript' type='text/JavaScript'>
function showcat(keyid,catid)
{
    var url = "<?echo $_SERVER['PHP_SELF']?>";
    var pars = "mod=phpcms&file=tag&action=category_select&catid="+catid+"&keyid="+keyid;
	var myAjax = new Ajax.Updater(
					'category_select',
					url,
					{
					method: 'get',
					parameters: pars
					}
	             ); 
}

var selectOption ="<?=$selectHtml;?>";
function loadModel(catid)
{
	myform.catid.value=catid;
	if(catid =='') return;
	clearModelSelected();
	var url = "<?echo $_SERVER['PHP_SELF']?>?mod=<?php echo $mod;?>&file=jobmgr&action=add&loadModelId="+catid;
	$.get(url,function(txt)
	{
		if(txt=='ERR'){alert('该栏目属于未知模型！');return;}
		selectOption = txt;
		setModelSelected();
	});
}

function setModelSelected()
{
	var obj = $("span") || '';
	for(i=0;i<obj.length;i++)
	{
		if(obj[i].id=='publish')
		{
			if(obj[i].innerHTML=='')
			{
				obj[i].innerHTML ='<select id="rule[publish]['+obj[i].name+']" name="rule[publish]['+obj[i].name+']">'+selectOption+'</select>';
			}
			var s = document.getElementById('rule[publish]['+obj[i].name+']');

			if(s.selectedIndex>0) continue;

			for(j=0;j<s.length;j++)
			{
				if(s[j].text == obj[i].name) s[j].selected = true;
			}
		}
	}
}
function clearModelSelected()
{
	selectOption ='';
	var obj = $("span") || '';
	for(i=0;i<obj.length;i++)
	{
		if(obj[i].id=='publish')
		{
			obj[i].innerHTML='';
		}
	}
}

function addSimilar()
{
	var obj =document.myform;
	var SimilarUrl = obj.SimilarUrl.value;
	var StarNumStart = obj.StarNumStart.value;
	var StarNumEnd = obj.StarNumEnd.value;
	var StarNumTime = obj.StarNumTime.value;
	var ckBackSort = obj.ckBackSort.checked;
	var AutoZero = obj.AutoZero.checked;
	var StartUrl = obj.StartUrl.value;
	if(SimilarUrl==''||SimilarUrl=='http://')
	{
		alert('请填写多页URL形式！变化的页码部分用通配符(*)代替');
		return false;
	}
	if(SimilarUrl.indexOf('(*)')==-1)
	{
		if(confirm('多页URL中不包含通配符(*)，将被认为单条网址生成！您确认吗？'))
		{
			obj.StartUrl.value=(StartUrl=='')?SimilarUrl:(StartUrl+"\n"+SimilarUrl);
			return false;
		}
	}else
	{
		if(StarNumStart==''||StarNumEnd=='')
		{
			return alert('请填写通配符范围起始地址！');
		}
		if(StarNumTime=='')
		{
			return alert('请填写通配符步长倍数！');
		}
		var curr='';
		var tmplist='';
		var AutoZeroStr='0000000000';
		var totallen=StarNumEnd.length;
		StarNumStart = parseInt(StarNumStart);
		StarNumEnd = parseInt(StarNumEnd);
		StarNumTime = parseInt(StarNumTime);
		if(isNaN(StarNumStart)||isNaN(StarNumStart)||isNaN(StarNumTime))
		{
			return alert('通配符范围及步长倍数都必须为数字！');
		}
		if(ckBackSort)
		{
			for(i=StarNumEnd;i>=StarNumStart;i-=StarNumTime)
			{
				if(AutoZero)
				{
					curr=AutoZeroStr+String(i);
					startpos = AutoZeroStr.length+String(i).length-totallen;
					curr=curr.substr(startpos,totallen);
				}else
				{
					curr=String(i);
				}
				tmplist+=(tmplist=='')?SimilarUrl.replace('(*)',curr):("\n"+SimilarUrl.replace('(*)',curr));
			}
		}else
		{
			for(i=StarNumStart;i<=StarNumEnd;i+=StarNumTime)
			{
				if(AutoZero)
				{
					curr=AutoZeroStr+String(i);
					startpos = AutoZeroStr.length+String(i).length-totallen;
					curr=curr.substr(startpos,totallen);
				}else
				{
					curr=String(i);
				}
				tmplist+=(tmplist=='')?SimilarUrl.replace('(*)',curr):("\n"+SimilarUrl.replace('(*)',curr));
			}
		}
		obj.StartUrl.value=(StartUrl=='')?tmplist:(StartUrl+"\n"+tmplist);
		if(StarNumStart>StarNumEnd)
		{
			return alert('通配符范围开始数大于结束数');
		}
	}

	//AutoZero
}

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
 

  	var img= document.getElementById("jobDownImg");
  	img.value=(img.checked==true)?1:0;
  	var swf= document.getElementById("jobDownSwf");
  	swf.value=(swf.checked==true)?1:0;
  	var oth= document.getElementById("jobDownOther");
  	oth.value=(oth.checked==true)?1:0;
 
	document.getElementById("jobStartUrl").value=document.myform.StartUrl.value;
  
    var rulekey=""; 
	var rulelabelname=""; 
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
   objimg.src="spider/images/open.gif";
   }
	else
	{
	  obj.style.display="none";
	  objtrim.style.display="none";
	  objtrimhtml.style.display="none";
	  objimg.src="spider/images/close.gif";
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
        } 
    } else {
        elts.checked        = true;
    } 

}

var labelnum=0;
function AddLabel(labelname,lnum)
{
  if(labelname==''){
    alert('请输入标签名称！');
    document.myform.userlabelname.focus();
    return;
  }
  
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
     } 
	  
labelnum=(labelnum<lnum)?lnum:labelnum+1;
var  labelhtml="";
	labelhtml+="<tr><td colspan=2><table width=\"100%\" border=0><tr bgcolor=\"#CCFFBB\" style=\"cursor:hand\"  >";
	labelhtml+="<td width=\"78%\" bgcolor=\"#6699FF\" onClick=\"ShowLabel('label"+labelnum+"');\"><img src=\"spider/images/open.gif\" id='label"+labelnum+"img'><strong id='rule"+labelnum+"name'>"+labelname+"</strong>:[点击打开/隐藏标签] </td>";
	labelhtml+="<td width=\"22%\" bgcolor=\"#6699FF\" align='left'><a href='#' onClick='if(checkDeleteUserLabel()) DeleteUserLabel("+labelnum+");'>删除</a>&nbsp;No."+labelnum+"&nbsp;&nbsp;&nbsp;发布字段<span id=\"publish\" name=\""+labelname+"\"></span></td></tr></table></td></tr>";


  
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
	setModelSelected();
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
    
    obj.focus();
    var r = document.selection.createRange();
    var ctr = obj.createTextRange();
    var i;
    var s = obj.value;
    
    var ivalue = "&^asdjfls2FFFF325%$^&"; 
    r.text = ivalue;
    i = obj.value.indexOf(ivalue);
    r.moveStart("character", -ivalue.length);
    r.text = "";

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
<table width='100%' border='0' cellpadding='0' cellspacing='0' class="table_list">
<tr align='center' height='24'>
<td id='TabTitle0' class='selected' onclick='ShowTabs(0)'><div align='center'>网址采集</div></td>
<td id='TabTitle1' onclick='ShowTabs(1)'><div align='center'>内容规则</div></td>
<td id='TabTitle2' onclick='ShowTabs(2)'><div align='center'>高级设置</div></td>
<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form" id='Tabs0' style='display:'>
<caption>网址采集</caption>
    <tr>
    <td width="150"  class='tablerow'><strong>任务名称:</strong>      </td>
    <td width="*" class='tablerow'><input name='job[JobName]' type='text' id='jobJobName' value="<?=$job_JobName?>" size='20'>&nbsp;<font color='#FF0000'>*</font></td>
      </tr>
	    <tr>
    <td width="150"  class='tablerow'><strong>所属站点:</strong></td>
    <td width="*" class='tablerow'><?=$site_select?>&nbsp;<font color="Red">*</font></td>
	</tr>
	<tr>
	<td width="150"   class='tablerow'><strong>发布栏目:</strong></td>
	<td width="*"  class='tablerow'><input name="job[CatId]" id="catid" type="hidden" size="10" value="<?=$job_CatId?>"/>
	<?=form::select_category('phpcms', 0, 'parentid', 'parentid', '无（作为一级栏目）', $job_CatId,$cat_js)?>&nbsp;<font color="Red">*</font></td>
	</tr>
	<tr>
    <td width="150"  class='tablerow'><strong>简单描述:</strong>      </td>
    <td width="*" class='tablerow'><textarea name="job[JobDescription]" cols="80" rows="3" id="jobJobDescription"><?=$job_JobDescription?></textarea></td>
    </tr>
  <tr style="display:none"  id="addresssimilar" >
    <td width="150"  class='tablerow'><strong>批量添加:</strong>      </td>
    <td class='tablerow'>
	<table width="98%"  border="0">
      <tr>
        <td colspan="3">多页URL形式：<input name='SimilarUrl' type='text' id='SimilarUrl' value="http://" size='60'>
          &nbsp;通配符: <a href="javascript:AddOnPos(document.myform.SimilarUrl,'(*)');"  style="color:#3300FF;">(*)</a><input type="button" name="add" value="添加" onclick="addSimilar()"> <br>
		通配符范围：从<input name='StarNumStart' type='text' id='StarNumStart' size='4'>到<input name='StarNumEnd' type='text' id='StarNumEnd' size='4'>
		&nbsp;&nbsp;&nbsp;&nbsp;步长倍数:
		<input name='StarNumTime' type='text' id='StarNumTime' value="1" size='4'>
		&nbsp;&nbsp;&nbsp;
		<input type="checkbox" name="ckBackSort">
		倒序生成
		&nbsp;&nbsp;&nbsp;&nbsp;补零:
		<input type="checkbox" name='AutoZero' id='AutoZero' value="1">
		</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td  class='tablerow'><strong>开始采集地址</strong>:<br>文章列表地址一行一个</td>
    <td class='tablerow'><input type="button" name="add" value="批量添加多页" onclick="document.all.addresssimilar.style.display=''"><br><textarea name="StartUrl" id="StartUrl" cols="80" rows="6" ><?echo $job_StartUrl?></textarea></td>
  </tr>
  <tr>
    <td  class='tablerow'><strong>列表页面某一区域内获取网址:</strong></td>
    <td class='tablerow'><table width="98%"  border="0">
        <tr>
          <td width="628">从
        <textarea name="job[ListUrlStart]" cols="35" rows="3" id="jobListUrlStart"><?=$job_ListUrlStart?></textarea>
      到
      <textarea name="job[ListUrlEnd]" cols="35" rows="3" id="jobListUrlEnd"><?=$job_ListUrlEnd?></textarea></td>
          <td width="205"  style='display:none'><a href="#" class="style1">测试网址采集</a></td>
          </tr></table>
          </td>
  </tr>
  <tr>
    <td  class='tablerow'><strong>文章网址筛选</strong>:<br></td>
    <td class='tablerow'>&nbsp;网址中<b>必须</b>包含
        <input name='job[ContentPageMust]' type='text' id='job_ContentPageMust' size='30' value='<?=$job_ContentPageMust?>'>
&nbsp;&nbsp;&nbsp;网址中<b>不得</b>包含
      <input name='job[ContentPageForbid]' type='text' id='jobContentPageForbid' size='30'  value='<?=$job_ContentPageForbid?>'></td>
  </tr>
  <tr>
    <td  class='tablerow'><strong>缩略图采集规则:</strong><br />建议不填写<br />不填写时程序抓取第一个图片为缩略图</td>
    <td class='tablerow'><textarea name='job[SpiderRule]' id='SpiderRule' cols="60" rows="3"><?=$job_SpiderRule?></textarea>&nbsp;通配符: <a href="javascript:AddOnPos(document.myform.SpiderRule,'(*)');"  style="color:#3300FF;">(*)</a>
	&nbsp; <a href="javascript:AddOnPos(document.myform.SpiderRule,'[缩略图]');"  style="color:#3300FF;">[缩略图]</a>
	&nbsp; <a href="javascript:AddOnPos(document.myform.SpiderRule,'[标题]');"  style="color:#3300FF;">[标题]</a>
	&nbsp;<a href="javascript:AddOnPos(document.myform.SpiderRule,'[实际链接]');"  style="color:#3300FF;">[实际链接]</a></td>
  </tr>
  <tr>
    <td  class='tablerow'><strong>采集登陆网站:</strong></td>
    <td class='tablerow'>使用已有的COOKIE:
        <input name='job[Cookie]' type='text' id='job[Cookie]' size='66' value='<?=$job_Cookie?>'></td>
  </tr>
  <tr>
    <td colspan="2"  class='tablerow'>&nbsp;</td>
  </tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form" id='Tabs1' style='display:none'>
<caption>内容规则</caption>
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
    <td colspan="2"  style="cursor:hand"><table width="100%"  border="0">
        <tr>
          <td width="78%" bgcolor="#6699FF"  onClick="ShowLabel('<?=${"label_".$labelkeys[$k]}?>');"><img src="spider/images/open.gif" width="18" height="18" id="<?=${"label_".$labelkeys[$k]}?>img">
		  <strong  id='rule<?=$labelkeys[$k]?>name'><?=${"label_".$labelkeys[$k]}?></strong>: [点击打开/隐藏标签] </td>
          <td width="22%" bgcolor="#6699FF" align="right">No.<?=$labelkeys[$k]?>&nbsp;&nbsp;&nbsp;发布字段
		  <span id="publish" name="<?=${"label_".$labelkeys[$k]};?>"><?=$publish[$k];?></span></td>
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
        <td width="803"><textarea name="rule[EndStr][<?=$labelkeys[$k]?>]" cols="30" rows="4" id="rule<?=$labelkeys[$k]?>EndStr"><?=htmlspecialchars($rule['EndStr'][$labelkeys[$k]])?></textarea>
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
        <input name='userlabelname' type='text' id='userlabelname' size='10' value="摘要">
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
      </table>
	  分页合并代码：<input type="text" name="job[DividePageUnion]" cols="26" rows="4" id="jobDividePageUnion" value="<?=$job_DividePageUnion?>">此处为分页采集后内容链接代码，[page]是phpcms默认分页符，为空表示字符直接连接在一起。
	  </td>
    </tr> 
    <tr >
    <td width="150"  class='tablerow'><strong>发布自动分页大小:</strong>      </td>
    <td width="*" class='tablerow'><input type="text" name="job[AutoPageSize]" cols="26" rows="4" id="jobAutoPageSize" value="<?=$job_AutoPageSize?>">此处填写自动分页时单页字符长度，0表示不分页。</td>
    </tr>
  <tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form" id='Tabs2' style='display:none'>
<caption>高级设置</caption>
  <tr>
    <td class='tablerow'><strong>列表页编码设置</strong></td>
    <td class='tablerow'>
      <input type='radio' name='job[SiteEncode]' value='0' <? if($job_SiteEncode==0) echo "checked"; else echo "";?>>
      GB2312&nbsp;&nbsp;&nbsp;&nbsp;
      <input type='radio' name='job[SiteEncode]' value='1' <? if($job_SiteEncode==1) echo "checked"; else echo "";?>>
      UTF8&nbsp;&nbsp;&nbsp;&nbsp;
      <input type='radio' name='job[SiteEncode]' value='2' <? if($job_SiteEncode==2) echo "checked"; else echo "";?>>
      BIG5 </td>
  </tr>
  <tr>
    <td class='tablerow'><strong>内容页编码设置</strong></td>
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
    线程数:<input name='job[ThreadNum]' type='text' id='jobThreadNum' size='8' value='<?=$job_ThreadNum?>' maxlength="1"><br />
    每个线程同时请求连接数:<input name='job[ThreadRequest]' type='text' id='jobThreadRequest' size='8' ' value='<?=$job_ThreadRequest?>' maxlength="1"><br />
    线程间隔时间(单位为秒):<input name='job[ThreadSleep]' type='text' id='jobThreadSleep' size='8' ' value='<?=$job_ThreadSleep?>' maxlength="2"><br /></td>
  </tr>
   <tr>
    <td class='tablerow'><strong>超时时间</strong></td>
    <td class='tablerow'><input name='job[TimeOut]' type='text' id='jobTimeOut' size='6' value='<?=$job_TimeOut?>'>秒 (0为无限大)</td>
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
<table cellpadding="2" cellspacing="1" border="0" align=center class="table_info" >
<caption>提示信息</caption>
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