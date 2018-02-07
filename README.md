# php-unit-testing

This branch prvoides some examples for getting started with php unit testing for Rolustech Plugins using plugin skeleton.

### Prerequisites

Make sure the composer is installed in the target SugarCRM. In order to install the composer run the following commands

```
cd <SugarCRM directory>
composer install
```

Also make sure Xdebug php extension is installed. This is neceassary for generating code coverage.

## Running the tests and generating code coverage

Copy the unit tests, phpunit.xml and bootstrap.php from tests/php/ folder to tests/php/ folder inside plugin skeleton. The phpunit.xml is configured to generate the code coverage for RTGSync. For other plugins the whitelist files and directories needs to be changed appropriately in phpunit.xml.

Once the plugin is installed and tests are deployed inside SugarCRM tests folder. Use Following commands to run the tests and generate code coverage respectively.



```
cd <SugarCRM directory>/tests/php
php ../../vendor/phpunit/phpunit/phpunit --testsuite "Plugin"

php ../../vendor/phpunit/phpunit/phpunit --testsuite "Plugin" --coverage-html="cache/cov/"
```
The code coverage will be genarated in cache/cov folder inside SugarCRM directory.
