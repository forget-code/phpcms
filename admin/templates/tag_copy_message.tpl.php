<?php 
$message = '<script type="text/javascript">
			function inserttag()
			{
			window.opener.document.myform.content.focus();
			var str = window.opener.document.selection.createRange();
			if(str.text != "") 
			{
				alert("请把光标放到要插入标签的位置，再点插入标签按钮！");
				return false;
			}
			str.text = "{tag_'.$tagname.'}";
			window.close();
			}
			</script>
			<font color="red">标签 {tag_'.$tagname.'} 已经创建成功！</font><p>
			<input type="button" value="插入标签" onclick="javascript:inserttag();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="关闭窗口" onclick="javascript:window.close();"><p>
			<font color="blue">注意：如果要插入标签 {tag_'.$tagname.'} 到编辑器，请先把光标放到要插入的位置，再点击上面的“插入标签”按钮。</font>';
?>