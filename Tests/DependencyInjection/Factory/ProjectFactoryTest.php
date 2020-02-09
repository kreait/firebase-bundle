<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\Tests\DependencyInjection\Factory;

use Kreait\Firebase\Factory as FirebaseFactory;
use Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory\ProjectFactory;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

class ProjectFactoryTest extends TestCase
{
    /** @var ProjectFactory */
    private $factory;

    private $firebaseFactory;

    protected function setUp()
    {
        $this->firebaseFactory = $this->createMock(FirebaseFactory::class);
        $this->factory = new ProjectFactory($this->firebaseFactory);
    }

    /**
     * @test
     * @group legacy
     * @expectedDeprecation The %s method is deprecated (4.33 Use the component-specific create*() methods instead.).
     */
    public function it_can_handle_a_custom_database_uri()
    {
        $this->firebaseFactory
            ->expects($this->once())
            ->method('withDatabaseUri')
            ->with('http://domain.tld');

        $this->factory->create(['database_uri' => 'http://domain.tld']);
    }

    /**
     * @test
     * @group legacy
     * @expectedDeprecation The %s method is deprecated (4.33 Use the component-specific create*() methods instead.).
     */
    public function it_can_handle_a_credentials_path()
    {
        $this->firebaseFactory
            ->expects($this->once())
            ->method('withServiceAccount');

        $this->factory->create(['credentials' => __DIR__.'/../../_fixtures/valid_credentials.json']);
    }

    /**
     * @test
     * @group legacy
     * @expectedDeprecation The %s method is deprecated (4.33 Use the component-specific create*() methods instead.).
     */
    public function it_can_handle_a_credentials_string()
    {
        $this->firebaseFactory
            ->expects($this->once())
            ->method('withServiceAccount');

        $credentials = file_get_contents(__DIR__.'/../../_fixtures/valid_credentials.json');

        $this->factory->create(['credentials' => $credentials]);
    }

    /**
     * @test
     * @group legacy
     * @expectedDeprecation The %s method is deprecated (4.33 Use the component-specific create*() methods instead.).
     */
    public function it_can_handle_a_credentials_array()
    {
        $this->firebaseFactory
            ->expects($this->once())
            ->method('withServiceAccount');

        $credentials = json_decode(file_get_contents(__DIR__.'/../../_fixtures/valid_credentials.json'), true);

        $this->factory->create(['credentials' => $credentials]);
    }

    /**
     * @test
     * @group legacy
     * @expectedDeprecation The %s method is deprecated (4.33 Use the component-specific create*() methods instead.).
     */
    public function it_accepts_a_verifier_cache()
    {
        $cache = $this->createMock(CacheInterface::class);

        $this->firebaseFactory
            ->expects($this->once())
            ->method('withVerifierCache')
            ->with($cache);

        $this->factory->setVerifierCache($cache);
        $this->factory->create([]);
    }
}
