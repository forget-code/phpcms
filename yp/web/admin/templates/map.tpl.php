<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include managetpl('header');
?>
<script language="javascript">
<!--
function update(x,y,z)
{
	var checkurl = '<?=$SITEURL?>/yp/admin.php';
	var pars = "file=<?=$file?>&action=update&x="+x+"&y="+y+"&z="+z;
	var myAjax = new Ajax.Request(checkurl, {method: 'post', parameters: pars, onComplete: alertmessage});
}

function alertmessage(Request)
{
	if(Request.responseText == '1'){
	alert('企业地址位置保存成功');
	window.location.reload();
	}
	else
	{
		alert('操作失败');
	}
}
//-->
</script>
<script language="javascript" src="http://api.51ditu.com/js/maps.js"></script>
<script language="javascript" src="http://api.51ditu.com/js/ezmarker.js"></script>
<BR>
<table width="100%"  border="0" cellpadding="5" cellspacing="2" class="tableborder">
<th >企业地理位置标注</th>
<input type="hidden" id="x" name="x">
<input type="hidden" id="y" name="y">
<input type="hidden" id="z" name="z">
<tr> 
	<td class="tablerow">
<script language="JavaScript">
<!--
    function setMap(point,zoom)
	{
		var x = point.getLongitude();
		var y = point.getLatitude();
        var z = zoom;
		update(x,y,z);
	}

    var ezmarker = new LTEZMarker("pos");
    LTEvent.addListener(ezmarker,"mark",setMap);//"mark"是标注事件
	
//-->
</script>
	</td>
</tr>
</table><BR>
<?php
if($map!='')
{
	?>
<table width="100%"  border="0" cellpadding="5" cellspacing="2" class="tableborder">
<TR>
	<TD>
<div id="maps" style="position:relative; width:100%; height:350px; border:black solid 1px;"> 
                                                  <script language="javascript">
	var maps = new LTMaps( "maps" );
	maps.cityNameAndZoom( "西安" , 2);
	var c = new LTSmallMapControl();
	maps.addControl(c);
	var point = new LTPoint(<?=$x?>,<?=$y?>); 
    maps.centerAndZoom( point, <?=$z?> );
	var text=new LTMapText(point,[0,-18]);
	text.setLabel( "<?=$pagename?>" );
	setTimeout("maps.addOverLay( text );",3000);
	var icon=new LTIcon("<?=$SITEURL?>/images/centerPoi.gif",[24,24],[12,12]);
		var marker=new LTMarker(new LTPoint(<?=$x?>,<?=$y?>),icon);
		maps.addOverLay(marker);
</script>
                  </div></TD>
</TR>
</TABLE>
<?php

}

?>
</body>
</html>