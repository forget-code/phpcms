var url = area_path+"area.php";
function areaload(areaid)
{
    var pars = "action=ajax&areaid="+areaid+"&keyid="+area_keyid;
    var myAjax = new Ajax.Request(url, {method: 'get', parameters: pars, onComplete: setload});
}

function setload(Request)
{
	var text = Request.responseText;
    $('load_area').innerHTML = $('load_area').innerHTML + text + '&nbsp;';
}

function reload()
{
	$('areaid').value = '';
	$('load_area').innerHTML = '';
	areaload(0);
}

areaload(0);