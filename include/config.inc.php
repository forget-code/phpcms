<?php
//数据库配置信息
define('DB_HOST', 'localhost'); //数据库服务器主机地址
define('DB_USER', 'root'); //数据库帐号
define('DB_PW', ''); //数据库密码
define('DB_NAME', ''); //数据库名
define('DB_PRE', 'phpcms_'); //数据库表前缀，同一数据库安装多套Phpcms时，请修改表前缀
define('DB_CHARSET', 'utf8'); //数据库字符集
define('DB_PCONNECT', 0); //0 或1，是否使用持久连接
define('DB_DATABASE', 'mysql'); //数据库类型

//网站路径配置
define('PHPCMS_PATH', '/'); //Phpcms框架访问路径，相对于域名

//shtml 支持
define('SHTML', 0); //是否支持 shtml，需要服务器支持，并且生成文件扩展名为 shtml

//数据存文本目录
define('CONTENT_ROOT', PHPCMS_ROOT.'data/txt/'); //默认存储路径

//缓存配置
define('CACHE_STORAGE', 'files'); //Cache 存储方式（files, mysql, apc, eaccelerator, memcache, shmop）
define('CACHE_PATH', PHPCMS_ROOT.'data/cache/'); //缓存默认存储路径
define('CACHE_MODEL_PATH', PHPCMS_ROOT.'data/cache_model/'); //模型缓存存储路径

//页面缓存配置
define('CACHE_PAGE', 0); //是否开启PHP页面自动缓存功能
define('CACHE_PAGE_PATH', PHPCMS_ROOT.'data/cache_page/'); //缓存存储路径
define('CACHE_PAGE_TTL', 3600); //秒，缓存默认生命周期
define('CACHE_PAGE_INDEX_TTL', 300); //秒，缓存默认生命周期
define('CACHE_PAGE_CATEGORY_TTL', 600); //秒，缓存默认生命周期
define('CACHE_PAGE_LIST_TTL', 900); //秒，缓存默认生命周期
define('CACHE_PAGE_CONTENT_TTL', 14400); //秒，缓存默认生命周期

//Session配置
define('SESSION_STORAGE', 'mysql'); //Session 存储方式（files, mysql, apc, eaccelerator, memcache, shmop）
define('SESSION_TTL', 1800); //Session 生命周期（秒）
define('SESSION_SAVEPATH', PHPCMS_ROOT.'/data/sessions/'); //Session 保存路径（files）
define('SESSION_N', 0); //Session 文件分布的目录深度（files）

//MemCache服务器配置
define('MEMCACHE_HOST', 'localhost'); //MemCache服务器主机
define('MEMCACHE_PORT', 11211); //MemCache服务器端口
define('MEMCACHE_TIMEOUT', 1); //S，MemCache服务器连接超时

//Cookie配置
define('COOKIE_DOMAIN', ''); //Cookie 作用域
define('COOKIE_PATH', '/'); //Cookie 作用路径
define('COOKIE_PRE', ''); //Cookie 前缀，同一域名下安装多套Phpcms时，请修改Cookie前缀
define('COOKIE_TTL', 0); //Cookie 生命周期，0 表示随浏览器进程

//模板相关配置
define('TPL_ROOT', PHPCMS_ROOT.'templates/'); //模板保存物理路径
define('TPL_NAME', 'default'); //当前模板方案目录
define('TPL_CSS', 'default'); //当前样式目录
define('TPL_CACHEPATH', PHPCMS_ROOT.'data/cache_template/'); //模板缓存物理路径
define('TPL_REFRESH', 1); //是否开启模板缓存自动刷新

//附件相关配置
define('UPLOAD_FRONT', 1); //是否允许前台上传附件
define('UPLOAD_ROOT', PHPCMS_ROOT.'uploadfile/'); //附件保存物理路径
define('UPLOAD_URL', 'uploadfile/'); //附件目录访问路径
define('UPLOAD_ALLOWEXT', 'doc|docx|xls|ppt|wps|zip|rar|txt|jpg|jpeg|gif|bmp|swf|png'); //允许上传的文件后缀，多个后缀用“|”分隔
define('UPLOAD_MAXSIZE', 1024000); //允许上传的附件最大值
define('UPLOAD_MAXUPLOADS', 100); //前台同一IP 24小时内允许上传附件的最大个数
define('UPLOAD_FUNC', 'copy'); //文件上传函数（copy, move_uploaded_file）

//Ftp相关配置
define('FTP_ENABLE', 0); //Ftp主机
define('FTP_HOST', '127.0.0.1'); //Ftp主机
define('FTP_PORT', '21'); //Ftp端口
define('FTP_USER', ''); //Ftp帐号
define('FTP_PW', ''); //Ftp密码
define('FTP_PATH', '/'); //Ftp默认路径

define('CHARSET', 'utf-8'); //网站字符集
define('TIMEZONE', 'Etc/GMT-8'); //网站时区（只对php 5.1以上版本有效），Etc/GMT-8 实际表示的是 GMT+8
define('DEBUG', 1); //是否显示调试信息
define('ADMIN_LOG', 0); //是否记录后台操作日志
define('ERRORLOG', 0); //是否保存错误日志
define('FILTER_ENABLE', 1); //非法信息屏蔽作用范围（0 禁用，1 前台，2 全站）
define('GZIP', 0); //是否Gzip压缩后输出
define('AUTH_KEY', ''); //Cookie密钥
define('PASSWORD_KEY', ''); //会员密码密钥，为了加强密码强度防止暴力破解，不可更改
define('MEMBER_FIELDS', 'username,password,groupid,email,areaid,amount,point,modelid,message'); //默认读取的会员全局变量字段
define('ALLOWED_HTMLTAGS', '<a><p><br><hr><h1><h2><h3><h4><h5><h6><font><u><i><b><strong><div><span><ol><ul><li><img><table><tr><td><map>'); //前台发布信息允许的HTML标签，可防止XSS跨站攻击
define('LANG', 'zh-cn'); //网站语言包

define('ADMIN_FOUNDERS', '1'); //网站创始人ID，多个ID逗号分隔

//安全相关配置
define('FILE_MANAGER', '0'); // 是否允许使用文件管理器 1=是 0=否[安全]
define('ACTION_TEMPLATE', '1'); //是否允许使用模板修改 1=是 0=否[安全]
define('EXECUTION_SQL', '0'); //是否允许执行SQL        1=是 0=否[安全]
?>