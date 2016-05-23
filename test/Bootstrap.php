<?php
/**
 * Sandro Keil (https://sandro-keil.de)
 *
 * @link      http://github.com/sandrokeil/docker-selenium-grid-phpunit for the canonical source repository
 * @copyright Copyright (c) 2016 Sandro Keil
 * @license   http://github.com/sandrokeil/docker-selenium-grid-phpunit/blob/master/LICENSE.md New BSD License
 */

// set error reporting
error_reporting(E_ALL | E_STRICT);

chdir(dirname(__DIR__));

if (!file_exists('vendor/autoload.php')) {
    throw new \RuntimeException(
        'Unable to load dependencies. Run `php composer.phar install`'
    );
}

// Setup autoloading
include 'vendor/autoload.php';
