# Meters application

This application shows you how to use atsd-api-php client with a real use case.
Read more about this use case on [axibase.com](http://axibase.com/products/axibase-time-series-database/visualization/embedded-widgets/external-application/)

To implement it, execute the following steps:

## Install [atsd-api-php](https://github.com/axibase/atsd-api-php#installing-the-atsd-client) client

Make sure you set the right ATSD user and password in atsd-api-php/atsdPHP/atsd.ini

## Create User Accounts

- Install ```apache2-utils``` package to use ```htdigest``` utility (required to generate the authentication file):
```bash
$ sudo apt-get install apache2-utils
```

- To create the users who will be authorized to access this application, run the following commands:

```bash
$ touch atsd-api-php/meters/.htpasswd
$ htdigest atsd-api-php/meters/.htpasswd meters admin
$ htdigest atsd-api-php/meters/.htpasswd meters user1
$ htdigest atsd-api-php/meters/.htpasswd meters user2
$ htdigest atsd-api-php/meters/.htpasswd meters guest
```

- Modify ```atsd-api-php/meters/.htaccess``` and specify the correct path to the ```.htpasswd``` file:
```
AuthUserFile "documentRoot/atsd-api-php/meters/.htpasswd"
```

## Configure application

- Configure metrics

To change displayed and reported metrics modify the ```atsd-api-php/meters/js/configs.js``` file and set your collected metric from ATSD on the first line:
```
var metricValue = "sml.power-consumed";
```

- Create the following entity groups in ATSD UI - navigate to Entities -> Entity Groups -> Create:
    - org-all-entities
    - org-001-entities
    - org-002-entities
    - org-none-entities

Populate the groups with entities collecting the selected metric.

- Configure Users-Group

To define user-group mappings your need to modify ```atsd-api-php/meters/users-group.ini``` file. 

```users-group.ini``` example:
```shell
[user-to-group]
admin = org-all-entities
user-001 = org-001-entities
user-002 = org-002-entities
user-guest = org-none-entities
```

## Enable digest authentication and rewrite module on your apache server
```bash
$ sudo a2enmod auth_digest
$ sudo a2enmod rewrite
$ sudo service apache2 restart
```

Verify that AllowOverride directive is set to All in Apache configuration file:
```
<Directory /var/www/>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```


## Access the application
You can access the application on the following URL:
yourDomainName/atsd-api-php/meters/

If you want to create a custom URL, create a new ```.htaccess``` file in your ```documentRoot``` directory with the following content:
```
RewriteEngine On
RewriteBase /
RewriteRule ^(meters/.*)$ /atsd-api-php/$1 
```

Then you can access the application on the following URL:
yourDomainName/meters/

## Troubleshooting

If you get the following error, ensure that variable AuthUserFile in ```atsd-api-php/meters/.htaccess``` is pointing to your ```.htpasswd``` file.
```
Internal Server Error
The server encountered an internal error or misconfiguration and was unable to complete your request.
```

