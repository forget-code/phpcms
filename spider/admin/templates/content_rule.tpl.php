<?php
echo <<<END
<th colspan=2>内容规则</th>
    <tr>
    <td  class='tablerow'><strong>规则说明</strong>:<br></td>
    <td class='tablerow'><font color="blue">匹配信息</font><br>填入能够包裹起匹配的前后两段唯一字符串<br>
	<font color="blue">信息替换删除</font><br>1、替换为排除和合并在一起的，将第二项留空，替换为空即相当于排除<br>
		2、不用使用用正则，变动的代码使用(*)代替即可<br>
		3、当替换次数不止一次时，两项均使用(|)分割多个替换条件。如配置abcd(|)xyz替换为1(|)2即将abcd替换为1，xyz替换为2</td>
  </tr>
    <tr bgcolor="#CCFFCC">
    <td colspan="2"  style="cursor:hand" onClick="ShowLabel('标题');"><table width="100%"  border="0">
        <tr>
          <td width="78%"><img src="/phpcms/images/icon/open.gif" width="18" height="18" id="标题img">
		  <strong  id='rule1name'>标题</strong>: [点击打开/隐藏标签] </td>
          <td width="22%" align="right">No.1&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  <tr  id="标题" style="display:block">
    <td width="90" class='tablerow' align="center"><font color=blue>匹配信息</font></td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">从</td>
        <td width="223"><textarea name="rule[StartStr][1]" cols="30" rows="4" id="rule1StartStr"></textarea></td>
        <td width="13">到</td>
        <td width="223"><textarea name="rule[EndStr][1]" cols="30" rows="4" id="rule1EndStr"></textarea></td>
        <td width="349">通配符:<a href="javascript:AddOnPos(document.myform.rule1StartStr,'(*)');" style="color:#3300FF;">(*)</a>
		&nbsp; 通配符:<a href="javascript:AddOnPos(document.myform.rule1EndStr,'(*)');" style="color:#3300FF;">(*)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="标题trim" style="display:block">
    <td class='tablerow'  align="center"><font color=blue>信息替换删除<br>
      </font> 后项可留空，替换为空即相当于删除 <br>
    </td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">将</td>
        <td width="223">
		<textarea name="rule[TrimStart][1]" cols="30" rows="5" id="rule1TrimStart"></textarea> </td>
        <td width="13">替换为 </td>
        <td width="223"><textarea name="rule[TrimEnd][1]" cols="30" rows="5" id="rule1TrimEnd"></textarea>          </td>
        <td width="349">替换代码通配符:<a href="javascript:AddOnPos(document.myform.rule1TrimStart,'(*)');"  style="color:#3300FF;">(*)</a>
		&nbsp; 多个替换条件间隔符:<a href="javascript:AddSeperate(document.myform.rule1TrimStart,document.myform.rule1TrimEnd,'(|)');" style="color:#3300FF;">(|)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="标题trimhtml" style="display:block">
    <td class='tablerow'  align="center"><font color=blue>Html自动清除<br>
    </font> </td>
    <td class='tablerow'>&nbsp;
        <input type="checkbox" name="rule[HtmlTrim][1][]" value="0" id="rule1HtmlTrim">
      链接&lt;a&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="1">
      换行&lt;br&gt;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="2">
      表格&lt;table&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="3">
      表格行&lt;tr&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="4">
      单元&lt;td&nbsp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="5">
      段落&lt;p&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="6">
      字体&lt;font&nbsp;
      <input name="buttonall1" type="button" onClick="HtmlTrimSelect(1,'all');" value="全选">
      <br>
