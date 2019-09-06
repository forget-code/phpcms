 window.onload=function() {
 	$('drag1').style.left= screen.width-160;
 	var pdtcompare = getcookie("pdtcompare");
	if(typeof(pdtcompare)=="object")
	{
		pdtcompare=",";
	}
	else
	{
		var pidarr = pdtcompare.split(",");
		var cc = pidarr.length;
		for(i=0;i<cc;i++)
		{
			if(pidarr[i]!="")
			{
				var pidname = pidarr[i].split("|");
				addtocompare(pidname[0],pidname[1],false);
			}
		}
	}	
 } 

self.onError=null;
 var currentX = currentY = 0;  
 var whichIt = null;           
 var lastScrollX = 0;
 var lastScrollY = 0;
 var NS = (document.layers) ? 1 : 0;
 var IE = (document.all) ? 1: 0;
 function heartBeat() {
  if(IE) { diffY = document.body.scrollTop; diffX = document.body.scrollLeft; }
     if(NS) { diffY = self.pageYOffset; diffX = self.pageXOffset; }
  if(diffY != lastScrollY) {
                 percent = 0.1 * (diffY - lastScrollY);
                 if(percent > 0) percent = Math.ceil(percent);
                 else percent = Math.floor(percent);
     if(IE) document.all.drag1.style.pixelTop += percent;
     if(NS) document.drag1.top += percent; 
                 lastScrollY = lastScrollY + percent;
     }
  if(diffX != lastScrollX) {
   percent = 0.1 * (diffX - lastScrollX);
   if(percent > 0) percent = Math.ceil(percent);
   else percent = Math.floor(percent);
   if(IE) document.all.drag1.style.pixelLeft += percent;
   if(NS) document.drag1.left += percent;
   lastScrollX = lastScrollX + percent;
  } 
 }
 if(NS || IE) action = window.setInterval("heartBeat()",1);

var pidn=0;
var spro_id = -1;
function delsingle(obj,pdtid)
{
	var row = rowindex(obj.parentNode.parentNode);
    var tbl = document.getElementById('comparetable');
    tbl.deleteRow(row);
    var pdtcompare = getcookie("pdtcompare");
    var reg = new RegExp(",("+pdtid+")\\\|[^,]*,");
    pdtcompare = pdtcompare.replace(reg,",");
    setcookie("pdtcompare",pdtcompare);
}
function cleartbl()
{
	var tblObj = document.getElementById("comparetable"); 
 	var length = tblObj.rows.length-1 ;      
    for( var i=1; i<length; i++ )
    {
      tblObj.deleteRow(1); 
    }  
    setcookie("pdtcompare","");	
    spro_id=-1;
}
function rowindex(tr)
{
    if (Browser.isIE)
    {
        return tr.rowIndex;
    }
    else
    {
      table = tr.parentNode.parentNode;

      for (i = 0; i < table.rows.length; i++)
      {
          if (table.rows[i] == tr)
          {
              return i;
              break;
          }
      }
    }
}
function addtocompare(productid,pdtname,comparerepeat,pro_id)//插入新比较
{
	if(productid=='') return false;
	if(spro_id!=-1 && spro_id!=pro_id)
	{
		alert("该商品与前面所选择的商品不是同一类型，无法进行比较");
		return;
	}
	pdtname = pdtname.replace(",","");
	pdtname = pdtname.replace("|","");
	var pidarr;
	var pdtcompare = getcookie("pdtcompare");
	if(!pdtcompare) pdtcompare = ",";
	var pidstr = ","+productid+"|";
	pidarr = pdtcompare.split(",");
	
	if(comparerepeat)
	{
	    if(pidarr.length>9)
	    {
		  alert('最多只可选择8款商品进行对比!')
		  return false;
		}
		if(pdtcompare.indexOf(pidstr)>-1)
		{
			alert("对比表内已经存在该商品，请重新选择!");
			return false;		
		}
		else
		{
			setcookie("pdtcompare",pdtcompare+productid+"|"+pdtname+",");
			spro_id = pro_id;
		}	
	}
	
    var src   = document.getElementById('trobj');
    //var idx   = rowindex(src);
    var tbl   = document.getElementById('comparetable');
    var row   = tbl.insertRow(1);
    var cell  = row.insertCell(-1);
    var createtd = "<tr ><td bgcolor=\"EEEEEE\" align=\"center\" height=\"28\"><input title=\"点击删除\" type=button name='pdt"+productid+"' value='"+pdtname+"' onclick=\"delsingle(this,"+productid+")\"  style=\"border:1px solid;border-color:#dddddd ;background-color:#efefef;height:24;width:120;cursor:hand;color:black;\"><input type=hidden name='pids[]' value='"+productid+"'></td></tr>";
    cell.innerHTML = createtd;
    cell.className = 'tablerow'; 
}

function check()
{
	var pdtcompare = getcookie("pdtcompare");
	if(typeof(pdtcompare)=="object")
	{
	  alert('请至少选择两款商品进行对比!')
	  return false;
	}
	var pidarr = pdtcompare.split(",");
    if(pidarr.length>10)
    {
	  alert('最多只可选择8款商品进行对比!')
	  return false;
	}
	if(pidarr.length==3)
    {
	  alert('请至少选择两款商品进行对比!')
	  return false;
	}
	document.getElementById('compareform').submit();
	
}

var ey=0,ex=0,lx=0,ly=0,canDrg=false,thiso=null;//
var x, y,rw,rh;
  var divs=document.getElementsByTagName("div");
  for (var i=0;i<divs.length;i++){  
    if(divs[i].getAttribute("rel")=="drag"){
      divs[i].onmousemove=function(){
       thismove(this);//实时得到当前对象与鼠标的值以判断拖动及关闭区域;
    }
    }
  }

function thismove(o){
    rw=parseInt(x)-parseInt(o.style.left);
    rh=parseInt(y)-parseInt(o.style.top);
}
function dargit(o,e){
thiso = o;
canDrg = true;
 if(!document.all){
      lx = e.clientX; ly = e.clientY;
      }else{
        lx = event.x; ly = event.y;
    }
 if(document.all) thiso.setCapture();
    
  st(o);//置前或置后
 
}

document.onmousemove = function(e){
if(!document.all){ x = e.clientX; y = e.clientY; }else{ x = event.x; y = event.y; }
if(canDrg){
    //if(rh<=20 && rw<180 ){//如果要设定拖动区域可以作判断
  var ofsx = x - lx;
  thiso.style.left = parseInt(thiso.style.left) + ofsx;
  lx = x;
  var ofsy = y - ly;
  thiso.style.top = parseInt(thiso.style.top) + ofsy;
  ly = y;
  //}else{canDrg=false;}
}
}

document.onmouseup=function(){
      canDrg=false;//拖拽变量设为false
      if(document.all && thiso != null){
        //ie下，将清捕获;
         thiso.releaseCapture();
       thiso = null;
   }
}


function set(obj){
     obj=obj.parentNode.parentNode;
     if(obj.getAttribute("rel"));
     //obj.style.zIndex=1;
     
}
function st(o){

var p = o.parentNode;
if(p.lastChild != o){
  p.appendChild(o);
}

if(rh<=20 && rw>=110){
canDrg=false;
//如果选择的是关闭区域;
     // window.status=rw+"|"+rh;
      o.style.display = 'none';
      //if(p.firstChild == o) return;
      //p.insertBefore(o, p.firstChild);
        }
}