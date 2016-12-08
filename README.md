#Firebase Symfony2 Bundle

A Symfony2 Bundle for the [Firebase PHP client](https://github.com/kreait/firebase-php).

## This project is abandoned and not longer maintained.

Please use the kreait/firebase-php library ([Packagist](https://packagist.org/packages/kreait/firebase-php)/
[Github](https://github.com/kreait/firebase-php)) directly and refer to the library's
[Using this library (version 1.x) with Symfony](https://github.com/kreait/firebase-php/blob/69496a13084710ff36d693439297e778dde178f0/doc/symfony.md)
documentation page to find out how you can migrate your application (it's easy, promised :)).

---

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

To use authentication, you need to set the Firebase secret in your configuration.

Then, in your code, you can authenticate a request like this:

```php
$firebase       = $this->container->get('kreait_firebase.connection.main');
$tokenGenerator = $firebase->getConfiguration()->getAuthTokenGenerator();

$adminToken     = $tokenGenerator->createAdminToken();

$firebase->setAuthToken($adminToken);
```

This procedure is quite cumbersome at the moment, but will be made more conveniant in an upcoming release.
