# ContentFilters Plug-in

Provides an API for purifying user submitted input using native PHP and wrapper classes for HTMLPurifier &amp; Akismet.
To accomplish this the ContentFilters Plug-in offers two behaviors; Scrubable &amp; AntiSpamable and a singleton 
library class; Scrub. The scrubale behavior simply provides a model level wrapper with some auto-magic class to the 
scrub class.

## Using the behaviors

Let's say you wanted to trim all of your input, allow YouTube videos as a part of you page content and assure no other 
field will contain any HTML; you might call the scrubable behavior as follows. 
   
    public $actsAs = array(
        'ContentFilters.Scrubable'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'htmlMedia'=>array('body'),
                'noHTML'=>array('id', 'tease', 'title', 'description', 'keywords', 'canonical', 'syntax', 'short_cut'),
            )
        )
    );

Lets say you wanted to use the AntiSpamable behavior to filter your blog comments using Akismet. You implementation 
might look something like this. Akismet has specific fields it looks for when validating a comment. If your table 
doesn't follow Akismet's namming conventions you map you column names the Akismet's namming convention using the map
setting. Otherwise make sure you've entered your Akismet key using the configuration panel.

    public $actsAs = array(
        'ContentFilters.AntiSpamable'=>array(
            'map'=>array(
                'name'=>'comment_author_name',
                'email'=>'comment_author_email',
                'uri'=>'comment_author_url',
                'body'=>'comment_content',
                'front_page'=>'blog'
            )
        )
    );