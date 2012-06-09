<?php

/**
 * A helper for managing social media connections.
 * 
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
 * @package Plugin\Connect
 */
App::uses('AppHelper', 'View/Helper');

/**
 * A helper for managing social media connections.
 * 
 * @package Plugin\Connect
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class SocialMediaHelper extends AppHelper
{

    /**
     * Helpers
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html');

    /**
     * View helper to render social media links based on whether the service is activated or not
     *
     * @access public
     * @param string $media
     * @param string $label (Default = '')
     * @param string $imageUrl (Default = '')
     * @param array $options
     * @return string
     */
    public function link($media, $label='', $imageUrl='', $options=array())
    {
        if(Configure::read("{$media}.active")) {
            $icon = strtolower($media);

            return $this->Html->link(
                $this->Html->image(
                    "/img/graphics/social_media/production/{$icon}32.png") . $label,
                    $imageUrl,
                    $options
            );
        } else {
            return '';
        }
    }
    
    /**
     *
     * @access public
     * @param string $media
     * @param string $label (Default = '')
     * @param string $imageUrl (Default = '')
     * @param array $options
     * @return string
     */
    public function landingPage($profileNetworks, $networks)
    {  
        $socialNetwork = array();
        $socialNetwork[0] = array();
        foreach($networks as $key => $network){
         
            $socialNetwork = Set::extract("./SocialNetwork[network={$key}]", $profileNetworks);

            if(!empty($socialNetwork)){
                echo $this->Html->image(
                        $network['icon'],
                        array(
                            'height'=>'32px',
                            'width'=>'32px',
                            'alt'=>$network['label'],
                            'url'=>$network['profile'] . $socialNetwork[0]['SocialNetwork']['profile']
                        )
                    );   
            }
        }
    }    
}