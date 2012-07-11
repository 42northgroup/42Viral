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
?>
<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="two-thirds column alpha">
        <?php echo $this->Form->create('Person', array(
            'url' => '/relationships/index',
            'class'=>'responsive',
            'style'=>"border-bottom: 1px solid #EFEFEF; padding: 0 0 4px; margin: 0 0 6px;"
            ));

        echo $this->Form->input('keywords',
                array('type'=>'text', 'label'=>false));

        echo $this->Form->submit(__('Search Persons'),
                array('div'=>array('style'=>'text-align:left;'), 'style'=>'padding: 5px 8px'));
        ?>

        <?php
        echo $this->Form->end();

        if($display == 'results'):

            if(!empty($data)): ?>
                <div id="ResultsPage">
                    <table>
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Relationship Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data as $person): ?>

                            <tr>
                                <td>
                                    <?php echo $person['Person']['first_name']!=null?
                                                                        $person['Person']['first_name']:"N/A "; ?>
                                </td>
                                <td>
                                    <?php echo $person['Person']['last_name']!=null?
                                                                            $person['Person']['last_name']:"N/A"; ?>
                                </td>
                                <td>
                                    <strong><?php echo $this->Html->link($person['Person']['username'],
                                                '/p/'.$person['Person']['username']); ?> </strong>
                                </td>
                                <td>
                                    <?php
                                    $personId = $person['Person']['id'];
                                    $relationship = array();

                                    if(isset($relationships[$personId])):
                                        if($relationships[$personId]['Relationship']['friends'] == 1):
                                            array_push($relationship, 'Friends');
                                        endif;

                                        if($relationships[$personId]['Relationship']['friend_request'] != null):
                                            array_push($relationship, 'Friendship Pending');
                                        endif;

                                        if($relationships[$personId]['Relationship']['person1_id'] == $personId
                                           &&$relationships[$personId]['Relationship']['person1_to_person2_follow']==1):
                                            array_push($relationship, 'Following You');
                                        endif;

                                        if($relationships[$personId]['Relationship']['person2_id'] == $personId
                                           &&$relationships[$personId]['Relationship']['person2_to_person1_follow']==1):
                                            array_push($relationship, 'Following You');
                                        endif;

                                        if($relationships[$personId]['Relationship']['person1_id'] == $personId
                                           &&$relationships[$personId]['Relationship']['person2_to_person1_follow']==1):
                                            array_push($relationship, 'Following Them');
                                        endif;

                                        if($relationships[$personId]['Relationship']['person2_id'] == $personId
                                           &&$relationships[$personId]['Relationship']['person1_to_person2_follow']==1):
                                            array_push($relationship, 'Following Them');
                                        endif;

                                        if($relationships[$personId]['Relationship']['person1_id'] == $personId
                                            &&$relationships[$personId]['Relationship']['person2_to_person1_block']==1):
                                            $relationship = array('Blocked By U');
                                        endif;

                                        if($relationships[$personId]['Relationship']['person2_id'] == $personId
                                            &&$relationships[$personId]['Relationship']['person1_to_person2_block']==1):
                                            $relationship = array('Blocked By U');
                                        endif;

                                        if($relationships[$personId]['Relationship']['person1_id'] == $personId
                                            &&$relationships[$personId]['Relationship']['person1_to_person2_block']==1):
                                            $relationship = array('You are blocked');
                                        endif;

                                        if($relationships[$personId]['Relationship']['person2_id'] == $personId
                                            &&$relationships[$personId]['Relationship']['person2_to_person1_block']==1):
                                            $relationship = array('You are blocked');
                                        endif;
                                    else:
                                        array_push($relationship, 'No Relationship');
                                    endif;

                                    if($personId == $this->Session->read("Auth.User.id")):
                                        echo "YOU";
                                    elseif(!empty($relationship)):
                                        echo implode(' | ', $relationship);
                                    else:
                                        echo 'No Relationship';
                                    endif

                                    ?>
                                </td>

                                <td>
                                    <?php
                                    $personId = $person['Person']['id'];
                                    $actions = array();

                                    if(isset($relationships[$personId])):
                                        if($relationships[$personId]['Relationship']['friends'] == 1):
                                            $link = $this->Html->link('Unfriend', '/relationships/unfriend/'.$personId);
                                            array_push($actions, $link);
                                        elseif($relationships[$personId]['Relationship']['friend_request'] != null):

                                            if($relationships[$personId]['Relationship']['friend_request']== $personId):
                                                $link = $this->Html->link('Accept Friendship',
                                                                     '/relationships/accept_friend_request/'.$personId);
                                                array_push($actions, $link);
                                            endif;
                                        else:
                                            $link = $this->Html->link('Request Friendship',
                                                                       '/relationships/send_friend_request/'.$personId);
                                            array_push($actions, $link);
                                        endif;

                                        if($relationships[$personId]['Relationship']['person1_id'] == $userId
                                           &&$relationships[$personId]['Relationship']['person1_to_person2_follow']==1):

                                            $link = $this->Html->link('Unfollow', '/relationships/unfollow/'.$personId);
                                            array_push($actions, $link);

                                        elseif($relationships[$personId]['Relationship']['person2_id'] == $userId
                                           &&$relationships[$personId]['Relationship']['person2_to_person1_follow']==1):

                                            $link = $this->Html->link('Unfollow', '/relationships/unfollow/'.$personId);
                                            array_push($actions, $link);
                                        else:

                                            $link = $this->Html->link('Follow', '/relationships/follow/'.$personId);
                                            array_push($actions, $link);
                                        endif;

                                        if($relationships[$personId]['Relationship']['person1_id'] == $userId
                                           &&$relationships[$personId]['Relationship']['person1_to_person2_block']==1):

                                            $link = $this->Html->link('Unblock', '/relationships/unblock/'.$personId);
                                            array_push($actions, $link);

                                        elseif($relationships[$personId]['Relationship']['person2_id'] == $userId
                                           &&$relationships[$personId]['Relationship']['person2_to_person1_block']==1):

                                            $link = $this->Html->link('Unblock', '/relationships/unblock/'.$personId);
                                            array_push($actions, $link);
                                        else:

                                            $link = $this->Html->link('Block', '/relationships/block/'.$personId);
                                            array_push($actions, $link);
                                        endif;
                                    else:
                                        $link = $this->Html->link('Request Friendship',
                                                                       '/relationships/send_friend_request/'.$personId);
                                        array_push($actions, $link);

                                        $link = $this->Html->link('Follow', '/relationships/follow/'.$personId);
                                        array_push($actions, $link);

                                        $link = $this->Html->link('Block','/relationships/block/'.$personId);
                                        array_push($actions, $link);
                                    endif;

                                    if($personId == $this->Session->read("Auth.User.id")):
                                        echo "YOU";
                                    else:
                                        echo implode(' | ', $actions);
                                    endif;

                                    ?>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            <?php
                echo $this->element('paginate');

            else:
                echo $this->element('no_results', array('message'=>__("I'm sorry, there are no results to display.")));
            endif;

        else:
            echo $this->element('no_results', array('message'=>__("I'm sorry, there are no results to display.")));
        endif;
    ?>
    </div>
    <div class="one-third column omega"></div>
</div>