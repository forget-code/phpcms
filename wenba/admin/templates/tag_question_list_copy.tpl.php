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
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="keyid" type="hidden" value="<?=$keyid?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
   <input name="tagname" type="hidden" value="<?=$tagname?>">
   <input name="forward" type="hidden" value="<?=$forward?>">
   <input name="referer" type="hidden" value="<?=$forward?>">
    <tr> 
      <td class="tablerow" width="40%"><b>标签名称</b><font color="red">*</font><br/>可用中文，不得包含特殊字符 ' " $ { } ( ) \ / , ;</td>
      <td  class="tablerow">
	  <input type="text" size="20" title="标签名称不可再修改" name="tagname"/>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>标签说明</b><br/>例如：首页推荐链接，10条</td>
      <td  class="tablerow"><input name="tag_config[introduce]" id="introduce" type="text" size="60"  /></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>标签参数设置</b></td>
    </tr>
	<tr> 
	<td class="tablerow"><b>调用问题所属栏目ID</b><br><font color="blue">多个ID之前用半角逗号隔开，0表示不限栏目</font><br>某些情况下可使用变量<a href="###" onclick="$('catid').value='$catid'"><font color="red">$catid</font></a>作为参数</td>
	<td  class="tablerow">
	<input name="tag_config[catid]" type="text" size="15"  id="catid" value="<?=$tag_config['catid']?>">&nbsp;
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
      <td  class="tablerow"><input type="radio" name="tag_config[child]" value="1" <?php if($tag_config['child']){ ?>checked<?php } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[child]" value="0" <?php if(!$tag_config['child']){ ?>checked<?php } ?>>否 仅当栏目ID为单个时有效</td>
    </tr>
	<tr> 
      <td class="tablerow" width="40%"><b>是否分页显示</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[page]" value="$page" <? if($tag_config['page']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[page]" value="0" <? if(!$tag_config['page']) { ?>checked<? } ?>>否 仅当栏目ID为单个时有效</td>
    </tr>
	<tr> 
      <td class="tablerow" width="40%"><b>调用问题数目</b></td>
      <td  class="tablerow"><input name="tag_config[ques_num]" type="text" size="5" value="<?=$tag_config['ques_num']?>"> </td>
    </tr>
	 <tr> 
      <td class="tablerow" width="40%"><b>问题标题最大字符数</b></td>
      <td  class="tablerow"><input name="tag_config[subjectlen]" type="text" size="5" value="<?=$tag_config['subjectlen']?>"> </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>是否为推荐的问题</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[elite]" value="1"  <?php if($tag_config['elite']) echo "checked";?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[elite]" value="0" <?php if(!$tag_config['elite']) echo "checked";?>>否</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>问题类别</b></td>
      <td  class="tablerow">
	  <input name="tag_config[ques_type]" type="text" size="10" value="<?=$tag_config['ques_type']?>" id="ques_type">
		<select name='selecttype' onchange="$('ques_type').value=this.value">
		<option value="all" <? if($tag_config['ques_type']=='all') { ?>selected<? } ?>>全部问题</option>
		<option value="nosolve" <? if($tag_config['ques_type']=='nosolve') { ?>selected<? } ?>>待解决问题</option>
		<option value="solve" <? if($tag_config['ques_type']=='solve') { ?>selected<? } ?>>已解决问题</option>
		<option value="highscore" <? if($tag_config['ques_type']=='highscore') { ?>selected<? } ?>>高分问题</option>
		</select>
      </td>
    </tr>
	 <tr> 
      <td class="tablerow" width="40%"><b>是否显示栏目名称</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[showcatname]" value="1" <? if($tag_config['showcatname']) { ?>checked<? } ?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[showcatname]" value="0" <? if(!$tag_config['showcatname']) { ?>checked<? } ?>>否</td>
    </tr>
	<tr> 
      <td class="tablerow"><b>多少天以内的问题</b></td>
      <td  class="tablerow"><input name="tag_config[datenum]" type="text" size="10" value="<?=$tag_config['datenum']?>" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name='selectdatenum' onclick="javascript:myform.datenum.value=this.value">
<option value='0' <? if($tag_config['datenum']==0) { ?>selected<? } ?>>不限天数</option>
<option value='3' <? if($tag_config['datenum']==3) { ?>selected<? } ?>>3天以内</option>
<option value='7' <? if($tag_config['datenum']==7) { ?>selected<? } ?>>一周以内</option>
<option value='14' <? if($tag_config['datenum']==14) { ?>selected<? } ?>>两周以内</option>
<option value='30' <? if($tag_config['datenum']==30) { ?>selected<? } ?>>一个月内</option>
<option value='60' <? if($tag_config['datenum']==60) { ?>selected<? } ?>>两个月内</option>
<option value='90' <? if($tag_config['datenum']==90) { ?>selected<? } ?>>三个月内</option>
<option value='180' <? if($tag_config['datenum']==180) { ?>selected<? } ?>>半年以内</option>
<option value='365' <? if($tag_config['datenum']==365) { ?>selected<? } ?>>一年以内</option>
</select>
您可以从下拉框中选择
</td>
</tr>
	<tr> 
      <td class="tablerow" width="40%"><b>排序方式</b></td>
      <td  class="tablerow">
