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

use Behat\Mink\Session;

class SearchWidget
{
    /**
     * @param $searchTerm
     * @param Session $minkSession
     * @return string
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public static function searchFor(string $searchTerm, Session $minkSession) : string
    {
        $baseUrl = 'https://en.wikipedia.org/wiki/Main_Page';

        $minkSession->visit($baseUrl);

        $page = $minkSession->getPage();

        $page->fillField('searchInput', $searchTerm);

        sleep(5);

        $page->pressButton('searchButton');

        return $minkSession->getPage()->getContent();
    }
}
