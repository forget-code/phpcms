CKEDITOR.plugins.add( 'attachment',
{
	requires: [ 'iframedialog' ],
	init : function( editor )
	{
		// Add the link and unlink buttons.
		CKEDITOR.dialog.add('myDialog',this.path + "/dialogs/mydialog.js"); 
		editor.addCommand( 'showattachement',new CKEDITOR.dialogCommand( 'myDialog' ) );
		
		editor.ui.addButton( 'attachment',
			{
				//label : editor.lang.link.toolbar,
				label : "attachment",
				//icon: 'images/anchor.gif',
				command : 'showattachement'
			} );
		//CKEDITOR.dialog.add( 'link', this.path + 'dialogs/link.js' );
        var iframeWindow = null;
        var me = this;
		CKEDITOR.dialog.add( 'aattachment', function( editor )
				{		
					return {
						title : '附件管理',
						minWidth : 350,
						minHeight : 100,
						contents : [
							{
								id : 'tab1',
								label : 'First Tab',
								title : 'First Tab',
								elements :
								[
									{
										id : 'pagetitle',
										type : 'frame',
										label : '请输入下一页文章标题<br />(不输入默认使用当前标题+数字形式)'
									}
								]
							}
						],
						onOk : function()
							{
								editor.insertHtml("[page="+this.getValueOf( 'tab1', 'pagetitle' )+"]");
							}
					};

				} );
	},
 
	requires : [ 'fakeobjects' ]
} );