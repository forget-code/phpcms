/** JavaScript Document
 *  Powered by phpcms
 *  author Robertvvv
**/
var userid;
var data = new Array();
function block(apiid, apiurl, userid)
{
	var blockid = '#block_' + apiid;
	var block_pic_id = '#block_pic_' + apiid;
	var block_words_id = '#block_words_' + apiid;
	var more_url = '#more_url_' + apiid;
	$.ajax({
		   url:apiurl,
		   data:{userid: userid},
		   dataType:'json',
		   beforeSend:function(){$(block_pic_id).html("<img src='images/loading.gif' />   Loading....")},
		   error:function(){$(blockid).hide();},
		   success:function(data) {
			var block_html = '';
			if(data.moreurl)
			{
				$(more_url).attr({href:data.moreurl});
			}
			if(data.pics)
			{
				if(typeof(data.words) == 'undefined')
				{
					$(block_pic_id).css({width:"100%"});
				}
				var pic_ul = '<ul>';
				if(data.cls_pic)
				{
					$(block_pic_id).addClass(data.piccls);
				}
				if(data.pics)
				{
					$.each(data.pics, function(i, n){ 
							pic_ul += '<li>';
							pic_ul += (n.title) ? "<a href='" + n.url + "'><img src='" + n.thumb + "' alt= '" + n.title + "' /></a><br /><a href='" + n.url + "'>" + n.title + "</a>": '';	
							pic_ul += '</li>';
						});
				}
				pic_ul += '</ul>';
				$(block_pic_id).html(pic_ul);
			}
			else
			{
				$(block_pic_id).toggle();
			}
			
			if(data.words)
			{
				var words_ul = '<ul>';
				if(typeof(data.pics) == 'undefined')
				{
					$(block_words_id).css({width:"100%"});
				}
				if(data.cls_words)
				{
					$(block_words_id).addClass(data.cls_words);
					
				}
				$.each(data.words, function(i, n){
					words_ul += '<li>';
					words_ul += (n.date) ? "<span class='date'> " + n.date + "</span>" : '';
					words_ul += (n.writer) ? n.writer : '';
					words_ul += (n.title) ? "<a href='" + n.url + "'>" + n.title + "</a>" : '';
					words_ul += '</li>';
				});
				words_ul += '</ul>';
				$(block_words_id).html(words_ul);
			}
			else
			{
				$(block_words_id).toggle();
			}
		}
	});
}