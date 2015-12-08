<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Templating;

use Assembly\Container\Container;
use Madewithlove\Definitions\TestCase;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Array;

class TwigDefinitionTest extends TestCase
{
    public function testCanConfigureTwig()
    {
        $definition = new TwigDefinition(
            ['foo', 'bar'],
            [
                'auto_reload' => true,
                'debug' => true,
            ],
            [
                new Twig_Extension_Debug(),
            ]
        );

        $container = new Container([], [$definition]);

        /** @var Twig_Environment $twig */
        $twig = $container->get(Twig_Environment::class);

        $extensions = $twig->getExtensions();
        $this->assertArrayHasKey('debug', $extensions);

        $this->assertInstanceOf(Twig_Loader_Array::class, $twig->getLoader());
        $this->assertTrue($twig->isAutoReload());
        $this->assertTrue($twig->isDebug());
    }
}
