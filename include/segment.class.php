<?php
class segment
{
	var $tagdic = array();
	var $onenamedic = array();
	var $twonamedic = array();
	var $hashdic = array();
	var $result = array();
	var $inputstring = '';
	var $splitlen = 4; //�����ʳ���
	var $especialchar = '��|��|��|��';
	var $newwordlimit = '��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��';
	var $commonunit = '��|��|��|ʱ|��|��|��|Ԫ|��|ǧ|��|��|λ|��|��|��';
	var $pchar = 0;
	var $cnnumber = array('��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��');
	//�����ַ�
	var $trimchars = array('��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','�I','��','�y','�x','�z','�{','�|','�}','�~','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','�d','��');
	var $fnums = '0123456789+-*%.=/[]{}()~123456789\$';
	var $cnsgnum = '0|1|2|3|4|5|6|7|8|9|��|һ|��|��|��|��|��|��|��|��|ʮ|��|ǧ|��|��|��';
	var $maxlen = 13;
	var $minlen = 3;
	var $cntwoname = '��ľ �Ϲ� ���� ��ԯ ��� ���� ���� ���� ���� ���� ˾ͽ ˾�� �Ϲ� ŷ�� ���� ���� ���� ���� ���� ���� Ľ�� ˾�� �ĺ� ��� ���� ���� �ʸ� ξ�� ����';
	var $cnonename = '��Ǯ��������֣��������������������������ʩ�ſײ��ϻ���κ�ս���л������ˮ��������˸��ɷ�����³Τ������ﻨ������Ԭ��ۺ��ʷ�Ʒ����Ѧ�׺����������ޱϺ�����������ʱ��Ƥ���뿵����Ԫ������ƽ��������Ҧ�ۿ�����ë����ױ���갼Ʒ��ɴ�̸��é���ܼ�������ף������������ϯ����ǿ��·¦Σ��ͯ�չ�÷ʢ�ֵ�����������Ĳ��﷮���������֧�¾̹�¬Ī�������Ѹɽ�Ӧ�������ڵ��������������ʯ�޼�ť�������ϻ���½��������춻���κ�ӷ����ഢ���������ɾ��θ����ڽ��͹�����ȳ������ȫۭ�����������������ﱩ�����������������ղ����Ҷ��˾��۬�輻��ӡ�ް׻���̨�Ӷ����̼���׿�����ɳ����������ܲ�˫��ݷ����̷�����̼������Ƚ��۪Ӻ�S�ɣ���ţ��ͨ�����༽ۣ����ũ�±�ׯ�̲���ֳ�Ľ����ϰ�°���������������θ����߾Ӻⲽ�����������Ŀܹ�»�ڶ�Ź�����εԽ��¡ʦ�������˹��������������Ǽ��Ŀ���ɳ��ᳲ������������';
	
	function segment($dictfile = '')
	{
		$this->__construct($dictfile);
	}

	function __construct($dictfile = '')
	{
		$cnonenamecount = strlen($this->cnonename);
		for($i=0; $i<$cnonenamecount; $i++)
		{
			$this->onenamedic[$this->cnonename[$i].$this->cnonename[$i+1]] = 1;
			$i++;
		}
		$twoname = explode(' ', $this->cntwoname);
		foreach($twoname as $n)
		{
			$this->twonamedic[$n] = 1;
		}
		unset($twoname, $this->cnonename, $this->cntwoname);
		if(!$dictfile) $dictfile = dirname(__file__).'/dict/dict_gbk.dat';
		$fp = @fopen($dictfile, 'rb');
		$i = 0;
		while($this->hashdic[$i++] = fread($fp, 65536));
		@fclose($fp);
	}

	function word_hash($word)
	{
		$i = 0;
		$c = $t = '';
		$hashcode = $pincode = 1;
		while($c = ord($word[$i++]))
		{
			if($c&0x80)
			{
				$t = ord($word[$i++]);
				$hashcode*=((($c&0x7f)<<8)|$t);
				$pincode*=$t;
			}
			else
			{
				$hashcode*=$c;
				$pincode*=$c;
			}
			$hashcode=abs($hashcode)%261223;
			$pincode=abs($pincode)%8285839;
		}
		if($hashcode<0) $hashcode=abs($hashcode)%261223;
		if($pincode<0) $pincode=abs($pincode)%8285839;
		$hashcode += 47;
		$pincode++;
		return array('hash_pos'=>$hashcode*3,'pincode'=>$pincode);
	}

	function close()
	{
		unset($this->hashdic);
	}

	function set_text($text)
	{
		if(strtolower(CHARSET) == 'utf-8') $text = iconv('utf-8', 'gbk', $text);
		$text = strip_tags($text);
		$this->inputstring = trim($this->initstring($text));
		$this->resultstring = '';
	}

