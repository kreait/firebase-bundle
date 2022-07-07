# Firebase SDK Bundle

A Symfony Bundle for the [Firebase PHP SDK](https://github.com/kreait/firebase-php).

[![Current version](https://img.shields.io/packagist/v/kreait/firebase-bundle.svg)](https://packagist.org/packages/kreait/firebase-bundle)
[![Build Status](https://travis-ci.org/kreait/firebase-bundle.svg)](https://travis-ci.org/kreait/firebase-bundle)
[![GitHub license](https://img.shields.io/github/license/kreait/firebase-bundle.svg)](https://github.com/kreait/firebase-bundle/blob/main/LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/kreait/firebase-bundle.svg)](https://packagist.org/packages/kreait/firebase-bundle/stats)
[![Discord](https://img.shields.io/discord/807679292573220925.svg?color=7289da&logo=discord)](https://discord.gg/Yacm7unBsr)
[![Sponsor](https://img.shields.io/static/v1?logo=GitHub&label=Sponsor&message=%E2%9D%A4&color=ff69b4)](https://github.com/sponsors/jeromegamez)

## Table of Contents

- [Overview](#overview)
- [Installation](#installation)
- [Documentation](#documentation)
- [Support](#support)
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

* `kreait_firebase.my_project.auth`
* `kreait_firebase.my_project.database`
* `kreait_firebase.my_project.firestore`
* `kreait_firebase.my_project.messaging`
* `kreait_firebase.my_project.remote_config`
* `kreait_firebase.my_project.storage`
* `kreait_firebase.my_project.dynamic_links`
* `kreait_firebase.other_project.*`

The following classes will be available for dependency injection if you have configured only one project:

* `Kreait\Firebase\Contract\Auth`
* `Kreait\Firebase\Contract\Database`
* `Kreait\Firebase\Contract\Firestore`
* `Kreait\Firebase\Contract\Messaging`
* `Kreait\Firebase\Contract\RemoteConfig`
* `Kreait\Firebase\Contract\Storage`
* `Kreait\Firebase\Contract\DynamicLinks`

To make it easier to use classes via dependency injection in the constructor of a class when multiple projects exist, you can do this in the constructor:

* `Kreait\Firebase\Contract\Auth $my_projectAuth`
* `Kreait\Firebase\Contract\Database $my_projectDatabase`
* `Kreait\Firebase\Contract\Firestore $my_projectFirestore`
* `Kreait\Firebase\Contract\Messaging $my_projectMessaging`
* `Kreait\Firebase\Contract\RemoteConfig $my_projectRemoteConfig`
* `Kreait\Firebase\Contract\Storage $my_projectStorage`
* `Kreait\Firebase\Contract\DynamicLinks $my_projectDynamicLinks`

### Full

```yaml
# app/config/config.yml (Symfony without Flex)
# config/packages/firebase.yaml (Symfony with Flex)
kreait_firebase:
    projects:
        my_project:
            # Optional: Path to the project's Service Account credentials file
            # If omitted, the credentials will be auto-discovered as described
            # in https://firebase-php.readthedocs.io/en/stable/setup.html#with-autodiscovery
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

- [Authentication Guide](https://firebase-php.readthedocs.io/en/stable/authentication.html)
- [Cloud Messaging Guide](https://firebase-php.readthedocs.io/en/stable/cloud-messaging.html)
- [Cloud Storage Guide](https://firebase-php.readthedocs.io/en/stable/cloud-storage.html)
- [Dynamic Links Guide](https://firebase-php.readthedocs.io/en/stable/dynamic-links.html)
- [Firestore Guide](https://firebase-php.readthedocs.io/en/stable/cloud-firestore.html)
- [Realtime Database Guide](https://firebase-php.readthedocs.io/en/stable/realtime-database.html)
- [Remote Config Guide](https://firebase-php.readthedocs.io/en/stable/remote-config.html)

## Support

- [Issue Tracker (Symfony Bundle)](https://github.com/kreait/firebase-bundle/issues/)
- [Bug Reports (Admin SDK)](https://github.com/kreait/firebase-php/issues/)
- [Feature Requests and Discussions (Admin SDK)](https://github.com/kreait/firebase-php/discussions)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/firebase+php)

_If you or your team rely on this project and me maintaining it, please consider becoming a
[Sponsor](https://github.com/sponsors/jeromegamez/) 🙏. Higher tiers enable access to extended
support._

## License

Firebase Admin PHP SDK is licensed under the [MIT License](LICENSE).

Your use of Firebase is governed by the [Terms of Service for Firebase Services](https://firebase.google.com/terms/).
