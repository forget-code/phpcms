<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=replace&referer=<?=$referer?>">
  <table cellpadding="0" cellspacing="1" class="table_form">
    <caption>
    字符串替换工具
    </caption>
    <tbody>
    <tr>
      <th style="width:20%;"><strong>要替换的字段名</strong></th>
      <td> 数据表：
        <select name="fromtable" id='fromfield'>
          <?=$tables?>
        </select>
        &nbsp;&nbsp;&nbsp;&nbsp;字段名：
        <select name="fromfield1" id="fromfield1">
        </select>
      </td>
    </tr>
    <tr>
      <th><strong>替换方式</strong></th>
      <td style="color:blue;"><input name='type' type='radio' id='type1' onClick="$('#t1').css({display:''});$('#t2').css({display:''});$('#t3').css({display:'none'})" value='1'  <?php if($type==1) echo "checked";?> >
        字符串替换
        <input name='type' id='type2' type='radio' value='2'  onClick="$('#t1').css({display:'none'});$('#t2').css({display:'none'});$('#t3').css({display:'none'});" <?php if($type==2) echo "checked";?> >
        转换为UBB
        <input name='type' id='type3' type='radio' value='3'  onClick="$('#t1').css({display:'none'});$('#t2').css({display:'none'});$('#t3').css({display:''});" <?php if($type==3) echo "checked";?> >
        在字段最前面追加
        <input name='type' id='type3' type='radio' value='4'  onClick="$('#t1').css({display:'none'});$('#t2').css({display:'none'});$('#t3').css({display:''});" <?php if($type==4) echo "checked";?> >
        在字段最后面追加</td>
    </tr>
    </tbody>
    <tbody id='t1'>
    <tr>
      <th><strong>要替换的内容</strong></th>
      <td><textarea name="search" cols="50" rows="3"></textarea></td>
    </tr>
    </tbody>
    <tbody id='t2'>
    <tr>
      <th><strong>替换为</strong></td>
      <td><textarea name="replace" cols="50" rows="3"></textarea></td>
    </tr>
    </tbody>
    <tbody id='t3' style="display:none">
    <tr>
      <th><strong>追加的字符串</strong></th>
      <td><textarea name="addstr" cols="50" rows="3"></textarea></td>
    </tr>
    </tbody>
    <tbody>
    <tr>
      <th><strong>替换条件</strong></th>
      <td><input name='condition' type='text' size='50'>
        <br /><br />
        请输入sql（AND 条件语句），注:多个条件以and连接<br />
        如 catid=10 AND username='name' AND hits>100 </td>
    </tr>
    </tbody>
    <tbody>
    <tr>
      <td></td>
      <td><input type="submit" name="dosubmit" value=" 开始替换 ">
        &nbsp;&nbsp; </td>
    </tr>
    </tbody>
  </table>
</form>
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>
  提示信息
  </caption>
  <tr>
    <td>如果你是先在本地测试并录入了很多数据，并且以 http://localhost/phpcms/ 来访问，但是现在安装到 http://www.abc.com 上，发现文章里的图片都不能显示。为什么呢？这个是路径问题造成的，图片路径多了 /phpcms 。<br>
      怎么办呢？用替换功能可以解决这个问题，把内容和标题图片中的 /phpcms/data/uploadfile/ 替换为 /data/uploadfile/,然后更新所有的文章页即可正常显示图片。<br>
      另外当你进行安装目录调整，比如把原来在 http://www.abc.com/news/ 下安装的换到 http://www.abc.com/ 也可以通过替换功能来解决这个问题。<br>
      如果你的文章内容是UBB格式的，你可以选定字段，点UBB代码转换为HTML</td>
  </tr>
</table>
<script type="text/javascript">
function getfields(tablenamee)
{
	$('#fromfield1').load("?mod=<?=$mod?>&file=<?=$file?>&action=replace&job=getfields&tablename="+tablenamee);
}

$('#fromfield').change(function(){getfields($('#fromfield').val())});
getfields($('#fromfield').val());

</script>
</body>
</html>