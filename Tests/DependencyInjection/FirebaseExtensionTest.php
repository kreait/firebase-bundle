<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\Tests\DependencyInjection;

use Kreait\Firebase;
use Kreait\Firebase\Symfony\Bundle\DependencyInjection\FirebaseExtension;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use stdClass;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use TypeError;

class FirebaseExtensionTest extends TestCase
{
    /** @var FirebaseExtension */
    private $extension;

    protected function setUp()
    {
        $this->extension = new FirebaseExtension();
    }

    /** @test */
    public function a_project_is_created_with_a_service_for_each_feature()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
            ],
        ]);

        $this->assertInstanceOf(Firebase::class, $container->get($this->extension->getAlias().'.foo'));
        $this->assertInstanceOf(Firebase::class, $container->get(Firebase::class));

        $this->assertInstanceOf(Firebase\Database::class, $container->get($this->extension->getAlias().'.foo.database'));
        $this->assertInstanceOf(Firebase\Database::class, $container->get(Firebase\Database::class));

        $this->assertInstanceOf(Firebase\Auth::class, $container->get($this->extension->getAlias().'.foo.auth'));
        $this->assertInstanceOf(Firebase\Auth::class, $container->get(Firebase\Auth::class));

        $this->assertInstanceOf(Firebase\Storage::class, $container->get($this->extension->getAlias().'.foo.storage'));
        $this->assertInstanceOf(Firebase\Storage::class, $container->get(Firebase\Storage::class));

        $this->assertInstanceOf(Firebase\RemoteConfig::class, $container->get($this->extension->getAlias().'.foo.remote_config'));
        $this->assertInstanceOf(Firebase\RemoteConfig::class, $container->get(Firebase\RemoteConfig::class));

        $this->assertInstanceOf(Firebase\Messaging::class, $container->get($this->extension->getAlias().'.foo.messaging'));
        $this->assertInstanceOf(Firebase\Messaging::class, $container->get(Firebase\Messaging::class));

        $this->assertInstanceOf(Firebase\DynamicLinks::class, $container->get($this->extension->getAlias().'.foo.dynamic_links'));
        $this->assertInstanceOf(Firebase\DynamicLinks::class, $container->get(Firebase\DynamicLinks::class));
    }

    /** @test */
    public function a_verifier_cache_can_be_used()
    {
        $cacheServiceId = 'cache.app.simple.mock';

        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                    'verifier_cache' => $cacheServiceId,
                ],
            ],
        ]);
        $cache = $this->createMock(CacheInterface::class);
        $container->set($cacheServiceId, $cache);

        $container->get(Firebase\Auth::class);
        $this->addToAssertionCount(1);
    }

    /** @test */
    public function an_invalid_verifier_cache_can_not_be_used()
    {
        $cacheServiceId = 'invalid_cache_service';

        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                    'verifier_cache' => $cacheServiceId,
                ],
            ],
        ]);
        $invalidCache = $this->createMock(stdClass::class);
        $container->set($cacheServiceId, $invalidCache);

        $this->expectException(TypeError::class);
        $container->get(Firebase\Auth::class);
    }

    /** @test */
    public function a_non_existing_verifier_cache_can_not_be_used()
    {
        $cacheServiceId = 'nonexisting';

        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                    'verifier_cache' => $cacheServiceId,
                ],
            ],
        ]);

        $this->expectException(ServiceNotFoundException::class);
        $container->get(Firebase\Auth::class);
    }

    /** @test */
    public function a_project_can_have_an_alias()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                    'alias' => 'bar',
                ],
            ],
        ]);

        $this->assertSame($container->get($this->extension->getAlias().'.foo'), $container->get('bar'));
    }

    /** @test */
    public function a_project_can_be_private()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                    'alias' => 'bar',
                    'public' => false,
                ],
            ],
        ]);
        $container->compile();

        $this->assertFalse($container->has($this->extension->getAlias().'.foo'));
        $this->assertFalse($container->has('bar'));
    }

    /** @test */
    public function it_can_provide_multiple_projects()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
                'bar' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
            ],
        ]);

        $this->assertTrue($container->hasDefinition($this->extension->getAlias().'.foo'));
        $this->assertTrue($container->hasDefinition($this->extension->getAlias().'.bar'));
    }

    /** @test */
    public function it_supports_specifying_credentials()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
            ],
        ]);

        $this->assertTrue($container->hasDefinition($this->extension->getAlias().'.foo'));
    }

    /** @test */
    public function it_accepts_only_one_default_project()
    {
        $this->expectException(InvalidConfigurationException::class);

        $this->createContainer([
            'projects' => [
                'foo' => [
                    'default' => true,
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
                'bar' => [
                    'default' => true,
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
            ],
        ]);
    }

    /** @test */
    public function it_aliases_the_firebase_class_to_the_default_project()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
                'bar' => [
                    'default' => true,
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
            ],
        ], $makeServicesPublic = true);

        $this->assertTrue($container->hasAlias(Firebase::class));
    }

    /** @test */
    public function it_aliases_the_firebase_class_to_the_only_project()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
            ],
        ], $makeServicesPublic = true);

        $this->assertTrue($container->hasAlias(Firebase::class));
    }

    /** @test */
    public function it_has_no_default_project_if_none_could_be_determined()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
                'bar' => [
                    'credentials' => __DIR__.'/../_fixtures/valid_credentials.json',
                ],
            ],
        ], $makeServicesPublic = true);

        $this->assertFalse($container->hasAlias(Firebase::class));
    }

    private function createContainer(array $config = [], $makeServicesPublic = false): ContainerBuilder
    {
        $container = new ContainerBuilder();

        // Make all services public just for testing
        if ($makeServicesPublic) {
            $container->addCompilerPass(new class() implements CompilerPassInterface {
                public function process(ContainerBuilder $container)
                {
                    array_map(static function (Definition $definition) {
                        $definition->setPublic(true);
                    }, $container->getDefinitions());

                    array_map(static function (Alias $alias) {
                        $alias->setPublic(true);
                    }, $container->getAliases());
                }
            });
        }

        $this->extension->load([$this->extension->getAlias() => $config], $container);

        return $container;
    }
}
