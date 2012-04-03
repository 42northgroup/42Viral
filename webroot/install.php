<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Setup the application</title>
        
        <style>
            ::-moz-selection { background: #fe57a1; color: #fff; text-shadow: none; }
            ::selection { background: #fe57a1; color: #fff; text-shadow: none; }
            html { padding: 30px 10px; font-size: 16px; line-height: 1.4; color: #737373; background: #f0f0f0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
            html, input { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; }
            body { max-width: 700px; _width: 700px; padding: 30px 20px 50px; border: 1px solid #b3b3b3; border-radius: 4px; margin: 0 auto; box-shadow: 0 1px 10px #a7a7a7, inset 0 1px 0 #fff; background: #fcfcfc; }
            h1 { margin: 0 10px; font-size: 50px; text-align: center; }
            h1 span { color: #bbb; }
            h3 { margin: 1.5em 0 0.5em; }
            p { margin: 1em 0; }
            ul { padding: 0 0 0 40px; margin: 1em 0; }
            .container { max-width: 580px; _width: 580px; margin: 0 auto; }
            dl{font-size: 14px;}
            pre {
                color: #000;
                background: #f0f0f0;
                padding: 15px;
                box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
                box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            }
            pre,
            code{
                overflow: auto;
                font-size: 12px;
            }
        </style>
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
                <dd>If the web server runs as a user, this would be that user name. This is probably www-data.</dd>

                <dt>[username]</dt>
                <dd>
                    The name a user with permission to write to the web directories. This is probably the user you are
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
                Make sure you complete all the steps in the setup
            </p>

            <a href="/users/login">I have ran the setup shell</a>
        </div>
    </body>
</html>