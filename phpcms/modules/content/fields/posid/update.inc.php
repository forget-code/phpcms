	function posid($field, $value) {
		if(!empty($value) && is_array($value)) {
			if(REOUTE_A=='add') {
				$position_data_db = pc_base::load_model('position_data_model');
				foreach($value as $r) {
					if($r!='-1') $position_data_db->insert(array('id'=>$this->id,'posid'=>$r,'module'=>'content','modelid'=>$this->modelid));
				}
			} else {
				$posids = array();
				$catid = $this->data['catid'];
				$push_api = pc_base::load_app_class('push_api','admin');
				foreach($value as $r) {
					if($r!='-1') $posids[] = $r;
				}
				$textcontent = array();
				foreach($this->fields AS $_key=>$_value) {
					if($_value['isposition']) {
						$textcontent[$_key] = $this->data[$_key];
					}
				}
				//颜色选择为隐藏域 在这里进行取值
				$textcontent['style'] = $_POST['style_color'] ? strip_tags($_POST['style_color']) : '';
				$textcontent['inputtime'] = strtotime($textcontent['inputtime']);
				if($_POST['style_font_weight']) $textcontent['style'] = $textcontent['style'].';'.strip_tags($_POST['style_font_weight']);
				$push_api->position_update($this->id, $this->modelid, $catid, $posids, $textcontent);
			}
		}
	}
