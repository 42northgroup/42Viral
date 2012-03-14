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

/**
 * Helper class to help with generation of the installer steps html, considering step dependency data
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
class InstallerStepHelper extends AppHelper
{
    private $__dependencyList = array();
    private $__installerStep = array();
    private $__logDirectory = '';


    /**
     * Initialize steps data structure
     *
     * @access private
     */
    private function __init()
    {
        $this->__logDirectory = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Log' . DS;

        $this->__dependencyList = array(
            'setup_shell' => array(),

            /*
            'setup_xml_database' => array(
                'setup_shell'
            ),
            */

            'setup_database_config' => array(
                'setup_shell'
            ),

            'setup_xml_core' => array(
                'setup_shell'
            ),

            'setup_xml_hash' => array(
                'setup_shell'
            ),

            'setup_xml_third_party' => array(
                'setup_shell'
            ),

            'setup_process' => array(
                'setup_shell'
            ),

            'setup_build_database' => array(
                'setup_shell'
            ),

            'setup_import' => array(
                'setup_shell'
            ),

            'setup_configure_root' => array(
                'setup_shell'
            )
        );

        $this->__installerStep = array(
            array(
                'number' => 1,
                'key' => 'setup_shell',
                'label' => __('Run setup shell'),
                'action' => '/setup/setup_shell',
                'status' => 'setup_shell',
                'dependency' => $this->__dependencyList['setup_shell'],
                'completed' => false
            ),

            /*
            array(
                'number' => 2,
                'key' => 'setup_xml_database',
                'label' => 'Configure the database',
                'action' => '/setup/xml_database',
                'status' => 'setup_xml_database',
                'dependency' => $this->__dependencyList['setup_xml_database'],
                'completed' => false
            ),
            */
            
            array(
                'number' => 2,
                'key' => 'setup_database_config',
                'label' => 'Configure the database',
                'action' => '/setup/database_config',
                'status' => 'setup_database_config',
                'dependency' => $this->__dependencyList['setup_database_config'],
                'completed' => false
            ),
            
            array(
                'number' => 3,
                'key' => 'setup_xml_core',
                'label' => 'Configure core',
                'action' => '/setup/xml_core',
                'status' => 'setup_xml_core',
                'dependency' => $this->__dependencyList['setup_xml_core'],
                'completed' => false
            ),

            array(
                'number' => 4,
                'key' => 'setup_xml_hash',
                'label' => 'Configure hashes',
                'action' => '/setup/xml_hash',
                'status' => 'setup_xml_hash',
                'dependency' => $this->__dependencyList['setup_xml_hash'],
                'completed' => false
            ),

            array(
                'number' => 5,
                'key' => 'setup_xml_site',
                'label' => 'Configure the site',
                'action' => '/setup/xml_site',
                'status' => 'setup_xml_site',
                'dependency' => $this->__dependencyList['setup_xml_site'],
                'completed' => false
            ),
            
            array(
                'number' => 6,
                'key' => 'setup_xml_third_party',
                'label' => 'Configure third party APIs',
                'action' => '/setup/xml_third_party',
                'status' => 'setup_xml_third_party',
                'dependency' => $this->__dependencyList['setup_xml_third_party'],
                'completed' => false
            ),
            
            array(
                'number' => 7,
                'key' => 'setup_process',
                'label' => 'Build configuration files',
                'action' => '/setup/process',
                'status' => 'setup_process',
                'dependency' => $this->__dependencyList['setup_process'],
                'completed' => false,
                'confirm' => 'Are you sure?\n This will overwrite your exisiting configuration files.'
            ),

            array(
                'number' => 8,
                'key' => 'setup_build_database',
                'label' => 'Build the database',
                'action' => '/setup/build_database',
                'status' => 'setup_build_database',
                'dependency' => $this->__dependencyList['setup_build_database'],
                'completed' => false
            ),

            array(
                'number' => 9,
                'key' => 'setup_import',
                'label' => 'Import core data',
                'action' => '/setup/import',
                'status' => 'setup_import',
                'dependency' => $this->__dependencyList['setup_import'],
                'completed' => false
            ),
            
            array(
                'number' => 12,
                'key' => 'setup_configure_root',
                'label' => 'Create root',
                'action' => '/setup/configure_root',
                'status' => 'setup_configure_root',
                'dependency' => $this->__dependencyList['setup_configure_root'],
                'completed' => false
            ),

            array(
                'number' => '',
                'key' => 'import_demo',
                'label' => 'Import demo data (optional)',
                'action' => '/setup/import_demo',
                'status' => 'import_demo',
                'dependency' => array(),
                'completed' => false,
                'confirm' =>
                    'Are you sure?\n'
                        . 'This will populate the database with demo data.\n'
                        . 'This is not reccomended for a production site.'
            ),

            array(
                'number' => '',
                'key' => 'setup_backup',
                'label' => 'Back up configuration files (optional)',
                'action' => '/setup/backup',
                'status' => 'setup_backup',
                'dependency' => array(),
                'completed' => false
            )
        );

        $this->__parseStepCompletion();
    }


    /**
     * Given a particular step mark it as completed
     *
     * @access private
     * @param string $stepKey
     */
    private function __setComplete($stepKey)
    {
        foreach($this->__installerStep as &$tempStep) {
            if($tempStep['key'] == $stepKey) {
                $tempStep['completed'] = true;
            }
        }
    }

    
    /**
     * Parse the installer step completion log and initialize step complete statuses
     * 
     * @access private
     */
    private function __parseStepCompletion()
    {
        $completed = $this->__fetchLogs();

        $stepAlias = array(
            'setup_shell',
            //'setup_xml_database',
            'setup_database_config',
            'setup_xml_core',
            'setup_xml_hash',
            'setup_xml_third_party',
            'setup_process',
            'setup_build_database',
            'setup_import',
            'setup_configure_root'
        );

        foreach($stepAlias as $tempStepAlias) {
            if(in_array("{$tempStepAlias}.txt", $completed)) {
                $this->__setComplete($tempStepAlias);
            }
        }
    }


    /**
     * Fetch the log of completed steps from the log files
     *
     * @access private
     * @return array
     */
    private function __fetchLogs()
    {
        return scandir($this->__logDirectory);
    }


    /**
     * Given a step specify whether step is active or in-active based on its dependency data and dependent step
     * completed statuses
     *
     * @access private
     * @param string $stepKey
     * @return boolean
     */
    private function __checkDependency($stepKey)
    {
        $step = $this->__getStepFromKey($stepKey);

        $stepDependencies = $step['dependency'];

        $dependencyResult = true;

        if(!empty($stepDependencies)) {
            foreach($stepDependencies as $tempStepDependency) {
                $step = $this->__getStepFromKey($tempStepDependency);

                if($dependencyResult && $step['completed']) {
                    $dependencyResult = true;
                } else {
                    $dependencyResult = false;
                }

                
            }
        }

        return $dependencyResult;
    }


    /**
     * Given a step key fetch the steps full record
     *
     * @access private
     * @param string $stepKey
     * @return array
     */
    private function __getStepFromKey($stepKey)
    {
        foreach($this->__installerStep as $tempStep) {
            if($tempStep['key'] == $stepKey) {
                return $tempStep;
            }
        }
    }


    /**
     * Given a step key find out whether the step status is complete or not
     *
     * @access private
     * @param string $stepKey
     * @return boolean
     */
    private function __isComplete($stepKey)
    {
        $step = $this->__getStepFromKey($stepKey);

        if($step['completed']) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Generate the full HTML for the steps data and their dependencies
     *
     * @access public
     * @return string
     */
    public function renderSteps()
    {
        $this->__init();

        $htmlString = '';

        foreach($this->__installerStep as $tempStep) {

            if($this->__checkDependency($tempStep['key'])) {

                if(isset($tempStep['confirm']) && !empty($tempStep['confirm'])) {
                    $confirmText = ' onclick="return confirm(\'' . $tempStep['confirm'] . '\');"';
                } else {
                    $confirmText = '';
                }

                if($this->__isComplete($tempStep['key'])) {
                    $htmlString .=
                        '<a href="' . $tempStep['action'] . '" class="setup-complete" ' . $confirmText . '>' .
                            (!empty($tempStep['number'])? $tempStep['number'] . ') ': '') . $tempStep['label'] .
                        '</a>';
                } else {
                    $htmlString .=
                        '<a href="' . $tempStep['action'] . '" class="config" ' . $confirmText . '>' .
                            (!empty($tempStep['number'])? $tempStep['number'] . ') ': '') . $tempStep['label'] .
                        '</a>';
                }
                
            } else {
                $htmlString .=
                    '<div class="setup-disabled">' .
                        (!empty($tempStep['number'])? $tempStep['number'] . ') ': '') . $tempStep['label'] .
                    '</div>';
            }
        }

        return $htmlString;
    }

}