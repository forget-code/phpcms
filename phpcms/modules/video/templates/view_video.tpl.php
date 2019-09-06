<?php 
	defined('IN_ADMIN') or exit('No permission resources.');
	include $this->admin_tpl('header','admin');
?>
<embed id="video_player" name="video_player" src="<?php echo pc_base::load_config('ku6server', 'player_url').$r['vid']?>/style/<?php echo $video_cache['style_projectid']?>/" height="350" width="450" quality="high" align="middle" allowScriptAccess="always" allowfullscreen="true" flashvars="auto=1&api=1&adss=0" type="application/x-shockwave-flash"></embed>