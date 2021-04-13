<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\Tests\DependencyInjection\Factory;

use Kreait\Firebase\Factory as FirebaseFactory;
use Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory\ProjectFactory;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * @internal
 */
class ProjectFactoryTest extends TestCase
{
    /** @var ProjectFactory */
    private $factory;

    private $firebaseFactory;

    protected function setUp(): void
    {
        $this->firebaseFactory = $this->createMock(FirebaseFactory::class);
        $this->factory = new ProjectFactory($this->firebaseFactory);
    }

    /**
     * @test
     */
    public function it_can_handle_a_custom_database_uri(): void
    {
        $this->firebaseFactory
            ->expects($this->once())
            ->method('withDatabaseUri')
            ->with('http://domain.tld');

        $this->factory->createDatabase(['database_uri' => 'http://domain.tld']);
    }

    /**
     * @test
     */
    public function it_can_handle_a_credentials_path(): void
    {
        $this->firebaseFactory
            ->expects($this->once())
            ->method('withServiceAccount');

        $this->factory->createAuth(['credentials' => __DIR__.'/../../_fixtures/valid_credentials.json']);
    }

    /**
     * @test
     */
    public function it_can_handle_a_credentials_string(): void
    {
        $this->firebaseFactory
            ->expects($this->once())
            ->method('withServiceAccount');

        $credentials = \file_get_contents(__DIR__.'/../../_fixtures/valid_credentials.json');

        $this->factory->createAuth(['credentials' => $credentials]);
    }

    /**
     * @test
     */
    public function it_can_handle_a_credentials_array(): void
    {
        $this->firebaseFactory
            ->expects($this->once())
            ->method('withServiceAccount');

        $credentials = \json_decode(\file_get_contents(__DIR__.'/../../_fixtures/valid_credentials.json'), true);

        $this->factory->createAuth(['credentials' => $credentials]);
    }

    /**
     * @test
     */
    public function it_can_handle_a_tenant_id(): void
    {
        $this->firebaseFactory
            ->expects($this->once())
            ->method('withTenantId')
            ->with('tenant-id');

        $this->factory->createAuth(['tenant_id' => 'tenant-id']);
    }

    /**
     * @test
     */
    public function it_accepts_a_PSR16_verifier_cache(): void
    {
        $cache = $this->createMock(CacheInterface::class);

        $this->firebaseFactory
            ->expects($this->once())
            ->method('withVerifierCache')
            ->with($cache);

        $this->factory->setVerifierCache($cache);
        $this->factory->createAuth();
    }

    /**
     * @test
     */
    public function it_accepts_a_PSR6_verifier_cache(): void
    {
        $cache = $this->createMock(CacheItemPoolInterface::class);

        $this->firebaseFactory
            ->expects($this->once())
            ->method('withVerifierCache')
            ->with($this->isInstanceOf(CacheInterface::class));

        $this->factory->setVerifierCache($cache);
        $this->factory->createAuth();
    }
}
