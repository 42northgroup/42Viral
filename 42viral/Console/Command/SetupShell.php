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
 * @package 42viral\Console
 */

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('String', 'Utility');
App::uses('Handy', 'Lib');

App::uses('ConnectionManager', 'Model');
App::uses('MissingConnectionException', 'Error/exceptions');

App::uses('User', 'Model');

App::uses('SchemaShell', 'Console/Command');
App::uses('SetupController', 'Controller');

App::uses('ConfigurationShell', 'Console/Command');
/**
 * A shell to enable the 42Viral framework user to setup their application by answering the required custom
 * configuration parameters.
 *
 * @package 42viral\Console
 * @subpackage 42viral\Console\Command
 * @author Jason D Snider <root@jasonsnider.com>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class SetupShell extends AppShell
{
    /**
     * Holds an instance of the setup controller after instantiating (The import is for reusing the setup controller
     * functionality. That controller will be made obsolete. )
     *
     * @access private
     * @var object
     */
    private $__setupControllerInstance = null;

    /**
     * Stores the web server process user name for setting file/folder permissions passed in as an argument to the
     * setup shell
     *
     * @access private
     * @var string
     */
    private $__pid = null;

    /**
     * Stores the group name for setting file/folder permissions passed in as an argument to the setup shell
     *
     * @access private
     * @var string
     */
    private $__group = null;

    /**
     * Holds the setup step state structure
     *
     * @access private
     * @var array
     */
    private $__setupState = null;

    /**
     * An alias to index mapping of setup steps
     *
     * @access private
     * @var array
     */
    private $__stepIndexList = array(
        '_all_steps' => 0,
        'security_codes' => 1,
        'database_config' => 2,
        'run_schema_shell' => 3,
        'import_core_data' => 4,
        'run_configuration_shell' => 5,
        'create_root_user' => 6,
        'setup_permissions' => 7,
        'clear_cache' => 8
    );

    /**
     * Overriding the standard call to Cake Shell startup method
     *
     * @access public
     * @return false
     */
    public function startup()
    {
        parent::startup();

        //Turn off cache while setup shell runs under sudo to prevent cache files with incorrect permissions
        Configure::write('Cache.disable', true);
    }

    /**
     * Main entry point to the setup shell. This ties together all the different steps of the setup
     *
     * @access public
     *
     */
    public function main()
    {
        if(isset($this->args[0])) {
            $this->__pid = $this->args[0];
        } else {
            $this->out('Usage: $0 {APACHE_PROCESS} {USER_GROUP}');
            $this->nl();
            $this->out('Enter the name your web server runs under - probably www-data');
            return;
        }

        if(isset($this->args[1])) {
            $this->__group = $this->args[1];
        } else {
            $this->out('Usage: $0 {APACHE_PROCESS} {USER_GROUP}');
            $this->nl();
            $this->out('"Enter the group that will have write acces to the server - probably your user name"');
            return;
        }

        $this->__setupState = $this->__parseSetupLog();

        //If first run is detected, make sure the init config step runs before anything to copy default settings
        if(!$this->__getSetupStateStepCompleteByStepAlias('init_config')) {
            $this->__initConfig();
        }

        $this->out('>>> Welcome to the 42Viral setup shell.');
        $this->hr();
        $this->out('42Viral setup started - ' . date('m/d/Y H:i:s'));

        $this->__interactiveSetup();

        $this->hr();
        $this->out('42Viral setup ended - ' . date('m/d/Y H:i:s'));
    }

    /**
     * Control the interactive setup UI
     *
     * @access private
     *
     */
    private function __interactiveSetup()
    {
        $this->nl();
        $this->out('Select an option from the list below: ');
        $this->out('0. >> Run all setup steps');

        $this->out('1. '. (($this->__getStepCompleteByIndex(1))? '[x]': '[ ]'). ' Security cipher and salt');
        $this->out('2. '. (($this->__getStepCompleteByIndex(2))? '[x]': '[ ]'). ' Database connection parameters');
        $this->out('3. '. (($this->__getStepCompleteByIndex(3))? '[x]': '[ ]'). ' Create database tables');
        $this->out('4. '. (($this->__getStepCompleteByIndex(4))? '[x]': '[ ]'). ' Import core system data');
        $this->out('5. '. (($this->__getStepCompleteByIndex(5))? '[x]': '[ ]'). ' Run configuration shell');
        $this->out('6. '. (($this->__getStepCompleteByIndex(6))? '[x]': '[ ]'). ' Create root user');
        $this->out('7. Setup file/folder permissions');
        $this->out('8. Clear CakePHP cache folders');
        $this->out('x. Exit setup');


        $userSelection = $this->in(
            'Select: ',
            array('0', '1', '2', '3', '4', '5', '6', '7', '8', 'x'),
            '0'
        );

        switch($userSelection) {
            case '0': // All steps
                $this->__runAll();
                break;

            case '1': // Security cipher and salt settings
                $this->__securityCodes();
                $this->__runStandardSteps();
                $this->__interactiveSetup();
                break;

            case '2': // Database connection parameter settings
                $this->__databaseConfig();
                $this->__runStandardSteps();
                $this->__interactiveSetup();
                break;

            case '3': // Create database tables
                $this->__runSchemaShell();
                $this->__runStandardSteps();
                $this->__interactiveSetup();
                break;

            case '4': // Import core system data
                $this->__importCoreData();
                $this->__runStandardSteps();
                $this->__interactiveSetup();
                break;

            case '5': // Run configuration shell
                $this->__runConfigurationShell();
                $this->__runStandardSteps();
                $this->__interactiveSetup();
                break;

            case '6': // Create root user
                $this->__createRootUser();
                $this->__runStandardSteps();
                $this->__interactiveSetup();
                break;

            case '7': // Setup file/folder permissions
                $this->__writePermissions();
                $this->__interactiveSetup();
                break;

            case '8': // Clear CakePHP cache folders
                $this->__clearCache();
                $this->__writePermissions();
                $this->__interactiveSetup();
                break;

            default: // Exit
            case 'x':
                break;
        }
    }


    /**
     * Wrapper to run standard steps run after each individual step run
     *
     * @access private
     *
     */
    private function __runStandardSteps()
    {
        $this->__writePermissions();
        $this->__finalizeSetupState();
    }

    /**
     * Wrapper to run all steps in sequence
     *
     * @access private
     *
     */
    private function __runAll()
    {
        //$this->__initConfig();
        $this->__securityCodes();
        $this->__databaseConfig();
        $this->__writePermissions();
        $this->__runSchemaShell();
        $this->__importCoreData();
        $this->__runConfigurationShell();
        $this->__createRootUser();
        $this->__writePermissions();

        $this->__updateSetupState('_all_steps');
    }

    /**
     * Create the initial configuration files by copying the default provided with the framework
     *
     * @access private
     *
     */
    private function __initConfig()
    {
        $this->out('...... Making a copy of the default configuration files');

        $dir = new Folder(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Defaults' . DS . 'Includes' . DS);
        $files = $dir->find();


        //Copy the default files to a git safe (ignored) location
        foreach ($files as $file) {
            $file = new File($dir->pwd() . DS . $file);
            $file->copy(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . $file->name);
            //$this->out($file->name . ' has been created');
            $file->close();
        }

        require_once(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'system.php');

        $this->__updateSetupState('init_config');
    }

    /**
     * Creates the systems salt and hash values
     *
     * @access private
     *
     */
    private function __securityCodes()
    {
        $this->out('...... Running system security setup');

        if($this->__getStepCompleteByIndex($this->__stepIndexList['security_codes'])) {
            $this->out(
                ' >>>> WARNING <<<< The security cipher and salt have been configured before.' .
                ' Changing these values can render your currently hashed data obsolete.'
            );

            $userInput = $this->in('Are you sure you want to continue?', array('Yes', 'No'), 'No');

            if($userInput == 'No') {
                return;
            }
        }

        $configurations = array(
            'cipher' => array(),
            'salt' => array()
        );

        do {
            $cipher = $this->in(
                'Set a security cipher (Numbers only) (ENTER to accept default):',
                null,
                Handy::random(128, false, false, true)
            );

            if(!intval($cipher)) {
                $this->out('** ERROR ** Please enter a number for security cipher');
                $cipher = false;
            }
        } while(!$cipher);


        $salt = $this->in(
            'Set a system salt (Mixed case and alphanumeric) (ENTER to accept default):',
            null,
            Handy::random(128, true, true, true)
        );


        $configurations = array(
            'cipher' => array('type' => 'string', 'value' => $cipher),
            'salt' => array('type' => 'string', 'value' => $salt)
        );

        $configureString = "<?php\n";

        foreach ($configurations as $key => $value) {

            //Type detection, this basically determines if we need to quote the value
            switch ($value['type']) {
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
            ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'hash.php',
            true,
            0755
        );

        $file->write($configureString, $mode = 'w', false);
        $file->close();

        require_once(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'hash.php');

        $this->__updateSetupState('security_codes');
    }

    /**
     * Generate database configuration file from user entered data for default and test databases
     *
     * @access private
     *
     */
    private function __databaseConfig()
    {
        $this->out('...... Running database config');

        $dbSettings = array();

        do {
            $dbSettings['default'] = $this->__inputDatabaseConfig('default');
        } while(!$this->__testDbConnection($dbSettings['default'], 'default'));

        do {
            $dbSettings['test'] = $this->__inputDatabaseConfig('test');
        } while(!$this->__testDbConnection($dbSettings['test'], 'test'));

        $configString = $this->__generateDBConfigurationString($dbSettings);
        $this->__writeDBConfigFile($configString);

        require_once(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'database.php');

        $this->__updateSetupState('database_config');
    }

    /**
     * Set the proper file/folder permissions
     *
     * @access private
     *
     */
    private function __writePermissions()
    {
        $fixedAppPath = ROOT . DS . APP_DIR . DS;

        //We want to try and guess a default group, I would assume the user group that cloned the repo is the owner
        //so lets get one of those files and use its owner as a default option
        $sampleFile = $fixedAppPath . 'Config' . DS . 'Defaults' . DS . 'Includes' . DS . 'database.php';
        $sampleFileGroup = posix_getgrgid(filegroup($sampleFile));

        //Paths that require chmod 777
        $paths777 = array(
            ROOT . DS . APP_DIR . DS .
                "42viral/Vendor/HtmlPurifier/library/HTMLPurifier/DefinitionCache/Serializer"
        );

        $paths = explode(PATH_SEPARATOR, ini_get('include_path'));
        $dispatcher = 'Cake' . DS . 'Console' . DS . 'ShellDispatcher.php';
        foreach ($paths as $path) {
            if(stripos($path, 'cake')) {
                if (file_exists($path . DS . $dispatcher)) {
                    array_push($paths777, $path);
                }
            }
        }

        //Make all of the 777 directories and files writable
        foreach ($paths777 as $path) {

            //Test for dir, file or doesn't exist. Process the permissions accordingly
            if (is_file($path)) {
                shell_exec("chown {$this->__pid}:{$this->__group} {$path}");
                shell_exec("chmod 777 {$path}");
            } elseif (is_dir($path)) {
                shell_exec("chown {$this->__pid}:{$this->__group} {$path}");
                shell_exec("chmod 777 -R {$path}");
            } else {

            }
        }


        //Paths that can run with more restrivite permissions
        $paths775 = array(
            $fixedAppPath .'tmp',
            //$fixedAppPath .'tmp/cache/persistent',
            //$fixedAppPath .'tmp/cache/models',
            //$fixedAppPath .'tmp/cache/views',

            $fixedAppPath .'webroot/cache',
            $fixedAppPath .'webroot/uploaded',
            $fixedAppPath .'Config/Xml',
            $fixedAppPath .'Config/Includes',
            $fixedAppPath .'Config/Log',
            $fixedAppPath .'Config/application.php',
            $fixedAppPath .'Config/application.default.php'
        );

        //Make all of the 775 directories and files writable
        foreach ($paths775 as $path) {
            //Test for dir, file or doesn't exist. Process the permissions accordingly
            if (is_file($path)) {
                shell_exec("chown -fR {$this->__pid}:{$this->__group} {$path}");
                shell_exec("chmod 775 -fR {$path}");
            } elseif (is_dir($path)) {
                shell_exec("chown -fR {$this->__pid}:{$this->__group} {$path}");
                shell_exec("chmod 775 -fR {$path}");
            } else {
            }
        }

        $this->__updateSetupState('permissions');
    }

    /**
     * Clear the cache folders, both CakePHP generated and the asset helper generated
     *
     * @access private
     *
     */
    private function __clearCache()
    {
        $fixedAppPath = ROOT . DS . APP_DIR . DS;

        $cakeCacheFolders = array(
            $fixedAppPath .'tmp' .DS. 'cache' .DS. 'persistent' .DS,
            $fixedAppPath .'tmp' .DS. 'cache' .DS. 'models' .DS,
            $fixedAppPath .'tmp' .DS. 'cache' .DS. 'views' .DS,
        );

        foreach ($cakeCacheFolders as $tempFolder) {
            if(is_dir($tempFolder)) {
                $files = glob($tempFolder . 'myapp_cake*', GLOB_MARK);
                array_push($files, $fixedAppPath .'tmp/cache/persistent/doc_index');

                foreach($files as $tempFile) {
                    if(is_file($tempFile)) {
                        unlink($tempFile);
                    }
                }
            }
        }

        //JS and CSS resource cache (Generated by the asset plugin)
        $resourceCacheFolders = array(
            $fixedAppPath .'webroot' .DS. 'cache' .DS. 'css' .DS,
            $fixedAppPath .'webroot' .DS. 'cache' .DS. 'js' .DS,
        );

        foreach ($resourceCacheFolders as $tempFolder) {
            if(is_dir($tempFolder)) {
                $filesJs = glob($tempFolder . '*.js', GLOB_MARK);
                $filesCss = glob($tempFolder . '*.css', GLOB_MARK);

                $files = array_merge($filesJs, $filesCss);

                foreach($files as $tempFile) {
                    if(is_file($tempFile)) {
                        unlink($tempFile);
                    }
                }
            }
        }
    }

    /**
     * Trigger the execution of the standard CakePHP schema shell
     *
     * @access private
     *
     */
    private function __runSchemaShell()
    {
        $this->out('...... Running schema shell');

        if(!$this->__getStepCompleteByIndex($this->__stepIndexList['database_config'])) {
            $this->out('*** ERROR *** You first need to run the database configuration step');
            return;
        }

        $schemaShell = new SchemaShell();
        $schemaShell->startup();
        $schemaShell->create();

        $this->__updateSetupState('run_schema_shell');
    }

    /**
     * Import the core system data and populate the database tables after the schema has been created
     *
     * @access private
     *
     */
    private function __importCoreData()
    {
        $this->out('...... Importing core data, please wait (this might take a while).');

        if(!$this->__getStepCompleteByIndex($this->__stepIndexList['database_config'])) {
            $this->out('*** ERROR *** You first need to run the database configuration step');
            return;
        }

        if(!$this->__getStepCompleteByIndex($this->__stepIndexList['run_schema_shell'])) {
            $this->out('*** ERROR *** You first need to run the schema generation step');
            return;
        }

        $this->__setupControllerInstance = new SetupController();
        $this->__setupControllerInstance->constructClasses();

        $this->__setupControllerInstance->acl();

        $path = ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Data' . DS . 'Required';

        foreach(scandir($path) as $file) {
            $this->__setupControllerInstance->buildPMA($path, $file);
        }

        $this->__updateSetupState('import_core_data');
    }

    /**
     * Trigger execution of the plugin configuration shell
     *
     * @access private
     *
     */
    private function __runConfigurationShell()
    {
        $this->out('...... Running configuration shell for plugin configuration');

        $configurationShell = new ConfigurationShell();
        $configurationShell->startup();
        $configurationShell->main();

        $this->__updateSetupState('run_configuration_shell');
    }

    /**
     * Gather the root user login credentials and create the root user
     *
     * @access private
     *
     */
    private function __createRootUser()
    {
        $this->out('...... Create root user');

        if(!$this->__getStepCompleteByIndex($this->__stepIndexList['security_codes'])) {
            $this->out('*** ERROR *** You first need to run the security cipher and salt generation step');
            return;
        }

        if(!$this->__getStepCompleteByIndex($this->__stepIndexList['database_config'])) {
            $this->out('*** ERROR *** You first need to run the database configuration step');
            return;
        }

        if(!$this->__getStepCompleteByIndex($this->__stepIndexList['run_schema_shell'])) {
            $this->out('*** ERROR *** You first need to run the schema generation step');
            return;
        }

        $userModel = new User();

        $user = array();
        $user['User']['id'] = '4e27efec-ece0-4a36-baaf-38384bb83359';
        $user['User']['employee'] = 1;

        $emailValidates = true;
        do {
            if(!$emailValidates) {
                $invalidData = $userModel->invalidFields();
                $this->out('** ERROR ** ' . $invalidData['email'][0]);
            }

            $user['User']['email'] = $this->in('Email: ');
            $userModel->set($user);
            $emailValidates = $userModel->validates(array('fieldList' => array('email')));
        } while(!$emailValidates);


        $passwordValidates = true;
        do {
            if(!$passwordValidates) {
                $invalidData = $userModel->invalidFields();
                $this->out('** ERROR ** ' . $invalidData['password'][0]);
            }

            system('stty -echo');
            $user['User']['password'] = $this->in('Password: ');
            $user['User']['verify_password'] = $this->in('Verify Password: ');
            system('stty echo');

            $userModel->set($user);
            $passwordValidates = $userModel->validates(array('fieldList' => array('password')));

        } while(!$passwordValidates);


        if($userModel->createUser($user['User'])) {
            $this->out('+++ Successfully created "root"');
        } else {
            $this->out('** ERROR ** There was a problem creating root user, please try again');
            $this->__createRootUser();
        }

        $this->__updateSetupState('create_root_user');
    }

    /**
     * Write the db configuration string to file
     *
     * @access private
     * @param string $configString
     *
     */
    private function __writeDBConfigFile($configString)
    {
        //Save config string
        $file = new File(
            ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'database.php',
            true,
            0755
        );

        $file->write($configString, $mode = 'w', false);
        $file->close();
    }

    /**
     * Generate the dabase configuration string from db settings
     *
     * @access private
     * @param array $dbSettings
     * @return string
     */
    private function __generateDBConfigurationString($dbSettings)
    {
        $default = $dbSettings['default'];
        $test = $dbSettings['test'];

        $configurationString =
            "<?php\n" .

            //Default
            "Configure::write('DataSource.default.datasource', '{$default['datasource']}');\n" .
            "Configure::write('DataSource.default.persistent', false);\n" .
            "Configure::write('DataSource.default.host', '{$default['host']}');\n" .
            "Configure::write('DataSource.default.login', '{$default['login']}');\n" .
            "Configure::write('DataSource.default.password', '{$default['password']}');\n" .
            "Configure::write('DataSource.default.database', '{$default['database']}');\n" .
            "Configure::write('DataSource.default.prefix', '{$default['prefix']}');\n" .

            //Test
            "Configure::write('DataSource.test.datasource', '{$test['datasource']}');\n" .
            "Configure::write('DataSource.test.persistent', false);\n" .
            "Configure::write('DataSource.test.host', '{$test['host']}');\n" .
            "Configure::write('DataSource.test.login', '{$test['login']}');\n" .
            "Configure::write('DataSource.test.password', '{$test['password']}');\n" .
            "Configure::write('DataSource.test.database', '{$test['database']}');\n" .
            "Configure::write('DataSource.test.prefix', '{$test['prefix']}');";

        return $configurationString;
    }

    /**
     * Capture user entered database parameters
     *
     * @access private
     * @param string $whichDB (Default = 'default')
     * @return string
     */
    private function __inputDatabaseConfig($whichDB='default')
    {
        //Reject any values other than these
        if(!in_array($whichDB, array('default', 'test'))) {
            exit();
        } else {
            switch($whichDB) {
                case 'default':
                default:
                    $defaultDBName = '42viral_default';
                    break;

                case 'test':
                    $defaultDBName = '42viral_test';
                    break;
            }
        }

        $this->hr();

        $this->out(
            "... Provide your '" .
            strtoupper($whichDB) .
            "' database configuration parameters (ENTER to select default)"
        );

        $configurations = array(
            'drivers' => array(),
            'host' => array(),
            'login' => array(),
            'password' => array(),
            'databse' => array(),
            'prefix' => array(),
        );

        $driversLabels = array(
            '[1] MySQL',
            '[2] SQLite',
            '[3] PostgreSQL',
            '[4] SQLServer',
            '[5] Oracle',
            '[6] None'
        );

        $drivers = array(
            1 => 'Database/Mysql',
            2 => 'Database/Sqlite',
            3 => 'Database/Postgres',
            4 => 'Database/Sqlserver',
            5 => 'Database/Oracle',
            6 => 'Database/No'
        );

        foreach($driversLabels as $tempLabel) {
            $this->out(__($tempLabel));
        }

        $driverOptions = array(1, 2, 3, 4, 5, 6);
        $driverSelection = $this->in('DB datasource: ', $driverOptions, '1');
        $driverSetting = $drivers[$driverSelection];

        $host = $this->in('DB host (name or ip): ', null, 'localhost');
        $login = $this->in('DB user: ', null, 'root');

        system('stty -echo');
        $password = $this->in('DB password: ', null, 'password');
        system('stty echo');
        
        $database = $this->in('DB name: ', null, $defaultDBName);
        $prefix = $this->in('DB table prefix: ', null, '');

        $configurations = array(
            'datasource' => (string) $driverSetting,
            'host' => (string) $host,
            'login' => (string) $login,
            'password' => (string) $password,
            'database' => (string) $database,
            'prefix' => (string) $prefix
        );

        return $configurations;
    }

    /**
     * Test the two db connections 'default', and 'test' using the passed db config params
     *
     * @access private
     * @param array $dbConfig
     * @param array $connectionName name of the database we are trying to connect to
     * @return array
     */
    private function __testDbConnection($dbConfig, $connectionName)
    {
        $connected = false;

        try {
            $this->out("Trying '{$connectionName}' database connection");
            ConnectionManager::create($connectionName, $dbConfig);

            $this->out("++ Successfully connected to database using entered connection parameters");
            $connected = true;
        } catch(MissingConnectionException $ex) {
            ConnectionManager::drop($connectionName);
            $this->out("** ERROR ** '" . ucfirst($connectionName) . "' database connection parameters failed");
        }

        return $connected;
    }

    /**
     * Parse the setup log file and load for reference and updates
     *
     * @access private
     * @return array
     */
    private function __parseSetupLog()
    {
        $file = 'setup_shell';

        $file = new File(ROOT . DS . APP_DIR .DS. 'Config' .DS. 'Log' .DS. $file);
        $fileContents = $file->read();

        switch(SETUP_STATE_ENCODING_METHOD) {
            case 'json':
                $setupStateData = json_decode($fileContents, true);
                break;

            case 'php_serialize':
                $setupStateData = unserialize($fileContents);
                break;
        }

        if(is_null($setupStateData) || empty($setupStateData)) {
            $setupStateData = $this->__initializeSetupState();
            $file->write(json_encode($setupStateData), $mode = 'w', false);
        }

        $file->close();

        return $setupStateData;
    }

    /**
     * Run through each setup step and if all steps are completed, mark the _all_steps as completed
     *
     * @access private
     *
     */
    private function __finalizeSetupState()
    {
        $completeFlag = true;

        foreach($this->__setupState as $tempStepKey => $tempStep) {
            if($tempStepKey !== '_all_steps') {
                if($tempStep['completed'] === false) {
                    $completeFlag = false;
                }
            }
        }

        $this->__setupState['_all_steps']['completed'] = $completeFlag;
        $this->__writeSetupState();
    }

    /**
     * If no setup state file was found, use this initializer structure to generate the content for the log file
     *
     * @access private
     *
     */
    private function __initializeSetupState()
    {
        $setupState = array(
            '_all_steps' => array(
                'ui_index' => 0,
                'completed' => false,
                'timestamp' => null
            ),

            'init_config' => array(
                'ui_index' => null,
                'completed' => false,
                'timestamp' => null
            ),

            'security_codes' => array(
                'ui_index' => 1,
                'completed' => false,
                'timestamp' => null
            ),

            'database_config' => array(
                'ui_index' => 2,
                'completed' => false,
                'timestamp' => null
            ),

            'run_schema_shell' => array(
                'ui_index' => 3,
                'completed' => false,
                'timestamp' => null
            ),

            'permissions' => array(
                'ui_index' => null,
                'completed' => false,
                'timestamp' => null
            ),

            'import_core_data' => array(
                'ui_index' => 4,
                'completed' => false,
                'timestamp' => null
            ),

            'run_configuration_shell' => array(
                'ui_index' => 5,
                'completed' => false,
                'timestamp' => null
            ),

            'create_root_user' => array(
                'ui_index' => 6,
                'completed' => false,
                'timestamp' => null
            )
        );

        return $setupState;
    }

    /**
     * Given a setup step index, determine whether the step has been completed or not
     *
     * @access private
     * @param string $uiIndex the setup step index whose status we are checking
     * @return boolean
     */
    private function __getStepCompleteByIndex($uiIndex) {
        foreach($this->__setupState as $tempState) {
            if(!is_null($tempState['ui_index']) && ($tempState['ui_index'] === $uiIndex)) {
                return $tempState['completed'];
            }
        }

        return false;
    }

    /**
     * Given a setup step alias, determine whether the step has been completed or not
     *
     * @access private
     * @param $stepAlias alias of the step which we are checking the status for
     * @return boolean
     */
    private function __getSetupStateStepCompleteByStepAlias($stepAlias) {
        if(array_key_exists($stepAlias, $this->__setupState)) {
            return $this->__setupState[$stepAlias]['completed'];
        } else {
            return false;
        }
    }

    /**
     * Update a particular setup step's status and write to setup log file
     *
     * @access private
     * @param $stepAlias alias of the step which we are updating
     *
     */
    private function __updateSetupState($stepAlias)
    {
        $this->__setupState[$stepAlias]['completed'] = true;
        $this->__setupState[$stepAlias]['timestamp'] = date('Y-m-d H:i:s');
        $this->__writeSetupState();
    }

    /**
     * Write in memory setup state structure to setup log file
     *
     * @access private
     *
     */
    private function __writeSetupState()
    {
        $file = 'setup_shell';
        $file = new File(ROOT . DS . APP_DIR .DS. 'Config' .DS. 'Log' .DS. $file);
        $file->write($this->__encodeState(), $mode = 'w', false);
        $file->close();
    }

    /**
     * Encode the setup state array structure into string for persistent file storage
     *
     * @access private
     * @return string
     */
    private function __encodeState()
    {
        switch(SETUP_STATE_ENCODING_METHOD) {
            case 'json':
                return json_encode($this->__setupState);
                break;

            case 'php_serialize':
            default:
                return serialize($this->__setupState);
                break;
        }
    }

    /**
     * Decode the setup log structure after reading it from the log file
     *
     * @access private
     * @return array
     */
    private function __decodeState()
    {
        switch(SETUP_STATE_ENCODING_METHOD) {
            case 'json':
                return json_decode($this->__setupState, true);
                break;

            case 'php_serialize':
            default:
                return unserialize($this->__setupState);
                break;
        }
    }
}