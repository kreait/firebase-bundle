# CHANGELOG

## Unreleased

* Dropped support for unsupported Symfony releases, supported are `^3.4|^4.2|^5.0`
* Made the Cache used to cache Google's Public Keys for ID Token verification configurable  

## 1.7.0 - 2019-11-26

* Added support for Symfony 5.x

## 1.6.1 - 2019-11-19

* Upgraded [symfony/dependency-injection](https://packagist.org/packages/symfony/dependency-injection) to avoid
  [CVE-2019-10910](https://github.com/advisories/GHSA-pgwj-prpq-jpc2)

## 1.6.0 - 2019-11-09

* Each Firebase SDK component is now individually registered and accessible ([#16](https://github.com/kreait/firebase-bundle/pull/16)).
* Using the `Kreait\Firebase` class is deprecated, please use the individual components instead.
* Defining an alias for the `Kreait\Firebase` service is deprecated, please also use the individual components instead.

## 1.5.0 - 2019-10-18

* Updated `kreait/firebase-php` to `^4.35`

## 1.4.0 - 2019-10-13

* Updated `kreait/firebase-php` to `^4.34`
* Added handling of now deprecated methods of the SDK 
* The predefined service classes can now be overridden via parameters
* The bundle is now tested with all currently supported PHP and Symfony versions

## 1.3.0 - 2019-05-26

* Credential autodiscovery is now disabled when the `credentials` configuration option 
  has been set. This prevents triggering it when there is a problem with the configured 
  credentials.

## 1.2.0 - 2019-02-08

* Avoid deprecation warning with newer Symfony versions ([#11](https://github.com/kreait/firebase-bundle/pull/11))

## 1.1.1 - 2018-04-09

### Bugfixes

* Fixed the usage of the unconfigured base factory ([#7](https://github.com/kreait/firebase-bundle/pull/7)) 

## 1.1.0 - 2018-04-08

* A project can be defined as the default project.
* If only one project is configured, it is considered the default project.
* The default project is aliased to the `Kreait\Firebase` class (useful for Dependency Injection/Autowiring) 

## 1.0.0 - 2018-04-06

* Initial release with support for `kreait/firebase-php` ^4.0  

## 0.5 - 2015-12-07

* Updated dependencies to add support for PHPUnit and Symfony 3.0.
* Removed obsolete documentation from the README.

## 0.4 - 2015-05-04
* Adds authentication support
* Removes HTTPAdapterBundle as dependency, because it is not available in a current enough version. The Firebase library
  will guess the best fitting HTTP client from the available clients in your project. 

## 0.3.1 - 2015-01-28
### FEATURE
* Ability to specify HTTP adapter

### CLEANUP
* Removed unused USE statements
* Text files should contain line endings

## 0.2.4 - 2015-01-23
### FIX
* fixed autoloading namespace

###Added
* Initial commit, version is in-sync with the firebase-php lib for convenience
* Here we go.
