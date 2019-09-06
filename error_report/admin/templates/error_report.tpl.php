<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
$today = date('Y-m-d',$PHP_TIME);
$end_date = date('Y-m-d',$PHP_TIME+86400);
?>
<?=$menu?>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>

<form id="form1" name="form1" method="post" action="?mod=<?=$mod?>&amp;file=<?=$file?>">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1"  class="tableborder">
    <tr>
      <th colspan="4">日期搜索</th>
    </tr>
    <tr>
      <td width="22%" height="20" colspan="2" class="tablerowhighlight">起始日期
      <?=date_select('start_date', $today, 'yyyy-mm-dd')?></td>
      <td width="24%" height="20" class="tablerowhighlight">结束日期
      <?=date_select('end_date', $end_date, 'yyyy-mm-dd')?></td>
      <td width="54%" height="20" class="tablerowhighlight"><label>
        <input type="submit" name="serch_submit" id="serch_submit" value="提交" />
      </label></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<form id="form2" name="form1" method="post" action="?mod=<?=$mod?>&amp;file=<?=$file?>&keyid=<?=$keyid?>">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1"  class="tableborder">
    <tr>
      <th colspan="2">模块搜索</th>
    </tr>
    <tr>
      <td width="32%" height="20" class="tablerowhighlight"><input name="report_keyid" id="keyid_select" type="text" size="15" value="<?=$keyid?$keyid:$report_keyid ?>">
<?=keyid_select('', '所属模块', $keyid, 'onchange="$(\'keyid_select\').value=this.value"')?></td>
      <td width="68%" height="20" class="tablerowhighlight"><label>
        <input type="submit" name="serch_submit2" id="serch_submit2" value="提交" <?php if($keyid){?>disabled="disabled"<?php }?> />
      </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?mod=<?=$mod?>&amp;file=<?=$file?>&action=clear" title="">查看所有模块</a></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<form action="?mod=<?=$mod?>&amp;file=<?=$file?>" method="post" name="myform" id="myform">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1"  class="tableborder">
 <tr>
    <th colspan="7">报错管理</th>
  </tr>
  <tr>
    <td width="3%" height="20" class="tablerowhighlight"><div align="center"></div></td>
    <td width="5%" class="tablerowhighlight"><div align="center">ID</div></td>
    <td width="30%" height="20" class="tablerowhighlight"><div align="center">标题</div></td>
    <td width="32%" height="20" class="tablerowhighlight"><div align="center">错误报告</div></td>
    <td width="17%" height="20" class="tablerowhighlight"><div align="center">时间</div></td>
    <td width="8%" height="20" class="tablerowhighlight"><div align="center">处理状态</div></td>
    <td width="5%" height="20" class="tablerowhighlight"><div align="center">操作</div></td>
  </tr>
  <?php if($error_list) foreach($error_list as $error_list){?>
  <tr align="center" onmouseout="this.style.backgroundColor='#F1F3F5'" onmouseover="this.style.backgroundColor='#BFDFFF'" bgcolor='#F1F3F5'>
    <td height="20"><div align="left">
      <input name='error_all[]' type='checkbox' value='<?=$error_list['error_id']?>' />
    </div></td>
    <td height="20"><?=$error_list['error_id']?></td>
    <td height="20" ><div align="left"><a href="<?=$error_list['error_link']?>" target="_blank">
      <?=str_cut($error_list['error_title'],32,'...')?>
    </a></div></td>
    <td height="20" >  <div align="left"><a href="?mod=<?=$mod?>&amp;file=error_text&amp;error_id=<?=$error_list['error_id']?>&keyid=<?=$keyid?$keyid:$report_keyid ?>">
      <?=str_cut($error_list['error_text'],20,'...')?>
    </a></div></td>
    <td height="20" ><div align="left">
      <?=$error_list['addtime']?>
    </div></td>
    <td >      <?php if($error_list['status']) echo '已处理'; else echo "<span class=\"STYLE1\">未处理</span>";?>     </td>
    <td height="20" ><div align="center"><a href="?mod=<?=$mod?>&amp;file=error_text&error_id=<?=$error_list['error_id']?>&keyid=<?=$keyid?$keyid:$report_keyid ?>">查看</a></div></td>
  </tr>
  <?php }?>
</table>
<table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="11%"><span class="tablerowhighlight">
      <input name='chkall' type='checkbox' id='chkall' onclick='checkall(this.form)' value='check' />
    全选/反选</span></td>
    <td width="10%"><span class="tablerowhighlight"><span class="tablerow">
      <input name="dosubmit" type="submit" id="dosubmit3" onclick="if(confirm('记录将会被删除，是否继续？')) document.myform.action='?mod=<?=$mod?>&file=error_report&action=delete'" value="删除记录"/>
    </span></span></td>
    <td width="11%"><span class="tablerowhighlight"><span class="tablerow">
      <input name="dosubmit2" type="submit" id="dosubmit2" onclick="if(confirm('记录将会被删除，是否继续？')) document.myform.action='?mod=<?=$mod?>&amp;file=error_report&action=delete_all'" value="清空所有记录"/>
    </span></span></td>
    <td width="68%"><span class="tablerowhighlight">
      <?=$pages?>
    </span></td>
  </tr>
</table>
<table width="101%" border="0" cellpadding="0" cellspacing="1" class="tableborder">
 <tr>
    <th colspan="7">调用代码</th>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td><textarea name="textarea" cols="128" rows="4"><input name="button" type="button" onclick="javascript:openwinx('{PHPCMS_PATH}error_report/error_report.php?keyid={$channelid}&report_mod={$mod}&title='+document.title+'&error_link=('+window.location.href+')','error','450','340')" value="报错" />
    </textarea></td>
  </tr>
</table>
</form>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1"class="tableborder">
 <tr>
    <th colspan="7">提示信息</th>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="20">把上面的代码复制到对应页面的模板文件中就可以使用了!</td>
  </tr>
</table>
