var url = area_path+"info_area.php";
function areaload(areaid)
{
    var pars = "areaid="+areaid+"&channelid="+area_channelid;
    var myAjax = new Ajax.Request(url, {method: 'get', parameters: pars, onComplete: setload});
}

function setload(Request)
{
	var text = Request.responseText;
    $('load_area').innerHTML = $('load_area').innerHTML + text + '&nbsp;';
}
function reload()
{
	$('load_area').innerHTML = '';
	areaload(0);
}
areaload(0);