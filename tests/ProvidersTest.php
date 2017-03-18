<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders;

use Interop\Container\ServiceProviderInterface;
use League\Flysystem\Adapter\Local;
use Madewithlove\ServiceProviders\CommandBus\TacticianServiceProvider;
use Madewithlove\ServiceProviders\Console\SymfonyConsoleServiceProvider;
use Madewithlove\ServiceProviders\Development\DebugbarServiceProvider;
use Madewithlove\ServiceProviders\Development\MonologServiceProvider;
use Madewithlove\ServiceProviders\Filesystem\FlysystemServiceProvider;
use Madewithlove\ServiceProviders\Http\LeagueRouteServiceProvider;
use Madewithlove\ServiceProviders\Http\RelayServiceProvider;
use Madewithlove\ServiceProviders\Http\ZendDiactorosServiceProvider;
use Madewithlove\ServiceProviders\Templating\TwigServiceProvider;
use Madewithlove\ServiceProviders\Utilities\ParametersServiceProvider;

class ProvidersTest extends TestCase
{
    /**
     * @dataProvider provideProviders
     *
     * @param ServiceProviderInterface $provider
     */
    public function testCanResolveProvider(ServiceProviderInterface $provider)
    {
        $container = $this->getContainerfromProviders([$provider]);

        $services = $provider->getServices();
        foreach ($services as $key => $definition) {
            $service = $container->get($key);

            $this->assertNotInstanceOf(ServiceProviderInterface::class, $service);
            if (class_exists($key)) {
                $this->assertInstanceOf($key, $service);
            }
        }
    }

    /**
     * @return ServiceProviderInterface[][]
     */
    public function provideProviders()
    {
        return [
            [new ParametersServiceProvider(['foo' => 'bar'])],
            [new FlysystemServiceProvider('local', ['local' => new Local(__DIR__)])],
            [new DebugbarServiceProvider()],
            [new LeagueRouteServiceProvider()],
            [new MonologServiceProvider()],
            [new RelayServiceProvider()],
            // [new TacticianServiceProvider()],
            [new ZendDiactorosServiceProvider()],
            [new SymfonyConsoleServiceProvider()],
            [new TwigServiceProvider()],
        ];
    }
}
