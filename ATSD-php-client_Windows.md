# `atsd-php-client` for Windows

## Install and Configure PHP

* [Download PHP](http://windows.php.net/download).
  * For assistance installing PHP follow the [Manuel Installation Instructions](http://php.net/manual/en/install.windows.manual.php).
* Specify path to the `php_curl` extension in `php.ini`:

```php
extension=ext\php_curl.dll
```

* Specify a timezone in `php.ini`:

```php
# Defines the default timezone used by the date functions
# http://php.net/date.timezone
date.timezone = UTC
```

## Install `atsd-php-client`

* Download the `atsd-php-client` to `c:\projects\atsd-api-php`.
  * Use `git` to clone the GitHub repository to the local filesystem.

   ```sh
   git clone https://github.com/axibase/atsd-api-php.git    c:\\projects\\atsd-api-php
   ```

  * Alternatively, download the [`.zip`](https://github.com/axibase/atsd-api-php) file from GitHub and extract it to `c:\projects\atsd-api-php`.

## Run Examples

* Specify credentials and ATSD URL in [`atsd.ini`](./atsdPHP/atsd.ini).

```sh
cd c:\projects\atsd-api-php\examples
atsd.ini
```

* Run the built-in web server:

```sh
cd c:\projects\atsd-api-php\examples
php -S localhost:8000
```

* Use your browser to view example files at `http://localhost:8000/{example}`.

For example:

```txt
http://localhost:8000/BasicExample.php
http://localhost:8000/SeriesExample.php
```
