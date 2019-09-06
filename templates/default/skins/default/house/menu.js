function externallinks()
{ 
	if(!document.getElementsByTagName) return; 
	var anchors = document.getElementsByTagName("a"); 
	for(var i=0; i<anchors.length; i++)
	{ 
		var anchor = anchors[i]; 
		if(anchor.getAttribute("href") && anchor.getAttribute("rel") == "external") 
		   anchor.target = "_blank"; 
	} 
} 
window.onload = externallinks;

function fod(obj,name)
{
	var p = obj.parentNode.getElementsByTagName("li");
	var p1 = document.getElementById(name).getElementsByTagName("div");
	for(i=0;i<p1.length;i++)
	{
		if(obj==p[i])
		{
			p[i].className = "s";
			p1[i].className = "dis";
		}
		else
		{
			p[i].className = "";
			p1[i].className = "undis";
		}
	}
}