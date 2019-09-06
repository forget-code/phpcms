<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script type="text/javascript" src="images/js/jqModal.js"></script>
<script type="text/javascript" src="images/js/jqDnR.js"></script>
<script type="text/javascript">
function insertText(text)
{
	myform.content.focus();
    var str = document.selection.createRange();
	str.text = text;
}

function tag_pop(mod, action, func)
{
	var tagname = document.selection.createRange().text;
	if(action == 'preview')
	{
		url = '?mod='+mod+'&file=tag&action='+action+'&tagname='+tagname;
	}
	else
	{
		if(func == '')
		{
			url = '?mod=phpcms&file=template&action=gettag&operate='+action+'&job=edittemplate&tagname='+tagname;
		}
		else
		{
			url = '?mod=phpcms&file=template&action=gettag&function='+action+'&job=edittemplate&tagname='+tagname;
		}
	}
	window.open(url,'tag','height=500,width=700,,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no');
}

function docheck()
{
	if(myform.template.value == '')
	{
		alert("请填写模板文件名！\n命名规则：模板类型-特征名，同类型模板特征名不同");
		myform.template.focus();
		return false;
	}
	if(myform.template.value == '<?=$templatetype?>-')
	{
		alert("请把模板文件名填写完整！\n命名规则：模板类型-特征名，同类型模板特征名不同");
		myform.template.focus();
		return false;
	}
	if(myform.templatename.value == '')
	{
		alert('请填写模板中文名！');
		myform.templatename.focus();
		return false;
	}
	if(myform.createtype[0].checked && myform.content.value == '')
	{
		alert('请填写模板内容！');
		myform.content.focus();
		return false;
	}
	if(myform.createtype[1].checked && myform.uploadfile.value == '')
	{
		alert('请选择要上传的模板文件！');
		myform.uploadfile.focus();
		return false;
	}
	return true;
}
</script>

<body onLoad="myform.content.focus();">
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" enctype="multipart/form-data" onSubmit="return docheck()">
<table cellpadding="0" cellspacing="1" class="table_form">
  <caption>添加模板</caption>
	<tr>
		<th width="10%"><strong>所属方案</strong></th>
		<td>
			<input type="hidden" name="project" value="<?=$project?>">
			<?=$projectname?>
		</td>
	</tr>
	<tr>
		<th><strong>所属模块</strong></td>
		<td>
		<input type="hidden" name="module" value="<?=$module?>">
		<?=$MODULE[$module]['name']?>
		</td>
	</tr>
		<?php if($templatetype){ ?>
	<tr>
		<th><strong>模板类型</strong></td>
		<td><?=$templatename?>(<?=$templatetype?>)</td>
	</tr>
	<?php } ?>
	<tr>
		<th><strong>模板名称</strong></th>
		<td><input type="text" name="templatename" size=25> 可以是中文</td>
	</tr>
	<tr>
		<th><strong>模板路径</strong></th>
		<td><font color="blue">./templates/<?=$project?>/<?=$module?>/<input type="text" name="template" <?php if($templatetype){ ?>value="<?=$templatetype?>_"<?php } ?> size="25"> .html</font><font color="red">*</font>&nbsp;&nbsp;(命名规则：<font color="blue">模板类型_</font><font color="red">特征名</font>，同类型模板特征名不同)</td>
	</tr>
	<tr>
		<th><strong>模板语法</strong></th>
		<td>
			<input type="button" value="get" title="插入数据调用" style="width:40px;color:#ff0000;"  class="jqModal" onClick="get_db_source();$('.jqmWindow').show();"/>
			<input type="button" value="block" title="插入碎片" style="width:55px" onClick='javascript:insertText("<!--{block(\"pageid\", 1)}-->\n")' />
			<input type="button" value="loop" style="width:50px" onClick="javascript:if(this.value != '') insertText('<!--{loop $array $key $val}-->\n{$key}:{$val}\n<!--{/loop}-->\n')" />
			<input type="button" value="if" style="width:40px" onClick="javascript:if(this.value != '') insertText('<!--{if $var1 == $var2}-->\n\n<!--{/if}-->\n')" />
			<input type="button" value="else" style="width:50px" onClick="javascript:if(this.value != '') insertText('<!--{else}-->\n')" />
			<input type="button" value="elseif" style="width:60px" onClick="javascript:if(this.value != '') insertText('<!--{elseif $a == $b}-->\n')" />
			<input type="button" value="template" style="width:70px" onClick="javascript:if(this.value != '') insertText('<!--{template \'phpcms\',\'header\'}-->\n')" />
			<input type="button" value="include" style="width:65px" onClick="javascript:if(this.value != '') insertText('<!--{include PHPCMS_ROOT.\'*.php\'}-->\n')" />
		</td>
	</tr>
	<tr>
		<th><strong>标签操作</strong></th>
		<td>
