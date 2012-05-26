<?php
/**
 * Model class representing the documentation model
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
 * @package 42viral\Content\Documentation
 */

App::uses('AppModel', 'Model');
App::uses('Content', 'Model');

/**
 * Model class representing the doc (documentation) model
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Content\Documentation
 */
class Doc extends Content
{

    /**
     * Model name
     * 
     * @access public
     * @var string
     */
    public $name = 'Doc';

    /**
     * Predefined data sets
     *
     * @access public
     * @var array
     */
    public $dataSet = array(
        'nothing' => array(
            'contain' => array(),
            'conditions' => array()
        ),
        'public' => array(
            'contain' => array(
                'Tag' => array()
            )
        ),

        'doc_index' => array(
            'contain' => array(),
            'conditions' => array(
                'Doc.object_type' => 'docs'
            ),

            'fields' => array(
                'Doc.url',
                'Doc.short_cut',
                'Doc.base_slug',
                'Doc.hierarchy',
                'Doc.slug'
            )
        )
    );

    /**
     * Fields to validate before saving
     * 
     * @access public
     * @var array
     */
    public $validate = array(
        'title' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => "Please enter a title",
                'last' => true
            ),
        ),
        'slug' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => "There is a problem with the slug",
                'last' => true
            )
        )
    );

    /**
     * beforeSave
     * 
     * @access public
     * @return boolean
     */
    public function beforeSave()
    {
        parent::beforeSave();
        $this->data['Doc']['object_type'] = 'docs';
        $this->data['Doc']['status'] = 'published';
        return true;
    }

    /**
     * Inject all "finds" against the doc object with lead filtering criteria
     *
     * @access public
     * @param array $queryData
     * @return array
     */
    public function beforeFind($queryData)
    {
        parent::beforeFind($queryData);

        $queryData['conditions'] = !empty($queryData['conditions']) ? $queryData['conditions'] : array();
        $docFilter = array('Doc.object_type' => 'docs');
        $queryData['conditions'] = array_merge($queryData['conditions'], $docFilter);

        return $queryData;
    }

    /**
     * Returns a given doc based on a given token and a with(query) array
     *
     * @access public
     * @param string $token
     * @param string|array $with (default: 'public')
     * @return array 
     */
    public function getDocWith($token, $with = 'public')
    {

        $theToken = array(
            'conditions' => array('or' => array(
                'Doc.id' => $token,
                'Doc.slug' => $token,
                'Doc.short_cut' => $token
            ))
        );

        $finder = array_merge($this->dataSet[$with], $theToken);
        $doc = $this->find('first', $finder);

        return $doc;
    }

    /**
     * Returns a given Doc based predefinded conditions
     *
     * @access public
     * @param string|array $with (default: 'public')
     * @return array 
     */
    public function fetchDocsWith($with = 'public')
    {
        $finder = $this->dataSet[$with];

        $docs = $this->find('all', $finder);
        return $docs;
    }

    /**
     * Given a parsed doc file content and hierarchy data structure, populate the content table.
     *
     * @access public
     * @param array $files
     * @return boolean
     *
     * [TODO] Make this more of a transactional process, i.e. the entire clearing of the old doc and
     * generation of the new doc.
     */
    public function saveDocFile($files)
    {
        $this->clearAllDocs();

        foreach($files as $tempFile) {
            $this->create();
            $this->data = array();

            $docTitle = '';
            $docHierarchy = '';
            
            if(!empty($tempFile['relative_path_structure'])) {
                foreach($tempFile['relative_path_structure'] as $tempDir) {
                    $docTitle .= Inflector::humanize($tempDir) . ' : ';
                    $docHierarchy .= $tempDir . '::';
                }
            }

            $this->data['Doc']['title'] =
                ucwords(preg_replace('/[0-9]*#/', '', $docTitle . str_replace('.md', '', $tempFile['file'])));

            $this->data['Doc']['hierarchy'] = $docHierarchy . str_replace('.md', '', $tempFile['file']);
            $this->data['Doc']['body'] = $tempFile['html'];
            
            $this->save($this->data);
        }

        return true;
    }

    /**
     * Clear all current content of the type doc (docs)
     *
     * @access public
     * @return boolean
     */
    public function clearAllDocs()
    {
        $oppStatus = $this->deleteAll(array(
            'Doc.object_type' => 'docs'
        ));

        return ($oppStatus)? true: false;
    }
}