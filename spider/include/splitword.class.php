<?php
class SplitWord
{
	var $RankDic = Array();
	var $OneNameDic = Array();
	var $TwoNameDic = Array();
	var $NewWord = Array();
	var $SourceString = '';
	var $ResultString = '';
	var $SplitChar = ' '; //分隔符
	var $SplitLen = 4; //保留词长度
	var $EspecialChar = "和|的|是";
	var $NewWordLimit = "在|的|与|或|就|你|我|他|她|有|了|是|其|能|对|地";

	var $CommonUnit = "年|月|日|时|分|秒|点|元|百|千|万|亿|位|辆";

	var $CnNumber = "０|１|２|３|４|５|６|７|８|９|＋|－|％|．|ａ|ｂ|ｃ|ｄ|ｅ|ｆ|ｇ|ｈ|ｉ|ｊ|ｋ|ｌ|ｍ|ｎ|ｏ|ｐ|ｑ|ｒ|ｓ |ｔ|ｕ|ｖ|ｗ|ｘ|ｙ|ｚ|Ａ|Ｃ|Ｄ|Ｅ|Ｆ|Ｇ|Ｈ|Ｉ|Ｊ|Ｋ|Ｌ|Ｍ|Ｎ|Ｏ|Ｐ|Ｑ|Ｒ|Ｓ|Ｔ|Ｕ|Ｖ|Ｗ|Ｘ|Ｙ|Ｚ";
	var $CnSgNum = "一|二|三|四|五|六|七|八|九|十|百|千|万|亿|数";
	var $MaxLen = 13; //词典最大 7 中文字，这里的数值为字节数组的最大索引
	var $MinLen = 3;  //最小 2 中文字，这里的数值为字节数组的最大索引
	var $CnTwoName = "端木 南宫 谯笪 轩辕 令狐 钟离 闾丘 长孙 鲜于 宇文 司徒 司空 上官 欧阳 公孙 西门 东门 左丘 东郭 呼延 慕容 司马 夏侯 诸葛 东方 赫连 皇甫 尉迟 申屠";
	var $CnOneName = "赵钱孙李周吴郑王冯陈褚卫蒋沈韩杨朱秦尤许何吕施张孔曹严华金魏陶姜戚谢邹喻柏水窦章云苏潘葛奚范彭郎鲁韦昌马苗凤花方俞任袁柳酆鲍史唐费廉岑薛雷贺倪汤滕殷罗毕郝邬安常乐于时傅皮卡齐康伍余元卜顾孟平黄穆萧尹姚邵堪汪祁毛禹狄米贝明臧计伏成戴谈宋茅庞熊纪舒屈项祝董粱杜阮蓝闵席季麻强贾路娄危江童颜郭梅盛林刁钟徐邱骆高夏蔡田樊胡凌霍虞万支柯咎管卢莫经房裘缪干解应宗宣丁贲邓郁单杭洪包诸左石崔吉钮龚程嵇邢滑裴陆荣翁荀羊于惠甄魏加封芮羿储靳汲邴糜松井段富巫乌焦巴弓牧隗谷车侯宓蓬全郗班仰秋仲伊宫宁仇栾暴甘钭厉戎祖武符刘姜詹束龙叶幸司韶郜黎蓟薄印宿白怀蒲台从鄂索咸籍赖卓蔺屠蒙池乔阴郁胥能苍双闻莘党翟谭贡劳逄姬申扶堵冉宰郦雍郤璩桑桂濮牛寿通边扈燕冀郏浦尚农温别庄晏柴翟阎充慕连茹习宦艾鱼容向古易慎戈廖庚终暨居衡步都耿满弘匡国文寇广禄阙东殴殳沃利蔚越夔隆师巩厍聂晁勾敖融冷訾辛阚那简饶空曾沙须丰巢关蒯相查后江游竺";
  function SplitWord($loaddic=true){
  	$this->__construct($loaddic);
  }
  function __construct($loaddic=true){
  	if($loaddic)
  	{
  	  for($i=0;$i<strlen($this->CnOneName);$i++){
  		  $this->OneNameDic[$this->CnOneName[$i].$this->CnOneName[$i+1]] = 1;
  		  $i++;
  	  }
  	  $twoname = explode(" ",$this->CnTwoName);
  	  foreach($twoname as $n){ $this->TwoNameDic[$n] = 1; }
  	  unset($twoname);
  	  unset($this->CnTwoName);
  	  unset($this->CnOneName);
  	  $dicfile = dirname(__FILE__)."/dict.csv";
  	  $fp = fopen($dicfile,'r');
  	  while($line = fgets($fp,64)){
  		  $ws = explode(' ',$line);
  		  $this->RankDic[strlen($ws[0])][$ws[0]] = $ws[1];
  	  }
  	  fclose($fp);
    }
  }

