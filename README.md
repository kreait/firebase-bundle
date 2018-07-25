# Firebase SDK Bundle

A Symfony Bundle for the [Firebase PHP SDK](https://github.com/kreait/firebase-php).

[![Current version](https://img.shields.io/packagist/v/kreait/firebase-bundle.svg)](https://packagist.org/packages/kreait/firebase-bundle)
[![Build Status](https://travis-ci.org/kreait/firebase-bundle.svg?branch=master)](https://travis-ci.org/kreait/firebase-bundle)
[![GitHub license](https://img.shields.io/github/license/kreait/firebase-bundle.svg)](https://github.com/kreait/firebase-bundle/blob/master/LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/kreait/firebase-bundle.svg)]()
[![Gitter](https://badges.gitter.im/kreait/firebase-php.svg)](https://gitter.im/kreait/firebase-php)

---

## Installation

Add the bundle using [Composer](https://getcomposer.org)

```bash
composer require kreait/firebase-bundle ^1.0
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
### Configuration

```yaml
# app/config/config.yml (Symfony without Flex)
# config/packages/firebase.yaml (Symfony with Flex)
kreait_firebase:
    projects:
        # You can access your firebase project with
        # $container->get('kreait_firebase.first')
        first:
            # Optional: If set to false, the service and its alias
            # can only be used via dependency injection
            public: true
            # Optional: If set to true, this project is used when
            # using Kreait\Firebase as a type hint for dependency injection
            default: false
            # Optional: Path to the projects Service Account credentials file
            # If omitted, the library will try to discover it.
            credentials: '%kernel.project_dir%/config/service_account_credentials.json'
            # You can find the database URI at 
            # https://console.firebase.google.com/project/first/database/data
            database_uri: 'https://my-project.firebaseio.com'
            # Optional: If set, you can access your project with
            # $container->get('firebase') 
            alias: 'firebase'
        second: # $container->get('kreait_firebase.second')
            database_uri: 'https://second.firebaseio.com'
        third: # $container->get('kreait_firebase.third')
            ...
        
```

## Support

For bug reports and feature requests, use the [issue tracker](https://github.com/kreait/firebase-bundle/issues/).

For help with and discussion about the PHP SDK and Bundle, join the [Gitter Channel dedicated to this library](https://gitter.im/kreait/firebase-php).

For questions about Firebase in general, use [Stack Overflow](https://stackoverflow.com/questions/tagged/firebase) or join the [Firebase Slack Community](https://firebase.community).
