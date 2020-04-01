<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder($this->name);

        if (\method_exists($builder, 'getRootNode')) {
            $root = $builder->getRootNode();
        } else {
            $root = $builder->root($this->name);
        }

        $root
            ->fixXmlConfig('project')
            ->children()
                ->arrayNode('projects')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->variableNode('credentials')
                                ->info('Path to the project\'s Service Account credentials file or the json/array credentials parameters. If omitted, the credentials will be auto-dicovered as described in https://firebase-php.readthedocs.io/en/stable/setup.html#with-autodiscovery')
                                ->example('%kernel.project_dir%/config/my_project_credentials.json or credentials: type ..')
                                ->validate()
                                    ->ifTrue(static function ($v) {return !\is_string($v) && !\is_array($v); })
                                    ->thenInvalid('Service Account credentials must be provided as a path to the project\'s credentials file, as a JSON encoded string or as an array')
                                ->end()
                            ->end()
                            ->scalarNode('public')
                                ->defaultTrue()
                                ->info('If set to false, the service and its alias can only be used via dependency injection, and not be retrieved from the container directly.')
                            ->end()
                            ->scalarNode('default')
                                ->defaultNull()
                                ->info('If set to true, this project will be used when type hinting the component classes of the Firebase SDK, e.g. Kreait\\Firebase\\Auth, Kreait\\Firebase\\Database, Kreait\\Firebase\\Messaging, etc.')
                            ->end()
                            ->scalarNode('database_uri')
                                ->example('https://my-project.firebaseio.com')
                                ->info('Should only be used if the URL of your Realtime Database can not be generated with the project id of the given Service Account')
                            ->end()
                            ->scalarNode('default_dynamic_links_domain')
                                ->example('https://my-project.page.link')
                                ->info('The default domain for dynamic links')
                            ->end()
                                ->scalarNode('verifier_cache')
                                ->defaultNull()
                                ->example('cache.app.simple')
                                ->info('Used to cache Google\'s public keys. Must implement \\Psr\\SimpleCache\\CacheInterface (PSR-16)')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
