<?php
require PHPCMS_ROOT.'/include/httpdown.class.php';
require MOD_ROOT.'/admin/html_parse.class.php';
require MOD_ROOT.'/admin/tag_parse.class.php';
require MOD_ROOT.'/admin/job_parse.class.php';
include_once PHPCMS_ROOT.'/include/get_remotefiles.func.php';
include_once PHPCMS_ROOT.'/include/charset.func.php';

@set_time_limit(0);

class MainSpider
{
	var $Article = Array();
	var $JobId = '';
	var $CJob;
	var $mod;
	var $CTagHtml = '';
	var $CFileGetContent = '';
	var $dividePageHtml = '';
	var $tid=0;
	//---------------------------
	//初始化
	//---------------------------
	function Init(){
		$this->CFileGetContent=new httpdown();
		$this->CJob =new Job_Parse();
		$this->CJob->mod = $this->mod;
		$this->CJob->GetJobInfo($this->JobId);
	}
	//---------------------------
	//析放资源
	//---------------------------
	function Close(){
		unset($this->Article);
		unset($this->CJob);
	}

	//---------------------
	//测试列表
	//---------------------
	function TestRules()
	{
		global $CONFIG,$LANG;
		$return="<table width=\"100%\"  border=\"0\">";
		if(isset($this->CJob->Job["url"][$this->tid])) $dourl = $this->CJob->Job["url"][$this->tid];
		else
		{
			$return.="<tr><td colspan=2>".$LANG['have_appoint_start_url']."</td></tr>\n";
			$return.="</table>";
			echo $return;
		}
		$htmlp = new Html_Parse();
		$htmlp->GetLinkType = "link";
		$basehref = '';
		$fgc = new httpdown();
		if($this->CJob->Job['Cookie']) $fgc->puthead["Cookie"] = $this->CJob->Job['Cookie'];
		$fgc->OpenUrl(trim($dourl));
		$html = $fgc->GetHtml();
		$fgc->Close();
		$basehref = get_basehref($html);
		$htmlp->GetLinkType = "link";
		if($html == '')
		{
			$return.= "<tr><td  colspan=2>".$LANG['request_to_url'].$dourl.$LANG['not_receive_any_response']."</td></tr>\n";
			$return.= "</table>";
			echo $return;
		}
		//在某一个区域内采集
		if(!empty($this->CJob->Job['ListUrlStart'])&&!empty($this->CJob->Job['ListUrlEnd']))
		{
			$pos = strpos($html,$this->CJob->Job['ListUrlStart']);
			$endpos = strpos($html,$this->CJob->Job['ListUrlEnd'],$pos);
			$v = '';
			if($endpos>$pos && $pos>0)
			{
				$v = substr($html,$pos+strlen($this->CJob->Job['ListUrlStart']),$endpos-$pos-strlen($this->CJob->Job['ListUrlStart']));
			}
			if($v!='')
				$htmlp->SetSource($v,$dourl,false);			
		}
		else 		
			$htmlp->SetSource($html,$dourl);
		$testpage = '';
		$urlSerial=0;
		if(is_array($htmlp->Links))
		{
			$return.="<tr><td colspan=2>".$LANG['url_'].$dourl .$LANG['fetched_url']."</td></tr>\n";
			foreach($htmlp->Links as $k=>$v)
			{
				//下面进行编码转化
				if($this->CJob->Job['SourceEncode']==1) $sourcecharset = "utf8";
				else if($this->CJob->Job['SourceEncode']==2) $sourcecharset = "big5";
				else $sourcecharset="gbk"; 		
				$phpcmschartset = ($CONFIG['charset']=='') ? "gbk" : $CONFIG['charset'];
				$k = convert_encoding($sourcecharset,$phpcmschartset,$k);
				$v = convert_encoding($sourcecharset,$phpcmschartset,$v);	
				$k =  $htmlp->FillUrl($k,$basehref);
				if($this->CJob->Job["ContentPageMust"]!= '')
				{
					if(eregi($this->CJob->Job["ContentPageMust"],$k))
					{
						if($this->CJob->Job["ContentPageForbid"]=='')
						{
							$return.="<tr><td><font color=blue>".++$urlSerial."</font> <a href='$k' target='_blank' id='url".$urlSerial."' >$k</a> 【".$v."】</td><td width=\"70\"><a href=\"javascript:TestContentById(".$urlSerial.")\">".$LANG['test_this_page']."</a></td></tr>\n";
						}
						else if(!eregi($this->CJob->Job["ContentPageForbid"],$k))
						{
							$return.= "<tr><td><font color=blue>".++$urlSerial."</font> <a href='$k' target='_blank'  id='url".$urlSerial."' >$k</a> 【".$v."】</td><td width=\"70\"><a href=\"javascript:TestContentById(".$urlSerial.")\">".$LANG['test_this_page']."</a></td></tr>\n";
						}
					}
				}
				else
				{
					$return.= "<tr><td><font color=blue>".++$urlSerial."</font> <a href='$k' target='_blank'  id='url".$urlSerial."'  >$k</a> 【".$v."】</td><td width=\"70\"><a href=\"javascript:TestContentById(".$urlSerial.")\">".$LANG['test_this_page']."</a></td></tr>\n";
				}
			}
		}
		else
		{
			$return.= "<tr><td colspan=2>".$LANG['not_fetched_any_useable_link_from_appoint_url']."</td></tr>\n";
			return $return;
		}
		$htmlp->Clear();
		$return.="</table>";
		echo $return;
	}

