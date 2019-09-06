var frame_id=1;
var frame_data=new Array();
var frame_form=new Array();
var userAgent=navigator.userAgent.toLowerCase();
var is_ie=(userAgent.indexOf('msie') != -1);
var is_opera=(userAgent.indexOf('opera') != -1);

function FixPrototypeForGecko()
{
	HTMLElement.prototype.__defineGetter__("runtimeStyle",element_prototype_get_runtimeStyle);
	window.constructor.prototype.__defineGetter__("event",window_prototype_get_event);
	Event.prototype.__defineGetter__("srcElement",event_prototype_get_srcElement);
	HTMLElement.prototype.__defineSetter__("outerHTML", setOuterHtml);
	HTMLElement.prototype.__defineGetter__("outerHTML", getOuterHtml);
}

function element_prototype_get_runtimeStyle()
{
	return this.style;
}

function window_prototype_get_event()
{
	return MTIR_searchevent();
}

function event_prototype_get_srcElement()
{
	return this.target;
}

function setOuterHtml(s) {
	var range=this.ownerDocument.createRange();
	range.setStartBefore(this);
	var fragment=range.createContextualFragment(s);
	this.parentNode.replaceChild(fragment, this);
}

function getOuterHtml() {
	var s='<span';
	var obj=this.attributes;
	for (i=0;i<obj.length;i++) {
		s+=' '+obj[i].nodeName+'="'+obj[i].nodeValue+'"';
	}
	s+='></span>';
	return s;
}

if(!is_opera && window.addEventListener) FixPrototypeForGecko();

function MTIR_searchevent()
{
	if(document.all) return window.event;
	var func=MTIR_searchevent.caller;
	while(func!=null)
	{
		var arg0=func.arguments[0];
		if(arg0)
		{
			if(arg0.constructor==Event || arg0.constructor==MouseEvent) return arg0;
		}
		func=func.caller;
	}
	return null;
}

function MTIR_create(src) {
	if (document.all && !is_opera) var _iframe=document.createElement("<iframe name='iframe_"+frame_id+"'></iframe>");
	else {
		var _iframe=document.createElement("iframe");
		_iframe.name='iframe_'+frame_id;
	}
	_iframe.id='iframe_'+frame_id;
	_iframe.style.display='none';
	if (src!='') _iframe.src=src;
	document.body.appendChild(_iframe);
	if (_iframe.attachEvent) {
		_iframe.attachEvent('onload', MTIR_load);
	} else {
		_iframe.addEventListener('load', MTIR_load, false);
	}
	return _iframe.id;
}

function MTIR_elementa() {
	try{
		target_event=MTIR_searchevent();
		var obj='';
		if (target_event.srcElement.tagName=='A' && target_event.srcElement.attributes._target.nodeName!='') {
			obj=target_event.srcElement;
		} else {
			if (target_event.srcElement.parentNode.tagName=='A' && target_event.srcElement.parentNode.attributes._target.nodeName!='') {
				obj=target_event.srcElement.parentNode;
			}
		}
		if (obj!='') {
			var _iframe=MTIR_create(obj.href);
			frame_data[frame_id]={
				'target':obj.attributes._target.nodeValue,
				'obj':obj
			}
			try{
				if (obj.attributes._addon.nodeName!='') {
					frame_data[frame_id]['addon']=true;
					frame_data[frame_id]['addonpos']=obj.attributes._addon.nodeValue;
				}
			} catch (e) {}
			if (is_ie || is_opera) {
				target_event.returnValue=false;
				target_event.cancelBubble=true;
			} else {
				target_event.stopPropagation();
				target_event.preventDefault();
			}
			frame_id++;
			return false;
		}
	} catch (e) {}
}

function MTIR_load() {
	target_event=MTIR_searchevent();
	if (target_event.srcElement) var id=target_event.srcElement.id.substr(7);
	else var id=this.id.substr(7);
	window.setTimeout("MTIR_show('"+id+"')",1);
}

