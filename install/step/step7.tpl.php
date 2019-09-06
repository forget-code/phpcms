<?php include PHPCMS_PATH.'install/step/header.tpl.php';?>
	<div class="body_box">
        <div class="main_box">
            <div class="hd">
            	<div class="bz a7"><div class="jj_bg"></div></div>
            </div>
            <div class="ct">
            	<div class="bg_t"></div>
                <div class="clr">
                    <div class="l"></div>
                    <div class="ct_box nobrd set7s">
                     <div class="nr">
						<div class="gxwc"><h1>恭喜您，安装成功！</h1></div>
						<div class="clj">
							<ul>
								<li><a href="<?php echo $url?>index.php?m=admin&c=index" title="后台管理" class="htgl">后台管理</a></li>
							</ul>
						</div>					
						<div class="txt_c">
						<span style="margin-right:8px;">*</span>安装完毕请登录后台生成首页，更新缓存<br/>
						<span style="margin-right:8px;">*</span>默认phpcms管理员密码与phpsso管理员密码相同<br/>
						<span style="margin-right:8px;">*</span>为了您站点的安全，安装完成后即可将网站根目录下的“install”文件夹删除。</div>
                     </div>
                    </div>
                </div>
                <div class="bg_b"></div>
            </div>
            <div class="h65"></div>
			<form id="install" action="install.php?" method="get">
			<input type="hidden" name="step" value="7">
        </div>
    </div>
</body>
</html>