	function regexEncode($str)
	{
		$str=str_replace("\\","\\\\",$str);//这个要先替换。。不然出现\又被替换了
		$str=str_replace(".","\.",$str);
		$str=str_replace("[","\[",$str);
		$str=str_replace("]","\]",$str);
		$str=str_replace("(","\(",$str);
		$str=str_replace(")","\)",$str);
		$str=str_replace("?","\?",$str);
		$str=str_replace("+","\+",$str);
		$str=str_replace("*","\*",$str);
		$str=str_replace("^","\^",$str);
		$str=str_replace("{","\{",$str);
		$str=str_replace("}","\}",$str);
		$str=str_replace("$","\$",$str);
		$str=str_replace("|","\|",$str);
		$str=str_replace("/","\/",$str);
		$str=str_replace("\(\*\)","[\s\S]*?",$str);
		return $str;
	}

	//
	//按载入的网页内容获取规则，从一个HTML文件中获取内容
	//
	function GetLabelsContent($html,$dourl,$down=false)
	{	
		set_time_limit(0);
		global $PHP_DOMAIN,$CONFIG,$LANG;	
		if($html == '') return '';
		$basehref = get_basehref($html);
		$artitem = '';
		$isPutUnit = false;
		$keys = array_keys($this->CJob->Label['LabelName']);
		$num = count($keys);
		for($i=0; $i<$num; $i++)
		{
			$pos = 0;
			$endpos = 0;
			$v = '';
			$sarr_start = '';
			$sarr_end = '';
			$sarr_start=$this->regexEncode($this->CJob->Label['StartStr'][$keys[$i]]);
			$sarr_end=$this->regexEncode($this->CJob->Label['EndStr'][$keys[$i]]);
			//内容分页处理
			if(!empty($this->CJob->Job['DividePageStart'])&&!empty($this->CJob->Job['DividePageEnd'])&&$this->CJob->Label['LabelName'][$keys[$i]]==$LANG['content'])
			{
				$pagestart = $this->regexEncode($this->CJob->Job['DividePageStart']);
				$pageend = $this->regexEncode($this->CJob->Job['DividePageEnd']);
				$regexStr = "/".$pagestart."([\s\S]*?)".$pageend."/";
				$regexnum = preg_match($regexStr,$html,$matches);
				$p = $matches[1];
				unset($matches);
				
				$p = trim($p);
				if($p!='')
				{
					$p = "-".$p;
					$htmlp = new Html_Parse();
					$htmlp->GetLinkType = "link";
					$htmlp->SetSource($p,$dourl,false);
					foreach($htmlp->Links as $k=>$v)
					{
						$k = $htmlp->FillUrl($k,$basehref);
							
						if($k==$dourl) continue;
						if($this->CJob->Job['Cookie']) $this->CFileGetContent->puthead["Cookie"]=$this->CJob->Job['Cookie'];
						$this->CFileGetContent->OpenUrl($k);
						$nhtml = $this->CFileGetContent->GetHtml();		
						if($nhtml!='')
						{
							$this->dividePageHtml .= "[next]".$this->GetOneField($nhtml,$k,$sarr_start,$sarr_end,$pagestart,$pageend);
						}
					}					
				}
			}		
			//处理各个标签，包括自定义标签
			if(!empty($sarr_start) && !empty($sarr_end))
			{	
				//得到标签信息			
				$regex = "/".$sarr_start."([\s\S]*?)".$sarr_end."/";
				preg_match($regex,$html,$matchess);
				if(count($matchess)<2) return $v='';
				else $v = $matchess[1];	
				
				if($v!='')
				{
					if($this->dividePageHtml && $this->CJob->Label['LabelName'][$keys[$i]] == $LANG['content'])//只有内容才可以分页
					{
						 $v = preg_replace("/".$pagestart."([\s\S]*)".$pageend."/",'',$v); //得到第一页的
						 $v.= $this->dividePageHtml; //连接所有分页
					}			
					//进行替换排除
					if(!empty($this->CJob->Label['TrimStart'][$keys[$i]]))
					{
						$strArrStart=explode("(|)",$this->CJob->Label['TrimStart'][$keys[$i]]);
						$strArrEnd=explode("(|)",$this->CJob->Label['TrimEnd'][$keys[$i]]);
	
						if(count($strArrStart)>0)  //开始正则内容替换
						{
							$num = count($strArrStart);
							for($y=0; $y<$num; $y++)
							{
								$regexTrimRelaceStar = '|'.$this->regexEncode($strArrStart[$y]).'|';
								$v = preg_replace($regexTrimRelaceStar,$strArrEnd[$y],$v) . "\r\n";
							}
						}
					}

					//下面排除HTML代码
					if(isset($this->CJob->Label['HtmlTrim'][$keys[$i]]))
					$v = $this->HtmlTrim($v,$this->CJob->Label['HtmlTrim'][$keys[$i]]);
					//替换所有相对地址为绝对地址
					$v = get_remotefiles($v,'',$dourl,$basehref,false); //不下载其中常见的几样
					
					//下载远程文件				
					if($down)
					{
						$downtype='';
						$notdowntype='';
						if($this->CJob->Job['DownImg']==1) //获取远程图片
						{
							if($this->CJob->Label['LabelName'][$keys[$i]]==$LANG['content'])
							{
								@set_time_limit(300);
	            				$downtype.="gif|jpg|jpeg|bmp|png";
							}
						}
						if($this->CJob->Job['DownSwf']==1) //获取远程Flash
						{
							if($this->CJob->Label['LabelName'][$keys[$i]]==$LANG['content'])
							{
								@set_time_limit(300);
								$downtype.=($downtype=='')?"swf|flv":"|swf|flv";            			
							}
						}
						if($this->CJob->Job['DownOther']==1) //获取远程Flash
						{
							if($this->CJob->Label['LabelName'][$keys[$i]]==$LANG['content'])
							{
								@set_time_limit(300);
								$downtype.=($downtype=='')?$this->CJob->Job['OtherFileType']:"|".$this->CJob->Job['OtherFileType'];            			
							}
						}
						if($downtype) $v = get_remotefiles($v,"gif|jpg|jpeg|bmp|png",$dourl,$basehref,true);
					}				
					$v = trim($v);
					$v = preg_replace("/\r\n{2,}/","\r\n",$v);//多个\r\n替换为2个
					if(($this->CJob->Label['LabelName'][$keys[$i]] == $LANG['title'] || $this->CJob->Label['LabelName'][$keys[$i]] == $LANG['content']) && $v=='')
					{
						$v = $LANG['title_or_content_null'];
						return $v;
					}
			
					//编码转换
					if($this->CJob->Job['SourceEncode']==1) $sourcecharset="utf8";
					else if($this->CJob->Job['SourceEncode']==2) $sourcecharset="big5";
					else $sourcecharset="gbk"; 				
					$phpcmschartset = ($CONFIG['charset']=='') ? "gbk":$CONFIG['charset'];
					$v = convert_encoding($sourcecharset,$phpcmschartset,$v);
				}				
				$artitem .= "【".$LANG['label'].":".$this->CJob->Label['LabelName'][$keys[$i]]."】:".$v;
				if($down==true) $artitem.="【/".$LANG['label']."】\r\n";
				else $artitem.="\r\n";
			}
			else
			{
				$artitem .= "【".$LANG['label'].":".$this->CJob->Label['LabelName'][$keys[$i]]."】:".$LANG['null'];
				if($down==true) $artitem.="【/".$LANG['label']."】\r\n";
				else $artitem.="\r\n";
			}
		}
		return $artitem;
	}

