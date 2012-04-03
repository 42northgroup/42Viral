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
App::uses('String', 'Utility');
App::uses('Handy', 'Lib');

App::uses('ConnectionManager', 'Model');
App::uses('MissingConnectionException', 'Error/exceptions');

App::uses('User', 'Model');

App::uses('SchemaShell', 'Console/Command');
App::uses('SetupController', 'Controller');

App::uses('ConfigurationShell', 'Plugin/PluginConfiguration/Console/Command');

/**
 * A shell to enable the 42Viral framework user to setup their application by answering the required custom
 * configuration parameters.
 *
 * @package Console
 * @subpackage Console.Command
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
     * @var type
     */
    private $__setupControllerInstance = null;


    /**
     * Stores the web server process user name for setting file/folder permissions passed in as an argument to the
     * setup shell
     *
     * @access private
     * @var type
     */
    private $__pid = null;

    /**
     * Stores the group name for setting file/folder permissions passed in as an argument to the setup shell
     *
     * @access private
     * @var type
     */
    private $__group = null;

    /**
     * Main entry point to the setup shell. This ties together all the different steps of the setup
     *
     * @access public
     * @return void
     */
    public function main()
    {
        if(isset($this->args[0])) {
            $this->__pid = $this->args[0];
        }

        if(isset($this->args[1])) {
            $this->__group = $this->args[1];
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
     * @return void
     */
    private function __interactiveSetup()
    {
        $this->nl();
        $this->out('Select an option from the list below: ');
        $this->out('0. >> Run all setup steps');
        $this->out('1. Security cipher and salt');
        $this->out('2. Database connection parameters');
        $this->out('3. Create database tables (cake schema create)');
        $this->out('4. Import core system data');
        $this->out('5. Create root user');
        $this->out('x. Exit setup');

        $userSelection = $this->in(
            'Select: ',
            array('0', '1', '2', '3', '4', '5', 'x'),
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

            case '5': // Create root user
                $this->__createRootUser();
                $this->__runStandardSteps();
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
     * @return void
     */
    private function __runStandardSteps()
    {
        $this->__runConfigurationShell();
        $this->__writePermissions();
    }

    /**
     * Wrapper to run all steps in sequence
     *
     * @access private
     * @return void
     */
    private function __runAll()
    {
        $this->__initConfig();
        $this->__securityCodes();
        $this->__databaseConfig();
        //$this->__buildConfigurationFiles();
        $this->__writePermissions();
        $this->__runSchemaShell();
        $this->__importCoreData();
        $this->__runConfigurationShell();
        $this->__createRootUser();
        $this->__writePermissions(true /* silent mode */);
        
        $this->__createSetupShellMarker();
    }

    /**
     * Create the initial configuration files by copying the default provided with the framework
     *
     * @access private
     * @return void
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

        $this->__writeSetupLog('setup_shell');
        require_once(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'system.php');
    }

    /**
     * Creates the systems salt and hash values
     *
     * @access private
     * @return void
     */
    private function __securityCodes()
    {
        $this->out('...... Running system security setup');

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

        $this->__writeSetupLog('setup_xml_hash');
        
        require_once(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'hash.php');
    }

    /**
     * Generate database configuration file from user entered data for default and test databases
     *
     * @access private
     * @return void
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

        $this->__writeSetupLog('setup_database_config');

        require_once(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'database.php');
    }

    /**
     * Build configuration files using user entered data
     *
     * @access private
     * @return void
     */
    private function __buildConfigurationFiles()
    {
        //Does nothing at this time. This is here to mirror the previous setup system.
        $this->__writeSetupLog('setup_process');
    }

    /**
     * Set the proper file/folder permissions
     *
     * @access private
     * @param boolean $silentMode
     * @return void
     */
    private function __writePermissions($silentMode=false)
    {
        if(!$silentMode) {
            $this->out('...... Setting file/folder permissions');
        }

        $fixedAppPath = ROOT . DS . APP_DIR . DS;

        //We want to try and guess a default group, I would assume the user group that cloned the repo is the owner
        //so lets get one of those files and use its owner as a default option
        $sampleFile = $fixedAppPath . 'Config' . DS . 'Defaults' . DS . 'Includes' . DS . 'database.php';
        $sampleFileGroup = posix_getgrgid(filegroup($sampleFile));

        if(is_null($this->__pid)) {
            //Ask the user to provide the the PID and user group
            $this->__pid = $this->in('Enter the name of the server process', null, 'www-data');
        }

        if(is_null($this->__group)) {
            $this->__group = $this->in(
                'Enter the name of the group that will have write access to the application, this should NOT be root!',
                null,
                $sampleFileGroup['name']
            );
        }

        //Paths that require chmod 777
        $paths777 = array(
            ROOT . DS . APP_DIR . DS .
                "Plugin/ContentFilters/Vendor/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer"
        );

        //Make all of the 777 directories and files writable
        foreach ($paths777 as $path) {

            //Test for dir, file or doesn't exist. Process the permissions accordingly
            if (is_file($path)) {
                shell_exec("chmod 777 {$path}");

                if(!$silentMode) {
                    //$this->out("777 access given to {$path}");
                }
            } elseif (is_dir($path)) {
                shell_exec("chmod 777 {$path}");

                if(!$silentMode) {
                    //$this->out("777 access given to {$path}");
                }
            } else {
                if(!$silentMode) {
                    $this->out($path . ' doesn\'t seem to exist');
                }
            }
        }


        //Paths that can run with more restrivite permissions
        $paths775 = array(
            $fixedAppPath .'tmp',
            $fixedAppPath .'tmp/cache/persistent',
            $fixedAppPath .'tmp/cache/models',
            $fixedAppPath .'tmp/cache/views',
            
            $fixedAppPath .'Plugin/HtmlFromDoc/Vendor/PostOffice',
            $fixedAppPath .'webroot/cache',
            $fixedAppPath .'webroot/img/people',
            $fixedAppPath .'webroot/files/people',
            $fixedAppPath .'webroot/files/temp',
            $fixedAppPath .'webroot/files/doc_images',
            $fixedAppPath .'Config/Xml',
            $fixedAppPath .'Config/Includes',
            $fixedAppPath .'Config/Backup',
            $fixedAppPath .'Config/Log',
            $fixedAppPath .'Plugin/PluginConfiguration/Config/application.php'
        );

        $paths = explode(PATH_SEPARATOR, ini_get('include_path'));
        $dispatcher = 'Cake' . DS . 'Console' . DS . 'ShellDispatcher.php';
        foreach ($paths as $path) {
            if(stripos($path, 'cake')) {
                if (file_exists($path . DS . $dispatcher)) {
                    array_push($paths775, $path);
                }
            }
        }

        //Make all of the 775 directories and files writable
        foreach ($paths775 as $path) {
            //Test for dir, file or doesn't exist. Process the permissions accordingly
            if (is_file($path)) {
                shell_exec("chown -fR {$this->__pid}:{$this->__group} {$path}");
                if(!$silentMode) {
                    //$this->out("{$this->__pid}:{$group} now owns  the file {$path}");
                }

                shell_exec("chmod 775 -fR {$path}");
                if(!$silentMode) {
                    //$this->out("775 access given to {$path}");
                }
            } elseif (is_dir($path)) {
                shell_exec("chown -fR {$this->__pid}:{$this->__group} {$path}");
                if(!$silentMode) {
                    //$this->out("{$this->__pid}:{$group} now owns  the directory {$path}");
                }

                shell_exec("chmod 775 -fR {$path}");
                if(!$silentMode) {
                    //$this->out("775 access given to {$path}");
                }
            } else {
                if(!$silentMode) {
                    $this->out($path . ' doesn\'t seem to exist');
                }
            }
        }
    }

    /**
     * Trigger the execution of the standard CakePHP schema shell
     *
     * @access private
     * @return void
     */
    private function __runSchemaShell()
    {
        $this->out('...... Running schema shell');

        $schemaShell = new SchemaShell();
        $schemaShell->startup();
        $schemaShell->create();
        $this->__writeSetupLog('setup_build_database');
    }

    /**
     * Import the core system data and populate the database tables after the schema has been created
     *
     * @access private
     * @return void
     */
    private function __importCoreData()
    {
        $this->out('...... Importing core data, please wait (this might take a while).');

        $this->__setupControllerInstance = new SetupController();
        $this->__setupControllerInstance->constructClasses();

        $this->__setupControllerInstance->acl();

        $path = ROOT . DS . APP_DIR. DS . 'Config' . DS . 'Data' . DS . 'Required';

        foreach(scandir($path) as $file) {
            $this->__setupControllerInstance->buildPMA($path, $file);
        }

        $this->__writeSetupLog('setup_import');
    }

    /**
     * Trigger execution of the plugin configuration shell
     *
     * @access private
     * @return void
     */
    private function __runConfigurationShell()
    {
        $this->out('...... Running configuration shell for plugin configuration');

        $configurationShell = new ConfigurationShell();
        $configurationShell->startup();
        $configurationShell->main();
        $this->__writeSetupLog('setup_initial_configuration');
    }

    /**
     * Gather the root user login credentials and create the root user
     *
     * @access private
     * @return void
     */
    private function __createRootUser()
    {
        $this->out('...... Create root user');

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

            $user['User']['password'] = $this->in('Password: ');
            $user['User']['verify_password'] = $this->in('Verify Password: ');
            
            $userModel->set($user);
            $passwordValidates = $userModel->validates(array('fieldList' => array('password')));

        } while(!$passwordValidates);

        
        if($userModel->createUser($user['User'])) {
            $this->out('+++ Successfully created "root"');
            $this->__writeSetupLog('setup_configure_root');
        } else {
            $this->out('** ERROR ** There was a problem creating root user, please try again');
            $this->__createRootUser();
        }
    }

    /**
     * Write the db configuration string to file
     *
     * @access private
     * @param string $configString
     * @return void
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
        $password = $this->in('DB password: ', null, 'password');
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
     * Creates a file in the logs folder indicating that the setup shell has been executed successfully
     *
     * @access private
     * @return void
     */
    private function __createSetupShellMarker()
    {
        $this->__writeSetupLog('setup_shell_full');
        $this->__writeSetupLog('setup');
    }

    /**
     * Write individual setup step log files (This is to keep track of which step completed)
     * TODO: Come up with a better way to keep a log of setup steps, probably in one single file in XML or JSON form
     *
     * @access private
     * @param string $logName
     * @return void
     */
    private function __writeSetupLog($logName)
    {
        $logDir = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Log' . DS;
        file_put_contents($logDir . $logName . '.txt', date('Y-m-d H:i:s'));
    }
}