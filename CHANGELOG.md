# CHANGELOG

## [Unreleased]

## [5.5.0] - 2024-10-16

* Added support for PHP 8.4
  ([#64](https://github.com/kreait/firebase-bundle/pull/64))

## [5.4.0] - 2024-07-08

* Added the ability to override the project id 
  ([#63](https://github.com/kreait/firebase-bundle/pull/63))

## [5.3.0] - 2024-05-28

* Added Support for overriding the `ProjectFactory`
  ([#60](https://github.com/kreait/firebase-bundle/pull/60))

## [5.2.0] - 2023-11-30

* Added Support for AppCheck
  ([#54](https://github.com/kreait/firebase-bundle/pull/53))

## [5.1.1] - 2023-11-30

* Actually support Symfony 7
  ([#53](https://github.com/kreait/firebase-bundle/pull/53)) 

## [5.1.0] - 2023-11-30

* Added support for PHP 8.3 and Symfony 7
  ([#52](https://github.com/kreait/firebase-bundle/pull/52))

## [5.0.0] - 2023-01-13

* Upgraded `kreait/firebase-php` from 6.x to 7.x
* Dropped support for PHP <8.1 (the PHP SDK requires PHP 8.1/8.2)

## [4.1.0] - 2022-07-07

### Added

* Extra aliases have been added to make it easier to work with multiple projects.
  ([#41](https://github.com/kreait/firebase-bundle/pull/41))

## [4.0.0] - 2022-01-09

This is a release with breaking changes. Please review the following changes and adapt your application where needed.

### Changes
* Added support for `kreait/firebase-php` ^6.0
* Dropped support for `kreait/firebase-php` <6.0
* If you're type-hinting dependencies in your application code, make sure you type-hint the
  `Kreait\Firebase\Contract\*` **interfaces**, not the `Kreait\Firebase\*` **implementations**

## [3.1.0] - 2021-12-04
### Added
* Added support for caching the authentication tokens used for connecting to the Firebase servers.

## [3.0.0] - 2021-11-30
### Changed
* Dropped support for Symfony <5.4
* Added support for Symfony ^6.0

## [2.6.0] - 2021-11-23
### Added
* Made component contracts (`Kreait\Firebase\Contract\*`) available via dependency injection.

### Changed
* Dropped support for unsupported Symfony versions (see [Symfony Releases](https://symfony.com/releases)). Starting with
  this release, supported Symfony versions are ^4.4 and ^5.3.
* Dropped support for unsupported PHP versions. Starting with this release, supported are PHP versions ^7.4 and ^8.0.
* Require `"kreait/firebase-php": "^5.25.0"`

### Deprecated
* Deprecated usage of contract implementations via dependency injection.

## [2.5.0] - 2021-10-08
### Changed
* Removed `psr/cache` and `psr/simple-cache` as direct dependencies.
* Updated `symfony/cache` dependency to address CVE.

## [2.4.0] - 2021-04-14
### Added
* Added configuration option `tenant_id` to make a project tenant aware.
  ([#31](https://github.com/kreait/firebase-bundle/pull/31))

### Changed
* The bundle now requires at least version 5.17.1 of the Firebase PHP SDK

## [2.3.0] - 2020-10-04
### Added
* PHP `^8.0` is now an allowed (but untested) PHP version

## [2.2.0] - 2020-07-10
### Added
* It is now possible to log HTTP requests and responses to the Firebase APIs 
  by specifying a logger's service ID. You can do so by setting 
  `http_request_logger` and `http_request_debug_logger` with the service ID 
  of an already configured logger, e.g. `monolog.logger`.

## [2.1.0] - 2020-06-23
### Added
* Added Support for PSR-6 and PSR-16 caches. This implicitly adds
  out-of-the-box support for Symfony 5.
### Changed
* The bundle now requires a version `^5.5` of the Firebase Admin SDK.
* The default branch of the GitHub repository has been renamed from `master`
  to `main` - if you're using `dev-master` as a version constraint in your 
  `composer.json`, please update it to `dev-main`.

## [2.0.0] - 2020-04-01
### Added
* Added Support for `kreait/firebase-php:^5.0`
### Removed
* Removed Support for `kreait/firebase-php:<5.0`
* Removed project aliases

[Unreleased]: https://github.com/kreait/firebase-bundle/compare/5.4.0...HEAD
[5.4.0]: https://github.com/kreait/firebase-bundle/compare/5.3.0...5.4.0
[5.3.0]: https://github.com/kreait/firebase-bundle/compare/5.2.0...5.3.0
[5.2.0]: https://github.com/kreait/firebase-bundle/compare/5.1.1...5.2.0
[5.1.1]: https://github.com/kreait/firebase-bundle/compare/5.1.0...5.1.1
[5.1.0]: https://github.com/kreait/firebase-bundle/compare/5.0.0...5.1.0
[5.0.0]: https://github.com/kreait/firebase-bundle/compare/4.1.0...5.0.0
[4.1.0]: https://github.com/kreait/firebase-bundle/compare/4.0.0...4.1.0
[4.0.0]: https://github.com/kreait/firebase-bundle/compare/3.1.0...4.0.0
[3.1.0]: https://github.com/kreait/firebase-bundle/compare/3.0.0...3.1.0
[3.0.0]: https://github.com/kreait/firebase-bundle/compare/2.6.0...3.0.0
[2.6.0]: https://github.com/kreait/firebase-bundle/compare/2.5.0...2.6.0
[2.5.0]: https://github.com/kreait/firebase-bundle/compare/2.4.0...2.5.0
[2.4.0]: https://github.com/kreait/firebase-bundle/compare/2.3.0...2.4.0
[2.3.0]: https://github.com/kreait/firebase-bundle/compare/2.2.0...2.3.0
[2.2.0]: https://github.com/kreait/firebase-bundle/compare/2.1.0...2.2.0
[2.1.0]: https://github.com/kreait/firebase-bundle/compare/2.0.0...2.1.0
[2.0.0]: https://github.com/kreait/firebase-bundle/releases/tag/2.0.0
