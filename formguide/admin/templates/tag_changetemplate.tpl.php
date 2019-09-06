<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>更改表单向导模板</th>
  </tr>
  <form name="myform" method="get" action="?">
   <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>" id="action">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="tagname" type="hidden" value="<?=$tagname?>">
   <input name="tag_config[formid]" type="hidden" value="<?=$formid?>">
   <input name="tag_config[func]" type="hidden" value="<?=$func?>">
   <input name="referer" type="hidden" value="<?=$PHP_REFERER?>">
    <tr> 
      <td class="tablerow" width="40%"><b>此标签调用的模板</b></td>
      <td  class="tablerow">
	<?=showtpl($mod,'tag_formguide','tag_config[templateid]',$tag_config['templateid'],'id="templateid"')?>
&nbsp;&nbsp;<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=<?=$mod?>&referer=<?=urlencode($PHP_URL)?>'"> [注:只能修改非默认模板]
      </td>
    </tr>
        <tr align="center"> 
      <td class="tablerow" colspan="2">&nbsp; </td>
    </tr>
    <tr align="center"> 
      <td class="tablerow" colspan="2">
         <input type="submit" name="dosubmit" value=" 保存 "   onclick="$('action').value='changetemplate';">   &nbsp; </td>
    </tr>
  </form>
</table>
</body>
</html>