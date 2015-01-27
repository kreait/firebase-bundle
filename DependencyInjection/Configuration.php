<?php

namespace Kreait\FirebaseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kreait_firebase');

        $rootNode->children()
            ->append($this->addConnectionsNode());

        return $treeBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function addConnectionsNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('connections');

        $node
            ->isRequired()
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('connection')
            ->prototype('array')
                ->children()
                    ->scalarNode('scheme')->defaultValue('https')->end()
                    ->scalarNode('adapter')->end()
                    ->scalarNode('host')->isRequired()->end()
                    ->append($this->addReferencesNode())
                ->end()
            ->end();

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    public function addReferencesNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('references');

        $node
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->prototype('scalar');

        return $node;
    }
}
