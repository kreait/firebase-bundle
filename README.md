# Firebase SDK Bundle

A Symfony Bundle for the [Firebase PHP SDK](https://github.com/kreait/firebase-php).

## WORK IN PROGRESS

The bundle will already work if your service account JSON file can be
auto discovered,
see http://firebase-php.readthedocs.io/en/stable/setup.html#with-autodiscovery .

---

## Installation

Add the bundle using [Composer](https://getcomposer.org)

```bash
composer require kreait/firebase-bundle 1.0.x-dev
```

```php
// in %kernel.root_dir%/AppKernel.php
$bundles = array(
    // ...
    new Kreait\Firebase\Symfony\Bundle\FirebaseBundle(),
    // ...
);
```
### Configuration

```yaml
kreait_firebase:
    projects:
        # You can access your firebase project with
        # $container->get('kreait_firebase.first')
        first:
            # Optional: If set to false, the service and its alias
            # can only be used via dependency injection
            public: true
            # You can find the database URI at 
            # https://console.firebase.google.com/project/first/database/data
            database_uri: 'https://first.firebaseio.com'
            # Optional: If set, you can access your project with
            # $container->get('firebase') 
            alias: 'firebase'
        second: # $container->get('kreait_firebase.second')
            database_uri: 'https://second.firebaseio.com'
        third: # $container->get('kreait_firebase.third')
            ...
        
```
