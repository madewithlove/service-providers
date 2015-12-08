<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions;

use Assembly\Container\Container;

class ValuesDefinitionTest extends TestCase
{
    public function testCanBindConfiguration()
    {
        $providers = [
            new ValuesDefinition('config', [
                'foo' => 'bar',
            ]),
        ];

        $container = new Container([], $providers);

        $this->assertEquals('bar', $container->get('config.foo'));
    }
}
