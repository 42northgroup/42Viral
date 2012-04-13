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
App::uses('Parser', 'Lib');
App::uses('Sec', 'Lib');
App::uses('Handy', 'Lib');
/**
 * Provides a web interface for running the intial system setup
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class SetupController extends AppController
{

    /**
     * @access public
     * @var string
     */
    public $name = 'Setup';

    /**
     * @access public
     * @var string
     */
    public $components = array('ControllerList');

    /**
     * @access public
     * @var string
     */
    public $uses = array('Aco', 'AclGroup', 'Aro', 'Content', 'Group', 'Person', 'User', 'ArosAco');

    /**
     * @access public
     * @var type
     */
    public $helpers = array('InstallerStep');

    /**
     * @access public
     * @var string
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth();
    }

    /**
     * Build the initial ACOs table, create an ARO entry for
     * user "root" and gives root all permissions
     * group "basic_user" id created as an ARO
     *
     * @access public
     * @return void
     */
    public function acl()
    {

        $this->Session->delete('Auth');

        $controllers = $this->ControllerList->get_all();

        //Set root's permissions (Root gets full access)
        $this->Acl->Aco->create(array('alias' => 'root', 0, 0));
        $this->Acl->Aco->save();

        $this->Acl->Aro->create(array(
            'model' => 'User',
            'foreign_key' => '4e27efec-ece0-4a36-baaf-38384bb83359',
            'alias' => 'root', 0, 0));

        $this->Acl->Aro->save();

        foreach ($controllers as $key => $value) {
            foreach ($controllers[$key] as $action) {
                $this->Acl->Aco->create(array(
                    'parent_id' => 1,
                    'alias' => "$key-$action", 0, 0
                ));
                $this->Acl->Aco->save();

                $this->Acl->allow('root', $key . '-' . $action, '*');
            }
        }

        //Set the default group permissions (We are really just creating the ARO group at this point)
        $this->Acl->Aro->create(array(
            'model' => 'Group',
            'foreign_key' => '4e5fcfef-8e80-40bb-a72f-22424bb83359',
            'alias' => 'basic_user', 0, 0));

        if ($this->Acl->Aro->save()) {
            /*
              $this->_setupLog('setup_acl');
              $this->Session->setFlash(__('ACL initialization complete.'), 'success');
              $this->redirect('/setup');
             */
        }
    }

    /**
     * Import the default data set from PMA XML
     * 
     * @access public
     * @return void
     */
    public function import()
    {

        $this->acl();

        $path = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Data' . DS . 'Required';

        foreach (scandir($path) as $file) {
            $this->buildPMA($path, $file);
        }

        $this->_setupLog('setup_import');
        $this->_setupLog('setup_build_database');

        $this->Session->setFlash('Core data imported', 'success');
        $this->redirect('/setup');
    }

    /**
     * Import the demo
     * 
     * @access public
     * @return void
     */
    public function import_demo()
    {

        $path = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Data' . DS . 'Demo';

        foreach (scandir($path) as $file) {
            $this->buildPMA($path, $file);
        }

        $customDemoFiles = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Data' . DS . 'DemoCustomPages';
        $customFiles = ROOT . DS . APP_DIR . DS . 'View' . DS . 'Blogs' . DS . 'Custom';
        foreach (scandir($customDemoFiles) as $file) {
            if (is_file($customDemoFiles . DS . $file)) {
                copy($customDemoFiles . DS . $file, $customFiles . DS . $file);
            }
        }

        $this->Session->setFlash(__('Demo installed'), 'success');
        $this->redirect('/setup');
    }

    /**
     * A utility for populating DB tables from an XML file.
     *
     * @access public
     * @param string $path
     * @param string $file
     * @return void
     */
    public function buildPMA($path, $file)
    {
        if (is_file($path . DS . $file)) {
            $xml = Xml::build($path . DS . $file, array('return' => 'domdocument'));
            $pma = Xml::toArray($xml);

            //We need to adjust the array for 1 rom vs mulitple rows
            if (isset($pma['pma_xml_export']['database']['table']['@name'])) {
                $tables = array();
                $tables[] = $pma['pma_xml_export']['database']['table'];
            } else {
                $tables = $pma['pma_xml_export']['database']['table'];
            }

            foreach ($tables as $table) {

                $model = Inflector::classify($table['@name']);
                $this->loadModel($model);

                $row = array();
                for ($i = 0; $i < count($table['column']); $i++):
                    //If we have a null value, check the schema and replace that with the columns
                    //intended default.

                    if (isset($table['column'][$i]['@'])) {
                        $value = $table['column'][$i]['@'];
                    } else {
                        $schema = $this->$model->schema($table['column'][$i]['@name']);
                        $value = $schema['default'];
                    }

                    $row[$table['column'][$i]['@name']] = $value;
                endfor;

                if ($this->$model->save($row)) {
                    //Nothing to do here
                } else {
                    $details = "{$table['@name']} {$table['column'][$i]['@id']}";
                    $this->log(sprintf(__("INSERT FAILED! %s"), $details), 'setup');
                }
            }
        }
    }
}