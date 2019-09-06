<?php
defined('IN_PHPCMS') or exit('Access Denied');

define('GBUNICODE', PHPCMS_ROOT.'/include/encoding/gb-unicode.table');
define('TEXTFONT', PHPCMS_ROOT.'/include/fonts/simhei.ttf');

/**
* 图片处理类，可以生成缩略图和加水印
*/
class watermark
{
	/**
	* 需要处理的图片的路径
	* @var string
	*/
	var $g_img = ''; 

	/**
	* 加水印的位置
	* @var int 0到9的数值
	*/
	var $pos = 3;

	/**
	* jpeg图片质量
	* @var int 0到100的数值
	*/
    var $jpeg_quality = 80;             //jpeg图片质量

	/**
	* 图片处理后的保存路径，留空则覆盖原文件
	* @var string
	*/
    var $save_name = '';

	/**
	* 生成缩略图的宽度最大值，0表示不限制
	* @var int
	*/
    var $w = 0;

	/**
	* 生成缩略图的高度最大值，0表示不限制
	* @var int
	*/
	var $h = 0;

	/**
	* 生成缩略图是否裁剪，0表示不裁剪
	* @var int
	*/
	var $cut = 0;

	/**
	* 当宽度和高度条件同时指定时，是否等比缩小
	* @var bool
	*/
	var $alongwith = 1;

	/**
	* 水印图片的路径
	* @var string
	*/
    var $w_img = '';

	/**
	* 水印图片与原图片的融合度,数值越小越透明 (1到100)
	* @var int
	*/
    var $transition = 65;

	/**
	* 水印文字(支持中英文以及带有\r\n的跨行文字)
	* @var string
	*/
    var $text = '';

	/**
	* 水印文字大小
	* @var int
	*/
    var $text_size = 20;

	/**
	* 水印文字的字体
	* @var int
	*/
    var $text_font = '';

	/**
	* 水印字体的颜色值
	* @var int
	*/
    var $text_color = '#ffffff';

	/**
	* 水印文字角度,这个值尽量不要更改
	* @var int
	*/
    var $text_angle = 0;
    var $t_x = 0;
    var $t_y = 0;

	/**
	* @access private
	*/
    var $gburl = GBUNICODE;   //简体中文件码文件路径

	/**
	* @access private
	*/
	var $ismake = 1;

	var $rw = 0;//原图像宽位置

	var $rh = 0;//原图像高位置

	/**
	* 构造函数，初始化类
	* @param string 需要处理的图片路径
    * @param int 图片处理的最小宽度和高度，当图片高度和宽度任意一个小于这个数值时，不对该图片进行处理
    * @param int 加水印的位置，在0到9之间取值
	*/
	function watermark($g_img = '', $min_wh = 10, $pos = 3,$t_x = 0,$t_y = 0)
	{
		global $PHPCMS;
		$g_img = strtolower(trim($g_img));
		if(empty($g_img) || !file_exists($g_img)) return false;
		$this->g_img = $g_img;
        $this->pos = $pos;
		$info = getimagesize($this->g_img);
		if($PHPCMS['water_min_wh']) $min_wh = $PHPCMS['water_min_wh'];
		if($info[0] < $min_wh || $info[1] < $min_wh)
		{
			$this->ismake = 0;
			return false;
        }
		if($PHPCMS['water_transition']) $this->transition = $PHPCMS['water_transition'];
		if($PHPCMS['water_jpeg_quality']) $this->jpeg_quality = $PHPCMS['water_jpeg_quality'];
		$this->t_x = $t_x;
		$this->t_y = $t_y;
		$this->g_w = $info[0];
		$this->g_h = $info[1];
		$this->g_type = $info[2];
		$this->g_im = $this->createimage($this->g_type,$this->g_img);
        if(!$this->g_im) return false;
	}

	/**
	* 生成图片水印
	* @param string 水印图片的路径
    * @param string 处理后的图片保存路径，留空则覆盖原图片
	*/
    function image($w_img, $save_name='')
    {
		if(!$this->ismake || ($this->g_type == 1 && (!function_exists('imagegif') || !function_exists('imagecreatefromgif')))) return false;
        $this->w_img = strtolower(trim($w_img));
        $this->save_name = $save_name ? $save_name : $this->g_img;
        $info = getimagesize($this->w_img);
        $w_im = $this->createimage($info[2],$this->w_img);
        $this->w_w = $info[0];
        $this->w_h = $info[1];
        $temp_w_im = $this->get_pos('image');
        $w_im_x = $temp_w_im["dest_x"];
        $w_im_y = $temp_w_im["dest_y"];
        imagecopymerge($this->g_im,$w_im,$w_im_x,$w_im_y,0,0,$this->w_w,$this->w_h,$this->transition);
		@imagedestroy($this->w_im);
		$this->save();
    }

