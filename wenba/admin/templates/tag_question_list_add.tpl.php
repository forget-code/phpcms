<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<script type="text/javascript" src="<?=PHPCMS_PATH?>include/js/tag.js"></script>

<?=$menu?>
<table cellpadding="2" cellspacing="1" border="0" align=center class="tableBorder" >
  <tr>
    <td class="submenu" align="center"><?=$functions[$function]?>标签管理</td>
  </tr>
  <tr>
    <td class="tablerow"><b>管理选项：</b><a href="?mod=<?=$mod?>&file=<?=$file?>&action=add&function=<?=$function?>&keyid=<?=$keyid?>">添加标签</a> | <a href="?mod=<?=$mod?>&file=<?=$file?>&action=manage&function=<?=$function?>&keyid=<?=$keyid?>">管理标签</a></td>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
	<tr>
		<td></td>
	</tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>添加<?=$functions[$function]?>标签</th>
  </tr>
  <form name="myform" method="get" action="?" >
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
   <input name="forward" type="hidden" value="<?=$forward?>">
   <input name="referer" type="hidden" value="<?=$forward?>">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input name="tagname" type="text" size="20" />
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>标签说明</b><br/>例如：首页推荐链接，10条</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="60" /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
	<tr> 
	<td class="tablerow"><b>调用问题所属栏目ID</b><br><font color="blue">多个ID之前用半角逗号隔开，0表示不限栏目</font><br>某些情况下可使用变量<a href="###" onclick="$('catid').value='$catid'"><font color="red">$catid</font></a>作为参数</td>
	<td  class="tablerow">
	<input name="tag_config[catid]" type="text" size="15"  id="catid" value='0'>&nbsp;
	<span id="category_select">
	<select name='selectcatid' onchange="ChangeInput(this,document.myform.catid)">
	<option value="0">不限栏目</option>
	<option value='$catid'>$catid</option>
	<?=$category_select?>
	</span> &nbsp;选择时栏目ID会自动加入到表单中
	</td>
	</tr>
    <tr> 
      <td class="tablerow"><b>是否调用子栏目问题</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[child]" value="1" checked>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[child]" value="0">否 仅当栏目ID为单个时有效</td>
    </tr>
	<tr> 
      <td class="tablerow" width="40%"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="$page" >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" checked>否 仅当栏目ID为单个时有效</td>
    </tr>
	<tr> 
      <td class="tablerow" width="40%"><b>调用问题数目</b></td>
      <td  class="tablerow"><input name="tag_config[ques_num]" type="text" size="5" value="10"> </td>
    </tr>
	 <tr> 
      <td class="tablerow" width="40%"><b>问题标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[subjectlen]" type="text" size="5" value="60"> </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>是否为推荐的问题</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[elite]" value="1" >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[elite]" value="0" checked>否</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>问题类别</b></td>
      <td  class="tablerow">
	  <input name="tag_config[ques_type]" type="text" size="10" value="all" id="ques_type">
		<select name='selecttype' onchange="$('ques_type').value=this.value">
		<option value="all" >全部问题</option>
		<option value="nosolve" >待解决问题</option>
		<option value="solve" >已解决问题</option>
		<option value="highscore" >高分问题</option>
		</select>
      </td>
    </tr>
	 <tr> 
      <td class="tablerow" width="40%"><b>是否显示栏目名称</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showcatname]" value="1" >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showcatname]" value="0" checked>否</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>多少天以内的问题</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="10" value="0" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name='selectdatenum' onclick="javascript:myform.datenum.value=this.value">
<option value='0'>不限天数</option>
<option value='3' >3天以内</option>
<option value='7' >一周以内</option>
<option value='14' >两周以内</option>
<option value='30' >一个月内</option>
<option value='60' >两个月内</option>
<option value='90' >三个月内</option>
<option value='180' >半年以内</option>
<option value='365' >一年以内</option>
</select>
您可以从下拉框中选择
</td>
</tr>
	<tr> 
      <td class="tablerow" width="40%"><b>排序方式</b></td>
      <td  class="tablerow">
<select name='tag_config[ordertype]'>
<option value='0' >按ID排序降序</option>
<option value='1' >按ID排序升序</option>
<option value='3' >按浏览次数降序</option>
<option value='4' >按浏览次数升序</option>
</select>
      </td>
    </tr>
	<tr> 
      <td class="tablerow" width="40%"><b>时间显示格式</b></td>
      <td  class="tablerow">
<select name='tag_config[datetype]'>
<option value="0" >不显示时间</option>
<option value="1" >格式：<?=date('Y-m-d',$PHP_TIME)?></option>
<option value="2" >格式：<?=date('m-d',$PHP_TIME)?></option>
<option value="3" >格式：<?=date('Y/m/d',$PHP_TIME)?></option>
<option value="4" >格式：<?=date('Y.m.d',$PHP_TIME)?></option>
<option value="5" >格式：<?=date("Y-m-d H:i:s",$PHP_TIME)?></option>
<option value="6" >格式：<?=date("Y-m-d H:i",$PHP_TIME)?></option>
</select>
      </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1" >是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[target]" value="0" checked>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每行显示问题列数</b></td>
      <td  class="tablerow">
<select name='tag_config[cols]'>
<option value='1' >1列</option>
<option value='2' >2列</option>
<option value='3' >3列</option>
<option value='4' >4列</option>
<option value='5' >5列</option>
<option value='6' >6列</option>
<option value='7' >7列</option>
<option value='8' >8列</option>
<option value='9' >9列</option>
<option value='10' >10列</option>
</select>
      </td>
    </tr>
	<tr> 
  <td class="tablerow"><b>会员名称</b></td>
  <td  class="tablerow"><input name="tag_config[username]" id="username" type="text" size="15"/> 可调用单个会员的问题</td>
</tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod,'tag_question_list','tag_config[templateid]','','id=templateid')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=wenba&forward=<?=urlencode($PHP_URL)?>'"> 【注:只能修改非默认模板】
      </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="dosubmit" value=" 保存 " onclick="$('action').value='add';">   &nbsp; 
         <input type="submit" name="dopreview" value=" 预览 " onclick="$('action').value='preview';">  
      </td>
    </tr>
  </form>
</table>
</body>
</html>