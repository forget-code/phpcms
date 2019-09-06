
	var MarqueeTool=null;
	var ImageWidth;
	var DefaultImageWidth;
	var SliderBar;
	var ImageRelUrl;
	var ImageAbsUrl;
	var ProcessImageSrc;
	var ErrorList=null;

	function onMarqueeUpdate() {
		if (!MarqueeTool)
		{
			return false;
		}
		var coords = MarqueeTool.getCoords();
		$('sample_x').innerHTML = $('coord_x').value = coords.x1;
		$('sample_y').innerHTML = $('coord_y').value = coords.y1;
		$('sample_w').innerHTML = $('coord_w').value = $('c_w').value = coords.width;
		$('sample_h').innerHTML = $('coord_h').value = $('c_h').value = coords.height;
		$('sample_iw').innerHTML = $('coord_iw').value = $('sampleid').width;
		$('sample_ih').innerHTML = $('coord_ih').value = $('sampleid').height;
	}

	function imageZoomIn()
	{
		ImageWidth = ImageWidth + 1;
		if (ImageWidth>2048)
		{
			ImageWidth = 2048;
		}
		SliderBar.setValue(ImageWidth);
		resizeImage('sampleid',ImageWidth,0,1);
		onMarqueeUpdate();
	}

	function imageZoomOut()
	{
		ImageWidth = ImageWidth - 1;
		if (ImageWidth<100)
		{
			ImageWidth = 100;
		}
		SliderBar.setValue(ImageWidth);
		resizeImage('sampleid',ImageWidth,0,1);
		onMarqueeUpdate();
	}

	function resizeImage(element,maxwidth,maxheight,force)
	{
		if (MarqueeTool)
		{
			var coords = MarqueeTool.getCoords();
		}
		var sw = parseInt($(element).width);
		var sh = parseInt($(element).height);
		var sr = sw/sh;
		if (force)
		{
			$(element).width = maxwidth;
			$(element).height = parseInt(maxwidth/sr);
		}
		else
		{
			if (sw>maxwidth)
			{
				$(element).width = maxwidth;
				$(element).height = parseInt(maxwidth/sr);
			}
			if (parseInt($(element).height)>maxheight)
			{
				$(element).height = maxheight;
				$(element).width = parseInt(maxheight*sr);
			}
			ImageWidth = parseInt($(element).width);
			if (!DefaultImageWidth)
			{
				DefaultImageWidth = ImageWidth;
			}
		}
		$('sample_iw').innerHTML = $('coord_iw').value = $('sampleid').width;
		$('sample_ih').innerHTML = $('coord_ih').value = $('sampleid').height;
		if (MarqueeTool)
		{
			Element.setStyle(MarqueeTool.landingobj, {
				width: MarqueeTool.getElement().offsetWidth + 'px',
				height: MarqueeTool.getElement().offsetHeight + 'px'
			});
			if (coords.width>0 && coords.height>0)
			{
				MarqueeTool.setCoords(coords.x1,coords.y1,coords.width,coords.height);
				MarqueeTool.showEdges();
			}
		}
	}

	function sliderImage(v)
	{
		ImageWidth = v;
		resizeImage('sampleid',ImageWidth,0,1);
		onMarqueeUpdate();
	}

	function resetImage()
	{
		ImageWidth = DefaultImageWidth;
		SliderBar.setValue(ImageWidth);
		resizeImage('sampleid',DefaultImageWidth,0,1);
		resetSelection();
		onMarqueeUpdate();
	}

	function checkCoord()
	{
		if (MarqueeTool)
		{
			var coords = MarqueeTool.getCoords();
			var element = MarqueeTool.getElement();
			var cwmax = element.offsetWidth;
			var chmax = element.offsetHeight;
			var cw = coords.width;
			var ch = coords.height;
			var cx1 = coords.x1;
			var cy1 = coords.y1;
			var cx2 = coords.x1+coords.width;
			var cy2 = coords.y1+coords.height;

			if (cw<10 || ch<10)
			{
				alert("剪切区域太小，至少10*10大小！");
				return false;
			}
			return true;
			if (cx1==0 || cy1==0)
			{
				alert("剪切区域不能靠在上边或者左边！");
				return false;
			}
			return true;
		}
		else
		{
			return false;
		}
	}

	function setCustomCoord()
	{
		if (MarqueeTool)
		{
			var element = MarqueeTool.getElement();

			var coords = MarqueeTool.getCoords();
			var cw = coords.width;
			var ch = coords.height;
			try{
				if(parseInt($('c_w').value)>0 && parseInt($('c_h').value)>0)
				{
					cw = parseInt($('c_w').value);
					ch = parseInt($('c_h').value)
				}
			}
			catch(e)
			{
				var cw = coords.width;
				var ch = coords.height;
			}
			MarqueeTool.setCoords(coords.x1,coords.y1,cw,ch);
			MarqueeTool.showEdges();
		}
		onMarqueeUpdate();
	}

	function resetSelection()
	{
		if (MarqueeTool)
		{
			MarqueeTool.setCoords(0,0,160,120);
			MarqueeTool.showEdges();
			/*
			var coords = MarqueeTool.getCoords();
			if (coords.width>0 && coords.height>0)
			{
				MarqueeTool.setCoords(0,0,160,120);
			}
			*/
		}
		onMarqueeUpdate();
	}

	function sendCropAndResize()
	{
		onMarqueeUpdate();
		if (!MarqueeTool)
		{
			return false;
		}
		if (checkCoord()==false)
		{
			return false;
		}

		$('coordlayer').style.display="none";
		$('processlayer').style.display="";
		URL = 'process.php?'+$('coordsform').serialize();
		new Ajax.Request(URL, {
		  method: 'post',
		  onSuccess: function(transport) {
			if (transport.responseText.match(/^url:/i))
			{
				var imagesrc = transport.responseText.replace(/^url:/i,'');
				$('processlayer').style.display="";				
				$('processid').src=$('phpcms_path').value+imagesrc;
				$('fished').innerHTML = "<input type=\"button\" value=\"完成\" onclick=\"completeImage();window.returnValue='"+imagesrc+"';\" />";
				ImageRelUrl = imagesrc;
				ImageAbsUrl = $('processid').src;
				$('processcompleteid').style.display="";
			}
			else
			{
				var errorindex = transport.responseText.replace(/^error:/i,'');
				errorindex = errorindex.replace(/^([0-9]+)/,"$1");
				errorindex = errorindex.match(/^[0-9]+/) ? parseInt(errorindex) : 0;
				showError(errorindex);
				$('processlayer').style.display="none";
				$('coordlayer').style.display="";
				$('processcompleteid').style.display="none";
			}
		  }
		});
	}

	function redoImage()
	{
		$('processlayer').style.display="none";
		$('coordlayer').style.display="";
		$('processid').src = ProcessImageSrc;
	}
	function getcookie(name)
	{
		//name = cookiepre+name;
		var arg = name + "="; 
		var alen = arg.length; 
		var clen = document.cookie.length; 
		var i = 0; 
		while (i < clen) { 
		var j = i + alen; 
		if (document.cookie.substring(i, j) == arg) 
		return getcookieval(j); 
		i = document.cookie.indexOf(" ", i) + 1; 
		if (i == 0) break; 
		} 
		return null; 
	}
	function getcookieval(offset)
	{
		var endstr = document.cookie.indexOf (";", offset); 
		if (endstr == -1) 
		endstr = document.cookie.length; 
		return unescape(document.cookie.substring(offset, endstr)); 
	}
	function deletecookie(name)
	{
		var exp = new Date(); 
		exp.setTime (exp.getTime() - 1); 
		var cval = getcookie(name);
		//name = cookiepre+name;
		document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString(); 
	}
	function completeImage()
	{
		if (window.opener && !window.opener.closed)
		{
			try{
				window.opener.window.completeHandle(ImageRelUrl,ImageAbsUrl);
			}
			catch(e)
			{
				;
			}
		}
		deletecookie('thumbfile');
		window.close();
	}

	function showError(index)
	{
		if (!ErrorList)
		{
			var ErrorList = new Array();
			var strError = $('error_list').value;
			strError = strError.replace(/(^[ \r\n]+|[ \r\n]+$)/,'');
			ErrorList = strError.split(/[\r\n]+/);
		}
		alert(ErrorList[index]);
	}

	function onWindowLoad() {
		ProcessImageSrc = $('processid').src;
		resizeImage('sampleid',500,375,0);
		new PreviewToolTip('element_container', {id: 'preview'});
		MarqueeTool = new Marquee('sampleid', {
			preview: 'preview', 
			color: '#333', 
			opacity: 0.3,
			coords: { x1:0, y1:0, width:160,height:120 }
		});
		$('uploadingid').style.display="none";
		MarqueeTool.setOnUpdateCallback(onMarqueeUpdate);
		SliderBar = new Control.Slider('handle','track',{increment:1,sliderValue:DefaultImageWidth,range:$R(100,4096),
			onSlide:function(v){sliderImage(v);},
			onChange:function(v){sliderImage(v);}});
	}

	Event.observe(window, 'load', onWindowLoad);