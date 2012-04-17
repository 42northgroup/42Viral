<?php
/**
 * Manages the person object with user contraints
 * 
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral
 */
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Setup the application</title>
        
        <link rel="stylesheet" type="text/css" href="/css/setup.css" />
    </head>
    
    <body>
        <div class="container">
            <h1>Setup the application</h1>

            <p>
                Run the setup shell from the app directory. Omit sudo if you are running from a root shell.
                Running this script will provide proper read/write permissions. In short, this allows the web server
                to do what it needs to do.
            </p>

            <dl>
                <dt>[www-data]</dt>
                <dd>If the web server runs as a user, this would be that user name. Usually it is www-data.</dd>
            </dl>

            <dl>
                <dt>[username]</dt>
                <dd>
                    The name a user with permission to write to the web directories. Usually this is the user you are
                    logged in as.
                </dd>
            </dl>

            <pre>
                <code>
                    cd app
                    chmod +x setup.sh
                    sudo ./setup.sh [www-data] [username]
                </code>
            </pre>

            <p>
                Follow the instructions in the setup shell to complete all the required steps and then click the
                button below.
            </p>

            <a href="/users/login"
               class="confirm-button">I completed the setup</a>
        </div>
    </body>
</html>