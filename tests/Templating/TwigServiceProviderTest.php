<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Templating;

use Madewithlove\ServiceProviders\TestCase;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Array;

class TwigServiceProviderTest extends TestCase
{
    public function testCanConfigureTwig()
    {
        $definition = new TwigServiceProvider(
            ['foo', 'bar'],
            [
                'auto_reload' => true,
                'debug' => true,
            ],
            [
                new Twig_Extension_Debug(),
            ]
        );

        $container = $this->getContainerfromProviders([$definition]);

        /** @var Twig_Environment $twig */
        $twig = $container->get(Twig_Environment::class);

        $extensions = $twig->getExtensions();
        $this->assertArrayHasKey(Twig_Extension_Debug::class, $extensions);

        $this->assertInstanceOf(Twig_Loader_Array::class, $twig->getLoader());
        $this->assertTrue($twig->isAutoReload());
        $this->assertTrue($twig->isDebug());
    }

    public function testAlwaysUsesProperLoader()
    {
        $container = $this->getContainerfromProviders([
            new TwigServiceProvider(__DIR__.'/foobar'),
        ]);

        $twig = $container->get(Twig_Environment::class);
        $this->assertInstanceOf(Twig_Environment::class, $twig);
    }
}
