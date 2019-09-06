<?php defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="10">
  <tr>
    <td></td>
  </tr>
</table>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>">
<table cellpadding="2" cellspacing="1" class="tableborder">
  <th colspan=2>基本信息</th>
     <tr>
      <td width='40%' class='tablerow'><strong>是否允许游客发表评论</strong></td>
      <td class='tablerow'><input type='radio' name='setting[ischecklogin]' id='ischecklogin' value='1' <?php echo $ischecklogin == 1 ? 'checked' : '' ?>> 是 <input type='radio' name='setting[ischecklogin]' id='ischecklogin' value='0' <?php echo $ischecklogin == 0 ? 'checked' : '' ?>> 否</td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>是否允许游客发表回复</strong></td>
      <td class='tablerow'><input type='radio' name='setting[ischeckreply]' id='ischeckreply' value='1' <?php echo $ischeckreply == 1 ? 'checked' : '' ?>> 是 <input type='radio' name='setting[ischeckreply]'  value='0' <?php echo $ischeckreply == 0 ? 'checked' : '' ?>> 否</td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>是否允许游客支持反对其他评论的观点</strong></td>
      <td class='tablerow'><input type='radio' name='setting[issupportagainst]' id='issupportagainst' value='1' <?php echo $issupportagainst == 1 ? 'checked' : '' ?>> 是 <input type='radio' name='setting[issupportagainst]' id='isagainst' value='0' <?php echo $issupportagainst == 0 ? 'checked' : '' ?>> 否</td>
    </tr>
     <tr>
      <td width='40%' class='tablerow'><strong>评论是否需要审核</strong></td>
      <td class='tablerow'><input type='radio' name='setting[ischeckcomment]' id='ischeckcomment' value='1' <?php echo $ischeckcomment == 1 ? 'checked' : '' ?>> 是 <input type='radio' name='setting[ischeckcomment]' id='ischeckcomment' value='0' <?php echo $ischeckcomment == 0 ? 'checked' : '' ?>> 否</td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>提交评论是否开启验证码</strong></td>
      <td class='tablerow'><input type='radio' name='setting[enablecheckcode]' id='enablecheckcode' value='1' <?php echo $enablecheckcode == 1 ? 'checked' : '' ?>> 是 <input type='radio' name='setting[enablecheckcode]' id='enablecheckcode' value='0' <?php echo $enablecheckcode == 0 ? 'checked' : '' ?>> 否</td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>每个评论内最多包含的表情个数</strong></td>
      <td class='tablerow'><input name='setting[maxsmilenum]' type='text' id='maxsmilenum' value='<?=$maxsmilenum?>' size='6' maxlength='4'></td>
    </tr>
        <tr>
      <td width='40%' class='tablerow'><strong>是否解析评论中的网址</strong><br />如http://www.phpcms.cn 自动加链接<br/><a href="http://www.phpcms.cn" target="_blank">http://www.phpcms.cn</a></td>
      <td class='tablerow'><input type='radio' name='setting[enableparseurl]' id='enableparseurl' value='1' <?php echo $enableparseurl == 1 ? 'checked' : '' ?>> 是 <input type='radio' name='setting[enableparseurl]'  value='0' <?php echo $enableparseurl == 0 ? 'checked' : '' ?>> 否</td>
    </tr>
        <tr>
      <td width='40%' class='tablerow'><strong>是否屏蔽评论中的网址<br />(屏蔽设置为是后解析自动不生效)</strong><br />如http://www.phpcms.cn 自动屏蔽为<br/>http://www.*****.cn</td>
      <td class='tablerow'><input type='radio' name='setting[enablekillurl]' id='enablekillurl' value='1' <?php echo $enablekillurl == 1 ? 'checked' : '' ?>> 是 <input type='radio' name='setting[enablekillurl]'  value='0' <?php echo $enablekillurl == 0 ? 'checked' : '' ?>> 否</td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>评论内容最小字节数</strong></td>
      <td class='tablerow'><input name='setting[mincontent]' type='text' id='mincontent' value='<?=$mincontent?>' size='6' maxlength='6'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>评论内容最大字节数</strong></td>
      <td class='tablerow'><input name='setting[maxcontent]' type='text' id='maxcontent' value='<?=$maxcontent?>' size='6' maxlength='6'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>评论表情保存目录</strong></td>
      <td class='tablerow'><input name='setting[uploaddir]' type='text' id='uploaddir' value='<?=$uploaddir?>' readonly  size='20' maxlength='50'></td>
    </tr>
    <tr>
      <td width='40%' class='tablerow'><strong>启用/禁用评论</strong><br>可以按模块选择是否开启评论功能</td>
      <td class='tablerow'><?=$link?></td>
    </tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
     <td width='40%'></td>
     <td><input type="submit" name="dosubmit" value=" 确定 ">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重置 "></td>
  </tr>
</table>
</form>
</body>
</html>