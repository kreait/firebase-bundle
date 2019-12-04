<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Psr\SimpleCache\CacheInterface;

class ProjectFactory
{
    /** @var Factory */
    private $firebaseFactory;

    /** @var CacheInterface|null */
    private $verifierCache;

    public function __construct(Factory $firebaseFactory)
    {
        $this->firebaseFactory = $firebaseFactory;
    }

    public function setVerifierCache(CacheInterface $verifierCache = null)
    {
        $this->verifierCache = $verifierCache;
    }

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

        if ($this->verifierCache) {
            $factory = $factory->withVerifierCache($this->verifierCache);
        }

        return $factory;
    }

    public function create(array $config = []): Firebase
    {
        return $this->createFactory($config)->create();
    }

    public function createAuth(array $config = []): Firebase\Auth
    {
        return $this->createFactory($config)->createAuth();
    }

    public function createDatabase(array $config = []): Firebase\Database
    {
        return $this->createFactory($config)->createDatabase();
    }

    public function createFirestore(array $config = []): Firebase\Firestore
    {
        return $this->createFactory($config)->createFirestore();
    }

    public function createMessaging(array $config = []): Firebase\Messaging
    {
        return $this->createFactory($config)->createMessaging();
    }

    public function createRemoteConfig(array $config = []): Firebase\RemoteConfig
    {
        return $this->createFactory($config)->createRemoteConfig();
    }

    public function createStorage(array $config = []): Firebase\Storage
    {
        return $this->createFactory($config)->createStorage();
    }
}
