	
	function video($field, $value) {
		$post_f = $field.'_video';
		if (isset($_POST[$post_f]) && !empty($_POST[$post_f])) {
			$value = 1;
			$video_store_db = pc_base::load_model('video_store_model');
			$setting = getcache('video', 'video');
			pc_base::load_app_class('ku6api', 'video', 0);
			$ku6api = new ku6api($setting['sn'], $setting['skey']);
			pc_base::load_app_class('v', 'video', 0);
			$v_class =  new v($video_store_db);
			foreach ($_POST[$post_f] as $_k => $v) {
				if (!$v['vid'] && !$v['videoid']) unset($_POST[$post_f][$_k]);
				$info = array();
				if ($v['vid']) {
					if (!$v['title']) $v['title'] = safe_replace($this->data['title']);
					$info = array('vid'=>$v['vid'], 'title'=>$v['title']);
					$get_data = $ku6api->vms_add($info);
					if (!$get_data) {
						continue;
					}
					$info['vid'] = $get_data['vid'];
					$info['addtime'] = SYS_TIME;
					$videoid = $v_class->add($info);
					$GLOBALS[$field][] = array('videoid' => $videoid, 'listorder' => $v['listorder']);
				} else {
					$GLOBALS[$field][] = array('videoid' => $v['videoid'], 'listorder' => $v['listorder']);
				}
			}
		} else {
			$value = 0;
		}
		return $value;
	}
