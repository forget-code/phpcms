var url = phpcms_path+"area.php";

function loadprovince()
{
    var pars = "action=province";
    var myAjax = new Ajax.Request(url, {method: 'get', parameters: pars, onComplete: setprovince});
}

function setprovince(Request)
{
	var text = Request.responseText;
    var provinces = text.split(",");
	var currprovince = enterValue(provinces, $('province'));
	loadcity(currprovince);
}

function loadcity(province)
{
    var pars = "action=city&province="+province;
    var cAjax = new Ajax.Request(url, {method: 'get', parameters: pars, onComplete: setcity});
}

function setcity(Request)
{
	var text = Request.responseText;
    var citys = text.split(",");
	var currcity = enterValue(citys, $('city'));
	loadarea($('province').value, currcity);
}

function loadarea(province,city)
{
    var pars = "action=area&province="+province+"&city="+city;
    var aAjax = new Ajax.Request(url, {method: 'get', parameters: pars, onComplete: setarea});
}

function setarea(Request)
{
	var text = Request.responseText;
    var areas = text.split(",");
	enterValue(areas, $('area'));
}

function enterValue(cell,place)
{
	clearPreValue(place);
	var selectedval = cell[0];
	for(i=0; i<cell.length; i++)
	{
	    isselected = addOption(place, cell[i], cell[i]);
		if(isselected)
		{
			place.options[i].selected = true;
			selectedval = cell[i];
		}
	}
	return selectedval;
}

function addOption(objSelectNow,txt,val)
{
	var objOption = document.createElement("option");
	objOption.text = txt;
	objOption.value = val;
	objSelectNow.options.add(objOption);
	return objOption.value == selectedprovince || objOption.value == selectedcity || objOption.value == selectedarea;
}

function clearPreValue(pc)
{
	while(pc.hasChildNodes())
	pc.removeChild(pc.childNodes[0]);
}

loadprovince();