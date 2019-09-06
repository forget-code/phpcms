function frmChk() {
	if (confirm("您确定要删除所选项目?")) {
		return true;
	} else {
		return false;
	}
}
function checknum() {
	var intNum = 0;
	var element = document.forms[0].mid;
	if (element.length) {
		for (var i = 0; i < element.length; i++) {
			if (element[i].checked) {
				intNum++;
			}
		}
	} else {
		if (element.checked) {
			intNum = 1;
		}
	}
	return intNum;
}
function delCheck() {
	var intNum = checknum();
	if (intNum > 0) {
		if (document.forms[0].mid.length) {
			if (intNum == document.forms[0].mid.length) {
				document.getElementById("checkAll").disabled = true;
				document.getElementById("checkOther").disabled = true;
			} else {
				document.getElementById("checkAll").disabled = false;
				document.getElementById("checkOther").disabled = false;
			}
		} else {
			document.getElementById("checkAll").disabled = true;
			document.getElementById("checkOther").disabled = true;
		}
		document.getElementById("cancel").disabled = false;
		document.getElementById("quite").disabled = false;
		document.getElementById("subBtn").disabled = false;
	} else {
		document.getElementById("checkAll").disabled = false;
		document.getElementById("checkOther").disabled = true;
		document.getElementById("cancel").disabled = true;
		document.getElementById("quite").disabled = true;
		document.getElementById("subBtn").disabled = true;
	}
}
function selectAll() {
	var element = document.forms[0].mid;
	if (element.length) {
		for (var i = 0; i < element.length; i++) {
			element[i].checked = true;
		}
	} else {
		element.checked = true;
	}
	document.getElementById("checkAll").disabled = true;
	document.getElementById("checkOther").disabled = true;
	document.getElementById("cancel").disabled = false;
	document.getElementById("quite").disabled = false
	document.getElementById("subBtn").disabled = false;
}
function selOther() {
	var element = document.forms[0].mid;
	for (var i = 0; i < element.length; i++) {
		if (element[i].checked) {
			element[i].checked = false;
		} else {
			element[i].checked = true;
		}
	}
}
function noCheck() {
	document.forms[0].reset();
	document.getElementById("checkAll").disabled = false;
	document.getElementById("cancel").disabled = true;
	document.getElementById("checkOther").disabled = true;
	document.getElementById("quite").disabled = true
	document.getElementById("subBtn").disabled = true;
}