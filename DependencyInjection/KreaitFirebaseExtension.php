<?php

namespace Kreait\FirebaseBundle\DependencyInjection;

use Kreait\Firebase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class KreaitFirebaseExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->processConnections($config['connections'], $container);
    }

    /**
     * {@inheritdoc}
     */
    protected function processConnections(array $connectionsConfig, ContainerBuilder $container)
    {
        foreach ($connectionsConfig as $name => $connection) {
            $connectionDefinition = new Definition();
            $connectionDefinition->setClass('Kreait\Firebase\Firebase');

            $firebaseConfigDefinition = new Definition();
            $firebaseConfigDefinition->setClass('Kreait\Firebase\Configuration');

            $baseUrl = $connection['scheme'] . '://' . $connection['host'];

            if(array_key_exists('secret',$connection)) {
                $firebaseConfigDefinition->addMethodCall('setFirebaseSecret', [$connection['secret']]);
            }

            $connectionDefinition->setArguments(array($baseUrl, $firebaseConfigDefinition));
            $connectionServiceId = 'kreait_firebase.connection.' . $name;

            $container->setDefinition($connectionServiceId, $connectionDefinition);

            if (!empty($connection['references'])) {
                $this->processReferences($connectionServiceId, $connection['references'], $container);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function processReferences($connectionServiceId, array $referencesConfig, ContainerBuilder $container)
    {
        foreach ($referencesConfig as $key => $value) {
            $referenceDefinition = new Definition();
            $referenceDefinition->setClass('Kreait\Firebase\Reference');
            $referenceDefinition->setArguments(array(
                new Reference($connectionServiceId),
                $value
            ));

            $container->setDefinition('kreait_firebase.reference.' . $key, $referenceDefinition);
        }
    }

}
