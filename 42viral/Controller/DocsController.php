<?php
/**
 * Short description for file
 * 
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral\Controller\DocsController
 */

App::uses('AppController', 'Controller');
App::uses('Utility', 'Lib');

/**
 * Short description for class
 * 
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Controller\DocsController
 */
class DocsController extends AppController
{

    /**
     * Models this controller uses
     * 
     * @var array
     * @access public
     */
    public $uses = array('Doc');

    /**
     * Helpers
     * 
     * @var array
     * @access public
     */
    public $helpers = array(
        //'Tags.TagCloud'
    );

    /**
     * beforeFilter
     * 
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array('index', 'view'));
    }

    /**
     * Action method to view the doc index page
     * 
     * @access public
     *
     */
    public function index()
    {
        $this->redirect('/docs/home');
    }

    /**
     * Helper method to fetch the current doc content and build a hierarchical table of contents data
     * structure for the view to render
     * 
     * @access private
     * @param string $slug
     *
     */
    private function __prepareDocIndex($slug)
    {
        if(! $fromCache = $this->__tryDocIndexCache()) {
            $docItems = $this->Doc->fetchDocsWith('doc_index');
            $docNavIndex = array(
                '00#_root' => array()
            );

            foreach($docItems as $tempItem) {
                $hierarchy = preg_split('~::~', $tempItem['Doc']['hierarchy'], -1, PREG_SPLIT_NO_EMPTY);

                if(!empty($hierarchy)) {
                    if(count($hierarchy) == 1) {
                        array_push($docNavIndex['00#_root'], array(
                            'label' => $hierarchy[0],
                            'url' => $tempItem['Doc']['url']
                        ));
                    } else {
                        $arr = &$docNavIndex;

                        do {
                            $tempVal = array_shift($hierarchy);
                            if(!array_key_exists($tempVal, $arr)) {
                                $arr[$tempVal] = array();
                            }
                            $arr = &$arr[$tempVal];
                        } while(count($hierarchy) > 1);

                        array_push($arr, array(
                            'label' => $hierarchy[0],
                            'url' => $tempItem['Doc']['url']
                        ));

                        $arr = Set::sort($arr, '{n}.label', 'asc');
                    }
                }
            }

            $this->__writeDocIndexCache($docNavIndex);

        } else {
            $docNavIndex = $fromCache;
        }

        $docNavIndexHtml = $this->__generateDocIndexHtml($docNavIndex, $slug);
        $this->set('doc_nav_index_html', $docNavIndexHtml);
    }

    /**
     * Generate doc index html for document navigation
     *
     * @access private
     * @param array $docNavIndex
     * @param string $slug
     * @return string
     */
    private function __generateDocIndexHtml($docNavIndex, $slug)
    {
        $html = '';
        $html .= '<div class="doc-index">';
        $html .= $this->__buildNavPart($docNavIndex, $slug);
        $html .= '</div>';

        return $html;
    }

    /**
     * Recursively build navigation, sub-navigation html structure
     *
     * @access private
     * @param array $navPart
     * @param string $slug
     * @return string
     */
    private function __buildNavPart($navPart, $slug)
    {
        $html = '';
        $page = false;

        if(array_key_exists('label', $navPart)) {
            if(str_replace('/docs/', '', $navPart['url']) == $slug) {
                $page = true;
            }

            $html .=
                '<li class="doc-index-item ' . ($page? 'doc-index-current': '') . '">'.
                    '<a href="' . $navPart['url'] . '">' . 
                        Inflector::humanize(preg_replace('/^[0-9]*#/', '', $navPart['label'])) .
                    '</a>' .
                '</li>';
        } else {
            if(Utility::isPureAssoc($navPart)) {
                ksort($navPart);
            }

            foreach($navPart as $key => $tempNavPart) {
                if($key !== '00#_root') {
                    $html .= '<ul>';
                }

                if(is_string($key) && $key !== '00#_root') {

                    $html .=
                        '<li class="doc-index-header">' .
                            Inflector::humanize(preg_replace('/^[0-9]*#/', '', $key)) .
                        '</li>';
                }
                
                $html .= $this->__buildNavPart($tempNavPart, $slug);


                if($key !== '00#_root') {
                    $html .= '</ul>';
                }
            }
        }

        return $html;
    }

    /**
     * Write the documentation nav index to cache file for subsequent requests.
     *
     * @access private
     * @param array $docNavIndex
     *
     */
    private function __writeDocIndexCache($docNavIndex)
    {
        $file = ROOT .DS. APP_DIR .DS. 'tmp' .DS. 'cache' .DS. 'persistent' .DS. 'doc_index';

        $fileHandle = fopen($file, 'w+');
        fwrite($fileHandle, serialize($docNavIndex));
        fclose($fileHandle);
    }

    /**
     * Try fetching the doc index from cache file if it exists and is not empty
     *
     * @access private
     * @return boolean|array
     */
    private function __tryDocIndexCache()
    {
        $file = ROOT .DS. APP_DIR .DS. 'tmp' .DS. 'cache' .DS. 'persistent' .DS. 'doc_index';

        if(file_exists($file)) {
            $fileHandle = fopen($file, 'r');
            $fileContents = fread($fileHandle, filesize($file));
            fclose($fileHandle);

            $navStructure = unserialize($fileContents);

            if(!empty($navStructure)) {
                return $navStructure;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Action method to display a single doc page
     *
     * @access public
     * @param string $slug
     *
     */
    public function view($slug)
    {
        $this->__prepareDocIndex($slug);

        $doc = $this->Doc->getDocWith($slug);

        if(empty($doc)){
           $this->redirect('/', '404');
        }

        $this->set('title_for_layout', $doc['Doc']['title']);
        $this->set('canonical_for_layout', $doc['Doc']['canonical']);

        $this->set('doc', $doc);
    }
}
