# CHANGELOG

## 1.1.0 - 2018-04-08

* A project can be defined as the default project.
* If only one project is configured, it is considered the default project.
* The default project is aliased to the `Kreait\Firebase` class (usefule for Dependency Injection/Autowiring) 

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
