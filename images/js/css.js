$(document).ready(function(){
　　$("input[type='text']").addClass('input_blur');
　　$("input[type='password']").addClass('input_blur');
    $("input[type='submit']").addClass('button_style');
    $("input[type='reset']").addClass('button_style');
    $("input[type='button']").addClass('button_style');
    $("input[type='radio']").addClass('radio_style');
    $("input[type='checkbox']").addClass('checkbox_style');
    $("input[type='textarea']").addClass('textarea_style');
    $("input[type='file']").addClass('file_style');
　　$("input[type='file']").blur(function () { this.className='input_blur'; } );
　　$("input[type='file']").focus(function () { this.className='input_focus'; } );
　　$("input[type='password']").blur(function () { this.className='input_blur'; } );
　　$("input[type='password']").focus(function () { this.className='input_focus'; } );
　　$("input[type='text']").blur(function () { this.className='input_blur'; } );
　　$("input[type='text']").focus(function () { this.className='input_focus'; } );
    $("textarea").blur(function () { this.className='textarea_style'; } );
　　$("textarea").focus(function () { this.className='textarea_focus'; } )
　　$(".table_list tr").mouseover(function () { this.className='mouseover'; } );
　　$(".table_list tr").mouseout(function () { this.className=''; } );
　　$("#title").focus(function () { this.className='inputtitle'; } );
　　$("#title").blur(function () { this.className='inputtitle'; } );

    $('img[tag]').css({cursor:'pointer'}).click(function(){
       var flag=$(this).attr('tag');
       var fck=$('#'+$(this).attr('fck')+'___Frame');

       var fckh=fck.height();
       (flag==1)?fck.height(fckh+120):fck.height(fckh-120) ;
    });

});