&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="7">
      层&lt;div&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="8">
      Span&lt;span&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="9">
      表格体&lt;tbody&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="10">
      加粗&lt;b&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="11">
      图象&lt;img&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="12">
      空格&amp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][1][]" value="13">
      脚本&lt;script&nbsp;
      <input name="buttonnone1" type="button" onClick="HtmlTrimSelect(1,'none');" value="全空">
	  <input type="hidden" name="userlabelid" value="1"></td>
  </tr>
    <tr bgcolor="#CCFFCC">
    <td colspan="2"  style="cursor:hand" onClick="ShowLabel('内容');"><table width="100%"  border="0">
        <tr>
          <td width="78%"><img src="/phpcms/images/icon/open.gif" width="18" height="18" id="内容img">
		  <strong  id='rule2name'>内容</strong>: [点击打开/隐藏标签] </td>
          <td width="22%" align="right">No.2&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  <tr  id="内容" style="display:block">
    <td width="90" class='tablerow' align="center"><font color=blue>匹配信息</font></td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">从</td>
        <td width="223"><textarea name="rule[StartStr][2]" cols="30" rows="4" id="rule2StartStr"></textarea></td>
        <td width="13">到</td>
        <td width="223"><textarea name="rule[EndStr][2]" cols="30" rows="4" id="rule2EndStr"></textarea></td>
        <td width="349">通配符:<a href="javascript:AddOnPos(document.myform.rule2StartStr,'(*)');" style="color:#3300FF;">(*)</a>
		&nbsp; 通配符:<a href="javascript:AddOnPos(document.myform.rule2EndStr,'(*)');" style="color:#3300FF;">(*)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="内容trim" style="display:block">
    <td class='tablerow'  align="center"><font color=blue>信息替换删除<br>
      </font> 后项可留空，替换为空即相当于删除 <br>
    </td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">将</td>
        <td width="223">
		<textarea name="rule[TrimStart][2]" cols="30" rows="5" id="rule2TrimStart"></textarea> </td>
        <td width="13">替换为 </td>
        <td width="223"><textarea name="rule[TrimEnd][2]" cols="30" rows="5" id="rule2TrimEnd"></textarea>          </td>
        <td width="349">替换代码通配符:<a href="javascript:AddOnPos(document.myform.rule2TrimStart,'(*)');"  style="color:#3300FF;">(*)</a>
		&nbsp; 多个替换条件间隔符:<a href="javascript:AddSeperate(document.myform.rule2TrimStart,document.myform.rule2TrimEnd,'(|)');" style="color:#3300FF;">(|)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="内容trimhtml" style="display:block">
    <td class='tablerow'  align="center"><font color=blue>Html自动清除<br>
    </font> </td>
    <td class='tablerow'>&nbsp;
        <input type="checkbox" name="rule[HtmlTrim][2][]" value="0" id="rule2HtmlTrim">
      链接&lt;a&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="1">
      换行&lt;br&gt;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="2">
      表格&lt;table&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="3">
      表格行&lt;tr&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="4">
      单元&lt;td&nbsp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="5">
      段落&lt;p&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="6">
      字体&lt;font&nbsp;
      <input name="buttonall2" type="button" onClick="HtmlTrimSelect(2,'all');" value="全选">
      <br>
&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="7">
      层&lt;div&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="8">
      Span&lt;span&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="9">
      表格体&lt;tbody&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="10">
      加粗&lt;b&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="11">
      图象&lt;img&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="12">
      空格&amp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][2][]" value="13">
      脚本&lt;script&nbsp;
      <input name="buttonnone2" type="button" onClick="HtmlTrimSelect(2,'none');" value="全空">
	  <input type="hidden" name="userlabelid" value="2"></td>
  </tr>
    <tr bgcolor="#CCFFCC">
    <td colspan="2"  style="cursor:hand" onClick="ShowLabel('作者');"><table width="100%"  border="0">
        <tr>
          <td width="78%"><img src="/phpcms/images/icon/close.gif" width="18" height="18" id="作者img">
		  <strong  id='rule3name'>作者</strong>: [点击打开/隐藏标签] </td>
          <td width="22%" align="right">No.3&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  <tr  id="作者" style="display:none">
    <td width="90" class='tablerow' align="center"><font color=blue>匹配信息</font></td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">从</td>
        <td width="223"><textarea name="rule[StartStr][3]" cols="30" rows="4" id="rule3StartStr"></textarea></td>
        <td width="13">到</td>
        <td width="223"><textarea name="rule[EndStr][3]" cols="30" rows="4" id="rule3EndStr"></textarea></td>
        <td width="349">通配符:<a href="javascript:AddOnPos(document.myform.rule3StartStr,'(*)');" style="color:#3300FF;">(*)</a>
		&nbsp; 通配符:<a href="javascript:AddOnPos(document.myform.rule3EndStr,'(*)');" style="color:#3300FF;">(*)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="作者trim" style="display:none">
    <td class='tablerow'  align="center"><font color=blue>信息替换删除<br>
      </font> 后项可留空，替换为空即相当于删除 <br>
    </td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">将</td>
        <td width="223">
		<textarea name="rule[TrimStart][3]" cols="30" rows="5" id="rule3TrimStart"></textarea> </td>
        <td width="13">替换为 </td>
        <td width="223"><textarea name="rule[TrimEnd][3]" cols="30" rows="5" id="rule3TrimEnd"></textarea>          </td>
        <td width="349">替换代码通配符:<a href="javascript:AddOnPos(document.myform.rule3TrimStart,'(*)');"  style="color:#3300FF;">(*)</a>
		&nbsp; 多个替换条件间隔符:<a href="javascript:AddSeperate(document.myform.rule3TrimStart,document.myform.rule3TrimEnd,'(|)');" style="color:#3300FF;">(|)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="作者trimhtml" style="display:none">
    <td class='tablerow'  align="center"><font color=blue>Html自动清除<br>
    </font> </td>
    <td class='tablerow'>&nbsp;
        <input type="checkbox" name="rule[HtmlTrim][3][]" value="0" id="rule3HtmlTrim">
      链接&lt;a&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="1">
      换行&lt;br&gt;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="2">
      表格&lt;table&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="3">
      表格行&lt;tr&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="4">
      单元&lt;td&nbsp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="5">
      段落&lt;p&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="6">
      字体&lt;font&nbsp;
      <input name="buttonall3" type="button" onClick="HtmlTrimSelect(3,'all');" value="全选">
      <br>
