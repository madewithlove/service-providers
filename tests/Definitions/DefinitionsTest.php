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
use Illuminate\Cache\FileStore;
use Illuminate\Filesystem\Filesystem;
use Interop\Container\Definition\DefinitionInterface;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\Flysystem\Adapter\Local;
use Madewithlove\Definitions\Definitions\Caching\IlluminateCacheDefinition;
use Madewithlove\Definitions\Definitions\CommandBus\TacticianDefinition;
use Madewithlove\Definitions\Definitions\Console\SymfonyConsoleDefinition;
use Madewithlove\Definitions\Definitions\Development\DebugbarDefinition;
use Madewithlove\Definitions\Definitions\Development\MonologDefinition;
use Madewithlove\Definitions\Definitions\Filesystem\FlysystemDefinition;
use Madewithlove\Definitions\Definitions\Http\LeagueRouteDefinition;
use Madewithlove\Definitions\Definitions\Http\RelayDefinition;
use Madewithlove\Definitions\Definitions\Http\ZendDiactorosDefinition;
use Madewithlove\Definitions\Definitions\Templating\TwigDefinition;
use Madewithlove\Definitions\TestCase;

class DefinitionsTest extends TestCase
{
    /**
     * @dataProvider provideDefinitions
     *
     * @param DefinitionProviderInterface $provider
     */
    public function testCanResolveDefinition(DefinitionProviderInterface $provider)
    {
        $container = new Container([], [$provider]);

        $definitions = $provider->getDefinitions();
        foreach ($definitions as $key => $definition) {
            $service = $container->get($key);

            $this->assertNotInstanceOf(DefinitionInterface::class, $service);
            if (class_exists($key)) {
                $this->assertInstanceOf($key, $service);
            }
        }
    }

    public function testCanSerializeDefinitions()
    {
        $definitions = [];
        $providers = $this->provideDefinitions();
        foreach ($providers as $provider) {
            $definitions = array_merge($definitions, $provider[0]->getDefinitions());
        }

        $serialized = serialize($definitions);
        $unserialized = unserialize($serialized);

        $this->assertEquals($unserialized, $definitions);
    }

    /**
     * @return DefinitionProviderInterface[][]
     */
    public function provideDefinitions()
    {
        return [
            [new ValuesDefinition('config', ['foo' => 'bar'])],
            [new FlysystemDefinition('local', ['local' => new Local(__DIR__)])],
            [new DebugbarDefinition()],
            [new LeagueRouteDefinition()],
            [new MonologDefinition()],
            [new RelayDefinition()],
            [new TacticianDefinition()],
            [new ZendDiactorosDefinition()],
            [new SymfonyConsoleDefinition()],
            [new TwigDefinition()],
            [new IlluminateCacheDefinition(FileStore::class, [new Filesystem(), __DIR__])],
        ];
    }
}