	//测试文章规则
	function TestArtical($dourl)
	{
		global $LANG;
		if($dourl=='')
		{
			echo $LANG['input_the_test_page'];
			exit;
		}
		$fgc = new httpdown();
		if($this->CJob->Job['Cookie']) $fgc->puthead["Cookie"]=$this->CJob->Job['Cookie'];
		$fgc->OpenUrl($dourl);
		$html = $fgc->GetHtml();
		$fgc->Close();
		echo "<textarea cols=\"60\" rows=\"27\" id='ContentArea'>";
		echo $this->GetLabelsContent($html,$dourl,false);
		echo "</textarea>";
	}
	
	/**
	 * 采集网址...
	 *
	 * @param unknown_type $uid   列表的ID
	 * @param unknown_type $auto   是否自动跳转到下一页面
	 * @return unknown
	 */
	function SpiderAllUrlById($uid,$auto,$totalurlcount,$totalurlnorepeatcount=0)
	{
		global $db,$CONFIG,$LANG;
		if($this->CFileGetContent=='') 
				$this->CFileGetContent = new httpdown();
		if($this->CTagHtml=='') 
				$this->CTagHtml = new Html_Parse();
		$this->CTagHtml->GetLinkType = "link";
		$tmplink = array();
		$totalnum=count($this->CJob->Job["url"]);
		$return='';
		if($uid>=$totalnum)
		{
			$return.= "<br><font color=blue>".$LANG['analysic_to_end_of_the_list_total_fetched'].$totalurlcount.$LANG['article_link_remove_repeat_get_valid_url'].$totalurlnorepeatcount.$LANG['one']."<br><br/></font>\r\n";
			$return.= "&nbsp;&nbsp;".$LANG['select_operation_below']."<br><br/>\r\n";
			$return.= "&nbsp;&nbsp;".$LANG['direct_to_next_step']." <a href='?mod=$this->mod&file=collect&action=collectcontent&jobid=$this->JobId'><font color='blue'>".$LANG['spider_content']."</font></a><br><br/>\r\n";
			$return.= "&nbsp;&nbsp;".$LANG['verify_url_fetch_by_current_job']." <a href='?mod=$this->mod&file=collect&action=manage&jobid=$this->JobId'><font color='blue'>".$LANG['view_content']."</font></a><br><br/>\r\n";
			$return.= "&nbsp;&nbsp;".$LANG['verify_url_fetch_by_all_job']." <a href='?mod=$this->mod&file=collect&action=manage'><font color='blue'>".$LANG['view_all']."</font></a><br><br/>\r\n";
		}
		else
		{
			$pageurl=$this->CJob->Job["url"][$uid];
			$return.= "<br><font color=blue>".$LANG['connect_to_list_page']."(<b>No.".($uid+1)."</b>): $pageurl  ".$LANG['analysing']."<br><br/></font>\r\n";
			
			if($this->CJob->Job['Cookie']) $this->CFileGetContent->puthead["Cookie"]=$this->CJob->Job['Cookie'];	
			$this->CFileGetContent->OpenUrl($pageurl);
			$html = $this->CFileGetContent->GetHtml();
			$this->CFileGetContent->Close();
			$this->CTagHtml->GetLinkType = "link";
			$basehref = get_basehref($html);

			if(!empty($this->CJob->Job['ListUrlStart'])&&!empty($this->CJob->Job['ListUrlEnd']))
			{
				$pos = strpos($html,$this->CJob->Job['ListUrlStart']);
				$endpos = strpos($html,$this->CJob->Job['ListUrlEnd'],$pos);
				if($endpos>$pos && $pos>0)
				{	$v = substr($html,$pos+strlen($this->CJob->Job['ListUrlStart']),$endpos-$pos-strlen($this->CJob->Job['ListUrlStart'])); }
				if($v!='')
					$this->CTagHtml->SetSource($v,$pageurl,false);			
			}
			else
				$this->CTagHtml->SetSource($html,$pageurl);
				
			if(is_array($this->CTagHtml->Links))
			foreach($this->CTagHtml->Links as $url=>$title)
			{
				//encode...
				$url = $this->CTagHtml->FillUrl($url,$basehref);
				if($this->CJob->Job["ContentPageMust"]!='')
				{
					if(eregi($this->CJob->Job["ContentPageMust"],$url))
					{
						if($this->CJob->Job["ContentPageForbid"]=='')
						{
							$tmplink[$url] = $title;
						}
						else if(!eregi($this->CJob->Job["ContentPageForbid"],$url))
						{	
							$tmplink[$url] = $title;
						}
					}
				}
				else
				{
					$tmplink[$url] = $title;
				}
			}
			$this->CTagHtml->Clear();
			
			$unum = count($tmplink);
			$d=0;
			$re=0;//非重复数
			foreach($tmplink as $keys=>$values)
			{
				//下面进行编码转化
				if($this->CJob->Job['SourceEncode']==1) $sourcecharset="utf8";
				else if($this->CJob->Job['SourceEncode']==2) $sourcecharset="big5";
				else $sourcecharset="gbk"; 		
				$phpcmschartset = ($CONFIG['charset']=='') ? "gbk" : $CONFIG['charset'];
				$keys = convert_encoding($sourcecharset,$phpcmschartset,$keys);
				$values = convert_encoding($sourcecharset,$phpcmschartset,$values);				
				$d++;
				$return.= "&nbsp;<font color=red>".$d."</font>&nbsp;".$keys."  【".$values."】 <br>";
				$qu = $db->query("Select PageUrl from ".TABLE_SPIDER_URLS." where PageUrl='".$keys."'");
				if($db->num_rows($qu)<1)
				{
					$re++;
					$db->query("Insert Into ".TABLE_SPIDER_URLS." (JobId,Title,PageUrl,CreateOn,Spidered) values(".$this->JobId.",'".addslashes($values)."','".addslashes($keys)."',".time().",0)");
				}
			}
			if($unum>0)
			{
				$totalurlcount = $totalurlcount + $unum;
				$totalurlnorepeatcount = $totalurlnorepeatcount + $re;
				$return.="<br><font color=blue>".$LANG['finish_spider_in_current_page_generate'].$unum." ".$LANG['records_repeat_num'].($unum-$re).$LANG['valid_url'].$re.$LANG['one']." <br/><font>\r\n";		
				if($auto) $return.="<script language=\"javascript\">parent.GotoPageByNext(\"Next\",$totalurlcount,$totalurlnorepeatcount);</script>";	
			}
			else
			{
				$return.="<br><font color=blue>".$LANG['current_page_url']."[".$this->CJob->Job["url"][$uid]."]".$LANG['not_fetched_any_valid_link']."</font>";
				if($auto) $return.="<script language=\"javascript\">parent.GotoPageByNext(\"Next\",$totalurlcount,$totalurlnorepeatcount);</script>";	
			}
		}
		return $return;
	}
	
