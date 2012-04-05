<h1>Post Configuration Plugin</h1>
<p>Deals with non-plugin post setup configuration.</p>
<p style="color:red" >
    There are certain fields that must be filled out, in order for 42Viral to function properly. Those fields are
    outlined in RED.
</p>

<div class="row">
    <div class="two-thirds column alpha">
    <?php 

        echo $this->Form->create(
                null, 
                array(
                    'class'=>'responsive', 
                    'url'=>$this->here)); 

        echo $this->Form->inputs(array(
                'legend'=>'Core',

                'debug.id'=>array('value'=>'debug', 'type'=>'hidden'),
                'debug.value'=>array(
                    'label'=>'Debug Level',
                    'style'=> 'border-color:red',
                    'between'=>'<span style="color:red" >'.(!isset($errors['debug'])?'':$errors['debug']).'</span>'
                ),

                'Securitylevel.id'=>array('value'=>'Security.level', 'type'=>'hidden'),
                'Securitylevel.value'=>array(
                    'label'=>'Security Level',
                    'style'=> 'border-color:red',
                    'between'=>'<span style="color:red" >'.(!isset($errors['Securitylevel'])?'':$errors['Securitylevel']).'</span>'
                )
            ));

        echo $this->Form->inputs(array(
                'legend'=>'Security',

                'LoginAttempts.id'=>array('value'=>'Login.attempts', 'type'=>'hidden'),
                'LoginAttempts.value'=>array(
                    'label'=>array(
                        'text'=>'Login Attempts Allowed',
                        'class'=>'help',
                        'title'=>'How many time can the user get their login credentials wrong, before they are locked'.
                                                                                                   ' out of the system.'
                    )
                ),

                'LoginLockout.id'=>array('value'=>'Login.lockout', 'type'=>'hidden'),
                'LoginLockout.value'=>array(
                    'label'=>array(
                        'text'=>'Login Lockout Duration',
                        'class'=>'help',
                        'title'=>'When a user gets locked out of the system, how long will they be locked out for.'
                    )
                ),

                'PasswordExpiration.id'=>array('value'=>'Password.expiration', 'type'=>'hidden'),
                'PasswordExpiration.value'=>array(
                    'label'=>array(
                        'text'=>'Password Expiration(days)',
                        'class'=>'help',
                        'title'=>'How many days should a password be valid for.'
                    )
                ),

                'PasswordMinLength.id'=>array('value'=>'Password.minLength', 'type'=>'hidden'),
                'PasswordMinLength.value'=>array(
                    'label'=>array(
                        'text'=>'Password Minimum Length',
                        'class'=>'help',
                        'title'=>'The mininum number of characters required for a password.'
                    )
                ),

                'PasswordAlphanumeric.id'=>array('value'=>'Password.alphanumeric', 'type'=>'hidden'),
                'PasswordAlphanumeric.value'=>array(
                    'label'=>array(
                        'text'=>'Force Alphanumeric Password',
                        'class'=>'help',
                        'title'=>'Should the password contain numbers.'
                    ),
                    'type'=>'checkbox',
                ),

                'PasswordSpecialChars.id'=>array('value'=>'Password.specialChars', 'type'=>'hidden'),
                'PasswordSpecialChars.value'=>array(
                    'label'=>array(                        
                        'text'=>'Force Special Chraracters Password',
                        'class'=>'help',
                        'title'=>'Should the password contain special characters.'
                    ),
                    'type'=>'checkbox'
                ),

                'PasswordDifference.id'=>array('value'=>'Password.difference', 'type'=>'hidden'),
                'PasswordDifference.value'=>array(
                    'label'=>array(
                        'text'=>'New Password Difference',
                        'class'=>'help',
                        'title'=>'When the user is forced to change their password, how many different passwords must '.
                                                      'they use, before they can reuse one of their previous passwords.'
                    )
                )
                
            ));
        
        echo $this->Form->inputs(array(
                'legend'=>'Beta Mode',
                
                'BetaPrivate.id'=>array('value'=>'Beta.private', 'type'=>'hidden'),
                'BetaPrivate.value'=>array(
                    'label'=>array(
                        'text'=>'New Members Can Only Join if Invited',
                        'class'=>'help',
                        'title'=>'If a person wants to register with 42Viral they need to get and invite from an '.
                                                                                                   'existing user.'
                    ),
                    'type'=>'checkbox'
                ),
             
                'BetaInvitations.id'=>array('value'=>'Beta.invitations', 'type'=>'hidden'),
                'BetaInvitations.value'=>array(
                    'label'=>array(
                        'text'=>'Number of Ivitations Per User (0 for inifinite)',
                        'class'=>'help',
                        'title'=>'How many invites is each user allowed to send.'
                    )
                )
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
                    'value'=> empty($this->data['Themeset'][''])?'Default':$this->data['Themeset'][''],
                    'style'=> 'border-color:red',
                    'between'=>'<span style="color:red" >'.(!isset($errors['Themeset'])?'':$errors['Themeset']).'</span>'
                ),

                'ThemeHomePagetitle.id'=>array('value'=>'Theme.HomePage.title', 'type'=>'hidden'),
                'ThemeHomePagetitle.value'=>array(
                    'label'=>'Home Page Title',
                    'style'=> 'border-color:red',
                    'between'=>'<span style="color:red" >'.(!isset($errors['ThemeHomePagetitle'])?'':$errors['ThemeHomePagetitle']).'</span>'
                ),

            ));


        $scheme = env('https')?'https':'http';

        echo $this->Form->inputs(array(
                'legend'=>'Domain Settings',

                'Domainscheme.id'=>array('value'=>'Domain.scheme', 'type'=>'hidden'),
                'Domainscheme.value'=>array(
                    'label'=>'Domain Scheme', 
                    'value'=> empty($this->data['Domainscheme'][''])?$scheme:$this->data['Domainscheme'][''],
                    'style'=> 'border-color:red',
                    'between'=>'<span style="color:red" >'.(!isset($errors['Domainscheme'])?'':$errors['Domainscheme']).'</span>'
                ),

                'Domainhost.id'=>array('value'=>'Domain.host', 'type'=>'hidden'),
                'Domainhost.value'=>array('label'=>'Domain Host', 
                    'value'=>
                        empty($this->data['Domainhost'][''])?env('SERVER_NAME'):$this->data['Domainhost'][''],
                    'style'=> 'border-color:red',
                    'between'=>'<span style="color:red" >'.(!isset($errors['Domainhost'])?'':$errors['Domainhost']).'</span>'
                )

            ));

        echo $this->Form->inputs(array(
                'legend'=>'Email Settings',

                'Emailfrom.id'=>array('value'=>'Email.from', 'type'=>'hidden'),
                'Emailfrom.value'=>array(
                    'label'=>array(
                        'text'=>'From',
                        'class'=>'help',
                        'title'=>'When the systems sends an email, what do you want appear in the "From" field'
                    ),
                    'style'=> 'border-color:red',
                    'between'=>'<span style="color:red" >'.(!isset($errors['Emailfrom'])?'':$errors['Emailfrom']).'</span>'
                ),

                'EmailreplyTo.id'=>array('value'=>'Email.replyTo', 'type'=>'hidden'),
                'EmailreplyTo.value'=>array(
                    'label'=>array(
                        'text'=>'Reply To',
                        'class'=>'help',
                        'title'=>'When the systems sends an email, what do you want appear in the "Reply To" field'
                    ),
                    'style'=> 'border-color:red',
                    'between'=>'<span style="color:red" >'.(!isset($errors['EmailreplyTo'])?'':$errors['EmailreplyTo']).'</span>'
                ),
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
        
        echo $this->Form->input('readyForProduction', array('type' => 'checkbox'));

        echo $this->Form->submit();
        echo $this->Form->end();
    ?>
    </div>
</div>