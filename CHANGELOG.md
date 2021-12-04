# CHANGELOG

## [Unreleased]
### Fixed
* Fixed service alias deprecation when used with Symfony 4.4
  ([#38](https://github.com/kreait/firebase-bundle/issues/38))

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

[Unreleased]: https://github.com/kreait/firebase-bundle/compare/2.6.0...HEAD
[2.6.0]: https://github.com/kreait/firebase-bundle/compare/2.5.0...2.6.0
[2.5.0]: https://github.com/kreait/firebase-bundle/compare/2.4.0...2.5.0
[2.4.0]: https://github.com/kreait/firebase-bundle/compare/2.3.0...2.4.0
[2.3.0]: https://github.com/kreait/firebase-bundle/compare/2.2.0...2.3.0
[2.2.0]: https://github.com/kreait/firebase-bundle/compare/2.1.0...2.2.0
[2.1.0]: https://github.com/kreait/firebase-bundle/compare/2.0.0...2.1.0
[2.0.0]: https://github.com/kreait/firebase-bundle/releases/tag/2.0.0