<?php
array_unshift($tagtype, "新建标签");
?>
			<?=form::select($tagtype, 'addtag', 'addtag')?>&nbsp;&nbsp;
            <input type="text" name="tagname" value="请输入标签名" size="15" onClick="if(this.value == '请输入标签名') this.value=''">&nbsp;<input name="dosubmit" type="button" value="编辑标签" onClick="window.open('?mod=phpcms&file=template&action=gettag&operate=edit&job=edittemplate&tagname='+myform.tagname.value,'tag','height=500,width=700,,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no')">&nbsp;&nbsp;
			<input type="button" name="tagpreview" value="预览选中的标签" style="background:blue;color:#ffffff;width:110px" onClick="javascript:if(document.selection.createRange().text != '') tag_pop('phpcms','preview','')">
			<input type="button" name="tagedit" value="编辑选中的标签" style="background:blue;color:#ffffff;width:110px" onClick="javascript:if(document.selection.createRange().text != '') tag_pop('phpcms','edit','')">
			<input type="button" name="listtag" value="列出模板中的标签" style="background:blue;color:#ffffff;width:110px" onClick="window.open('?mod=phpcms&file=tag&action=listtag&job=edittemplate&module='+myform.module.value+'&templatename='+myform.templatename.value+'&template='+myform.template.value,'tag','height=500,width=700,,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no')">
		</td>
	</tr>
	<tr>
		<th><strong>创建方式</strong></th>
		<td><input type="radio" name="createtype" value="0" checked onClick="$('#createtype1').show();$('#createtype2').hide()"> 在线创建 <input type="radio" name="createtype" value="1"  onclick="$('#createtype2').show();$('#createtype1').hide()"> 本地上传 </td>
	</tr>
</table>
<table cellpadding="0" cellspacing="1" class="table_form">
<tbody id="createtype1" style="disply:">
	<tr>
		<td>
