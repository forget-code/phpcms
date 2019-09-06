<?php include admintpl('header'); ?>

<?php echo $menu; ?>

<form id="formgetmails" name="formgetmails" method="post" action="?mod=<?php echo $mod; ?>&file=mail&action=config&submit=1">

  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="tableborder">
    <tr>
      <th colspan="2">获取列表</th>
    </tr>
    <tr>
      <td class="tablerowhighlight" colspan="2" align="center"><b>外部数据提取参数配置</b></td>
    </tr>
    <tr>
      <td width="30%" class="tablerow"><b>数据库来源</b><font color="red">*</font></td>
      <td width="70%"  class="tablerow">
	  <input type="radio" name="newdata[dbfrom]" value="1" <?php if(!$data['dbfrom'] || $data['dbfrom']==1) echo 'checked="checked"'; ?> onclick="javascript:db.style.display='none'" />当前系统数据库
	  <input type="radio" name="newdata[dbfrom]" value="2" <?php if($data['dbfrom']==2) echo 'checked="checked"'; ?> onclick="javascript:db.style.display='block'" />其他数据库	  </td>
    </tr>
    <tbody style="display:<?php if(!$data['dbfrom'] || $data['dbfrom']==1){ ?>none<?php } ?>" id="db">
      <tr>
        <td class="tablerow"><b>数据库系统类型</b><font color="red">*</font></td>
        <td  class="tablerow">
		<input type="radio" name="newdata[database]" value="mysql" <?php if(!$data['database'] || $data['database']=='mysql') echo 'checked="checked"'; ?> />MYSQL
		<input type="radio" name="newdata[database]" value="mssql" <?php if($data['database']=='mssql') echo 'checked="checked"';?> />MSSQL		</td>
      </tr>
      <tr>
        <td class="tablerow"><b>数据库主机地址</b><font color="red">*</font><br />
          你的数据库所在的主机地址，一般为localhost</td>
        <td  class="tablerow">
		<input name="newdata[dbhost]" type="text" size="20" value="<?php if($data['dbhost']) echo $data['dbhost']; else echo 'localhost'; ?>" /></td>
      </tr>
      <tr>
        <td class="tablerow"><b>数据库用户名</b><font color="red">*</font><br />
          MYSQL数据库帐号</td>
        <td class="tablerow">
		<input name="newdata[dbuser]" type="text" size="20" value="<?php echo $data['dbuser']; ?>" />		</td>
      </tr>
      <tr>
        <td class="tablerow"><b>数据库密码</b><font color="red">*</font><br />
          MYSQL数据库密码</td>
        <td class="tablerow">
		<input name="newdata[dbpw]" type="password" size="20" value="<?php echo $data['dbpw']; ?>" />		</td>
      </tr>
      <tr>
        <td class="tablerow"><b>数据库名称</b><font color="red">*</font><br />
          MYSQL数据库名称</td>
        <td class="tablerow">
		<input name="newdata[dbname]" type="text" size="20" value="<?php echo $data['dbname']; ?>" />		</td>
      </tr>
    </tbody>
    <tr>
      <td class="tablerow"><b>数据表</b><font color="red">*</font><br />
        源数据表名称</td>
      <td  class="tablerow">
	  <input name="newdata[table]" type="text" size="30" value="<?php echo $data['table']; ?>" /></td>
    </tr>
    <tr>
      <td class="tablerow"><b>电子邮件字段</b><font color="red">*</font><br />
        源数据表中对应于电子邮件的字段</td>
      <td  class="tablerow">
	  <input name="newdata[field]" type="text" id="newdata[field]" value="<?php echo $data['field']; ?>" size="20" /></td>
    </tr>
	<tr>
	  <td class="tablerow"><strong>获取条件（SQL语句）</strong><br />
      可以不填写</td>
	  <td class="tablerow"><input name="newdata[condition]" type="text" id="newdata[condition]" value="<?php echo $data['condition']; ?>" size="40" /></td>
    </tr>
	<tr>
      <td class="tablerow"><strong>保存邮件列表的文件名</strong><font color="red">*</font><br />
      只能是英文，字母，下划线组成</td>
      <td class="tablerow">
	  <input name="newdata[file]" type="text" value="<?php if($data['file']) echo $data['file']; else echo date('Ymd'); ?>" size="20" />
	  .txt</td>
	</tr>
	<tr>
      <td class="tablerowhighlight" colspan="2" align="center"><b>数据提取导入执行设置</b></td>
    </tr>
	
	<tr>
      <td class="tablerow"><b>每次提取并导入数据条数</b><br />
        如果数据较多可分步提取导入</td>
	  <td class="tablerow">
	  <input name="newdata[number]" type="text" size="5" value="<?php if($data['number']) echo $data['number']; else echo 1000; ?>" />条
	  </td>
    </tr>
	<tr>
      <td class="tablerow"><b>php脚本执行超时时限</b><br />
        当数据较多时程序执行时间会较长</td>
	  <td class="tablerow">
	  <input name="newdata[timelimit]" type="text" size="5" value="<?php if($data['timelimit']) echo $data['timelimit']; else echo 60; ?>" />秒
	  </td>
    </tr>
	<tr>
      <td class="tablerow"></td>
      <td class="tablerow">
	  <input name="submit" type="submit" id="submit" value=" 获取并保存 " />
	  <input name="reset" type="reset" id="reset" value=" 重新填写 " /> 
	  <input name="importtype" type="hidden" value="database" />	  </td>
    </tr>
  </table>
</form>

</body>
</html>