	function get_words($method = 1)
	{
		$this->result = array();
		$this->pchar = -1;
		$spwords = explode(' ', $this->inputstring);
		$splen = sizeof($spwords);
		for($i=0; $i<$splen; $i++)
		{
			if(trim($spwords[$i]) == '') continue;
			if(!($oc=ord($spwords[$i][0])&0x80))
			{
				if($oc<43 || $oc>57|| $oc==44 ||$oc==47)
				{
					$this->result[++$this->pchar]= $spwords[$i];
				}
				else
				{
					$nextword = '';
					@$nextword = substr($this->resultstring, 0, strpos($this->resultstring, ' '));
					if(ereg('^'.$this->commonunit,$nextword))
					{
						$this->result[$this->pchar] .= $spwords[$i];
					}
					else
					{
						$this->result[++$this->pchar] = $spwords[$i];
					}
				}
			}
			else
			{
				$c = $spwords[$i][0].$spwords[$i][1];
				$n = hexdec(bin2hex($c));
				if($c=='��' || ($n>0xa13f && $n < 0xaa40))
				{
					$this->result[++$this->pchar]= $spwords[$i];
				}
				else
				{
					if(strlen($spwords[$i]) <= $this->splitlen)
					{
						if(ereg($this->especialchar.'$',$spwords[$i],$regs))
						{
							$spwords[$i] = ereg_replace($regs[0].'$', '', $spwords[$i]).$regs[0];
						}
						if(!ereg('^'.$this->commonunit,$spwords[$i]) || $i==0)
						{
							$this->result[++$this->pchar]= $spwords[$i];
						}
						elseif($i!=0)
						{
							$this->result[$this->pchar].= $spwords[$i];
						}
					}
					else
					{
						if($method == 0)
						{
							//�������ƥ���㷨
							$this->seg_mm($spwords[$i]);
						}
						elseif($method == 1)
						{
							//������Сƥ���㷨
							$this->seg_nm($spwords[$i]);
						}
					}
				}
			}
		}
		$text = implode(' ', array_filter($this->result, 'is_ok'));
		if(strtolower(CHARSET) == 'utf-8') $text = iconv('gbk', 'utf-8', $text);
		return $text;
	}

	function seg_mm($str)
	{
		$slen = strlen($str);
		$maxpos = $slen-$this->minlen-1;
		$wordarray = array();
		for($i=0; $i<$slen;)
		{
			if($i>=$maxpos)
			{
				if($this->minlen==1)
				{
					$wordarray[] = substr($str,$maxpos,2);
				}
				else
				{
					$w = substr($str, $i, $this->minlen+1);
					if($this->isword($w))
					{
						$wordarray[] = $w;
					}
					else
					{
						while($i<=$slen-2)
						{
							$wordarray[] = substr($str,$i,2);
							$i+=2;
						}
					}
				}
				$i = $slen; break;
			}
			$maxlenght = $this->maxlen+1>$slen-$i ? $slen-$i : $this->maxlen+1;
			for($j=$maxlenght; $j>=$this->minlen+1; $j=$j-2)
			{
				$w = substr($str,$i,$j);
				if($this->isword($w))
				{
					$wordarray[] = $w;
					$i += $j;
					break;
				}
			}
			if($j < $this->minlen+1)
			{
				$wordarray[] = $str[$i].$str[$i+1];
				$i += 2;
			}
		}
		$this->matchother($wordarray);
		return;
	}

	function seg_nm($str)
	{
		$slen = strlen($str);
		$maxpos = $slen-$this->minlen-1;
		$wordarray = array();
		for($i=0; $i<$slen;)
		{
			if($i >= $maxpos)
			{
				if($this->minlen==1)
				{
					$wordarray[] = substr($str,$maxpos,2);
				}
				else
				{
					$w = substr($str,$i,$this->minlen+1);
					if($this->isword($w))
					{
						$wordarray[] = $w;
					}
					else
					{
						while($i<=$slen-2)
						{
							$wordarray[] = substr($str,$i,2);
							$i+=2;
						}
					}
				}
				break;
			}
			$maxlenght = $this->maxlen+1 > $slen-$i ? $slen-$i : $this->maxlen+1;
			for($j=$this->minlen+1; $j<=$maxlenght; $j+=2)
			{
				$w = substr($str,$i,$j);
				if($this->isword($w))
				{
					$wordarray[] = $w;
					$i +=$j;
					break;
				}
			}
			if($j > $maxlenght)
			{
				$wordarray[] = substr($str,$i,2);
				$i += 2;
			}
		}
		$this->matchother($wordarray);
		return;
	}

