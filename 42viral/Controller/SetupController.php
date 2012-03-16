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
                $this->redirect('/setup/xml_hash');
            }
                      
        }

        //Read the current xml file to prepopulate the form
        $xmlData = Xml::toArray(Xml::build($file));

        $this->set('xmlData', $xmlData);
        $this->set('title_for_layout', 'Configuration Manager (Database)');
    }

    /**
     * Map form database configuration form data to the standard CakePHP database config array
     *
     * @access private
     * @param array $formData
     * @return array
     */
    private function __createDbConfigFromForm($formData)
    {
        return array(
            'default' => array(
                'datasource' => $formData['DataSource.default.datasource'],
                'persistent' => ($formData['DataSource.default.persistent'] == 0)? false: true,
                'host' => $formData['DataSource.default.host'],
                'login' => $formData['DataSource.default.login'],
                'password' => $formData['DataSource.default.password'],
                'database' => $formData['DataSource.default.database'],
                'prefix' => $formData['DataSource.default.prefix'],
                //'encoding' => 'utf8',
            ),

            'test' => array(
                'datasource' => $formData['DataSource.test.datasource'],
                'persistent' => ($formData['DataSource.test.persistent'] == 0)? false: true,
                'host' => $formData['DataSource.test.host'],
                'login' => $formData['DataSource.test.login'],
                'password' => $formData['DataSource.test.password'],
                'database' => $formData['DataSource.test.database'],
                'prefix' => $formData['DataSource.test.prefix'],
                //'encoding' => 'utf8',
            )
        );
    }

    /**
     * Test the two db connections 'default', and 'test' using the passed db config params
     *
     * @access private
     * @param array $dbConfig
     * @return array
     */
    private function __testDbConnection($dbConfig)
    {
        $connected = array(
            'default' => true,
            'test' => true
        );

        try {
            ConnectionManager::create('temp_default', $dbConfig['default']);
        } catch(MissingConnectionException $ex) {
            $connected['default'] = false;
        }
        
        try {
            ConnectionManager::create('temp_test', $dbConfig['test']);
        } catch(MissingConnectionException $ex) {
            $connected['test'] = false;
        }
        
        return $connected;
    }

    /**
     * Action to setup database connections by capturing and testing the connection parameters
     *
     * @access public
     * @return void
     */
    public function database_config()
    {
        if(!empty($this->data)) {
            $sourceFile = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Defaults' .DS. 'Xml' . DS . 'database.xml';
            $targetFile = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Xml' . DS . 'database.xml';
            Parser::dbConfig2XML($this->data, $sourceFile, $targetFile);

            $dbConfig = $this->__createDbConfigFromForm($this->data);
            $conStatus = $this->__testDbConnection($dbConfig);

            if(($conStatus['default'] == true) && ($conStatus['test'] == true)) {
                $this->_setupLog('setup_database_config');
                $this->Session->setFlash(__("Changes Saved"), 'success');

                if($this->data['Control']['next_step'] == 1) {
                    $this->redirect('/setup/xml_hash');
                }
            } else {
                $testConn = ($conStatus['test'])? '': '[TEST]';
                $defaultConn = ($conStatus['default'])? '': '[DEFAULT]';

                $this->Session->setFlash(
                    __("Database config {$testConn} {$defaultConn} failed. Verify your connection parameters"),
                    'error'
                );
                
                $this->redirect('/setup/database_config');
            }
        } else {
            $dbDrivers = array(
                array(
                    'label' => 'MySQL',
                    'description' => 'MySQL 4 & 5',
                    'value' => 'Database/Mysql'
                ),

                array(
                    'label' => 'SQLite',
                    'description' => 'SQLite (PHP5 only)',
                    'value' => 'Database/Sqlite'
                ),

                array(
                    'label' => 'PostgreSQL',
                    'description' => 'PostgreSQL 7 and higher',
                    'value' => 'Database/Postgres'
                ),

                array(
                    'label' => 'MS SQL Server',
                    'description' => 'Microsoft SQL Server 2005 and higher',
                    'value' => 'Database/Sqlserver'
                ),

                array(
                    'label' => 'Oracle',
                    'description' => 'Oracle 8 and higher',
                    'value' => 'Database/Oracle'
                ),

                array(
                    'label' => 'None',
                    'description' => 'No database',
                    'value' => 'Database/No'
                )
            );

            $txtFields = array(
                array(
                    'label' => 'Host',
                    'description' => 'The host you connect to the database.',
                    'value' => 'localhost',
                    'test_value' => 'localhost'
                ),

                array(
                    'label' => 'Login',
                    'description' => 'Username for the production database',
                    'value' => 'root',
                    'test_value' => 'root'
                ),

                array(
                    'label' => 'Password',
                    'description' => 'Password for the production database',
                    'value' => 'password',
                    'test_value' => 'password'
                ),

                array(
                    'label' => 'Database',
                    'description' => 'Name of the production database',
                    'value' => '42viral_default',
                    'test_value' => '42viral_test'
                ),

                array(
                    'label' => 'Prefix',
                    'description' => 'Uses the given prefix for all the tables in this database',
                    'value' => '',
                    'test_value' => ''
                )
            );

            $this->set('db_drivers', $dbDrivers);
            $this->set('txt_fields', $txtFields);
            $this->set('title_for_layout', 'Configuration Manager (Database)');
        }
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
            /*
            $this->_setupLog('setup_acl');
            $this->Session->setFlash(__('ACL initialization complete.'), 'success');
            $this->redirect('/setup');
             */
        }
    }
    

    /**
     * Import the default data set from PMA XML
     * @return void
     * @access public
     */
    public function import()
    {

        $this->acl();
        
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