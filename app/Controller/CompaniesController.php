<?php

App::uses('CompaniesAbstractController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * @package app
 * @subpackage app.core
 */
class CompaniesController extends CompaniesAbstractController
{

    /**
     *
     *
     * @return void
     * @author Zubin Khavarian <zkhavarian@microtrain.net>
     * @access public
     */
    public function profile()
    {
        //$this->Session->read('Auth.User.User.id');

        $yahooResults = $this->__profileDoYahoo();

        $results = array(
            'yahoo' => $yahooResults
        );

        $this->set('results', $results);
    }


    /**
     * @author Zubin Khavarian <zkhavarian@microtrain.net>
     * @access public
     * @return type
     */
    private function __profileDoYahoo()
    {
        $requestObject = array(
            'requestUrl' => 'http://local.yahooapis.com/LocalSearchService/V3/localSearch',
            'params' => array(
                'appid' => APP_ID_YAHOO_LOCAL_SEARCH,
                'output' => 'php',
                'query' => 'computer training',
                'zip' => '60606',
            //'listing_id' => '40830988'
            )
        );

        $HttpSocket = new HttpSocket();

        $yahooResponse = $HttpSocket->get(
            $requestObject['requestUrl'], $requestObject['params']
        );

        $resultsObject = unserialize($yahooResponse->body);

        return $resultsObject['ResultSet'];
    }


    /**
     *
     *
     * @author Zubin Khavarian <zkhavarian@microtrain.net>
     * @access public
     */
    public function profile_create()
    {

    }


    /**
     * @author Zubin Khavarian <zkhavarian@microtrain.net>
     * @access public
     */
    public function profile_save()
    {

        $tempData = $this->data;
        $tempData['Company']['owner_person_id'] = $this->Session->read('Auth.User.User.id');

        if($this->Company->save($tempData)) {
            $this->Session->setFlash(__('The company details were saved successfully'), 'success');
            $this->redirect('/companies/profile');
        } else {
            $this->Session->setFlash(__('There was a problem saving the company details'), 'error');
            $this->redirect('/companies/profile_create');
        }
    }

}
