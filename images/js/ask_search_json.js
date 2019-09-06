$().ready(
function(){
	$('#asktitle').keyup(
		function(){
			var value = $("#asktitle").val();
			if (value.length > 1)
			{
				$.getJSON(modurl+'search_ajax.php', {q: value}, function(data){
					if (data != null)
					{
						var str = '';
						$.each(data, function(i,n){
							str += '<li><a href="'+n.url+'">'+n.title+'</a></li>';
						});
						$('#tl').html(str);
						$('#search_div').show();
					}
					else
					{
						$('#search_div').hide();
					}
				});
			}
			else
			{
				$('#search_div').hide();
			}
		}
	);

	$('#asktitle').blur(function(){setTimeout("hide_search_div()", 1000);});
}
)

function hide_search_div()
{
	$('#search_div').hide();
}