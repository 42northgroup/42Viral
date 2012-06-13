<?php
/**
 * Mangages the address objects
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
 * @package 42viral\Address
 */

App::uses('AppModel', 'Model');
/**
 * Mangages the address objects
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Address
 */
class Address extends AppModel
{
    /**
     * The statis name of the address object
     * @access public
     * @var string
     */
    public $name = 'Address';

    /**
     * Specifies the table to be used by the address model
     * @access public
     * @var string
     */
    public $useTable = 'addresses';

    /**
     * Specifies the behaviors inoked by the address object
     * @access public
     * @var array
     */
    public $actsAs = array(
        'AuditLog.Auditable',
        'Log'
    );

    /**
     * Specifies the validation rules for the address model
     * @access public
     * @var array
     */
    public $validate = array(
        /*
        'zip' => array(
            'rule'    => array('postal', null, 'us'),
            'message' => 'Invalid Zip Code'
        )
        */
    );

    /**
     *
     * @var unknown_type
     */
    private $__countries = array(
    	'US'=>array(
    		'label' => 'United States',
    		'state_level'=>array(
    			'label'=>'States',
    			'states'=>array(
    				'AL' => array(
    					'label' => 'Alabama',
    					'county_level'=>array(
    						'label'=>'County',
    						'counties'=>array()
    					)
    				),
    				'AK' => array(
    					'label' => 'Alaska'
    				),
    				'AZ' => array(
    					'label' => 'Arizona'
    				),
    				'AR' => array(
    					'label' => 'Arkansas'
    				),
    				'CA' => array(
    					'label' => 'California'
    				),
    				'CO' => array(
    					'label' => 'Colorado'
    				),
    				'CT' => array(
    					'label' => 'Connecticut'
    				),
    				'DE' => array(
    					'label' => 'Delaware'
    				),
    				'DC' => array(
    					'label' => 'District Of Columbia'
    				),
    				'FL' => array(
    					'label' => 'Florida'
    				),
    				'GA' => array(
    					'label' => 'Georgia'
    				),
    				'HI' => array(
    					'label' => 'Hawaii'
    				),
    				'ID' => array(
    					'label' => 'Idaho'
    				),
    				'IL' => array(
    					'label' => 'Illinois'
    				),
    				'IN' => array(
    					'label' => 'Indiana'
    				),
    				'IA' => array(
    					'label' => 'Iowa'
    				),
    				'KS' => array(
    					'label' => 'Kansas'
    				),
    				'KY' => array(
    					'label' => 'Kentucky'
    				),
    				'LA' => array(
    					'label' => 'Louisiana',
    					'county_level'=>array(
    						'label'=>'Parish',
    						'counties'=>array()
    					)
    				),
    				'ME' => array(
    					'label' => 'Maine'
    				),
    				'MD' => array(
    					'label' => 'Maryland'
    				),
    				'MA' => array(
    					'label' => 'Massachusetts'
    				),
    				'MI' => array(
    					'label' => 'Michigan'
    				),
    				'MN' => array(
    					'label' => 'Minnesota'
    				),
    				'MS' => array(
    					'label' => 'Mississippi'
    				),
    				'MO' => array(
    					'label' => 'Missouri'
    				),
    				'MT' => array(
    					'label' => 'Montana'
    				),
    				'NE' => array(
    					'label' => 'Nebraska'
    				),
    				'NV' => array(
    					'label' => 'Nevada'
    				),
    				'NH' => array(
    					'label' => 'New Hampshire'
    				),
    				'NJ' => array(
    					'label' => 'New Jersey'
    				),
    				'NM' => array(
    					'label' => 'New Mexico'
    				),
    				'NY' => array(
    					'label' => 'New York'
    				),
    				'NC' => array(
    					'label' => 'North Carolina'
    				),
    				'ND' => array(
    					'label' => 'North Dakota'
    				),
    				'OH' => array(
    					'label' => 'Ohio'
    				),
    				'OK' => array(
    					'label' => 'Oklahoma'
    				),
    				'OR' => array(
    					'label' => 'Oregon'
    				),
    				'PA' => array(
    					'label' => 'Pennsylvania'
    				),
    				'RI' => array(
    					'label' => 'Rhode Island'
    				),
    				'SC' => array(
    					'label' => 'South Carolina'
    				),
    				'SD' => array(
    					'label' => 'South Dakota'
    				),
    				'TN' => array(
    					'label' => 'Tennessee'
    				),
    				'TX' => array(
    					'label' => 'Texas'
    				),
    				'UT' => array(
    					'label' => 'Utah'
    				),
    				'VT' => array(
    					'label' => 'Vermont'
    				),
    				'VA' => array(
    					'label' => 'Virginia'
    				),
    				'WA' => array(
    					'label' => 'Washington'
    				),
    				'WV' => array(
    					'label' => 'West Virginia'
    				),
    				'WI' => array(
    					'label' => 'Wisconsin'
    				),
    				'WY' => array(
    					'label' => 'Wyoming'
    				)
    			)
    		)
    	)
    );

    /**
     * Returns a key to value list of countries
     * @access public
     * @return array
     */
    public function listCountries(){
    	$countries = array();

		foreach($this->__countries as $key => $values){
			$countries[$key] = $values['label'];
		}

		return $countries;
    }

    /**
     * Returns a key to value list of countries
     * @access public
     * @return array
     */
    public function listStates($country){

    	$states = array();

    	foreach($this->__countries[$country]['state_level']['states'] as $key => $values){
    		$states[$key] = $values['label'];
    	}

    	return $states;
    }

    /**
     * Initialisation for all new instances of Address
     * @access public
     * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
     * @param string $table Name of database table to use.
     * @param string $ds DataSource connection name.
     *
     */
    public function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields = array(
            '_us_full_address' => "CONCAT(
                `{$this->alias}`.`line1`, ' ',
                `{$this->alias}`.`line2`, ' ',
                `{$this->alias}`.`city`, ', ',
                `{$this->alias}`.`state`, ' ',
                `{$this->alias}`.`zip`
            )"
        );
    }


}