<textarea id='txt_ln' rows='30' cols='4' align="left" style='overflow:hidden;border-right:0px;padding-right:0px;text-align:right;scrolling:no;height:360px;font-family:Fixedsys,verdana,宋体;font-size:12px;color:#0000FF;background-color:#eeeeee;' readonly>
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
48
49
50
51
52
53
54
55
56
57
58
59
60
61
62
63
64
65
66
67
68
69
70
71
72
73
74
75
76
77
78
79
80
81
82
83
84
85
86
87
88
89
90
91
92
93
94
95
96
97
98
99
100
101
102
103
104
105
106
107
108
109
110
111
112
113
114
115
116
117
118
119
120
121
122
123
124
125
126
127
128
129
130
131
132
133
134
135
136
137
138
139
140
141
142
143
144
145
146
147
148
149
150
151
152
153
154
155
156
157
158
159
160
161
162
163
164
165
166
167
168
169
170
171
172
173
174
175
176
177
178
179
180
181
182
183
184
185
186
187
188
189
190
191
192
193
194
195
196
197
198
199
200
201
202
203
204
205
206
207
208
209
210
211
212
213
214
215
216
217
218
219
220
221
222
223
224
225
226
227
228
229
230
231
232
233
234
235
236
237
238
239
240
241
242
243
244
245
246
247
248
249
250
251
252
253
254
255
256
257
258
259
260
261
262
263
264
265
266
267
268
269
270
271
272
273
274
275
276
277
278
279
280
281
282
283
284
285
286
287
288
289
290
291
292
293
294
295
296
297
298
299
300
301
302
303
304
305
306
307
308
309
310
311
312
313
314
315
316
317
318
319
320
321
322
323
324
325
326
327
328
329
330
331
332
333
334
335
336
337
338
339
340
341
342
343
344
345
346
347
348
349
350
351
352
353
354
355
356
357
358
359
360
361
362
363
364
365
366
367
368
369
370
371
372
373
374
375
376
377
378
379
380
381
382
383
384
385
386
387
388
389
390
391
392
393
394
395
396
397
398
399
400
401
402
403
404
405
406
407
408
409
410
411
412
413
414
415
416
417
418
419
420
421
422
423
424
425
426
427
428
429
430
431
432
433
434
435
436
437
438
439
440
441
442
443
444
445
446
447
448
449
450
451
452
453
454
455
456
457
458
459
460
461
462
463
464
465
466
467
468
469
470
471
472
473
474
475
476
477
478
479
480
481
482
483
484
485
486
487
488
489
490
491
492
493
494
495
496
497
498
499
500
501
502
503
504
505
506
507
508
509
510
511
512
513
514
515
516
517
518
519
520
521
522
523
524
525
526
527
528
529
530
531
532
533
534
535
536
537
538
539
540
541
542
543
544
545
546
547
548
549
550
551
552
553
554
555
556
557
558
559
560
561
562
563
564
565
566
567
568
569
570
571
572
573
574
575
576
577
578
579
580
581
582
583
584
585
586
587
588
589
590
591
592
593
594
595
596
597
598
599
600
601
602
603
604
605
606
607
608
609
610
611
612
613
614
615
616
617
618
619
620
621
622
623
624
625
626
627
628
629
630
631
632
633
634
635
636
637
638
639
640
641
642
643
644
645
646
647
648
649
650
651
652
653
654
655
656
657
658
659
660
661
662
663
664
665
666
667
668
669
670
671
672
673
674
675
676
677
678
679
680
681
682
683
684
685
686
687
688
689
690
691
692
693
694
695
696
697
698
699
700
701
702
703
704
705
706
707
708
709
710
711
712
713
714
715
716
717
718
719
720
721
722
723
724
725
726
727
728
729
730
731
732
733
734
735
736
737
738
739
740
741
742
743
744
745
746
747
748
749
750
751
752
753
754
755
756
757
758
759
760
761
762
763
764
765
766
767
768
769
770
771
772
773
774
775
776
777
778
779
780
781
782
783
784
785
786
787
788
789
790
791
792
793
794
795
796
797
798
799
800
801
802
803
804
805
806
807
808
809
810
811
812
813
814
815
816
817
818
819
820
821
822
823
824
825
826
827
828
829
830
831
832
833
834
835
836
837
838
839
840
841
842
843
844
845
846
847
848
849
850
851
852
853
854
855
856
857
858
859
860
861
862
863
864
865
866
867
868
869
870
871
872
873
874
875
876
877
878
879
880
881
882
883
884
885
886
887
888
889
890
891
892
893
894
895
896
897
898
899
900
901
902
903
904
905
906
907
908
909
910
911
912
913
914
915
916
917
918
919
920
921
922
923
924
925
926
927
928
929
930
931
932
933
934
935
936
937
938
939
940
941
942
943
944
945
946
947
948
949
950
951
952
953
954
955
956
957
958
959
960
961
962
963
964
965
966
967
968
969
970
971
972
973
974
975
976
977
978
979
980
981
982
983
984
985
986
987
988
989
990
991
992
993
994
995
996
997
998
999
1000
1001
1002
1003
1004
1005
1006
1007
1008
1009
1010
1011
1012
1013
1014
1015
1016
1017
1018
1019
1020
1021
1022
1023
1024
1025
1026
1027
1028
1029
1030
1031
1032
1033
1034
1035
1036
1037
1038
1039
1040
1041
1042
1043
1044
1045
1046
1047
1048
1049
1050
1051
1052
1053
1054
1055
1056
1057
1058
1059
1060
1061
1062
1063
1064
1065
1066
1067
1068
1069
1070
1071
1072
1073
1074
1075
1076
1077
1078
1079
1080
1081
1082
1083
1084
1085
1086
1087
1088
1089
1090
1091
1092
1093
1094
1095
1096
1097
1098
1099
1100
1101
1102
1103
1104
1105
1106
1107
1108
1109
1110
1111
1112
1113
1114
1115
1116
1117
1118
1119
1120
1121
1122
1123
1124
1125
1126
1127
1128
1129
1130
1131
1132
1133
1134
1135
1136
1137
1138
1139
1140
1141
1142
1143
1144
1145
1146
1147
1148
1149
1150
1151
1152
1153
1154
1155
1156
1157
1158
1159
1160
1161
1162
1163
1164
1165
1166
1167
1168
1169
1170
1171
1172
1173
1174
1175
1176
1177
1178
1179
1180
1181
1182
1183
1184
1185
1186
1187
1188
1189
1190
1191
1192
1193
1194
1195
1196
1197
1198
1199
1200
1201
1202
1203
1204
1205
1206
1207
1208
1209
1210
1211
1212
1213
1214
1215
1216
1217
1218
1219
1220
1221
1222
1223
1224
1225
1226
1227
1228
1229
1230
1231
1232
1233
1234
1235
1236
1237
1238
1239
1240
1241
1242
1243
1244
1245
1246
1247
1248
1249
1250
1251
1252
1253
1254
1255
1256
1257
1258
1259
1260
1261
1262
1263
1264
1265
1266
1267
1268
1269
1270
1271
1272
1273
1274
1275
1276
1277
1278
1279
1280
1281
1282
1283
1284
1285
1286
1287
1288
1289
1290
1291
1292
1293
1294
1295
1296
1297
1298
1299
1300
1301
1302
1303
1304
1305
1306
1307
1308
1309
1310
1311
1312
1313
1314
1315
1316
1317
1318
1319
1320
1321
1322
1323
1324
1325
1326
1327
1328
1329
1330
1331
1332
1333
1334
1335
1336
1337
1338
1339
1340
1341
1342
1343
1344
1345
1346
1347
1348
1349
1350
1351
1352
1353
1354
1355
1356
1357
1358
1359
1360
1361
1362
1363
1364
1365
1366
1367
1368
1369
1370
1371
1372
1373
1374
1375
1376
1377
1378
1379
1380
1381
1382
1383
1384
1385
1386
1387
1388
1389
1390
1391
1392
1393
1394
1395
1396
1397
1398
1399
1400
1401
1402
1403
1404
1405
1406
1407
1408
1409
1410
1411
1412
1413
1414
1415
1416
1417
1418
1419
1420
1421
1422
1423
1424
1425
1426
1427
1428
1429
1430
1431
1432
1433
1434
1435
1436
1437
1438
1439
1440
1441
1442
1443
1444
1445
1446
1447
1448
1449
1450
1451
1452
1453
1454
1455
1456
1457
1458
1459
1460
1461
1462
1463
1464
1465
1466
1467
1468
1469
1470
1471
1472
1473
1474
1475
1476
1477
1478
1479
1480
1481
1482
1483
1484
1485
1486
1487
1488
1489
1490
1491
1492
1493
1494
1495
1496
1497
1498
1499
1500
</textarea>
<textarea id='txt_main' name='content' onscroll='show_ln()' align="left" wrap='off' style='width:90%;height:360px;overflow:auto;scrolling:yes;border-left:0px;font-family:Fixedsys,verdana,宋体;font-size:12px;'><?=htmlspecialchars($content)?></textarea>
<script>
var i=1694;
function show_ln()
{
 var txt_ln  = document.getElementById('txt_ln');
 var txt_main  = document.getElementById('txt_main');
 txt_ln.scrollTop = txt_main.scrollTop;
 while(txt_ln.scrollTop != txt_main.scrollTop)
 {
  txt_ln.value += (i++) + '\n';
  txt_ln.scrollTop = txt_main.scrollTop;
 }
 return;
}

