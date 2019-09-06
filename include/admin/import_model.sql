CREATE TABLE `$tablename` (
  `contentid` MEDIUMINT(8) unsigned NOT NULL,
  `template` char(30) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY  (`contentid`)
) TYPE=MyISAM;

INSERT INTO `$table_model_field` (`modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `listorder`, `disabled`) VALUES ($modelid, 'contentid', 'ID', '', '', 0, 0, '', '', 'number', '', '', '', '', 1, 1, 0, 0, 1, 0, 1, 1, 1, 0, 0);
INSERT INTO `$table_model_field` (`modelid`, `field`, `name`, `tips`, `css`, `minlength`, `maxlength`, `pattern`, `errortips`, `formtype`, `setting`, `formattribute`, `unsetgroupids`, `unsetroleids`, `iscore`, `issystem`, `isunique`, `issearch`, `isselect`, `iswhere`, `isorder`, `islist`, `isshow`, `listorder`, `disabled`) VALUES ($modelid, 'catid', '栏目', '', '', 1, 9999, '/^[0-9]+$/', '请选择所属栏目', 'catid', 'array (\n  ''defaultvalue'' => '''',\n)', '', '', '', 0, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0);