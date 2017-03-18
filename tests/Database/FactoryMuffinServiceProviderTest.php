<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Database;

use Illuminate\Support\Fluent;
use League\FactoryMuffin\Facade;
use League\FactoryMuffin\Factory;
use Madewithlove\ServiceProviders\TestCase;

class FactoryMuffinServiceProviderTest extends TestCase
{
    public function testCanLoadFactories()
    {
        $container = $this->getContainerfromProviders([
            new FactoryMuffinServiceProvider(realpath(__DIR__.'/../Factories')),
        ]);

        $container->get(Factory::class);

        $this->assertEquals(['name' => 1], Facade::instance(Fluent::class)->toArray());
    }
}