function ShowTab(id)
{
	var select = '';
	var tab = '#tab' + id;
	var menu_tab = '#menu_tab' + id;
	for(i = 0; i < 2; i++)
	{
		var utab = '#tab' + i;
		var umenu_tab = '#menu_tab' + i;
		$(utab).hide();
		$(umenu_tab).removeClass('selected');
	}
	if(tab == '#tab1')
	{
		$('#tag').hide();
		var select = '';
		$.get('?mod=<?=$mod?>&file=<?=$file?>', {action:'showvar', strvar:'phpcms'}, function(data){
			if(data == 'null')
			{
				$('#var').hide();
				return false;
			}
			else
			{
				var arr_var = data.split(',');
				$.each(arr_var, function(n){
					var val = '{' + arr_var[n] + '}';
					select += "<option value='"+ val + "'>" + arr_var[n] + "</option>";
				});
				$('#var').show();
				$('#var').html(select);
			}
		});
	}
	else if(tab == '#tab0')
	{
		$('#var').hide();
		$.get('?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>', {action:'showtags', module:'phpcms'}, function(data){
			if(data == 'null')
			{
				$('#tag').hide();
				return false;
			}
			else
			{
				var arr_tag = data.split(',');
				$.each(arr_tag, function(n){
					var val = '{tag_' + arr_tag[n] + '}';
					select += "<option value='" + val + "'>" + arr_tag[n] + "</option>";
				});
				$('#tag').show();
				$('#tag').html(select);
			}
		});
	}
	$(tab).show();
	$(menu_tab).addClass('selected');
}
</script>
</td>
<td width="10%" valign="top">
<div class="tag_menu">
	<ul>
	  <li><a href="#" class="selected" onClick="ShowTab(0)" id="menu_tab0">插入标签</a></li>
	  <li><a href="#" onClick="ShowTab(1)" id="menu_tab1">插入变量</a></li>
     </ul>
