<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=4>外部数据导入配置</th>
  </tr>
  <form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>&channelid=<?=$channelid?>">
   <input name="setting[importtime]" type="hidden" <?php if(isset($setting['importtime'])){ ?> value="<?=$setting['importtime']?>" <?php } ?>>
	<tr> 
      <td class="tablerow" width="40%"><b>配置名称</b><font color="red">*</font><br>只能由小写字母和数字组成</td>
      <td colspan=3 class="tablerow"><input name="setting[name]" type="text" size="20" value="<?=$setting['name']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>配置说明</b><br>可用中文</td>
      <td colspan=3 class="tablerow"><input name="setting[note]" type="text" size="50" value="<?=$setting['note']?>"></td>
    </tr>
    <tr> 
	<th colspan=4>数据库配置</th>
    </tr>

    <tr> 
      <td class="tablerow"  width="40%"><b>数据库来源</b><font color="red">*</font></td>
      <td colspan=3 class="tablerow"><input type="radio" name="setting[dbfrom]" value="0" <? if(!$setting['dbfrom']) { ?>checked<? } ?> onclick="javascript:db.style.display='none'">当前系统数据库&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[dbfrom]" value="1" <? if($setting['dbfrom']) { ?>checked<? } ?> onclick="javascript:db.style.display=''">其他数据库</td>
    </tr>
    <TBODY style="display:'<? if(!$setting['dbfrom']) { ?>none<? } ?>'" id="db">
    <tr> 
      <td class="tablerow" width="40%"><b>数据库系统类型</b><font color="red">*</font></td>
      <td  colspan=3 class="tablerow"><input type="radio" name="setting[database]" value="mysql" <? if($setting['database']=='mysql') { ?>checked<? } ?> onclick="$('help_dbhost').innerHTML = ''">MYSQL&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[database]" value="mssql" <? if($setting['database']=='mssql') { ?>checked<? } ?> onclick="$('help_dbhost').innerHTML = ''">MSSQL&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="setting[database]" value="access" <? if($setting['database']=='access') { ?>checked<? } ?> onclick="$('help_dbhost').innerHTML = '<font color=red>请填写Access数据库物理路径</font>' ">ACCESS</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>数据库主机地址</b><font color="red">*</font><br>你的数据库所在的主机地址，一般为localhost</td>
      <td colspan=3 class="tablerow"><input name="setting[dbhost]" type="text" size="30" value="<?=$setting['dbhost']?>">
	  <span id='help_dbhost'> <?php if($setting['database']=='access') { ?><font color=red>请填写Access数据库物理路径</font><?php } ?></span>
	  </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>数据库用户名</b><font color="red">*</font><br>数据库帐号</td>
      <td  colspan=3 class="tablerow"><input name="setting[dbuser]" type="text" size="20" value="<?=$setting['dbuser']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>数据库密码</b><font color="red">*</font><br>数据库密码</td>
      <td  colspan=3 class="tablerow"><input name="setting[dbpw]" type="password" size="20" value="<?=$setting['dbpw']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>数据库名称</b><font color="red">*</font><br>数据库名称（Access数据库不需要填写此项）</td>
      <td  colspan=3 class="tablerow"><input name="setting[dbname]" type="text" size="20" value="<?=$setting['dbname']?>"></td>
    </tr>
    </TBODY>
    <tr> 
      <td class="tablerow" width="40%"><b>数据表</b><font color="red">*</font><br>源数据表名称</td>
      <td  colspan=3 class="tablerow"><input name="setting[table]" type="text" size="30" value="<?=$setting['table']?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>提取字段</b></td>
      <td  colspan=3 class="tablerow"><input name="setting[selectfield]" type="text" size="50" value="<?=$setting['selectfield']?>"> 请填写SQL语句</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>数据提取条件</b></td>
      <td  colspan=3 class="tablerow"><input name="setting[condition]" type="text" size="50" value="<?=$setting['condition']?>"> 请填写SQL语句</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>上次导入的最大ID($maxid)</b></td>
      <td  colspan=3 class="tablerow"><input name="setting[maxid]" type="text" size="10" <?php if(isset($setting['maxid'])){ ?> value="<?=$setting['maxid']?>" <?php } ?>> 系统将自动获得上次导入的最大ID，下次将只导入ID大于此值的数据</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>是否使用原数据ID</b></td>
      <td  colspan=3 class="tablerow">
	  <input name="setting[isuseoldid]" type="radio" value="1" <?php if(isset($setting['isuseoldid']) && $setting['isuseoldid'] == 1){ ?>checked<?php } ?>> 是
	  <input name="setting[isuseoldid]" type="radio" value="0" <?php if(!isset($setting['isuseoldid']) || $setting['isuseoldid'] == 0){ ?>checked<?php } ?>> 否
	  </td>
    </tr>
    <tr> 
	<th colspan=4>数据表字段对应关系</th>
    </tr>

    <tr> 
      <td class="tablerowhighlight">phpcms 文章字段</td>
      <td class="tablerowhighlight">原系统文章字段</td>
      <td class="tablerowhighlight">默认值</td>
      <td class="tablerowhighlight">处理函数</td>
    </tr>
