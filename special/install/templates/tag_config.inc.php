<?php
return array (
  '专题' => 
  array (
    'introduce' => '',
    'typeid' => '3',
    'elite' => '0',
    'orderby' => 'listorder DESC,specialid DESC',
    'page' => '$page',
    'number' => '10',
    'template' => 'tag_special',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
    ),
    'sql' => 'SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'3\'  ORDER BY listorder DESC,specialid DESC',
    'tagcode' => 'tag(\'special\', \'tag_special\', "SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'3\'  ORDER BY listorder DESC,specialid DESC", $page, 10, array (  \'class\' => \'url\',  \'target\' => \'_blank\',))',
  ),
  '首页推荐专题' => 
  array (
    'introduce' => '',
    'typeid' => '',
    'elite' => '0',
    'orderby' => 'listorder DESC,specialid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_special',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '宽度',
      4 => '高度',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'width',
      4 => 'height',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '90',
      4 => '62',
    ),
    'sql' => 'SELECT * FROM `phpcms2008_special`  ORDER BY listorder DESC,specialid DESC',
    'tagcode' => 'tag(\'special\', \'tag_special\', "SELECT * FROM `phpcms2008_special`  ORDER BY listorder DESC,specialid DESC", 0, 10, array (  \'class\' => \'url\',  \'target\' => \'_blank\',  \'width\' => \'90\',  \'height\' => \'62\',))',
  ),
  '专题首页循环分类' => 
  array (
    'introduce' => '',
    'typeid' => '$typeid',
    'elite' => '0',
    'orderby' => 'listorder DESC,specialid DESC',
    'page' => '0',
    'number' => '1',
    'template' => 'tag_special_elite',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '高度',
      4 => '宽度',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'height',
      4 => 'width',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '110',
      4 => '206',
    ),
    'sql' => 'SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\'  ORDER BY listorder DESC,specialid DESC',
    'tagcode' => 'tag(\'special\', \'tag_special_elite\', "SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\'  ORDER BY listorder DESC,specialid DESC", 0, 1, array (  \'class\' => \'url\',  \'target\' => \'_blank\',  \'height\' => \'110\',  \'width\' => \'206\',))',
  ),
  '专题首页推荐专题' => 
  array (
    'introduce' => '',
    'typeid' => '$typeid',
    'elite' => '1',
    'orderby' => 'specialid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_special_elite',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '宽度',
      4 => '高度',
      5 => '标题长度',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'width',
      4 => 'height',
      5 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '206',
      4 => '110',
      5 => '35',
    ),
    'sql' => 'SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\' AND `elite`=\'1\'  ORDER BY specialid DESC',
    'tagcode' => 'tag(\'special\', \'tag_special_elite\', "SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\' AND `elite`=\'1\'  ORDER BY specialid DESC", 0, 10, array (  \'class\' => \'url\',  \'target\' => \'_blank\',  \'width\' => \'206\',  \'height\' => \'110\',  \'titlelen\' => \'35\',))',
  ),
  '专题首页最新专题循环列表' => 
  array (
    'introduce' => '',
    'typeid' => '$typeid',
    'elite' => '0',
    'orderby' => 'listorder DESC,specialid DESC',
    'page' => '0',
    'number' => '10',
    'template' => 'tag_special_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '高度',
      4 => '宽度',
      5 => '标题长度',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'height',
      4 => 'width',
      5 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '110',
      4 => '206',
      5 => '45',
    ),
    'sql' => 'SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\'  ORDER BY listorder DESC,specialid DESC',
    'tagcode' => 'tag(\'special\', \'tag_special_list\', "SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\'  ORDER BY listorder DESC,specialid DESC", 0, 10, array (  \'class\' => \'url\',  \'target\' => \'_blank\',  \'height\' => \'110\',  \'width\' => \'206\',  \'titlelen\' => \'45\',))',
  ),
  '专题列表页图片专题' => 
  array (
    'introduce' => '',
    'typeid' => '$typeid',
    'elite' => '0',
    'orderby' => 'specialid DESC',
    'page' => '0',
    'number' => '4',
    'template' => 'tag_special_more',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '宽度',
      4 => '高度',
      5 => '标题字数',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'width',
      4 => 'height',
      5 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '142',
      4 => '92',
      5 => '20',
    ),
    'sql' => 'SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\'  ORDER BY specialid DESC',
    'tagcode' => 'tag(\'special\', \'tag_special_more\', "SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\'  ORDER BY specialid DESC", 0, 4, array (  \'class\' => \'url\',  \'target\' => \'_blank\',  \'width\' => \'142\',  \'height\' => \'92\',  \'titlelen\' => \'20\',))',
  ),
  '专题列表页文字列表' => 
  array (
    'introduce' => '',
    'typeid' => '$typeid',
    'elite' => '0',
    'orderby' => 'listorder DESC,specialid DESC',
    'page' => '$page',
    'number' => '20',
    'template' => 'tag_special_list',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '高度',
      4 => '宽度',
      5 => '标题长度',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'height',
      4 => 'width',
      5 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '110',
      4 => '206',
      5 => '75',
    ),
    'sql' => 'SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\'  ORDER BY listorder DESC,specialid DESC',
    'tagcode' => 'tag(\'special\', \'tag_special_list\', "SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\'  ORDER BY listorder DESC,specialid DESC", $page, 20, array (  \'class\' => \'url\',  \'target\' => \'_blank\',  \'height\' => \'110\',  \'width\' => \'206\',  \'titlelen\' => \'75\',))',
  ),
  '推荐专题' => 
  array (
    'introduce' => '',
    'typeid' => '$typeid',
    'elite' => '0',
    'orderby' => 'listorder DESC,specialid DESC',
    'page' => '0',
    'number' => '12',
    'template' => 'tag_special_pos',
    'var_description' => 
    array (
      1 => '链接样式',
      2 => '打开窗口',
      3 => '图片高度',
      4 => '图片宽度',
      5 => '标题长度',
    ),
    'var_name' => 
    array (
      1 => 'class',
      2 => 'target',
      3 => 'height',
      4 => 'width',
      5 => 'titlelen',
    ),
    'var_value' => 
    array (
      1 => 'url',
      2 => '_blank',
      3 => '62',
      4 => '87',
      5 => '15',
    ),
    'sql' => 'SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\'  ORDER BY listorder DESC,specialid DESC',
    'tagcode' => 'tag(\'special\', \'tag_special_pos\', "SELECT * FROM `phpcms2008_special` WHERE  `typeid`=\'$typeid\'  ORDER BY listorder DESC,specialid DESC", 0, 12, array (  \'class\' => \'url\',  \'target\' => \'_blank\',  \'height\' => \'62\',  \'width\' => \'87\',  \'titlelen\' => \'15\',))',
  ),
);
?>