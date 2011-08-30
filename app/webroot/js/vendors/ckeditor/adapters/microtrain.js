/* If we are going to combine and minify, this file must be called before ckeditor */
var CKEDITOR_BASEPATH = "/ckeditor/";
$(function(){
    /**
     * CKEditor
     * @TODO Define a stack of various editors
     * @TODO Determine the proper configuration for each of the exisiting editiors
     */
    var config = {
        toolbar_Full : [
            ['Source', '-',  'Bold', 'Italic', 'Underline', 'Strike'],
            ['Link', 'Image'],
            ['NumberedList','BulletedList'],
            ['SpellChecker', 'Scayt'],
            '/',
            ['Format', '-', 'Paste','PasteText','PasteFromWord','-','SelectAll','RemoveFormat' ,'-','Print'],
            ['About']
        ],

        toolbar_Basic : [
            ['Source', '-',  'Bold', 'Italic', 'Underline', 'Strike'],
            ['Link', 'Image','-','SelectAll','RemoveFormat'],
            ['NumberedList','BulletedList'],
            ['SpellChecker', 'Scayt'],
            ['About']
        ],
        
        toolbar : 'Full',
        extraPlugins : 'autogrow',
        scayt_autoStartup : true,
        toolbarStartupExpanded : false,
        basePath : '/ckeditior/',
        contentsCss : ['/css/ronco/web/default.css'],
        skin: 'kama'
    };
    
    $('.edit-basic').ckeditor(config); //Default
    /* END CKEditor */ 
});