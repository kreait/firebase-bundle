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
                            ->scalarNode('credentials')
                                ->info('Path to the Google Service Account credentials file for this project.')
                                ->example('%kernel.project_dir%/config/credentials.json')
                            ->end()
                            ->scalarNode('public')
                                ->defaultTrue()
                                ->info('If set to false, the service and its alias can only be used via dependency injection')
                            ->end()
                            ->scalarNode('database_uri')
                                ->example('https://my-project.firebaseio.com')
                                ->info('You can find the database URI in the project settings in the Firebase console')
                            ->end()
                            ->scalarNode('alias')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
