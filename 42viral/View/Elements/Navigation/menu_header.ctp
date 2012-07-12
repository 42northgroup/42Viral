    <?php if($this->Session->check('Auth.User.id')): ?>
        <div id="Navigation">
            <div class="navigation"><?php echo $this->Html->link(__('Search'), '/searches/'); ?></div>
            <div class="navigation"><?php echo $this->Html->link(__('Blogs'), '/blogs/'); ?></div>
            <div class="navigation"><?php echo $this->Html->link(__('Profiles'), '/profiles/'); ?></div>
            <div class="navigation"><?php echo $this->Html->link(__('Pages'), '/pages/'); ?></div>
            <div class="navigation">
                <a href="#">Relationships</a>
                <div class="subnavigation">
                    <?php echo $this->Html->link(__('Search People'),'/relationships/'); ?>
                    <?php echo $this->Html->link(__('My Relationships'),'/relationships/my_relationships/'); ?>
                </div>
            </div>
            <div class="navigation">
                <?php
                $messageBadge = empty($unreadMessageCount)?'':" ({$unreadMessageCount})";
                echo $this->Html->link(__('Inbox') . $messageBadge, '/notifications/'); ?>
            </div>
            <div class="navigation">
                <a href="#">Share</a>
                <div class="subnavigation">
                    <div><?php echo $this->Html->link(__('Socialize'), '/users/social_media/'); ?></div>
                    <div><?php echo $this->Html->link(__('Create a blog'), '/blogs/create/'); ?></div>
                    <div><?php echo $this->Html->link(__('Create a post'), '/posts/create/'); ?></div>
                </div>
            </div>

        </div>

<?php
$username = $this->Session->read('Auth.User.username');

$headerMenu = array(
    'Items'=>array(
        array(
            'text'=>__('My Account'),
            'url'=>"/profiles/view/{$username}/",
            'options'=>null,
            'confirm'=>null,
            'SubNavigation'=>array(
                array(
                    'text'=>__('Invite a friend'),
                    'url'=>"/people/invite/",
                    'options'=>null,
                    'confirm'=>null,
                ),
            array(
                'text'=>__('Logout'),
                'url'=>"/users/logout/",
                'options'=>null,
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
                'options'=>null,
                'confirm'=>null
            ),
            array(
                'text'=>__('Blogs'),
                'url'=>'/searches/',
                'options'=>null,
                'confirm'=>null
            ),
            array(
                'text'=>__('Profiles'),
                'url'=>'/profiles/',
                'options'=>null,
                'confirm'=>null
            ),
            array(
                'text'=>__('Pages'),
                'url'=>'/pages/',
                'options'=>null,
                'confirm'=>null
            ),
            array(
                'text'=>__('New Account'),
                'url'=>'/users/create/',
                'options'=>null,
                'confirm'=>null
            ),
            array(
                'text'=>__('Login'),
                'url'=>'/users/login/',
                'options'=>null,
                'confirm'=>null,
            ),

        ),
    );
endif;

$menuDisplay = "<div id=\"Navigation\">";

//Loop through this sections menu items
foreach($headerMenu['Items'] as $item):

    $item = $this->Menu->item($item);

    //If $item is still set, show the link
    if($item):
        $menuDisplay .= "<div class=\"navigation\">";
            $menuDisplay .= $this->Html->link(
                $item['text'],
                $item['url'],
                $item['options'],
                $item['confirm']
            );

            if(isset($item['SubNavigation'])):
                $menuDisplay .= "<div class=\"subnavigation\">";
                foreach($item['SubNavigation'] as $subItem):
                    $subItem = $this->Menu->item($subItem);
                        $menuDisplay .= "<div>";
                        $menuDisplay .= $this->Html->link(
                            $subItem['text'],
                            $subItem['url'],
                            $subItem['options'],
                            $subItem['confirm']
                        );
                    $menuDisplay .= "</div>";
                endforeach;
                $menuDisplay .= "</div>";
            endif;

        $menuDisplay .= "</div>";
    endif;

endforeach;

$menuDisplay .= "</div>";

echo $menuDisplay;