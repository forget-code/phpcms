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
    <th colspan=2>修改权限</th>
  </tr>
   <form action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" method="post" name="myform" onsubmit="return Check()">
    <tr> 
      <td width="20%" class="tablerow">用户名</td>
      <td class="tablerow">
      <?=$username?>
      </td>
    </tr>
	<tr> 
      <td class="tablerow">管理员级别</td>
      <td class="tablerow">
	  <select name='grade' onchange="javascript:gradechange(this.value)">
	  <option value='0' <?php if($grade==0){ ?>selected<?php } ?>>超级管理员</option>
	  <option value='1' <?php if($grade==1){ ?>selected<?php } ?>>频道管理员</option>
	  <option value='2' <?php if($grade==2){ ?>selected<?php } ?>>栏目总编</option>
	  <option value='3' <?php if($grade==3){ ?>selected<?php } ?>>栏目编辑</option>
	  <option value='4' <?php if($grade==4){ ?>selected<?php } ?>>信息发布员</option>
	  <option value='5' <?php if($grade==5){ ?>selected<?php } ?>>信息审核员</option>
	  </select>
     </td>
    </tr>
<?php if($grade>0){ ?>
<tbody id="detail" style="display:">
<?php }else{ ?>
<tbody id="detail" style="display:none">
<?php } ?>
	<tr> 
	<td width="20%" class="tablerow">频道管理权限</td>
	<td class="tablerow">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?php 
if(is_array($_CHANNEL)){
	foreach($_CHANNEL as $channel){
		if($channel['channeltype']){
?>
  <tr>
    <td height="25"><input name="channel[<?=$channel['channelid']?>]" id="channel<?=$channel['channelid']?>"  type="checkbox" value="<?=$channel['channelid']?>" <?php if(in_array($channel['channelid'],$channels)){ ?>checked <?php } ?> onclick="if(this.checked==true)table_<?=$channel['channeldir']?>.style.display='';else table_<?=$channel['channeldir']?>.style.display='none';"><?=$channel['channelname']?>频道 <br/></td>
  </tr>

<?php if(in_array($channel['channelid'],$channels)){ ?> 
  <tr id='table_<?=$channel['channeldir']?>' style='display:'>
    <td><iframe id='frm<?=$channel['channeldir']?>' height='200' width='100%' src='?mod=<?=$mod?>&file=<?=$file?>&action=purview_category&channelid=<?=$channel['channelid']?>&purview_category=<?=$purview_category?>'></iframe></td>
  </tr>
<?php }else{ ?>
  <tr id='table_<?=$channel['channeldir']?>' style='display:none'>
    <td><iframe id='frm<?=$channel['channeldir']?>' height='200' width='100%' src='?mod=<?=$mod?>&file=<?=$file?>&action=purview_category&channelid=<?=$channel['channelid']?>&purview_category=<?=$purview_category?>'></iframe></td>
  </tr>
<?php } ?>

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
    <td height="25"><input size=50 name="module[]" type="checkbox" value="<?=$module?>" <?php if(in_array($module,$modules)){ ?>checked <?php } ?>><?=$m['modulename']?></td>
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
	  <input type="hidden" name="userid" value="<?=$userid?>">
	  <input type="hidden" name="purview_category" value="">
	  <input type="hidden" name="save" value="1">
	  <input type="submit" name="submit" value=" 确定 "> 
     &nbsp; <input type="reset" name="reset" value=" 清除 "> </td>
    </tr>
  </form>
</table>
</body>
</html>