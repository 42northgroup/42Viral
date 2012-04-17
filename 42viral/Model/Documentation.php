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
 * Model class representing the documentation model
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Content\Documentation
 */
class Documentation extends Content
{

    /**
     * @access public
     * @var string
     */
    public $name = 'Documentation';

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
                'Documentation.object_type' => 'docs'
            ),

            'fields' => array(
                'Documentation.url',
                'Documentation.short_cut',
                'Documentation.base_slug',
                'Documentation._before_seo',
                'Documentation.slug'
            )
        )
    );

    /**
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
     * @access public
     * @return boolean
     */
    public function beforeSave()
    {
        parent::beforeSave();
        $this->data['Documentation']['object_type'] = 'docs';
        return true;
    }

    /**
     * Inject all "finds" against the Documentation object with lead filtering criteria
     *
     * @access public
     * @param array $queryData
     * @return array
     */
    public function beforeFind($queryData)
    {
        parent::beforeFind($queryData);

        $queryData['conditions'] = !empty($queryData['conditions']) ? $queryData['conditions'] : array();
        $DocumentationFilter = array('Documentation.object_type' => 'docs');
        $queryData['conditions'] = array_merge($queryData['conditions'], $DocumentationFilter);

        return $queryData;
    }

    /**
     * Returns a given Documentation based on a given token and a with(query) array
     *
     * @access public
     * @param string $token
     * @param string|array $with (default: 'public')
     * @return array 
     */
    public function getDocumentationWith($token, $with = 'public')
    {

        $theToken = array(
            'conditions' => array('or' => array(
                    'Documentation.id' => $token,
                    'Documentation.slug' => $token,
                    'Documentation.short_cut' => $token
            ))
        );

        $finder = array_merge($this->dataSet[$with], $theToken);
        $documentation = $this->find('first', $finder);

        return $documentation;
    }

    /**
     * Returns a given Documentation based predefinded conditions
     *
     * @access public
     * @param string|array $with (default: 'public')
     * @return array 
     */
    public function fetchDocumentationsWith($with = 'public')
    {
        $finder = $this->dataSet[$with];

        $documentations = $this->find('all', $finder);
        return $documentations;
    }

    /**
     * Given a parsed documentation file content and hierarchy data structure, populate the documentation table.
     *
     * @access public
     * @param array $files
     * @return boolean
     *
     * [TODO] Make this more of a transactional process, i.e. the entire clearing of the old documentation and
     * generation of the new documentation.
     */
    public function saveDocFile($files)
    {
        $this->clearAllDocs();

        foreach($files as $tempFile) {
            $this->create();
            $this->data = array();

            $docHierarchy = '';
            if(!empty($tempFile['relative_path_structure'])) {
                foreach($tempFile['relative_path_structure'] as $tempDir) {
                    $docHierarchy .= $tempDir . '::';
                }
            }

            $this->data['Documentation']['title'] = $docHierarchy . str_replace('.md', '', $tempFile['file']);
            $this->data['Documentation']['body'] = $tempFile['html'];
            
            $this->save($this->data);
        }

        return true;
    }

    /**
     * Clear all current content of the type documentation (docs)
     *
     * @access public
     * @return boolean
     */
    public function clearAllDocs()
    {
        $oppStatus = $this->deleteAll(array(
            'Documentation.object_type' => 'docs'
        ));

        return ($oppStatus)? true: false;
    }
}