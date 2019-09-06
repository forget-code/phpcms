<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<body>
<form method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=createindex">
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>提示信息</caption>
  <tr>
    <td>

      <font color="red">为什么要用全文索引呢？</font><br /><br />

      &nbsp;&nbsp;&nbsp;&nbsp;一般的数据库搜索都是用的SQL的 like 语句，like 语句是不能利用索引的，每次查询都是从第一条遍历至最后一条，查询效率极其低下。一般数据超过10万或者在线人数过多,like查询都会导致数据库崩溃。这也就是为什么很多程序都只提供标题搜索的原因了，因为如果搜索内容，那就更慢了，几万数据就跑不动了。<br />

     Mysql 全文索引是专门为了解决模糊查询提供的，可以对整篇文章预先按照词进行索引，搜索效率高，能够支持百万级的数据检索。<br /><br />
<?php if($search->ft_min_word_len > 2){ ?>
     &nbsp;&nbsp;&nbsp;&nbsp;从 Mysql 4.0 开始就支持全文索引功能，但是 Mysql 默认的最小索引长度是 4。如果是英文默认值是比较合理的，但是中文绝大部分词都是2个字符，这就导致小于4个字的词都不能被索引，全文索引功能就形同虚设了。国内的空间商大部分可能并没有注意到这个问题，没有修改 Mysql 的默认设置。<br /><br />

	 &nbsp;&nbsp;&nbsp;&nbsp;如果您使用的是自己的服务器，请马上进行设置，不要浪费了这个功能。<br />

     &nbsp;&nbsp;&nbsp;&nbsp;如果您使用的是虚拟主机，请马上联系空间商修改配置。首先，Mysql 的这个默认值对于中文来说就是一个错误的设置，修改设置等于纠正了错误。其次，这个配置修改很简单，也就是几分钟的事情，而且搜索效率提高也降低了空间商数据库宕掉的几率。如果你把本文发给空间商，我相信绝大部分都会愿意改的。<br /><br />


    <font color="red">设置方法：</font><br />

    请联系服务器管理员修改<?=$inifile?> ，在 [mysqld] 后面加入一行“ft_min_word_len=1”，然后重启Mysql，再登录网站后台（模块管理->全站搜索）重建全文索引，否则将无法使用全站搜索功能。
<?php } ?>
	</td>
  </tr>
</table>
<div class="button_box" style="text-align:center">
<input type="submit" name="dosubmit" value=" 开始重建全文索引 ">
</div>
</form>
</body>
</html>