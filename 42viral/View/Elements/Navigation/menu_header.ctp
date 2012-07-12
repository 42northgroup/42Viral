<?php

    if($this->Session->check('Auth.User.id')):

    $username = $this->Session->read('Auth.User.username');
    $messageBadge = empty($unreadMessageCount)?'':" ({$unreadMessageCount})";

    $headerMenu = array(
        'Items'=>array(
            array(
                'text'=>__('Search'),
                'url'=>"#",
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Blogs'),
                'url'=>"#",
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Profiles'),
                'url'=>"#",
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Pages'),
                'url'=>"#",
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Inbox') . $messageBadge,
                'url'=>"/notifications/",
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Relationships'),
                'url'=>"#",
                'options'=>array(),
                'confirm'=>null,
                'SubNavigation'=>array(
                    array(
                        'text'=>__('Search People'),
                        'url'=>"/relationships/",
                        'options'=>array(),
                        'confirm'=>null,
                    ),
                    array(
                        'text'=>__('My Relationships'),
                        'url'=>"/relationships/my_relationships/",
                        'options'=>array(),
                        'confirm'=>null,
                    )
                )
            ),
            array(
                'text'=>__('Share'),
                'url'=>"#",
                'options'=>array(),
                'confirm'=>null,
                'SubNavigation'=>array(
                    array(
                        'text'=>__('Socialize'),
                        'url'=>"/users/social_media/",
                        'options'=>array(),
                        'confirm'=>null,
                    ),
                    array(
                        'text'=>__('Create a blog'),
                        'url'=>"/blogs/create/",
                        'options'=>array(),
                        'confirm'=>null,
                    ),
                    array(
                        'text'=>__('Create a post'),
                        'url'=>"/posts/create/",
                        'options'=>array(),
                        'confirm'=>null,
                    ),
                )
            ),
            array(
                'text'=>__('My Account'),
                'url'=>"/profiles/view/{$username}/",
                'options'=>array(),
                'confirm'=>null,
                'SubNavigation'=>array(
                    array(
                        'text'=>__('Invite a friend'),
                        'url'=>"/people/invite/",
                        'options'=>array(),
                        'confirm'=>null,
                    ),
                    array(
                        'text'=>__('Logout'),
                        'url'=>"/users/logout/",
                        'options'=>array(),
                        'confirm'=>null,
                    ),
                )
            ),
        ),
    );

else:

    $headerMenu = array(
        'Items'=>array(
            array(
                'text'=>__('Search'),
                'url'=>'/searches/',
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Blogs'),
                'url'=>'/searches/',
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Profiles'),
                'url'=>'/profiles/',
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Pages'),
                'url'=>'/pages/',
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('New Account'),
                'url'=>'/users/create/',
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Login'),
                'url'=>'/users/login/',
                'options'=>array(),
                'confirm'=>null,
            ),

        ),
    );

endif;

$menuDisplay = "<div id=\"Navigation\">"; #1

//Loop through this sections menu items
foreach($headerMenu['Items'] as $item):

    $item = $this->Menu->item($item);

    //If $item is still set, show the link
    if($item):
        $menuDisplay .= "<div class=\"navigation\">"; #2
            $menuDisplay .= $this->Html->link(
                $item['text'],
                $item['url'],
                $item['options'],
                $item['confirm']
            );

            if(isset($item['SubNavigation'])):
                $menuDisplay .= "<div class=\"subnavigation\">"; #3
                foreach($item['SubNavigation'] as $subItem):
                    $subItem = $this->Menu->item($subItem);
                    $menuDisplay .= "<div>"; #4
                    $menuDisplay .= $this->Html->link(
                        $subItem['text'],
                        $subItem['url'],
                        $subItem['options'],
                        $subItem['confirm']
                    );
                    $menuDisplay .= "</div>"; #/4
                endforeach;
                $menuDisplay .= "</div>"; #/3
            endif;

        $menuDisplay .= "</div>"; #/2
    endif;

endforeach;

$menuDisplay .= "</div>"; #/1

echo $menuDisplay;