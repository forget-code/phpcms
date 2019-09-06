<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<script LANGUAGE="javascript">
<!--
function gradechange(val){
    if(val>0) document.all.detail.style.display="block";
	else document.all.detail.style.display="none";
}

function Check() {
if (document.myform.username.value=="")
	{
	  alert("请输入帐号")
	  document.myform.username.focus()
	  return false
	 }
     GetCatPurview();
}

function GetCatPurview(){
  document.myform.purview_category.value='';
<?php 
if(is_array($_CHANNEL)){
	foreach($_CHANNEL as $channel){
		if($channel['channeltype']){
			$channelid = $channel['channelid'];
			@include PHPCMS_CACHEDIR."category_".$channelid.".php";
			$_CAT = $_CATEGORY[$channelid];
			if(is_array($_CAT))
			{
?>
  if(document.myform.channel<?=$channel['channelid']?>.checked==true){
	<?php if(count($_CAT)>1){ ?>
     for(var i=0;i<frm<?=$channel['channeldir']?>.document.myform.catid.length;i++){
         if (frm<?=$channel['channeldir']?>.document.myform.catid[i].checked==true){
             if (document.myform.purview_category.value=='')
                 document.myform.purview_category.value=frm<?=$channel['channeldir']?>.document.myform.catid[i].value;
             else
                 document.myform.purview_category.value+=','+frm<?=$channel['channeldir']?>.document.myform.catid[i].value;
         }
     }
	<?php }else{ ?>
         if (frm<?=$channel['channeldir']?>.document.myform.catid.checked==true){
             if (document.myform.purview_category.value=='')
                 document.myform.purview_category.value=frm<?=$channel['channeldir']?>.document.myform.catid.value;
             else
                 document.myform.purview_category.value+=','+frm<?=$channel['channeldir']?>.document.myform.catid.value;
         }
	<?php } ?>
  }
<?php 
			}
		}
	}
}
?>
}
//-->
</script>

<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>添加管理员</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform" onsubmit="return Check()">
    <tr> 
      <td width="20%" class="tablerow">用户名</td>
      <td class="tablerow">
      <input size=20 name="username" type=text value="">
      </td>
    </tr>
	<tr> 
      <td class="tablerow">管理员级别</td>
      <td class="tablerow">
	  <select name='grade' onchange="javascript:gradechange(this.value)">
	  <option value='0'>超级管理员</option>
	  <option value='1'>频道管理员</option>
	  <option value='2'>栏目总编</option>
	  <option value='3'>栏目编辑</option>
	  <option value='4'>信息发布员</option>
	  <option value='5'>信息审核员</option>
	  </select>
     </td>
    </tr>
<tbody id="detail" style="display:none">
	<tr> 
	<td class="tablerow">频道管理权限</td>
	<td class="tablerow">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php 
if(is_array($_CHANNEL)){
	foreach($_CHANNEL as $channel){
		if($channel['channeltype']){
?>
  <tr>
    <td height="25"><input size=50 name="channel[<?=$channel['channelid']?>]" id="channel<?=$channel['channelid']?>"  type="checkbox" value="<?=$channel['channelid']?>" onclick="if(this.checked==true && myform.grade.value>2)table_<?=$channel['channeldir']?>.style.display='';else table_<?=$channel['channeldir']?>.style.display='none';"><?=$channel['channelname']?>频道 <br/></td>
  </tr>
  <tr id='table_<?=$channel['channeldir']?>' style='display:none'>
    <td><iframe id='frm<?=$channel['channeldir']?>' height='200' width='100%' src='?mod=<?=$mod?>&file=<?=$file?>&action=purview_category&channelid=<?=$channel['channelid']?>'></iframe></td>
  </tr>
<?php 
		}
	}
}
?>
</table>
	</td>
	</tr>
	<tr> 
	<td class="tablerow">模块管理权限</td>
	<td class="tablerow">

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php 
if(is_array($_MODULE)){
	$k=0;
	foreach($_MODULE as $module=>$m){
		if($m['enablecopy']==0 && $m['isshare']==0 && $module!='phpcms'){
		if($k%4==0) echo "<tr>";
?>
    <td height="25"><input size=50 name="module[]" type="checkbox" value="<?=$module?>"><?=$m['modulename']?></td>
<?php 
		if($k%4==3) echo "</tr>";
	    $k++;
		}
	}
}
?>
</table>
	</td>
	</tr>
</tbody>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow">
	  <input type="hidden" name="purview_category" value="">
	  <input type="hidden" name="save" value="1">
	  <input type="submit" name="submit" value=" 确定 "> 
     &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>