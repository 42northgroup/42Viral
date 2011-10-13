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
App::uses('Config', 'Lib');
App::uses('Sec', 'Lib');
App::uses('Handy', 'Lib');

/**
 * Provides a web interface for running the intial system setup
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 */
abstract class SetupAbstractController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Setup';

    public $components = array('ControllerList');
    public $uses = array('Aco', 'AclGroup', 'Aro', 'Content', 'Group', 'Person', 'User', 'ArosAco');


    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array('*'));
    }

    /**
     * The starting pont to the first run wizard
     * @return void
     * @access public
     */
    public function index(){
        
        $this->flash('Welcome to The 42 Viral Projects Setup Wizard. Let\'s start by setting up the database.', 
                '/setup/xml_database');
        
    }
    
    /**
     * Provides a UI for setting up the database
     * @return void
     * @access public
     */
    public function xml_database(){
        $file = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Xml' . DS . 'database.xml';

        if(!empty($this->data)){
            Config::data2XML($this->data, $file);
            $this->Session->setFlash(__("Changes Saved"), 'success');
        }

        //Read the current xml file to prepopulate the form
        $xmlData = Xml::toArray(Xml::build($file));
        $this->set('xmlData', $xmlData);
    }
    
    /**
     * Provides a UI for setting up the database
     * @return void
     * @access public
     */
    public function xml_site(){
        $file = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Xml' . DS . 'site.xml';

        if(!empty($this->data)){
            Config::data2XML($this->data, $file);
            $this->Session->setFlash(__("Changes Saved"), 'success');
        }

        //Read the current xml file to prepopulate the form
        $xmlData = Xml::toArray(Xml::build($file));
        $this->set('xmlData', $xmlData);
    }
    
    /**
     * Provides a UI for setting up the database
     * @return void
     * @access public
     */
    public function xml_third_party(){
        $file = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Xml' . DS . 'third_party.xml';

        if(!empty($this->data)){
            Config::data2XML($this->data, $file);
            $this->Session->setFlash(__("Changes Saved"), 'success');
        }

        //Read the current xml file to prepopulate the form
        $xmlData = Xml::toArray(Xml::build($file));
        $this->set('xmlData', $xmlData);
    }
    
    /**
     * Provides a UI for setting up the database
     * @return void
     * @access public
     */
    public function xml_core(){ 
        $file = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Xml' . DS . 'core.xml';

        if(isset($this->params['named']['regen'])){
            $salt = Sec::makeSalt();
            $cipher = Handy::random(128, false, false, true, false);            

            $this->request->data['Security']['salt'] = $salt;
            $this->request->data['Security']['cipher'] = $cipher;
        }
        
        if(!empty($this->data)){
            Config::data2XML($this->data, $file);
            $this->Session->setFlash(__("Changes Saved"), 'success');
        }

        

        
        //Read the current xml file to prepopulate the form
        $xmlData = Xml::toArray(Xml::build($file));
        $this->set('xmlData', $xmlData);
    }
    
    /**
     * Converts XML to configuration files
     * @return void
     * @access public
     */
    public function process(){
        $path = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Xml' . DS;
        
        Config::xml2Config($path);
        
        $this->flash(__('Configuration files built. Set up privledges.'), '/setup/acl');
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
        
        $controllers = $this->ControllerList->get();

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
                    'alias' => $key . '-' . $action, 0, 0
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

        $this->Acl->Aro->save();

        $this->flash(__('ACL Set up complete. Import default data...'), '/setup/import');
    }
    

    /**
     * Import the default data set from PMA XML
     * @return void
     * @access public
     */
    public function import(){

        $path = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Data' . DS . 'Required';
        
        foreach(scandir($path) as $file){      
            
            $this->__buildPMA($path, $file);
        }
        $this->Session->setFlash('Assign permissions to the basic_user group', 'success');
        $this->flash(__('Data imported. Assign permissions...'), '/setup/give_permissions');
    }
    
    public function give_permissions($username='basic_user')
    {
        $controllers = $this->ControllerList->get();
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
            
            $this->Session->setFlash(__('Entering Manual configuration; Choose your next step!'), 'success');
            $this->flash(__('Auto setup complete; Proceed with manual configuration...'), '/setup/finish');            
        }
    }

        /**
     * Sets up the root user
     * @return void
     * @access public
     */
    public function configure_root(){
        if(!empty($this->data)){
            if($this->User->createUser($this->data['User'])){
                $this->Session->setFlash(__('Try your root login'), 'success');
                $this->flash( __('Setup complete, try your root login'), '/users/login');
            }
        }
    }
    
    /**
     * Run demo data or configure root?
     * @return void
     * @access public
     */
    public function finish(){}
        
    
    /**
     * Import the demo 
     * @return void
     * @access public
     */
    public function import_demo(){

        $path = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Data' . DS . 'Demo';
        
        foreach(scandir($path) as $file){      
            
            $this->__buildPMA($path, $file);
        }
        $this->flash(__('Demo installed, configure Root'), '/setup/configure_root');
    } 
    
    /**
     * A utility for populating DB tables from an XML file.
     * @return void
     */
    private function __buildPMA($path, $file){
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
   
}
