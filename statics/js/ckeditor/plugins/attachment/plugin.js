CKEDITOR.plugins.add( 'attachment',
{
	init : function( editor )
	{
		// Add the link and unlink buttons.
		editor.addCommand( 'attachment', {  
			exec:function (e){  
			var returnValue = window.showModalDialog('?m=test&c=rocing');  
			  
		   CKEDITOR.instances.editor.insertHtml(returnValue);
		}  
	});
		editor.ui.addButton( 'attachment',
			{
				//label : editor.lang.link.toolbar,
				label : "attachment",
				//icon: 'images/anchor.gif',
				command : 'attachment'
			} );
	},
 
	requires : [ 'fakeobjects' ]
} );