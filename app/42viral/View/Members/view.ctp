<?php //debug($user); ?>

<style type="text/css">

    div.profile-pic{
        margin: 20px 0 0;
    }

    div.profile-pic img{
        width: 128px;
    }    
    
    div.profile-column-left{
        float: left;
        width: 150px;
    }

    div.profile-column-right{
        float: left;
        width: 640px;
    }

    div.section-box {
        border: 1px solid #ccc;
        padding: 5px;
        margin: 5px;
    }

</style>

<div class="clearfix">

    <div class="profile-column-left">
        <div class="profile-pic">
            <?php echo $this->Member->avatar($user['User']) ?>
        </div>
    </div>

    <div class="profile-column-right">
        <h1><?php echo $this->Member->displayName($user['User']) ?></h1>

        <p>
            <?php echo $user['Profile']['first_name'] .' '. $user['Profile']['last_name']; ?>
        </p>


        <div class="section-box">
            <h2>Bio:</h2>
            <p>
                <?php echo $user['Profile']['bio']; ?>
            </p>
        </div>


        <table>
            <caption>Content</caption>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Title</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($user['Content'] as $content):?>
                <tr>
                    <td>
                        <?php echo Inflector::humanize($content['object_type']); ?>
                    </td>
                    <td>
                       <?php echo $this->Html->link($content['title'], $content['url']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>


        <div class="section-box">
            <h2>Companies:</h2>
            <?php $companies = $user['Company']; ?>

            <?php if(!empty($companies)): ?>

                <?php foreach($companies as $tempCompany): ?>
                    <h2>
                        <u>Name</u>:
                        <a href="/company_profile/<?php echo $tempCompany['name_normalized']; ?>">
                            <?php echo $tempCompany['name']; ?>
                        </a>
                    </h2>

                    <?php if(isset($tempCompany['Address']) && !empty($tempCompany['Address'])): ?>
                        <h4>Addresses:</h4>

                        <table>
                            <tbody>
                                <?php foreach($tempCompany['Address'] as $tempAddress): ?>
                                    <tr>
                                        <td><?php echo $tempAddress['_us_full_address']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php endforeach; ?>

            <?php else: ?>

                No companies created yet.  <a href="/companies/create">Create one</a>

            <?php endif; ?>
        </div>

    </div>


    <?php if($mine): ?>
        <div>
            <a href="/profiles/edit/<?php echo $user['Profile']['id']; ?>">Edit Profile</a>
            <br />

            <a href="/companies/mine">Edit Companies</a>
        </div>

        <div style="float:left; width: 200px; margin-top: 20px;">
            <a href="/oauth/facebook_connect" >
                Connect Facebook
            </a><br/>

            <a href="/oauth/linkedin_connect" >
                Connect Linkedin
            </a><br/>

            <a href="/oauth/twitter_connect" >
                Connect Twitter
            </a>
        </div>
    <?php endif; ?>
</div>
