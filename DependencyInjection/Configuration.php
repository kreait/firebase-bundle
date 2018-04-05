<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $root = $builder->root($this->name);

        $root
            ->fixXmlConfig('project')
            ->children()
                ->arrayNode('projects')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('public')->defaultTrue()->end()
                            ->scalarNode('database_uri')->end()
                            ->scalarNode('alias')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
