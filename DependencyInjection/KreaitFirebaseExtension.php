<?php

namespace Kreait\FirebaseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

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

        foreach ($config['connections'] as $name => $connection) {
            $connectionDefinition = new Definition();
            $connectionDefinition->setClass('Kreait\Firebase\Firebase');
            $connectionDefinition->setArguments(array($connection['scheme'] . '://' . $connection['host']));
            $connectionServiceId = 'kreait_firebase.connection.' . $name;

            $container->setDefinition($connectionServiceId, $connectionDefinition);

            if (!empty($connection['references'])) {
                foreach ($connection['references'] as $key => $value) {
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
    }
}
