try {
	if(document.documentElement.addEventListener) {
		document.documentElement.addEventListener('keydown', parent.resetf5, false);
	} else if(document.documentElement.attachEvent) {
		document.documentElement.attachEvent("onkeydown", parent.resetf5);
	}
}catch(e){}

var tID=0;
function ShowTabs(ID)
{
	var tTabTitle=document.getElementById("TabTitle"+tID);
	var tTabs=document.getElementById("Tabs"+tID);
	var TabTitle=document.getElementById("TabTitle"+ID);
	var Tabs=document.getElementById("Tabs"+ID);
	if(ID!=tID)
	{
		tTabTitle.className='';
		TabTitle.className='selected';
		tTabs.style.display='none';
		Tabs.style.display='';
		tID=ID;
	}
}

function ChangeInput (objSelect,objInput)
{
	if (!objInput) return;
	var str = objInput.value;
	var arr = str.split(",");
	for (var i=0; i<arr.length; i++){
	  if(objSelect.value==arr[i])return;
	}
	if(objInput.value=='' || objInput.value==0 || objSelect.value==0){
	   objInput.value=objSelect.value
	}else{
	   objInput.value+=','+objSelect.value
	}
}

function file_select(textid, catid, isimage)
{
	var arr=Dialog('?mod=phpcms&file=file_select&catid='+catid+'&isimage='+isimage, '', 700, 500);
	if(arr!=null)
	{
		var s=arr.split('|');
		$('#'+textid).val(s[0]);
		try {$(textid+'size').value=s[1];}catch(e){};
	}
}
function AddMorePic(textid)
{
	var arr=Dialog('?mod=phpcms&file=more_pic_select', '', 700, 500);
	if(arr!=null)
	{
		var select = '';
		$.get('?mod=phpcms&file=more_pic_select&action=getdata&currentdir='+arr, function(data){
		    if(data !=null)
			{
				var arr_var=data.split('|');
				$.each(arr_var, function(n){
					var val = arr_var[n];
					select += "<input type='hidden' name='"+textid+"[]' value='"+val+"'><div id='file_uploaded_1'><span style='width:30px'><input type='checkbox' name='"+textid+"_delete[]' value='"+val+"' title='删除'></span><span style='width:60px'><input type='text' name='"+textid+"_description[]' value='' size='20' title='图片说明'></span><a href='###' onMouseOut='javascript:FilePreview(\""+val+"\", 0);' onMouseOver='javascript:FilePreview(\""+val+"\", 1);'>"+val+"</a></div>";
				});
				$('#'+textid).html(select);
			}
		});
	}
}
