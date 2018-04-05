<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\Tests\DependencyInjection;

use Kreait\Firebase\Symfony\Bundle\DependencyInjection\FirebaseExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FirebaseExtensionTest extends TestCase
{
    /**
     * @var FirebaseExtension
     */
    private $extension;

    protected function setUp()
    {
        $this->extension = new FirebaseExtension();
    }

    /**
     * @test
     */
    public function a_project_can_have_an_alias()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'alias' => 'bar',
                ],
            ],
        ]);

        $this->assertSame($container->get($this->extension->getAlias().'.foo'), $container->get('bar'));
    }

    /**
     * @test
     */
    public function a_project_can_be_private()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [
                    'alias' => 'bar',
                    'public' => false
                ],
            ],
        ]);

        $this->assertFalse($container->has($this->extension->getAlias().'.foo'));
        $this->assertFalse($container->has('bar'));
    }

    /**
     * @test
     */
    public function it_can_provide_multiple_projects()
    {
        $container = $this->createContainer([
            'projects' => [
                'foo' => [],
                'bar' => [],
            ],
        ]);

        $this->assertTrue($container->hasDefinition($this->extension->getAlias().'.foo'));
        $this->assertTrue($container->hasDefinition($this->extension->getAlias().'.bar'));
    }

    protected function createContainer(array $config = [])
    {
        $container = new ContainerBuilder();

        $this->extension->load([$this->extension->getAlias() => $config], $container);

        $container->compile();

        return $container;
    }
}
