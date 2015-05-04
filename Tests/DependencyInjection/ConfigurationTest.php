<?php


namespace DependencyInjection;

use Kreait\FirebaseBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration()
    {
        return new Configuration();
    }

    public function testValuesAreInvalidIfConnectionsValueIsNotProvided()
    {
        $this->assertConfigurationIsInvalid(
            [
                [] // no values at al
            ],
            'connections'
        );
    }

    public function testValuesAreInvalidIfNoConnectionAreProvided()
    {
        $this->assertConfigurationIsInvalid(
            [
                [
                    'connections' => []
                ]
            ],
            'connections'
        );
    }

    public function testValuesAreInvalidIfNoHostIsProvided()
    {
        $this->assertConfigurationIsInvalid(
            [
                [
                    'connections' => [
                        'connection' => []
                    ]
                ]
            ],
            'host'
        );
    }

    public function testValuesAreInvalidIfReferencesAreSetButEmpty()
    {
        $this->assertConfigurationIsInvalid(
            [
                [
                    'connections' => [
                        'connection' => [
                            'host' => 'host',
                            'references' => [],
                        ]
                    ]
                ]
            ],
            'references'
        );
    }
}
