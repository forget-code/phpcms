<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body onload="myform.fromwhere.value=myform.fromwhereselect.value">
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
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=replace&channelid=<?=$channelid?>&referer=<?=$referer?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>字符替换工具</th>
  </tr>
<tr bgColor='#F1F3F5'>
<td>要替换的字段名</td>
<td>
<select name="fromwhereselect" onchange="javascript:myform.fromwhere.value=myform.fromwhereselect.value">
<?=$option?>
</select> 
<input name='fromwhere' type='text' size='15' value=''> 
 可直接选择也可以手动填写字段名
</td>
  </tr>
<tr bgColor='#F1F3F5'>
<td>要替换的内容</td>
<td><textarea name="search" cols="50" rows="3"></textarea></td>
</tr>
<tr bgColor='#F1F3F5'>
<td>替换为</td>
<td><textarea name="replace" cols="50" rows="3"></textarea></td>
</tr>
<tr bgColor='#F1F3F5'>
<td>替换条件</td>
<td><input name='condition' type='text' size='50'> 请输入sql语句，留空则替换所有!<br /><br />例如替换栏目ID为10的<?=$_CHA[channelname]?>,则可填 catid=10 [注:多个条件以and连接]</td>
</tr>
<tr bgColor='#F1F3F5'>
<td> </td>
<td>
<input type="submit" name="submit" value=" 开始替换字符 ">&nbsp;&nbsp;
<input type="submit" name="submit1" value=" UBB代码转换为HTML " onClick="document.myform.action='?mod=<?=$mod?>&file=<?=$file?>&action=ubb&channelid=<?=$channelid?>'">
</td>
</tr>
</table>
</form>
</body>
</html>