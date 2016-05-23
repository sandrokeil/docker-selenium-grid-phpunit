# Docker Selenium-Grid PHPUnit/Mink

This is a simple example how to use a [Selenium-Grid](https://github.com/SeleniumHQ/selenium/wiki/Grid2) 
with [PHPUnit](https://phpunit.de/) and [Mink](http://mink.behat.org/en/latest/). There are three test classes, to 
demonstrate parallel execution of tests. One test has a duration of ~10s (uses `sleep()`). So you
can see the difference and have time to observe the test execution in the Selenium-Grid.

* `WikipediaChromeTest`: Uses Google Chrome with Selenium to test the search widget
* `WikipediaFirefoxTest`: Uses Mozilla Firefox with Selenium to test the search widget
* `WikipediaGoutteTest`: Uses Mink Goutte Driver to test the search widget (headless Browser)

## Start Selenium-Grid
First, you need to setup a Selenium-Grid. Please install [Docker >= 1.11](https://docs.docker.com/engine/installation/linux/ubuntulinux/) 
and [Docker Compose >= 1.7](https://docs.docker.com/compose/install/) and then run:

```
$ docker-compose up -d
```

If you interested in more Docker Images, please take a look at the [prooph/docker-files](https://github.com/prooph/docker-files).

### Scaling Selenium-Grid
You can run more Firefox oder Chrome instances by running:

```
$ docker-compose scale firefox=5
$ docker-compose scale chrome=5
```

### Watching Tests
You can watch the test execution with a VNC Viewer like [xvnc4viewer](https://wiki.ubuntuusers.de/VNC/#Kommandozeile).

Determine the ports of the Selenium-Node Docker container with:

```
$ docker-compose port firefox
$ docker-compose port chrome
```

Use the IP/Port with the VNC Viewer. The passwort is *secret*:

```
$ vncviewer 0.0.0.0:49338
```

## Install Composer Dependencies
To install the [Composer](https://getcomposer.org/) dependencies run:

```
$ docker run --rm -it --volume $(pwd):/app prooph/composer:7.0 install --dev -o
```

## Using PHPUnit
Every test is executed in order. This should take ~28s.

```
$ docker run --rm -it --volume $(pwd):/app --link hub:hub prooph/php:7.0-cli vendor/bin/phpunit
```

Output:

```bash
PHPUnit 5.3.4 by Sebastian Bergmann and contributors.

...                                                                 3 / 3 (100%)

Time: 28.07 seconds, Memory: 8.00MB

OK (3 tests, 3 assertions)
```

## Using ParaTest
The objective of [ParaTest](https://github.com/brianium/paratest) is to support parallel testing in PHPUnit.
Every test is executed in parallel. This should take ~13s.

```
$ docker run --rm -it --volume $(pwd):/app --link hub:hub prooph/php:7.0-cli vendor/bin/paratest
```

Output:

```bash
Running phpunit in 5 processes with /app/vendor/bin/phpunit

Configuration read from /app/phpunit.xml.dist

...

Time: 13.57 seconds, Memory: 4.00MB

OK (3 tests, 3 assertions)
```

## Using parallel
Every test is executed [parallel](https://launchpad.net/ubuntu/+source/parallel) in an own Docker PHP container. 
This should take ~13s.

```
$ find test/ -name "*Test.php" | parallel --gnu -P 0 'docker run --rm --volume $(pwd):/app --link hub:hub prooph/php:7.0-cli vendor/bin/phpunit {};echo "Runned {} tests";'
```

Output:
```bash
When using programs that use GNU Parallel to process data for publication please cite:

  O. Tange (2011): GNU Parallel - The Command-Line Power Tool,
  ;login: The USENIX Magazine, February 2011:42-47.

This helps funding further development; and it won't cost you a cent.
Or you can get GNU Parallel without this requirement by paying 10000 EUR.

To silence this citation notice run 'parallel --bibtex' once or use '--no-notice'.

PHPUnit 5.3.4 by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: 5.73 seconds, Memory: 6.00MB

OK (1 test, 1 assertion)
Runned test/integration/WikipediaGoutteTest.php tests
PHPUnit 5.3.4 by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: 9.44 seconds, Memory: 4.00MB

OK (1 test, 1 assertion)
Runned test/integration/WikipediaChromeTest.php tests
PHPUnit 5.3.4 by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: 13.14 seconds, Memory: 6.00MB

OK (1 test, 1 assertion)
Runned test/integration/WikipediaFirefoxTest.php tests
```
