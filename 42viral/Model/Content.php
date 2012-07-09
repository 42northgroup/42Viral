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
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral\Contentpar
 */

App::uses('AppModel', 'Model');
App::uses('Utility', 'Lib');
/**
 * The parent class for content objects i.e. Page, Blog, Post etc.
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Content
 */
class Content extends AppModel
{

    /**
     * The static name of the model
     * @access public
     * @var string
     */
    public $name = 'Content';

    /**
     * Specifies the table to be used by the Content model and it children
     * @access public
     * @var string
     */
    public $useTable = 'contents';

    /**
     * Defines the default set of behaivors for all content.
     * @access public
     * @var array
     */
    public $actsAs = array(

        'AuditLog.Auditable',

        'Random' => array(
            'Fields'=>array('short_cut')
        ),

        'Scrubable'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'htmlMedia'=>array('body'),
                'noHTML'=>array('id', 'title', 'description', 'keywords', 'canonical', 'syntax', 'short_cut'),
            )
        ),

        'Search.Searchable',

        'Seo',

        'Tags.Taggable'

    );
    /**
     * belongsTo ralationship
     *
     * @var array
     * @access public
     */
    public $hasOne = array(
        'Sitemap' => array(
            'className' => 'Sitemap',
            'foreignKey' => 'model_id',
            'conditions'=>array('Sitemap.model_id LIKE "Content"'),
            'dependent' => true
        )
    );
    /**
     * Defines various types of content. These are the object_type's for the Content model.
     * @access private
     * @var array
     */
    private $__listContentTypes = array(
        'page'=>array(
            'label'=>'Page',
            '_ref'=>'page',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'blog'=>array(
            'label'=>'Blog',
            '_ref'=>'blog',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'post'=>array(
            'label'=>'Post',
            '_ref'=>'post',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'docs'=>array(
            'label'=>'Docs',
            '_ref'=>'docs',
            '_inactive'=>true,
            'category'=>'',
            'tags'=>array()
        )
    );

    /**
     * Defines various types of content
     *
     * - tags
     *     public - This is used to restrict publication status options such as draft from appearing on public pages
     * such as search results.
     *
     * @access private
     * @var array
     */
    private $__listPublicationStatuses = array(
        'draft'=>array(
            'label'=>'Draft',
            '_ref'=>'draft',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'published'=>array(
            'label'=>'Published',
            '_ref'=>'published',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array('public')
        ),
        'archived'=>array(
            'label'=>'Archived',
            '_ref'=>'Archived',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array('public')
        )
    );

    /**
     * Defines various types of content
     *
     * @access private
     * @var array
     */
    private $__listSyntaxTypes = array(
        'markdownt'=>array(
            'label'=>'Markdown',
            '_ref'=>'markdown',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'html'=>array(
            'label'=>'HTML',
            '_ref'=>'html',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array('public')
        )
    );

    /**
     * Sets up the searchable behavior
     * @access public
     * @var array
     * @see https://github.com/CakeDC/search
     */
    public $filterArgs = array(
        array('name' => 'status', 'type' => 'value'),
        array('name' => 'object_type', 'type' => 'value'),
        array('name' => 'title', 'type' => 'like', 'field' => 'Content.title'),
        array('name' => 'body', 'type' => 'like', 'field' => 'Content.body'),
        array('name' => 'tags', 'type' => 'subquery', 'method' => 'findByTags', 'field' => 'Content.id'),
        array('name' => 'filter', 'type' => 'query', 'method' => 'orConditions')
    );

    /**
     * Initialisation for all new instances of Content
     * @access public
     * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
     * @param string $table Name of database table to use.
     * @param string $ds DataSource connection name.
     *
     */
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);

        $this->virtualFields = array(
            'url'=>"CONCAT('/',`{$this->alias}`.`object_type`,'/',`{$this->alias}`.`slug`)",
            'edit_url'=>"CONCAT('/admin','/',`{$this->alias}`.`object_type`,'s/','edit/',`{$this->alias}`.`id`)",
            'delete_url'=>"CONCAT('/admin','/',`{$this->alias}`.`object_type`,'s/','delete/',`{$this->alias}`.`id`)",
        );
    }

    /**
     * A subquery for finding associated tags
     * @access public
     * @param array $data
     * @return array
     * @see https://github.com/CakeDC/search
     */
    public function findByTags($data = array()) {
        $this->Tagged->Behaviors->attach('Containable', array('autoFields' => false));
        $this->Tagged->Behaviors->attach('Search.Searchable');
        $query = $this->Tagged->getQuery('all', array(
            'conditions' => array(
                    'or'=>array(
                        'Tag.keyname' => $data['tags'],
                        'Tag.name' => $data['tags']
                    )
                ),
            'fields' => array('foreign_key'),
            'contain' => array('Tag')
        ));
        return $query;
    }

    /**
     * A query for or searches
     * @access public
     * @param array $data
     * @return array
     * @see https://github.com/CakeDC/search
     */
    public function orConditions($data = array()) {
        $filter = $data['filter'];
        $conditions = array(
            'OR' => array(
                $this->alias . '.title LIKE' => '%' . $filter . '%',
                $this->alias . '.body LIKE' => '%' . $filter . '%',
            ));
        return $conditions;
    }

    /**
     * Returns a list of all object types currently in use.
     * @access public
     * @param boolean $keyByReference - Do we want numeric or referential key value pairs?
     * @return array
     */
    public function listInUseContentTypes($keyByReference = true){

        $objectTypes = array();

        $contents = $this->find('all',
                array(
                    'conditions' => array('Content.status'=>array('archived', 'published')),
                    'fields'=>array('DISTINCT Content.object_type'),
                    'contain'=>array()
                ));

        if($keyByReference){
            foreach($contents as $content){
                $objectTypes[$content['Content']['object_type']] =
                    Inflector::humanize($content['Content']['object_type']);
            }
        }else{
            foreach($contents as $content){
                $objectTypes[] = $content['Content']['object_type'];
            }
        }

        return $objectTypes;
    }

    /**
     * Returns a key to value publication statuses. This list can be flat, categorized or a partial list based on tags.
     * @access public
     * @param array $list
     * @param array $tags
     * @param string $catgory
     * @param boolean $categories
     * @return array
     */
    public function listSyntaxTypes($tags = null, $category = null, $categories = false){
        return $this->_listParser($this->__listSyntaxTypes, $tags, $category, $categories);
    }

    /**
     * Returns a key to value list of types. This list can be flat, categorized or a partial list based on tags.
     * @access public
     * @param array $list
     * @param array $tags
     * @param string $catgory
     * @param boolean $categories
     * @return array
     */
    public function listContentTypes($tags = null, $category = null, $categories = false){
        return $this->_listParser($this->__listContentTypes, $tags, $category, $categories);
    }

    /**
     * Returns a key to value publication statuses. This list can be flat, categorized or a partial list based on tags.
     * @access public
     * @param array $list
     * @param array $tags
     * @param string $catgory
     * @param boolean $categories
     * @return array
     */
    public function listPublicationStatus($tags = null, $category = null, $categories = false){
        return $this->_listParser($this->__listPublicationStatuses, $tags, $category, $categories);
    }

    /**
     * Parses text as markdown and converts it to HTML
     * @access public
     * @param string $text
     * @return string
     */
    public function markdown($text){
        return  Utility::markdown($text);
    }
}