	//-----------------------------
	//获取一篇文章
	// aid:文章在url表中的序号，dourl文章原地址
	//-----------------------------
	function GetOneContent($aid,$dourl)
	{
		global $db,$LANG;
		if($this->CFileGetContent == '') $this->CFileGetContent = new httpdown();
		if($this->CJob->Job['Cookie']) $this->CFileGetContent->puthead["Cookie"]=$this->CJob->Job['Cookie'];
		$this->CFileGetContent->OpenUrl($dourl);
		$html = $this->CFileGetContent->GetHtml();
		$this->CFileGetContent->Close();
		
		$body = $this->GetLabelsContent($html,$dourl,true);
		if($body!=$LANG['title_or_content_null'])
		{
			$db->query("Update ".TABLE_SPIDER_URLS." Set SpiderOn='".time()."',Content='".addslashes($body)."',Spidered=1 where Id=".$aid);
		}
		$body = '';
		$html = '';
		return $body;
	}
	
	//--------------------------------
	//获得网页指定field的内容
	//--------------------------------
	function GetOneField($html,$dourl,$startstr,$endstr,$pagestart,$pageend)
	{
		if($html == '') return '';
		$regexStr = "/".$startstr."([\s\S]*?)".$endstr."/";
		$regexnum = preg_match($regexStr,$html,$matches);
		$v = $matches[1];
		$v = trim($v);		
		$v = preg_replace("/".$pagestart."([\s\S]*)".$pageend."/",'',$v);
		return $v;
	}

