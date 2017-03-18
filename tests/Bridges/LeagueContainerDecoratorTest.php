<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Bridges;

use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Route\RouteCollection;
use Madewithlove\ServiceProviders\Dummies\DummyServiceProvider;
use Madewithlove\ServiceProviders\Http\LeagueRouteServiceProvider;
use Madewithlove\ServiceProviders\Templating\TwigServiceProvider;
use Madewithlove\ServiceProviders\TestCase;
use Twig_Environment;

class LeagueContainerDecoratorTest extends TestCase
{
    public function testCanDecorateLeagueContainer()
    {
        $container = new LeagueContainerDecorator(new Container());
        $container->addServiceProvider(new TwigServiceProvider());
        $container->addServiceProvider(new DummyServiceProvider());

        $twig = $container->get(Twig_Environment::class);
        $globals = $twig->getGlobals();

        $this->assertArrayHasKey('foo', $globals);
        $this->assertEquals('bar', $globals['foo']);
    }

    public function testDoesntTryToAutowirePrevious()
    {
        $container = new LeagueContainerDecorator(new Container());
        $container->delegate(new ReflectionContainer());
        $container->addServiceProvider(new LeagueRouteServiceProvider());

        $routes = $container->get(RouteCollection::class);
        $this->assertInstanceOf(RouteCollection::class, $routes);
    }

    public function testOrderOfProvidersDoesntMatter()
    {
        $this->markTestSkipped('Blocked by https://github.com/thephpleague/container/issues/102');

        $container = new LeagueContainerDecorator(new Container());
        $container->addServiceProvider(new TwigServiceProvider());
        $container->addServiceProvider(new DummyServiceProvider());

        $twig = $container->get(Twig_Environment::class);
        $globals = $twig->getGlobals();

        $this->assertArrayHasKey('foo', $globals);
        $this->assertEquals('bar', $globals['foo']);
    }
}
