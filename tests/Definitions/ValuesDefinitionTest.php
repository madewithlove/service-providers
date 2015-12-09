<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Definitions;

use Assembly\Container\Container;
use Madewithlove\Definitions\TestCase;

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
