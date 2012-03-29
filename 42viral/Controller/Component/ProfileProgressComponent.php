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


App::uses('Profile', 'Model');
App::uses('Oauth', 'Model');

/**
 * Component class to use for fetching profile completness information and related tasks
 *
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class ProfileProgressComponent  extends Component
{

    public function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, $settings);

        $this->Profile = new Profile();
        $this->Oauth = new Oauth();
    }

    /**
     * Fetch profile completness criteria from different models for the given user
     *
     * @author Zubin Khavarian (https://github.com/zubinkhavarian)
     * @access public
     * @param string $userId
     * @return array
     */
    public function fetchOverallProfileProgress($userId)
    {
        $progress = array();
        $progress['user'] = $this->Profile->userProfileProgress($userId);
        $progress['connect'] = $this->Oauth->connectProgress($userId);
        $progress['_all'] = ($progress['user'] + $progress['connect']) / 3;

        return $progress;
    }
}
