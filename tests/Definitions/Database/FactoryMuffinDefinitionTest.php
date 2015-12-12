<?php
namespace Madewithlove\Definitions\Definitions\Database;

use Assembly\Container\Container;
use Illuminate\Support\Fluent;
use League\FactoryMuffin\Facade;
use League\FactoryMuffin\Factory;
use Madewithlove\Definitions\TestCase;

class FactoryMuffinDefinitionTest extends TestCase
{
    public function testCanLoadFactories()
    {
        $container = new Container([], [
           new FactoryMuffinDefinition(realpath(__DIR__.'/../../Dummies')),
        ]);

        $container->get(Factory::class);

        $this->assertEquals(['name' => 1], Facade::instance(Fluent::class)->toArray());
    }
}
