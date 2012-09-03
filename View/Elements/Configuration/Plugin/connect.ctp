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
 */

    echo $this->Form->inputs(array(
            'legend'=>'Twitter Service',

            'Twitteractive.id' => array('value' => 'Twitter.active', 'type' => 'hidden'),
            'Twitteractive.value' => array('label' => 'Active', 'type' => 'checkbox'),

            'Twitterconsumer_key.id'=>array('value'=>'Twitter.consumer_key', 'type'=>'hidden'),
            'Twitterconsumer_key.value'=>array('label'=>'Consumer Key'),

            'Twitterconsumer_secret.id'=>array('value'=>'Twitter.consumer_secret', 'type'=>'hidden'),
            'Twitterconsumer_secret.value'=>array('label'=>'Consumer Secret'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'LinkedIn Service',

            'LinkedInactive.id' => array('value' => 'LinkedIn.active', 'type' => 'hidden'),
            'LinkedInactive.value' => array('label' => 'Active', 'type' => 'checkbox'),

            'LinkedInconsumer_key.id'=>array('value'=>'LinkedIn.consumer_key', 'type'=>'hidden'),
            'LinkedInconsumer_key.value'=>array('label'=>'Consumer Key'),

            'LinkedInconsumer_secret.id'=>array('value'=>'LinkedIn.consumer_secret', 'type'=>'hidden'),
            'LinkedInconsumer_secret.value'=>array('label'=>'Consumer Secret'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Facebook Service',

            'Facebookactive.id' => array('value' => 'Facebook.active', 'type' => 'hidden'),
            'Facebookactive.value' => array('label' => 'Active', 'type' => 'checkbox'),

            'Facebookconsumer_key.id'=>array('value'=>'Facebook.consumer_key', 'type'=>'hidden'),
            'Facebookconsumer_key.value'=>array('label'=>'Consumer Key'),

            'Facebookconsumer_secret.id'=>array('value'=>'Facebook.consumer_secret', 'type'=>'hidden'),
            'Facebookconsumer_secret.value'=>array('label'=>'Consumer Secret'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Yelp Service',

            'Yelpactive.id' => array('value' => 'Yelp.active', 'type' => 'hidden'),
            'Yelpactive.value' => array('label' => 'Active', 'type' => 'checkbox'),

            'Yelpconsumer_key.id'=>array('value'=>'Yelp.consumer_key', 'type'=>'hidden'),
            'Yelpconsumer_key.value'=>array('label'=>'Consumer Key'),

            'Yelpconsumer_secret.id'=>array('value'=>'Yelp.consumer_secret', 'type'=>'hidden'),
            'Yelpconsumer_secret.value'=>array('label'=>'Consumer Secret'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Google+ Service',

            'GooglePlusactive.id' => array('value' => 'GooglePlus.active', 'type' => 'hidden'),
            'GooglePlusactive.value' => array('label' => 'Active', 'type' => 'checkbox'),

            'GooglePlusconsumer_key.id'=>array('value'=>'GooglePlus.consumer_key', 'type'=>'hidden'),
            'GooglePlusconsumer_key.value'=>array('label'=>'Consumer Key'),

            'GooglePlusconsumer_secret.id'=>array('value'=>'GooglePlus.consumer_secret', 'type'=>'hidden'),
            'GooglePlusconsumer_secret.value'=>array('label'=>'Consumer Secret'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Yahoo! Local',

            'YahooLocalSearchactive.id' => array('value' => 'YahooLocalSearch.active', 'type' => 'hidden'),
            'YahooLocalSearchactive.value' => array('label' => 'Active', 'type' => 'checkbox'),

            'YahooLocalSearchapp_id.id'=>array('value'=>'Yahoo.LocalSearch.app_id', 'type'=>'hidden'),
            'YahooLocalSearchapp_id.value'=>array('label'=>'App Id')
        ));
