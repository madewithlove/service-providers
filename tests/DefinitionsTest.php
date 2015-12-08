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
use Interop\Container\Definition\DefinitionInterface;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\Flysystem\Adapter\Local;
use Madewithlove\Definitions\CommandBus\TacticianDefinition;
use Madewithlove\Definitions\Console\SymfonyConsoleDefinition;
use Madewithlove\Definitions\DefinitionTypes\ExtendDefinition;
use Madewithlove\Definitions\Development\DebugbarDefinition;
use Madewithlove\Definitions\Development\MonologDefinition;
use Madewithlove\Definitions\Filesystem\FlysystemDefinition;
use Madewithlove\Definitions\Http\LeagueRouteDefinition;
use Madewithlove\Definitions\Http\RelayDefinition;
use Madewithlove\Definitions\Http\ZendDiactorosDefinition;
use Madewithlove\Definitions\Templating\TwigDefinition;

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
            if (!$definition instanceof ExtendDefinition) {
                $this->assertNotInstanceOf(DefinitionInterface::class, $service);
            }
        }
    }

    /**
     * @return array
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
            [new TacticianDefinition(['FooCommand' => 'FooHandler'])],
            [new ZendDiactorosDefinition()],
            [new SymfonyConsoleDefinition()],
            [new TwigDefinition()],
        ];
    }
}
