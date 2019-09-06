<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header','phpcms');

?>
<?=$menu?>
<style type="text/css">
<!--
.STYLE2 {color: #FF0000}
.STYLE3 {color: #000000}
-->
</style>
<body>
<form action="?mod=<?=$mod?>&amp;file=<?=$file?>" method="post" name="myform" id="myform">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1"  class="tableborder">
    <tr>
      <th height="25" colspan="4">文件比较</th>
    </tr>
    <tr bgcolor="#E4EDF9">
      <td height="25" colspan="2"><div align="center"><strong>
      </strong></div>        <strong><label></label>
        <div align="center">推荐选择目录</div>
        </strong></td>
    </tr>
        <tr>
      <td width="56" height="25" bgcolor="#F1F3F5"><div align="center">
        <input name="files[root]" type="checkbox" id="files[root]" value="root" checked>
      </div></td>
      <td height="25" bgcolor="#F1F3F5"><strong>网站根目录[./]</strong></td>
    </tr>
    <tr>
      <td width="56" height="25" bgcolor="#F1F3F5"><div align="center"><strong>
        <input name="files[admin]" type="checkbox" id="files[admin]" value="admin" checked>
      </strong></div></td>
      <td height="25" bgcolor="#F1F3F5"><strong>后台文件[./admin]</strong></td>
    </tr>
    <tr>
      <td width="56" height="25" bgcolor="#F1F3F5"><div align="center"><strong>
        <input name="files[include]" type="checkbox" id="files[include]" value="include" checked>
      </strong></div></td>
      <td width="900" height="25" bgcolor="#F1F3F5"><strong>系统文件[./include]</strong></td>
    </tr>
    <tr>
      <td width="56" height="25" bgcolor="#F1F3F5"><div align="center"><strong>
        <input name="files[module]" type="checkbox" id="files[module]" value="module" checked>
      </strong></div></td>
      <td width="900" height="25" bgcolor="#F1F3F5"><strong>系统模块[./moudle]</strong></td>
    </tr>
    <tr>
      <td width="56" height="25" bgcolor="#F1F3F5"><div align="center"><strong>
        <input name="files[mod]" type="checkbox" id="files[mod]" value="mod" checked>
      </strong></div></td>
      <td width="900" height="25" bgcolor="#F1F3F5"><strong>
        <label>模块文件[不包含HTML文件]</label>
      </strong></td>
    </tr>
    <tr>
      <td width="56" height="25" bgcolor="#F1F3F5"><div align="center">
        <input name="files[install]" type="checkbox" id="files[install]" value="install" checked>
      </div></td>
      <td height="25" bgcolor="#F1F3F5"><strong>安装文件[./install]</strong></td>
    </tr>
    <tr>
      <td width="56" height="25" bgcolor="#F1F3F5"><div align="center"><strong>
        <input name="files[templates]" type="checkbox" id="files[templates]" value="templates" checked>
      </strong></div></td>
      <td width="900" height="25" bgcolor="#F1F3F5"><strong>模板文件[./templates]</strong></td>
    </tr>
    <tr>
      <td height="25" colspan="2" bgcolor="#E4EDF9"><div align="center"><strong>自定义选择目录</strong></div></td>
    </tr>
    <tr>
      <td width="56" height="25" bgcolor="#F1F3F5"><div align="center"><strong>
        <input name="files[data]" type="checkbox" id="files[data]" value="data">
      </strong></div></td>
      <td height="25" bgcolor="#F1F3F5"><strong>缓存文件[./data]</strong></td>
    </tr>




    <tr>
      <td width="56" height="25" bgcolor="#F1F3F5">
        <div align="center">
          <input name="files[languages]" type="checkbox" id="files[languages]" value="languages">
        </div></td>
      <td height="25" bgcolor="#F1F3F5"><strong>语言文件[./languages]</strong></td>
    </tr>
    <tr>
      <td width="56" height="25" bgcolor="#F1F3F5">
        <div align="center">
          <input name="files[images]" type="checkbox" id="files[images]" value="images">
        </div></td>
      <td height="25" bgcolor="#F1F3F5"><strong>图片文件[./images]</strong></td>
    </tr>

    <tr>
      <td width="56" height="25" bgcolor="#F1F3F5">全选
        <label>
        <input name='chkall' type='checkbox' id='chkall' onClick='checkall(this.form)' value='check' />
        </label></td>
      <td width="900" height="25" bgcolor="#F1F3F5"><label></label></td>
    </tr>
  </table>
  <table width="100%">
    <tr>
      <td width="22%">&nbsp;</td>
      <td width="13%"><span class="tablerow">
        <input name="dosubmit" type="submit" id="dosubmit3" onClick="if(confirm('此过程比较缓慢，是否继续？')) document.myform.action='?mod=<?=$mod?>&file=filecheck&action=check'" value="检查文件"/>
        </span></td>
      <td width="65%"><span class="tablerow">
      <input name="dosubmit" type="submit" id="dosubmit" onClick="if(confirm('此过程比较缓慢，是否继续？')) document.myform.action='?mod=<?=$mod?>&file=filecheck&action=reload'" value="重新生成镜像"/>
      <?php if(filesize($allfiles_path)>=1000) { ?>[上次生成镜像的时间是:]<span class="STYLE2"><?=$filedate?><span class="STYLE3"></span><?php }else{ ?><span class="STYLE2">
      您还没有创建镜像</span><?php }?>
      </td>
    </tr>
  </table>
</form>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1"  class="tableborder">

  <tr>

    <td height="22" bgcolor="#E4EDF9"><div align="center"><strong>已经生成的镜像目录</strong></div></td>

  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1"  class="tableborder">

  <tr>
    <?php foreach($check_path as $list) {?>
    <td width="20" height="25" bgcolor="#F1F3F5"><?=$list?></td>
      <?php }?>
  </tr>
</table>
</body>
</html>