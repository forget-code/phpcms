function change_f_catid(catid)
{
	if(catid)
	{
		$('#secondcatid').empty();
		$('#thirdcatid').empty();
		$.get(phpcms_path+'yp/load.php?action=cat_option&catid='+catid, function(data){
			if(data==1)
			{
				$('#hava_checked').val('1');
			}
			else
			{
				$('#secondcatid').append(data);
				$('#hava_checked').val('0');
			}
		});
		$("#catid").addClass('category_no_select');
		$("#thirdcatid").addClass('category_no_select');
	}
}

function change_s_catid(catid)
{
	if(catid)
	{
		$('#thirdcatid').empty();
		$.get(phpcms_path+'yp/load.php?action=cat_option&catid='+catid, function(data){
			if(data==1)
			{
				$('#hava_checked').val('1');
			}
			else
			{
				$('#thirdcatid').append(data);
				$('#hava_checked').val('0');
			}
		});
		$("#secondcatid").addClass('category_no_select');
	}
}
function change_t_catid(catid)
{
	$('#hava_checked').val('1');
}
var upLoading = true;
function YP_checkform()
{
	var catid = $('#catid').val();
	if(catid==null)
	{
		alert('请选择产品所属分类');
		$('#catid').focus();
		$("#catid").addClass('category_select');
		return false;
	}
	else
	{
		var secondcatid = $('#secondcatid').val();
		if(secondcatid==null)
		{
			$.get(phpcms_path+'yp/load.php?action=catid_select&catid='+catid, function(data){
				if(data == '1')
				{
					alert('请选择二级分类');
					$('#secondcatid').focus();
					$("#secondcatid").addClass('category_select');
					return false;
				}
				else
				{
					$('#hava_checked').val('1');
					$('form').submit();
				}
			});
		}
		else
		{
			var thirdcatid = $('#thirdcatid').val();
			if(thirdcatid==null)
			{
				$.get(phpcms_path+'yp/load.php?action=catid_select&catid='+secondcatid, function(data){
					if(data == '1')
					{
						alert('请选择三级分类');
						$('#thirdcatid').focus();
						$("#thirdcatid").addClass('category_select');
						return false;
					}
					else
					{
						$('#hava_checked').val('1');
						$('form').submit();
					}
				});
			}
			else
			{
				$('#hava_checked').val('1');
				$('form').submit();
			}
		}

	}
}

function check_catid(catid)
{
	$.get(phpcms_path+'yp/load.php?action=catid_select&catid='+catid, function(data){
	if(data == '1')
	{
		alert('该分类含有子分类，请选择下级子分类');
		$('#catid').val('0');
		return false;
	}
});
}