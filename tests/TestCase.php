<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders;

use League\Container\Container;
use League\Container\ReflectionContainer;
use PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @param array $providers
     *
     * @return Container
     */
    protected function getContainerfromProviders(array $providers = [])
    {
        $container = new Container();
        $container->delegate(new ReflectionContainer());
        foreach ($providers as $provider) {
            $container->addServiceProvider(new ServiceProviderDecorator($provider));
        }

        return $container;
    }
}
