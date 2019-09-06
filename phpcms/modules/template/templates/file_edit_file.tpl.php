<?php
defined('IN_ADMIN') or exit('No permission resources.'); 
include $this->admin_tpl('header', 'admin');
?>
<style type="text/css">
	html{_overflow:hidden}
</style>
<body style="overflow:hidden">
<div class="pad-10" style="padding-bottom:0px">
<form action="?m=template&c=file&a=edit_file&style=<?php echo $this->style?>&dir=<?php echo $dir?>&file=<?php echo $file?>" method="post" name="myform" id="myform" >
<textarea name="code" id="code" style="height: 450px;width:99%; visibility:inherit"><?php echo $data?></textarea>
<div class="bk10"></div>
<input type="text" id="text" value="" /><input type="button" class="button" onClick="fnSearch()" value="<?php echo L('find_code')?>" /> <?php if ($is_write==0){echo '<font color="red">'.L("file_does_not_writable").'</font>';}?>
<input type="submit" class="dialog" id="dosubmit" name="dosubmit" value="<?php echo L('submit')?>" />
</form>
</div>
<script type="text/javascript">
var oRange; 
var intCount = 0;  
var intTotalCount = 100;

function fnSearch() { 
	var strBeReplaced; 
	var strReplace; 
	strBeReplaced = $('#text').val(); 
	fnNext(); 
	$('#code').focus(); 
	oRange = document.getElementById('code').createTextRange(); 
	for (i=1; oRange.findText(strBeReplaced)!=false; i++) { 
		if(i==intCount){ 
			oRange.select(); 
			oRange.scrollIntoView(); 
			break; 
		} 
		oRange.collapse(false); 
	} 
} 


function fnNext(){ 
	if (intCount > 0 && intCount < intTotalCount){ 
		intCount = intCount + 1; 
	} else { 
		intCount = 1 ; 
	} 
} 
//--> 
</SCRIPT> 
</script>
</body>
</html>