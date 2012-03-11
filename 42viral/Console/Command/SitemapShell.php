<?php
App::uses('File', 'Lib');
class SitemapShell extends AppShell {
    
    public $uses = array('Content');
    
    /**
     * @return void
     * @access public
     */
    public function main() 
    {
        $contents = $this->Content->fetchContentWith('sitemap');
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
        foreach($contents as $content){
            $xml .= "<url>";
            $xml .= "<loc>" . htmlspecialchars($content['Content']['canonical'], ENT_QUOTES) . "</loc>";

            $xml .= "<lastmod>" 
                        . htmlspecialchars(date('Y-m-d', strtotime($content['Content']['modified'])), ENT_QUOTES) 
                        . "</lastmod>";

            $xml .= "<changefreq>" . htmlspecialchars($content['Content']['changefreq'], ENT_QUOTES) . "</changefreq>";

            $xml .= "<priority>" . htmlspecialchars($content['Content']['priority'], ENT_QUOTES) . "</priority>";

            $xml .= "</url>";
        }      
        $xml .= "</urlset>";
        $file = new File(ROOT . DS . APP_DIR . DS . 'webroot' . DS . 'sitemap.xml', true, 0644);
        $file->create();
        $file->write($xml, $mode = 'w', false);
        $file->close();       
        
    }   
}