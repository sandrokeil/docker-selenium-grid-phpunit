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

use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;
use PHPUnit_Framework_TestCase as TestCase;

class BaseTestCase extends TestCase
{
    /**
     * @return Session
     */
    protected function setupSeleniumSession($browser) : Session
    {
        // selenium version is important
        $driver = new Selenium2Driver(
            $browser,
            ['selenium-version' => '2.53.0'],
            'http://hub:4444/wd/hub'
        );
        $minkSession = new Session($driver);
        $minkSession->start();
        return $minkSession;
    }

    /**
     * @return Session
     */
    protected function setupGoutteSession() : Session
    {
        $driver = new \Behat\Mink\Driver\GoutteDriver();
        $minkSession = new \Behat\Mink\Session($driver);
        $minkSession->start();
        return $minkSession;
    }

    /**
     * Test search widget
     *
     * @param Session $minkSession
     */
    public function assertSearchForPhp(Session $minkSession)
    {
        $content = SearchWidget::searchFor('PHP', $minkSession);

        self::assertContains('PHP: Hypertext Preprocessor', $content);
    }
}
