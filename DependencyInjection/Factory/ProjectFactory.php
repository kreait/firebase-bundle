<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory;

use Kreait\Firebase;
use Kreait\Firebase\Factory;

class ProjectFactory
{
    /**
     * @var Factory
     */
    private $firebaseFactory;

    public function __construct(Factory $firebaseFactory)
    {
        $this->firebaseFactory = $firebaseFactory;
    }

    public function create(array $config = []): Firebase
    {
        $factory = clone $this->firebaseFactory; // Ensure a new instance

        if ($config['credentials'] ?? null) {
            $serviceAccount = Firebase\ServiceAccount::fromValue($config['credentials']);
            $factory = $factory
                ->withServiceAccount($serviceAccount)
                ->withDisabledAutoDiscovery();
        }

        if ($config['database_uri'] ?? null) {
            $factory = $factory->withDatabaseUri($config['database_uri']);
        }

        return $factory->create();
    }
}
