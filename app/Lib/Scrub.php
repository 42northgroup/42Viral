<?php
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
 * Copyright (c) 2011,  MicroTrain Technologies  (http://www.microtrain.net)
 * licensed under MIT (http://www.opensource.org/licenses/mit-license.php)
 *
 * @copyright  Copyright 2011, MicroTrain Technologies  (http://www.microtrain.net)
 * @package app
 * @subpackage app.core
 * @author     Jason D Snider <jsnider@jsnider77@gmil.com>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
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