  function Clear()
  {
  	unset($this->RankDic);
  }
  function SetSource($str)
  {
  	global $cfg_ver_lang;
  	if($cfg_ver_lang=='utf-8') $str = utf82gb($str);
  	$this->SourceString = $str;
  	$this->ResultString = '';
  }
  function SimpleSplit($str)
  {
  	$this->SourceString = $this->ReviseString($str);

  	return $this->SourceString;
  }
  function SplitRMM($str='',$tryNumName=true,$tryDiff=true)
  {
  	global $cfg_ver_lang;

  	$str = trim($str);

  	if($str!='') $this->SetSource($str);
  	else return '';

  	$this->SourceString = preg_replace('/ {1,}/',' ',$this->ReviseString($this->SourceString));

  	$spwords = explode(' ',$this->SourceString);
  	$spLen = count($spwords) - 1;
  	$spc = $this->SplitChar;
  	for($i=$spLen;$i>=0;$i--)
  	{
  		if(ord($spwords[$i][0])<33) continue;
  		else if(!isset($spwords[$i][$this->MinLen])) $this->ResultString = $spwords[$i].$spc.$this->ResultString;
  		else if(ord($spwords[$i][0])<0x81)
  		{
  			$this->ResultString = $spwords[$i].$spc.$this->ResultString;
  		}
  		else
  		{
  		  $this->ResultString = $this->RunRMM($spwords[$i],$tryNumName,$tryDiff).$spc.$this->ResultString;
  	  }
  	}

  	if($cfg_ver_lang=='utf-8') $okstr = gb2utf8($this->ResultString);
  	else $okstr = $this->ResultString;

  	return $okstr;
  }
  function ParNumber($str)
  {
  	if($str == '') return '';
  	$ws = explode(' ',$str);
  	$wlen = count($ws);
  	$spc = $this->SplitChar;
  	$reStr = '';
  	for($i=0;$i<$wlen;$i++){
  		if($ws[$i]=='') continue;
  		if($i>=$wlen-1) $reStr .= $spc.$ws[$i];
  		else{ $reStr .= $spc.$ws[$i]; }
    }
    return $reStr;
  }
  function ParOther($WordArray)
  {
  	$wlen = count($WordArray)-1;
  	$rsStr = '';
  	$spc = $this->SplitChar;
  	for($i=$wlen;$i>=0;$i--)
  	{
  		if(preg_match('/'.$this->CnSgNum.'/',$WordArray[$i]))
  		{
  			$rsStr .= $spc.$WordArray[$i];
  			if($i>0 && preg_match('/^'.$this->CommonUnit.'/',$WordArray[$i-1]) )
  			{ $rsStr .= $WordArray[$i-1]; $i--; }
  			else
  			{
  				while($i>0 && preg_match("/".$this->CnSgNum."/",$WordArray[$i-1]) ){ $rsStr .= $WordArray[$i-1]; $i--; }
  			}
  			continue;
  		}
  		if(strlen($WordArray[$i])==4 && isset($this->TwoNameDic[$WordArray[$i]]))
  		{
  			$rsStr .= $spc.$WordArray[$i];
  			if($i>0&&strlen($WordArray[$i-1])==2){
  				$rsStr .= $WordArray[$i-1];$i--;
  				if($i>0&&strlen($WordArray[$i-1])==2){ $rsStr .= $WordArray[$i-1];$i--; }
  			}
  		}
  		else if(strlen($WordArray[$i])==2 && isset($this->OneNameDic[$WordArray[$i]]))
  		{
  			$rsStr .= $spc.$WordArray[$i];
  			if($i>0&&strlen($WordArray[$i-1])==2){
  				 if(preg_match("/".$this->EspecialChar."/",$WordArray[$i-1])) continue;
  				 $rsStr .= $WordArray[$i-1];$i--;
  				 if($i>0 && strlen($WordArray[$i-1])==2 &&
  				  !preg_match("/".$this->EspecialChar."/",$WordArray[$i-1]))
  				 { $rsStr .= $WordArray[$i-1];$i--; }
  			}
  		}
  		else{
  			$rsStr .= $spc.$WordArray[$i];
  		}
  	}
  	$rsStr = preg_replace("/^".$spc."/","",$rsStr);
  	return $rsStr;
  }
  function RunRMM($str,$tryNumName=true,$tryDiff=true)
  {
  	$spc = $this->SplitChar;
  	$spLen = strlen($str);
  	$rsStr = $okWord = $tmpWord = '';
  	$WordArray = Array();
  	for($i=($spLen-1);$i>=0;)
  	{
  		if($i<=$this->MinLen){
  			if($i==1){
  			  $WordArray[] = substr($str,0,2);
  		  }else
  			{
  			   $w = substr($str,0,$this->MinLen+1);
  			   if($this->IsWord($w)){
  			   	$WordArray[] = $w;
  			   }else{
  				   $WordArray[] = substr($str,2,2);
  				   $WordArray[] = substr($str,0,2);
  			   }
  		  }
  			$i = -1; break;
  		}
  		if($i>=$this->MaxLen) $maxPos = $this->MaxLen;
  		else $maxPos = $i;
  		$isMatch = false;
  		for($j=$maxPos;$j>=0;$j=$j-2){
  			 $w = substr($str,$i-$j,$j+1);
  			 if($this->IsWord($w)){
  			 	$WordArray[] = $w;
  			 	$i = $i-$j-1;
  			 	$isMatch = true;
  			 	break;
  			 }
  		}
  		if(!$isMatch){
  			if($i>1) {
  				$WordArray[] = $str[$i-1].$str[$i];
  				$i = $i-2;
  			}
  		}
  	}//End For

  	if($tryNumName)
  	{ $rsStr = $this->ParOther($WordArray); }
  	else{
  		$wlen = count($WordArray)-1;
  		for($i=$wlen;$i>=0;$i--){
  	  	$rsStr .= $spc.$WordArray[$i];
  	  }
  	}

  	if($tryDiff) $rsStr = $this->TestDiff(trim($rsStr));

  	return $rsStr;
  }
  function AutoDescription($str,$keyword,$strlen)
  {
  	$this->SourceString = $this->ReviseString($this->SourceString);
  	$spwords = explode(" ",$this->SourceString);
  	$keywords = explode(" ",$this->keywords);
  	$regstr = "";
  	foreach($keywords as $k=>$v)
  	{
  		if($v=="") continue;
  		if(ord($v[0])>0x80 && strlen($v)<3) continue;
  		if($regstr=="") $regstr .= "($v)";
  		else $regstr .= "|($v)";
  	}
  }
  function TestDiff($str)
  {
  	$str = preg_replace("/ {1,}/"," ",$str);
  	if($str == ""||$str == " ") return "";
  	$ws = explode(' ',$str);
  	$wlen = count($ws);
  	$spc = $this->SplitChar;
  	$reStr = "";
  	for($i=0;$i<$wlen;$i++)
  	{
  		if($i>=($wlen-1)) {
  			$reStr .= $spc.$ws[$i];
  		}
  		else
  		{
  			if($ws[$i]==$ws[$i+1]){
  				$reStr .= $spc.$ws[$i].$ws[$i+1];
  				$i++; continue;
  			}
  			if(strlen($ws[$i])==2 && strlen($ws[$i+1])<8 && strlen($ws[$i+1])>2)
  			{
  				$addw = $ws[$i].$ws[$i+1];
  				$t = 6;
  				$testok = false;
  				while($t>=4)
  				{
  				  $w = substr($addw,0,$t);
  				  if($this->IsWord($w) && ($this->GetRank($w) > $this->GetRank($ws[$i+1])*2) )
  				  {
  					   $limitW = substr($ws[$i+1],strlen($ws[$i+1])-$t-2,strlen($ws[$i+1])-strlen($w)+2);
  					   if($limitW!="") $reStr .= $spc.$w.$spc.$limitW;
  					   else $reStr .= $spc.$w;
  					   $testok = true;
  					   break;
  				  }
  				  $t = $t-2;
  			  }
  			  if(!$testok) $reStr .= $spc.$ws[$i];
  			  else $i++;
  			}
  			else if(strlen($ws[$i])>2 && strlen($ws[$i])<8 && strlen($ws[$i+1])>2 && strlen($ws[$i+1])<8)
  			{
  				$t21 = substr($ws[$i+1],0,2);
  				$t22 = substr($ws[$i+1],0,4);
  				if($this->IsWord($ws[$i].$t21))
  				{
  					if(strlen($ws[$i])==6||strlen($ws[$i+1])==6){
  						$reStr .= $spc.$ws[$i].$t21.$spc.substr($ws[$i+1],2,strlen($ws[$i+1])-2);
  						$i++;
  					}else{
  						$reStr .= $spc.$ws[$i];
  					}
  				}
  				else if(strlen($ws[$i+1])==6)
  				{
  					if($this->IsWord($ws[$i].$t22))
  					{
  						$reStr .= $spc.$ws[$i].$t22.$spc.$ws[$i+1][4].$ws[$i+1][5];
  						$i++;
  					}else{ $reStr .= $spc.$ws[$i]; }
  				}
  				else if(strlen($ws[$i+1])==4)
  				{
  					$addw = $ws[$i].$ws[$i+1];
  					$t = strlen($ws[$i+1])-2;
  					$testok = false;
  					while($t>0)
  					{
  						$w = substr($addw,0,strlen($ws[$i])+$t);
  						if($this->IsWord($w) && ($this->GetRank($w) > $this->GetRank($ws[$i+1])*2) )
  				    {
  				       $limitW = substr($ws[$i+1],$t,strlen($ws[$i+1])-$t);
  					     if($limitW!="") $reStr .= $spc.$w.$spc.$limitW;
  					     else $reStr .= $spc.$w;
  					     $testok = true;
  					     break;
  				    }
  				    $t = $t-2;
  					}
  					if(!$testok) $reStr .= $spc.$ws[$i];
  			    else $i++;
  				}else {
  					$reStr .= $spc.$ws[$i];
  				}
  			}
  			else
  			{
  				$reStr .= $spc.$ws[$i];
  			}
  		}
    }//End For
  	return $reStr;
  }
  function IsWord($okWord){
  	$slen = strlen($okWord);
  	if($slen > $this->MaxLen) return false;
  	else return isset($this->RankDic[$slen][$okWord]);
  }
  function ReviseString($str)
  {
  	$spc = $this->SplitChar;
    $slen = strlen($str);
    if($slen==0) return '';
    $okstr = '';
    $prechar = 0; // 0-空白 1-英文 2-中文 3-符号
    for($i=0;$i<$slen;$i++){
      if(ord($str[$i]) < 0x81)
      {
        if(ord($str[$i]) < 33){
          //$str[$i]!="\r"&&$str[$i]!="\n"
          if($prechar!=0) $okstr .= $spc;
          $prechar=0;
          continue;
        }else if(preg_match("/[^0-9a-zA-Z@\.%#:\\/\\&_-]/",$str[$i]))
        {
          if($prechar==0)
          {	$okstr .= $str[$i]; $prechar=3;}
          else
          { $okstr .= $spc.$str[$i]; $prechar=3;}
        }else
        {
        	if($prechar==2||$prechar==3)
        	{ $okstr .= $spc.$str[$i]; $prechar=1;}
        	else
        	{
        	  if(preg_match("/@#%:/",$str[$i])){ $okstr .= $str[$i]; $prechar=3; }
        	  else { $okstr .= $str[$i]; $prechar=1; }
        	}
        }
      }
      else{
        if($prechar!=0 && $prechar!=2) $okstr .= $spc;
        if(isset($str[$i+1])){
          $c = $str[$i].$str[$i+1];

          if(preg_match("/".$this->CnNumber."/",$c))
          { $okstr .= $this->GetAlabNum($c); $prechar = 2; $i++; continue; }

          $n = hexdec(bin2hex($c));
          if($n>0xA13F && $n < 0xAA40)
          {
            if($c=="《"){
            	if($prechar!=0) $okstr .= $spc." 《";
            	else $okstr .= " 《";
            	$prechar = 2;
            }
            else if($c=="》"){
            	$okstr .= "》 ";
            	$prechar = 3;
            }
            else{
            	if($prechar!=0) $okstr .= $spc.$c;
            	else $okstr .= $c;
            	$prechar = 3;
            }
          }
          else{
            $okstr .= $c;
            $prechar = 2;
          }
          $i++;
        }
      }//中文字符
    }//结束循环
    return $okstr;
  }
  function FindNewWord($str,$maxlen=6)
  {
    $okstr = "";
    return $str;
  }
  function GetIndexText($str,$ilen=-1)
  {
    global $cfg_ver_lang;
    if($str=='') return '';
    else $this->SplitRMM($str,true,true);
    $okstr = $this->ResultString;
    $ws = explode(' ',$okstr);
    $okstr = $wks = '';
    foreach($ws as $w)
    {
      $w = trim($w);
      if(strlen($w)<2) continue;
      if(!preg_match("/[^0-9:-]/",$w)) continue;
      if(strlen($w)==2&&ord($w[0])>0x80) continue;
      if(isset($wks[$w])) $wks[$w]++;
      else $wks[$w] = 1;
    }
    if(is_array($wks))
    {
      arsort($wks);
      if($ilen==-1)
      { foreach($wks as $w=>$v)
      	{
      		if($this->GetRank($w)>500) $okstr .= $w." ";
        }
      }
      else
      {
        foreach($wks as $w=>$v){
          if((strlen($okstr)+strlen($w)+1)<$ilen) $okstr .= $w." ";
          else break;
        }
      }
    }
    if($cfg_ver_lang=='utf-8') $okstr = gb2utf8($okstr);
    return trim($okstr);
  }
  function GetRank($w){
  	if(isset($this->RankDic[strlen($w)][$w])) return $this->RankDic[strlen($w)][$w];
  	else return 0;
  }
  function GetAlabNum($fnum)
  {
	  $nums = array("０","１","２","３","４","５","６",
	  "７","８","９","＋","－","％","．",
	  "ａ","ｂ","ｃ","ｄ","ｅ","ｆ","ｇ","ｈ","ｉ","ｊ","ｋ","ｌ","ｍ",
	  "ｎ","ｏ","ｐ","ｑ","ｒ","ｓ ","ｔ","ｕ","ｖ","ｗ","ｘ","ｙ","ｚ",
	  "Ａ","Ｂ","Ｃ","Ｄ","Ｅ","Ｆ","Ｇ","Ｈ","Ｉ","Ｊ","Ｋ","Ｌ","Ｍ",
	  "Ｎ","Ｏ","Ｐ","Ｑ","Ｒ","Ｓ","Ｔ","Ｕ","Ｖ","Ｗ","Ｘ","Ｙ","Ｚ");
	  $fnums = "0123456789+-%.abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  $fnum = str_replace($nums,$fnums,$fnum);
	  return $fnum;
  }
}//End Class

?>