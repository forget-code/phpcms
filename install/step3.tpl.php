<?php include PHPCMS_ROOT.'install/header.tpl.php';?>
	 <table width="100%" cellpadding="0" cellspacing="0" class="table_list">
                  <tr>
                    <th>检查项目</th>
                    <th>当前环境</th>
                    <th>建议环境</th>
                    <th>功能影响</th>
                  </tr>
                  <tr>
                    <td>操作系统</td>
                    <td><?php echo php_uname();?></td>
                    <td>Windows_NT/Linux/Freebsd</td>
                    <td><font color="yellow">√</font></td>
                  </tr>
                  <tr>
                    <td>web 服务器</td>
                    <td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
                    <td>Apache/IIS</td>
                    <td><font color="yellow">√</font></td>
                  </tr>
                  <tr>
                    <td>php 版本</td>
                    <td>php <?php echo phpversion();?></td>
                    <td>php 4.3.0 及以上</td>
                    <td><?php if(phpversion() >= '4.3.0'){ ?><font color="yellow">√<?php }else{ ?><font color="red">无法安装</font><?php }?></font></td>
                  </tr>
                  <tr>
                    <td>mysql 扩展</td>
                    <td><?php if(extension_loaded('mysql')){ ?>√<?php }else{ ?>×<?php }?></td>
                    <td>建议开启</td>
                    <td><?php if(extension_loaded('mysql')){ ?><font color="yellow">√</font><?php }else{ ?><font color="red">无法安装</font><?php }?></td>
                  </tr>
                  <tr>
                    <td>gd 扩展</td>
                    <td><?php if($PHP_GD){ ?>√ （支持 <?php echo $PHP_GD;?>）<?php }else{ ?>×<?php }?></td>
                    <td>建议开启</td>
                    <td><?php if($PHP_GD){ ?><font color="yellow">√</font><?php }else{ ?><font color="red">不支持缩略图和水印</font><?php }?></td>
                  </tr>
                  <tr>
                    <td>zlib 扩展</td>
                    <td><?php if(extension_loaded('zlib')){ ?>√<?php }else{ ?>×<?php }?></td>
                    <td>建议开启</td>
                    <td><?php if(extension_loaded('zlib')){ ?><font color="yellow">√</font><?php }else{ ?><font color="red">不支持Gzip功能</font><?php }?></td>
                  </tr>
                  <tr>
                    <td>ftp 扩展</td>
                    <td><?php if(extension_loaded('ftp')){ ?>√<?php }else{ ?>×<?php }?></td>
                    <td>建议开启</td>
                    <td><?php if(extension_loaded('ftp')){ ?><font color="yellow">√</font><?php }elseif(ISUNIX){ ?><font color="red">不支持在线升级</font><?php }?></td>
                  </tr>
                  <tr>
                    <td>iconv/mb_string 扩展</td>
                    <td><?php if(extension_loaded('iconv') || extension_loaded('mbstring')){ ?>√<?php }else{ ?>×<?php }?></td>
                    <td>建议开启</td>
                    <td><?php if(extension_loaded('iconv') || extension_loaded('mbstring')){ ?><font color="yellow">√</font><?php }else{ ?><font color="red">字符集转换效率低</font><?php }?></td>
                  </tr>
                  <tr>
                    <td>short_open_tag</td>
                    <td><?php if(ini_get('short_open_tag')){ ?>√<?php }else{ ?>×<?php }?></td>
                    <td>必须打开</td>
                    <td><?php if(ini_get('short_open_tag')){ ?><font color="yellow">√</font><?php }else{ ?><font color="red">无法安装</font><?php }?></td>
                  </tr>
                  <tr>
                    <td>allow_url_fopen</td>
                    <td><?php if(ini_get('allow_url_fopen')){ ?>√<?php }else{ ?>×<?php }?></td>
                    <td>建议打开</td>
                    <td><?php if(ini_get('allow_url_fopen')){ ?><font color="yellow">√</font><?php }else{ ?><font color="red">不支持保存远程图片</font><?php }?></td>
                  </tr>
                  <tr>
                    <td>DNS解析</td>
                    <td><?php if($PHP_DNS){ ?>√<?php }else{ ?>×<?php }?></td>
                    <td>建议设置正确</td>
                    <td><?php if($PHP_DNS){ ?><font color="yellow">√</font><?php }else{ ?><font color="red">不支持采集和保存远程图片</font><?php }?></td>
                  </tr>
                </table>
<form id="install" action="install.php?" method="post">
<input type="hidden" name="step" value="4">
 </form>
<a href="javascript:history.go(-1);" class="btn">返回上一步：<?php echo $steps[--$step];?></a><?php if($is_right) { ?>
<a onClick="$('#install').submit();" class="btn"><span>下一步</span></a>
<?php }else{ ?>
<a onClick="alert('当前配置不满足Phpcms安装需求，无法继续安装！');" class="btn"><span>检测不通过，无法继续安装</span></a>
 <?php }?>
  </div>
</div>
</body>
</html>		 