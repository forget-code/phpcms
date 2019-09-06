<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<?=$menu?>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2><?=$name?> 模块</th>
  </tr>
	<tr> 
      <td width="15%" class="tablerow">模块名称</td>
      <td class="tablerow"><?=$name?></td>
    </tr>
	<tr> 
      <td class="tablerow">模块目录</td>
      <td class="tablerow"><?=$module?></td>
    </tr>
	<tr> 
      <td class="tablerow">是复制</td>
      <td class="tablerow"><?=$iscopy?></td>
    </tr>
	<tr> 
      <td class="tablerow">是共享</td>
      <td class="tablerow"><?=$isshare?></td>
    </tr>
	<tr> 
      <td class="tablerow">版本号</td>
      <td class="tablerow"><?=$version?></td>
    </tr>
	<tr> 
      <td class="tablerow">作者</td>
      <td class="tablerow"><?=$author?></td>
    </tr>
	<tr> 
      <td class="tablerow">E-mail</td>
      <td class="tablerow"><?=$email?></td>
    </tr>
	<tr> 
      <td class="tablerow">网站地址</td>
      <td class="tablerow"><?=$site?></td>
    </tr>
	<tr> 
      <td class="tablerow">功能说明</td>
      <td class="tablerow"><?=$introduce?></td>
    </tr>
	<tr> 
      <td class="tablerow">许可协议</td>
      <td class="tablerow"><?=$license?></td>
    </tr>
	<tr> 
      <td class="tablerow">发布日期</td>
      <td class="tablerow"><?=$publishdate?></td>
    </tr>
	<tr> 
      <td class="tablerow">安装日期</td>
      <td class="tablerow"><?=$installdate?></td>
    </tr>
	<tr> 
      <td class="tablerow">更新日期</td>
      <td class="tablerow"><?=$updatedate?></td>
    </tr>
</table>
</body>
</html>