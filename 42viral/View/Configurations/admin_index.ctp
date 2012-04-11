<h1><?php echo $title_for_layout; ?></h1>
<div class="rows">
    <div class="one-third column alpha">
        <div class="column-block navigation-block block-links">
            <?php echo $this->Html->link(
                    'Configuration Settings', 
                    '/admin/configurations/configuration'); ?>
        </div>
    </div>
    <div class="one-third column">
        <h2>Installed Plugins</h2>
        <div class="column-block">
        <?php foreach($plugins as $plugin):?>
            <span class="block-well-spaced">
            <?php 
                if(isset($plugin['url'])):
                    echo $this->Html->link($plugin['label'], $plugin['url']); 
                else:
                    echo $plugin['label'];   
                endif;
            ?>
            </span>
        <?php endforeach; ?>
        </div>
    </div>
    <div class="one-third column omega">
        <h2>Third party services</h2>
        <?php
            $servers = array(
                array('server'=> 'rest.akismet.com', 'port'=>'80')
            );        
        ?>
        <table>
            <caption>Akismet Service Status</caption>
            <tr>
                <th>Server/Service</th>
                <th>Status</th>
            </tr>
            <?php foreach($servers as $server): ?>
            <tr>
                <td><?php echo $server['server']; ?></td>
                <td><?php echo Utility::connectionTest($server['server'], 
                                $server['port'])?'Connected :)':'Could not connect :('; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        
        <?php
            $servers = array(
                array('server'=> 'graph.facebook.com', 'port'=>'443'),
                array('server'=> 'api.linkedin.com', 'port'=>'80'),
                array('server'=> 'api.twitter.com', 'port'=>'80'),
                array('server'=> 'local.yahooapis.com', 'port'=>'80'),
                array('server'=> 'api.yelp.com', 'port'=>'80')
            );
        ?>


        <table>
            <caption>Oauth Connect Service Status</caption>
            <thead>
                <tr>
                    <th>Server/Service</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($servers as $server): ?>
                    <tr>
                        <td>
                            <?php echo $server['server']; ?>
                        </td>

                        <td>
                            <?php
                                echo Utility::connectionTest($server['server'], $server['port'])?
                                    'Connected :)':
                                    'Could not connect :('; 
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>