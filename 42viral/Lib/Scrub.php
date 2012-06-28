<?php
/**
 * Copyright 2011-2012, Jason D Snider (https://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider (https://jasonsnider.com)
 * @link https://jasonsnider.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::import(
    'Vendor',
    'HTMLPurifier',
    array(
        'file' => 'HtmlPurifier'. DS . 'library' . DS . 'HTMLPurifier.auto.php'
    )
);

/**
 * A class for dealing with malicious and poorly formatted user submitted data.
 * This is basically a stack of wrappers for HTMLPurifier, Sanitize and various other filtering methods.
 * @package Plugin.ContentFilter
 * @subpackage Plugin.ContentFilter.Lib
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class Scrub
{

    /**
     * Purifies, creates html and fixes broken HTML
     * @param string $value
     * @return string
     * @access public
     */
    public static function html($value)
    {
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

        return $HTMLPurifier->purify($value, $config);
    }

    /**
     * Purifies, creates html and fixes broken HTML while allowing iFrames
     * Purity and security are both decreased, but it's good for media sites.
     * I'd only reccomend this for use by trusted users.
     * @param string $value
     * @return string
     * @access public
     */
    public static function htmlMedia($value)
    {
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
        //Remove empty conflicts with iFrames, I'd like to find a fix for this
        //$config->set('AutoFormat.RemoveEmpty', true);
        $config->set('AutoFormat.RemoveSpansWithoutAttributes', true);

        //Autolink text based links into html tags
        $config->set('AutoFormat.Linkify', true);

        //Allow iframes for YouTube and such
        $config->set('HTML.SafeIframe', true);
        $config->set('URI.SafeIframeRegexp', "%^https://(www.youtube.com/embed/|player.vimeo.com/video/)%");

        return $HTMLPurifier->purify($value, $config);
    }

    /**
     * Purifies, creates html and fixes broken HTML and removes unwanted crap
     * A less permissive version of self::html(), recommended for public facing WYSIWYG editors and content
     * @param string $value
     * @return string
     * @access public
     */
    public static function htmlStrict($value)
    {
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

        $config->set('HTML.AllowedAttributes', array('src', 'href', 'title', 'alt'));

        return $HTMLPurifier->purify($value, $config);
    }

    /**
     * Purifies plain text and fixes broken HTML
     * @param string $value
     * @return string
     * @access public
     */
    public static function safe($value)
    {
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
     * @access public
     */
    public static function noHTML($value)
    {
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

    /**
     * Given a phone number string which could consist of non-numeric characters and 1 preceeding 1, convert it to
     * a 10 digit numeric phone number
     *
     * @static
     * @access public
     * @param string $phoneNumber Input phone number string
     * @return string
     */
    public static function phoneNumber($phoneNumber)
    {
        //Strip all non-numeric data from the string
        $phoneNumber = preg_replace('/[^\d]/', '', $phoneNumber);

        //If the number has a preceeding 1, strip it.
        if(strlen($phoneNumber > 10) && strpos($phoneNumber, '1') == 0) {
            $phoneNumber = preg_replace('/^1/', '', $phoneNumber);
        }

        return $phoneNumber;
    }
}