&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="7">
      层&lt;div&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="8">
      Span&lt;span&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="9">
      表格体&lt;tbody&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="10">
      加粗&lt;b&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="11">
      图象&lt;img&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="12">
      空格&amp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][3][]" value="13">
      脚本&lt;script&nbsp;
      <input name="buttonnone3" type="button" onClick="HtmlTrimSelect(3,'none');" value="全空">
	  <input type="hidden" name="userlabelid" value="3"></td>
  </tr>
    <tr bgcolor="#CCFFCC">
    <td colspan="2"  style="cursor:hand" onClick="ShowLabel('来源');"><table width="100%"  border="0">
        <tr>
          <td width="78%"><img src="/phpcms/images/icon/close.gif" width="18" height="18" id="来源img">
		  <strong  id='rule4name'>来源</strong>: [点击打开/隐藏标签] </td>
          <td width="22%" align="right">No.4&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  <tr  id="来源" style="display:none">
    <td width="90" class='tablerow' align="center"><font color=blue>匹配信息</font></td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">从</td>
        <td width="223"><textarea name="rule[StartStr][4]" cols="30" rows="4" id="rule4StartStr"></textarea></td>
        <td width="13">到</td>
        <td width="223"><textarea name="rule[EndStr][4]" cols="30" rows="4" id="rule4EndStr"></textarea></td>
        <td width="349">通配符:<a href="javascript:AddOnPos(document.myform.rule4StartStr,'(*)');" style="color:#3300FF;">(*)</a>
		&nbsp; 通配符:<a href="javascript:AddOnPos(document.myform.rule4EndStr,'(*)');" style="color:#3300FF;">(*)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="来源trim" style="display:none">
    <td class='tablerow'  align="center"><font color=blue>信息替换删除<br>
      </font> 后项可留空，替换为空即相当于删除 <br>
    </td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">将</td>
        <td width="223">
		<textarea name="rule[TrimStart][4]" cols="30" rows="5" id="rule4TrimStart"></textarea> </td>
        <td width="13">替换为 </td>
        <td width="223"><textarea name="rule[TrimEnd][4]" cols="30" rows="5" id="rule4TrimEnd"></textarea>          </td>
        <td width="349">替换代码通配符:<a href="javascript:AddOnPos(document.myform.rule4TrimStart,'(*)');"  style="color:#3300FF;">(*)</a>
		&nbsp; 多个替换条件间隔符:<a href="javascript:AddSeperate(document.myform.rule4TrimStart,document.myform.rule4TrimEnd,'(|)');" style="color:#3300FF;">(|)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="来源trimhtml" style="display:none">
    <td class='tablerow'  align="center"><font color=blue>Html自动清除<br>
    </font> </td>
    <td class='tablerow'>&nbsp;
        <input type="checkbox" name="rule[HtmlTrim][4][]" value="0" id="rule4HtmlTrim">
      链接&lt;a&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="1">
      换行&lt;br&gt;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="2">
      表格&lt;table&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="3">
      表格行&lt;tr&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="4">
      单元&lt;td&nbsp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="5">
      段落&lt;p&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="6">
      字体&lt;font&nbsp;
      <input name="buttonall4" type="button" onClick="HtmlTrimSelect(4,'all');" value="全选">
      <br>
