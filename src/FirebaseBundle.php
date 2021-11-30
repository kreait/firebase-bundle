<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle;

use Kreait\Firebase\Symfony\Bundle\DependencyInjection\FirebaseExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FirebaseBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new FirebaseExtension();
    }
}
