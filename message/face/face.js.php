<?php
$dir = dirname($_SERVER['PHP_SELF']);
?>
function setFace() {
	var intWidth = 240;
	var intHeight = 254;
	var faceValue = window.showModalDialog("<?php echo $dir; ?>/face.php",window,"dialogWidth:"+intWidth+"px;dialogHeight:"+intHeight+"px;center:yes;help:no;scroll:no;status:yes;resizable:no;scroll:no");
	if (faceValue != null) {
		editor.document.body.innerHTML += "<img src='"+faceValue+"' border='0' align='absmiddle'>";
	}
}
document.write("<img id='face' src='<?php echo $dir; ?>/face_42.gif' border='0' align='absmiddle' alt='设置表情图标' style='cursor:pointer' onclick='setFace();'>");