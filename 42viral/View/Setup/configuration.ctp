<h1>Build the initial application configuration</h1>

Run the schema shell from your CakePHP Console
<pre>
    <code>
        cd app
        sudo ./Console/cake configuration
    </code>
</pre>

After you've ran the configuration shell make sure any new cache files are writable.
<pre>
    <code>
        cd app
        chmod +x write.sh
        sudo ./write.sh [www-data] [username]
    </code>
</pre>

<a href="/setup" class="setup-complete">I have ran the configuration shell and write files</a>
