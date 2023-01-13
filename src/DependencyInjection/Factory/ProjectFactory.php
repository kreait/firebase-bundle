<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Adapter\Psr16Adapter;

class ProjectFactory
{
    private Factory $firebaseFactory;
    private ?CacheItemPoolInterface $verifierCache = null;
    private ?CacheItemPoolInterface $authTokenCache = null;
    private ?LoggerInterface $httpRequestLogger = null;
    private ?LoggerInterface $httpRequestDebugLogger = null;

    public function __construct()
    {
        $this->firebaseFactory = new Factory();
    }

    /**
     * @param CacheInterface|CacheItemPoolInterface $verifierCache
     */
    public function setVerifierCache($verifierCache = null): void
    {
        if ($verifierCache instanceof CacheInterface) {
            $verifierCache = new Psr16Adapter($verifierCache);
        }

        $this->verifierCache = $verifierCache;
    }

    /**
     * @param CacheInterface|CacheItemPoolInterface|null $authTokenCache
     */
    public function setAuthTokenCache($authTokenCache = null): void
    {
        if ($authTokenCache instanceof CacheInterface) {
            $authTokenCache = new Psr16Adapter($authTokenCache);
        }

        $this->authTokenCache = $authTokenCache;
    }

    public function setHttpRequestLogger(?LoggerInterface $logger = null): void
    {
        $this->httpRequestLogger = $logger;
    }

    public function setHttpRequestDebugLogger(?LoggerInterface $logger = null): void
    {
        $this->httpRequestDebugLogger = $logger;
    }

    public function createAuth(array $config = []): Firebase\Contract\Auth
    {
        return $this->createFactory($config)->createAuth();
    }

    public function createFactory(array $config = []): Factory
    {
        $factory = clone $this->firebaseFactory; // Ensure a new instance

        if ($config['credentials'] ?? null) {
            $factory = $factory->withServiceAccount($config['credentials']);
        }

        if ($config['database_uri'] ?? null) {
            $factory = $factory->withDatabaseUri($config['database_uri']);
        }

        if ($config['tenant_id'] ?? null) {
            $factory = $factory->withTenantId($config['tenant_id']);
        }

        if ($this->verifierCache) {
            $factory = $factory->withVerifierCache($this->verifierCache);
        }

        if ($this->authTokenCache) {
            $factory = $factory->withAuthTokenCache($this->authTokenCache);
        }

        if ($this->httpRequestLogger) {
            $factory = $factory->withHttpLogger($this->httpRequestLogger);
        }

        if ($this->httpRequestDebugLogger) {
            $factory = $factory->withHttpDebugLogger($this->httpRequestDebugLogger);
        }

        return $factory;
    }

    public function createDatabase(array $config = []): Firebase\Contract\Database
    {
        return $this->createFactory($config)->createDatabase();
    }

    public function createFirestore(array $config = []): Firebase\Contract\Firestore
    {
        return $this->createFactory($config)->createFirestore();
    }

    public function createMessaging(array $config = []): Firebase\Contract\Messaging
    {
        return $this->createFactory($config)->createMessaging();
    }

    public function createRemoteConfig(array $config = []): Firebase\Contract\RemoteConfig
    {
        return $this->createFactory($config)->createRemoteConfig();
    }

    public function createStorage(array $config = []): Firebase\Contract\Storage
    {
        return $this->createFactory($config)->createStorage();
    }

    public function createDynamicLinksService(array $config = []): Firebase\Contract\DynamicLinks
    {
        $defaultDynamicLinksDomain = $config['default_dynamic_links_domain'] ?? null;

        return $this->createFactory($config)->createDynamicLinksService($defaultDynamicLinksDomain);
    }
}
