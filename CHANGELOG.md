# CHANGELOG

## [Unreleased]
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

[Unreleased]: https://github.com/kreait/firebase-bub/compare/2.0.0...HEAD
[2.0.0]: https://github.com/kreait/firebase-php/releases/tag/2.0.0