</div>
<table cellspacing="1" cellpadding="0" class="table_list">
    <tr>
    	<td style="">
        	<span id="tab0">
				<?=form::select($modname, 'moduleid', 'module', 'phpcms', 1, '', 'style="width:150px; margin:5px 0;"')?><br />
            	<select name="tag" id="tag" tabindex="1" size="19" style="display:none; width:150px; margin:5px 0;"></select>
            </span>
            <span id="tab1" style="display:none;">
				<?=form::select($variable, 'variable', 'variable', 'PHPCMS', '', '', 'style="width:150px; margin:5px 0;"')?><br />
            	<select name="var" id="var" tabindex="1" size="19" style="display:none; width:150px; margin:5px 0;"></select>
            </span></td>
	</tr>
</table>
</td>
</tr>
</tbody>
<tbody id="createtype2" style="display:none;">
<tr>
	<th width="10%"><strong>模板文件</strong></td>
	<td><input type="file" name="uploadfile" size="20"> <font color="red">*</font></td>
</tr>
</tbody>
<tr>
    	<td align="center" colspan="2">
 <input type="submit" name="dosubmit" value=" 保存 ">&nbsp;&nbsp;&nbsp;&nbsp;
 <input type="reset" name="submit" value=" 重置 ">&nbsp;&nbsp;&nbsp;&nbsp;
	</td>
  </tr>
</table>
</form>
<br/>
<table cellpadding="0" cellspacing="1" class="table_info">
  <caption>get 标签用法介绍</caption>
  <tr>
    <td>
<span style="color:red">get 标签可调用本系统和外部数据，适合熟悉SQL语句的人使用。</span>注意：get标签属性值必须用双引号括起来<br />
<span style="color:blue">1、调用本系统单条数据，示例（调用ID为1的信息，标题长度不超过25个汉字，显示更新日期）：</span><br />
{get sql="select * from phpcms_content where contentid=1" /}<br />
标题：{str_cut($r[title], 50)} URL：{$r[url]} 更新日期：{date('Y-m-d', $r[updatetime])} <br />

<span style="color:blue">2、调用本系统多条数据，示例（调用栏目ID为1通过审核的10条信息，标题长度不超过25个汉字，显示更新日期）：</span><br />
{get sql="select * from phpcms_content where catid=1 and status=99 order by updatetime desc" rows="10"}<br />
 &nbsp;&nbsp;&nbsp;&nbsp;标题：{str_cut($r[title], 50)} URL：{$r[url]} 更新日期：{date('Y-m-d', $r[updatetime])} <br />
{/get}<br />

