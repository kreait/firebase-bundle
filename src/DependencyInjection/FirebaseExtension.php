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

class FirebaseExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('firebase.xml');

        $projectConfigurations = $config['projects'] ?? [];
        $projectConfigurationsCount = \count($projectConfigurations);

        $this->assertThatOnlyOneDefaultProjectExists($projectConfigurations);

        foreach ($projectConfigurations as $projectName => $projectConfiguration) {
            if (1 === $projectConfigurationsCount) {
                $projectConfiguration['default'] = $projectConfiguration['default'] ?? true;
            }

            $this->processProjectConfiguration($projectName, $projectConfiguration, $container);
        }
    }

    private function processProjectConfiguration(string $name, array $config, ContainerBuilder $container): void
    {
        $this->registerService($name.'.database', $config, Firebase\Database::class, Firebase\Contract\Database::class, $container, 'createDatabase');
        $this->registerService($name.'.auth', $config, Firebase\Auth::class, Firebase\Contract\Auth::class, $container, 'createAuth');
        $this->registerService($name.'.storage', $config, Firebase\Storage::class, Firebase\Contract\Storage::class, $container, 'createStorage');
        $this->registerService($name.'.remote_config', $config, Firebase\RemoteConfig::class, Firebase\Contract\RemoteConfig::class, $container, 'createRemoteConfig');
        $this->registerService($name.'.messaging', $config, Firebase\Messaging::class, Firebase\Contract\Messaging::class, $container, 'createMessaging');
        $this->registerService($name.'.firestore', $config, Firebase\Firestore::class, Firebase\Contract\Firestore::class, $container, 'createFirestore');
        $this->registerService($name.'.dynamic_links', $config, Firebase\DynamicLinks::class, Firebase\Contract\DynamicLinks::class, $container, 'createDynamicLinksService');
    }

    public function getAlias(): string
    {
        return 'kreait_firebase';
    }

    public function getConfiguration(array $config, ContainerBuilder $container): Configuration
    {
        return new Configuration($this->getAlias());
    }

    private function registerService(string $name, array $config, string $class, string $contract, ContainerBuilder $container, string $method = 'create'): void
    {
        $projectServiceId = \sprintf('%s.%s', $this->getAlias(), $name);
        $isPublic = $config['public'];

        $factory = $container->getDefinition(ProjectFactory::class);

        if ($config['verifier_cache'] ?? null) {
            $factory->addMethodCall('setVerifierCache', [new Reference($config['verifier_cache'])]);
        }

        if ($config['http_request_logger'] ?? null) {
            $factory->addMethodCall('setHttpRequestLogger', [new Reference($config['http_request_logger'])]);
        }

        if ($config['http_request_debug_logger'] ?? null) {
            $factory->addMethodCall('setHttpRequestDebugLogger', [new Reference($config['http_request_debug_logger'])]);
        }

        $container->register($projectServiceId, $contract)
            ->setFactory([$factory, $method])
            ->addArgument($config)
            ->setPublic($isPublic);

        if ($config['default'] ?? false) {
            $container->setAlias($contract, $projectServiceId)->setPublic($isPublic);
            $container->setAlias($class, $projectServiceId)->setPublic($isPublic)->setDeprecated('kreait/firebase-bundle', '2.6.0', 'The "%alias_id%" service alias is deprecated. You should stop using it, as it will be removed in the future.');
        }
    }

    private function assertThatOnlyOneDefaultProjectExists(array $projectConfigurations): void
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
