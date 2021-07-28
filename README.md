PhpInterface
============

Use this package to determine what type of interface your PHP app is using to run. a command line interface or a web interface

<p align="center">
<a href="LICENSE"><img src="https://img.shields.io/github/license/natokpe/php-interface" alt="Software License"></img></a>
<a href="#"><img src="https://img.shields.io/github/repo-size/natokpe/php-interface" alt="repo size"></img></a>
<a href="#"><img src="https://img.shields.io/github/size/natokpe/php-interface/src/PhpInterface.php" alt="file size"></img></a>
<a href="#"><img src="https://img.shields.io/github/v/release/natokpe/php-interface" alt="release"></img></a>
</p>

# Installation

## Composer
The recommended way of including this package in your project is via Composer
```bash
$ composer require natokpe/php-interface
```

# Usage
To use the package, you can simply do something like this
```php
use natokpe\PhpInterface\PhpInterface;

require_once __DIR__ . '/vendor/autoload.php';

$interface = new PhpInterface;

echo $interface->which();
// will print 'cli' if PHP is using CLI to run or 'web' if PHP is run from web
```

You can also use either of the `isCli()` or `isWeb()` methods to check
```php
if ( $interface->isCli() ) {
  echo 'cli'; // will print 'cli' if PHP is using CLI to run
}

if ( $interface->isWeb() ) {
  echo 'cli'; // will print 'web' if PHP is run from web
}
```

Additionally, you may want to know if PHP is using a CGI based interface. Use the `isCgi()` method to check.
```php
if ( $interface->isCgi() ) {
  echo 'cgi'; // will print 'cgi' if PHP is using a CGI based interface to run
}
```

You can use PhpInterface without instantiation via the `getType()` static method.
```php
echo PhpInterface::getType(); // will print either 'cli' or 'web' depending on which type of interface PHP is using
```
The `getType()` static method is similar to `which()`.


That's it! I hope you like it and find it useful.
