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
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');
App::uses('Parser', 'Lib');
App::uses('Sec', 'Lib');
App::uses('Handy', 'Lib');

/**
 * Provides a web interface for running the intial system setup
 * @package app.Controller
 * @subpackage app.Controller.System
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 */
 class SetupController extends AppController {

    /**
     * @var string
     * @access public
     */
    public $name = 'Setup';

    /**
     * @var string
     * @access public
     */
    public $components = array('ControllerList');
    
    /**
     * @var string
     * @access public
     */    
    public $uses = array('Aco', 'AclGroup', 'Aro', 'Content', 'Group', 'Person', 'User', 'ArosAco');


    /**
     * @var type
     * @access public
     */
    public $helpers = array('InstallerStep');
    
    /**
     * @var string
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        
        if(file_exists($this->_logDirectory . 'setup.txt')){
            $this->auth();
        }else{
            $this->auth(array('*'));
        }
    }
    
    public function beforeRender()
    {
        parent::beforeRender();
        $this->layout = 'install';
    }
    
    /**
     * The starting pont to the first run wizard
     * @return void
     * @access public
     */
    public function index()
    {
        $this->set('title_for_layout', 'Configuration Manager');
        
        $this->set('completed', $this->_fetchLogs());
        
    }


    /**
     * 
     *
     * @access public
     */
    public function setup_shell()
    {
        $this->set('title_for_layout', 'Configuration Manager (Setup Shell)');
    }

    
    /**
     * Provides a UI for setting up the database
     * @return void
     * @access public
     */
    public function xml_database()
    {
        
        $file = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Xml' . DS . 'database.xml';

        if(!empty($this->data)){

            Parser::data2XML($this->data, $file);
            $this->Session->setFlash(__("Changes Saved"), 'success');
            
            $this->_setupLog('setup_xml_database');
            
            if($this->data['Control']['next_step'] == 1){
                $this->redirect('/setup/xml_core');
            }
                      
        }

        //Read the current xml file to prepopulate the form
        $xmlData = Xml::toArray(Xml::build($file));
        $this->set('xmlData', $xmlData);
        $this->set('title_for_layout', 'Configuration Manager (Database)');
        
    }
    
    /**
     * Database setup step
     * @return void
     * @access public
     */
    public function build_database()
    {
        $this->set('completed', $this->_fetchLogs());
    }
    
    /**
     * Provides a UI for setting up the database
     * @return void
     * @access public
     */
    public function xml_core()
    { 
        $file = ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Xml' . DS . 'core.xml';
        
        if(!empty($this->data)){
            Parser::data2XML($this->data, $file);
            $this->Session->setFlash(__("Changes Saved"), 'success');
            
            $this->_setupLog('setup_xml_core');
            
            if($this->data['Control']['next_step'] == 1){
                $this->redirect('/setup/xml_hash');
            }             
        }
        
        //Read the current xml file to prepopulate the form
        $xmlData = Xml::toArray(Xml::build($file));
        $this->set('xmlData', $xmlData);
        $this->set('title_for_layout', 'Configuration Manager (Core)');
    }
    
    /**
     * Provides a UI for setting up the database
     * @return void
     * @access public
     */
    public function xml_hash()
    { 
        $file = ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Xml' . DS . 'hash.xml';

        if(isset($this->params['named']['regen'])){
            $salt = Sec::makeSalt();
            $cipher = Handy::random(128, false, false, true, false);            

            $this->request->data['Security']['salt'] = $salt;
            $this->request->data['Security']['cipher'] = $cipher;
        }
        
        if(!empty($this->data)){
            Parser::data2XML($this->data, $file);
            $this->Session->setFlash(__("Changes Saved"), 'success');
            
            $this->_setupLog('setup_xml_hash');
            
            if($this->data['Control']['next_step'] == 1){
                 $this->redirect('/setup/build_database');
            }             
        }
        
        //Read the current xml file to prepopulate the form
        $xmlData = Xml::toArray(Xml::build($file));
        $this->set('xmlData', $xmlData);
        $this->set('title_for_layout', 'Configuration Manager (Security Hashes)');
    }
    
    /**
     * Converts XML to configuration files
     * @return void
     * @access public
     */
    public function process()
    {
        $path = ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Xml' . DS;
        Parser::xml2Config($path);
        $this->_setupLog('setup_process');
        $this->Session->setFlash(__('Configuration files built.'), 'success');
        $this->redirect('/schema.php');        
    }

    /**
     * Build the initial ACOs table, create an ARO entry for
     * user "root" and gives root all permissions
     * group "basic_user" id created as an ARO
     * @return void
     * @access public
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

        if($this->Acl->Aro->save()){
            $this->_setupLog('setup_acl');
            $this->Session->setFlash(__('ACL initialization complete.'), 'success');
            $this->redirect('/setup');
        }
    }
    

    /**
     * Import the default data set from PMA XML
     * @return void
     * @access public
     */
    public function import()
    {

        $path = ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Data' . DS . 'Required';
        
        foreach(scandir($path) as $file){      
            $this->__buildPMA($path, $file);
        }
        
        $this->_setupLog('setup_import');
        $this->_setupLog('setup_build_database');
        
        $this->Session->setFlash('Core data imported', 'success');
        $this->redirect('/setup');
    }
    
    /**
     * Allows the user to configure the permissions for the basic_user group
     * @return void
     * @access public
     */    
    public function give_permissions($username='basic_user')
    {
        $controllers = $this->ControllerList->get_all();
        $this->set('username', $username);
        
        $acos = $this->Aco->find('list', array(
            'fields' => array('Aco.id', 'Aco.alias')
        ));
        
        $this->set('controllers', $controllers);
                
        if(!empty ($this->data)){
            foreach($this->data as $controller => $action){
                if($controller != '_Token'){
                    
                    foreach ($this->data[$controller] as $function => $permission){
                        
                        foreach ($this->data[$controller][$function] as $perm => $value){
                            
                            if($value == 1){
                                $this->Acl->allow($username,$controller.'-'.$function, $perm);
                            }elseif($value == 0){
                                $this->Acl->deny($username,$controller.'-'.$function, $perm);
                            }
                            
                        }
                    }
                }
            }
            
            $this->Session->setFlash(__('Permission setting complete!'), 'success');
            $this->_setupLog('setup_give_permissions');
            $this->redirect('/setup');        
        }
        
        $this->set('title_for_layout', 'Configuration Manager (Permisions)');
        
    }

    /**
     * Sets up the root user
     * @return void
     * @access public
     */
    public function configure_root()
    {
        if(!empty($this->data)){
            if($this->User->createUser($this->data['User'])){
                
                //Lock the setup controller
                $this->_setupLog('setup');
                $this->_setupLog('setup_configure_root');
                
                //Direct the user to the root loging
                $this->Session->setFlash(__('Try your root login'), 'success');
                $this->redirect('/users/login');
            }
        }
        $this->set('title_for_layout', 'Configuration Manager (Configure Root)');
    }
        
    /**
     * Import the demo 
     * @return void
     * @access public
     */
    public function import_demo()
    {

        $path = ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Data' . DS . 'Demo';
        
        foreach(scandir($path) as $file){      
            $this->__buildPMA($path, $file);
        }
        
        $backupPath = 
            ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Backup' . DS . 'Xml' . DS . date('Y-m-d');
        
        if(!is_dir($backupPath)){
            mkdir($backupPath);
        }
        
        $customDemoFiles = ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Data' . DS . 'DemoCustomPages';
        $customFiles = ROOT . DS . APP_DIR . DS . 'View' . DS . 'Blogs' . DS . 'Custom';
        foreach(scandir($customDemoFiles) as $file){
            if(is_file($customDemoFiles . DS . $file)){
                copy($customDemoFiles . DS . $file, $customFiles . DS . $file);
            }
        }
        
        $this->Session->setFlash(__('Demo installed'), 'success');
        $this->redirect('/setup');

    } 
    
    /**
     * A utility for populating DB tables from an XML file.
     * @return void
     * @access public
     */
    private function __buildPMA($path, $file)
    {
        if(is_file($path . DS . $file)){
            $xml = Xml::build($path . DS . $file, array('return' => 'domdocument'));
            $pma = Xml::toArray($xml);

            //We need to adjust the array for 1 rom vs mulitple rows
            if(isset($pma['pma_xml_export']['database']['table']['@name'])){
                $tables = array();
                $tables[] = $pma['pma_xml_export']['database']['table'];

            }else{
                $tables = $pma['pma_xml_export']['database']['table'];
            }                 

            foreach($tables as $table){

                    $model = Inflector::classify($table['@name']);
                    $this->loadModel($model);

                    $row = array();
                    for($i=0; $i<count($table['column']); $i++): 
                        //If we have a null value, check the schema and replace that with the columns 
                        //intended default. 

                        if(isset($table['column'][$i]['@'])){
                            $value = $table['column'][$i]['@'];
                        }else{
                            $schema = $this->$model->schema($table['column'][$i]['@name']);
                            $value = $schema['default'];
                        }

                        $row[$table['column'][$i]['@name']] = $value;
                    endfor;

                if($this->$model->save($row)){
                    //Nothing to do here
                }else{
                    $details = "{$table['@name']} {$table['column'][$i]['@id']}";
                    $this->log(sprintf(__("INSERT FAILED! s%"),  $details), 'setup');
                }
            }
        }
    }
    
    /**
     * Creates a backup of the XML configuration files
     * @return void
     * @access public
     */
    public function backup()
    {
        
        $backupPath = 
            ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Backup' . DS . 'Xml' . DS . date('Y-m-d');
        
        if(!is_dir($backupPath)){
            mkdir($backupPath);
        }
        
        $path = ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Xml';
        
        foreach(scandir($path) as $file){
            if(is_file($path . DS . $file)){
                copy($path . DS . $file, $backupPath . DS . $file);
            }
        }
        
        $this->Session->setFlash(__('Backup Created.'), 'success');
        $this->redirect('/setup');
    }
   
   /**
    * Allows one to remove the step-complete files
    */ 
    public function deconfig(){
        exec("rm -fR $this->_logDirectory");
        $this->Session->setFlash(__('The system has been deconfigured.'), 'success');
        $this->redirect('/setup');
    }
}
