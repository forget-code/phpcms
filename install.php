<?php
error_reporting(E_ERROR);

set_magic_quotes_runtime(0);
define('IN_PHPCMS', TRUE);
define('PHPCMS_ROOT', str_replace("\\", '/', dirname(__FILE__)));
@set_time_limit(1000);

require PHPCMS_ROOT."/include/version.inc.php";
require PHPCMS_ROOT."/install/modules.inc.php";
require PHPCMS_ROOT."/include/global.func.php";
require PHPCMS_ROOT."/admin/include/global.func.php";
require PHPCMS_ROOT."/config.inc.php";
require PHPCMS_ROOT."/include/db_".$CONFIG['database'].".class.php";
header("Content-Type:text/html;charset=".$CONFIG['charset']."");
if(file_exists(PHPCMS_ROOT.'/data/install.lock')) exit('您已经安装过PHPCMS,如果需要重新安装，请删除 ./data/install.lock 文件！'); 
$PHP_MODULE = get_loaded_extensions();
$PHP_OS = PHP_OS;
$PHP_DOMAIN = $_SERVER['SERVER_NAME'];
$PHP_SCHEME = $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
$PHP_PORT = $_SERVER['SERVER_PORT'] == '80' ? '' : ':'.$_SERVER['SERVER_PORT'];
define("PHPCMS_SITEURL",$PHP_SCHEME.$PHP_DOMAIN.$PHP_PORT.$CONFIG['rootpath']);
define('PHPCMS_PATH',$CONFIG['rootpath']);

$PHPCMS['enableftp'] = 0;

if(strrpos(strtolower(PHP_OS),"win") === FALSE)
{
	define('ISUNIX', TRUE);
}
else
{
	define('ISUNIX', FALSE);
}

$step = isset($_POST['step']) ? $_POST['step'] : (isset($_GET['step']) ? $_GET['step'] : 1);

