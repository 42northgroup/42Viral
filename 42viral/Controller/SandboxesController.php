<?php
App::uses('AppController', 'Controller');
/**
 * Provides a sandbox location for experimental functionality and examples
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Sandbox
 */
 class SandboxesController extends AppController {

    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Sandboxes';

    /**
     * Helpers
     *
     * @var array
     * @access public
     */
    public $helpers = array();


    /**
     * Components
     *
     * @access public
     * @var array
     */
    public $components = array();

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'Content'
    );


    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();

        $this->auth(array('*'));
    }

    public function ajax_form(){


    }

    public function process_ajax_form(){
        $data = $this->data;
        $this->autoRender = false;
        Configure::write('debug', 0);
        if ($this->RequestHandler->isAjax()) {
            $this->layout = 'ajax';
        }

        if(!empty($this->data)){
            if($this->Content->save($this->data)){



            }
        }
        $responseData = array('response'=>array(
        'serverError' => false,
        'serverMsg' => 'The ticket has been updated',
        //'returnData' => $programs
        ));

        echo json_encode($responseData);

        die();
        //$this->set('json', $responseData);
    }
 }