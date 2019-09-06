<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<script type="text/javascript">
function getfields(tablename)
{
    var url ="?mod=<?=$mod?>&file=<?=$file?>&action=getfields";
    var pars = "tablename="+tablename;
	var cAjax = new Ajax.Request(url, {method: 'get', parameters: pars, onComplete: setfield});
}

function setfield(Request)
{
	var text = Request.responseText;
    var fileds = text.split(",");
	enterValue(fileds, $('fromfield'));
}

function enterValue(cell,place)
{
	clearPreValue(place);
	var selectedval = cell[0];
	for(i=0; i<cell.length; i++)
	{
	    isselected = addOption(place, cell[i], cell[i]);
		if(isselected)
		{
			place.options[i].selected = true;
			selectedval = cell[i];
		}
	}
	return selectedval;
}
function addOption(objSelectNow,txt,val)
{
	var objOption = document.createElement("option");
	objOption.text = txt;
	objOption.value = val;
	objSelectNow.options.add(objOption);
	return true;
}

function clearPreValue(pc)
{
	while(pc.hasChildNodes())
	pc.removeChild(pc.childNodes[0]);
}


</script>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th>提示信息</th>
  </tr>
<tr bgColor='#F1F3F5'>
    <td>如果你是先在本地测试并录入了很多数据，并且以 http://localhost/phpcms/ 来访问，但是现在安装到 http://www.abc.com 上，发现文章里的图片都不能显示。为什么呢？这个是路径问题造成的，图片路径多了 /phpcms 。<br>怎么办呢？用替换功能可以解决这个问题，把内容和标题图片中的 /phpcms/data/uploadfile/ 替换为 /data/uploadfile/,然后更新所有的文章页即可正常显示图片。<br>另外当你进行安装目录调整，比如把原来在 http://www.abc.com/news/ 下安装的换到 http://www.abc.com/ 也可以通过替换功能来解决这个问题。<br>如果你的文章内容是UBB格式的，你可以选定字段，点UBB代码转换为HTML</td>
</tr>
</table>
<br />
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=replace&referer=<?=$referer?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>字符串替换工具</th>
  </tr>
<tr bgColor='#F1F3F5'>
<td>要替换的字段名</td>
<td>

数据表：<select name="fromtable" onchange="getfields(this.value);">
<?=$tables?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;字段名：<select name="fromfield" id='fromfield'>
</select>

</td>
  </tr>
  
<tr bgColor='#F1F3F5'>
<td>替换方式</td>
<td style="color:blue;"><input name='type' type='radio' id='type1' onClick="t1.style.display='block';t2.style.display='block';t3.style.display='none';" value='1'  <?php if($type==1) echo "checked";?> >
字符串替换
        <input name='type' id='type2' type='radio' value='2'  onClick="t1.style.display='none';t2.style.display='none';t3.style.display='none';" <?php if($type==2) echo "checked";?> >
转换为UBB
        <input name='type' id='type3' type='radio' value='3'  onClick="t1.style.display='none';t2.style.display='none';t3.style.display='block';" <?php if($type==3) echo "checked";?> >
在字段最前面追加
        <input name='type' id='type3' type='radio' value='4'  onClick="t1.style.display='none';t2.style.display='none';t3.style.display='block';" <?php if($type==4) echo "checked";?> >
在字段最后面追加</td>
</tr>
<tr bgColor='#F1F3F5' id='t1'>
<td>要替换的内容</td>
<td><textarea name="search" cols="50" rows="3"></textarea></td>
</tr>
<tr bgColor='#F1F3F5' id='t2'>
<td>替换为</td>
<td><textarea name="replace" cols="50" rows="3"></textarea></td>
</tr>
<tr bgColor='#F1F3F5' id='t3' style="display:none">
<td>追加的字符串</td>
<td><textarea name="addstr" cols="50" rows="3"></textarea></td>
</tr>
<tr bgColor='#F1F3F5'>
<td>替换条件</td>
<td><input name='condition' type='text' size='50'> <br /><br />请输入sql（AND 条件语句），注:多个条件以and连接<br />如 catid=10 ( AND hits>100 ) </td>
</tr>
<tr bgColor='#F1F3F5'>
<td> </td>
<td>
<input type="submit" name="dosubmit" value=" 开始替换 ">&nbsp;&nbsp;
</td>
</tr>
</table>
</form>
</body>
</html>