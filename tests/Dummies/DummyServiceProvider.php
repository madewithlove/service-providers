<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Dummies;

use Interop\Container\ServiceProviderInterface;
use Madewithlove\ServiceProviders\Utilities\Parameter;
use Psr\Container\ContainerInterface;
use Twig_Environment;

class DummyServiceProvider implements ServiceProviderInterface
{
    public function getServices()
    {
        return [
            'foo' => new Parameter('bar'),
            Twig_Environment::class => [$this, 'withSomething'],
        ];
    }

    public function withSomething(ContainerInterface $container, callable $getPrevious = null)
    {
        /** @var Twig_Environment $twig */
        $twig = $getPrevious();
        $twig->addGlobal('foo', $container->get('foo'));

        return $twig;
    }
}
