<?php

namespace Kreait\FirebaseBundle\Tests\DependencyInjection;

use Kreait\Firebase\Firebase;
use Kreait\FirebaseBundle\DependencyInjection\KreaitFirebaseExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class KreaitFirebaseExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return [
            new KreaitFirebaseExtension()
        ];
    }

    public function testAllConfiguredSettingsAreProcessed()
    {
        $this->load([
            'connections' => [
                'foo' => [
                    'host' => 'example.com',
                    'secret' => 'secret',
                    'references' => [
                        'foo' => 'foo/bar'
                    ],
                ]
            ]
        ]);

        $this->assertContainerBuilderHasService('kreait_firebase.connection.foo');

        /** @var Firebase $firebase */
        $firebase = $this->container->get('kreait_firebase.connection.foo');

        $this->assertEquals('https://example.com', $firebase->getBaseUrl());
        $this->assertEquals('secret', $firebase->getConfiguration()->getFirebaseSecret());

        $this->assertInstanceOf('Kreait\Firebase\Reference', $this->container->get('kreait_firebase.reference.foo'));
    }
}
