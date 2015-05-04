#Firebase Symfony2 Bundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8d6e529b-ec74-4bfb-8892-4ef1e21a76f0/mini.png)](https://insight.sensiolabs.com/projects/8d6e529b-ec74-4bfb-8892-4ef1e21a76f0)
[![Packagist](https://img.shields.io/packagist/v/kreait/firebase-bundle.svg?style=flat-square)](https://packagist.org/packages/kreait/firebase-bundle)
[![Packagist](https://img.shields.io/packagist/l/kreait/firebase-bundle.svg?style=flat-square)](https://github.com/kreait/firebase-bundle/blob/master/LICENSE)
[![Code Coverage](https://scrutinizer-ci.com/g/kreait/firebase-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/kreait/firebase-bundle/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kreait/firebase-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kreait/firebase-bundle/?branch=master)
[![Build Status](https://travis-ci.org/kreait/firebase-bundle.svg?branch=master)](https://travis-ci.org/kreait/firebase-bundle)

A Symfony2 Bundle for the [Firebase PHP client](https://github.com/kreait/firebase-php).

## Installation

### Download the bundle

Execute the following from the project root directory

```
  composer require kreait/firebase-bundle
```

### Enable the bundle

Then, enable the bundle by adding the following line in the `app/AppKernel.php file of your project:

```php
// app/AppKernel.php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Kreait\FirebaseBundle\KreaitFirebaseBundle(),
        );

        // ...
    }
}
```

### Add minimal configuration

Add the following to `app/config/config.yml`

```
kreait_firebase:
  connections:
    main:
      host: prefix-suffix-1234.firebaseio.com
```

Setup complete!

## Configuration

Following configuration

```
kreait_firebase:
  connections:
    main:
      scheme: https
      host: prefix-suffix-1234.firebaseio.com
      secret: <your firebase secret>
      references:
        users: data/users
        images: data/images
```

will automagically register the following services 

  - kreait_firebase.connection.main (instance of Kreait\Firebase\Firebase)
  - kreait_firebase.reference.users (instance of Kreait\Firebase\Reference)
  - kreait_firebase.reference.images (instance of Kreait\Firebase\Reference)


## Usage

Please see [https://github.com/kreait/firebase-php#documentation](https://github.com/kreait/firebase-php#documentation)
for the full documentation

### Retrieving a Firebase connection

```php
$firebase = $this->container->get('kreait_firebase.connection.main');
```

### Retrieving a Firebase Reference

```php
$users = $this->container->get('kreait_firebase.reference.users');
```

### Authentication

To use authentication, you have to include the firebase token generator into your project

```
composer require firebase/token-generator
```

You also need to set the Firebase secret in your configuration.

Then, in your code, you can authenticate a request like this:

```php
$firebase       = $this->container->get('kreait_firebase.connection.main');
$tokenGenerator = $firebase->getConfiguration()->getAuthTokenGenerator();

$adminToken     = $tokenGenerator->createAdminToken();

$firebase->setAuthToken($adminToken);
```

This procedure is quite cumbersome at the moment, but will be made more conveniant in an upcoming release.