&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="7">
      层&lt;div&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="8">
      Span&lt;span&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="9">
      表格体&lt;tbody&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="10">
      加粗&lt;b&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="11">
      图象&lt;img&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="12">
      空格&amp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][4][]" value="13">
      脚本&lt;script&nbsp;
      <input name="buttonnone4" type="button" onClick="HtmlTrimSelect(4,'none');" value="全空">
	  <input type="hidden" name="userlabelid" value="4"></td>
  </tr>
    <tr bgcolor="#CCFFCC">
    <td colspan="2"  style="cursor:hand" onClick="ShowLabel('时间');"><table width="100%"  border="0">
        <tr>
          <td width="78%"><img src="/phpcms/images/icon/close.gif" width="18" height="18" id="时间img">
		  <strong  id='rule5name'>时间</strong>: [点击打开/隐藏标签] </td>
          <td width="22%" align="right">No.5&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  <tr  id="时间" style="display:none">
    <td width="90" class='tablerow' align="center"><font color=blue>匹配信息</font></td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">从</td>
        <td width="223"><textarea name="rule[StartStr][5]" cols="30" rows="4" id="rule5StartStr"></textarea></td>
        <td width="13">到</td>
        <td width="223"><textarea name="rule[EndStr][5]" cols="30" rows="4" id="rule5EndStr"></textarea></td>
        <td width="349">通配符:<a href="javascript:AddOnPos(document.myform.rule5StartStr,'(*)');" style="color:#3300FF;">(*)</a>
		&nbsp; 通配符:<a href="javascript:AddOnPos(document.myform.rule5EndStr,'(*)');" style="color:#3300FF;">(*)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="时间trim" style="display:none">
    <td class='tablerow'  align="center"><font color=blue>信息替换删除<br>
      </font> 后项可留空，替换为空即相当于删除 <br>
    </td>
    <td align="right" class='tablerow'><table width="98%"  border="0">
      <tr>
        <td width="13">将</td>
        <td width="223">
		<textarea name="rule[TrimStart][5]" cols="30" rows="5" id="rule5TrimStart"></textarea> </td>
        <td width="13">替换为 </td>
        <td width="223"><textarea name="rule[TrimEnd][5]" cols="30" rows="5" id="rule5TrimEnd"></textarea>          </td>
        <td width="349">替换代码通配符:<a href="javascript:AddOnPos(document.myform.rule5TrimStart,'(*)');"  style="color:#3300FF;">(*)</a>
		&nbsp; 多个替换条件间隔符:<a href="javascript:AddSeperate(document.myform.rule5TrimStart,document.myform.rule5TrimEnd,'(|)');" style="color:#3300FF;">(|)</a>
		</td>
      </tr>
    </table>      </td>
    </tr>
  <tr id="时间trimhtml" style="display:none">
    <td class='tablerow'  align="center"><font color=blue>Html自动清除<br>
    </font> </td>
    <td class='tablerow'>&nbsp;
        <input type="checkbox" name="rule[HtmlTrim][5][]" value="0" id="rule5HtmlTrim">
      链接&lt;a&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="1">
      换行&lt;br&gt;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="2">
      表格&lt;table&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="3">
      表格行&lt;tr&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="4">
      单元&lt;td&nbsp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="5">
      段落&lt;p&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="6">
      字体&lt;font&nbsp;
      <input name="buttonall5" type="button" onClick="HtmlTrimSelect(5,'all');" value="全选">
      <br>
&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="7">
      层&lt;div&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="8">
      Span&lt;span&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="9">
      表格体&lt;tbody&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="10">
      加粗&lt;b&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="11">
      图象&lt;img&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="12">
      空格&amp;&nbsp;
      <input type="checkbox" name="rule[HtmlTrim][5][]" value="13">
      脚本&lt;script&nbsp;
      <input name="buttonnone5" type="button" onClick="HtmlTrimSelect(5,'none');" value="全空">
	  <input type="hidden" name="userlabelid" value="5"></td>
  </tr>
    <tr>
    <td colspan="2" class='tablerow'><strong>自定义标签名称:</strong>
        <input name='userlabelname' type='text' id='userlabelname' size='10' value="简介">
&nbsp;
      <input name="buttonaddlabel" type="button" onClick="AddLabel(document.myform.userlabelname.value,6);" value="添加标签"></td>
  </tr>
  <tr><td  class='tablerow' colspan="2" >
    <div id='userlabel'></div>
  </td></tr>
  <tr>
    <td class='tablerow'><strong>文章分页合并</strong></td>
    <td valign="middle" class='tablerow'><table width="98%"  border="0">
        <tr>
          <td width="100">分页代码：从</td>
          <td width="223"><textarea name="job[DividePageStart]" cols="26" rows="4" id="jobDividePageStart"></textarea>            </td>
          <td width="13">到</td>
          <td width="223"><textarea name="job[DividePageEnd]" cols="26" rows="4" id="jobDividePageEnd"></textarea></td>
          <td width="220"><input type='radio' name='job[DividePageStyle]'  value='0' checked>
全部列出模式
  <br>
  <input type='radio' name='job[DividePageStyle]' value='1'>上下页模式</td>
<td width="150">
通配符:<a href="javascript:AddOnPos(document.myform.jobDividePageStart,'(*)');" style="color:#3300FF;">(*)</a><br><br>
通配符:<a href="javascript:AddOnPos(document.myform.jobDividePageEnd,'(*)');" style="color:#3300FF;">(*)</a>
		</td>
          </tr>		  
      </table>            </td>
    </tr>
	<tr>
    <td width="192"  class='tablerow'><strong>测试地址:</strong>      </td>
    <td width="*" class='tablerow'><input name='job[TestPageUrl]' type='text' id='jobTestPageUrl' size='66'>
      <input name="buttontestrule" type="button" onClick="buttontestrule();" value="测试规则"></td>
      </tr>
END;
?>