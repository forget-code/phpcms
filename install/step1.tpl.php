<?php include PHPCMS_ROOT.'install/header.tpl.php';?>
	<div class="content">
		<div id="installdiv">
		  <h3>（一）运行环境需求</h3>
		  <ul>
			<li>可用的 httpd 服务器（如 Apache，Zeus，IIS 等）</li>
			<li>PHP 4.3.0 及以上 </li>
			<li>Mysql 4.0.x 及以上</li>
		  </ul>
          <br />
		  <h3>（二）程序安装步骤</h3>
		  <?php if(substr(PHP_OS, 0, 3) == 'WIN'){ ?>
		  <ul>
			<li>第一步：使用ftp工具中的二进制模式将本软件包里的 phpcms 目录上传至服务器，假设上传后目录仍为 phpcms；</li>
			<li>第二步：访问 http://yourwebsite/phpcms/install.php 进入安装程序，根据安装向导提示完成安装！</li>
		  </ul>
		  <?php }else{ ?>
		  <ul>
			<li>第一步：使用ftp工具，将该软件包里的 upload 目录及其文件上传到您的空间，假设上传后目录仍旧为 upload。</li>
			<li>第二步：先确认以下目录或文件属性为 (777) 可写模式。index.html,sitemaps.xml,sitemap.html,baidunews.xml,include/config.inc.php,about/*,data/*,templates/*,uploadfile/,languages/*</li>
			<li>第三步：运行 http://yourwebsite/upload/install.php 安装程序，填入安装相关信息与资料，完成安装！</li>
		  </ul>
		  <?php } ?>
		</div>
		<br />
		<a class="btn" onClick="$('#install').submit();">开始安装 Phpcms2008</a>
	</div>
	<form id="install" action="install.php?" method="post">
	<input type="hidden" name="step" value="2">
	</form>
  </div>
</div>
<script type="text/javaScript" src="http://update.phpcms.cn/?action=phpcms_install&charset=<?php echo CHARSET;?>&phpcms_version=<?php echo PHPCMS_VERSION;?>&phpcms_release=<?php echo PHPCMS_RELEASE;?>&url=<?php echo urlencode(URL);?>"></script>
</body>
</html>