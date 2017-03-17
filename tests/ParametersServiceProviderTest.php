<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders;

use Madewithlove\ServiceProviders\Utilities\ParametersServiceProvider;

class ParametersServiceProviderTest extends TestCase
{
    public function testCanBindConfiguration()
    {
        $container = $this->getContainerfromProviders([
            new ParametersServiceProvider('config', [
                'foo' => 'bar',
            ]),
        ]);

        $this->assertEquals('bar', $container->get('config.foo'));
    }
}
