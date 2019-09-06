<?php 
defined('IN_PHPCMS') or exit('Access Denied');
include admintpl('header');
?>
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
	if(func == '')
	{
		url = '?mod='+mod+'&file=tag&action=quickoperate&operate='+action+'&job=edittemplate&tagname='+tagname;
	}
	else
	{
		url = '?mod='+mod+'&file=tag&action='+action+'&function='+func+'&job=edittemplate&tagname='+tagname;
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

<body onload="myform.content.focus();">
<?=$menu?>
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="20">
  <tr>
    <td>当前位置：<a href="?mod=phpcms&file=templateproject&action=manage">模板方案管理</a> > <a href="?mod=phpcms&file=template&action=manage&project=<?=$project?>&module=<?=$module?>"><?=$projectname?> - <?=$MODULE[$module]['name']?> 模板管理</a> > 添加模板</td>
  </tr>
</table>
<table cellpadding="2" cellspacing="1" class="tableborder">
  <tr>
    <th colspan=2>添加模板</th>
  </tr>
<form name="myform" method="post" action="?mod=<?=$mod?>&file=<?=$file?>&action=<?=$action?>" enctype="multipart/form-data" onsubmit="return docheck()">
<tr>
<td class="tablerow" width="8%">所属方案</td>
<td class="tablerow">
<input type="hidden" name="project" value="<?=$project?>">
<?=$projectname?>
</td>
</tr>
<tr>
<td class="tablerow">所属模块</td>
<td class="tablerow">
<input type="hidden" name="module" value="<?=$module?>">
<?=$MODULE[$module]['name']?>
</td>
</tr>
<?php if($templatetype){ ?>
<tr>
<td class="tablerow">模板类型</td>
<td class="tablerow"><?=$templatename?>(<?=$templatetype?>)</td>
</tr>
<?php } ?>
<tr>
<td class="tablerow">模板名称</td>
<td class="tablerow"><input type="text" name="templatename" size=25> 可以是中文</td>
</tr>
<tr>
<td class="tablerow">模板路径</td>
<td class="tablerow"><font color="blue">./templates/<?=$project?>/<?=$module?>/<input type="text" name="template" <?php if($templatetype){ ?>value="<?=$templatetype?>-"<?php } ?> size="25"> .html</font><font color="red">*</font>&nbsp;&nbsp;(命名规则：<font color="blue">模板类型-</font><font color="red">特征名</font>，同类型模板特征名不同)</td>
</tr>
<tr>
<td class="tablerow">模板语法</td>
<td class="tablerow">
<input type="button" value="{template 'phpcms','header'}" style="width:190px" onclick="javascript:if(this.value != '') insertText('\n{template \'phpcms\',\'header\'}')">
<input type="button" value="{include '*.php'}" style="width:115px" onclick="javascript:if(this.value != '') insertText('\n{include PHPCMS_ROOT.\'/*.php\'}')">
<input type="button" value="{loop $a $k $v}*{/loop}" style="width:160px" onclick="javascript:if(this.value != '') insertText('\n<!--{loop $array $key $val}-->\n{$key}:{$val}\n<!--{/loop}-->')">
<input type="button" value="{if *}*{/if}" style="width:100px" onclick="javascript:if(this.value != '') insertText('\n<!--{if $var1 == $var2}-->\n\n<!--{/if}-->')">
<input type="button" value="{else}" style="width:50px" onclick="javascript:if(this.value != '') insertText('\n<!--{else}-->')">
<input type="button" value="{elseif *}" style="width:70px" onclick="javascript:if(this.value != '') insertText('\n<!--{elseif $a = $b}-->')">
</td>
</tr>
<?php if(strpos($filename, 'tag_') === FALSE && strpos($filename, 'admin_') === FALSE){ ?>
<tr>
<td class="tablerow">新建标签</td>
<td class="tablerow">
<select name="phpcms_tag_list" style="font-family:arial;width:100" onchange="javascript:if(this.value != '') tag_pop('phpcms', 'add', this.value)">
<option value="">栏目/类别/专题</option>
<option value="phpcms_cat">栏目标签</option>
<option value="phpcms_type">类别标签</option>
<option value="phpcms_special_list">专题列表</option>
<option value="phpcms_special_slide">专题幻灯片</option>
</select>
 &nbsp; 
<select name="other_tag_list" style="font-family:arial;width:100" onchange="javascript:if(this.value != ''){s = this.value.split('_'); tag_pop(s[0], 'add', this.value);}">
<option value="">公告/投票/链接</option>
<option value="announce_list">公告标签</option>
<option value="vote_list">投票标签</option>
<option value="link_list">链接标签</option>
</select>
 &nbsp; 
<?php foreach($MODULE as $m){
	if(!$m['iscopy']) continue;
	?>
<select name="<?=$m['module']?>_tag_list" style="font-family:arial;width:100" onchange="javascript:if(this.value != '') tag_pop('<?=$m['module']?>', 'add', this.value)">
<option value=""><?=$m['name']?>标签</option>
<option value="<?=$m['module']?>_list"><?=$m['name']?>标题列表</option>
<option value="<?=$m['module']?>_thumb"><?=$m['name']?>图片列表</option>
<option value="<?=$m['module']?>_slide"><?=$m['name']?>幻灯片</option>
<option value="<?=$m['module']?>_related">相关<?=$m['name']?></option>
</select>
 &nbsp; 
<?php } ?>
</tr>
<tr>
<td class="tablerow">插入标签</td>
<td class="tablerow" style="LINE-HEIGHT:200%;">
<div style="height:25px">
<select name="phpcms_tag_list" style="font-family:arial;width:140"  onchange="javascript:if(this.value != '') insertText(this.value)">
<option value="">栏目/类别/专题/自定义</option>
<?php foreach($taglist['phpcms'] as $tagname) {?>
<option value="{tag_<?=$tagname?>}"><?=$tagname?></option>
<?php } ?>
</select>
 &nbsp; 
<?php 
    foreach($taglist1 as $tagmod => $tag){
	?>
<select name="<?=$tagmod?>_tag_list" style="font-family:arial;width:100" onchange="javascript:if(this.value != '') insertText(this.value)">
<option value=""><?=$MODULE[$tagmod]['name']?>公共标签</option>
<?php foreach($tag as $tagname) {?>
<option value="{tag_<?=$tagname?>}"><?=$tagname?></option>
<?php } ?>
</select>
 &nbsp; 
<?php } ?>
</div>
<div style="height:25px">
<?php 
    $i = 0;
	$num = count($channels);
    foreach($channels as $channelid => $c){
    $i++;
	$end = $i < $num ? 0 : 1;
	?>
<select name="<?=$c['module']?>_<?=$c['channelid']?>_tag_list" style="font-family:arial;width:100" onchange="javascript:if(this.value != '') insertText(this.value)">
<option value=""><?=$c['channelname']?>频道标签</option>
<?php foreach($taglist2[$channelid] as $tagname) {?>
<option value="{tag_<?=$tagname?>}"><?=$tagname?></option>
<?php } ?>
</select>
 &nbsp; 
<?php 
if(!$end && $i%6==0) echo '</div><div style="height:25px">';
}
?>
</div>
<div style="height:25px">
<?php 
    $i = 0;
	$num = count($taglist3);
    foreach($taglist3 as $tagmod => $tag){
    $i++;
	$end = $i < $num ? 0 : 1;
	?>
<select name="<?=$tagmod?>_tag_list" style="font-family:arial;width:100"  onchange="javascript:if(this.value != '') insertText(this.value)">
<option value=""><?=$MODULE[$tagmod]['name']?>标签</option>
<?php foreach($tag as $tagname) {?>
<option value="{tag_<?=$tagname?>}"><?=$tagname?></option>
<?php } ?>
</select>
 &nbsp; 
<?php 
if(!$end && $i%6==0) echo '</div><div style="height:25px">';
}
?>
</div>
</td>
</tr>
<tr>
<td class="tablerow">插入变量</td>
<td class="tablerow">
<select name="CHA_list" style="font-family:arial;width:90"  onchange="javascript:if(this.value != '') insertText(this.value)">
<option value="">用户变量</option>
<option value="{$_userid}">$_userid</option>
<option value="{$_username}">$_username</option>
<option value="{$_groupid}">$_groupid</option>
<option value="{$_arrgroupid}">$_arrgroupid</option>
<option value="{$_email}">$_email</option>
<option value="{$_chargetype}">$_chargetype</option>
<option value="{$_money}">$_money</option>
<option value="{$_point}">$_point</option>
<option value="{$_credit}">$_credit</option>
<option value="{$_begindate}">$_begindate</option>
<option value="{$_enddate}">$_enddate</option>
<option value="{$_newmessages}">$_newmessages</option>
</select>
&nbsp;
<select name="PHPCMS_list" style="font-family:arial;width:110" onchange="javascript:if(this.value != '') insertText(this.value)">
<option value="">$PHPCMS</option>
<?php foreach($PHPCMS as $k=>$v){ ?>
<option value="{$PHPCMS[<?=$k?>]}"><?=$k?></option>
<?php } ?>
</select>
&nbsp;
<select name="CHANNEL_list" style="font-family:arial;width:110" onchange="javascript:if(this.value != '') insertText(this.value)">
<option value="">$CHANNEL</option>
<?php foreach($CHANNEL[1] as $k=>$v){ ?>
<option value="{$CHANNEL[$channelid][<?=$k?>]}"><?=$k?></option>
<?php } ?>
</select>
&nbsp;
<select name="CHA_list" style="font-family:arial;width:110" onchange="javascript:if(this.value != '') insertText(this.value)">
<option value="">$CHA</option>
<option value="{$CHA[channelid]}">channelid</option>
<option value="{$CHA[module]}">module</option>
<option value="{$CHA[channelname]}">channelname</option>
<option value="{$CHA[style]}">style</option>
<option value="{$CHA[channelpic]}">channelpic</option>
<option value="{$CHA[introduce]}">introduce</option>
<option value="{$CHA[seo_title]}">seo_title</option>
<option value="{$CHA[seo_keywords]}">seo_keywords</option>
<option value="{$CHA[seo_description]}">seo_description</option>
<option value="{$CHA[listorder]}">listorder</option>
<option value="{$CHA[islink]}">islink</option>
<option value="{$CHA[channeldir]}">channeldir</option>
<option value="{$CHA[channeldomain]}">channeldomain</option>
<option value="{$CHA[disabled]}">disabled</option>
<option value="{$CHA[templateid]}">templateid</option>
<option value="{$CHA[skinid]}">skinid</option>
<option value="{$CHA[items]}">items</option>
<option value="{$CHA[comments]}">comments</option>
<option value="{$CHA[categorys]}">categorys</option>
<option value="{$CHA[specials]}">specials</option>
<option value="{$CHA[hits]}">hits</option>
<option value="{$CHA[enablepurview]}">enablepurview</option>
<option value="{$CHA[arrgroupid_browse]}">arrgroupid_browse</option>
<option value="{$CHA[purview_message]}">purview_message</option>
<option value="{$CHA[point_message]}">point_message</option>
<option value="{$CHA[enablecontribute]}">enablecontribute</option>
<option value="{$CHA[enablecheck]}">enablecheck</option>
<option value="{$CHA[emailofreject]}">emailofreject</option>
<option value="{$CHA[emailofpassed]}">emailofpassed</option>
<option value="{$CHA[enableupload]}">enableupload</option>
<option value="{$CHA[uploaddir]}">uploaddir</option>
<option value="{$CHA[maxfilesize]}">maxfilesize</option>
<option value="{$CHA[uploadfiletype]}">uploadfiletype</option>
<option value="{$CHA[linkurl]}">linkurl</option>
<option value="{$CHA[setting]}">setting</option>
<option value="{$CHA[ishtml]}">ishtml</option>
<option value="{$CHA[cat_html_urlruleid]}">cat_html_urlruleid</option>
<option value="{$CHA[item_html_urlruleid]}">item_html_urlruleid</option>
<option value="{$CHA[special_html_urlruleid]}">special_html_urlruleid</option>
<option value="{$CHA[cat_php_urlruleid]}">cat_php_urlruleid</option>
<option value="{$CHA[item_php_urlruleid]}">item_php_urlruleid</option>
<option value="{$CHA[special_php_urlruleid]}">special_php_urlruleid</option>
</select>
&nbsp;
<select name="CATEGORY_list" style="font-family:arial;width:110" onchange="javascript:if(this.value != '') insertText(this.value)">
<option value="">$CATEGORY</option>
<option value="{$CATEGORY[$catid][module]}">module</option>
<option value="{$CATEGORY[$catid][channelid]}">channelid</option>
<option value="{$CATEGORY[$catid][catid]}">catid</option>
<option value="{$CATEGORY[$catid][catname]}">catname</option>
<option value="{$CATEGORY[$catid][style]}">style</option>
<option value="{$CATEGORY[$catid][introduce]}">introduce</option>
<option value="{$CATEGORY[$catid][catpic]}">catpic</option>
<option value="{$CATEGORY[$catid][islink]}">islink</option>
<option value="{$CATEGORY[$catid][catdir]}">catdir</option>
<option value="{$CATEGORY[$catid][linkurl]}">linkurl</option>
<option value="{$CATEGORY[$catid][parentid]}">parentid</option>
<option value="{$CATEGORY[$catid][arrparentid]}">arrparentid</option>
<option value="{$CATEGORY[$catid][parentdir]}">parentdir</option>
<option value="{$CATEGORY[$catid][child]}">child</option>
<option value="{$CATEGORY[$catid][arrchildid]}">arrchildid</option>
<option value="{$CATEGORY[$catid][itemordertype]}">itemordertype</option>
<option value="{$CATEGORY[$catid][itemtarget]}">itemtarget</option>
<option value="{$CATEGORY[$catid][ismenu]}">ismenu</option>
<option value="{$CATEGORY[$catid][islist]}">islist</option>
<option value="{$CATEGORY[$catid][ishtml]}">ishtml</option>
<option value="{$CATEGORY[$catid][htmldir]}">htmldir</option>
<option value="{$CATEGORY[$catid][prefix]}">prefix</option>
<option value="{$CATEGORY[$catid][urlruleid]}">urlruleid</option>
<option value="{$CATEGORY[$catid][item_prefix]}">item_prefix</option>
<option value="{$CATEGORY[$catid][item_html_urlruleid]}">item_html_urlruleid</option>
<option value="{$CATEGORY[$catid][item_php_urlruleid]}">item_php_urlruleid</option>
</select>
&nbsp;
<select name="CAT_list" style="font-family:arial;width:110" onchange="javascript:if(this.value != '') insertText(this.value)">
<option value="">$CAT</option>
<option value="{$CAT[catid]}">catid</option>
<option value="{$CAT[module]}">module</option>
<option value="{$CAT[channelid]}">channelid</option>
<option value="{$CAT[catname]}">catname</option>
<option value="{$CAT[catpic]}">catpic</option>
<option value="{$CAT[style]}">style</option>
<option value="{$CAT[introduce]}">introduce</option>
<option value="{$CAT[islink]}">islink</option>
<option value="{$CAT[catdir]}">catdir</option>
<option value="{$CAT[parentid]}">parentid</option>
<option value="{$CAT[arrparentid]}">arrparentid</option>
<option value="{$CAT[parentdir]}">parentdir</option>
<option value="{$CAT[child]}">child</option>
<option value="{$CAT[arrchildid]}">arrchildid</option>
<option value="{$CAT[itemtarget]}">itemtarget</option>
<option value="{$CAT[itemordertype]}">itemordertype</option>
<option value="{$CAT[listorder]}">listorder</option>
<option value="{$CAT[ismenu]}">ismenu</option>
<option value="{$CAT[islist]}">islist</option>
<option value="{$CAT[ishtml]}">ishtml</option>
<option value="{$CAT[htmldir]}">htmldir</option>
<option value="{$CAT[prefix]}">prefix</option>
<option value="{$CAT[urlruleid]}">urlruleid</option>
<option value="{$CAT[item_htmldir]}">item_htmldir</option>
<option value="{$CAT[item_prefix]}">item_prefix</option>
<option value="{$CAT[item_html_urlruleid]}">item_html_urlruleid</option>
<option value="{$CAT[item_php_urlruleid]}">item_php_urlruleid</option>
<option value="{$CAT[linkurl]}">linkurl</option>
<option value="{$CAT[items]}">items</option>
<option value="{$CAT[hits]}">hits</option>
<option value="{$CAT[disabled]}">disabled</option>
<option value="{$CAT[seo_title]}">seo_title</option>
<option value="{$CAT[seo_keywords]}">seo_keywords</option>
<option value="{$CAT[seo_description]}">seo_description</option>
<option value="{$CAT[skinid]}">skinid</option>
<option value="{$CAT[templateid]}">templateid</option>
<option value="{$CAT[listtemplateid]}">listtemplateid</option>
<option value="{$CAT[defaultitemskin]}">defaultitemskin</option>
<option value="{$CAT[defaultitemtemplate]}">defaultitemtemplate</option>
<option value="{$CAT[enableadd]}">enableadd</option>
<option value="{$CAT[enableprotect]}">enableprotect</option>
<option value="{$CAT[showchilditems]}">showchilditems</option>
<option value="{$CAT[maxperpage]}">maxperpage</option>
<option value="{$CAT[enablepurview]}">enablepurview</option>
<option value="{$CAT[creditget]}">creditget</option>
<option value="{$CAT[defaultpoint]}">defaultpoint</option>
<option value="{$CAT[chargedays]}">chargedays</option>
<option value="{$CAT[arrgroupid_browse]}">arrgroupid_browse</option>
<option value="{$CAT[arrgroupid_view]}">arrgroupid_view</option>
<option value="{$CAT[arrgroupid_add]}">arrgroupid_add</option>
</select>
</td>
</tr>
<tr>
<td class="tablerow">标签操作</td>
<td class="tablerow">
<input type="text" name="tagname" value="请输入标签名" size="15" onclick="if(this.value == '请输入标签名') this.value=''"> <input name="dosubmit" type="button" value="编辑标签" onclick="window.open('?mod=phpcms&file=tag&action=quickoperate&operate=edit&job=edittemplate&tagname='+myform.tagname.value,'tag','height=500,width=700,,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no')">
&nbsp;&nbsp;
<input type="button" name="tagpreview" value="预览被选中的标签" style="background:blue;color:#ffffff;width:120px" onclick="javascript:if(document.selection.createRange().text != '') tag_pop('phpcms','preview','')">
&nbsp;&nbsp;
<input type="button" name="tagedit" value="编辑被选中的标签" style="background:blue;color:#ffffff;width:120px" onclick="javascript:if(document.selection.createRange().text != '') tag_pop('phpcms','edit','')">
&nbsp;&nbsp;
<input type="button" name="tagcopy" value="复制被选中的标签" style="background:blue;color:#ffffff;width:120px" onclick="javascript:if(document.selection.createRange().text != '') tag_pop('phpcms','copy','')">
&nbsp;&nbsp;
<input type="button" name="listtag" value="列出模板中的标签" style="background:blue;color:#ffffff;width:120px" onclick="window.open('?mod=phpcms&file=tag&action=listtag&job=edittemplate&module='+myform.module.value+'&templatename='+myform.templatename.value+'&template='+myform.template.value,'tag','height=500,width=700,,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes,resizable=no,location=no,status=no')">
</td>
</tr>
<?php } ?>
<tr>
<td class="tablerow">创建方式</td>
<td class="tablerow"><input type="radio" name="createtype" value="0" checked onclick="createtype0.style.display='';createtype1.style.display='none'"> 在线创建 <input type="radio" name="createtype" value="1"  onclick="createtype0.style.display='none';createtype1.style.display=''"> 本地上传 </td>
</tr>
<tbody id='createtype0' style="display:">
<tr>
<td class="tablerow" colspan=2 align="left">
<textarea id='txt_ln' rows='30' cols='4' align='left' style='overflow:hidden;border-right:0px;padding-right:0px;text-align:right;scrolling:no;height:320px;font-family:Fixedsys,verdana,宋体;font-size:12px;background-color:#eeeeee;color:#0000FF;' readonly>
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
1501
1502
1503
1504
1505
1506
1507
1508
1509
1510
1511
1512
1513
1514
1515
1516
1517
1518
1519
1520
1521
1522
1523
1524
1525
1526
1527
1528
1529
1530
1531
1532
1533
1534
1535
1536
1537
1538
1539
1540
1541
1542
1543
1544
1545
1546
1547
1548
1549
1550
1551
1552
1553
1554
1555
1556
1557
1558
1559
1560
1561
1562
1563
1564
1565
1566
1567
1568
1569
1570
1571
1572
1573
1574
1575
1576
1577
1578
1579
1580
1581
1582
1583
1584
1585
1586
1587
1588
1589
1590
1591
1592
1593
1594
1595
1596
1597
1598
1599
1600
1601
1602
1603
1604
1605
1606
1607
1608
1609
1610
1611
1612
1613
1614
1615
1616
1617
1618
1619
1620
1621
1622
1623
1624
1625
1626
1627
1628
1629
1630
1631
1632
1633
1634
1635
1636
1637
1638
1639
1640
1641
1642
1643
1644
1645
1646
1647
1648
1649
1650
1651
1652
1653
1654
1655
1656
1657
1658
1659
1660
1661
1662
1663
1664
1665
1666
1667
1668
1669
1670
1671
1672
1673
1674
1675
1676
1677
1678
1679
1680
1681
1682
1683
1684
1685
1686
1687
1688
1689
1690
1691
1692
1693
</textarea>
<textarea id='txt_main' name='content'  onscroll='show_ln()' wrap='off' style='width:720px;height:320px;overflow:auto;scrolling:yes;border-left:0px;font-family:Fixedsys,verdana,宋体;font-size:12px;'>
</textarea> <font color="red">*</font>
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
</script>
</td>
</tr>
</tbody>
<tbody id='createtype1' style="display:none">
<tr>
<td class="tablerow">模板文件</td>
<td class="tablerow"><input type="file" name="uploadfile" size="20"> <font color="red">*</font></td>
</tr>
</tbody>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
 <input type="submit" name="dosubmit" value=" 保存 ">&nbsp;&nbsp;&nbsp;&nbsp;
 <input type="reset" name="submit" value=" 重置 ">&nbsp;&nbsp;&nbsp;&nbsp;
 <input type="button" name="bt" value=" 预览 " style="background:blue;color:#ffffff;" onclick="window.open('?mod=phpcms&file=template&action=preview')">
</td>
  </tr>
</table>
</form>
</body>
</html>