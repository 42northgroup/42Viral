<h1>Post Configuration Plugin</h1>
<p>Deals with non-plugin post setup configuration.</p>
<?php 

    echo $this->Form->create(null, array('class'=>'conversation', 'url'=>$this->here)); 

    echo $this->Form->inputs(array(
            'legend'=>'Core',
        
            'debug.id'=>array('value'=>'debug', 'type'=>'hidden'),
            'debug.value'=>array('label'=>'Security Level'),
        
            'Securitylevel.id'=>array('value'=>'Security.level', 'type'=>'hidden'),
            'Securitylevel.value'=>array('label'=>'Security Level'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Google Analytics',
            'GooglesetAccount.id'=>array('value'=>'Google.setAccount', 'type'=>'hidden'),
            'GooglesetAccount.value'=>array('label'=>'Tracking Code'),
        ));
    
    echo $this->Form->inputs(array(
            'legend'=>'Google Webmaster Tools',
            'GoogleSiteVerification.id'=>array('value'=>'Google.SiteVerification', 'type'=>'hidden'),
            'GoogleSiteVerification.value'=>array('label'=>'Verification ID'),
        ));
    
    echo $this->Form->inputs(array(
            'legend'=>'Google Apps',
            'GoogleAppsdomain.id'=>array('value'=>'Google.Apps.domainGoogle.SiteVerification', 'type'=>'hidden'),
            'GoogleAppsdomain.value'=>array('label'=>'Domain'),
        ));
    
    
    echo $this->Form->inputs(array(
            'legend'=>'Theme Settings',
        
            'Themeset.id'=>array('value'=>'Theme.set', 'type'=>'hidden'),
            'Themeset.value'=>array(
                'label'=>'Theme Set',
                'value'=> empty($this->data['Themeset']['value'])?'Default':$this->data['Themeset']['value']
            ),
        
            'ThemeHomePagetitle.id'=>array('value'=>'Theme.HomePage.title', 'type'=>'hidden'),
            'ThemeHomePagetitle.value'=>array('label'=>'Home Page Title'),
        
        ));
    
    
    $scheme = env('https')?'https':'http';
    
    echo $this->Form->inputs(array(
            'legend'=>'Domain Settings',
        
            'Domainscheme.id'=>array('value'=>'Domain.scheme', 'type'=>'hidden'),
            'Domainscheme.value'=>array(
                'label'=>'Domain Scheme', 
                'value'=> empty($this->data['Domainscheme']['value'])?$scheme:$this->data['Domainscheme']['value']),
        
            'Domainhost.id'=>array('value'=>'Domain.host', 'type'=>'hidden'),
            'Domainhost.value'=>array('label'=>'Domain Host', 
                'value'=>
                    empty($this->data['Domainhost']['value'])?env('SERVER_NAME'):$this->data['Domainhost']['value'])
        
        ));
    
    echo $this->Form->inputs(array(
            'legend'=>'Email Settings',
        
            'Emailfrom.id'=>array('value'=>'Email.from', 'type'=>'hidden'),
            'Emailfrom.value'=>array('label'=>'From'),
        
            'EmailreplyTo.id'=>array('value'=>'Email.replyTo', 'type'=>'hidden'),
            'EmailreplyTo.value'=>array('label'=>'Reply To'),
        ));
    
    echo $this->Form->inputs(array(
        'legend'=>'URL Shortener',

        'ShortURLscheme.id'=>array('value'=>'ShortUR.scheme', 'type'=>'hidden'),
        'ShortURLscheme.value'=>array('label'=>'Short URL Scheme'),

        'ShortURLhost.id'=>array('value'=>'ShortURL.host', 'type'=>'hidden'),
        'ShortURLhost.value'=>array('label'=>'Short URL Host'),

        'ShortURLPointerpage.id'=>array('value'=>'ShortURL.Pointer.page', 'type'=>'hidden'),
        'ShortURLPointerpage.value'=>array('label'=>'Page Pointer'),        

        'ShortURLPointerblog.id'=>array('value'=>'ShortURL.Pointer.blog', 'type'=>'hidden'),
        'ShortURLPointerblog.value'=>array('label'=>'Blog Pointer'),   

        'ShortURLPointerpost.id'=>array('value'=>'ShortURL.Pointer.post', 'type'=>'hidden'),
        'ShortURLPointerpost.value'=>array('label'=>'Post Pointer'),   
    ));
    
    echo $this->Form->submit();
    echo $this->Form->end();