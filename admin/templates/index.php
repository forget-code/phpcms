<?php include admintpl('header');?>

<frameset name="main" rows="25,*" frameborder="no" border="0" framespacing="0" cols="*"> 
	<frame name="top" noresize scrolling="no" src="?file=index&action=top">
	<frameset cols="170,*" frameborder="no" border="0" framespacing="0" rows="*"> 
	<frame name="left" noresize scrolling="yes" src="?file=index&action=<?=$left?>">
	<frame name="right" noresize scrolling="yes" src="?file=index&action=main">
	</frameset>
</frameset>
<noframes></noframes>

</html>