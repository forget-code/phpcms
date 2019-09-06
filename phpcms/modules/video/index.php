<?php 
defined('IN_PHPCMS') or exit('No permission resources.');

/**
 * 
 * ------------------------------------------
 * index
 * ------------------------------------------
 * @package 	PHPCMS V9.1.16
 * @author		王官庆
 * @copyright	CopyRight (c) 2006-2012 上海盛大网络发展有限公司
 * 
 */

class index{
	
	public $db;
	
	public function __construct() {
		$this->db = pc_base::load_model('video_model');
		pc_base::load_app_class('ku6api', 'video', 0);
		$this->userid = param::get_cookie('userid');
		$this->setting = getcache('video');
		$this->ku6api = new ku6api($this->setting['sn'], $this->setting['skey']);
	}
	
	/**
	 * 
	 * 视频列表
	 */
	public function init() {
		
		
		$where = '';
		$page = max(intval($_GET['page']), 1);
		$pagesize = 20;
		$infos = $this->db->listinfo($where, 'videoid DESC', $page, $pagesize);
		$flash_info = $this->ku6api->flashuploadparam();
		include template('content','video_for_ck');
	}
	
	/**
	* 播放清单，播放页
	*/
	public function playlist(){
		pc_base::load_app_func('util','content');
		if(isset($_GET['siteid'])) {
			$siteid = intval($_GET['siteid']);
		} else {
			$siteid = 1;
		}
		$CATEGORYS = getcache('category_content_'.$siteid,'commons');
		$title = strip_tags($_GET['title']);
		$contentid = intval($_GET['contentid']);
		$catid = intval($_GET['catid']);
 		$video_info = get_vid($contentid, $catid, $isspecial = 0);
  		include template('content','show_videolist');
	} 
	
	/**
	* 视频专辑列表页
	* index.php?m=video&c=index&a=album
	*/
	public function album(){
		pc_base::load_app_func('util','content');
		$spid = $_GET['spid'];
		$page = $_GET['page'];
 		include template('content','video_album');
	}
	
	
	
}

?>