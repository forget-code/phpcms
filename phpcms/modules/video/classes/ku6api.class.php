<?php
/**
 * 
 * ----------------------------
 * ku6api class
 * ----------------------------
 * 
 * An open source application development framework for PHP 5.0 or newer
 * 
 * 这是个接口类，主要负责视频模型跟ku6vms之间的通信
 * @package	PHPCMS V9.1.16
 * @author		chenxuewang
 * @copyright	CopyRight (c) 2006-2012 上海盛大网络发展有限公司
 *
 */

class ku6api {
	public $ku6api_sn, $ku6api_key;
	private $ku6api_url,$http,$xxtea;
	
	/**
	 * 
	 * 构造方法 初始化用户身份识别码、加密密钥等
	 * @param string $ku6api_skey vms系统中的身份识别码
	 * @param string $ku6api_sn vms系统中配置的通信加密密钥
	 * 
	 */
	public function __construct($ku6api_sn = '', $ku6api_skey = '') {
		$this->ku6api_skey = $ku6api_skey;
		$this->ku6api_sn = $ku6api_sn;
		if (!$this->ku6api_sn) {
			$this->set_sn();
		}
		$this->ku6api_url = pc_base::load_config('ku6server', 'api_url');
		$this->http = pc_base::load_sys_class('http');
		$this->xxtea = pc_base::load_app_class('xxtea', 'video');
		
	}

	/**
	 * 
	 * 设置身份识别码及身份密钥
	 * 
	 */
	private function set_sn() {
		//获取短信平台配置信息
		$setting = getcache('video');
		if ($setting['sn'] && $setting['skey']) {
			$this->ku6api_skey = $setting['skey'];
			$this->ku6api_sn = $setting['sn'];
		}
	}
	
	/**
	 * 
	 * vms_add 视频添加方法 系统中添加视频是调用，同步添加到vms系统中
	 * @param array $data 添加是视频信息 视频标题、介绍等
	 */
	public function vms_add($data = array()) {
		if (is_array($data) && !empty($data)) {
			//处理数据
			$data['tag'] = $this->get_tag($data);
			$data['v'] = 1;
			//将gbk编码转为utf-8编码
			if (CHARSET == 'gbk') {
				$data = array_iconv($data);
			}
			$data['sn'] = $this->ku6api_sn;
			$data['method'] = 'VideoAdd';
			$data['posttime'] = SYS_TIME;
			$data['token'] = $this->xxtea->encrypt($data['posttime'], $this->ku6api_skey);
			//向vms post数据，并获取返回值
			$this->http->post($this->ku6api_url, $data);
			$get_data = $this->http->get_data();
			$get_data = json_decode($get_data, true);
			if($get_data['code'] != 200) {
				$this->error_msg = $get_data['msg'];
				return false;
			}
			return $get_data;
			
		} else {
			$this->error_msg = '';
			return false; 
		}
	}
	
