function FormatText(command, option)
{
	editor.focus();
  	editor.document.execCommand(command, true, option);
}

function doNew()
{
	editor.focus();
	editor.document.body.innerHTML = '';
}

function doReplace()
{
	var a=prompt('请输入要查找的字符...', '');
	var b=prompt('请输入要替换的字符...', '');
	if(a)
	{
		editor.document.body.innerHTML = editor.document.body.innerHTML.replace(new RegExp(a,"gm"),b);
	}
	editor.focus();
}

function doHelp()
{
	if(confirm('帮助 Help (?)\n\n如使用中有任何问题,请访问:\n\nhttp://bbs.phpcms.cn\n\n寻求解决...\n\n名称:PHPCMS编辑器\n\n主页:http://www.phpcms.cn\n\n(c)2007 PHPCMS GROUP'))
	{
		window.open('http://bbs.phpcms.cn');
	}
}

function doQuote()
{
	var str='<span style="width:99%;background:#FFFFF0;border:#EEEEEE 1px dotted;"><strong>Quote:</strong><br/></span>';
	Insert(str);
}

function Zoom(mode)
{
	if(mode == 'up')
	{
		if(Number($('EditorAREA').height)-50 > 100) $('EditorAREA').height = Number($('EditorAREA').height)-50;
	}
	else if(mode == 'right')
	{
		$('EditorAREA').width = Number($('EditorAREA').width)+50;
	}
	else if(mode == 'down')
	{
		$('EditorAREA').height = Number($('EditorAREA').height)+50;
	}
	else if(mode == 'left')
	{
		if(Number($('EditorAREA').width)-50 > 380) $('EditorAREA').width = Number($('EditorAREA').width)-50;
	}
	editor.focus();
}

function Insert(str)
{
	editor.focus();
	var r = editor.document.selection.createRange();
	var s = '%N#H#%';
	r.text = s;
	editor.document.body.innerHTML = editor.document.body.innerHTML.replace(s, str);
}

function cc_Insert(str)
{
	Insert(str);
}

function Preview()
{
	if ($('Mode_Img').src.indexOf('code.gif') == -1) setMode();
	var code = '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8'+editorCharset+'"><link rel="stylesheet" type="text/css" href="'+editorCss+'"><link rel="stylesheet" type="text/css" href="'+PHPCMS_PATH+'editor/css/editor.css"><body>'+editor.document.body.innerHTML+'</body></html>';
	var newwin = window.open('','','');
	newwin.opener = null;
	newwin.document.write(code);
	newwin.document.close();
}

function hr()
{
	var arr = showModalDialog(PHPCMS_PATH+"editor/dialog.php?do=hr", "", "dialogWidth:400px; dialogHeight:145px; help: no; scroll: no; status: no");
	if (arr != null)
	{
		var ss=arr.split("*")
		a=ss[0];
		b=ss[1];
		c=ss[2];
		d=ss[3];
		e=ss[4];
		var str = '<hr';
		if(a) str += ' color="'+a+'"';
		if(b) str += ' size="'+b+'"';
		if(c) str += ' '+c;
		if(d) str += ' align="'+d+'"';
		if(e) str += ' width="'+e+'"';
		str += '>';
		Insert(str);
	}
	else
	{
		editor.focus();
	}
}

function link()
{
	var r = editor.document.selection.createRange().text;
	if(r == '' || typeof(r) == 'undefined')
	{
		alert('提示:请先选择需要链接的文字或对象!');
		editor.focus();
		return;
	}
	var arr = showModalDialog(PHPCMS_PATH+"editor/dialog.php?do=link", "", "dialogWidth:430px; dialogHeight:120px; help: no; scroll: no; status: no");
	if (arr != null)
	{
		var ss=arr.split("*")
		a=ss[0];
		b=ss[1];
		var str = '<a href="'+a+'"';
		if(b) str += ' target="'+b+'"';
		str += '>'+r+'</a>';
		Insert(str);
	}
	else
	{
		editor.focus();
	}
}

function fieldset()
{
	var arr = showModalDialog(PHPCMS_PATH+"editor/dialog.php?do=fieldset", "", "dialogWidth:400px; dialogHeight:150px; help: no; scroll: no; status: no");
	if (arr != null)
	{
		var ss=arr.split("*")
		a=ss[0];
		b=ss[1];
		c=ss[2];
		d=ss[3];
		var str = '<fieldset';
		if(a) str += ' align="'+a+'"';
		if(c || d) str += ' style="color:'+c+';background:'+d+';"';
		str += '><legend';
		if(b) str += ' align="'+b+'"';
		str += '>标题</legend>内容</fieldset>';
		Insert(str);
	}
	else
	{
		editor.focus();
	}
}

