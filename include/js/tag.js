function doPreview(){
	 document.myform.action.value = 'preview';
	 document.myform.target = '_blank';
	 return true;
}

function doSave(){
	 document.myform.action.value = 'save';
	 document.myform.target='_self';
	 return true;
}

function doCheck(){
	if (!myform.tagid.value && (myform.tag.value=="" || myform.tag.value=="my_")) {
		alert("请输入标签配置名称！");
		myform.tag.focus();
		return false;
	}
	if (myform.tagname.value=="") {
		alert("请输入标签配置说明！");
		myform.tagname.focus();
		return false;
	}
	return true;
}

function CopyInp(theField) {
	var tempval=eval('document.'+theField)
	tempval.focus()
	tempval.select()
	therange=tempval.createTextRange()
	therange.execCommand('Copy')
	alert("复制成功,请粘贴到相应的模板中即可实现标签调用!");
}