<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\DependencyInjection;

use Kreait\Firebase;
use Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory\ProjectFactory;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Throwable;

class FirebaseExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     *
     * @throws Throwable
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('firebase.xml');

        $projectConfigurations = $config['projects'] ?? [];
        $projectConfigurationsCount = count($projectConfigurations);

        $this->assertThatOnlyOneDefaultProjectExists($projectConfigurations);

        foreach ($projectConfigurations as $projectName => $projectConfiguration) {
            if (1 === $projectConfigurationsCount) {
                $projectConfiguration['default'] = $projectConfiguration['default'] ?? true;
            }

            $this->processProjectConfiguration($projectName, $projectConfiguration, $container);
        }
    }

    private function processProjectConfiguration(string $name, array $config, ContainerBuilder $container)
    {
        $this->registerService($name.'.database', $config, Firebase\Database::class, $container, 'createDatabase');
        $this->registerService($name.'.auth', $config, Firebase\Auth::class, $container, 'createAuth');
        $this->registerService($name.'.storage', $config, Firebase\Storage::class, $container, 'createStorage');
        $this->registerService($name.'.remote_config', $config, Firebase\RemoteConfig::class, $container, 'createRemoteConfig');
        $this->registerService($name.'.messaging', $config, Firebase\Messaging::class, $container, 'createMessaging');
        $this->registerService($name.'.firestore', $config, Firebase\Firestore::class, $container, 'createFirestore');
        $this->registerService($name, $config, Firebase::class, $container, 'create');
    }

    public function getAlias(): string
    {
        return 'kreait_firebase';
    }

    public function getConfiguration(array $config, ContainerBuilder $container): Configuration
    {
        return new Configuration($this->getAlias());
    }

    private function registerService(string $name, array $config, string $class, ContainerBuilder $container, string $method = 'create'): string
    {
        $projectServiceId = sprintf('%s.%s', $this->getAlias(), $name);
        $isPublic = $config['public'];

        $factory = $container->getDefinition(ProjectFactory::class);

        if ($config['verifier_cache'] ?? null) {
            $factory->addMethodCall('setVerifierCache', [new Reference($config['verifier_cache'])]);
        }

        $container->register($projectServiceId, $class)
            ->setFactory([$factory, $method])
            ->addArgument($config)
            ->setPublic($isPublic);

        if ($config['alias'] ?? null) {
            $container->setAlias($config['alias'], $projectServiceId);
            $container->getAlias($config['alias'])->setPublic($isPublic);
        }

        if ($config['default'] ?? false) {
            $container->setAlias($class, $projectServiceId);
            $container->getAlias($class)->setPublic($isPublic);
        }

        return $projectServiceId;
    }

    private function assertThatOnlyOneDefaultProjectExists(array $projectConfigurations)
    {
        $count = 0;

        foreach ($projectConfigurations as $projectConfiguration) {
            if ($projectConfiguration['default'] ?? false) {
                ++$count;
            }

            if ($count > 1) {
                throw new InvalidConfigurationException('Only one project can be set as default.');
            }
        }
    }
}
