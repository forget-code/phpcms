<?php
/**
 * Description:
 *
 * Encoding:    GBK
 * Created on:  2012-5-7-下午2:11:42
 * Author:      kangyun
 * Email:       KangYun.Yun@Snda.Com
 */

defined ( 'IN_PHPCMS' ) or exit ( 'No permission resources.' );

class maillist_tag {
	private $maillist;
	
	public function __construct() {
		$this->maillist = pc_base::load_model ( 'maillist_model' );		
	}
	
	public function get_wzz()
	{
		$cond = array(
				'domain' => SITE_URL
		);
		$maillist = $this->maillist->get_one($cond, 'wzz, is_activate, group_name');
		return $maillist;
	}

}