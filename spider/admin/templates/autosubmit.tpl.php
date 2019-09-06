<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
 <?
 $per = (int)($havefinished*100/$totalRecord);
 if($per ==0) $per=1;
 ?>
 <center>
 <table cellpadding="2" cellspacing="1" class="table_list">
  <caption>采集任务内容发布</caption>
  <tr>
    <td class="tablerow">
      <font color="blue">任务名称:</font><?echo $JobName;?><br>
      <font color="blue">发布栏目:</font><?echo $job_CatName;?><br>
      <font color="blue">发布进度:</font>已处理<?echo $per?>%(<?echo $havefinished?>/<?echo $totalRecord?>篇,发布成功<?echo $publistedNum?>篇)<br>
    </td>
  </tr>
  <tr>
    <td align=center>
	 <table cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" style="border:1px #9900FF solid" width="100%">
	 <tr>
		<td width="<?echo $per?>%" height="35" bgcolor="#669900"><center>已完成<?echo $per?>%</center></td>
		<td  bgcolor="#CCCCCC"></td>
	 </tr>
	 </table>
	</td>
  </tr>
</table>
 </center>
 <form name="myform" action="?mod=spider&file=collect&action=spideradd&jobid=<?echo $jobid?>&autosubmit=1&havefinished=<?echo $havefinished?>&totalRecord=<?echo $totalRecord?>&publistedNum=<?echo $publistedNum?>&submit=1" method=post>
 <?
 foreach($_POST as $key => $sub)
 {
	if($key=='submit')continue;
	if(is_array($sub))
	{
		foreach($sub as $skey => $val)
		{
			echo "<input type='hidden' name='".$key."[".$skey."]' value='".$val."'>\n\r";
		}
	}else
	{
			echo "<input type='hidden' name='".$key."' value='".$sub."'>\n\r";
	}
 ?>
 <?
 }
 ?>
 <br />
 <input type='submit' name="dosubmit" value="如果不能自动发布，请点击这里继续发布" style="display:none">
 </form>
 </body>
<script>   
setTimeout('document.myform.submit();',1000);//1秒后自动提交   
</script>