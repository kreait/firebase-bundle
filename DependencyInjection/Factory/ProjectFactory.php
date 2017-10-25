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

        if ($config['database_uri'] ?? null) {
            $factory = $this->firebaseFactory->withDatabaseUri($config['database_uri']);
        }

        if ($config['api_key'] ?? null) {
            $factory = $this->firebaseFactory->withApiKey($config['api_key']);
        }

        return $factory->create();
    }
}
