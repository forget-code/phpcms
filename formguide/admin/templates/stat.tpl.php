<?php defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>

	<table cellpadding="0" cellspacing="1" class="table_list">
		<caption>“<?=$formname?>”统计</caption>
		<?php
		foreach($infos AS $info) { ?>
		<tr>
			<td width="35%" class="align_l">
				<strong ><?=$info['name']?><BR><?=$info['tips']?></strong>
			</td>
			<td>
				<table cellpadding="0" cellspacing="1" class="table_list">
				<?php
				$setting = string2array($info['setting']);
				$setting = $setting['options'];
				$settings = explode("\n",$setting);
				foreach($settings AS $_k=>$_v)
				{
					$_key = $_kv = $_v;
					if(strpos($_v,'|')!==false)
					{
						$xs = explode('|',$_v);
						$_key =$xs[0];
						$_kv =$xs[1];
					}
					?>
					<tr>
					<td width="35%" class="align_l">
					<?=$_k+1?>、<?=$_key?>
					</td>
					<td>
						<?php
						$number = 0;
						foreach($datas AS $__k=>$__v)
						{
							if(trim($__v[$info['field']])==trim($_kv))  $number++;
						}
						echo $number;
						?>
					</td>
					</tr>
				<?php 
					}?>
				</table>

			</td>
		</tr>
		<?php }?>
		</table>
</body>
</html>