<?php
/**
 * Manages the content object from the point of view of a blog
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
 * @package 42viral\Content\Blog
 */

App::uses('AppModel', 'Model');
App::uses('Content', 'Model');

/**
 * Manages the content object from the point of view of a blog
 *
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Content\Blog
 */
class Blog extends Content
{
    /**
     * The static name of the blog class
     * @access public
     * @var string
     */
    public $name = 'Blog';

    /**
     * Predefined data sets, this provides the commonality for $with arguments
     * @access public
     * @var array
     */
    public $dataSet = array(

        'admin'=>array(
            'contain'=>array(
                'Tag'=>array()
            ),
            'conditions' => array('Blog.status'=>array('archived', 'published'))
        ),
        'admin_nothing'=>array('contain'=>array()),
        'nothing'=>array(
            'contain'=>array(),
            'conditions' => array('Blog.status'=>array('archived', 'published'))
        ),
        'public'=>array(
            'contain'=>array(
                'Tag'=>array()
            ),
            'conditions' => array('Blog.status'=>array('archived', 'published'))
        ),
        'sitemap'=>array(
            'conditions' => array(
                'Blog.status'=>array(
                    'archived',
                    'published'
                )
            ),
            'contain'=>array(
                'Sitemap'
            ),
            'fields' => array(
                'Blog.canonical',
                'Blog.modified',
                'Sitemap.changefreq',
                'Sitemap.priority'
            )
        ),
        'standard'=>array(
            'CreatedPerson'=>array(
                'Profile'=>array()
            ),
            'Post'=>array(
                'conditions'=>array('Blog.status'=>'published'),
                'order'=>array('Blog.created DESC')
            )
        ),
        'view'=>array(
            'fields'=>array(
                'Blog.body',
                'Blog.canonical',
                'Blog.created',
                'Blog.created_person_id',
                'Blog.id',
                'Blog.title',
                'Blog.syntax'
            ),
            'contain'=>array('CreatedPerson')
        )
    );

    /**
     * Defines the has many relationships for the blog model
     * @access public
     * @var array
     */
    public $hasMany = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'parent_content_id',
            'dependent' => true
        )
    );

    /**
     * Defines the belongs to relationships of the blog model
     * @access public
     * @var array
     */
    public $belongsTo = array(
        'CreatedPerson' => array(
            'className' => 'Person',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        )
    );

    /**
     * Defines the default has one data associations for all content
     * @access public
     * @var array
     */
    public $hasOne = array(
        'Sitemap' => array(
            'className' => 'Sitemap',
            'foreignKey' => 'model_id',
            'conditions' => array(
                'Sitemap.model LIKE "blog"'
            ),
            'dependent' => true
        )
    );
    /**
     * Defines a blog's model validation
     * @var array
     * @access public
     */
    public $validate = array(

        'title' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please enter a title",
                'last' => true
            ),
        ),
        'slug' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"There is a problem with the slug",
                'last' => true
            )
        )
    );

    /**
     * Controls who is allowed to post to a target blog
     * @access private
     * @var array
     */
    private $__listPostAccess = array(
        'public'=>array(
            'label'=>'Public',
            '_ref'=>'public',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'private'=>array(
            'label'=>'Private',
            '_ref'=>'private',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        )
    );

    /**
     * Initialisation for all new instances of Blog
     * @access public
     * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
     * @param string $table Name of database table to use.
     * @param string $ds DataSource connection name.
     *
     */
    public function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields = array(
            'url' => "CONCAT('/blog/',`{$this->alias}`.`slug`)"
        );
    }

   /**
    * Applies the proper object_type to the blog data set prior to a save
    * @access public
    * @return boolean
    */
    public function beforeSave()
    {
        parent::beforeSave();
        $this->data['Blog']['object_type'] = 'blog';
        return true;
    }

    /**
     * Inject all "finds" against the blog object with lead blog criteria
     * @access public
     * @param array $queryData Holds the parameters for building a CakePHP query
     * @return array
     */
    public function beforeFind($queryData) {
        parent::beforeFind($queryData);

        $queryData['conditions'] =!empty($queryData['conditions'])?$queryData['conditions']:array();
        $blogFilter = array('Blog.object_type' =>'blog');
        $queryData['conditions'] = array_merge($queryData['conditions'], $blogFilter);

        return $queryData;
    }

    /**
     * Returns a key to value post accessors. This list can be flat, categorized or a partial list based on tags.
     * @access public
     * @param array $list
     * @param array $tags
     * @param string $catgory
     * @param boolean $categories
     * @return array
     */
    public function listPostAccess($tags = null, $category = null, $categories = false){
        return $this->_listParser($this->__listPostAccess, $tags, $category, $categories);
    }

    /**
     * Returns a specified blog with a predefined data set
     * @access public
     * @param string $token The identifier of a target blog. This may be an id, short_cut or slug
     * @param array $with The predefined dataset with which the blog will be retrived (default: public)
     * @return array
     */
    function getBlogWith($token, $with = 'public'){

        $theToken = array(
            'conditions'=>array('or' => array(
                'Blog.id' => $token,
                'Blog.slug' => $token,
                'Blog.short_cut' => $token
            ))
        );

        $finder = array_merge($this->dataSet[$with], $theToken);
        $blog = $this->find('first', $finder);

        return $blog;
    }

    /**
     * Returns a set of blogs using a predetermined data set
     * @access public
     * @param array $with The predefined dataset with which the blog will be retrived (default: public)
     * @return array
     */
    public function fetchBlogsWith($with = 'public'){
        $finder = $this->dataSet[$with];
        $blog = $this->find('all', $finder);
        return $blog;
    }
}