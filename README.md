#Firebase Symfony2 Bundle

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8d6e529b-ec74-4bfb-8892-4ef1e21a76f0/mini.png)](https://insight.sensiolabs.com/projects/8d6e529b-ec74-4bfb-8892-4ef1e21a76f0)

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

## Confuguration

Following configuration

```
kreait_firebase:
  connections:
    main:
      scheme: https
      host: prefix-suffix-1234.firebaseio.com
      references:
        users: data/users
        images: data/images
```

will automagically register the following services 

  - kreait_firebase.connection.main (instance of Kreait\Firebase\Firebase)
  - kreait_firebase.reference.users (instance of Kreait\Firebase\Reference)
  - kreait_firebase.reference.images (instance of Kreait\Firebase\Reference)


## Usage

### Basic commands

```php
$firebase = $this->container->get('kreait_firebase.connection.main');

$firebase->set(['name' => 'John Doe', 'email' => 'john@doh.com'], 'data/users/john');
$firebase->update(['email' => 'john@doe.com'], 'data/users/john');
$firebase->push(['name' => 'Jane Doe', 'email' => 'jane@doe.com'], 'data/users');
$firebase->delete('data/users/john');
$firebase->get('data/users');
$firebase->get('data/users', ['shallow' => true]); // Limit the depth of the data received

```

### References

```php
$users = $this->container->get('kreait_firebase.reference.users');

$users->set(['name' => 'Jack Doe', 'email' => 'jack@doh.com'], 'jack');
$users->update(['email' => 'jack@doe.com'], 'jack');
$users->push(['name' => 'Jane Doe', 'email' => 'jane@doe.com']);
$users->delete('jack');
$users->delete();
```
