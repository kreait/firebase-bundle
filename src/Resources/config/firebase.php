<?php

use Kreait\Firebase\Factory;
use Kreait\Firebase\Symfony\Bundle\DependencyInjection\Factory\ProjectFactory;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    // Equivalent of <parameter key="kreait.firebase.factory">Kreait\Firebase\Factory</parameter>
    // NO need for these parameters anymore — use FQCN directly.

    $services
        ->set(Factory::class)
        ->public(); // optional: same as XML service id="Kreait\Firebase\Factory"

    $services
        ->set(ProjectFactory::class)
        ->public(false); // same as public="false"
};
