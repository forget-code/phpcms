$(document).ready(function(){
	$(window).scroll(resscrEvt);
	$(window).resize(resscrEvt);
});
//显示灰色背景和操作窗口
//vType:窗口加载的是html代码还是文件，参数可能为html或url
//url为代码或文件名 args 为传递的参数 格式为{arg1:"",arg2:""} w为窗口的宽 h为窗口的高showWin('url','/plus/jsview.php?aid=[field:id/]&jsview=1','',600,305);
function openshow(action,url,width,height){
	showWin('url',url,'',width,height);
}

function showWin(vType,url,args,w,h){
var bH=document.body.scrollHeight+"px";
		//var bH2=$("body").height();
var bW=$("body").width();
$("#msg").height(h);
$("#msg").width(w);
var objWH=objValue("msg");
$("#fullBg").css({width:bW,height:bH,display:"block"});
var tbT=objWH.split("|")[0]+"px";
var tbL=objWH.split("|")[1]+"px";
$("#msg").css({top:tbT,left:tbL,display:"block"});
$("#cttt").html("<br /><br /><br /><div onclick='closeWin();'>正在加载，请稍后...(单击此处退出演示)</div>");
if(vType=="url")
{
	$("#cttt").load(url,args);
}
else  $("#cttt").html(url);
}
function objValue(obj){
	var st=document.documentElement.scrollTop;//滚动条距顶部的距离
	var sl=document.documentElement.scrollLeft;//滚动条距左边的距离
	var ch=document.documentElement.clientHeight;//屏幕的高度
	var cw=document.documentElement.clientWidth;//屏幕的宽度
	var objH=$("#"+obj).height();//浮动对象的高度
	var objW=$("#"+obj).width();//浮动对象的宽度
	var objT=Number(st)+(Number(ch)-Number(objH))/2;
	var objL=Number(sl)+(Number(cw)-Number(objW))/2;
	return objT+"|"+objL;
}
function resscrEvt(){
	var bjCss=$("#fullBg").css("display");
	if(bjCss=="block"){
	var bH2=document.body.scrollHeight+"px";
		//var bH2=$("body").height();
	var bW2=$("body").width();
	$("#fullBg").css({width:bW2,height:bH2});
	var objV=objValue("msg");
	var tbT=objV.split("|")[0]+"px";
	var tbL=objV.split("|")[1]+"px";
	$("#msg").css({top:tbT,left:tbL});
	}
}
//关闭灰色背景和操作窗口
function closeWin(){
$("#fullBg").css("display","none");
$("#msg").css("display","none");
}

function   backup(){
        if(event.escKey || window.event.keyCode==27)   closeWin();   
}   
document.onkeypress=backup;