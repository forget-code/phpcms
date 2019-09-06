<?php 
defined('IN_ADMIN') or exit('No permission resources.'); 
$show_header = $show_validator = $show_scroll = 1; 
include $this->admin_tpl('header','admin');
?>
<br />
<div class="pad-lr-10">
<div id="searchid" style="display:">
<form name="searchform" action="" method="get" >
<input type="hidden" value="special" name="m">
<input type="hidden" value="special" name="c">
<input type="hidden" value="public_get_pics" name="a">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
 			<?php echo $model_form?>&nbsp;&nbsp; 
<span id="catids"></span>&nbsp;&nbsp; <span id="title" style="display:none;"><?php echo L('title')?>：<input type="text" name="title" size="20"></span>
				<?php echo L('input_time')?>：
				<link rel="stylesheet" type="text/css" href="statics/js/calendar/calendar-blue.css"/>
			        <script type="text/javascript" src="statics/js/calendar/calendar.js"></script><input type="text" name="start_time" id="start_time" value="2010-06-21" size="10" class="date" readonly>&nbsp;<script language="javascript" type="text/javascript">
					date = new Date();document.getElementById ("start_time").value="<?php echo $_GET['start_time'] ? $_GET['start_time'] : format::date(SYS_TIME-2592000);?>";
					Calendar.setup({
						inputField     :    "start_time",
						ifFormat       :    "%Y-%m-%d",
						showsTime      :    false,
						timeFormat     :    "24"
					});
				 </script>-
				<input type="text" name="end_time" id="end_time" value="2010-07-22" size="10" class="date" readonly>&nbsp;<script language="javascript" type="text/javascript">
					date = new Date();document.getElementById ("end_time").value="<?php echo $_GET['end_time'] ? $_GET['end_time'] : format::date(SYS_TIME+86400);?>";
					Calendar.setup({
						inputField     :    "end_time",
						ifFormat       :    "%Y-%m-%d",
						showsTime      :    false,
						timeFormat     :    "24"
					});
				 </script>
				 <input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>
</div>
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			<th><?php echo L('content_title')?></th>
			</tr>
        </thead>
<tbody>
    <?php if(is_array($data)) { foreach ($data as $r) {?>
        <tr>
		<td><label style="display:block"><input type="radio" onclick="choosed(<?php echo $r['id']?>, <?php echo $r['catid']?>, '<?php echo $r['title']?>')" class="inputcheckbox " name='ids' value="<?php echo $r['id'];?>">		  <?php echo $r['title'];?></label></td>
		</tr>
     <?php } }?>
</tbody>
     </table>
    <div class="btn"> <input type="hidden" name="msg_id" id="msg_id"> </div>
    <div id="pages"><?php echo $pages;?></div>
</div>
</div>
</body>
</html>
<script type="text/javascript">

	function choosed(contentid, catid, title) {
		var msg = contentid+'|'+catid+'|'+title;
		$('#msg_id').val(msg);
	}

	function select_categorys(modelid, id) {
		if(modelid) {
			$.get('', {m: 'special', c: 'special', a: 'ajax_categorys_list', modelid: modelid, catid: id, pc_hash: pc_hash }, function(data){
				if(data) {
					$('#catids').html(data);
					$('#title').show();
				} else {
					$('#catids').html('');
					$('#title').hide();
				}
			});
		}
	}
	select_categorys(<?php echo $_GET['modelid']?>, <?php echo $_GET['catid']?>);
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'220',height:'70'}, function(){this.close();$(obj).focus();})}});
		$("#typeid").formValidator({tipid:"msg_id",onshow:"<?php echo L('please_choose_type')?>",oncorrect:"<?php echo L('true')?>"}).inputValidator({min:1,onerror:"<?php echo L('please_choose_type')?>"});	
	});
	$("#myform").submit(function (){
		var str = 0;
		$("input[name='ids[]']").each(function() {
			if($(this).attr('checked')==true) str = 1;
		});
		if(str==0) {
			alert('<?php echo L('choose_news')?>');
			return false;
		}
		return true;
	});
</script>