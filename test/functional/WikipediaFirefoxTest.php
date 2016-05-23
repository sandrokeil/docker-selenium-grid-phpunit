<?php
/**
 * Sandro Keil (https://sandro-keil.de)
 *
 * @link      http://github.com/sandrokeil/docker-selenium-grid-phpunit for the canonical source repository
 * @copyright Copyright (c) 2016 Sandro Keil
 * @license   http://github.com/sandrokeil/docker-selenium-grid-phpunit/blob/master/LICENSE.md New BSD License
 */
declare(strict_types = 1);

namespace SakeTest\Functional;

use SakeTest\Functional\BaseTestCase as TestCase;

class WikipediaFirefoxTest extends TestCase
{
    /**
     * Uses Selenium to test search widget
     */
    public function testSeleniumSearchWithPhp()
    {
        $this->assertSearchForPhp($this->setupSeleniumSession('firefox'));
    }
}
