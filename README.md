# bbframework
Very basic PHP MVC framework with Global Registry model


Intallation Process:

- copy config_template.php (located in the /config directory) to config.php
- update config.php with your values for Redis and MySQL
- run composer init (or remove vendor/autoload from the top of index.php in /document_root)
- configure .htaccess to redirect all requests (except /scripts or /images as required) to index.php (mod_rewrite)
- run "php install.php" in the base directory

TODO: More information to come later.
