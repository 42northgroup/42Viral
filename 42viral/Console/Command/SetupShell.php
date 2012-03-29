<?php
/**
 * Copyright 2012, Jason D Snider (https://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider (https://jasonsnider.com)
 * @link https://jasonsnider.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('Handy', 'Lib');
/**
 * Creates an XML sitemap
 * @package Plugin.ContentFilter
 * @subpackage Plugin.ContentFilter.Console.Command
 * @author Jason D Snider <root@jasonsnider.com>
 */
class SetupShell extends AppShell {

    
    /**
     * @return void
     * @access public
     */
    public function main() 
    { 
        
    }   

    /**
     * Create the initial configuration files 
     * 
     * @return void
     * @access public
     */
    public function config(){
        $dir = new Folder(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Defaults' . DS . 'Includes' . DS);  
        $files = $dir->find();
        
        
        //Copy the default files to a git safe (ignored) location
        foreach ($files as $file) {
            $file = new File($dir->pwd() . DS . $file);
            $file->copy(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . $file->name);
            $this->out($file->name . ' has been created');
            $file->close();
        } 
    }
    
    /**
     * Set the proper file write permissions 
     * 
     * @return void
     * @access public
     */
    public function write(){
        
        //We want to try and guess a default group, I would assume the user group that cloned the repo is the owner
        //so lets get one of those files and use its owner as a default option
        $sampleFile = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Defaults' . DS . 'Includes' . DS . 'database.php';
        $sampleFileGroup = posix_getgrgid(filegroup($sampleFile));
        
        
        //Ask the user to provide the the PID and user group
        $pid = $this->in('Enter the name of the server process', null, 'www-data');
        $group = $this->in(
                'Enter the name of the group that will have write access to the application, this should NOT be root!', 
                null, $sampleFileGroup['name']);
        
        //Paths that require chmod 777
        $paths777 = array(
            "Plugin/ContentFilters/Vendor/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer"
        );
        
        //Paths that can run with more restrivite permissions
        $paths775 = array(
            'tmp',
            'Plugin/HtmlFromDoc/Vendor/PostOffice',
            'webroot/cache',
            'webroot/img/people',
            'webroot/files/people',
            'webroot/files/temp',
            'webroot/files/doc_images',
            'Config/Xml',
            'Config/Includes',
            'Config/Backup',
            'Config/Log',
            'Plugin/PluginConfiguration/Config/application.php'
        );

        //Make all of the 777 directories and files writable
        foreach($paths777 as $path){
            
            //Test for dir, file or doesn't exist. Process the permissions accordingly
            if(is_file($path)){
                
                exec("chmod 777 {$path}");
                $this->out("777 access given to {$path}");
                
            }elseif(is_dir($path)){
                
                exec("chmod 777 {$path}");
                $this->out("777 access given to {$path}");
                
            }else{
                
                $this->out($path .' doesn\'t seem to exist');
                
            }
        }
        
        //Make all of the 775 directories and files writable
        foreach($paths775 as $path){
            
            //Test for dir, file or doesn't exist. Process the permissions accordingly
            if(is_file($path)){
                
                exec("chown -fR {$pid}:{$group} {$path}");
                $this->out("{$pid}:{$group} now owns  the file {$path}");
                
                exec("chmod 775 {$path}");
                $this->out("775 access given to {$path}");
                
            }elseif(is_dir($path)){
                
                exec("chown -fR {$pid}:{$group} {$path}");
                $this->out("{$pid}:{$group} now owns  the directory {$path}");
                
                exec("chmod 775 {$path}");
                $this->out("775 access given to {$path}");
                
            }else{
                
                $this->out($path .' doesn\'t seem to exist');
                
            }
        }
        
    }
    
    /**
     * Creates the systems salt and hash values 
     * 
     * @return void
     * @access public
     */
    public function hash(){
        
        $configurations = array('cipher'=>array(), 'salt'=>array());
        
        $cipher = $this->in(
                'Set a security cipher (Numbers only)', null, Handy::random(128, false, false, true));
        
        $salt = $this->in(
                'Set a system salt (Mixed case and alphanumeric)', null,  Handy::random(128, true, true, true));
       
        
        $configurations = array(
                'cipher'=>array('type'=>'string', 'value'=>$cipher), 
                'salt'=>array('type'=>'string', 'value'=>$salt)
            );
        
        $configureString = "<?php\n";

        foreach($configurations as $key => $value){

                //Type detection, this basically determines if we need to quote the value
                switch($value['type']){
                    case 'string':
                        $configureString .= "Configure::write('{$key}',"
                            . " '{$value['value']}');\n";
                    break;

                    default:
                        $configureString .= "Configure::write('{$key}',"
                            . " {$value['value']});\n";
                    break;    
            }
        }
        
        $file = new File(
                ROOT 
                . DS . APP_DIR . DS . 'Config' .  DS . 'Includes' . DS . 'hash.php', 
                true, 
                0755);
        
        $file->write($configureString, $mode = 'w', false);
        $file->close();   
        
    }
    
    /**
     * Creates the configuration for the production database
     * 
     * @return void
     * @access public
     */
    public function production(){
        
        $configurations = array(
            'drivers'=>array(), 
            'host'=>array(),
            'login'=>array(),
            'password'=>array(),
            'databse'=>array(),
            'prefix'=>array(),
        );
        
        $drivers = array(
            'MySQL' => 'Database/Mysql',
            'SQLite' => 'Database/Sqlite',
            'PostgreSQL' => 'Database/Postgres',
            'SQLServer' => 'Database/Sqlserver',
            'Oracle'=>'Database/Oracle',
            'None'=>'Database/No'
        );
        
        $driverLabels = array('MySQL','SQLite','PostgreSQL','SQLServer','Oracle','None');

        $driver = $this->in('Select your database driver', $driverLabels, 'MySQL');
        
        $driver = $drivers[$driver];
        $host = $this->in('Host', null, 'localhost');
        $login = $this->in('Login', null, 'login');
        $password = $this->in('Password', null, 'password');
        $database = $this->in('Database', null, '42viral_default');
        $prefix = $this->in('Prefix', null, '');
        
        $configurations = array(
            'drivers'=>array('type'=>'string','value'=>$driver), 
            'host'=>array('type'=>'string','value'=>$host),
            'login'=>array('type'=>'string','value'=>$login),
            'password'=>array('type'=>'string','value'=>$password),
            'databse'=>array('type'=>'string','value'=>$database),
            'prefix'=>array('type'=>'string','value'=>$prefix)
        );
        
        debug($configurations);
    }
    
    /**
     * Creates the configuration for the production database
     * 
     * @return void
     * @access public
     */
    public function test(){
        
    }
}