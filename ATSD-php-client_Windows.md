# atsd-php-client on Windows

## Install and configure php

- Download PHP from http://windows.php.net/download

- Follow installation steps at http://php.net/manual/en/install.windows.manual.php

* Ensure that you specify path to php_curl extension in php.ini:

```
extension=ext\php_curl.dll
```

* Ensure that you specify timezone in php.ini:

```
; Defines the default timezone used by the date functions
; http://php.net/date.timezone
date.timezone = UTC
```

## Install atst-php-client

- Download ATSD-php-client to `c:\projects\atsd-api-php`

* If you have git installed, just clone github repository

```
git clone https://github.com/axibase/atsd-api-php.git c:\\projects\\atsd-api-php
```

-   If you don't have git installed, download ZIP from https://github.com/axibase/atsd-api-php and extract it to `c:\projects\atsd-api-php`.

## Run examples

- Specify your credentials and ATSD url in `c:\projects\atsd-api-php\examples\atsd.ini`

- Run built-in web server

```
cd c:\projects\atsd-api-php\examples
php -S localhost:8000
```

- Use your browser to view examples files at `http://localhost:8000/{.php fileName}`, for example:

~~~
http://localhost:8000/BasicExample.php
http://localhost:8000/SeriesExample.php
~~~