function iframe()
{
	var arr = showModalDialog(PHPCMS_PATH+"editor/dialog.php?do=iframe", "", "dialogWidth:450px; dialogHeight:170px; help: no; scroll: no; status: no");
	if (arr != null)
	{
		var ss=arr.split("*");
		a=ss[0];
		b=ss[1];
		c=ss[2];
		d=ss[3];
		e=ss[4];
		f=ss[5];
		g=ss[6];
		if(a == '' || a == 'http://') return;
		var  str = '<iframe src="'+a+'" scrolling="'+b+'" frameborder="'+c+'"';
		if(d) str += ' marginheight="'+d+'"';
		if(e) str += ' marginwidth="'+e+'"';
		if(f) str += ' width="'+f+'"';
		if(g) str += ' height="'+g+'"';
		str += '></iframe>';
		Insert(str);
	}
	else
	{
		editor.focus();
	}
}

function table()
{
	var arr = showModalDialog(PHPCMS_PATH+"editor/dialog.php?do=table", "", "dialogWidth:400px; dialogHeight:200px; help: no; scroll: no; status: no");
	if (arr != null)
	{
		var ss=arr.split("*");
		a=ss[0];
		b=ss[1];
		c=ss[2];
		d=ss[3];
		e=ss[4];
		f=ss[5];
		g=ss[6];
		h=ss[7];
		var  str = '<table width="'+c+'" border="'+d+'"  cellpadding="'+e+'" cellspacing="'+f+'" bordercolor="'+g+'" bgcolor="'+h+'">';
		for(var i=1; i<=a; i++)
		{
			str += '<tr>';
			for(var j=1; j<=b; j++)
			{
				str += '<td>&nbsp;</td>';
			}
			str += '</tr>';
		}
		str += '</table>';
		Insert(str);
	}
	else
	{
		editor.focus();
	}
}

function swf()
{
	var arr = showModalDialog(PHPCMS_PATH+"editor/dialog.php?do=swf&keyid="+editorKeyid, "", "dialogWidth:450px; dialogHeight:145px; help: no; scroll: no; status: no");
	if (arr != null)
	{
		var ss=arr.split("*");
		a=ss[0];
		b=ss[1];
		c=ss[2];
		var str = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'+b+'" height="'+c+'"><param name="movie" value="'+a+'"><param name="quality" value="high"><embed src="'+a+'" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'+b+'" height="'+c+'"></embed></object>';
		Insert(str);
	}
	else
	{
		editor.focus();
	}
}

function pic()//img 在html4不可以用xhtml可用
{
	var arr = showModalDialog(PHPCMS_PATH+"editor/dialog.php?do=img&keyid="+editorKeyid, "", "dialogWidth:450px; dialogHeight:170px; help: no; scroll: no; status: no");
	if (arr != null)
	{
		var ss=arr.split("*");
		a=ss[0];
		b=ss[1];
		c=ss[2];
		d=ss[3];
		var str = '<a href="'+a+'" target="_blank"><img src="'+a+'"';
		if(b) str += ' width="'+b+'"';
		if(c) str += ' height="'+c+'"';
		if(d) str += ' alt="'+d+'"';
		str += ' /></a>';
		Insert(str);
	}
	else
	{
		editor.focus();
	}
}

function mv()
{
	var arr = showModalDialog(PHPCMS_PATH+"editor/dialog.php?do=mv&keyid="+editorKeyid, "", "dialogWidth:450px; dialogHeight:145px; help: no; scroll: no; status: no");
	if (arr != null)
	{
		var ss=arr.split("*");
		a=ss[0];
		b=ss[1];
		c=ss[2];
		var str = '<embed src="'+a+'" width="'+b+'" height="'+c+'" type="audio/x-pn-realaudio-plugin" console="Clip1" controls="IMAGEWINDOW,ControlPanel,StatusBar" autostart="true"></embed>';
		Insert(str);
	}
	else
	{
		editor.focus();
	}
}

function att()
{
	var arr = showModalDialog(PHPCMS_PATH+"editor/dialog.php?do=att&keyid="+editorKeyid, "", "dialogWidth:450px; dialogHeight:145px; help: no; scroll: no; status: no");
	if (arr != null)
	{
		var ss=arr.split("*");
		a=ss[0];
		b=ss[1] ? ss[1] : ss[0];
		var str = '<a href="'+a+'">[附件:'+b+']</a>';
		Insert(str);
	}
	else
	{
		editor.focus();
	}
}