<span style="color:blue">3、带分页，示例（调用栏目ID为1通过审核的10条信息，标题长度不超过25个汉字，显示更新日期，带分页）：</span><br />
{get sql="select * from phpcms_content where catid=1 and status=99 order by updatetime desc" rows="10" page="$page"}<br />
 &nbsp;&nbsp;&nbsp;&nbsp;标题：{str_cut($r[title], 50)} URL：{$r[url]} 更新日期：{date('Y-m-d', $r[updatetime])} <br />
{/get}<br />
分页：{$pages}<br />

<span style="color:blue">4、自定义返回变量，示例（调用栏目ID为1通过审核的10条信息，标题长度不超过25个汉字，显示更新日期，返回变量为 $v）：</span><br />
{get sql="select * from phpcms_content where catid=1 and status=99 order by updatetime desc" rows="10" return="v"}<br />
 &nbsp;&nbsp;&nbsp;&nbsp;标题：{str_cut($v[title], 50)} URL：{$v[url]} 更新日期：{date('Y-m-d', $v[updatetime])} <br />
{/get}<br />

<span style="color:blue">5、调用同一帐号下的其他数据库，示例（调用数据库为bbs，分类ID为1的10个最新主题，主题长度不超过25个汉字，显示更新日期）：</span><br />
{get dbname="bbs" sql="select * from cdb_threads where fid=1 order by dateline desc" rows="10"}<br />
 &nbsp;&nbsp;&nbsp;&nbsp;主题：{str_cut($r[subject], 50)} URL：http://bbs.phpcms.cn/viewthread.php?tid={$r[tid]} 更新日期：{date('Y-m-d', $r[dateline])} <br />
{/get}<br />

<span style="color:blue">6、调用外部数据，示例（调用数据源为bbs，分类ID为1的10个最新主题，主题长度不超过25个汉字，显示更新日期）：</span><br />
{get dbsource="bbs" sql="select * from cdb_threads where fid=1 order by dateline desc" rows="10"}<br />
 &nbsp;&nbsp;&nbsp;&nbsp;主题：{str_cut($r[subject], 50)} URL：http://bbs.phpcms.cn/viewthread.php?tid={$r[tid]} 更新日期：{date('Y-m-d', $r[dateline])} <br />
{/get}	</td>
  </tr>
</table>

<div class="jqmWindow">
<h5 class="title" style="cursor:move"><a href="#" class="jqmClose"><img src="images/close.gif" alt="" height="16px" width="16px" /></a>创建 GET 标签调用</h5>
<div id="protocol" style="height:400px;overflow:auto;">
<table cellpadding="0" cellspacing="0">
  <tr>
    <th width="30%">数据源：</th>
    <td><select id="db_table" onChange="select_db_table(this.value)">
     <option value="">请选择</option>
     <option value="MM_LOCALHOST">本系统</option>
    </select></td>
  </tr>
<tbody id="db_tables" style="display:none">
  <tr>
    <th width="30%">数据表：</th>
    <td><select id="dbase" onChange="get_fields(this.value)">
    <option value="">请选择</option>
    </select></td>
  </tr>
</tbody>
<tbody id="where" style="display:none">
  <tr>
  <td colspan="2">
    <table cellpadding="1" cellspacing="1" width="150" class="table_list">
    <caption>数据调用条件设置</caption>
    <tr>
    <th class="align_c">字段名</th>
    <th class="align_c">类型</th>
    <th class="align_c">显示</th>
    <th class="align_c">条件</th>
    <th class="align_c">值</th>
    <th class="align_c">排序</th>
    </tr>
    <tbody id="where_sql"></tbody>
    </table>
  </td>
  </tr>
  <tr>
  <th width="30%">是否分页：</th>
  <td style="text-align:left"><input type="checkbox" id="pages" value="1" style="width:20px"></td>
  </tr>
  <tr>
  <th width="30%">每页显示：</th>
  <td style="text-align:left"><input type="text" id="pages_rows" value="10" size="5" maxlength="3"> 条</td>
  </tr>
  <tr><td></td>
  <td><input type="button" value="插 入" id="ok" onClick="go_ok()" style="width:60px"></td>
  </tr>
</tbody>
</table>
</div>
</div>

