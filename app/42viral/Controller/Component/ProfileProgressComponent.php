<?php

App::uses('Profile', 'Model');
App::uses('Company', 'Model');
App::uses('Oauth', 'Model');

class ProfileProgressComponent  extends Component
{

    public function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, $settings);

        $this->Profile = new Profile();
        $this->Company = new Company();
        $this->Oauth = new Oauth();
    }

    function fetchOverallProfileProgress($userId)
    {
        $progress = array();
        $progress['user'] = $this->Profile->userProfileProgress($userId);
        $progress['company'] = $this->Company->companyProfileProgress($userId);
        $progress['connect'] = $this->Oauth->connectProgress($userId);
        $progress['_all'] = ($progress['user'] + $progress['company'] + $progress['connect']) / 3;

        return $progress;
    }
}