	function HtmlTrim($strHtml,$serial) 
	{
		if($serial!='')
		{
			$ids = explode(',',$serial);//获取要排除html代码的序号
			$aryReg =array(
						  "/<a[^>]*?>([\s\S]*?)<\/a>/i",
						  "/<br[^>]*?>/i",
						  "/<table[^>]*?>([\s\S]*?)<\/table>/i",
						  "/<tr[^>]*?>([\s\S]*?)<\/tr>/i",
						  "/<td[^>]*?>([\s\S]*?)<\/td>/i",
						  "/<p[^>]*?>([\s\S]*?)<\/p>/i",
						  "/<font[^>]*?>([\s\S]*?)<\/font>/i",
						  "/<div[^>]*?>([\s\S]*?)<\/div>/i",
						  "/<span[^>]*?>([\s\S]*?)<\/span>/i",
						  "/<tbody[^>]*?>([\s\S]*?)<\/tbody>/i",
						  "/<([\/]?)b>/i",								  
						  "/<img[^>]*?>/i",
						  "/[&nbsp;]{2,}/i",
						  "/<script[^>]*?>([\w\W]*?)<\/script>/i",
						  );
			$aryRep = array(
						   "\\1",
						   "",
						   "\\1",
						   "\\1",
						   "\\1",
						   "\\1",
						   "\\1",
						   "\\1",
						   "\\1",
						   "\\1",
						   "",								   
						   "",
						   "&nbsp;",
						   "\\1",
						   );
			$strOutput = $strHtml;
			foreach($ids as $id)
			{
				$strOutput = preg_replace($aryReg[$id],$aryRep[$id],$strOutput);
			}
			return $strOutput;
		}
		else
		{
			return $strHtml;
		}
	}		
}


//获取basehref_url值
function get_basehref($html)
{
	return preg_match("/<base[\s]+href=([\"|']?)([^ \"'>]+)\\1/i",$html,$matches) ? $matches[2] : '';
}
?>