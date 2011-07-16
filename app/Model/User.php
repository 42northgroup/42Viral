<?php
App::uses('UserAbstract', 'Model');
App::uses('Security', 'Utility'); 

App::uses('Security42', 'Lib'); 
        
/**
 * Mangages the person object from the POV of a contact
 * @package App
 * @subpackage App.core
 */
class User extends UserAbstract {}
