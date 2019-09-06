<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<?=$menu?>
<script language="javascript" type="text/javascript" src="<?=PHPCMS_PATH?>module/down/include/js/prototype.js">
</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td ></td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>外部数据导入配置</th>
  </tr>
  <form name="myform" method="post" action="?dir=plugin&file=getdata&action=<?=$action?>&channelid=<?=$channelid?>">
   <input name="newdata[gettime]" type="hidden" value="<?=$data[gettime]?>">
   <input name="type" type="hidden" value="<?=$type?>">
    <tr> 
      <td class="tablerow" width="40%"><b>配置名称</b><font color="red">*</font><br>只能由小写字母和数字组成</td>
      <td  class="tablerow"><input name="newdata[name]" type="text" size="20" value="<?=$data[name]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>配置说明</b><br>可用中文</td>
      <td  class="tablerow"><input name="newdata[introduce]" type="text" size="50" value="<?=$data[introduce]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>数据类型</b><font color="red">*</font></td>
      <td  class="tablerow"><input type="radio" name="newdata[datatype]" value="article" <? if($data[datatype]=="article") { ?>checked<? } ?> onclick="javascript:articledata1.style.display='';articledata2.style.display='';memberdata1.style.display='none';memberdata2.style.display='none'"><?=$_CHA[channelname]?>数据&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="newdata[datatype]" value="member" <? if($data[datatype]=="member") { ?>checked<? } ?> onclick="javascript:articledata1.style.display='none';articledata2.style.display='none';memberdata1.style.display='';memberdata2.style.display=''">会员数据</td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>外部数据提取参数配置</b></td>
    </tr>
    <tr> 
      <td class="tablerow"  width="40%"><b>数据库来源</b><font color="red">*</font></td>
      <td  class="tablerow"><input type="radio" name="newdata[dbfrom]" value="0" <? if(!$data[dbfrom]) { ?>checked<? } ?> onclick="javascript:db.style.display='none'">当前系统数据库&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="newdata[dbfrom]" value="1" <? if($data[dbfrom]) { ?>checked<? } ?> onclick="javascript:db.style.display=''">其他数据库</td>
    </tr>
    <TBODY style="display:'<? if(!$data[dbfrom]) { ?>none<? } ?>'" id="db">
    <tr> 
      <td class="tablerow" width="40%"><b>数据库系统类型</b><font color="red">*</font></td>
      <td  class="tablerow"><input type="radio" name="newdata[database]" value="mysql" <? if($data[database]=='mysql') { ?>checked<? } ?>>MYSQL&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="newdata[database]" value="mssql" <? if($data[database]=='mssql') { ?>checked<? } ?>>MSSQL</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>数据库主机地址</b><font color="red">*</font><br>你的数据库所在的主机地址，一般为localhost</td>
      <td  class="tablerow"><input name="newdata[dbhost]" type="text" size="20" value="<?=$data[dbhost]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>数据库用户名</b><font color="red">*</font><br>MYSQL数据库帐号</td>
      <td  class="tablerow"><input name="newdata[dbuser]" type="text" size="20" value="<?=$data[dbuser]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>数据库密码</b><font color="red">*</font><br>MYSQL数据库密码</td>
      <td  class="tablerow"><input name="newdata[dbpw]" type="password" size="20" value="<?=$data[dbpw]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>数据库名称</b><font color="red">*</font><br>MYSQL数据库名称</td>
      <td  class="tablerow"><input name="newdata[dbname]" type="text" size="20" value="<?=$data[dbname]?>"></td>
    </tr>
    </TBODY>
    <tr> 
      <td class="tablerow" width="40%"><b>数据表</b><font color="red">*</font><br>源数据表名称</td>
      <td  class="tablerow"><input name="newdata[table]" type="text" size="30" value="<?=$data[table]?>"></td>
    </tr>

    <tr> 
      <td class="tablerow" width="40%"><b>会员用户名字段</b><font color="red">*</font><br>源数据表中对应于会员用户名的字段</td>
      <td  class="tablerow"><input name="newdata[username]" type="text" size="15" value="<?=$data[username]?>"></td>
    </tr>
    <TBODY style="display:'<? if($data[datatype]!='article') { ?>none<? } ?>'" id="articledata1">
    <tr> 
      <td class="tablerow" width="40%"><b>标题字段</b><font color="red">*</font><br>源数据表中对应于标题的字段</td>
      <td  class="tablerow"><input name="newdata[title]" type="text" size="15" value="<?=$data[title]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>内容字段</b><font color="red">*</font><br>源数据表中对应于内容的字段</td>
      <td  class="tablerow"><input name="newdata[content]" type="text" size="15" value="<?=$data[content]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>作者字段</b><br>源数据表中对应于作者的字段</td>
      <td  class="tablerow"><input name="newdata[author]" type="text" size="15" value="<?=$data[author]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>发表时间字段</b></td>
      <td  class="tablerow"><input name="newdata[addtime]" type="text" size="15" value="<?=$data[addtime]?>"></td>
    </tr>
    <!--<TBODY style="display:'<? if(!$data[settype]) { ?>none<? } ?>'" id="otherset">-->
    <tr> 
      <td class="tablerow" width="40%"><b>转向链接字段</b><br>源数据表中对应于关键词的字段</td>
      <td  class="tablerow"><input name="newdata[linkurl]" type="text" size="15" value="<?=$data[linkurl]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>关键词字段</b><br>源数据表中对应于关键词的字段</td>
      <td  class="tablerow"><input name="newdata[keywords]" type="text" size="15" value="<?=$data[keywords]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>来源名称字段</b><br>源数据表中对应于来源名称的字段</td>
      <td  class="tablerow"><input name="newdata[copyfromname]" type="text" size="15" value="<?=$data[copyfromname]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>来源地址字段</b><br>源数据表中对应于来源地址的字段</td>
      <td  class="tablerow"><input name="newdata[copyfromurl]" type="text" size="15" value="<?=$data[copyfromurl]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>内容摘要字段</b><br>内容简介</td>
      <td  class="tablerow"><input name="newdata[description]" type="text" size="15" value="<?=$data[description]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>标题图片字段</b><br>将作为该文代表图片调用</td>
      <td  class="tablerow"><input name="newdata[thumb]" type="text" size="15" value="<?=$data[thumb]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>浏览次数字段</b><br><?=$_CHA[channelname]?>阅读次数</td>
      <td  class="tablerow"><input name="newdata[hits]" type="text" size="15" value="<?=$data[hits]?>"></td>
    </tr>
    <!--</TBODY>-->
    </TBODY>
    <TBODY style="display:'<? if($data[datatype]!='member') { ?>none<? } ?>'" id="memberdata1">
    <tr> 
      <td class="tablerow" width="40%"><b>密码字段</b><font color="red">*</font></td>
      <td  class="tablerow"><input name="newdata[password]" type="text" size="15" value="<?=$data[password]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>E-MAIL字段</b><font color="red">*</font></td>
      <td  class="tablerow"><input name="newdata[email]" type="text" size="15" value="<?=$data[email]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>密码提示问题字段</b></td>
      <td  class="tablerow"><input name="newdata[question]" type="text" size="15" value="<?=$data[question]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>密码提示问题答案字段</b></td>
      <td  class="tablerow"><input name="newdata[answer]" type="text" size="15" value="<?=$data[answer]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>真实姓名字段</b></td>
      <td  class="tablerow"><input name="newdata[truename]" type="text" size="15" value="<?=$data[truename]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>性别字段</b></td>
      <td  class="tablerow"><input name="newdata[gender]" type="text" size="15" value="<?=$data[gender]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>生日字段</b></td>
      <td  class="tablerow"><input name="newdata[birthday]" type="text" size="15" value="<?=$data[birthday]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>个人主页字段</b></td>
      <td  class="tablerow"><input name="newdata[homepage]" type="text" size="15" value="<?=$data[homepage]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>QQ字段</b></td>
      <td  class="tablerow"><input name="newdata[qq]" type="text" size="15" value="<?=$data[qq]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>MSN字段</b></td>
      <td  class="tablerow"><input name="newdata[msn]" type="text" size="15" value="<?=$data[msn]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>联系地址字段</b></td>
      <td  class="tablerow"><input name="newdata[address]" type="text" size="15" value="<?=$data[address]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>邮政编码字段</b></td>
      <td  class="tablerow"><input name="newdata[postid]" type="text" size="15" value="<?=$data[postid]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>联系电话字段</b></td>
      <td  class="tablerow"><input name="newdata[telephone]" type="text" size="15" value="<?=$data[telephone]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>积分字段</b></td>
      <td  class="tablerow"><input name="newdata[point]" type="text" size="15" value="<?=$data[point]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>注册IP字段</b></td>
      <td  class="tablerow"><input name="newdata[regip]" type="text" size="15" value="<?=$data[regip]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>注册时间字段</b></td>
      <td  class="tablerow"><input name="newdata[regtime]" type="text" size="15" value="<?=$data[regtime]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>最后登录IP字段</b></td>
      <td  class="tablerow"><input name="newdata[lastloginip]" type="text" size="15" value="<?=$data[lastloginip]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>最后登录时间字段</b></td>
      <td  class="tablerow"><input name="newdata[lastlogintime]" type="text" size="15" value="<?=$data[lastlogintime]?>"></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>登录次数字段</b></td>
      <td  class="tablerow"><input name="newdata[logintimes]" type="text" size="15" value="<?=$data[logintimes]?>"></td>
    </tr>
    </TBODY>
    <tr> 
      <td class="tablerow" width="40%"><b>数据提取条件</b><br>提取<?=$_CHA[channelname]?>数据前应先在phpcms中建立好栏目，然后在提取条件中设置好源数据栏目ID，以便将源数据栏目<?=$_CHA[channelname]?>导入到phpcms的相应栏目去</td>
      <td  class="tablerow"><input name="newdata[condition]" type="text" size="50" value="<?=$data[condition]?>"> 请填写SQL语句</td>
    </tr>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>外部数据导入参数配置</b></td>
    </tr>
    <TBODY style="display:'<? if($data[datatype]!='article') { ?>none<? } ?>'" id="articledata2">
    <tr> 
      <td class="tablerow"><b>提取数据到</b><font color="red">*</font><br>请选择导入的栏目和专题</td>
      <td class="tablerow"><?=$cat_select?>
 
