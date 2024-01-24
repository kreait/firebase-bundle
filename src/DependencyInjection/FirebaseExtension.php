<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\DependencyInjection;

use Kreait\Firebase;
use Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory\ProjectFactory;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
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
        $this->registerService($name, 'database', $config, Firebase\Contract\Database::class, $container, 'createDatabase');
        $this->registerService($name, 'auth', $config, Firebase\Contract\Auth::class, $container, 'createAuth');
        $this->registerService($name, 'storage', $config, Firebase\Contract\Storage::class, $container, 'createStorage');
        $this->registerService($name, 'remote_config', $config, Firebase\Contract\RemoteConfig::class, $container, 'createRemoteConfig');
        $this->registerService($name, 'messaging', $config, Firebase\Contract\Messaging::class, $container, 'createMessaging');
        $this->registerService($name, 'firestore', $config, Firebase\Contract\Firestore::class, $container, 'createFirestore');
        $this->registerService($name, 'dynamic_links', $config, Firebase\Contract\DynamicLinks::class, $container, 'createDynamicLinksService');
        $this->registerService($name, 'app_check', $config, Firebase\Contract\AppCheck::class, $container, 'createAppCheck');
    }

    public function getAlias(): string
    {
        return 'kreait_firebase';
    }

    public function getConfiguration(array $config, ContainerBuilder $container): Configuration
    {
        return new Configuration($this->getAlias());
    }

    private function registerService(string $name, string $postfix, array $config, string $contract, ContainerBuilder $container, string $method = 'create'): void
    {
        $projectServiceId = \sprintf('%s.%s.%s', $this->getAlias(), $name, $postfix);
        $isPublic = $config['public'];

        $factory = new Definition(ProjectFactory::class);
        $factory->setPublic(false);

        if ($config['verifier_cache'] ?? null) {
            $factory->addMethodCall('setVerifierCache', [new Reference($config['verifier_cache'])]);
        }

        if ($config['auth_token_cache'] ?? null) {
            $factory->addMethodCall('setAuthTokenCache', [new Reference($config['auth_token_cache'])]);
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
        }

        $container->registerAliasForArgument($projectServiceId, $contract, $name.ucfirst($postfix));
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
