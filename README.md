# Firebase SDK Bundle

A Symfony Bundle for the [Firebase PHP SDK](https://github.com/kreait/firebase-php).

[![Current version](https://img.shields.io/packagist/v/kreait/firebase-bundle.svg?logo=composer)](https://packagist.org/packages/kreait/firebase-bundle)
[![Monthly Downloads](https://img.shields.io/packagist/dm/kreait/firebase-bundle.svg)](https://packagist.org/packages/kreait/firebase-bundle/stats)
[![Total Downloads](https://img.shields.io/packagist/dt/kreait/firebase-bundle.svg)](https://packagist.org/packages/kreait/firebase-bundle/stats)
[![Tests](https://github.com/kreait/firebase-bundle/actions/workflows/tests.yml/badge.svg)](https://github.com/kreait/firebase-bundle/actions/workflows/tests.yml)
[![Sponsor](https://img.shields.io/static/v1?logo=GitHub&label=Sponsor&message=%E2%9D%A4&color=ff69b4)](https://github.com/sponsors/jeromegamez)

---

## The future of the Firebase Admin PHP SDK

Please read about the future of the Firebase Admin PHP SDK on the
[SDK's GitHub Repository](https://github.com/kreait/firebase-php).

---

- [Overview](#overview)
- [Installation](#installation)
- [Supported Versions](#supported-versions)
- [Documentation](#documentation)
- [License](#license)

## Overview

[Firebase](https://firebase.google.com/) provides the tools and infrastructure you need to develop your app, grow your user base, and earn money. The Firebase Admin PHP SDK enables access to Firebase services from privileged environments (such as servers or cloud) in PHP.

For more information, visit the [Firebase Admin PHP SDK documentation](https://firebase-php.readthedocs.io/).

## Installation

Add the bundle using [Composer](https://getcomposer.org)

```bash
composer require kreait/firebase-bundle
```

```php
// Symfony without Flex
// in %kernel.root_dir%/AppKernel.php
$bundles = array(
    // ...
    new Kreait\Firebase\Symfony\Bundle\FirebaseBundle(),
);

// Symfony with Flex
// in config/bundles.php
return [
    // ...
    Kreait\Firebase\Symfony\Bundle\FirebaseBundle::class => ['all' => true],
];
```

## Supported Versions

**Only the latest version is actively supported.**

Earlier versions will receive security fixes as long as their **lowest** SDK requirement receives security fixes. You
can find the currently supported versions and support options in the [SDK's README](https://github.com/kreait/firebase-php).

| Version | Initial Release | Supported SDK Versions | Supported Symfony Versions | Status      |
|---------|-----------------|------------------------|----------------------------|-------------|
| `5.x`   | 23 Jan 2023     | `^7.0`                 | `^5.4, ^6.0`               | Active      |
| `4.x`   | 09 Jan 2022     | `^6.0`                 | `^5.4, ^6.0`               | End of life |
| `3.x`   | 30 Nov 2021     | `^5.25`                | `^5.4, ^6.0`               | End of life |
| `2.x`   | 01 Apr 2020     | `^5.0`                 | `^3.4.26, ^4.2, ^5.0`      | End of life |
| `1.x`   | 06 Apr 2018     | `^4.35`                | `^3.4, ^4.2, ^5.0`         | End of life |
| `0.x`   | 23 Jan 2015     | `0.9.*`                | `^2.0, ^3.0`               | End of life |

## Configuration

### Minimal

```yaml
# app/config/config.yml (Symfony without Flex)
# config/packages/firebase.yaml (Symfony with Flex)
kreait_firebase:
    projects:
        my_project:
            credentials: '%kernel.project_dir%/config/my_project_credentials.json'
        other_project: # optional
            credentials: '%kernel.project_dir%/config/other_project_credentials.json'
```

The following services will be available for your project:

* `kreait_firebase.my_project.app_check`
* `kreait_firebase.my_project.auth`
* `kreait_firebase.my_project.database`
* `kreait_firebase.my_project.firestore`
* `kreait_firebase.my_project.messaging`
* `kreait_firebase.my_project.remote_config`
* `kreait_firebase.my_project.storage`
* `kreait_firebase.my_project.dynamic_links`
* `kreait_firebase.other_project.*`

The following classes will be available for dependency injection if you have configured only one project:

* `Kreait\Firebase\Contract\AppCheck`
* `Kreait\Firebase\Contract\Auth`
* `Kreait\Firebase\Contract\Database`
* `Kreait\Firebase\Contract\Firestore`
* `Kreait\Firebase\Contract\Messaging`
* `Kreait\Firebase\Contract\RemoteConfig`
* `Kreait\Firebase\Contract\Storage`
* `Kreait\Firebase\Contract\DynamicLinks`

To make it easier to use classes via dependency injection in the constructor of a class when multiple projects exist, you can do this in the constructor:

* `Kreait\Firebase\Contract\Auth $myProjectAppCheck`
* `Kreait\Firebase\Contract\Auth $myProjectAuth`
* `Kreait\Firebase\Contract\Database $myProjectDatabase`
* `Kreait\Firebase\Contract\Firestore $myProjectFirestore`
* `Kreait\Firebase\Contract\Messaging $myProjectMessaging`
* `Kreait\Firebase\Contract\RemoteConfig $myProjectRemoteConfig`
* `Kreait\Firebase\Contract\Storage $myProjectStorage`
* `Kreait\Firebase\Contract\DynamicLinks $myProjectDynamicLinks`

### Full

```yaml
# app/config/config.yml (Symfony without Flex)
# config/packages/firebase.yaml (Symfony with Flex)
kreait_firebase:
    projects:
        my_project:
            # Optional: Path to the project's Service Account credentials file
            # If omitted, the credentials will be auto-discovered as described
            # in https://firebase-php.readthedocs.io/en/stable/setup.html
            credentials: '%kernel.project_dir%/config/my_project_credentials.json'
            # Optional: If set to true, this project will be used when 
            # type hinting the component classes of the Firebase SDK,
            # e.g. Kreait\Firebase\Auth, Kreait\Firebase\Database,
            # Kreait\Firebase\Messaging, etc.
            default: false 
            # Optional: If set to false, the service and its alias can only be
            # used via dependency injection, and not be retrieved from the
            # container directly.
            public: true
            # Optional: Should only be used if the URL of your Realtime
            # Database can not be generated with the project id of the 
            # given Service Account
            database_uri: 'https://my_project.firebaseio.com'
            # Optional: Make the client tenant aware
            tenant_id: 'tenant-id'
            # Optional: Default domain for Dynamic Links
            default_dynamic_links_domain: 'https://my_project.page.link'
            # Optional: Used to cache Google's public keys.
            verifier_cache: null # Example: cache.app
            # Optional: Used to cache the authentication tokens for connecting to the Firebase servers.
            auth_token_cache: null # Example: cache.app
            # If set, logs simple HTTP request and response statuses
            http_request_logger:  null # Example: monolog.logger.firebase
            # If set, logs detailed HTTP request and response statuses
            http_request_debug_logger: null # Example: monolog.logger.firebase_debug
```

## Documentation

For documentation of the underlying SDK, visit the [Firebase Admin PHP SDK documentation](https://firebase-php.readthedocs.io/).

## License

This project is licensed under the [MIT License](LICENSE).

Your use of Firebase is governed by the [Terms of Service for Firebase Services](https://firebase.google.com/terms/).
