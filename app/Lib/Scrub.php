<?php
App::import('Vendor', 'HTMLPurifier', 
        array('file' => 'htmlpurifier' . DS . 'library' . DS . 'HTMLPurifier.auto.php'));

//namespace FortyTwoViral\Lib\Scrub;

/**
 * Data filtering
 *
 * @package app
 * @subpackage app.core
 */
class Scrub {    
    
    /**
     * Purifies, creates html and fixes broken HTML
     * @param string $value
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public static function html($value){
        $HTMLPurifier = new HTMLPurifier();

        $config = HTMLPurifier_Config::createDefault();

        //Standard scrubbing and repair
        $config->set('HTML.TidyLevel', 'heavy');
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('Core.Encoding', Configure::read('App.encoding'));        
        
        //Auto pargraphs on line break
        $config->set('AutoFormat.AutoParagraph', true);
        
        //Strips useless jiberish, typically this is cruft left over from WYSIWYG formatting
        $config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
        $config->set('AutoFormat.RemoveEmpty', true);
        $config->set('AutoFormat.RemoveSpansWithoutAttributes', true);
        
        //Autolink text based links into html tags
        $config->set('AutoFormat.Linkify', true);

        //Allow flash embedding
        $config->set('HTML.SafeObject', true);
        $config->set('HTML.SafeEmbed', true);

        return $HTMLPurifier->purify($value, $config);
    }

    /**
     * Purifies plain text and fixes broken HTML
     * @param string $value
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public static function plainText($value){
        $HTMLPurifier = new HTMLPurifier();
        
        $config = HTMLPurifier_Config::createDefault();

        //Standard scrubbing and repair
        $config->set('HTML.TidyLevel', 'heavy');
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('Core.Encoding', Configure::read('App.encoding'));   
        
        return $HTMLPurifier->purify($value, $config);
    }

    /**
     * Purifies plain text and strips all HTML and tags
     * @param string $value
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public static function plainTextNoHTML($value){
        $HTMLPurifier = new HTMLPurifier();
        
        $config = HTMLPurifier_Config::createDefault();
        
        //Standard scrubbing and repair
        $config->set('HTML.TidyLevel', 'heavy');
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('Core.Encoding', Configure::read('App.encoding'));   
        
        //Scrubs the user submitted data and fixes broken HTML
        //Trying to strip clean HTML is far more accurate
        $purify = $HTMLPurifier->purify($value, $config);
        
        //Strips all extra whitespace, images, scripts and stylesheets
        $purify = Sanitize::stripAll($purify);
        
        //Strips all remaining HTML tags
        $purify = strip_tags($purify);

        return $purify;
    }
    
    /**
     * Purifies and applies nl2br
     * @param string $value
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public static function nl2br($value){
        $HTMLPurifier = new HTMLPurifier();
        
        $config = HTMLPurifier_Config::createDefault();

        //Standard scrubbing and repair
        $config->set('HTML.TidyLevel', 'heavy');
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('Core.Encoding', Configure::read('App.encoding'));   
        
        return $HTMLPurifier->purify(nl2br($value), $config);
    }    
    
}
