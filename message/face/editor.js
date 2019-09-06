document.write("<iframe name='editor' id='editor' src='about:blank' width='100%' height='100%' scrolling='yes' frameborder='1' allowtransparency='true'></iframe>");
var strBody = "<html>\r\n<head>\r\n<meta http-equiv='content-type' content='text/html;charset=utf-8'>\r\n<title>Editor</title>\r\n<style type='text/css'>\r\n<!--\r\nbody{font-familly:宋体,Arial,sans-serif;font-size:13px;color:#000000;word-break:break-all;word-wrap:break-word;margin:3px;background-color:#ffffff;}\r\np{margin:2px;}\r\n-->\r\n</style>\r\n</head>\r\n<body>"+document.getElementById('content').value+"\r\n</body>\r\n</html>";
editor.document.open();
editor.document.write(strBody);
editor.document.close();
editor.document.designMode="On";
editor.focus();
function formSubmit() {
	if (document.getElementById("sendto") && document.getElementById("sendto").value == "") {
		alert("发送到不能为空!");
		document.getElementById("sendto").focus();
		return false;
	} else if (document.getElementById("title").value == "") {
		alert("标题不能为空!");
		document.getElementById("title").focus();
		return false;
	} else if (editor.document.body.innerHTML == "") {
		alert("消息内容不能为空!");
		editor.focus();
		return false;
	} else {
		document.getElementById("content").value = editor.document.body.innerHTML;
		return true;
	}
}
function formReset() {
	document.getElementById("content").value = "";
	editor.document.body.innerHTML = "";
	return true;
}