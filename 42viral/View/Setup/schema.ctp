<h1>Build the database</h1>

Run the schema shell from your CakePHP Console

<pre>
    <code>
        cd app
        chmod +x Console/cake
        sudo ./Console/cake schema create
    </code>
</pre>

After you've ran the schema shell make sure any new cache files are writable.
<pre>
    <code>
        cd app
        chmod +x setup.sh
        sudo ./setup.sh [www-data] [username]
    </code>
</pre>

<a href="/setup" class="setup-complete">I have ran the schema shell and write files</a>