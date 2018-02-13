# php-unit-testing

This branch prvoides some examples for getting started with php unit testing inside SugarCRM.

### Prerequisites

Make sure the composer (dependency management tool for PHP) is installed in your operating system. Then you need to install dependencies using composer in the target SugarCRM. In order to install the dependencies using composer run the following commands

```
cd <SugarCRM directory>
composer install
```

Also make sure Xdebug php extension is installed. This is neceassary for generating code coverage.

## Running the tests and generating code coverage in SugarCRM

Copy all files from custom/tests/ folder from this repository to custom/tests/ folder inside SugarCRM. The phpunit.xml is configured to generate the code coverage for custom folder by default. To include or exclude any other files or folders in code coverage, the whitelist files and directories needs to be changed appropriately in phpunit.xml.

Once the files are copied inside SugarCRM tests folder. Use Following commands to run the tests and generate code coverage respectively.


```
cd <SugarCRM directory>/custom/tests

php ../../vendor/phpunit/phpunit/phpunit --testsuite "RT customization test suite"

php ../../vendor/phpunit/phpunit/phpunit --testsuite "RT customization test suite" --coverage-html="cache/cov"

```

To run the unit tests in debug mode use the following command.

```
php ../../vendor/phpunit/phpunit/phpunit --testsuite "RT customization test suite" --debug

```

The code coverage will be genarated in cache/cov folder inside SugarCRM directory.
