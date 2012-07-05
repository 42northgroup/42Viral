<?php
/**
 * Creates an XML sitemap
 * Copyright 2012, Jason D Snider (https://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider (https://jasonsnider.com)
 * @link https://jasonsnider.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package Seo
 */

App::uses('File', 'Lib');
App::uses('Content', 'Model');
/**
 * Creates an XML sitemap
 * @package Seo
 * @author Jason D Snider <root@jasonsnider.com>
 */
class SitemapShell extends AppShell {

    /**
     * Models used
     *
     * @var array
     */
    public $uses = array('Content');

    /**
     * Main
     *
     * @return void
     * @access public
     */
    public function main()
    {
        $contents = $this->Content->find('all', array(
            'conditions' => array(
                'Content.status'=>array(
                    'archived',
                    'published'
                )
            ),
            'contain'=>array(
                'Sitemap'
            ),
            'fields' => array(
                'Content.canonical',
                'Content.modified',
                'Sitemap.changefreq',
                'Sitemap.priority'
            )
        ));

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        foreach($contents as $content){
            $xml .= "<url>";
            $xml .= "<loc>" . htmlspecialchars($content['Content']['canonical'], ENT_QUOTES) . "</loc>";

            $xml .= "<lastmod>"
                        . htmlspecialchars(date('Y-m-d', strtotime($content['Content']['modified'])), ENT_QUOTES)
                        . "</lastmod>";

            $xml .= "<changefreq>" . htmlspecialchars($content['Sitemap']['changefreq'], ENT_QUOTES) . "</changefreq>";

            $xml .= "<priority>" . htmlspecialchars($content['Sitemap']['priority'], ENT_QUOTES) . "</priority>";

            $xml .= "</url>";
        }
        $xml .= "</urlset>";
        $file = new File(ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'sitemap.xml', true, 0644);
        $file->create();
        $file->write($xml, $mode = 'w', false);
        $file->close();

    }
}