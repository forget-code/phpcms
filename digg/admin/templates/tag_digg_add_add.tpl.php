<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<script type="text/javascript">
function InitAjax()
{
　var ajax=false;
　try {
　　ajax = new ActiveXObject("Msxml2.XMLHTTP");
　} catch (e) {
　　try {
　　　ajax = new ActiveXObject("Microsoft.XMLHTTP");
　　} catch (E) {
　　　ajax = false;
　　}
　}
　if (!ajax && typeof XMLHttpRequest!='undefined') {
　　ajax = new XMLHttpRequest();
　}
　return ajax;
}
//点击操作函数
function showimage(id,url)
{
  var url =url+"show_images.php?id="+id;
	var show = document.getElementById('style_digg');
　var ajax = InitAjax();
　ajax.open("GET", url, true);
　ajax.onreadystatechange = function() {
　　if (ajax.readyState == 4 && ajax.status == 200) {
　　　show.innerHTML = ajax.responseText;
　　}
　}
　ajax.send(null);
}

   / -->
</script>

<form name="myform" method="get" action="?">
     <input name="mod" type="hidden" value="<?=$mod?>">
   <input name="file" type="hidden" value="<?=$file?>">
   <input name="action" type="hidden" value="<?=$action?>">
   <input name="keyid" type="hidden" value="<?=$keyid?>">
   <input name="job" type="hidden" value="<?=$job?>">
   <input name="function" type="hidden" value="<?=$function?>">
   <input name="tag_config[func]" type="hidden" value="<?=$function?>">
   <input name="forward" type="hidden" value="<?=$forward?>">
   <input name="referer" type="hidden" value="<?=$forward?>">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1"  class="tableborder">
    <tr>
     <th height="25" colspan="2"><strong>digg点击标签添加</strong></th>
    </tr>
    <tr bgcolor="#F1F3F5">
      <td width="33%" height="25" ><span class="tablerow"><strong>标签名称</strong>*<br />
        可用中文，不得包含特殊字符 ' &quot; $ { } ( ) \ / ,</span></td>
      <td width="67%" height="25" ><input name="tagname" id="tagname" type="text" size="20" value="<?=$tagname?>" />
      <input name="button3" type="button" onclick="Dialog('?mod=<?=$mod?>&amp;file=tag&amp;action=checkname&amp;channelid=<?=$channelid?>&amp;tagname='+$('tagname').value+'','','300','40','no')" value=" 检查是否已经存在 " /></td>
    </tr>
    <tr bgcolor="#F1F3F5">
      <td height="25" ><strong>标签说明</strong></td>
      <td width="67%" height="25" ><span class="tablerow">
        <input name="tag_config[introduce]" type="text" id="tag_config[introduce]" value="<?=$tag_config['introduce']?>" size="50" />
      </span></td>
    </tr>
    <tr bgcolor="#E4EDF9">
      <td height="25" colspan="2" ><div align="center"><strong>标签参数设置</strong></div>
          <div align="center"></div></td>
    </tr>
    <tr bgcolor="#F1F3F5">
      <td height="25" ><strong>是否启用DIGG</strong></td>
      <td height="25" ><span class="tablerow">启用
          <input name="tag_config[digg_on]" type="radio" value="1" <?php if ($digg_on==1 || !$digg_on) {?>checked="checked"<?php }?> />
禁用
<input type="radio" name="tag_config[digg_on]" value="0"  <?php if ($digg_on==0 && $digg_on) {?>checked="checked"<?php }?>/>
      </span></td>
    </tr>
    <tr bgcolor="#F1F3F5">
      <td height="25" ><strong>是否使用"踩一下"</strong></td>
      <td height="25" ><span class="tablerow">启用
          <input name="tag_config[digg_down_on]" type="radio" value="1" <?php if ($digg_down_on==1 || !$digg_down_on) {?>checked="checked"<?php }?> />
禁用
<input type="radio" name="tag_config[digg_down_on]" value="0" <?php if ($digg_down_on==0 && $digg_down_on) {?>checked="checked"<?php }?> />
      </span></td>
    </tr>
    <tr bgcolor="#F1F3F5">
      <td height="25" ><strong>所属频道</strong></td>
      <td height="25" bgcolor="#F1F3F5" ><label>
          <label><span class="tablerow">
          <select name="tag_config[style]" id="style" onchange="return showimage(document.myform.style.value,'<?=$CONFIG['rootpath']?>digg/admin/');">
            <option value="1" selected="selected">样式一</option>
            <option value="2">样式二</option>
            <option value="3">样式三</option>
            <option value="4">样式四</option>
          </select>
        </span></label>
          <div id="style_digg"></div></td>
    </tr>
  </table>
  <label></label>
  <table width="100%">
    <tr>
      <td width="35%">&nbsp;</td>
      <td width="65%"><input name="dosubmit" type="submit" id="dosubmit" value="提交" />
      <label>
      <input type="reset" name="button2" id="button" value="重置" />
      </label></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="1"class="tableborder">
    <tr>
      <th colspan="7">提示信息</th>
    </tr>
    <tr bgcolor="#F1F3F5">
      <td height="20">此设置主要针对DIGG在内容中的按钮</td>
    </tr>
  </table>
</form>