	/**
	* 生成文字水印
	* @param string 水印文字
    * @param string 处理后的图片保存路径，留空则覆盖原图片
    * @param string 水印文字颜色
    * @param int 水印文字大小
    * @param string 水印文字字体位置
    * @param int 水印文字角度
	*/
    function text($text, $save_name='', $text_color='#ffffff', $text_size=20, $text_font=TEXTFONT, $text_angle=0)
    {
		if(!$this->ismake || ($this->g_type == 1 && (!function_exists('imagegif') || !function_exists('imagecreatefromgif')))) return false;
        $this->text = $this->gb2utf8($text);
        $this->save_name = $save_name ? $save_name : $this->g_img;
		$this->text_font = $text_font ;
		$this->text_size = $text_size ;
		$this->text_angle = $text_angle ;
        $temp_text = $this->get_pos('text');
        $text_x = $temp_text["dest_x"];
        $text_y = $temp_text["dest_y"];
        if(preg_match("/([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])([a-f0-9][a-f0-9])/i",$text_color,$color))
        {
               $red = hexdec($color[1]);
               $green = hexdec($color[2]);
               $blue = hexdec($color[3]);
               $text_color = imagecolorallocate($this->g_im, $red,$green,$blue);
        }
		else
		{
               $text_color = imagecolorallocate($this->g_im, 255,255,255);
        }
        imagettftext($this->g_im, $text_size, $text_angle, $text_x, $text_y, $text_color,$text_font, $this->text);
		$this->save();
    }

	/**
	* @access private
	*/
    function save()
    {
        switch($this->g_type)
		{
            case '1': imagegif($this->g_im, $this->save_name); break;
            case '2': imagejpeg($this->g_im, $this->save_name, $this->jpeg_quality); break;
            case '3': imagepng($this->g_im, $this->save_name); break;
            default : imagejpeg($this->g_im, $this->save_name, $this->jpeg_quality); break;
        }
    }

	/**
	* 在浏览器中显示处理好的图片，不会被保存
	*/
	function show()
	{
        header('Content-type: image/jpeg');
        switch($this->g_type)
		{
			case 1: imagegif($this->g_im); break;
            case 2: imagejpeg($this->g_im, '', $this->jpeg_quality);break;
            case 3: imagepng($this->g_im);break;
            default : imagejpeg($this->g_im, '', $this->jpeg_quality);break;
        }
	}

	/**
	* 生成缩略图，当$w和$h只指定了一个时，等比缩小；都指定了时，$alongwith=1则等比缩小，$alongwith=0则缩小到指定大小
	* @param int 缩略图宽度，0为不限制
    * @param int 处理后的图片保存路径，留空则覆盖原图片
    * @param string 处理后的图片保存路径，留空则覆盖原图片
	*/
    function thumb($w=0,$h=0,$save_name='',$cut=0)
    {
		if(!$this->g_im) return FALSE;
		$this->save_name = $save_name ? $save_name : $this->g_img;
		if($this->resize($w,$h,$cut)) $this->save();
		return TRUE;
    }

	/**
	* @access private
	*/
	function resize($w=0,$h=0,$cut)
    {
		$w = $w ? $w : $this->w ;
		$h = $h ? $h : $this->h ;
		if(!$w && !$h) return false;

		if($w && !$h && $this->g_w > $w)
		{
			$h = $w/$this->g_w * $this->g_h;
		}
		elseif(!$w && $h && $this->g_h > $h)
		{
			$w = $h/$this->g_h * $this->g_w;
		}
		elseif($w && $h && $this->alongwith && !$cut)
		{
			$a = $w/$this->g_w;
			$b = $h/$this->g_h;
			if($a<1 || $b<1)
			{
				$a>$b ? $w = $this->g_w * $b : $h = $this->g_h * $a;               
			}
        }
		elseif($w && $h && $cut)
		{
			
			$resize_ratio = $w/$h;	//改变后的图象的比例
			
			$ratio = $this->g_w/$this->g_h;	//实际图象的比例

			if($ratio>=$resize_ratio)//高度优先
				$this->g_w = $h*$resize_ratio;

			if($ratio<$resize_ratio)//宽度优先
				$this->g_h = $w/$resize_ratio;
		}

        $dst_image = imagecreatetruecolor($w, $h);
        imagecopyresampled($dst_image, $this->g_im, 0, 0, 0, 0, $w, $h, $this->g_w, $this->g_h);
        $this->g_im = $dst_image;
        unset($dst_image);
		return TRUE;
    }

