<?php
/**
 *  position_api.class.php 推荐至推荐位接口类
 *
 * @copyright			(C) 2005-2010 PHPCMS
 * @license				http://www.phpcms.cn/license/
 * @lastmodify			2010-8-3
 */

defined('IN_PHPCMS') or exit('No permission resources.');

class push_api {
 	private $db, $pos_data; //数据调用属性
 	
	public function __construct() {
		$this->db = pc_base::load_model('position_model');  //加载数据模型
	}
	
	/**
	 * 推荐位推送修改接口
	 * 适合在文章发布、修改时调用
	 * @param int $id 推荐文章ID
	 * @param int $modelid 模型ID
	 * @param array $posid 推送到的推荐位ID
	 * @param array $data 推送数据
	 * 调用方式
	 * $push = pc_base::load_app_class('push_api','admin');
	 * $push->position_update(323, 25, 45, array(20,21), array('title'=>'文章标题','thumb'=>'缩略图路径','inputtime'='时间戳'));
	 */
	public function position_update($id, $modelid, $catid, $posid, $data) {
		$arr = $param = array();
		$id = intval($id);
		if($id == '0') return false;
		$modelid = intval($modelid);
		$data['inputtime'] = $data['inputtime'] ? $data['inputtime'] : SYS_TIME;
		
		//组装属性参数
		$arr['modelid'] = $modelid;
		$arr['catid'] =  $catid;
		$arr['posid'] =  $posid;
		$arr['dosubmit'] =  '1';
		
		//组装数据
		$param[0] = $data;
		$param[0]['id'] = $id;
		$pos_info = $this->position_del($catid, $id, $posid);
		return $this->position_list($param, $arr) ? true : false;
	}
	
	/**
	 * 推荐位删除计算
	 * Enter description here ...
	 * @param int $catid 栏目ID
	 * @param int $id 文章id
	 * @param array $input_posid 传入推荐位数组
	 */
	private function position_del($catid,$id,$input_posid) {
		$array = array();
		$pos_data = pc_base::load_model('position_data_model');
		
		//查找已存在推荐位
		$r = $pos_data->select(array('id'=>$id,'catid'=>$catid),'posid');
		if(!$r) return false;
		foreach ($r as $v) $array[] = $v['posid'];
		
		//差集计算，需要删除的推荐
		$real_posid = implode(',', array_diff($array,$input_posid));
		
		if (!$real_posid) return false;
		
		$sql = "`catid`='$catid' AND `id`='$id' AND `posid` IN ($real_posid)";	
		return $pos_data->delete($sql) ? true : false;
	}
	
	/**
	 * 判断文章是否被推荐
	 * @param $id
	 * @param $modelid
	 */
	private function content_pos($id, $modelid) {
		$id = intval($id);
		$modelid = intval($modelid);
		if ($id && $modelid) {
			$db_data = pc_base::load_model('position_data_model');
			$this->db_content = pc_base::load_model('content_model');
			$MODEL = getcache('model','commons');
			$this->db_content->table_name = $this->db_content->db_tablepre.$MODEL[$modelid]['tablename'];		
			$posids = $db_data->get_one(array('id'=>$id,'modelid'=>$modelid)) ? 1 : 0;
			if ($posids==0) $this->db_content->update(array('posids'=>$posids),array('id'=>$id));
		}
		return true;
	}

	/**
	 * 接口处理方法
	 * @param array $param 属性 请求时，为模型、栏目数组。提交添加为二维信息数据 。例：array(1=>array('title'=>'多发发送方法', ....))
	 * @param array $arr 参数 表单数据，只在请求添加时传递。 例：array('modelid'=>1, 'catid'=>12); 
	 */
	public function position_list($param = array(), $arr = array()) {
		if ($arr['dosubmit']) {
			$db = pc_base::load_model('content_model');
			$modelid = intval($arr['modelid']);
			$catid = intval($arr['catid']);
			$db->set_model($modelid);
			$info = array();
			$pos_data = pc_base::load_model('position_data_model');
			$position_info = getcache('position', 'commons');
			$fulltext_array = getcache('model_field_'.$modelid,'model');
			if (is_array($arr['posid']) && !empty($arr['posid']) && is_array($param) && !empty($param)) {
				foreach ($arr['posid'] as $pid) {
					foreach ($param as $d) {
						$info['id'] = $info['listorder'] = $d['id'];
						$info['catid'] = $catid;
						$info['posid'] = $pid;
						$info['module'] = 'content';
						$info['modelid'] = $modelid;
						foreach($fulltext_array AS $key=>$value){
							if($value['isposition']) {
								if ($d[$key]) $info['data'][$key] = $d[$key];
							}
						}
						//颜色选择为隐藏域 在这里进行取值
						$info['data']['style'] = $d['style'];
						$info['thumb'] = $info['data']['thumb'] ? 1 : 0;
						$info['siteid'] = get_siteid();
						$info['data'] = array2string($info['data']);
						
						if ($r = $pos_data->get_one(array('id'=>$d['id'], 'posid'=>$pid, 'catid'=>$info['catid']))) {
							if($r['synedit'] == '0') $pos_data->update($info, array('id'=>$d['id'], 'posid'=>$pid, 'catid'=>$info['catid']));
						} else {
							$pos_data->insert($info);
						}
						$db->update(array('posids'=>1), array('id'=>$d['id']));
						unset($info);
					}
					$maxnum = $position_info[$pid]['maxnum']+4;
					$r = $pos_data->select(array('catid'=>$catid, 'posid'=>$pid), 'id, listorder', $maxnum.',1', 'listorder DESC, id DESC');
					if ($r && $position_info[$pid]['maxnum']) {
						$listorder = $r[0]['listorder'];
						$where = '`catid`='.$catid.' AND `posid`='.$pid.' AND `listorder`<'.$listorder;
						$result = $pos_data->select($where, 'id, modelid');
						foreach ($result as $r) {
							$pos_data->delete(array('id'=>$r['id'], 'posid'=>$pid, 'catid'=>$catid));
							$this->content_pos($r['id'], $r['modelid']);
						}
					}
				}
			}
			return true;
			
		} else {
			$infos = $info = array();
			$where = '1';
			$siteid = get_siteid();
			$category = getcache('category_content_'.$siteid,'commons');
			$positions = getcache('position', 'commons');
			if(!empty($positions)) {
				foreach ($positions as $pid => $p) {
					if ($p['catid']) $catids = array_keys((array)subcat($p['catid'], 0, 1));
					if (($p['siteid']==0 || $p['siteid']==$siteid) && ($p['modelid']==0 || $p['modelid']==$param['modelid']) && ($p['catid']==0 || in_array($param['catid'], $catids))) {
						$info[$pid] = $p['name'];
					}
				}
				return array(
					'posid' => array('name'=>L('position'), 'htmltype'=>'checkbox', 'defaultvalue'=>'', 'data'=>$info, 'validator'=>array('min'=>1)),
				);
			}
		}
	}
 }
 
 ?>