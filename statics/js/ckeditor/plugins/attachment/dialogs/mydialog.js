CKEDITOR.dialog.add( 'myDialog', function( editor )
{
	return {
		title : '附件管理',
		minWidth : 400,
		minHeight : 200,
		contents : [
			{
                id : 'iframe',
                label : 'Insert myiframedialog Movie...',
                expand : true,
				elements :
				[
					{
                        type  : 'iframe',
                        src : 'http://ckeditor.com',
                        width : 200,
                        height : 200,
                        onContentLoad : function()
                        {
                        }
					},
				]
			}
		]
	};
} );