</body>
</html>
<script language="javascript" >
var db_source;
var db_tables;
var select_type = ['IS NULL','IS NOT NULL'];
function go_ok()
{
	var sql = '{get';
	if(db_source!='MM_LOCALHOST')sql += ' dbsource="'+db_source+'"';
	var a ='*';
	var fd = '';
	$("input:checked").each(function(){
		if(isNaN($(this).val()))
		{
			if(a!='*')
			{
				a += ',`'+$(this).val()+'`';
			}
			else
			{
				a = '`'+$(this).val()+'`';
			}
			fd += "{$r["+$(this).val()+"]}\n";
		}
	});
	sql += ' sql="SELECT '+a+' FROM `'+db_tables+'`';
	var where = '';
	$("select[name='func']").each(function(){
		var val = $(this).val();
		var id = $(this).attr('d');
		if($.inArray(val,select_type)<0)
		{
			var field_val = $("#fields_"+id).val();
			if(field_val!='')
			{
				if(val != 'LIKE %*%' && val != 'LIKE *%' && val != 'LIKE %*')
				{
					if(where!='')
					{
						where += ' AND `'+id+'` '+val+' \''+field_val+'\'';
					}
					else
					{
						where += '`'+id+'` '+val+' \''+field_val+'\'';
					}
				}
				else
				{
					if(where!='')
					{
						if(val == 'LIKE %*%')
						{
							where += " AND `"+id+"` "+val.replace('%*%',"'%"+field_val+"%'");
						}
						if(val == 'LIKE *%')
						{
							where += " AND `"+id+"` "+val.replace('*%',"'"+field_val+"%'");
						}
						if(val == 'LIKE %*')
						{
							where += " AND `"+id+"` "+val.replace('%*',"'%"+field_val+"'");
						}
					}
					else
					{
						if(val == 'LIKE %*%')
						{
							where += "`"+id+"` "+val.replace('%*%',"'%"+field_val+"%'");
						}
						if(val == 'LIKE *%')
						{
							where += "`"+id+"` "+val.replace('*%',"'"+field_val+"%'");
						}
						if(val == 'LIKE %*')
						{
							where += "`"+id+"` "+val.replace('%*',"'%"+field_val+"'");
						}
					}
				}
			}
		}
		else
		{
			if(where!='')
			{
				where += ' AND `'+id+'` '+val;
			}
			else
			{
				where += '`'+id+'` '+val;
			}
		}
	});
	if(where!='')sql += ' WHERE '+where;
	var order = '';
	$("select[name='order']").each(function(){
		var selected = $(this).val();
		var d = $(this).attr('d');
		if(selected!='')
		{
			if(order!='')
			{
				order += ", `"+d+"` "+selected;
			}
			else
			{
				order += " `"+d+"` "+selected;
			}
		}
	});
	if(order!='')
	{
		sql += ' ORDER BY '+order+'"';
	}
	else
	{
		sql += '"';
	}
	if($('#pages_rows').val()!='')sql += ' rows="'+$('#pages_rows').val()+'" ';
	if($("#pages").attr('checked')==true)sql += ' page="$page" ';
	sql += "}\n"+fd+"\n{/get}";
	if($("#pages").attr('checked')==true)sql += '\n{$pages}';
	insertText(sql);
	$('.jqmWindow').hide();
}

function get_db_source()
{
	$("#db_table").html(' <option value="">请选择</option><option value="MM_LOCALHOST">本系统</option>');
	$.getJSON('?mod=phpcms&file=template&action=get_db_source',function(data){
		if(data)
		{
			$.each(data,function(i,n){
				if(n.name)
				{
					$("#db_table").append('<option value="'+n.name+'">'+n.name+'</option>');
				}
			});

		}
		document.getElementById('db_table').selectedIndex=1;
		select_db_table('MM_LOCALHOST');
	});
}