$step = isset($step) ? $step : 1;
header("Content-Type:text/html;charset=".$CONFIG['charset'].""); 
switch($step)
{
    case '1': //开始界面
		include PHPCMS_ROOT."/install/step".$step.".tpl.php";

		break;

    case '2': //安装方式
		include PHPCMS_ROOT."/install/step".$step.".tpl.php";
		break;

	case '3'://接受协议
		if($_POST['radiobutton']==2)
		{
			file_put_contents(PHPCMS_ROOT.'/data/uninstall/phpcms/isupdate.lock',' ');
		}
		$license = file_get_contents(PHPCMS_ROOT."/install/license.txt");
		include PHPCMS_ROOT."/install/step".$step.".tpl.php";
		break;		
		
	case '4': //选择模块
		include PHPCMS_ROOT."/install/step".$step.".tpl.php";
		break;
		
	case '5': //目录检查
        $PHP_DOMAIN = $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : '');
		$selectmod = isset($_POST['selectmod']) ? implode(',', $_POST['selectmod']) : '';
		$selectchannel = isset($_POST['selectchannel']) ? implode(',', $_POST['selectchannel']) : '';
		$selectcount = count($_POST['selectchannel']) + count($_POST['selectmod']);
		include PHPCMS_ROOT."/install/step".$step.".tpl.php";
		break;

	case '6': //环境检测	
		if(!file_exists(PHPCMS_ROOT.'/data/uninstall/phpcms/ftpsetting.php') && $_POST['ftphost'] && $_POST['ftpuser'])
		{			
			$PHPCMS['enableftp'] = 1;
			$PHPCMS['ftphost'] = $_POST['ftphost'];
			$PHPCMS['ftpuser'] = $_POST['ftpuser'];
			$PHPCMS['ftppass'] = $_POST['ftppass'];
			$PHPCMS['ftpport'] = $_POST['ftpport'];
			$PHPCMS['ftpwebpath'] = $_POST['ftpwebpath'];
			$mode = 777;
			require_once PHPCMS_ROOT.'/include/ftp.class.php';
			$ftp = new phpcms_ftp($PHPCMS['ftphost'], $PHPCMS['ftpuser'], $PHPCMS['ftppass'], $PHPCMS['ftpport'], $PHPCMS['ftpwebpath'], 'I', 1);
			if(!$ftp->connected) exit("<script>alert('设置错误！无法连接到FTP服务器,请先确认并保存FTP设置后进入下一步');this.location='install.php?step=1';</script>");
			if(!$ftp->is_phpcms()) exit("<script>alert('网站根目录相对FTP根目录的路径设置错误！,请先确认并保存FTP设置后进入下一步');this.location='install.php?step=1';)</script>");			
			dir_chmod(PHPCMS_ROOT.'/', $mode); 			
			dir_chmod(PHPCMS_ROOT.'/uploadfile/', $mode); 
			dir_chmod(PHPCMS_ROOT.'/config.inc.php',$mode); 
			dir_chmod(PHPCMS_ROOT.'/index.html',$mode);					
			dir_chmod(PHPCMS_ROOT.'/data/*', $mode);		//强制对所有子目录和文件都更改
			dir_chmod(PHPCMS_ROOT.'/templates/*', $mode);	//强制
			dir_chmod(PHPCMS_ROOT.'/install/*', $mode);	//强制	
			array_save($PHPCMS,'$PHPCMS', PHPCMS_ROOT."/data/uninstall/phpcms/ftpsetting.php");
		}
		$selectmod = isset($_POST['selectmod']) ? explode(',', $_POST['selectmod']) : array();
		$selectchannel = isset($_POST['selectchannel']) ? explode(',', $_POST['selectchannel']) : array();
		$selectcount = isset($_POST['selectcount']) ? $_POST['selectcount'] : 0;
        $modules = array_merge($selectmod,$selectchannel);
		array_push($modules, 'phpcms', 'member');
		//array_save
		array_save($selectmod,"\$selectmod",PHPCMS_ROOT.'/data/uninstall/phpcms/selectmod.php');
		array_save($selectchannel,"\$selectchannel",PHPCMS_ROOT.'/data/uninstall/phpcms/selectchannel.php');
		array_save($modules,"\$modules",PHPCMS_ROOT.'/data/uninstall/phpcms/modules.php');
		file_put_contents(PHPCMS_ROOT.'/data/uninstall/phpcms/installnum.php',$selectcount);
		$PHP_SERVER = $_SERVER['SERVER_SOFTWARE'];
		$PHP_VERSION = phpversion();
        $PHP_GD = "";
        if(function_exists('imagepng')) $PHP_GD .= "png";
        if(function_exists('imagejpeg')) $PHP_GD .= " jpg";
        if(function_exists('imagegif')) $PHP_GD .= " gif";
		$PHP_MBSTRING = in_array('mbstring',$PHP_MODULE) ? 1 : 0;
		$PHP_ZLIB = in_array('zlib',$PHP_MODULE) ? 1 : 0;
        $PHP_ZEND = '';
        if(in_array('Zend Optimizer',$PHP_MODULE))
	    {
			if(!function_exists('zend_optimizer_version'))
			{
				function zend_optimizer_version()
				{
					ob_start();
					@phpinfo();
					$phpinfo = ob_get_contents();
					ob_end_clean();
					preg_match("/Zend(?: |&nbsp;)+?Optimizer(?: |&nbsp;)+?v([0-9]+\.[0-9]+\.[0-9]+),/",strip_tags($phpinfo),$info); 
					return $info[1];
				}
			}
			$PHP_ZEND = zend_optimizer_version();
		}
        $PHP_FOPENURL = @get_cfg_var("allow_url_fopen");
        $PHP_DNS = preg_match("/^[0-9.]{7,15}$/", @gethostbyname('www.phpcms.cn')) ? 1 : 0;
		$PHP_SAFEMODE = ini_get('safe_mode');
		$install = 1;
		if($PHP_VERSION < '4.3.0' || ($PHP_ZEND && $PHP_ZEND < '2.5.10')) $install = 0;

		include PHPCMS_ROOT."/install/step".$step.".tpl.php";
		break;

	case '7':	//数据库连接配置
		$PHP_SELF = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);
		$rootpath = str_replace("\\","/",dirname($PHP_SELF));
		$rootpath = strlen($rootpath)>1 ? $rootpath."/" : "/";

		include PHPCMS_ROOT."/install/step".$step.".tpl.php";
		break;
	case '8':	//超级管理员用户名
	
		$dbhost = $_POST['dbhost'];
		$dbuser = $_POST['dbuser'];
		$dbpw = $_POST['dbpw'];
		$dbname = $_POST['dbname'];
		$tablepre = $_POST['tablepre'];
		if(!@mysql_connect($dbhost,$dbuser,$dbpw)) exit("<script>alert('无法连接到数据库服务器，请检查配置！');</script>");
		if(!@mysql_select_db($dbname))
	    {
			if(!@mysql_query("CREATE DATABASE $dbname")) exit("<script>alert('指定的数据库不存在，系统也无法创建，请先通过其他方式建立好数据库！');</script>");
			mysql_select_db($dbname);
		}
		$query = mysql_list_tables($dbname);
		$installed  = false;
		while($r = mysql_fetch_row($query))
		{
			$tables[] = $r[0];
		}
		if(is_array($tables) && in_array($CONFIG['tablepre']."module",$tables))
	    {
	    	$installed = true;			
		}
		
		$rootpath = $_POST['rootpath'];
		$pconnect = $_POST['pconnect'];
		$dbcharset = $_POST['dbcharset'];
		$cookiepre = $_POST['cookiepre'];
		$timestamp = time();

		$db = new db_mysql();
		$db->connect($dbhost, $dbuser, $dbpw, '', $pconnect);
		
		if(!@$db->select_db($dbname))
	    {
			@$db->query("CREATE DATABASE $dbname");
			if(@$db->error()) 
				message("指定的数据库不存在，系统也无法创建，请先通过其他方式建立好数据库！","goback");
			else
			    $db->select_db($dbname);
		}

		if($db->version() < '4.1') $dbcharset = '';

		$config = array('dbhost'=>$dbhost,
						'dbuser'=>$dbuser,
						'dbpw'=>$dbpw,
						'dbname'=>$dbname,
						'tablepre'=>$tablepre,
						'rootpath'=>$rootpath,
						'pconnect'=>$pconnect,
						'dbcharset'=>$dbcharset,
						'cookiepre'=>$cookiepre
						);
		set_config($config);
		$config_js = "var phpcms_path = '$rootpath';\nvar cookiepre = '$cookiepre';";
		dir_create(PHPCMS_ROOT.'/data/js/');
		file_put_contents(PHPCMS_ROOT.'/data/js/config.js', $config_js);
		chmod(PHPCMS_ROOT.'/data/js/config.js', 0777);
		include PHPCMS_ROOT."/install/step".$step.".tpl.php";
		break;
		
	case '9':	//安装程序正在运行	
		include(PHPCMS_ROOT."/include/htmlframe.inc.php");
		include(PHPCMS_ROOT."/include/auth.func.php");
	 	loadMtir();
	 	//多页面传值，临时文件保存
	 	$user = array('username' => $_POST['username'],
					  'password' => $_POST['password'],
					  'email' => $_POST['email']
					  );
		file_put_contents(PHPCMS_ROOT.'/data/uninstall/phpcms/phpcms.php',phpcms_encode(serialize($user),'uninstall'));
		include PHPCMS_ROOT."/install/step".$step.".tpl.php";
		break;
		
		
	case '10':	//  完成安装 
		include PHPCMS_ROOT."/install/step".$step.".tpl.php";
		file_put_contents(PHPCMS_ROOT.'/data/install.lock',' ');
		@unlink(PHPCMS_ROOT.'/data/uninstall/phpcms/ftpsetting.php');
		$isupdate = false;
		if(file_exists(PHPCMS_ROOT.'/data/uninstall/phpcms/isupdate.lock'))
		{
			$isupdate = true;	
			@unlink(PHPCMS_ROOT.'/data/uninstall/phpcms/isupdate.lock');	
		}
		break;
		
	case 'installmodule':			
		define('PHPCMS_CACHEDIR',$CONFIG['cachedir']);
		$db = new db_mysql();
		$db->connect($CONFIG['dbhost'], $CONFIG['dbuser'], $CONFIG['dbpw'], $CONFIG['dbname'], $CONFIG['pconnect']);
		include(PHPCMS_ROOT."/include/htmlframe.inc.php");
	 	loadMtir();
		$s = isset($_GET['s']) ? $_GET['s'] : 1;
		$currentjob = isset($_GET['currentjob']) ? $_GET['currentjob'] : 'channel';
		$installnum = trim(file_get_contents(PHPCMS_ROOT.'/data/uninstall/phpcms/installnum.php'));
		$installnum = $installnum ? $installnum : 1;		
		$n = isset($_GET['n']) ? $_GET['n'] : 1;
		$modulestep = 6; //每个模块的安装步骤
		$processnum = 300/($installnum*$modulestep) ;
		$processwidth = 30 + ceil($n*$processnum);

		//使用ftp设置目录文件属性
		if(file_exists(PHPCMS_ROOT.'/data/uninstall/phpcms/ftpsetting.php'))
		{
			include PHPCMS_ROOT.'/data/uninstall/phpcms/ftpsetting.php';			
			require_once PHPCMS_ROOT.'/include/ftp.class.php';
			$ftp = new phpcms_ftp($PHPCMS['ftphost'], $PHPCMS['ftpuser'], $PHPCMS['ftppass'], $PHPCMS['ftpport'], $PHPCMS['ftpwebpath'], 'I', 1);
		}

		switch($currentjob)
		{
			case  'main':
				echo "<script language=\"javascript\">parent.currentmod.innerHTML='安装：系统主框架（核心模块）';</script>";
				if(!file_exists(PHPCMS_ROOT."/install/main/phpcms.sql"))
				{
					echo 'install/main/下不存在phpcms.sql主框架数据文件，安装失败，请检查文件完整性';
					exit();
				}
				else
				{
					$sql = file_get_contents(PHPCMS_ROOT."/install/main/phpcms.sql");
					sql_execute($sql);
					$cache_setting = cache_read('phpcms_setting.php');
					$cache_setting = addslashes(serialize($cache_setting));
					$db->query("UPDATE {$CONFIG['tablepre']}module SET setting='$cache_setting' WHERE module='phpcms'");
				}
				echo "<script language=\"javascript\">parent.InstallingModule.innerHTML='1、安装PHPCMS系统主框架&nbsp;<img src=\"install/images/yes.gif\" /><br />'; parent.processor.style.width='7px';</script>";
				if(!file_exists(PHPCMS_ROOT."/install/main/member.sql"))
				{
					echo 'install/main/下不存在member.sql会员系统数据文件，安装失败，请检查文件完整性';
					exit();
				}
				else
				{
					$sql = file_get_contents(PHPCMS_ROOT."/install/main/member.sql");
					sql_execute($sql);
					$cache_setting = cache_read('member_setting.php');
					$cache_setting = addslashes(serialize($cache_setting));
					$db->query("UPDATE {$CONFIG['tablepre']}module SET setting='$cache_setting' WHERE module='member'");
				}
				echo "<script language=\"javascript\">parent.InstallingModule.innerHTML='2、安装PHPCMS会员模块&nbsp;<img src=\"install/images/yes.gif\" />'; parent.processor.style.width='15px';</script>";
				
				$PHP_DOMAIN = $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : '');
				$PHP_SCHEME = $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
				$PHP_PORT = $_SERVER['SERVER_PORT'] == '80' ? '' : ':'.$_SERVER['SERVER_PORT'];
				$PHP_SITEURL = $PHP_SCHEME.$PHP_DOMAIN.$PHP_PORT.PHPCMS_PATH;
				$r = $db->get_one("SELECT setting FROM ".$CONFIG['tablepre']."module WHERE module='phpcms'");
				$setting = unserialize($r['setting']);
				$setting['siteurl'] = $PHP_SITEURL;
				$setting = serialize($setting);
				$db->query("UPDATE {$CONFIG['tablepre']}module SET setting='$setting' WHERE module='phpcms'");
				
				//保存ftp设置
				if(file_exists(PHPCMS_ROOT.'/data/uninstall/phpcms/ftpsetting.php') && ISUNIX)
				{
					include(PHPCMS_ROOT.'/data/uninstall/phpcms/ftpsetting.php');
					$r = $db->get_one("SELECT setting FROM ".$CONFIG['tablepre']."module WHERE module='phpcms'");	
					if($r['setting'])
					{
						$PHPCMS['enableftp'] = dir_writable(PHPCMS_ROOT.'/data/temp/'.time().'/') ? 0 : 1;
						$setting = unserialize($r['setting']);
						$setting['enableftp'] = $PHPCMS['enableftp'];
						$setting['ftphost'] = $PHPCMS['ftphost'];
						$setting['ftpuser'] = $PHPCMS['ftpuser'];
						$setting['ftppass'] = $PHPCMS['ftppass'];
						$setting['ftpwebpath'] = $PHPCMS['ftpwebpath'];
						$setting['ftpport'] = $PHPCMS['ftpport'];
						$setting = serialize($setting);
						$db->query("UPDATE {$CONFIG['tablepre']}module SET setting='$setting' WHERE module='phpcms'");
					}
				}
				echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=area');</script>";	
				break;
			case 'area':
				$sql = file_get_contents(PHPCMS_ROOT."/install/main/area.sql");
				sql_execute($sql);
				echo "<script language=\"javascript\">parent.InstallingModule.innerHTML='正在插入系统必备数据...&nbsp;<img src=\"install/images/yes.gif\" />'; parent.processor.style.width='30px';</script>";
				echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=channel&n=1&s=1');</script>";
				break;
			case  'channel':
				include PHPCMS_ROOT.'/data/uninstall/phpcms/selectchannel.php';
				if(!empty($selectchannel)) //安装频道
				{
					$selectchannelkey = array_keys($selectchannel);
					$currentkey = $selectchannelkey[0];
					$current = $selectchannel[$currentkey];
					echo "<script language=\"javascript\">parent.currentmod.innerHTML='当前频道：".$PHPCMS_CHANNELS['modules'][$current]."';</script>";
					if($s==1)
					{
						echo "<script language=\"javascript\">parent.InstallingModule.innerHTML='1、开始准备需要安装的频道&nbsp;<img src=\"install/images/yes.gif\" /><br />';</script>";
					}
					elseif($s==2)
					{
						if(file_exists(PHPCMS_ROOT."/module/".$current."/install/mysql.sql"))
						{
							$sql = file_get_contents(PHPCMS_ROOT."/module/".$current."/install/mysql.sql");
							sql_execute($sql);						
						}
						echo "<script language=\"javascript\">parent.InstallingModule.innerHTML+=' 2、正在创建数据表&nbsp;<img src=\"install/images/yes.gif\" /><br />';</script>";
					}
					elseif($s==3)
					{
						if($PHPCMS['enableftp'])
						{
							if(file_exists(PHPCMS_ROOT."/module/".$current."/install/chmod.txt"))
							{
								$files = file(PHPCMS_ROOT."/module/".$current."/install/chmod.txt");
								$files = array_filter($files);
								foreach($files as $file)
								{
									dir_chmod(PHPCMS_ROOT.'/'.trim($file));
								}
							}
						}
						echo "<script language=\"javascript\">parent.InstallingModule.innerHTML+=' 3、正在设置相关目录及文件属性&nbsp;<img src=\"install/images/yes.gif\" /><br />';</script>";
					}
					elseif($s==4)
					{
						if(file_exists(PHPCMS_ROOT."/module/".$current."/install/extension.php"))
						{
							include(PHPCMS_ROOT."/module/".$current."/install/extension.php");
						}
						$cache_setting = cache_read($current.'_setting.php');
						$cache_setting = serialize($cache_setting);
					
						$db->query("UPDATE {$CONFIG['tablepre']}module SET setting='$cache_setting' WHERE module='$current'");
						echo "<script language=\"javascript\">parent.InstallingModule.innerHTML+=' 4、正在加载模块个性化设置&nbsp;<img src=\"install/images/yes.gif\" /><br />';</script>";
					}
					$s = $s+1;
					$n = $n+1;
					if($s>4)
					{
						//已安装的从数组中移出；
						unset($selectchannel[$currentkey]);
						array_save($selectchannel,'$selectchannel',PHPCMS_ROOT.'/data/uninstall/phpcms/selectchannel.php');	
						echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=channel&n=$n&s=1');</script>";
					}
					else
					{	
						echo "<script language=\"javascript\">parent.processor.style.width='".$processwidth."px';</script>";
						echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=channel&n=$n&s=".$s."');</script>";
					}
				}
				else //==0后频道安装完成
				{					
					echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=module&n=$n&s=1');</script>";
				}
				break;
				
			case 'module'://安装模块
				include PHPCMS_ROOT.'/data/uninstall/phpcms/selectmod.php';
				if($selectmod)
				{
					$selectmodkey = array_keys($selectmod);
					$currentkey = $selectmodkey[0];
					$current = $selectmod[$currentkey];
					echo "<script language=\"javascript\">parent.currentmod.innerHTML='当前模块：".$PHPCMS_MODULES['modules'][$current]."';</script>";
					if($s==1)
					{
						echo "<script language=\"javascript\">parent.InstallingModule.innerHTML='1、开始准备需要安装的模块&nbsp;<img src=\"install/images/yes.gif\" /><br />';</script>";
					}
					elseif($s==2)
					{
						$db->query("DELETE FROM `".$CONFIG['tablepre']."module` WHERE module='$current'");
						if(file_exists(PHPCMS_ROOT."/".$current."/install/mysql.sql"))
						{
							$sql = file_get_contents(PHPCMS_ROOT."/".$current."/install/mysql.sql");
							sql_execute($sql);
							$cache_setting = cache_read($current.'_setting.php');
							$cache_setting = addslashes(serialize($cache_setting));
							$db->query("UPDATE {$CONFIG['tablepre']}module SET setting='$cache_setting' WHERE module='$current'");
						}
						echo "<script language=\"javascript\">parent.InstallingModule.innerHTML+=' 2、正在创建数据表&nbsp;<img src=\"install/images/yes.gif\" /><br />';</script>";
					}
					elseif($s==3)
					{
						if($PHPCMS['enableftp'])
						{
							if(file_exists(PHPCMS_ROOT."/".$current."/install/chmod.txt"))
							{
								$files = file(PHPCMS_ROOT."/".$current."/install/chmod.txt");
								$files = array_filter($files);
								foreach($files as $file)
								{
									dir_chmod(PHPCMS_ROOT.'/'.trim($file));
								}
							}
						}
						echo "<script language=\"javascript\">parent.InstallingModule.innerHTML+=' 3、正在设置相关目录及文件属性&nbsp;<img src=\"install/images/yes.gif\" /><br />';</script>";
					}
					elseif($s==4)
					{
						@include PHPCMS_ROOT.'/'.$current.'/install/extension.php';
						echo "<script language=\"javascript\">parent.InstallingModule.innerHTML+=' 4、正在加载模块个性化设置&nbsp;<img src=\"install/images/yes.gif\" /><br />';</script>";
					}
					$s = $s+1;
					$n = $n+1;
					if($s>4)
					{
						//已安装的从数组中移出；
						unset($selectmod[$currentkey]);
						array_save($selectmod,'$selectmod',PHPCMS_ROOT.'/data/uninstall/phpcms/selectmod.php');	
						echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=module&n=$n&s=1');</script>";
					}
					else
					{					
						echo "<script language=\"javascript\">parent.processor.style.width='".$processwidth."px';</script>";
						echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=module&n=$n&s=".$s."');</script>";	
					}
				}
				else 
				{
					echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=user');</script>";
				}
				@unlink(PHPCMS_ROOT.'/data/install/phpcms/selectchannel.php');	
				@unlink(PHPCMS_ROOT.'/data/install/phpcms/selectmod.php');	
				break;
				
			case 'user':
				include(PHPCMS_ROOT."/include/auth.func.php");
				$user = file_get_contents(PHPCMS_ROOT.'/data/uninstall/phpcms/phpcms.php');
				$user = unserialize(phpcms_decode($user,'uninstall'));
				$db->query("INSERT INTO {$CONFIG['tablepre']}member (username,password,email,groupid,regip, regtime,chargetype) VALUES ('".$user['username']."',  '".md5($user['password'])."',  '".$user['email']."', 1,'".$_SERVER['REMOTE_ADDR']."','".time()."', 0)");
				$db->query("INSERT INTO {$CONFIG['tablepre']}member_info (userid,gender) VALUES ('1','1')");
				$db->query("INSERT INTO {$CONFIG['tablepre']}admin (userid,username,grade) VALUES ('1','".$user['username']."','0')");
				@unlink(PHPCMS_ROOT.'/data/install/phpcms/phpcms.php');	
				
				//创建快捷操作菜单
				if(file_exists(PHPCMS_ROOT."/install/main/quickmenu.sql"))
				{
					$sql = file_get_contents(PHPCMS_ROOT."/install/main/quickmenu.sql");
					sql_execute($sql);
				}
				$db->query("UPDATE {$CONFIG['tablepre']}menu SET username='$user[username]' WHERE  username!='' ");
				echo "<script language=\"javascript\">
				parent.currentmod.innerHTML='系统设置';
				parent.InstallingModule.innerHTML=' 1、管理帐号 <font color=blue>".$user['username']."</font> 建立成功&nbsp;<img src=\"install/images/yes.gif\" /><br />';
				parent.processor.style.width='350px';				
				parent.GetInstallingPage('install.php?step=installmodule&currentjob=systemcache');
				</script>";
			break;

			case 'systemcache';
				include (PHPCMS_ROOT.'/include/cache.func.php');
				cache_all();				
				echo "<script language=\"javascript\">
				parent.InstallingModule.innerHTML+=' 2、系统缓存建立成功&nbsp;<img src=\"install/images/yes.gif\" /><br />';
				parent.processor.style.width='370px';
				parent.GetInstallingPage('install.php?step=installmodule&currentjob=templatecache');
				</script>";
			break;
			
			case 'templatecache':
				include PHPCMS_ROOT.'/include/template.func.php';
				$CACHE = cache_read('common.php');
				$MODULE = $CACHE['module'];
				tags_update();
				template_cache();
				echo "<script language=\"javascript\">
				parent.InstallingModule.innerHTML+=' 3、模板缓存建立成功，标签调用缓存更新成功&nbsp;<img src=\"install/images/yes.gif\" /><br />';
				parent.processor.style.width='385px';
				parent.GetInstallingPage('install.php?step=installmodule&currentjob=index');
				</script>";
			break;
			
			case 'index':
				$content = copy(PHPCMS_ROOT."/install/cms_index.html",PHPCMS_ROOT."/index.html");
				echo "<script language=\"javascript\">
				parent.InstallingModule.innerHTML+=' 4、首页建立成功&nbsp;<img src=\"install/images/yes.gif\" />'
				parent.processor.style.width='400px';
				parent.GetInstallingPage('install.php?step=installmodule&currentjob=freelink1');
				</script>";
			break;	
			
			case 'freelink1':
				//首页幻灯片
				update_freelink('首页幻灯片');
				echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=freelink2');</script>";	
			break;

			case 'freelink2':
				//更新幻灯片
				update_freelink('首页推荐信息');
				echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=freelink3');</script>";	
			break;

			case 'freelink3':
				//首页推荐问吧
				update_freelink('首页推荐问吧');
				echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=freelink4');</script>";	
			break;

			case 'freelink4':
				//全站头部置顶
				update_freelink('全站头部置顶');
				echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=freelink5');</script>";	
			break;

			case 'freelink5':
				//3dflash
				update_freelink('3dflash');
				echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=freelink6');</script>";	
			break;

			case 'freelink6':
				//flash_下载频道首页
				update_freelink('flash_下载频道首页');
				echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=freelink7');</script>";	
			break;

			case 'freelink7':
				//flash_图片频道首页
				update_freelink('flash_图片频道首页');
				echo "<script language=\"javascript\">parent.GetInstallingPage('install.php?step=installmodule&currentjob=finish');</script>";	
			break;

			case 'finish':
				//flash_新闻频道首页
				update_freelink('flash_新闻频道首页');
				echo "<script language=\"javascript\">parent.InstallingFinish();</script>";	
			break;
				
		}//end switch
		break;
		
		
	case 'dbcheck':
		$dbhost = $_GET['dbhost'];
		$dbuser = $_GET['dbuser'];
		$dbpw = $_GET['dbpw'];
		$dbname = $_GET['dbname'];
		$tablepre = $_GET['tablepre'];
		if(!@mysql_connect($dbhost,$dbuser,$dbpw)) exit("<script>alert('无法连接到数据库服务器，请检查配置！');</script>");
		if(!@mysql_select_db($dbname))
	    {
			if(!@mysql_query("CREATE DATABASE $dbname")) exit("<script>alert('指定的数据库不存在，系统也无法创建，请先通过其他方式建立好数据库！');</script>");
			mysql_select_db($dbname);
		}
		$query = mysql_list_tables($dbname);
		while($r = mysql_fetch_row($query))
		{
			$tables[] = $r[0];
		}
		if(is_array($tables) && in_array($CONFIG['tablepre']."module",$tables))
	    {
			exit("<script>alert('您已经安装过phpcms，前缀相同系统会自动删除原来的数据！');</script>");
		}
        exit("<script>alert('数据库设置正确，可以继续安装！');</script>");
		break;
		
	case 'ftpset':
		$PHPCMS['enableftp'] = 1;
		$PHPCMS['ftphost'] = $_GET['ftphost'];
		$PHPCMS['ftpuser'] = $_GET['ftpuser'];
		$PHPCMS['ftppass'] = $_GET['ftppass'];
		$PHPCMS['ftpport'] = $_GET['ftpport'];
		$PHPCMS['ftpwebpath'] = $_GET['ftpwebpath'];
		$mode = 777;
		if(!$PHPCMS['ftphost'] || !$PHPCMS['ftpuser']) exit("<script>alert('请填写ftp服务器和ftp帐号！');</script>");
		
		require_once PHPCMS_ROOT.'/include/ftp.class.php';
		$ftp = new phpcms_ftp($PHPCMS['ftphost'], $PHPCMS['ftpuser'], $PHPCMS['ftppass'], $PHPCMS['ftpport'], $PHPCMS['ftpwebpath'], 'I', 1);
		if(!$ftp->connected) exit("<script>alert('设置错误！无法连接到FTP服务器 ');</script>");
		if(!$ftp->is_phpcms()) exit("<script>alert('网站根目录相对FTP根目录的路径设置错误！');</script>");
		
		dir_chmod(PHPCMS_ROOT.'/', $mode);		
		dir_chmod(PHPCMS_ROOT.'/uploadfile/', $mode); 
		dir_chmod(PHPCMS_ROOT.'/config.inc.php',$mode); 
		dir_chmod(PHPCMS_ROOT.'/index.html',$mode);
		dir_chmod(PHPCMS_ROOT.'/sitemap.xml',$mode);				

		dir_chmod(PHPCMS_ROOT.'/data/*', $mode);
		dir_chmod(PHPCMS_ROOT.'/templates/*', $mode);

		array_save($PHPCMS,'$PHPCMS', PHPCMS_ROOT."/data/uninstall/phpcms/ftpsetting.php");
		exit("<script>alert('目录文件可写属性设置成功！');parent.myform.dosubmit.disabled=false;</script>");
		break;


	case 'showchmodlist':

		$selectmod = isset($_POST['selectmod']) ? explode(',', $_POST['selectmod']) : array();
		$selectchannel = isset($_POST['selectchannel']) ? explode(',', $_POST['selectchannel']) : array();
		$strlist = '';

		$strlist.= "请手动设置以下目录及文件的权限为777,注意：以*结尾的目录必须同时将其所有子目录及子文件都设置<br>";
		$strlist.="./<br>";
		$strlist.="./data/*<br>"; 
		$strlist.="./templates/*<br>"; 
		$strlist.="./uploadfile/<br>"; 
		$strlist.="./config.inc.php<br>"; 
		$strlist.="./index.html<br>"; 
	
		//$selectchannel = array_keys($selectchannel);
		
		foreach($selectchannel as $installdir)
		{
			if(file_exists(PHPCMS_ROOT."/module/".$installdir."/install/chmod.txt") && ISUNIX)
			{
				$files = file(PHPCMS_ROOT."/module/".$installdir."/install/chmod.txt");
				$files = array_filter($files);
				foreach($files as $fi)
				{								
					$strlist.= './'.$fi." <br>";			
				}			
			}
		}

		//$selectmod = array_keys($selectmod);
		foreach($selectmod as $installdir)
		{
			if(file_exists(PHPCMS_ROOT."/".$installdir."/install/chmod.txt") && ISUNIX)
			{
				$files = file(PHPCMS_ROOT."/".$installdir."/install/chmod.txt");
				$files = array_filter($files);
				foreach($files as $fi)
				{								
					$strlist.= './'.$fi." <br>";			
				}			
			}
		}
		echo $strlist;
		break;
}

function dir_writable($dir)
{
	if(!is_dir($dir)) @mkdir($dir, 0777);
	return is_writable($dir);
}
?>