	/**
	* @access private
	*/
    function createimage($type,$img_name)
    {
        switch($type)
	    {
            case 1:
                   $tmp_img = @imagecreatefromgif($img_name);
                   break;
            case 2:
                   $tmp_img = imagecreatefromjpeg($img_name);
                   break;
            case 3:
                   $tmp_img = imagecreatefrompng($img_name);
                   break;
            default:
                   $tmp_img = imagecreatefromstring($img_name);
        }
        return $tmp_img;
    }
 
 	/**
	* @access private
	*/
 	function get_pos($type='image')
	{
        if($type=='image')
        {
            $p_w = $this->w_w; 
            $p_h = $this->w_h; 
        } 
        else
        {
			$line = count(explode("\n",$this->text));
            $temp = imagettfbbox($this->text_size,$this->text_angle,$this->text_font,$this->text);
            $p_w = $temp[2] - $temp[6]; 
            $p_h = $line*($temp[3] - $temp[7]); 
            unset($temp); 
        } 
        if(($this->g_w < $p_w) || ($this->g_h < $p_h)) 
        {
			return false; 
        } 
        switch($this->pos) 
        { 
            case 0://随机 
                $posX = rand(0,($this->g_w - $p_w)); 
                $posY = rand(0,($this->g_h - $p_h)); 
                break; 
            case 1://1为顶端居左 
                $posX = 0; 
                $posY = $type=='image' ? 0 : $p_h; 
                break; 
            case 2://2为顶端居中 
                $posX = ($this->g_w - $p_w) / 2; 
                $posY = $type=='image' ? 0 : $p_h; 
                break; 
            case 3://3为顶端居右 
                $posX = $this->g_w - $p_w; 
                $posY = $type=='image' ? 0 : $p_h; 
                break; 
            case 4://4为中部居左 
                $posX = 0; 
                $posY = ($this->g_h - $p_h) / 2; 
                break; 
            case 5://5为中部居中 
                $posX = ($this->g_w - $p_w) / 2; 
                $posY = ($this->g_h - $p_h) / 2; 
                break; 
            case 6://6为中部居右 
                $posX = $this->g_w - $p_w; 
                $posY = ($this->g_h - $p_h) / 2; 
                break; 
            case 7://7为底端居左 
                $posX = 0; 
                $posY = $this->g_h - $p_h; 
                break; 
            case 8://8为底端居中 
                $posX = ($this->g_w - $p_w) / 2; 
                $posY = $this->g_h - $p_h; 
                break; 
            case 9://9为底端居右 
                $posX = $this->g_w - $p_w; 
                $posY = $this->g_h - $p_h; 
                break; 
			case 10://自定义
                $posX = $this->t_x;
                $posY = $this->t_y;
                break; 
            default://随机 
                $posX = rand(0,($this->g_w - $p_w)); 
                $posY = rand(0,($this->g_h - $p_h)); 
                break;     
        }
		return array('dest_x'=>$posX, 'dest_y'=>$posY);
	}

	/**
	* @access private
	*/
  	function gb2utf8($gb)
  	{
    	if(!trim($gb))
      	   return $gb;
    	$filename = $this->gburl;
    	$tmp=file($filename);
    	$codetable=array();
    	while(list($key,$value)=each($tmp))
    	 	  $codetable[hexdec(substr($value,0,6))]=substr($value,7,6);
 
    	$utf8='';
    	while($gb)
    	{
      	 	if(ord(substr($gb,0,1))>127)
            {
        	    $tthis=substr($gb,0,2);
        	 	$gb=substr($gb,2,strlen($gb)-2);
        	 	$utf8.=$this->u2utf8(hexdec($codetable[hexdec(bin2hex($tthis))-0x8080]));
      	 	}
      	 	else
      	 	{
        	 	$tthis=substr($gb,0,1);
        	 	$gb=substr($gb,1,strlen($gb)-1);
        	 	$utf8.=$this->u2utf8($tthis);
      	 	}
    	}
   	    return $utf8;
  	}
 
 	/**
	* @access private
	*/
  	function u2utf8($c)
  	{
    	$str='';
    	if($c < 0x80)
   	    {
      	 	$str.=$c;
    	}
    	elseif($c < 0x800)
    	{
      	 	$str.=chr(0xC0 | $c>>6);
      	 	$str.=chr(0x80 | $c & 0x3F);
    	}
    	elseif($c < 0x10000)
    	{
      	 	$str.=chr(0xE0 | $c>>12);
      	 	$str.=chr(0x80 | $c>>6 & 0x3F);
      	 	$str.=chr(0x80 | $c & 0x3F);
    	}
    	elseif($c < 0x200000)
    	{
      	 	$str.=chr(0xF0 | $c>>18);
      	 	$str.=chr(0x80 | $c>>12 & 0x3F);
      	 	$str.=chr(0x80 | $c>>6 & 0x3F);
      	 	$str.=chr(0x80 | $c & 0x3F);
    	}
  	 	return $str;
  	}
}
?>