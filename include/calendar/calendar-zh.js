Calendar._DN = new Array
("星期日","星期一","星期二","星期三","星期四","星期五","星期六","星期日");
Calendar._SDN = new Array
("日","一","二","三","四","五","六","日");
Calendar._FD = 0;
Calendar._MN = new Array
("一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月");
Calendar._SMN = new Array
("一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月");
Calendar._TT = {};
Calendar._TT["INFO"] = "帮助";
Calendar._TT["ABOUT"] =
"选择日期:\n" +
"- 点击 \xab, \xbb 按钮选择年份\n" +
"- 点击 " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " 按钮选择月份\n" +
"- 长按以上按钮可从菜单中快速选择年份或月份";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"选择时间:\n" +
"- 点击小时或分钟可使改数值加一\n" +
"- 按住Shift键点击小时或分钟可使改数值减一\n" +
"- 点击拖动鼠标可进行快速选择";
Calendar._TT["PREV_YEAR"] = "上一年 (按住出菜单)";
Calendar._TT["PREV_MONTH"] = "上一月 (按住出菜单)";
Calendar._TT["GO_TODAY"] = "转到今日";
Calendar._TT["NEXT_MONTH"] = "下一月 (按住出菜单)";
Calendar._TT["NEXT_YEAR"] = "下一年 (按住出菜单)";
Calendar._TT["SEL_DATE"] = "选择日期";
Calendar._TT["DRAG_TO_MOVE"] = "拖动";
Calendar._TT["PART_TODAY"] = " (今日)";
Calendar._TT["DAY_FIRST"] = "最左边显示%s";
Calendar._TT["WEEKEND"] = "0,6";
Calendar._TT["CLOSE"] = "关闭";
Calendar._TT["TODAY"] = "今日";
Calendar._TT["TIME_PART"] = "(Shift-)点击鼠标或拖动改变值";
Calendar._TT["DEF_DATE_FORMAT"] = "%Y-%m-%d";
Calendar._TT["TT_DATE_FORMAT"] = "%A, %b %e日";
Calendar._TT["WK"] = "周";
Calendar._TT["TIME"] = "时间:";