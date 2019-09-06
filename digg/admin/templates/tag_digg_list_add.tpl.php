<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>

<?=$menu?>
<script type="text/javascript">
    <!--
    function showcat(keyid,catid)
{
    var url = "<?=$PHP_SELF?>";
    var pars = "mod=phpcms&file=tag&action=category_select&catid="+catid+"&keyid="+keyid;
	var myAjax = new Ajax.Updater(
					'category_select',
					url,
					{
					method: 'get',
					parameters: pars
					}
	             );
				 pars = "mod=phpcms&file=tag&action=specialid_select&catid="+catid+"&keyid="+keyid;
	var tags = new Ajax.Updater(
	'selectspecialid',
		url,
		{
	method: 'get',
	parameters: pars
		}
	);
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1"  class="tableborder">
  <tr>
    <th height="25" colspan="2"><strong>digg列表标签设置</strong></th>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td width="40%" height="25" ><span class="tablerow"><strong>标签名称</strong>*<br />
可用中文，不得包含特殊字符 ' &quot; $ { } ( ) \ / ,</span></td>
    <td width="67%" height="25" ><input name="tagname" id="tagname" type="text" size="20" />
      <input name="button" type="button" onclick="Dialog('?mod=<?=$mod?>&amp;file=tag&amp;action=checkname&amp;channelid=<?=$channelid?>&amp;tagname='+$('tagname').value+'','','300','40','no')" value=" 检查是否已经存在 " /></td>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>标签说明</strong></td>
    <td width="67%" height="25" ><span class="tablerow">
      <input name="tag_config[introduce]" type="text" id="tag_config[introduce]" size="50" />
    </span></td>
  </tr>
  <tr bgcolor="#E4EDF9">
    <td height="25" colspan="2" ><div align="center"><strong>标签参数设置</strong></div>      <div align="center"></div></td>
    </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>是否分页显示</strong></td>
    <td height="25" >是
      <label>
      <input name="tag_config[page_on]" type="radio" id="page_on" value="1" />
      </label>
      否
      <label>
      <input name="tag_config[page_on]" type="radio" id="page_on" value="0" checked="checked" />
      </label></td>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>调用文章数或每页文章数</strong></td>
    <td height="25" ><input name="tag_config[list_num]" type="text" id="list_num" value="10" size="10" /></td>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>文章标题最大字符数</strong></td>
    <td height="25" ><input name="tag_config[title_text]" type="text" id="title_text" value="25" size="10" /></td>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>内容摘要最大字符数</strong></td>
    <td height="25" ><input name="tag_config[text_num]" type="text" id="text_num" value="0" size="10" /></td>
  </tr>

<tr bgcolor="#F1F3F5">
    <td height="25" ><strong>是否在首页显示</strong></td>
    <td height="25" >是
      <label>
      <input type="radio" name="tag_config[index_on]" id="index_on" value="1" <?php if ($tag_config[index_on]==1){?> checked="checked" <?php }?> />
      </label>
否
<label>
<input type="radio" name="tag_config[index_on]" id="index_on" value="0" <?php if ($tag_config[index_on]==0){?> checked="checked" <?php }?> />
【如果选择不限制栏目，请关闭此项！】</label></td>
  </tr>

  <tr>
      <td height="25" bgcolor="#F1F3F5" class="tablerow"><b>调用文章所属频道ID</b><br />
        <font color="blue">0表示不限频道</font></td>
      <td height="25" bgcolor="#F1F3F5"  class="tablerow"><input name="tag_config[digg_channelid]" id="setchannelid" type="text" size="15" value="0">
        <select name='selectchannelid' onChange="$('setchannelid').value=this.value;showcat(this.value, 0)">

         <option value='0' selected="selected">不限频道</option>
        <?php
        foreach($CHANNEL as $id=>$channel)
        {
            //if($channel['islink'] || $channel['module'] != $mod) continue;
            $selected = $id == $channelid ? "selected" : "";
        ?>
        <option value='<?=$id?>' <?=$selected?>><?=$channel['channelname']?></option>
        <?php
        }
        ?>
        </select>
      【注:当使用总列表的时候选择&quot;不限频道&quot;】 </td>
  </tr>

    <tr>
      <td height="25" bgcolor="#F1F3F5" class="tablerow"><b>调用文章所属栏目ID</b><br>
      <font color="blue">0表示不限栏目</font><br></td>
      <td height="25" bgcolor="#F1F3F5"  class="tablerow">
	<input name="tag_config[digg_catid]" type="text" size="15"  id="catid" value="0">
	<span id="category_select">
	<select name='selectcatid' onChange="ChangeInput(this,document.myform.catid)">
	<option value="0">不限栏目</option>
    </select>
    </span>
	&nbsp;【注:当使用总列表的时候选择&quot;不限栏目&quot;】 </td>
	</tr>

    <tr>
      <td height="25" bgcolor="#F1F3F5" class="tablerow"><b>多少天以内的排行</b></td>
      <td height="25" bgcolor="#F1F3F5"  class="tablerow"><input name="tag_config[digg_defind]" type="text" size="10" value="0" id="datenum"> 天&nbsp;&nbsp;&nbsp;&nbsp;
<select name="selectdatenum" onchange="$('datenum').value=this.value">
<option value="0">不限天数</option>
<option value="1">1天以内</option>
<option value="3">3天以内</option>
<option value="7">一周以内</option>
<option value="14">两周以内</option>
<option value="30">一个月内</option>
<option value="60">两个月内</option>
<option value="90">三个月内</option>
<option value="180">半年以内</option>
<option value="365">一年以内</option>
</select>
您可以从下拉框中选择</td>
    </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>是否显示评论数</strong></td>
    <td height="25" bgcolor="#F1F3F5" >是
      <label>
      <input name="tag_config[comment_on]" type="radio" id="" value="1" />
      </label>
否
<label>
<input name="tag_config[comment_on]" type="radio" id="" value="0" checked="checked" />
<span class="tablerow">【注:开启后略微消耗系统资源】 </span></label></td>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="25" ><strong>是否显示点击数</strong></td>
    <td height="25" bgcolor="#F1F3F5" >是
      <label>
      <input name="tag_config[hits_on]" type="radio" id="" value="1" />
      </label>
否
<label>
<input name="tag_config[hits_on]" type="radio" id="" value="0" checked="checked" />
<span class="tablerow">【注:开启后略微消耗系统资源】 </span></label></td>
  </tr>
      <tr>
      <td width="40%" height="25" bgcolor="#F1F3F5" class="tablerow"><b>此标签调用的模板</b></td>
      <td height="25" bgcolor="#F1F3F5"  class="tablerow">
<?=showtpl($mod,'tag_digg_list','tag_config[templateid]','','id=templateid')?>
&nbsp;&nbsp;
<input type="button" name="edittpl" value="修改选择的模板" onclick="window.location='?mod=phpcms&file=template&action=edit&templateid='+myform.templateid.value+'&module=digg&forward=<?=urlencode($PHP_URL)?>'"> 【注:只能修改非默认模板】      </td>
    </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="5">
  <tr>
    <td width="30%">&nbsp;</td>
    <td width="70%"><label>
      <input name="dosubmit" type="submit" id="dosubmit" value="提交" />
      <input type="reset" name="Submit2" value="重置" />
    </label></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1"class="tableborder">
  <tr>
    <th colspan="7">提示信息</th>
  </tr>
  <tr bgcolor="#F1F3F5">
    <td height="20">在此可以设置不同频道中的DIGG排行标签。</td>
  </tr>
</table>
</form>
