<?php 
	defined('IN_PHPCMS') or exit('Access Denied');
	include admin_tpl('header');
	$myUrl='admin.php?mod=ads&file=ads&action=detail&adsid='.$adsid;
?>

<script language="javascript">

	function myform_submit(pv){
		obj=document.getElementById('domain');
		d=encodeURIComponent(obj.value);
		obj=document.getElementById('timebegin');
		tb=encodeURIComponent(obj.value);
		obj=document.getElementById('timeend');
		te=encodeURIComponent(obj.value);
		obj=document.getElementById('areaaaa');
		area=obj.value;
		obj=document.getElementById('referererer');
		referer=encodeURIComponent(obj.value);
		window.location='<?=$myUrl?>&domain='+d+'&timebegin='+tb+'&timeend='+te+'&area='+area+'&referer='+referer+'&pv='+pv;
	}
	function myexport(a){
		obj=document.getElementById('domain');
		d=encodeURIComponent(obj.value);
		obj=document.getElementById('timebegin');
		tb=encodeURIComponent(obj.value);
		obj=document.getElementById('timeend');
		te=encodeURIComponent(obj.value);
		obj=document.getElementById('areaaaa');
		area=obj.value;
		obj=document.getElementById('referererer');
		referer=encodeURIComponent(obj.value);
		a.href='admin.php?mod=ads&file=ads&action=detailexport&adsid=<?=$adsid?>&domain='+d+'&timebegin='+tb+'&timeend='+te+'&area='+area+'&referer='+referer+'&pv=<?=$pv?>';
		return true;
	}
</script>

<table cellpadding="0" cellspacing="0" class="table_list">
	<tr>
		<td><a href="admin.php?mod=ads&file=ads&action=stat&adsid=<?=$adsid?>&domain=<?=urlencode($domain)?>">广告统计</a></td>
		<td>详细<?=$pv?'点击':'浏览'?>记录</td>
	</tr>
  	<tr> 
	  	<td colspan="2" align="left">
	  		选择站点<select id="domain" onchange="myform_submit(<?=$pv?>)">
		  	<?php
		  		foreach ($domains as $k=>$v){
		  			if($k==$domain)
		  				echo "<option selected value='$k'>$v</option>";
		  			else 
		  				echo "<option value='$k'>$v</option>";
		  		}
		  	?>
		  	</select>
		  	<br/>
	    	开始时间:<?=form::date('timebegin',$timebegin,1)?>
	    	结束时间:<?=form::date('timeend',$timeend,1)?>
		  	<br/>
	    	地域:<select id='areaaaa' onchange="myform_submit(<?=$pv?>)">
	    	<?php
	    		foreach ($areas as $k=>$v) {
	    			if($k==$area)
	    				echo "<option selected value='$k'>$v</option>";
	    			else 
	    				echo "<option value='$k'>$v</option>";
	    		}
	    	?>
	    	</select>
		  	<br/>
	    	引用页面:<input type="text" id="referererer" value="<?=$referer?>" />
		  	<br/>
	    	<input type="button" onclick="myform_submit(1)" value="查看点击记录" />
	    	<input type="button" onclick="myform_submit(0)" value="查看浏览记录" />
	    </td>
  	</tr>
	<tr>
		<td valign="top" colspan="2">
    		<table>
    		<tr>
    		<td colspan="6">
    		<a href="#" onclick="myexport(this)">导出</a>
    		</td>
    		</tr>
    		
    		<tr>
    			<?php
    				$head=$pv?'浏览':'点击';
					$title=array('站点','引用页面','访问者账号','访问者IP','所属区域',$head.'时间');
					foreach ($title as $head){
				?>
					<td><?=$head?></td>
				<?php
					}
    			?>
    		</tr>
    		<?php
    			foreach($data as $row){
			?>
				<tr>
					<td><?=$row['domain']?></td>
					<td><?=$row['referer']?></td>
					<td><?=$row['username']?></td>
					<td><?=$row['ip']?></td>
					<td><?=$row['area']?></td>
					<td><?=date('Y-m-d H:i:s',$row['click_time'])?></td>
				</tr>
			<?php
    			}
    		?>
    		</table>
    		<?=$pages?>    		
		</td>	
	</tr>
</table>
	
	
</body>
</html>