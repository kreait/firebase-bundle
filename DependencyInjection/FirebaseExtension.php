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
    /** @var array */
    private $projects = [];

    /** @var string */
    private $defaultProject;

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

        foreach ($config['projects'] ?? [] as $projectName => $projectConfiguration) {
            $this->projects[] = $this->processProjectConfiguration($projectName, $projectConfiguration, $container);
        }

        if (!$this->defaultProject && 1 === \count($this->projects)) {
            $this->defaultProject = array_values($this->projects)[0];
        }

        if ($this->defaultProject) {
            $container->setAlias(Firebase::class, $this->defaultProject);
        }
    }

    private function processProjectConfiguration(string $name, array $config, ContainerBuilder $container): string
    {
        $this->registerService($name.'.factory', $config, $container, 'createFactory');
        $this->registerService($name.'.database', $config, $container, 'createDatabase');
        $this->registerService($name.'.auth', $config, $container, 'createAuth');
        $this->registerService($name.'.storage', $config, $container, 'createStorage');
        $this->registerService($name.'.remote_config', $config, $container, 'createRemoteConfig');
        $this->registerService($name.'.messaging', $config, $container, 'createMessaging');
        $this->registerService($name.'.firestore', $config, $container, 'createFirestore');
        $projectServiceId = $this->registerService($name, $config, $container);

        if ($this->defaultProject && $config['default']) {
            throw new InvalidConfigurationException('Only one project can be set as default.');
        }

        if ($config['default']) {
            $this->defaultProject = $projectServiceId;
        }

        return $projectServiceId;
    }

    public function getAlias(): string
    {
        return 'kreait_firebase';
    }

    public function getConfiguration(array $config, ContainerBuilder $container): Configuration
    {
        return new Configuration($this->getAlias());
    }

    private function registerService(string $name, array $config, ContainerBuilder $container, string $method = 'create'): string
    {
        $projectServiceId = sprintf('%s.%s', $this->getAlias(), $name);
        $isPublic = $config['public'];

        $container->register($projectServiceId, Firebase::class)
            ->setFactory([new Reference(ProjectFactory::class), $method])
            ->addArgument($config)
            ->setPublic($isPublic);

        if ($config['alias'] ?? null) {
            $container->setAlias($config['alias'], $projectServiceId);
            $container->getAlias($config['alias'])->setPublic($isPublic);
        }

        return $projectServiceId;
    }
}
