<?php

namespace Kreait\FirebaseBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KreaitFirebaseBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testIsInitializable()
    {
        $out = new KreaitFirebaseBundle();
        $this->assertInstanceOf('Kreait\\FirebaseBundle\\KreaitFirebaseBundle', $out);
    }
}
