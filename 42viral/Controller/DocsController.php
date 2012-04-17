<?php
/**
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
 */

App::uses('AppController', 'Controller');

/**
 * @package app
 * @subpackage app.controller
 *
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class DocsController extends AppController
{

    /**
     * @var array
     * @access public
     */
    public $uses = array('Doc');

    /**
     * @var array
     * @access public
     */
    public $helpers = array(
        //'Tags.TagCloud'
    );

    /**
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
     * @return void
     */
    public function index()
    {
        $this->__prepareDocIndex();
    }

    /**
     * Helper method to fetch the current doc content and build a hierarchical table of contents data
     * structure for the view to render
     * 
     * @access private
     * @return void
     */
    private function __prepareDocIndex()
    {
        $docItems = $this->Doc->fetchDocsWith('doc_index');

        $docNavIndex = array(
            '_root' => array()
        );

        foreach($docItems as $tempItem) {
            $hierarchy = preg_split('~::~', $tempItem['Doc']['_before_seo'], -1, PREG_SPLIT_NO_EMPTY);

            if(!empty($hierarchy)) {
                if(count($hierarchy) == 1) {
                    array_push($docNavIndex['_root'], array(
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
                }
            }
        }

        $this->set('doc_nav_index', $docNavIndex);
    }


    /**
     * Action method to display a single doc page
     *
     * @access public
     * @param string $slug
     * @return void
     */
    public function view($slug)
    {
        $this->__prepareDocIndex();

        $doc = $this->Doc->getDocWith($slug);

        if(empty($doc)){
           $this->redirect('/', '404');
        }

        //[TODO] Make the documentation title more human friendly as opposed to the hierarchical coded form
        $this->set('title_for_layout', $doc['Doc']['title']);
        $this->set('canonical_for_layout', $doc['Doc']['canonical']);

        $this->set('doc', $doc);
    }
}
