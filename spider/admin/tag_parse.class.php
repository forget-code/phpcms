<?php

class Tag_Parse
{
	var $SourceString = '';
	var $SourceMaxSize = 1024;
	var $CharToLow = FALSE;  //属性值是否不分大小写(属性名统一为小写)
	var $IsTagName = TRUE; //是否解析标记名称
	var $Count = -1;
	var $Items = ''; //属性元素的集合
	//设置属性解析器源字符串
	function SetSource($str='')
	{
		$this->Count = -1;
		$this->Items = '';
		$strLen = 0;
		$this->SourceString = trim(preg_replace("/[ \t\r\n]{1,}/"," ",$str));
		$strLen = strlen($this->SourceString);
		$this->SourceString .= ' '; //增加一个空格结尾,以方便处理没有属性的标记
		if($strLen>0&&$strLen<=$this->SourceMaxSize)
		{
			$this->ParseAttribute();
		}
	}
	//获得某个属性
	function GetAtt($str)
	{
		if($str=='') return '';
		$str = strtolower($str);
		if(isset($this->Items[$str])) return $this->Items[$str];
		else return '';
	}
	//判断属性是否存在
	function IsAtt($str)
	{
		if($str=='') return false;
		$str = strtolower($str);
		if(isset($this->Items[$str])) return true;
		else return false;
	}
	//获得标记名称
	function GetTagName()
	{
		return $this->GetAtt("tagname");
	}
	// 获得属性个数
	function GetCount()
	{
		return $this->Count+1;
	}
	//解析属性(仅给SetSource调用)
	function ParseAttribute()
	{
		$d = '';
		$tmpatt='';
		$tmpvalue='';
		$startdd=-1;
		$ddtag='';
		$strLen = strlen($this->SourceString);
		$j = 0;
		//这里是获得标记的名称
		if($this->IsTagName)
		{
			//如果属性是注解，不再解析里面的内容，直接返回
			if(isset($this->SourceString[2]))
			{
				if($this->SourceString[0].$this->SourceString[1].$this->SourceString[2]=="!--")
				{ $this->Items["tagname"] = "!--"; return ;}
			}
			//
			for($i=0;$i<$strLen;$i++)
			{
				$d = $this->SourceString[$i];
				$j++;
				if(ereg("[ '\"\r\n\t]",$d))
				{
					$this->Count++;
					$this->Items["tagname"]=strtolower(trim($tmpvalue));
					$tmpvalue = ''; break;
				}
				else
				{
					$tmpvalue .= $d;
				}
			}
			if($j>0) $j = $j-1;
	    }
		//遍历源字符串，获得各属性
		for($i=$j;$i<$strLen;$i++)
		{
			$d = $this->SourceString[$i];
			//获得属性的键
			if($startdd==-1){
				if($d!="=")	$tmpatt .= $d;
				else{
					$tmpatt = strtolower(trim($tmpatt));
					$startdd=0;
				}
			}
			//检测属性值是用什么包围的，允许使用 '' '' 或空白
			else if($startdd==0){
				switch($d){
					case ' ':
						continue;
						break;
					case '\'':
						$ddtag='\'';
						$startdd=1;
						break;
					case '"':
						$ddtag='"';
						$startdd=1;
						break;
					default:
						$tmpvalue.=$d;
						$ddtag=' ';
						$startdd=1;
						break;
				}
			}
			//获得属性的值
			else if($startdd==1)
			{
				if($d==$ddtag)
				{
					$this->Count++;
                    if($this->CharToLow) $this->Items[$tmpatt] = strtolower(trim($tmpvalue));
					else $this->Items[$tmpatt] = trim($tmpvalue);
					$tmpatt = '';
					$tmpvalue = '';
					$startdd=-1;
				}
				else
					$tmpvalue.=$d;
			}
	  }//End for
	  //处理没有值的属性(必须放在结尾才有效)如："input type=radio name=t1 value=aaa checked"
	  if($tmpatt!='') $this->Items[$tmpatt] = '';
   }
}
?>