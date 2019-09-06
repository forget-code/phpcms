<?php
return array (
  '文字链接' => 
  array (
    'func' => 'link',
    'introduce' => '标准的文字链接输出',
    'linktype' => '0',
    'typeid' => '0',
    'elite' => '1',
    'linknum' => '18',
    'template' => 'tag_link',
    'var_description' => 
    array (
      1 => '每行显示链接列数',
      2 => '是否显示点击次数',
    ),
    'var_name' => 
    array (
      1 => 'rownum',
      2 => 'showhits',
    ),
    'var_value' => 
    array (
      1 => '10',
      2 => '是',
    ),
    'number' => '18',
    'page' => '0',
    'type' => 'link',
    'sql' => 'SELECT * FROM phpcms2008_link where linktype=\'0\' and passed=1 AND elite=1 ORDER BY listorder ASC',
    'tagcode' => 'tag(\'link\', \'tag_link\', "SELECT * FROM phpcms2008_link where linktype=\'0\' and passed=1 AND elite=1 ORDER BY listorder ASC", 0, 18, array (  \'typeid\' => \'0\',  \'rownum\' => \'10\',  \'showhits\' => \'是\',))',
  ),
  'logo链接' => 
  array (
    'func' => 'link',
    'introduce' => 'logo图片链接',
    'linktype' => '1',
    'typeid' => '0',
    'elite' => '1',
    'linknum' => '20',
    'template' => 'tag_link_logo',
    'var_description' => 
    array (
      1 => '每行显示链接列数',
      2 => '是否显示点击次数',
    ),
    'var_name' => 
    array (
      1 => 'rownum',
      2 => 'showhits',
    ),
    'var_value' => 
    array (
      1 => '15',
      2 => '是',
    ),
    'number' => '20',
    'page' => '0',
    'type' => 'link',
    'sql' => 'SELECT * FROM phpcms2008_link where linktype=\'1\' and passed=1 AND elite=1',
    'tagcode' => 'tag(\'link\', \'tag_link_logo\', "SELECT * FROM phpcms2008_link where linktype=\'1\' and passed=1 AND elite=1", 0, 20, array (  \'typeid\' => \'0\',  \'rownum\' => \'15\',  \'showhits\' => \'是\',))',
  ),
  '首页图片链接' => 
  array (
    'func' => 'link',
    'introduce' => '',
    'linktype' => '1',
    'typeid' => '0',
    'linknum' => '20',
    'template' => 'tag_link_logo',
    'var_description' => 
    array (
      1 => '每行显示链接列数',
      2 => '是否显示点击次数',
    ),
    'var_name' => 
    array (
      1 => 'rownum',
      2 => 'showhits',
    ),
    'var_value' => 
    array (
      1 => '10',
      2 => '1',
    ),
    'number' => '20',
    'page' => '0',
    'type' => 'link',
    'sql' => 'SELECT * FROM phpcms2008_link where linktype=\'1\' and passed=1',
    'tagcode' => 'tag(\'link\', \'tag_link_logo\', "SELECT * FROM phpcms2008_link where linktype=\'1\' and passed=1", 0, 20, array (  \'typeid\' => \'0\',  \'rownum\' => \'10\',  \'showhits\' => \'1\',))',
  ),
);
?>