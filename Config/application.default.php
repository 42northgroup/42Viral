<?php
//Configure::write('Akismet.key', '');
//Configure::write('Disqus.developer', '');
//Configure::write('Disqus.shortname', '');
//Configure::write('AntispamService', '');
Configure::write('Beta.invitations', '25'); ## INT
Configure::write('Beta.private', 0); ## 1/0

Configure::write('Email.from', 'support@jasonsnider.com');
Configure::write('Email.replyTo', 'support@jasonsnider.com');


Configure::write('Login.attempts', '');
Configure::write('Login.lockout', '');

Configure::write('Password.alphanumeric', 0); ## 1/0
Configure::write('Password.difference', '');
Configure::write('Password.expiration', '');
Configure::write('Password.minLength', ''); ## INT
Configure::write('Password.specialChars', 0); ## 1/0

Configure::write('Theme.set', 'Default');