	function matchother($wordarray)
	{
		$wordcount = count($wordarray)-1;
		for($i=0; $i<=$wordcount; $i++)
		{
			$this->result[++$this->pchar] = $wordarray[$i];
			if(ereg($this->cnsgnum,$wordarray[$i]))
			{
				if($i<$wordcount&& ereg('^'.$this->commonunit, $wordarray[$i+1]))
				{
					$this->result[$this->pchar].= $wordarray[++$i];
				}
				else
				{
					while($i<=$wordcount && ereg($this->cnsgnum, $wordarray[$i+1]))
					{
						$this->result[$this->pchar].= $wordarray[++$i]; 
					}
				}
				continue;
			}
		}
	}

	function isword($inputword)
	{
		static $iswordarray = array();
		if(isset($iswordarray[$inputword]))return true;
		if(!$hash=&$this->word_hash($inputword))return false;
		$hash_pos=$hash['hash_pos'];
		$hashdic=&$this->hashdic;
		$segment=$hash['hash_pos']>>16;
		$offset=$hash['hash_pos']&0xffff;
		$hash_pin_key = (ord($hashdic[$segment][$offset+2])<<16)|(ord($hashdic[$segment][$offset+1])<<8)|ord($hashdic[$segment][$offset]);
		if($hash['pincode'] == $hash_pin_key)
		{
			$iswordarray[$inputword] = 1;
			return true;
		}
		elseif($hash_pin_key&0x800000)
		{
			$offsetpos = 0x7fffff&$hash_pin_key;
			do{
				$segment=$offsetpos>>16;
				$offset=$offsetpos&0xffff;
				$hash_pin_code=(ord($hashdic[$segment][$offset+2])<<16)|(ord($hashdic[$segment][$offset+1])<<8)|ord($hashdic[$segment][$offset]);$offset+=3;
				if(($hash_pin_code&0x7fffff)==$hash['pincode'])
				{
					$iswordarray[$inputword]=1;
					return true;
				}
				if($offset>=65536)
				{
					$offset-=65536;
					$segment++;
				}
			}
			while(($hash_pin_code&0x800000)&&($offsetpos=(ord($hashdic[$segment][$offset+2])<<16)|(ord($hashdic[$segment][$offset+1])<<8)|ord($hashdic[$segment][$offset])));
		}
		return false;
	}

	function initstring($str)
	{
		$spc =' ';
		$slen = strlen($str);
		if($slen==0) return '';
		$okstr = '';
		$oc=$i=0;
		$prechar = 0;
		while($oc=ord($str[$i]))
		{
			if($oc < 0x81)
			{
				if($oc < 33)
				{
					if($prechar!=0&&$oc!=13&&$str[$i]!=10) $okstr .= $spc;
					$prechar=0;
					$i++;
					continue;
				}
				elseif(($oc!=44)&&($oc<42 ||$oc>58)&&($oc<64 ||$oc>90)&&($oc<67 ||$oc>70)&&($oc<97 ||$oc>122)&&$oc!=95)
				{
					if($prechar==0)
					{
						$okstr .= $str[$i]; $prechar=3;
					}
					else
					{ 
						$okstr .= $spc.$str[$i]; $prechar=3;
					}
				}
				else
				{
					if($prechar==2 || $prechar==3)
					{ 
						$okstr .= $spc.$str[$i]; $prechar=1;
					}
					else
					{
						$okstr .= $str[$i];
						$prechar=1;
						if($oc==58 || $oc==67 || $oc==69)
						{
							$prechar=3;
						}
						else
						{ 
							$prechar=1;
						}
					}
				}
			}
			else
			{
				if($prechar!=0 && $prechar!=2) $okstr .= $spc;
				if(isset($str[$i+1]))
				{
					$c = $str[$i].$str[$i+1];
					if(false!==$idx=array_search($c,$this->cnnumber))
					{ 
						$okstr .= $this->fnums[$idx]; $prechar = 2; $i+=2; continue; 
					}
					elseif(false!==array_search($c,$this->trimchars))
					{
						$i+=2; 
						continue;
					}
					$n = hexdec(bin2hex($c));
					if($n>0xa13f && $n < 0xaa40)
					{
						if($c=='��')
						{
							if($prechar!=0) $okstr .= $spc.' ��';
							else $okstr .= ' ��';
							$prechar = 2;
						}
						elseif($c=='��')
						{
							$okstr .= '�� ';
							$prechar = 3;
						}
						else
						{
							if($prechar!=0) $okstr .= $spc.$c;
							else $okstr .= $c;
							$prechar = 3;
						}
					}
					else
					{
						$okstr .= $c;
						$prechar = 2;
					}
					$i++;
				}
			}
			$i++;
		}
		return $okstr;
	}
}

function is_ok($str)
{
	return $str != '��';
}
?>