function MTIR_parse() {
	obj=document.getElementsByTagName('SPAN');
	for(i=0;i<obj.length;i++) {
		try {
			if (obj[i].attributes._frame.nodeName!='') {
				obj[i].location=MTIR_location;
			}
		} catch (e) {}
	}
	obj=document.getElementsByTagName('FORM');
	for(i=0;i<obj.length;i++) {
		try {
			if (obj[i].attributes._target.nodeName!='' && obj[i].target=='') {
				if (!isNaN(parseInt(frame_form[i]))) {
					eval("obj[i].target='iframe_"+frame_form[i]+"'");
					frame_data[frame_form[i]]={
						'target':obj[i].attributes._target.nodeValue,
						'noremove':true
					}
					try{
						if (obj[i].attributes._addon.nodeName!='') {
							frame_data[frame_form[i]]['addon']=true;
							frame_data[frame_form[i]]['addonpos']=obj[i].attributes._addon.nodeValue;
						}
					} catch (e) {}
				} else {
					var form_iframe=MTIR_create('');
					obj[i].target=form_iframe;
					frame_data[frame_id]={
						'target':obj[i].attributes._target.nodeValue,
						'noremove':true
					}
					try{
						if (obj[i].attributes._addon.nodeName!='') {
							frame_data[frame_id]['addon']=true;
							frame_data[frame_id]['addonpos']=obj[i].attributes._addon.nodeValue;
						}
					} catch (e) {}
					frame_form[i]=frame_id;
					frame_id++;
				}
			}
		} catch (e) {}
	}
}

function MTIR_show(lid) {
	var content='';
	if (is_opera) {
		try {
			eval('content=iframe_'+lid+'.document.body.innerHTML');
		} catch (e) {}
	} else content=document.getElementById('iframe_'+lid).contentWindow.document.body.innerHTML;
	if (content!='') {
		if (document.getElementById(frame_data[lid]['target'])) {
			if (frame_data[lid]['addon']==true) {
				var targetself=document.getElementById(frame_data[lid]['target']).outerHTML;
				switch (frame_data[lid]['addonpos']) {
					case 'before':
						document.getElementById(frame_data[lid]['target']).outerHTML=targetself+content;
						break;
					case 'replace':
						document.getElementById(frame_data[lid]['target']).outerHTML=content;
						break;
					default:
						document.getElementById(frame_data[lid]['target']).outerHTML=content+targetself;
				}
			}
			else document.getElementById(frame_data[lid]['target']).innerHTML=content;
			var r=/[\n\r]function\s+(\S+?)\((.*?)\)\s*?\{([\n\r\s\S]+?)[\n\r]\}/;
			var func_name, func_parm, func_body, v;
			var reg=new RegExp(r);
			v=reg.exec(content);
			while (v) {
				func_name=v[1];func_parm=v[2];func_body=v[3];
				eval(func_name+'=new Function(func_parm, func_body)');
				content=content.replace(v[0], '');
				v=reg.exec(content);
			}
			var obj=document.getElementById('iframe_'+lid);
			if (frame_data[lid]['noremove']!=true) {
				obj.parentNode.removeChild(obj);
				frame_data[lid]=null;
			}
			MTIR_parse();
		}
	}
}

function MTIR_location(URL, is_addon, is_before) {
	var _iframe=MTIR_create(URL);
	if (!is_before) is_before='';
	frame_data[frame_id]={
		'target':this.id,
		'addon':is_addon,
		'addonpos':is_before
	}
	frame_id++;
}

function MTIR_onload(noinit) {	
	MTIR_parse();	
	try {
		frame_init();				
	} catch (e) {}
}

function frame(obj) {
	try {
		var obj=document.getElementById(obj);
		if (obj.tagName=='SPAN' && obj.attributes._frame.nodeName!='') return obj;
		else return false;
	} catch (e) {return false;}		
}

if (document.attachEvent) {
	document.attachEvent('onclick', MTIR_elementa);
	window.attachEvent('onload', MTIR_onload);
} else if (document.addEventListener) {
	document.addEventListener('click', MTIR_elementa, false);
	window.addEventListener('load', MTIR_onload, false);
}

MTIR_parse();