<select name='tag_config[ordertype]'>
<option value='0' <? if($tag_config['ordertype']==0) { ?>selected<? } ?>>按ID排序降序</option>
<option value='1' <? if($tag_config['ordertype']==1) { ?>selected<? } ?>>按ID排序升序</option>
<option value='3' <? if($tag_config['ordertype']==2) { ?>selected<? } ?>>按浏览次数降序</option>
<option value='4' <? if($tag_config['ordertype']==3) { ?>selected<? } ?>>按浏览次数升序</option>
</select>
      </td>
    </tr>
	<tr> 
      <td class="tablerow" width="40%"><b>时间显示格式</b></td>
      <td  class="tablerow">
<select name='tag_config[datetype]'>
<option value="0" <? if($tag_config['datetype']==0) { ?>selected<? } ?>>不显示时间</option>
<option value="1" <? if($tag_config['datetype']==1) { ?>selected<? } ?>>格式：<?=date('Y-m-d',$PHP_TIME)?></option>
<option value="2" <? if($tag_config['datetype']==2) { ?>selected<? } ?>>格式：<?=date('m-d',$PHP_TIME)?></option>
<option value="3" <? if($tag_config['datetype']==3) { ?>selected<? } ?>>格式：<?=date('Y/m/d',$PHP_TIME)?></option>
<option value="4" <? if($tag_config['datetype']==4) { ?>selected<? } ?>>格式：<?=date('Y.m.d',$PHP_TIME)?></option>
<option value="5" <? if($tag_config['datetype']==5) { ?>selected<? } ?>>格式：<?=date("Y-m-d H:i:s",$PHP_TIME)?></option>
<option value="6" <? if($tag_config['datetype']==6) { ?>selected<? } ?>>格式：<?=date("Y-m-d H:i",$PHP_TIME)?></option>
</select>
      </td>
    </tr>
	<tr> 
      <td class="tablerow"><b>是否在新窗口打开链接</b></td>
      <td  class="tablerow"><input type="radio" name="tag_config[target]" value="1"  <?php if($tag_config['target']) echo "checked";?>>是&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="tag_config[target]" value="0" <?php if(!$tag_config['target']) echo "checked";?>>否</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每行显示问题列数</b></td>
      <td  class="tablerow">
<select name='tag_config[cols]'>
<option value='1' <?php if($tag_config['cols']==1) { ?>selected<? } ?>>1列</option>
<option value='2' <?php if($tag_config['cols']==2) { ?>selected<? } ?>>2列</option>
<option value='3' <?php if($tag_config['cols']==3) { ?>selected<? } ?>>3列</option>
<option value='4' <?php if($tag_config['cols']==4) { ?>selected<? } ?>>4列</option>
<option value='5' <?php if($tag_config['cols']==5) { ?>selected<? } ?>>5列</option>
<option value='6' <?php if($tag_config['cols']==6) { ?>selected<? } ?>>6列</option>
<option value='7' <?php if($tag_config['cols']==7) { ?>selected<? } ?>>7列</option>
<option value='8' <?php if($tag_config['cols']==8) { ?>selected<? } ?>>8列</option>
<option value='9' <?php if($tag_config['cols']==9) { ?>selected<? } ?>>9列</option>
<option value='10' <?php if($tag_config['cols']==10) { ?>selected<? } ?>>10列</option>
</select>
      </td>
    </tr>
	<tr> 
  <td class="tablerow"><b>会员名称</b></td>
  <td  class="tablerow"><input name="tag_config[username]" id="username" type="text" size="15" value="<?=$tag_config['username']?>"/> 可调用单个会员的问题</td>
</tr>
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
<?=showtpl($mod,'tag_question_list','tag_config[templateid]',$tag_config['templateid'],'id=templateid')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=wenba&forward=<?=urlencode($PHP_URL)?>'"> 【注:只能修改非默认模板】
      </td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
         <input type="submit" name="dosubmit" value=" 保存 "  onclick="$('action').value='<?=$action?>';">   &nbsp; 
         <input type="submit" name="dopreview" value=" 预览 " onclick="$('action').value='preview';">  
      </td>
    </tr>
  </form>
</table>
</body>
</html>