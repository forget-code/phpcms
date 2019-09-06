<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<table cellpadding="0" cellspacing="1" class="table_form">
<caption>文件权限检查</caption>
<tr><th><font color='red'>提示信息：</font>如果某个文件或目录被检查到“无法写入”（以红色列出），请即刻通过 FTP 或其他工具修改其属性（例如设置为 777），以确保程序功能的正常使用。</th></tr>
<?=$result?>
<table cellpadding="0" cellspacing="1" class="table_list">
<caption>系统检测信息</caption>
<tr>
<th width="15%">检测项目</th>
<th class="align_l">当前配置</th>
<tr>
<tr><td>服务器操作系统</td><td><?=$sys_info['os']?></td></tr>
<tr><td>Web 服务器</td><td><?=$sys_info['web_server']?></td></tr>
<tr><td>Mysql</td><td><?=$db->version()?> <?php if($db->version() < '4.1.0'){ ?>您的数据库版本低于 4.1.0，不支持子查询，将无法使用本系统<?php } ?></td></tr>
<tr><td>程序版本<td><?=$sys_info['version']?>（Release：<?=PHPCMS_RELEASE?>）</td></tr>
<tr><td>网站根目录</td><td><?=$sys_info['web_root']?></td></tr>
</table>

<table cellpadding="0" cellspacing="1" class="table_list">
<caption>PHP.INI检测信息</caption>
<tr>
<th width="15%">检测项目</th>
<th width="15%">当前配置</th>
<th width="15%">建议配置</th>
<th width="5%">结果</th>
<th>说明</th>
<tr>
   <tr>
    <td>PHP版本</td>
    <td><?=$sys_info['phpv']?></td>
    <td><font color="red">5.0以上</font></td>
    <td><?if($sys_info['phpv'] < '4.3.0'){?><span style="color:red">×</span><?} else{ ?><span style="color:green">√</span> <? }?></td>
    <td>PHP 版本不得低于 4.1.0，否则无法使用本系统</td>
   </tr>
<tr>
    <td>Gzip 支持</td>
    <td><?if($sys_info['gzip']){?>是<?}else{?>否<?}?></td><td>开启GZIP支持</td><td><?if($sys_info['gzip']){?><span style="color:green">√</span><?}else{?><span style="color:red">×</span><?}?></td><td>GZIP（GNU-ZIP）是一种压缩技术。经过GZIP压缩后页面大小可以变为原来的30%甚至更小。</td></tr>

<tr>
    <td>安全模式</td>
    <td><?if($sys_info['safe_mode']){?>是<?}else{?>否<?}?></td><td>建议不要开启</td><td><?if($sys_info['safe_mode']){?><span style="color:green">√</span><?}else{?><span style="color:red">-</span><?}?></td><td>修改 php.ini（safe_mode = Off）</td></tr>
<tr>
    <td>安全模式GID</td>
    <td><?if($sys_info['safe_mode_gid']){?>是<?}else{?>否<?}?></td><td>建议不要开启</td><td><?if($sys_info['safe_mode_gid']){?><span style="color:green">√</span><?}else{?><span style="color:red">-</span><?}?></td><td>修改 php.ini（safe_mode_gid = Off）</td></tr>
<tr>
    <td>Socket 支持</td>
    <td><?if($sys_info['socket']){?>是<?}else{?>否<?}?></td><td>可选</td><td><?if($sys_info['socket']){?><span style="color:green">√</span><?}else{?><span style="color:red">×</span><?}?></td><td></td></tr>
<tr>
    <td>短标签</td>
    <td><?if($sys_info['short_open_tag']){?>是<?}else{?>否<?}?></td>
    <td>必须开启</td><td><?if($sys_info['socket']){?><span style="color:green">√</span><?}else{?><span style="color:red">×</span><?}?></td><td>修改 php.ini（short_open_tag = ON）</td></tr>
<tr>
    <td>远程打开</td>
    <td><?if($sys_info['php_fopenurl']){?>是<?}else{?>否<?}?></td>
    <td>建议支持</td><td><?if($sys_info['php_fopenurl']){?><span style="color:green">√</span><?}else{?><span style="color:red">×</span><?}?></td><td>如果不支持，系统就无法抓取远程文件。</td></tr>
<tr>
    <td>域名解析</td>
    <td><?if($sys_info['php_dns']){?>是<?}else{?>否<?}?></td>
    <td>建议支持</td><td><?if($sys_info['php_dns']){?><span style="color:green">√</span><?}else{?><span style="color:red">×</span><?}?></td><td></td></tr>

<tr>
    <td>GD 版本</td>
    <td><?=$sys_info['gd']?></td>
    <td>GD2</td><td><?if($gd){?><span style="color:green">√</span><?}else{?><span style="color:red">×</span> <? }?></td><td></td></tr>
<tr>
    <td>Zlib 支持</td>
    <td><?if($sys_info['zlib']){?>是<?}else{?>否<?}?></td><td></td><td><?if($sys_info['zlib']){?><span style="color:green">√</span><?}else{?><span style="color:red">×</span><?}?></td><td></td></tr>
<tr>
    <td>上传最大文件</td>
    <td><?=$sys_info['fileupload']?></td>
    <td></td><td></td><td></td></tr>
<tr>
    <td>时区设置</td>
    <td><?=$sys_info['timezone']?></td><td></td><td></td><td></td></tr>
</table>


<table cellpadding="0" cellspacing="1" class="table_list">
<caption>数据库检测信息</caption>
<tr>
<th width="15%">检测项目</th>
<th width="15%">当前配置</th>
<th width="15%">建议配置</th>
<th width="5%">结果</th>
<th>说明</th>
<tr>
<tr>
    <td>数据库版本</td>
    <td><?=$sys_info['mysqlv']?></td>
    <td><font color="red">5.0以上</font></td><td><?if($sys_info['mysqlv'] < '4.0.0'){?><span style="color:red">×</span><?}else{?><span style="color:green">√</span><?}?></td>
    <td>Mysql 版本不得低于 4.0.0 </td></tr>
<tr>
    <td>全文索引最小长度</td>
    <td><?=$sys_info['ft_min_word_len']?></td>
    <td><font color="red">1</font></td>
    <td><?if(intval($sys_info['ft_min_word_len']) <= '2'){?><span style="color:green">√</span><?}else{?><span style="color:red">×</span><?}?></td><td>请修改<?=substr(PHP_OS, 0, 3) == 'WIN' ? 'my.ini' : 'my.cnf' ?>，在 [mysqld] 后面加入一行“ft_min_word_len=1”，<br />然后重启Mysql，<a href="?mod=search&file=search&action=createindex">重建全文索引</a>，否则将无法使用全站搜索功能</td></tr>
</table>
</body>
</html>
