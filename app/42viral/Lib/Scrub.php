<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::import('Vendor', 'HTMLPurifier', 
        array('file' => 'htmlpurifier' . DS . 'library' . DS . 'HTMLPurifier.auto.php'));

//namespace FortyTwoViral\Lib\Scrub;
/**
 * A class for dealing with malicious and poorly formatted user submitted data. 
 * This is basically a stack of wrappers for HTMLPurifier, Sanitize and various other filtering methods.
 * 
 * trim
 * html
 * plainText
 * plainTextNoHtml
 *
 * @package app
 * @subpackage app.core
 * @author     Jason D Snider <jsnider@jsnider77@gmil.com>
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
        
        //Auto pargraphs on line break, this is the paragragh version of nl2br
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
     * Purifies, creates html and fixes broken HTML and removes unwanted crap
     * A less permissive version of self::html(), recommended for public facing WYSIWYG editors and content
     * @param string $value
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public static function htmlStrict($value){
        $HTMLPurifier = new HTMLPurifier();

        $config = HTMLPurifier_Config::createDefault();

        //Standard scrubbing and repair
        $config->set('HTML.TidyLevel', 'heavy');
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('Core.Encoding', Configure::read('App.encoding'));        
        
        $config->set('CSS.ForbiddenProperties', array('class', 'styles'));
        
        //Auto pargraphs on line break, this is the paragragh version of nl2br
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
        
        $config->set('HTML.AllowedAttributes', array('src', 'href', 'title', 'alt'));

        return $HTMLPurifier->purify($value, $config);
    }
    
    /**
     * Purifies plain text and fixes broken HTML
     * @param string $value
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public static function safe($value){
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
    public static function noHTML($value){
        $HTMLPurifier = new HTMLPurifier();
        
        $config = HTMLPurifier_Config::createDefault();
        
        //Standard scrubbing and repair
        $config->set('HTML.TidyLevel', 'heavy');
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('Core.Encoding', Configure::read('App.encoding'));   
        
        //Scrubs the user submitted data and fixes broken HTML. The cleaner the HTML the easier it is to strip
        $purify = $HTMLPurifier->purify($value, $config);
        
        //Strips all extra whitespace, images, scripts and stylesheets. Hopefully we are left with nothing but clean
        //HTML tags. PHP should have no issue getting rid of this.
        $purify = Sanitize::stripAll($purify);
        
        //Strips all remaining HTML tags
        $purify = strip_tags($purify);

        return $purify;
    } 
}
