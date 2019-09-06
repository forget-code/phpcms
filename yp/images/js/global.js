function favorite(title,url,id)
{
	url = phpcms_path+'yp/load.php?action=collect_favorite&title='+title+"&url="+url);
	location.href = url;
}