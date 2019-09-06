<?php
/*
' * ------------------------------------------------------------
' *	版权所有 2005 XingWorld.Net 保留所有版权
' * ------------------------------------------------------------
' *	主要功能:
' *		生成 Vsid
' *
' *
' * ------------------------------------------------------------
' *	更新历史:
' *		Jun 21,2005	[V1.0] 刘其星 创建
' *		Oct 30,2005	[V2.0] 增加远程 IP 地址的参数
' *				       需要 VirtualWall.dll 2.1.6.1037 及以上版本支持
' *		Sep 18,2006	[V4.0] 刘其星 增加 VSID 随机变化的功能
' *		Oct 21,2006	[V5.0] 刘其星 增加 getvsidex 函数
' *
' * ------------------------------------------------------------
' */


//--------------------------------------------------
// 请修改您的共用钥匙
//--------------------------------------------------
define( 'CONST_PUBKEY',		$MOD['auth_key']);	// Vsid 的公共钥匙（请与远程服务器相同）
define( 'CONST_PUBKEYTIME',	0 );		// Vsid 的有效时间（请与远程服务器相同）
define( 'CONST_PUBKEYTYPE',	1 );		// Vsid 计算类型：0为普通，1为随机变化，2为文件名附加模式
define( 'CONST_TIMESPAN',	0 );		// 该值是本台服务器比远程服务器时间上慢的秒数
define( 'CONST_DOMAIN',		'xxx.com');	// [仅在使用COOKIE时设置]这里设置您网站的域名，例如：www.fangdaolian.com，您应该设置：fangdaolian.com；详细请见下面“使用示例 [1]”

//------------------------------------------------------------
//	获取 vsid
//------------------------------------------------------------
function getvsid( $strFileName = "" )
{
	/*
		strFileName	- [in] 文件名。注意：大小写敏感
		RETURN		- VSID
	*/

	$strRand	= "";
	$dwSecs		= 0;
	$dwNowSecs	= 0;
	$strString	= 0;

	$strRemoteAddr	= $_SERVER["REMOTE_ADDR"];
	$nYear		= date("Y");
	$nMonth		= date("n");
	$nDay		= date("j");
	$nHour		= date("G");
	$nMin		= date("i");
	$nSec		= date("s");
	
	$strRand	= rand( 100000, 999999 );

	if ( CONST_PUBKEYTIME > 0 )
	{
		$dwSecs	= ( $nHour * 60 * 60 ) + ( $nMin * 60 ) + $nSec + CONST_TIMESPAN;
		$dwNowSecs = round( $dwSecs / CONST_PUBKEYTIME );
	
		// 编码之前的串
		$strString = $nYear . "-" . $nMonth . "-" . $nDay . " " . $dwNowSecs . CONST_PUBKEY;
	}
	else
	{
		// 编码之前的串
		$strString = $strRemoteAddr . "-" . CONST_PUBKEY;
	}

	//
	//	Md5 编码后的串
	//
	if ( 1 == CONST_PUBKEYTYPE )
	{
		//	Random
		return $strRand . substr( md5( $strRand . $strString ), 6 );
	}
	else if ( 2 == CONST_PUBKEYTYPE )
	{
		//	FileName method
		return md5( $strString . "-" . $strFileName );
	}
	else
	{
		return md5( $strString );
	}
}

function VwUrlEncode( $szTarget )
{
	return str_replace( "%3A//", "://", str_replace( "%3D", "=", str_replace( "%3F", "?", str_replace( "%2F", "/", str_replace( "%2E", ".", str_replace( "+", "%20", urlencode( $szTarget ) ) ) ) ) ) );
}

//------------------------------------------------------------
//	获取 vsid(扩展函数)
//------------------------------------------------------------
function getvsidex( $strFilePath )
{
	/*
		strFileName	- [in] 文件名。注意：大小写敏感
		RETURN		- VSID
	*/

	$strFileName	= '';
	$strVsid	= '';

	$uPos = strrpos( $strFilePath, "/" );
	if ( $uPos )
	{
		$strFileName	= substr( $strFilePath, $uPos+1 );
	}
	$strFileName	= substr( VwUrlEncode( $strFileName ), 0, 31 );
	$strVsid	= getvsid( $strFileName );

	if ( strstr( $strFilePath, "?" ) )
	{
		return VwUrlEncode( $strFilePath ) . "&vsid=" . $strVsid;
	}
	else
	{
		return VwUrlEncode( $strFilePath ) . "?vsid=" . $strVsid;
	}
}
?>