<?php 
foreach($fields as $k=>$v)
{
	if($k == 'catid' && !$setting[$k]['func']) $setting[$k]['func'] = 'get_catid';
?>
    <tr> 
      <td class="tablerow" width="40%"><b><?=$k?></b> (<?=$v?>字段)</td>
      <td class="tablerow"><input name="setting[<?=$k?>][field]" type="text" size="15" <?php if(isset($setting[$k]['field'])){?>value="<?=$setting[$k]['field']?>" <?php } ?>></td>
      <td class="tablerow"><input name="setting[<?=$k?>][value]" type="text" size="15" <?php if(isset($setting[$k]['value'])){?>value="<?=$setting[$k]['value']?>" <?php } ?>></td>
      <td class="tablerow"><input name="setting[<?=$k?>][func]" type="text" size="15" <?php if(isset($setting[$k]['func'])){?>value="<?=$setting[$k]['func']?>" <?php } ?>></td>
	</tr>
<?php 
} 
?>
    <tr> 
	<th colspan=4>栏目对应关系</th>
    </tr>
    <tr>
      <td width='300' class="tablerow" ><b>默认导入到栏目</b></td>
      <td  colspan=3 class="tablerow"><?=$category_select?></td>
    </tr>
    <tr> 
      <td class="tablerowhighlight">phpcms 文章栏目</td>
      <td colspan=3 class="tablerowhighlight">原系统栏目ID</td>
    </tr>
<?php 
foreach($CATEGORY as $catid=>$cat)
{
?>
    <tr>
      <td width='300' class="tablerow" ><?=$cat['catname']?></td>
      <td  colspan=3 class="tablerow"><input name="setting[catids][<?=$catid?>]" type="text" size="15" <?php if(isset($setting['catids'][$catid])){?>value="<?=$setting['catids'][$catid]?>" <?php } ?>> 多个ID请用逗号分隔</td>
    </tr>
<?php
}
?>
    <tr> 
      <th colspan=4>文章数据导入执行设置</th>
    </tr>
	<tr>
        <td class="tablerow"><b>是否检查同名帐号</b><br>如果选“是”，则系统会自动丢弃同名帐号</td>
        <td colspan=3 class="tablerow"> <input type="radio" name='setting[articlecheck]' value='1' <? if($setting['articlecheck']) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name='setting[articlecheck]' value='0' <? if(!$setting['articlecheck']) { ?>checked<? } ?>> 否 
        </td>
      </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>php脚本执行超时时限</b><br>当数据较多时程序执行时间会较长</td>
      <td colspan=3 class="tablerow"><input name="setting[timelimit]" type="text" size="5" value="<?=$setting['timelimit']?>"> 秒</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每次提取并导入数据条数</b><br>如果数据较多可分步提取导入</td>
      <td colspan=3 class="tablerow"><input name="setting[number]" type="text" size="5" value="<?=$setting['number']?>"> 条</td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td colspan=3 class="tablerow">
	  <input type="submit" name="dosubmit" value=" 确定 "> &nbsp; <input type="reset" name="reset" value=" 重置 "> </td>
    </tr>
  </form>
</table>
</body>
</html>