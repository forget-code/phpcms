<?php

//注意进行补零的操作。。。
//任务参数解析类
class Job_Parse
{
	var $jobid;
	var $mod;
	var $startstyle; //起始地址的样式
	var $Job=array(); //任务基本参数
	var $Label=array(); //标签规则基本参数
	
	//-------------------------------
	//从数据库里载入某个任务
	//-------------------------------
	function GetJobInfo($jd)
	{
		global $db;
		$this->jobid = $jd;
		$this->Job=$db->get_one("SELECT * FROM ".TABLE_SPIDER_JOB." WHERE JobId='".$jd."'");	
		if(is_array($this->Job))
		{
			if(strpos($this->Job["StartUrl"],"\n")<1 && strpos($this->Job["StartUrl"],'(*)')<1) //单条形式
			{ 
				$this->startstyle=0;
				$this->Job["url"]=array($this->Job["StartUrl"]); 
			}
			else if(strpos($this->Job["StartUrl"],"\n")>1) ////多条形式
			{ 
				$this->startstyle=1;
				$this->Job["url"]=explode("\n",$this->Job["StartUrl"]);
				if(is_array($this->Job["url"])) 
				$filter=array_filter($this->Job["url"]);
				foreach ($filter as $k=>$u)
				$filter[$k]=str_replace("\r","",$u);
				
				$this->Job["url"]=$filter;
			}
			elseif(strpos($this->Job["StartUrl"],'(*)')>1) //相似网址形式
			{ 
				$this->startstyle=2;
				$su=explode("♀",$this->Job["StartUrl"]);
				if(isset($su[1]))
					$sn=explode(",",$su[1]);
				$urlid = 0;
				if($sn[3]=="true")
				{
					for($n =$sn[1];$n>=$sn[0];$n--)
					{
						$this->Job["url"][$urlid] = str_replace("(*)",$n*$sn[2],$su[0]);
						$urlid++;
					}	
				}
				else
				 {
					for($n =$sn[0];$n<=$sn[1];$n++)
					{
						$this->Job["url"][$urlid] = str_replace("(*)",$n*$sn[2],$su[0]);
						$urlid++;
					}	
				}
			}
			$this->GetRuleInfo();	//只在该函数内调用，先获取任务基本参数，再获取相关的规则参数
		}
		else
			return 'not catch any information';
	}
	
	//----------------------------
	//从配置文件中得到Rule的标签规则
	//----------------------------
	function GetRuleInfo()
	{
		include MOD_ROOT.'/rules/'.$this->jobid.'.php';
		$this->Label=$rule;
	}
	
	//----------------------------
	//回调函数，去掉空值
	//----------------------------
	function FilterNull($url)
	{
		if(!isset($url)) return false;
		return trim($url) ? true : false;
	}
	
	//----------------------------
	//释放资源
	//----------------------------	
	function Dispose()
	{
		unset($this->Job);
		unset($this->Label);
	}
}
?>