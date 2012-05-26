# HtmlFromDoc Plug-in

This plug-in is used to convert `.docx` files to their HTML equivalent. It consists of a component which is a wrapper 
around a WordPress plug-in called **Post Office** and can be found at
[http://wordpress.org/extend/plugins/post-office/](http://wordpress.org/extend/plugins/post-office)

The primary usage of this plug-in is to allow content generation for blogs, posts using a word document which can be
easily uploaded instead of typed in the browser.

To use this plug-in you will also need to make use of the FileUpload plug-in since `.docx` files to be converted first
need to be uploaded.

__Usage:__

In your controller of interest add the plug-in components to the controller's components array:

    public $components = array(
        'HtmlFromDoc.CakeDocxToHtml',
        'FileUpload.FileUpload'
    );


Then use the following statement to get HTML for a given file:

    $html = $this->CakeDocxToHtml->convertDocumentToHtml(
        '/location/to/file.docx',
        true
    );

The second boolean parameter to the method specifies whether you want to maintain any images embedded within the
document (`true`) or you want them to be ignored (`false`).

Usage instructions for the `FileUpload` plug-in can be found here: [FileUpload](/docs/developer-plugins-file_upload)