	/**
	 * function vms_edit
	 * 视频编辑时调用 视频改变时同步更新vms系统中对应的视频
	 * @param array $data
	 */
	public function vms_edit($data = array()) {
		if (is_array($data ) && !empty($data)) {
			//处理数据
			$data['tag'] = $this->get_tag($data);
			//将gbk编码转为utf-8编码
			if (CHARSET == 'gbk') {
				$data = array_iconv($data);
			}
			$data['sn'] = $this->ku6api_sn;
			$data['method'] = 'VideoEdit';
			$data['posttime'] = SYS_TIME;
			$data['token'] = $this->xxtea->encrypt($data['posttime'], $this->ku6api_skey);
			//向vms post数据，并获取返回值
			$this->http->post($this->ku6api_url, $data);
			$get_data = $this->http->get_data();
			$get_data = json_decode($get_data, true);
			if($get_data['code'] != 200) {
				$this->error_msg = $get_data['msg'];
				return false;
			}
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * function delete_v
	 * 删除视频时，通知vms系统接口。
	 * @param string $ku6vid vms系统中ku6vid
	 */
	public function delete_v($ku6vid = '') {
		if (!$ku6vid) return false;
		//构造post数据
		$data['sn'] = $this->ku6api_sn;
		$data['method'] = 'VideoDel';
		$data['posttime'] = SYS_TIME;
		$data['token'] = $this->xxtea->encrypt($data['posttime'], $this->ku6api_skey);
		$data['vid'] = $ku6vid;
		//向vms post数据
		$this->http->post($this->ku6api_url, $data);
		$get_data = $this->http->get_data();
		$get_data = json_decode($get_data, true);
		if($get_data['code'] != 200 && $get_data['code']!=112) {
			$this->error_msg = $get_data['msg'];
			return false;
		}
		return true;
	}
	/**
	 * 
	 * 获取视频tag标签
	 * @param array $data 视频信息数组
	 * @return string $tag 标签
	 */
	private function get_tag($data = array()) {
		if (is_array($data) && !empty($data)) {
			if ($data['keywords']) $tag = trim(strip_tags($data['keywords']));
			else $tag = $data['title'];
			return $tag;
		}
	}
	
	/**
	 * function update_video_status_from_vms
	 * 视频状态改变接口
	 * @param array $get 视频信息
	 */
	public function update_video_status_from_vms() {
		if (is_array($_GET) && !empty($_GET)) {
			$size = $_GET['size'];
			$timelen = intval($_GET['timelen']);
			$status = intval($_GET['ku6status']);
			$vid = $_GET['vid'];
			$picpath = format_url($_GET['picpath']);
			//验证数据
			/* 验证vid */
			if(!$vid) return json_encode(array('status'=>'101','msg'=>'vid not allowed to be empty'));
			/* 验证视频大小 */
			if($size<100) return json_encode(array('status'=>'103','msg'=>'size incorrect'));
			/* 验证视频时长 */
			if($timelen<1) return json_encode(array('status'=>'104','msg'=>'timelen incorrect'));
			
			$db = pc_base::load_model('video_store_model');
			$r = $db->get_one(array('vid'=>$vid));
			if ($r) {
				$db->update(array('size'=>$size, 'picpath'=>$picpath, 'status'=>$status), array('vid'=>$vid));
				if ($status==21) {
					$r = $video_store_db->get_one(array('vid'=>$vid), 'videoid'); //取出videoid，以便下面操作
					$videoid = $r['videoid'];
					/**
					 * 加载视频内容对应关系数据模型，检索与删除视频相关的内容。
					 * 在对应关系表中找出对应的内容id，并更新内容的静态页
					 */
					$video_content_db = pc_base::load_model('video_content_model');
					$result = $video_content_db->select(array('videoid'=>$videoid));
					if (is_array($result) && !empty($result)) {
						//加载更新html类
						$html = pc_base::load_app_class('html', 'content');
						$content_db = pc_base::load_model('content_model');
						$url = pc_base::load_app_class('url', 'content');
						foreach ($result as $rs) {
							$modelid = intval($rs['modelid']);
							$contentid = intval($rs['contentid']);
							$content_db->set_model($modelid);
							$content_db->update(array('status'=>99), array('id'=>$contentid));
							$table_name = $content_db->table_name;
							$r1 = $content_db->get_one(array('id'=>$contentid));
							/**
							 * 判断如果内容页生成了静态页，则更新静态页
							 */
							if (ishtml($r1['catid'])) {
								$content_db->table_name = $table_name.'_data';
								$r2 = $content_db->get_one(array('id'=>$contentid));
								$r = array_merge($r1, $r2);unset($r1, $r2);
								if($r['upgrade']) {
									$urls[1] = $r['url'];
								} else {
									$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
								}
								$html->show($urls[1], $r, 0, 'edit');
							} else {
								continue;
							}
						}
					}
				} elseif ($data['status']<0 || $data['status']==24) {
					$r = $video_store_db->get_one(array('vid'=>$vid), 'videoid'); //取出videoid，以便下面操作
					$videoid = $r['videoid'];
					//$video_store_db->delete(array('vid'=>$vid)); //删除此视频
					/**
					 * 加载视频内容对应关系数据模型，检索与删除视频相关的内容。
					 * 在对应关系表中解除关系，并更新内容的静态页
					 */
					$video_content_db = pc_base::load_model('video_content_model');
					$result = $video_content_db->select(array('videoid'=>$videoid));
					if (is_array($result) && !empty($result)) {
						//加载更新html类
						$html = pc_base::load_app_class('html', 'content');
						$content_db = pc_base::load_model('content_model');
						$url = pc_base::load_app_class('url', 'content');
						foreach ($result as $rs) {
							$modelid = intval($rs['modelid']);
							$contentid = intval($rs['contentid']);
							$video_content_db->delete(array('videoid'=>$videoid, 'contentid'=>$contentid, 'modelid'=>$modelid));
							$content_db->set_model($modelid);
							$table_name = $content_db->table_name;
							$r1 = $content_db->get_one(array('id'=>$contentid));
							/**
							 * 判断如果内容页生成了静态页，则更新静态页
							 */
							if (ishtml($r1['catid'])) {
								$content_db->table_name = $table_name.'_data';
								$r2 = $content_db->get_one(array('id'=>$contentid));
								$r = array_merge($rs, $r2);unset($r1, $r2);
								if($r['upgrade']) {
									$urls[1] = $r['url'];
								} else {
									$urls = $url->show($r['id'], '', $r['catid'], $r['inputtime']);
								}
								$html->show($urls[1], $r, 0, 'edit');
							} else {
								continue;
							}
						}
					}
				}
				return json_encode(array('status'=>'200','msg'=>'Success'));
			} else {
				return json_encode(array('status'=>'107','msg'=>'Data is empty!'));
			}
		}
		json_encode(array('status'=>'107','msg'=>'Data is empty!'));
	}
	
	/**
	 * function get_categroys
	 * 将cms系统中视频模型的栏目取出来，并通过接口传到vms系统中
	 * @param bloon $isreturn 是否返回option
	 * @param int $catid 被选中的栏目 id
	 */
	public function get_categorys($isreturn = false, $catid = 0) {
		$siteid = get_siteid();
		$sitemodel_field = pc_base::load_model('sitemodel_field_model');
		$result = $sitemodel_field->select(array('formtype'=>'video', 'siteid'=>$siteid), 'modelid');
		if (is_array($result)) {
			$models = '';
			foreach ($result as $r) {
				$models .= $r['modelid'].',';
			}
		}
		$models = substr(trim($models), 0, -1);
		$cat_db = pc_base::load_model('category_model');
		if ($models) {
			$where = '`modelid` IN ('.$models.') AND `type`=0 AND `siteid`=\''.$siteid.'\'';
			$result = $cat_db->select($where, '`catid`, `catname`, `parentid`, `siteid`, `child`');
			if (is_array($result)) {
				$data = $return_data = array();
				foreach ($result as $r) {
					$sitename = $this->get_sitename($r['siteid']);
					$data[] = array('catid'=>$r['catid'], 'catname'=>$r['catname'], 'parentid'=>$r['parentid'], 'siteid'=>$r['siteid'], 'sitename'=>$sitename, 'child'=>$r['child']);
					$r['disabled'] = $r['child'] ? 'disabled' : '';
					if ($r['catid'] == $catid) { 
						$r['selected'] = 'selected';
					}
					$return_data[$r['catid']] = $r;
					
				}
				//将gbk编码转为utf-8编码
				if (strtolower(CHARSET) == 'gbk') {
					$data = array_iconv($data);
				}
				$data = json_encode($data);	
				$postdata['sn'] = $this->ku6api_sn;
				$postdata['method'] = 'UserCat';
				$postdata['posttime'] = SYS_TIME;
				$postdata['token'] = $this->xxtea->encrypt($postdata['posttime'], $this->ku6api_skey);
				$postdata['data'] = $data;
				//向vms post数据，并获取返回值
				$this->http->post($this->ku6api_url, $postdata);
				$get_data = $this->http->get_data();
				$get_data = json_decode($get_data, true);
				if($get_data['code'] != 200) {
					$this->error_msg = $get_data['msg'];
					return false;
				} elseif ($isreturn) {
					$tree = pc_base::load_sys_class('tree');
					$str  = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";

					$tree->init($return_data);
					$string = $tree->get_tree(0, $str);
					return $string;
				} else {
					return true;
				}
			}
		}
		return array();
	}
	
	/**
	 * function get_ku6_channels
	 * 获取ku6的频道信息
	 */
	public function get_subscribetype() {
		//构造post数据
		$postdata['method'] = 'SubscribeType';
		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		}
		return false;
	}
	
	/**
	 * function get_ku6_channels
	 * 获取ku6的频道信息
	 */
	public function get_ku6_channels() {
		//构造post数据
		$postdata['method'] = 'Ku6Channel';
		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		}
		return false;
	}
	
