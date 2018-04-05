<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\DependencyInjection;

use Kreait\Firebase;
use Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory\ProjectFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class FirebaseExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('firebase.xml');

        foreach ($config['projects'] ?? [] as $projectName => $projectConfiguration) {
            $this->processProjectConfiguration($projectName, $projectConfiguration, $container);
        }
    }

    private function processProjectConfiguration($name, array $config, ContainerBuilder $container)
    {
        $projectServiceId = sprintf('%s.%s', $this->getAlias(), $name);

        $container->register($projectServiceId, Firebase::class)
            ->setFactory([new Reference(ProjectFactory::class), 'create'])
            ->addArgument($config)
            ->setPublic(true);

        if ($config['alias'] ?? null) {
            $alias = $container->setAlias($config['alias'], $projectServiceId);
            $alias->setPublic(true);
        }
    }

    public function getAlias()
    {
        return 'kreait_firebase';
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($this->getAlias());
    }
}