function select_db_table(obj)
{
	db_source = obj;
	$("#dbase").html('<option value="">请选择</option>');
	if(obj!='')
	{
		$.getJSON('?mod=phpcms&file=template&action=get_ajax_db_table&name='+obj,function(data){
			if(data)
			{
				$.each(data,function(i,n){
                    var selected = '';
					if(n.tablename=='<?=DB_PRE?>content')
					{
						selected = 'selected';
						get_fields(n.tablename);
					}
					$("#dbase").append('<option value="'+n.tablename+'" '+selected+'>'+(n.nickname ? n.nickname : n.tablename)+'</option>');
				});
				$("#db_tables").show();
			}
			else
			{
				alert('没有找到数据表');
			}
		})
	}
}
var types = ['int','tinyint','smallint','mediumint','bigint'];
function get_fields(val)
{
	db_tables = val;
	$('#fields').html('');
					$("#where_sql").html('<tr></tr>');
	if(val!='')
	{
		$.getJSON('?mod=phpcms&file=template&action=get_fields&name='+db_source+'&tables='+val,function(data){
			if(data)
			{
				$.each(data,function(i,n){
					var str = '<tr><td>'+(n.nickname ? n.nickname : n.field)+'</td><td>'+n.type+(n.num ? '('+n.num+')' : '')+'</td><td class="align_c"><input type="checkbox" value="'+n.field+'" id="checkbox_'+n.field+'" style="border:0px"></td><td class="align_c"><select name="func" d="'+n.field+'"><option value="="';
					if($.inArray(n.type,types)>=0){str += ' selected';}
					str += '>=</option><option value=">">></option><option value=">=">>=</option> <option value="<"><</option><option value="<="><=</option><option value="!=">!=</option><option value="LIKE"';
					if($.inArray(n.type,types)<0){str += ' selected';}
					str += '>LIKE</option><option value="LIKE %*%">LIKE % * %</option><option value="LIKE *%">LIKE * %</option><option value="LIKE %*">LIKE % *</option><option value="NOT LIKE">NOT LIKE</option><option value="IS NULL">IS NULL</option><option value="IS NOT NULL">IS NOT NULL</option> </select></td><td class="align_c"><input type="text" id="fields_'+n.field+'" size="15"></td><td class="align_c"><select name="order" d="'+n.field+'" id="order_'+n.field+'"><option value=""></option><option value="ASC">升序</option><option value="DESC">降序</option></select></td></tr>';
					$("#where_sql").append(str);
				});
				$('#rows').show();
				$('#where').show();
			}
			else
			{
				alert('没有找到数据表');
			}
		});
	}
}

	$('#module').change(function(){
		var select = '';
		$('#var').hide();
		$.get('?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>', {action:'showtags', module:$('#module').val()}, function(data){
			if(data == 'null')
			{
				$('#tag').hide();
				return false;
			}
			else
			{
				var arr_tag = data.split(',');
				$.each(arr_tag, function(n){
					var val = '{tag_' + arr_tag[n] + '}';
					select += "<option value='" + val + "'>" + arr_tag[n] + "</option>";
				});
				$('#tag').show();
				$('#tag').html(select);
			}
		});
	});

	$().ready(function(){
		$('.jqmWindow').jqm({overlay: 0	}).jqDrag('.title');
		var select = '';
		$('#var').hide();
		$.get('?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>', {action:'showtags', module:$('#module').val()}, function(data){
			if(data == 'null')
			{
				$('#tag').hide();
				return false;
			}
			else
			{
				var arr_tag = data.split(',');
				$.each(arr_tag, function(n){
					var val = '{tag_' + arr_tag[n] + '}';
					select += "<option value='" + val + "'>" + arr_tag[n] + "</option>";
				});
				$('#tag').show();
				$('#tag').html(select);
			}
		});
	});

	$('#variable').change(function(){
		$('#tag').hide();
		var select = '';
		$.get('?mod=<?=$mod?>&file=<?=$file?>', {action:'showvar', strvar:$('#variable').val()}, function(data){
			if(data == 'null')
			{
				$('#var').hide();
				return false;
			}
			else
			{
				var arr_var = data.split(',');
				$.each(arr_var, function(n){
					var val = '{' + arr_var[n] + '}';
					select += "<option value='"+ val + "'>" + arr_var[n] + "</option>";
				});
				$('#var').show();
				$('#var').html(select);
			}
		});
	});

	$('#var').click(function() {
		insertText(this.value);
	});

	$('#tag').click(function() {
		insertText(this.value);
	});

	$('#addtag').change(function() {
		var str = $('#addtag').val();
		if(str != '' && str != '0')
		{
			var arr_val = str.split('-');
			window.open("?mod="+arr_val[0]+"&file=tag&action=add&operate=add&type="+arr_val[1],'tag','height=500,width=700,,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no"');
		}
	});
	is_ie();
</script>