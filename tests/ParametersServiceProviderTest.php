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
use Madewithlove\ServiceProviders\Utilities\PrefixedProvider;

class ParametersServiceProviderTest extends TestCase
{
    public function testCanBindConfiguration()
    {
        $container = $this->getContainerfromProviders([
            new PrefixedProvider('config', new ParametersServiceProvider([
                'foo' => 'bar',
            ])),
        ]);

        $this->assertEquals('bar', $container->get('config.foo'));
    }
}
