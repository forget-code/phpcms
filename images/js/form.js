function SelectPic()
{
  var arr=Dialog('?mod=phpcms&file=file_select&type=thumb','',700,500);
  if(arr!=null)
  {
    var s=arr.split('|');
    $('#thumb').val(s[0]);
  }
}

function SelectKeyword()
{	
	var s=Dialog('?mod=phpcms&file=keyword&action=select','',700,500);
	if(s!=null)
	{
		if($('#keywords').val() == '')
		{
			$('#keywords').val(s);
		}
		else if($('#keywords').val().indexOf(s) == -1)
		{
			$('#keywords').val($('#keywords').val()+' '+s);
		}
	}
	$('#keywords').focus();
}

function SelectAuthor()
{	
	var s=Dialog('?mod=phpcms&file=author&action=select','',700,500);
	if(s!=null)
	{
		$('#author').val(s);
	}
	$('#author').focus();
}

function SelectCopyfrom()
{	
	var s=Dialog('?mod=phpcms&file=copyfrom&action=select','',700,500);
	if(s!=null)
	{
		$('#copyfrom').val(s);
	}
	$('#copyfrom').focus();
}

function ruselinkurl()
{
	if($('#islink').attr('checked')==true)
	{
		$('#linkurl').attr('disabled','');
		$('input[require]').attr('require','false');
		$('#title').attr('require','true');
	}
	else
	{
		$('#linkurl').attr('disabled','disabled');
		$('input[require]').attr('require','true');
	}
}