<?=$special_select?>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>分页方式</b></td>
      <td  class="tablerow">
            <select name='newdata[paginationtype]'>
                <option value='0' <? if($data[paginationtype]==0) { ?>selected<? } ?>>不分页</option>
                <option value='1' <? if($data[paginationtype]==1) { ?>selected<? } ?>>自动分页</option>
                <option value='2' <? if($data[paginationtype]==2) { ?>selected<? } ?>>手动分页</option>
            </select>
            自动分页时每页字符数 <input name='newdata[maxcharperpage]' type='text' size="5" value="<?=$data[maxcharperpage]?>">
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b><?=$_CHA[channelname]?>性质</b></td>
      <td  class="tablerow">
         <input name='newdata[ontop]' type='checkbox' value='1' <? if($data[ontop]==1) { ?>checked<? } ?>>置顶&nbsp;&nbsp;&nbsp;&nbsp; 
         <input name='newdata[elite]' type=checkbox value='1' <? if($data[elite]==1) { ?>checked<? } ?>>推荐&nbsp;&nbsp;&nbsp;&nbsp;
         <?=$_CHA[channelname]?>评分等级
               <select name='newdata[stars]'>
                <option value='5' <? if($data[stars]==5) { ?>selected<? } ?>>5</option>
                <option value='4' <? if($data[stars]==4) { ?>selected<? } ?>>4</option>
                <option value='3' <? if($data[stars]==3) { ?>selected<? } ?>>3</option>
                <option value='2' <? if($data[stars]==2) { ?>selected<? } ?>>2</option>
                <option value='1' <? if($data[stars]==1) { ?>selected<? } ?>>1</option>
                <option value='0' <? if($data[stars]==0) { ?>selected<? } ?>>0</option>
              </select>
      </td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>设置这些<?=$_CHA[channelname]?>的阅读点数</b></td>
      <td  class="tablerow"><input name="newdata[readpoint]" type="text" size="5" value="<?=$data[readpoint]?>"> 点</td>
    </tr>
    <tr>
      <td width='300' class="tablerow" ><b>设置这些<?=$_CHA[channelname]?>的阅读等级</b></td>
      <td class="tablerow"><?=$showgroupview?></td>
    </tr>
      <tr>
        <td class="tablerow"><b>提取的数据中是否包含UBB代码</b><br>如果包含UBB代码，系统会在导入前进行解析</td>
        <td class="tablerow"> <input type=radio name='newdata[ubb]' value='1' <? if($data[ubb]) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name='newdata[ubb]' value='0' <? if(!$data[ubb]) { ?>checked<? } ?>> 否 
        </td>
      </tr>
      <tr>
        <td class="tablerow"><b>是否允许提取数据中包含HTML代码</b></td>
        <td class="tablerow"> <input type=radio name='newdata[html]' value='1' <? if($data[html]) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name='newdata[html]' value='0' <? if(!$data[html]) { ?>checked<? } ?>> 否 
        </td>
      </tr>
      <tr>
        <td class="tablerow"><b>是否检查同名<?=$_CHA[channelname]?></b><br>如果选“是”，则系统会自动丢弃同名<?=$_CHA[channelname]?></td>
        <td class="tablerow"> <input type=radio name='newdata[titlecheck]' value='1' <? if($data[titlecheck]) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name='newdata[titlecheck]' value='0' <? if(!$data[titlecheck]) { ?>checked<? } ?>> 否 
        </td>
      </tr>
    <tr> 
      <td class="tablerow"><b>是否立即发布</b></td>
      <td class="tablerow">
          <input name='newdata[status]' type='radio' value='3' <? if($data[status]==3) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;<input name='newdata[status]' type='radio' value='1' <? if($data[status]<3) { ?>checked<? } ?>> 否
     </td>
    </tr>
    </TBODY>
    <TBODY style="display:'<? if($data[datatype]!='member') { ?>none<? } ?>'" id="memberdata2">
    <tr>
      <td width='300' class="tablerow" ><b>设置这些会员到用户组</b><font color="red">*</font></td>
      <td class="tablerow"><?=$showgroupid?></td>
    </tr>
      <tr>
        <td class="tablerow"><b>是否检查同名帐号</b><br>如果选“是”，则系统会自动丢弃同名帐号</td>
        <td class="tablerow"> <input type=radio name='newdata[membercheck]' value='1' <? if($data[membercheck]) { ?>checked<? } ?>> 是&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name='newdata[membercheck]' value='0' <? if(!$data[membercheck]) { ?>checked<? } ?>> 否 
        </td>
      </tr>
    </TBODY>
    <tr> 
      <td class="tablerowhighlight" colspan=2 align="center"><b>数据提取导入执行设置</b></td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>php脚本执行超时时限</b><br>当数据较多时程序执行时间会较长</td>
      <td class="tablerow"><input name="newdata[timelimit]" type="text" size="5" value="<?=$data[timelimit]?>"> 秒</td>
    </tr>
    <tr> 
      <td class="tablerow" width="40%"><b>每次提取并导入数据条数</b><br>如果数据较多可分步提取导入</td>
      <td class="tablerow"><input name="newdata[number]" type="text" size="5" value="<?=$data[number]?>"> 条</td>
    </tr>
    <tr> 
      <td class="tablerow"></td>
      <td class="tablerow"> <input type="submit" name="Submit" value=" 确定 "> 
        &nbsp; <input type="reset" name="reset" value=" 重置 "> </td>
    </tr>
  </form>
</table>
</body>
</html>