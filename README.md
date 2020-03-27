# Firebase SDK Bundle

A Symfony Bundle for the [Firebase PHP SDK](https://github.com/kreait/firebase-php).

[![Current version](https://img.shields.io/packagist/v/kreait/firebase-bundle.svg)](https://packagist.org/packages/kreait/firebase-bundle)
[![Build Status](https://travis-ci.org/kreait/firebase-bundle.svg?branch=master)](https://travis-ci.org/kreait/firebase-bundle)
[![GitHub license](https://img.shields.io/github/license/kreait/firebase-bundle.svg)](https://github.com/kreait/firebase-bundle/blob/master/LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/kreait/firebase-bundle.svg)]()
[![Discord](https://img.shields.io/discord/523866370778333184.svg?color=7289da&logo=discord)](https://discord.gg/nbgVfty)

---

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

### Full

```yaml
# app/config/config.yml (Symfony without Flex)
# config/packages/firebase.yaml (Symfony with Flex)
kreait_firebase:
    projects:
        my_project:
            # Optional: Path to the project's Service Account credentials file
            # If omitted, the credentials will be auto-dicovered as described
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
            # Optional: Default domain for Dynamic Links
            default_dynamic_links_domain: 'https://my_project.page.link'
            # Optional: Used to cache Google's public keys. Must implement
            # \Psr\SimpleCache\CacheInterface (PSR-16)
            verifier_cache: 'cache.app.simple'
```

## Support

For bug reports and feature requests, use the [issue tracker](https://github.com/kreait/firebase-bundle/issues/).

For help with and discussion about the PHP SDK and Bundle, join the [Gitter Channel dedicated to this library](https://gitter.im/kreait/firebase-php).

For questions about Firebase in general, use [Stack Overflow](https://stackoverflow.com/questions/tagged/firebase) or join the [Firebase Slack Community](https://firebase.community).
