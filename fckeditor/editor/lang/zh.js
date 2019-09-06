/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2008 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Chinese Simplified language file.
 */

var FCKLang =
{
// Language direction : "ltr" (left to right) or "rtl" (right to left).
Dir					: "ltr",

ToolbarCollapse		: "折疊工具欄",
ToolbarExpand		: "展開工具欄",

// Toolbar Items and Context Menu
Save				: "保存",
NewPage				: "新建",
Preview				: "預覽",
Cut					: "剪切",
Copy				: "複製",
Paste				: "粘貼",
PasteText			: "粘貼為無格式文本",
PasteWord			: "從 MS Word 粘貼",
Print				: "打印",
SelectAll			: "全選",
RemoveFormat		: "清除格式",
InsertLinkLbl		: "超鏈接",
InsertLink			: "插入/編輯超鏈接",
RemoveLink			: "取消超鏈接",
VisitLink			: "打開超鏈接",
Anchor				: "插入/編輯錨點鏈接",
AnchorDelete		: "清除錨點鏈接",
InsertImageLbl		: "圖像",
InsertImage			: "插入/編輯圖像",
InsertFlashLbl		: "Flash",
InsertFlash			: "插入/編輯 Flash",
InsertMedia			: "插入多媒體文件",
InsertMediaLbl		: "多媒體文件",
InsertAttach		: "上傳附件",
InsertAttachLbl		: "附件",
InsertTableLbl		: "表格",
InsertTable			: "插入/編輯表格",
InsertLineLbl		: "水平線",
InsertLine			: "插入水平線",
InsertSpecialCharLbl: "特殊符號",
InsertSpecialChar	: "插入特殊符號",
InsertSmileyLbl		: "表情符",
InsertSmiley		: "插入表情圖標",
About				: "關於 FCKeditor",
Bold				: "加粗",
Italic				: "傾斜",
Underline			: "下劃線",
StrikeThrough		: "刪除線",
Subscript			: "下標",
Superscript			: "上標",
LeftJustify			: "左對齊",
CenterJustify		: "居中對齊",
RightJustify		: "右對齊",
BlockJustify		: "兩端對齊",
DecreaseIndent		: "減少縮進量",
IncreaseIndent		: "增加縮進量",
Blockquote			: "塊引用",
CreateDiv			: "新增 Div 標籤",
EditDiv				: "更改 Div 標籤",
DeleteDiv			: "刪除 Div 標籤",
Undo				: "撤消",
Redo				: "重做",
NumberedListLbl		: "編號列表",
NumberedList		: "插入/刪除編號列表",
BulletedListLbl		: "項目列表",
BulletedList		: "插入/刪除項目列表",
ShowTableBorders	: "顯示表格邊框",
ShowDetails			: "顯示詳細資料",
Style				: "樣式",
FontFormat			: "格式",
Font				: "字體",
FontSize			: "大小",
TextColor			: "文本顏色",
BGColor				: "背景顏色",
Source				: "源代碼",
Find				: "查找",
Replace				: "替換",
SpellCheck			: "拼寫檢查",
UniversalKeyboard	: "軟鍵盤",
PageBreakLbl		: "分頁符",
PageBreak			: "插入分頁符",

Form			: "表單",
Checkbox		: "復選框",
RadioButton		: "單選按鈕",
TextField		: "單行文本",
Textarea		: "多行文本",
HiddenField		: "隱藏域",
Button			: "按鈕",
SelectionField	: "列表/菜單",
ImageButton		: "圖像域",

FitWindow		: "全屏編輯",
ShowBlocks		: "顯示區塊",

// Context Menu
EditLink			: "編輯超鏈接",
CellCM				: "單元格",
RowCM				: "行",
ColumnCM			: "列",
InsertRowAfter		: "下插入行",
InsertRowBefore		: "上插入行",
DeleteRows			: "刪除行",
InsertColumnAfter	: "右插入列",
InsertColumnBefore	: "左插入列",
DeleteColumns		: "刪除列",
InsertCellAfter		: "右插入單元格",
InsertCellBefore	: "左插入單元格",
DeleteCells			: "刪除單元格",
MergeCells			: "合併單元格",
MergeRight			: "右合併單元格",
MergeDown			: "下合併單元格",
HorizontalSplitCell	: "橫拆分單元格",
VerticalSplitCell	: "縱拆分單元格",
TableDelete			: "刪除表格",
CellProperties		: "單元格屬性",
TableProperties		: "表格屬性",
ImageProperties		: "圖像屬性",
FlashProperties		: "Flash 屬性",

AnchorProp			: "錨點鏈接屬性",
ButtonProp			: "按鈕屬性",
CheckboxProp		: "復選框屬性",
HiddenFieldProp		: "隱藏域屬性",
RadioButtonProp		: "單選按鈕屬性",
ImageButtonProp		: "圖像域屬性",
TextFieldProp		: "單行文本屬性",
SelectionFieldProp	: "菜單/列表屬性",
TextareaProp		: "多行文本屬性",
FormProp			: "表單屬性",

FontFormats			: "普通;已編排格式;地址;標題 1;標題 2;標題 3;標題 4;標題 5;標題 6;段落(DIV)",

// Alerts and Messages
ProcessingXHTML		: "正在處理 XHTML，請稍等...",
Done				: "完成",
PasteWordConfirm	: "您要粘貼的內容好像是來自 MS Word，是否要清除 MS Word 格式後再粘貼？",
NotCompatiblePaste	: "該命令需要 Internet Explorer 5.5 或更高版本的支持，是否按常規粘貼進行？",
UnknownToolbarItem	: "未知工具欄項目 \"%1\"",
UnknownCommand		: "未知命令名稱 \"%1\"",
NotImplemented		: "命令無法執行",
UnknownToolbarSet	: "工具欄設置 \"%1\" 不存在",
NoActiveX			: "瀏覽器安全設置限制了本編輯器的某些功能。您必須啟用安全設置中的「運行 ActiveX 控件和插件」，否則將出現某些錯誤並缺少功能。",
BrowseServerBlocked : "無法打開資源瀏覽器，請確認是否啟用了禁止彈出窗口。",
DialogBlocked		: "無法打開對話框窗口，請確認是否啟用了禁止彈出窗口或網頁對話框（IE）。",
VisitLinkBlocked	: "無法打開新窗口，請確認是否啟用了禁止彈出窗口或網頁對話框（IE）。",

// Dialogs
DlgBtnOK			: "確定",
DlgBtnCancel		: "取消",
DlgBtnClose			: "關閉",
DlgBtnBrowseServer	: "瀏覽服務器",
DlgAdvancedTag		: "高級",
DlgOpOther			: "<其它>",
DlgInfoTab			: "信息",
DlgAlertUrl			: "請插入 URL",

// General Dialogs Labels
DlgGenNotSet		: "<沒有設置>",
DlgGenId			: "ID",
DlgGenLangDir		: "語言方向",
DlgGenLangDirLtr	: "從左到右 (LTR)",
DlgGenLangDirRtl	: "從右到左 (RTL)",
DlgGenLangCode		: "語言代碼",
DlgGenAccessKey		: "訪問鍵",
DlgGenName			: "名稱",
DlgGenTabIndex		: "Tab 鍵次序",
DlgGenLongDescr		: "詳細說明地址",
DlgGenClass			: "樣式類名稱",
DlgGenTitle			: "標題",
DlgGenContType		: "內容類型",
DlgGenLinkCharset	: "字符編碼",
DlgGenStyle			: "行內樣式",

// Image Dialog
DlgImgTitle			: "圖像屬性",
DlgImgInfoTab		: "圖像",
DlgImgBtnUpload		: "發送到服務器上",
DlgImgURL			: "源文件",
DlgImgUpload		: "上傳",
DlgImgAlt			: "替換文本",
DlgImgWidth			: "寬度",
DlgImgHeight		: "高度",
DlgImgLockRatio		: "鎖定比例",
DlgBtnResetSize		: "恢復尺寸",
DlgImgBorder		: "邊框大小",
DlgImgHSpace		: "水平間距",
DlgImgVSpace		: "垂直間距",
DlgImgAlign			: "對齊方式",
DlgImgAlignLeft		: "左對齊",
DlgImgAlignAbsBottom: "絕對底邊",
DlgImgAlignAbsMiddle: "絕對居中",
DlgImgAlignBaseline	: "基線",
DlgImgAlignBottom	: "底邊",
DlgImgAlignMiddle	: "居中",
DlgImgAlignRight	: "右對齊",
DlgImgAlignTextTop	: "文本上方",
DlgImgAlignTop		: "頂端",
DlgImgPreview		: "預覽",
DlgImgAlertUrl		: "請輸入圖像地址",
DlgImgLinkTab		: "鏈接",

// Flash Dialog
DlgFlashTitle		: "Flash 屬性",
DlgFlashChkPlay		: "自動播放",
DlgFlashChkLoop		: "循環",
DlgFlashChkMenu		: "啟用 Flash 菜單",
DlgFlashScale		: "縮放",
DlgFlashScaleAll	: "全部顯示",
DlgFlashScaleNoBorder	: "無邊框",
DlgFlashScaleFit	: "嚴格匹配",

DlgMediaTitle			: "多媒體屬性",
DlgAttachTitle			: "附件屬性",
DlgAttachName			: "附件名稱",
DlgAttachUrl			: "附件地址",

// Link Dialog
DlgLnkWindowTitle	: "超鏈接",
DlgLnkInfoTab		: "超鏈接信息",
DlgLnkTargetTab		: "目標",

DlgLnkType			: "超鏈接類型",
DlgLnkTypeURL		: "超鏈接",
DlgLnkTypeAnchor	: "頁內錨點鏈接",
DlgLnkTypeEMail		: "電子郵件",
DlgLnkProto			: "協議",
DlgLnkProtoOther	: "<其它>",
DlgLnkURL			: "地址",
DlgLnkAnchorSel		: "選擇一個錨點",
DlgLnkAnchorByName	: "按錨點名稱",
DlgLnkAnchorById	: "按錨點 ID",
DlgLnkNoAnchors		: "(此文檔沒有可用的錨點)",
DlgLnkEMail			: "地址",
DlgLnkEMailSubject	: "主題",
DlgLnkEMailBody		: "內容",
DlgLnkUpload		: "上傳",
DlgLnkBtnUpload		: "發送到服務器上",

DlgLnkTarget		: "目標",
DlgLnkTargetFrame	: "<框架>",
DlgLnkTargetPopup	: "<彈出窗口>",
DlgLnkTargetBlank	: "新窗口 (_blank)",
DlgLnkTargetParent	: "父窗口 (_parent)",
DlgLnkTargetSelf	: "本窗口 (_self)",
DlgLnkTargetTop		: "整頁 (_top)",
DlgLnkTargetFrameName	: "目標框架名稱",
DlgLnkPopWinName	: "彈出窗口名稱",
DlgLnkPopWinFeat	: "彈出窗口屬性",
DlgLnkPopResize		: "調整大小",
DlgLnkPopLocation	: "地址欄",
DlgLnkPopMenu		: "菜單欄",
DlgLnkPopScroll		: "滾動條",
DlgLnkPopStatus		: "狀態欄",
DlgLnkPopToolbar	: "工具欄",
DlgLnkPopFullScrn	: "全屏 (IE)",
DlgLnkPopDependent	: "依附 (NS)",
DlgLnkPopWidth		: "寬",
DlgLnkPopHeight		: "高",
DlgLnkPopLeft		: "左",
DlgLnkPopTop		: "右",

DlnLnkMsgNoUrl		: "請輸入超鏈接地址",
DlnLnkMsgNoEMail	: "請輸入電子郵件地址",
DlnLnkMsgNoAnchor	: "請選擇一個錨點",
DlnLnkMsgInvPopName	: "彈出窗口名稱必須以字母開頭，並且不能含有空格。",

// Color Dialog
DlgColorTitle		: "選擇顏色",
DlgColorBtnClear	: "清除",
DlgColorHighlight	: "預覽",
DlgColorSelected	: "選擇",

// Smiley Dialog
DlgSmileyTitle		: "插入表情圖標",

// Special Character Dialog
DlgSpecialCharTitle	: "選擇特殊符號",

// Table Dialog
DlgTableTitle		: "表格屬性",
DlgTableRows		: "行數",
DlgTableColumns		: "列數",
DlgTableBorder		: "邊框",
DlgTableAlign		: "對齊",
DlgTableAlignNotSet	: "<沒有設置>",
DlgTableAlignLeft	: "左對齊",
DlgTableAlignCenter	: "居中",
DlgTableAlignRight	: "右對齊",
DlgTableWidth		: "寬度",
DlgTableWidthPx		: "像素",
DlgTableWidthPc		: "百分比",
DlgTableHeight		: "高度",
DlgTableCellSpace	: "間距",
DlgTableCellPad		: "邊距",
DlgTableCaption		: "標題",
DlgTableSummary		: "摘要",

// Table Cell Dialog
DlgCellTitle		: "單元格屬性",
DlgCellWidth		: "寬度",
DlgCellWidthPx		: "像素",
DlgCellWidthPc		: "百分比",
DlgCellHeight		: "高度",
DlgCellWordWrap		: "自動換行",
DlgCellWordWrapNotSet	: "<沒有設置>",
DlgCellWordWrapYes	: "是",
DlgCellWordWrapNo	: "否",
DlgCellHorAlign		: "水平對齊",
DlgCellHorAlignNotSet	: "<沒有設置>",
DlgCellHorAlignLeft	: "左對齊",
DlgCellHorAlignCenter	: "居中",
DlgCellHorAlignRight: "右對齊",
DlgCellVerAlign		: "垂直對齊",
DlgCellVerAlignNotSet	: "<沒有設置>",
DlgCellVerAlignTop	: "頂端",
DlgCellVerAlignMiddle	: "居中",
DlgCellVerAlignBottom	: "底部",
DlgCellVerAlignBaseline	: "基線",
DlgCellRowSpan		: "縱跨行數",
DlgCellCollSpan		: "橫跨列數",
DlgCellBackColor	: "背景顏色",
DlgCellBorderColor	: "邊框顏色",
DlgCellBtnSelect	: "選擇...",

// Find and Replace Dialog
DlgFindAndReplaceTitle	: "查找和替換",

// Find Dialog
DlgFindTitle		: "查找",
DlgFindFindBtn		: "查找",
DlgFindNotFoundMsg	: "指定文本沒有找到。",

// Replace Dialog
DlgReplaceTitle			: "替換",
DlgReplaceFindLbl		: "查找:",
DlgReplaceReplaceLbl	: "替換:",
DlgReplaceCaseChk		: "區分大小寫",
DlgReplaceReplaceBtn	: "替換",
DlgReplaceReplAllBtn	: "全部替換",
DlgReplaceWordChk		: "全字匹配",

// Paste Operations / Dialog
PasteErrorCut	: "您的瀏覽器安全設置不允許編輯器自動執行剪切操作，請使用鍵盤快捷鍵(Ctrl+X)來完成。",
PasteErrorCopy	: "您的瀏覽器安全設置不允許編輯器自動執行複製操作，請使用鍵盤快捷鍵(Ctrl+C)來完成。",

PasteAsText		: "粘貼為無格式文本",
PasteFromWord	: "從 MS Word 粘貼",

DlgPasteMsg2	: "請使用鍵盤快捷鍵(<STRONG>Ctrl+V</STRONG>)把內容粘貼到下面的方框裡，再按 <STRONG>確定</STRONG>。",
DlgPasteSec		: "因為你的瀏覽器的安全設置原因，本編輯器不能直接訪問你的剪貼板內容，你需要在本窗口重新粘貼一次。",
DlgPasteIgnoreFont		: "忽略 Font 標籤",
DlgPasteRemoveStyles	: "清理 CSS 樣式",

// Color Picker
ColorAutomatic	: "自動",
ColorMoreColors	: "其它顏色...",

// Document Properties
DocProps		: "頁面屬性",

// Anchor Dialog
DlgAnchorTitle		: "命名錨點",
DlgAnchorName		: "錨點名稱",
DlgAnchorErrorName	: "請輸入錨點名稱",

// Speller Pages Dialog
DlgSpellNotInDic		: "沒有在字典裡",
DlgSpellChangeTo		: "更改為",
DlgSpellBtnIgnore		: "忽略",
DlgSpellBtnIgnoreAll	: "全部忽略",
DlgSpellBtnReplace		: "替換",
DlgSpellBtnReplaceAll	: "全部替換",
DlgSpellBtnUndo			: "撤消",
DlgSpellNoSuggestions	: "- 沒有建議 -",
DlgSpellProgress		: "正在進行拼寫檢查...",
DlgSpellNoMispell		: "拼寫檢查完成：沒有發現拼寫錯誤",
DlgSpellNoChanges		: "拼寫檢查完成：沒有更改任何單詞",
DlgSpellOneChange		: "拼寫檢查完成：更改了一個單詞",
DlgSpellManyChanges		: "拼寫檢查完成：更改了 %1 個單詞",

IeSpellDownload			: "拼寫檢查插件還沒安裝，你是否想現在就下載？",

// Button Dialog
DlgButtonText		: "標籤(值)",
DlgButtonType		: "類型",
DlgButtonTypeBtn	: "按鈕",
DlgButtonTypeSbm	: "提交",
DlgButtonTypeRst	: "重設",

// Checkbox and Radio Button Dialogs
DlgCheckboxName		: "名稱",
DlgCheckboxValue	: "選定值",
DlgCheckboxSelected	: "已勾選",

// Form Dialog
DlgFormName		: "名稱",
DlgFormAction	: "動作",
DlgFormMethod	: "方法",

// Select Field Dialog
DlgSelectName		: "名稱",
DlgSelectValue		: "選定",
DlgSelectSize		: "高度",
DlgSelectLines		: "行",
DlgSelectChkMulti	: "允許多選",
DlgSelectOpAvail	: "列表值",
DlgSelectOpText		: "標籤",
DlgSelectOpValue	: "值",
DlgSelectBtnAdd		: "新增",
DlgSelectBtnModify	: "修改",
DlgSelectBtnUp		: "上移",
DlgSelectBtnDown	: "下移",
DlgSelectBtnSetValue : "設為初始化時選定",
DlgSelectBtnDelete	: "刪除",

// Textarea Dialog
DlgTextareaName	: "名稱",
DlgTextareaCols	: "字符寬度",
DlgTextareaRows	: "行數",

// Text Field Dialog
DlgTextName			: "名稱",
DlgTextValue		: "初始值",
DlgTextCharWidth	: "字符寬度",
DlgTextMaxChars		: "最多字符數",
DlgTextType			: "類型",
DlgTextTypeText		: "文本",
DlgTextTypePass		: "密碼",

// Hidden Field Dialog
DlgHiddenName	: "名稱",
DlgHiddenValue	: "初始值",

// Bulleted List Dialog
BulletedListProp	: "項目列表屬性",
NumberedListProp	: "編號列表屬性",
DlgLstStart			: "開始序號",
DlgLstType			: "列表類型",
DlgLstTypeCircle	: "圓圈",
DlgLstTypeDisc		: "圓點",
DlgLstTypeSquare	: "方塊",
DlgLstTypeNumbers	: "數字 (1, 2, 3)",
DlgLstTypeLCase		: "小寫字母 (a, b, c)",
DlgLstTypeUCase		: "大寫字母 (A, B, C)",
DlgLstTypeSRoman	: "小寫羅馬數字 (i, ii, iii)",
DlgLstTypeLRoman	: "大寫羅馬數字 (I, II, III)",

// Document Properties Dialog
DlgDocGeneralTab	: "常規",
DlgDocBackTab		: "背景",
DlgDocColorsTab		: "顏色和邊距",
DlgDocMetaTab		: "Meta 數據",

DlgDocPageTitle		: "頁面標題",
DlgDocLangDir		: "語言方向",
DlgDocLangDirLTR	: "從左到右 (LTR)",
DlgDocLangDirRTL	: "從右到左 (RTL)",
DlgDocLangCode		: "語言代碼",
DlgDocCharSet		: "字符編碼",
DlgDocCharSetCE		: "中歐",
DlgDocCharSetCT		: "繁體中文 (Big5)",
DlgDocCharSetCR		: "西裡爾文",
DlgDocCharSetGR		: "希臘文",
DlgDocCharSetJP		: "日文",
DlgDocCharSetKR		: "韓文",
DlgDocCharSetTR		: "土耳其文",
DlgDocCharSetUN		: "Unicode (UTF-8)",
DlgDocCharSetWE		: "西歐",
DlgDocCharSetOther	: "其它字符編碼",

DlgDocDocType		: "文檔類型",
DlgDocDocTypeOther	: "其它文檔類型",
DlgDocIncXHTML		: "包含 XHTML 聲明",
DlgDocBgColor		: "背景顏色",
DlgDocBgImage		: "背景圖像",
DlgDocBgNoScroll	: "不滾動背景圖像",
DlgDocCText			: "文本",
DlgDocCLink			: "超鏈接",
DlgDocCVisited		: "已訪問的超鏈接",
DlgDocCActive		: "活動超鏈接",
DlgDocMargins		: "頁面邊距",
DlgDocMaTop			: "上",
DlgDocMaLeft		: "左",
DlgDocMaRight		: "右",
DlgDocMaBottom		: "下",
DlgDocMeIndex		: "頁面索引關鍵字 (用半角逗號[,]分隔)",
DlgDocMeDescr		: "頁面說明",
DlgDocMeAuthor		: "作者",
DlgDocMeCopy		: "版權",
DlgDocPreview		: "預覽",

// Templates Dialog
Templates			: "模板",
DlgTemplatesTitle	: "內容模板",
DlgTemplatesSelMsg	: "請選擇編輯器內容模板<br>(當前內容將會被清除替換):",
DlgTemplatesLoading	: "正在加載模板列表，請稍等...",
DlgTemplatesNoTpl	: "(沒有模板)",
DlgTemplatesReplace	: "替換當前內容",

// About Dialog
DlgAboutAboutTab	: "關於",
DlgAboutBrowserInfoTab	: "瀏覽器信息",
DlgAboutLicenseTab	: "許可證",
DlgAboutVersion		: "版本",
DlgAboutInfo		: "要獲得更多信息請訪問 ",

// Div Dialog
DlgDivGeneralTab	: "常規",
DlgDivAdvancedTab	: "高級",
DlgDivStyle		: "樣式",
DlgDivInlineStyle	: "CSS 樣式"
};
