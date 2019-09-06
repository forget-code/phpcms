<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<script type="text/javascript" src="images/js/thickbox.js"></script>
<link type="text/css" rel="stylesheet" href="<?=$mod;?>/images/ThickBox.css" media="screen"/>
<style type="text/css">
.gray1{color:#fff;!important;text-decoration:none; position:absolute;}
</style>

<table cellpadding="0" cellspacing="1" class="table_list">
   <tr>
    <th>时段选择</th>
    <th>排序方式</th>
    <th>选择栏目</th>
  </tr>
  <tr>
    <td width="230"><a href='?mod=video&file=stat&type=all&orderby=<?=$orderby?>&catid=<?=$catid?>' ><font color="<?php if($type=='all'){?>red<?php }?>">总统计</font></a> | <a href='?mod=video&file=stat&type=today' ><font color="<?php if($type=='today'){?>red<?php }?>">今日</font></a> | <a href='?mod=video&file=stat&type=yestoday' ><font color="<?php if($type=='yestoday'){?>red<?php }?>">昨日</font></a> | <a href='?mod=video&file=stat&type=week' ><font color="<?php if($type=='week'){?>red<?php }?>">本周</font></a> | <a href='?mod=video&file=stat&type=month' ><font color="<?php if($type=='month'){?>red<?php }?>">本月</font></a></td>
<td class="align_c">
<select name='orderby' id='orderby' onchange="if(this.value!=''){location='?mod=video&file=stat&type=<?=$type?>&catid=<?=$catid?>&orderby='+this.value;}">
<option value='0'>--请选择排序方式 --</option>
<option value='a.inputtime DESC' <?php if($orderby="a.inputtime DESC") echo "selected";?>>添加时间-降序</option>
<option value='a.inputtime ASC' <?php if($orderby="a.inputtime ASC") echo "selected";?>>添加时间-升序</option>
<option value='b.hits DESC' <?php if($orderby="b.hits DESC") echo "selected";?>>访问量-降序</option>
<option value='b.hits ASC' <?php if($orderby="b.hits ASC") echo "selected";?>>访问量-升序</option>
</select>
</td>
	<td class="align_c"><?=form::select_category($mod, 0, 'category[parentid]', 'parentid', '--请选择栏目进行浏览 --', $catid,"onchange=\"if(this.value!=''){location='?mod=$mod&file=$file&orderby=$orderby&type=$type&catid='+this.value;}\"")?></td>
  </tr>
</table>

<form name="search" method="get" action="">
<input type="hidden" name="mod" value="<?=$mod?>"> 
<input type="hidden" name="file" value="<?=$file?>"> 
<input type="hidden" name="action" value="<?=$action?>"> 
<input type="hidden" name="catid" value="<?=$catid?>">
<table cellpadding="0" cellspacing="1" class="table_list">
<tr>
<td class="align_c">
<input type="radio" name="field" value="title" <?php if($field=='title') echo 'checked';?>> 标题
<input type="radio" name="field" value="username" <?php if($field=='username') echo 'checked';?>> 用户名
<input type="radio" name="field" value="userid" <?php if($field=='userid') echo 'checked';?>> 用户ID
<input type="radio" name="field" value="vid" <?php if($field=='vid') echo 'checked';?>> 视频VID
<input type="text" name="q" value="<?=$q?>" size="20" />&nbsp;
发布时间：<?=form::date('inputdate_start')?> - <?=form::date('inputdate_end')?>&nbsp;
<input type="submit" name="dosubmit" value=" 查询 " />
</td>
</tr>
</table>
</form>
<form name="myform" method="post" action="">
<table cellpadding="0" cellspacing="1" class="table_list">
   <caption>[<?=$pagetitle?>]视频统计</caption>
<tr>
<th width="40">ID</th>
<th width="98">图片</th>
<th>标题</th>
<th width="50">总数</th>
<th width="30">今日</th>
<th width="30">昨日</th>
<th width="35">本周</th>
<th width="40">本月</th>
<th width="70">发布人</th>
<th width="105">更新时间</th>
<th width="70">管理操作</th>
</tr>
<?php 
if(is_array($infos)){
	foreach($infos as $info){
?>
<tr>
<td class="align_c"><?=$info['vid']?></td>
<td height="72" align="center"> <?php if($info['thumb']) {?><span class="gray1">02:04</span>

<img src="<?=$info['thumb'];?>" width="93" height="70"/>
<?php }?></td>

<td><a href="<?=video_show_url($info['vid'],$info['url'])?>" target="_blank"><?=output::style($info['title'], $info['style'])?></a> &nbsp;<?=$info['posids']?'<font color="green">荐</font>': ''?>&nbsp;<?=$info['typeid']?'<font color="blue">类</font>': ''?>
</br></br>所属分类：默认分类

</td>
<td class="align_c"><?=$info['hits']?></td>
<td class="align_c"><?=$info['hits_day']?></td>
<td class="align_c"><?=$info['hits_yestoday']?></td>
<td class="align_c"><?=$info['hits_week']?></td>
<td class="align_c"><?=$info['hits_month']?></td>
<td class="align_c"><a href="?mod=member&file=member&action=view&userid=<?=$info['userid']?>"><?=$info['username']?></td>
<td class="align_c"><?=date('Y-m-d H:i', $info['updatetime'])?></td>
<td class="align_c">
<a href="?mod=<?=$mod?>&file=video&action=edit&catid=<?=$catid?>&vid=<?=$info['vid']?>">编辑视频</a>
<?php if(isset($MODULE['comment'])){ ?></br> <a href="?mod=comment&file=comment&keyid=<?=$mod?>-v-<?=$info['vid']?>">查看评论</a> <?php } ?>
</br><a href="?mod=<?=$mod?>&file=video&action=priview&vid=<?=$info['vid']?>&keepThis=true&TB_iframe=true&height=293&width=385" class="thickbox">预览视频</a>
</td>
</tr>
<?php 
	}
}
?>
</table>

<div id="pages"><?=$ST->pages?></div>
</form>
<br></br>
<SCRIPT LANGUAGE="JavaScript">
<!--
function insert_special()
{
	$("#special_div").hide();
	myform.action='?mod=<?=$mod?>&file=video&action=add_to_special&specialid=<?=$specialid?>';myform.submit();
}
//-->
</SCRIPT>
</body>
</html>