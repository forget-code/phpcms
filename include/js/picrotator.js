<!-- // linkpic

   var linkpic=new Array();
   var linkurl=new Array();
   var linktitle=new Array();
   var picnum=0;
   var istitle=0;
  
   var preloadedimages=new Array();
   for (i=1;i<linkpic.length;i++){
      preloadedimages[i]=new Image();
      preloadedimages[i].src=linkpic[i];
   }

function setTransition(){
   if (document.all){
      if(transition==-1) {
            picrotator.filters.revealTrans.Transition=Math.floor(Math.random()*23);
      }else{
            picrotator.filters.revealTrans.Transition=transition;
      }
      picrotator.filters.revealTrans.apply();
   }
}

function playTransition(){
   if (document.all)
      picrotator.filters.revealTrans.play()
}

function nextpic(){
   if(linkpic.length==0)return false;
   if(picnum<linkpic.length-1)picnum++ ;
      else picnum=0;
   setTransition();
   document.images.picrotator.src=linkpic[picnum];
   if(istitle){
         document.getElementById("picarticletitle").innerHTML="<a href='"+linkurl[picnum]+"' target='_blank'>"+linktitle[picnum]+"</a>";
   }else{
         document.getElementById("picarticletitle").innerHTML="";
   }
   playTransition();
   theTimer=setTimeout("nextpic()", timeout);
}

function jump2url(){
   jumpUrl=linkurl[picnum];
   jumpTarget='_blank';
   if (jumpUrl != ''){
      if (jumpTarget != '')window.open(jumpUrl,jumpTarget);
      else location.href=jumpUrl;
   }
}
function displayStatusMsg() { 
   status=linkurl[picnum];
   document.returnValue = true;
}
//-->