<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\Tests\DependencyInjection\Factory;

use Kreait\Firebase\Factory as FirebaseFactory;
use Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory\ProjectFactory;
use PHPUnit\Framework\TestCase;

class ProjectFactoryTest extends TestCase
{
    /**
     * @var ProjectFactory
     */
    private $factory;

    /**
     * @var FirebaseFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $firebaseFactory;

    protected function setUp()
    {
        $this->firebaseFactory = $this->createMock(FirebaseFactory::class);
        $this->factory = new ProjectFactory($this->firebaseFactory);
    }

    /**
     * @test
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
     */
    public function it_can_handle_an_api_key()
    {
        $this->firebaseFactory
            ->expects($this->once())
            ->method('withApiKey')
            ->with('foo');

        $this->factory->create(['api_key' => 'foo']);
    }
}
