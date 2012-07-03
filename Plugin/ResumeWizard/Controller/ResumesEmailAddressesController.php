<?php
/**
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package Plugin\ResumeWizard
 */

App::uses('ResumesAppController', 'ResumeWizard.Controller');
/**
 *
 * @author Jason D Snider <jason.snider@42northgroup.com>
 * @package Plugin\ResumeWizard
 */
class ResumesEmailAddressesController extends ResumesAppController {

    /**
     * Define this controllers model access
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Person',
        'ResumeWizard.ResumeEmailAddress'
    );

    /**
     * Helpers
     * @var array
     * @access public
     */
    public $helpers = array();

    /**
     * Components
     * @access public
     * @var array
     */
    public $components = array();

    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->auth(array('*'));
    }

    public function index() {

    }


    public function create($personId, $resumeId) {
        $person = $this->Person->find(
            'first',
            array(
                'conditions'=>array(
                    'Person.id'=>$personId
                ),
                'fields'=>array('Person.id'),
                'contain'=>array(
                    'Person'=>array(
                        'Address'=>array(
                            'fields'=>array(
                                'Address.id',
                                'Address.label',
                                'Address.full_address'
                            )
                        ),
                        'EmailAddress'=>array(
                            'fields'=>array(
                                'EmailAddress.id',
                                'EmailAddress.label',
                                'EmailAddress.email_address'
                            )
                        ),
                        'PhoneNumbers'=>array(
                            'fields'=>array(
                                'PhoneNumbers.id',
                                'PhoneNumbers.label',
                                'PhoneNumbers.phone_number'
                            )
                        ),
                    )
                )
            )
        );
    }
}