	/**
	 * function subscribe 订阅处理
	 * 该方法将用户的订阅信息post到vms里面记录
	 * @param array $data 推送信息 例如： array(array('channelid'=>102000, 'catid'=>16371, 'posid'=>8))
	 */
	public function subscribe($datas = array()) {
		//构造post数据
		$postdata['method'] = 'SubscribeAdd';
		$postdata['channelid'] = $datas['channelid'];
		$postdata['catid'] = $datas['catid'];
		$postdata['posid'] = $datas['posid'] ? $datas['posid'] : 0;

		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return $data;
		}
		return false;
	} 
	
	/**
	 * Function sub_del 删除订阅
	 * 用户删除订阅
	 * @param int $id 订阅id
	 */
	public function sub_del($id = 0) {
		if (!$id) return false;
		//构造post数据
		$postdata['method'] = 'SubscribeDel';
		$postdata['sid'] = $id;
		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return true;
		}
		return false;
	}
	
	/**
	 * fucntion get_subscribe 获取订阅
	 * 获取自己的订阅信息
	 */	
	public function get_subscribe() {
		//构造post数据
		$postdata['method'] = 'SubscribeSearch';
		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		} else {
			return false;
		}
	}
	
	/**
	 * Function flashuploadparam 获取flash上传条属性
	 * 获取flash上传条属性
	 */
	public function flashuploadparam () {
		//构造post数据
		$postdata['method'] = 'GetFlashUploadParam';
		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Function get_albums
	 * 获取ku6专辑列表
	 * @param int $page 当前页数
	 * @param int $pagesize 每页数量
	 * @return array 返回专辑数组
	 */
	public function get_albums($page = 1, $pagesize = 20) {
		//构造post数据
		if ($_GET['start_time']) {
			$postdata['start_time'] = strtotime($_GET['start_time']);
		}
		if ($_GET['end_time']) {
			$postdata['end_time'] = strtotime($_GET['end_time']);
		}
		if ($_GET['keyword']) {
			$postdata['key'] = addslashes($_GET['keyword']);
			if (strtolower(CHARSET) == 'gbk') {
				$postdata['key'] = iconv('gbk', 'utf-8', $postdata['key']);
			}
		}
		if ($_GET['categoryid']) {
			$postdata['categoryid'] = intval($_GET['categoryid']);
		}
		$postdata['method'] = 'AlbumList';
		$postdata['start'] = ($page-1)*$pagesize;
		$postdata['size'] = $pagesize;
		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return $data;
		} else {
			return false;
		}
	}
	
	/**
	 * Function get_album_videoes
	 * 获取某专辑下的视频列表
	 * @param int $albumid 专辑ID
	 * @param int $page 当前页
	 * @param int $pagesize 每页数量
	 * @return array 视频数组
	 */
	public function get_album_videoes($albumid = 0, $page = 1, $pagesize = 20) {
		//构造post数据
		$postdata['method'] = 'AlbumVideoList';
		$postdata['p'] = $page;
		$postdata['playlistid'] = $albumid;
		$postdata['s'] = $pagesize;
		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return $data['data'];
		} else {
			return false;
		}
	}
	
	/**
	 * Function get_album_info
	 * 获取专辑的详细信息
	 * @param int $albumid 专辑id
	 */
	public function get_album_info($albumid = 0) {
		$albumid = intval($albumid);
		if (!$albumid) return false;
		$arr = array('method'=>'GetOneAlbum', 'id'=>$albumid);
		if ($data = $this->post($arr)) {
			return $data['list'];
		} else {
			return false;
		}
	}
	
	/**
	 * Function add_album_subscribe
	 * 添加专辑订阅
	 * @param array $data 订阅数组 如：array(0=>array('specialid'=>1, 'id'=>1232131), 1=>array('specialid'=>2, 'id'=>4354323))
	 */
	public function add_album_subscribe($data = array()) {
		if (!is_array($data) || empty($data)) {
			return false;
		}
		//构造post数据
		$postdata['method'] = 'AlbumVideoSubscribe';
		$postdata['data'] = $data;
		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Function member_login_vms
	 * 登陆后台同时登陆vms
	 * @param array $data
	 */
	public function member_login_vms() {
		//构造post数据
		$postdata = array();
		$postdata['method'] = 'SynLogin';
		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Function http
	 * 执行http post数据到接口
	 * @param array $datas post数据参数 如：array('method'=>'AlbumVideoList', 'p'=>1, 's'=>6,....)
	 */
	private function post($datas = array()) {
		//构造post数据
		$data['sn'] = $this->ku6api_sn;
		$data['posttime'] = SYS_TIME;
		$data['token'] = $this->xxtea->encrypt($data['posttime'], $this->ku6api_skey);
		if (is_array($datas)) {
			foreach ($datas as $_k => $d) {
				if (is_array($d)) {
					$data[$_k] = json_encode($d);
				} else {
					$data[$_k] = $d;
				}
			}
		}
		//向vms post数据，并获取返回值
		$this->http->post($this->ku6api_url, $data);
		$get_data = $this->http->get_data();
		$get_data = json_decode($get_data, true);
		//成功时vms返回code=200 而ku6返回status=1
		if ($get_data['code'] == 200 || $get_data['status'] == 1) {
			//将gbk编码转为utf-8编码
			if (strtolower(CHARSET) == 'gbk') {
				$get_data = array_iconv($get_data, 'utf-8', 'gbk');
			}
			return $get_data;
		} else {
			return false;
		}
	}
	
	/**
	 * Function CHECK
	 * 向vms发送vid
	 * @param string $vid vid
	 */
	public function check($vid = '') {
		if (!$vid) return false;
		//构造post数据
		$postdata['method'] = 'GetVid';
		$postdata['vid'] = $vid;
		$postdata['url'] = APP_PATH . 'api.php?op=video_api';
		//向vms post数据，并获取返回值
		if ($data = $this->post($postdata)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Function Preview
	 * 向vms请求vid
	 * @param string $vid vid
	 */
	public function Preview($vid = '') {
		if (!$vid) return false;
		//构造post数据
		$postdata['method'] = 'Preview';
		$postdata['vid'] = $vid;
		//向vms post数据，并获取返回值
 		if ($data = $this->post($postdata)) {
			return $data;
		} else { 
  			return false;
		}
	}
	
	/**
	 * Function Ku6search
	 * 向vms请求搜索
	 * @param string $vid vid
	 */
	public function Ku6search($keyword,$pagesize,$page,$len,$fenlei,$fq) { 
		//构造post数据
		$postdata['method'] = 'search';
		$postdata['pagesize'] = $pagesize;
		$postdata['keyword'] = $keyword;
		$postdata['page'] = $page;
		$postdata['fenlei'] = $fenlei;
		$postdata['len'] = $len;
		$postdata['fq'] = $fq;
		
 		//向vms post数据，并获取返回值
 		if ($data = $this->post($postdata)) { 
  			return $data;
		} else { 
 			echo '没有返回数据！';exit;
   			return false;
		}
	}
	/**
	 * Function get_sitename
	 * 获取站点名称
	 */
	private function get_sitename($siteid) {
		static $sitelist;
		if (!$sitelist) {
			$sitelist = getcache('sitelist', 'commons');
		}
		return $sitelist[$siteid]['name'];

	}

	/**
	 * Function testapi
	 * 测试接口配置是否正确
	 */
	public function testapi() {
		$postdata['method'] = 'Test';
		$data = $this->post($postdata);
		if ($data['code']==200) {
			return true;
		} else {
			return false;
		}
	}
}