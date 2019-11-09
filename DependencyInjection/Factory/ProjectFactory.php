<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory;

use Kreait\Firebase;
use Kreait\Firebase\Factory;

class ProjectFactory
{
    /**
     * @var Factory
     */
    private $firebaseFactory;

    public function __construct(Factory $firebaseFactory)
    {
        $this->firebaseFactory = $firebaseFactory;
    }

    /**
     * @param array $config
     *
     * @return Factory
     */
    public function createFactory(array $config = []): Factory
    {
        $factory = clone $this->firebaseFactory; // Ensure a new instance

        if ($config['credentials'] ?? null) {
            $serviceAccount = Firebase\ServiceAccount::fromValue($config['credentials']);
            $factory = $factory
                ->withServiceAccount($serviceAccount)
                ->withDisabledAutoDiscovery();
        }

        if ($config['database_uri'] ?? null) {
            $factory = $factory->withDatabaseUri($config['database_uri']);
        }

        return $factory;
    }

    /**
     * @param array $config
     *
     * @return Firebase
     *
     * @deprecated use the component-specific create*() methods instead
     * @see createAuth()
     * @see createDatabase()
     * @see createFirestore()
     * @see createMessaging()
     * @see createRemoteConfig()
     * @see createStorage()
     */
    public function create(array $config = []): Firebase
    {
        $factory = $this->createFactory($config);

        return $factory->create();
    }

    /**
     * @param array $config
     *
     * @return Firebase\Auth
     */
    public function createAuth(array $config = []): Firebase\Auth
    {
        $factory = $this->createFactory($config);

        return $factory->createAuth();
    }

    /**
     * @param array $config
     *
     * @return Firebase\Database
     */
    public function createDatabase(array $config = []): Firebase\Database
    {
        $factory = $this->createFactory($config);

        return $factory->createDatabase();
    }

    /**
     * @param array $config
     *
     * @return Firebase\Firestore
     */
    public function createFirestore(array $config = []): Firebase\Firestore
    {
        $factory = $this->createFactory($config);

        return $factory->createFirestore();
    }

    /**
     * @param array $config
     *
     * @return Firebase\Messaging
     */
    public function createMessaging(array $config = []): Firebase\Messaging
    {
        $factory = $this->createFactory($config);

        return $factory->createMessaging();
    }

    /**
     * @param array $config
     *
     * @return Firebase\RemoteConfig
     */
    public function createRemoteConfig(array $config = []): Firebase\RemoteConfig
    {
        $factory = $this->createFactory($config);

        return $factory->createRemoteConfig();
    }

    /**
     * @param array $config
     *
     * @return Firebase\Storage
     */
    public function createStorage(array $config = []): Firebase\Storage
    {
        $factory = $this->createFactory($config);

        return $factory->createStorage();
    }
}
