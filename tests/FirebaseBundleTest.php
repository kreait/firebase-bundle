<?php

declare(strict_types=1);

namespace Kreait\Firebase\Symfony\Bundle\Tests;

use Kreait\Firebase\Symfony\Bundle\DependencyInjection\FirebaseExtension;
use Kreait\Firebase\Symfony\Bundle\FirebaseBundle;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class FirebaseBundleTest extends TestCase
{
    /**
     * @test
     */
    public function it_uses_the_right_container_extension(): void
    {
        $bundle = new FirebaseBundle();

        $this->assertInstanceOf(FirebaseExtension::class, $bundle->getContainerExtension());
    }
}
