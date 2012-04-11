<?php
    echo $this->Form->inputs(array(
            'legend'=>'Twitter Service',

            'Twitterconsumer_key.id'=>array('value'=>'Twitter.consumer_key', 'type'=>'hidden'),
            'Twitterconsumer_key.value'=>array('label'=>'Consumer Key'),

            'Twitterconsumer_secret.id'=>array('value'=>'Twitter.consumer_secret', 'type'=>'hidden'),
            'Twitterconsumer_secret.value'=>array('label'=>'Consumer Secret'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'LinkedIn Service',

            'LinkedInconsumer_key.id'=>array('value'=>'LinkedIn.consumer_key', 'type'=>'hidden'),
            'LinkedInconsumer_key.value'=>array('label'=>'Consumer Key'),

            'LinkedInconsumer_secret.id'=>array('value'=>'LinkedIn.consumer_secret', 'type'=>'hidden'),
            'LinkedInconsumer_secret.value'=>array('label'=>'Consumer Secret'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Facebook Service',

            'Facebookconsumer_key.id'=>array('value'=>'Facebook.consumer_key', 'type'=>'hidden'),
            'Facebookconsumer_key.value'=>array('label'=>'Consumer Key'),

            'Facebookconsumer_secret.id'=>array('value'=>'Facebook.consumer_secret', 'type'=>'hidden'),
            'Facebookconsumer_secret.value'=>array('label'=>'Consumer Secret'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Yelp Service',

            'Yelpconsumer_key.id'=>array('value'=>'Yelp.consumer_key', 'type'=>'hidden'),
            'Yelpconsumer_key.value'=>array('label'=>'Consumer Key'),

            'Yelpconsumer_secret.id'=>array('value'=>'Yelp.consumer_secret', 'type'=>'hidden'),
            'Yelpconsumer_secret.value'=>array('label'=>'Consumer Secret'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Google+ Service',

            'GooglePlusconsumer_key.id'=>array('value'=>'GooglePlus.consumer_key', 'type'=>'hidden'),
            'GooglePlusconsumer_key.value'=>array('label'=>'Consumer Key'),

            'GooglePlusconsumer_secret.id'=>array('value'=>'GooglePlus.consumer_secret', 'type'=>'hidden'),
            'GooglePlusconsumer_secret.value'=>array('label'=>'Consumer Secret'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Yahoo! Local',
            'YahooLocalSearchapp_id.id'=>array('value'=>'Yahoo.LocalSearch.app_id', 'type'=>'hidden'),
            'YahooLocalSearchapp_id.value'=>array('label'=>'App Id')
        ));
