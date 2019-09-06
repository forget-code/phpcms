<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body style="margin:0px;padding:0px;">
<style type="text/css">
.pic_select li{float:left;border-top:1px solid #919485;border-right:1px solid #e5e5e5;position:relative;}
.pic_select_it{color:#fff;!important;text-decoration:none; position:absolute;left:40px;top:25px;}

</style>
<ul class="pic_select">
<?php
foreach($infos AS $n=>$info)
{
	?>
<li><span class="pic_select_it" id="style<?=$n?>" style="display:<?php if($now_pic!=$n) echo "none";?>"><img src="video/images/right_sign.png"></span>
<a href="?mod=<?=$mod?>&file=video&action=selectpic&vid=<?=$vid?>dosubmit=1&n=<?=$n?>" onclick="return changeimg('<?=$vid?>','<?=$n?>')"><img src="<?=$info?>" id="img<?=$n?>" width="132" height="99" <?php if($n=='big') echo 'alt="大图"'?>></a></li>
<?php
}?>
</ul>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function changeimg(vid,id) {
		$.get(
		 "?mod=<?=$mod?>&file=video&action=selectpic",
		 { dosubmit: "1", vid: "<?=$vid?>", n: id},
		 function(data){
		   if(data==1) {
				var img = document.getElementById('img'+id).src;
				parent.document.getElementById('thumb'+vid).src=img;
				$.each( [1,2,3,4,5,6,7,8,'big'], function(i, m){
					$('#style'+m).css('display','none');
				}); 
				$('#style'+id).css('display','');
		   }
		 }   
	);

		return false;
	}
//-->
</SCRIPT>
</body>
</html>