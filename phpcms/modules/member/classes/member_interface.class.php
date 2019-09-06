<?php
/**
 * 会员接口
 *
 */
class member_interface {
	//数据库连接
	private $db;
	public function __construct() {
		$this->db = pc_base::load_model('member_model');
	}
	
	/**
	 * 获取用户信息
	 * @param $username 用户名
	 * @param $type {1:用户id;2:用户名;3:email}
	 * @return $mix {-1:用户不存在;userinfo:用户信息}
	 */
	public function get_member_info($mix, $type=1) {
		if($type==1) {
			$userinfo = $this->db->get_one(array('userid'=>$mix));
		} elseif($type==2) {
			$userinfo = $this->db->get_one(array('username'=>$mix));
		} elseif($type==3) {
			if(!$this->_is_email($mix)) {
				return -4;
			}
			$userinfo = $this->db->get_one(array('email'=>$mix));
		}
		if($userinfo) {
			return $userinfo;
		} else {
			return -1;
		}
	}
	
	/**
	 * 将文章加入收藏夹
	 * @param int $cid 文章id
	 * @param int $userid 会员id
	 * @param string $title 文章标题
	 * @param $mix {-1:加入失败;$id:加入成功，返回收藏id}
	 */
	public function add_favorite($cid, $userid, $title) {
		$this->favorite_db = pc_base::load_model('favorite_model');
		$id = $this->favorite_db->insert(array('title'=>$title,'userid'=>$userid, 'cid'=>$cid, 'adddate'=>SYS_TIME), 1);
		if($id) {
			return $id;
		} else {
			return -1;
		}
	}

	/**
	 * 添加好友
	 * @param int $friendid	好友id
	 * @param int $userid	用户id
	 * @param int $phpssouid	phpssouid
	 * @param string $username 好友用户名
	 * @param bool {1:成功}
	 */
	public function add_friend($friendid, $userid, $phpssouid, $username) {
		$this->favorite_db = pc_base::load_model('friend_model');
		$this->friend_db->insert(array('userid'=>$userid,'phpssouid'=>$phpssouid, 'friendid'=>$friendid, 'username'=>$username), 1);
		return 1;
	}
}