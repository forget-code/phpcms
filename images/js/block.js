$(document).ready(function(){
  $(".show_block").attr("style", "margin:5px;padding:5px;width:200px;text-align:center;background-color: #cccccc;border:#CCCCCC solid 1px;filter:Alpha(opacity=30);-moz-opacity:0.3;-khtml-opacity:0.3;opacity:0.3;");
  $(".show_block").attr("title", "参数包含变量的碎片不能在此维护");
  $(".show_tag").attr("style", "margin:5px;padding:5px;width:200px;text-align:center;cursor:pointer;background-color: #66FF00;border:#CCCCCC solid 1px;filter:Alpha(opacity=40);-moz-opacity:0.4;-khtml-opacity:0.4;opacity:0.4;");
  $(".show_tag").attr("title", "点击可修改，参数包含变量的中文标签不能在此预览");
  $(".block_add").attr("style", "margin:5px;padding:5px;width:60px;text-align:center;cursor:pointer;background-color: yellow;border:#cccccc solid 1px;filter:Alpha(opacity=80);-moz-opacity:0.8;-khtml-opacity:0.8;opacity:0.8;");
  set_tag_float_div();
  set_block_float_div();
  $(".show_tag").click(function(){
	  redirect(admin_url+'?mod='+$(this).attr('module')+'&file=tag&action=edit&tagname='+$(this).attr('tagname')+'&forward='+$(this).attr('forward'));
  });
  $(".block_add").mouseover(function(){
	  $(this).css("background-color", "#FFFF99");
  });
  $(".block_add").mouseout(function(){
	  $(this).css("background-color", "yellow");
  });
  $(".block_add").click(function(){
	  $('.jqmWindow').show();
	  block_iframe.location = admin_url+'?mod=phpcms&file=block&action=add&ajax=1&pageid='+$(this).attr('pageid')+'&blockno='+$(this).attr('blockno');
	  $('#blockname').html('添加碎片');
  });
  $(".jqmWindow").jqm({overlay: 0	}).jqDrag(".title");
  $(".jqmWindow").hide();
  $(".jqmClose").click(function(){
	    close_window();
  });
});

function set_block_float_div()
{
  $(".block_float_div").attr("style", "position:absolute;z-index:100;border:#cccccc solid 1px;background-color:#FFFF66;filter:Alpha(opacity=40);-moz-opacity:0.4;-khtml-opacity:0.4;opacity:0.4;cursor:pointer;display:none");
  $(".block_float_div").mouseover(function(){
	  $(this).css("background-color", "#FFFF99");
  });
  $(".block_float_div").mouseout(function(){
	  $(this).css("background-color", "#FFFF66");
  });
  $(".block_float_div").click(function(){
	  $('.jqmWindow').show();
      block_iframe.location = admin_url+'?mod=phpcms&file=block&action=update&ajax=1&blockid='+$(this).attr('blockid');
      $('#blockname').html('修改碎片['+$(this).attr('blockname')+']');
  });
  $(".block_float_div").each(function(i){
	var blockid = $(this).attr("blockid");
	var id = "#block_"+blockid;
	var width = $(id).width();
	var height = $(id).height();
	if(height < 16) height = 16;
	var pos = $(id).offset();
	var padding_l = $(id).css("padding-left");
	var padding_r = $(id).css("padding-right");
	var padding_t = $(id).css("padding-top");
	var padding_b = $(id).css("padding-buttom");
	$(this).css("top", pos.top+"px");
	$(this).css("left", pos.left+"px");
	$(this).width(width);
	$(this).height(height);
	if(padding_l != 'undefined') $(this).css("padding-left", padding_l);
	if(padding_r != 'undefined') $(this).css("padding-right", padding_r);
	if(padding_t != 'undefined') $(this).css("padding-top", padding_t);
	if(padding_b != 'undefined') $(this).css("padding-buttom", padding_b);
	$(this).show();
  }); 
}

function set_tag_float_div()
{
  $(".tag_float_div").attr("style", "position:absolute;z-index:100;border:#cccccc solid 1px;background-color:#99FFFF;filter:Alpha(opacity=30);-moz-opacity:0.3;-khtml-opacity:0.3;opacity:0.3;cursor:pointer;display:none");
  $(".tag_float_div").mouseover(function(){
	  $(this).css("background-color", "#EEFFFF");
  });
  $(".tag_float_div").mouseout(function(){
	  $(this).css("background-color", "#99FFFF");
  });
  $(".tag_float_div").click(function(){
	  $('.jqmWindow').show();
      block_iframe.location = admin_url+'?mod='+$(this).attr('module')+'&file=tag&action=edit&ajax=1&tagname='+$(this).attr('tagname');
      $('#blockname').html('修改标签['+$(this).attr('tagname')+']');
  });
  $(".tag_float_div").each(function(i){
	var tagname = $(this).attr("tagname");
	var id = "#tag_"+tagname;
	var width = $(id).width();
	var height = $(id).height();
	if(height < 16) height = 16; 
	var pos = $(id).offset();
	var padding_l = $(id).css("padding-left");
	var padding_r = $(id).css("padding-right");
	var padding_t = $(id).css("padding-top");
	var padding_b = $(id).css("padding-buttom");
	$(this).css("top", pos.top+"px");
	$(this).css("left", pos.left+"px");
	$(this).width(width);
	$(this).height(height);
	if(padding_l != 'undefined') $(this).css("padding-left", padding_l);
	if(padding_r != 'undefined') $(this).css("padding-right", padding_r);
	if(padding_t != 'undefined') $(this).css("padding-top", padding_t);
	if(padding_b != 'undefined') $(this).css("padding-buttom", padding_b);
	$(this).show();
  }); 
}

function add_block(blockid, blockname, pageid, blockno)
{
	$('#block_add_'+pageid+'_'+blockno).before('<div id="block_'+blockid+'"></div><div id="float_div_'+blockid+'" class="block_float_div jqModal" style="display:none" blockid="'+blockid+'" blockname="'+blockname+'" title="点击修改碎片"></div>');
	set_block_float_div();
}

function set_html(blockid, data)
{
	$('#block_'+blockid).html(data);
    set_block_float_div();
	return true;
}

function get_html(blockid)
{
	$('#block_'+blockid).html(data);
	return true;
}

function close_window()
{
	$("#block_iframe").attr('src', 'fckeditor/index.html');
	$(".jqmWindow").hide();
}

function tag_preview(tagname, data)
{
	$('#tag_'+tagname).html(data);
    set_tag_float_div();
	set_block_float_div();
	return true;
}

function tag_save(tagname, data)
{
	$('#tag_'+tagname).html(data);
    set_tag_float_div();
	set_block_float_div();
	close_window();
	return true;
}

function parent_file_list(obj)
{
	block_iframe.parent_file_list(obj);
}