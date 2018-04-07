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
    /**
     * @var array
     */
    private $projects = [];

    /**
     * @var string
     */
    private $defaultProject;

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

    private function processProjectConfiguration($name, array $config, ContainerBuilder $container): string
    {
        $projectServiceId = sprintf('%s.%s', $this->getAlias(), $name);
        $isPublic = $config['public'];

        $container->register($projectServiceId, Firebase::class)
            ->setFactory([new Reference(ProjectFactory::class), 'create'])
            ->addArgument($config)
            ->setPublic($isPublic);

        if ($config['alias'] ?? null) {
            $alias = $container->setAlias($config['alias'], $projectServiceId);
            $alias->setPublic($isPublic);
        }

        if ($this->defaultProject && $config['default']) {
            throw new InvalidConfigurationException('Only one project can be set as default.');
        }

        if ($config['default']) {
            $this->defaultProject = $projectServiceId;
        }

        return $projectServiceId;
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
