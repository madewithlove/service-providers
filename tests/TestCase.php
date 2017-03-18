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
use Madewithlove\ServiceProviders\Bridges\LeagueContainerDecorator;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param array $providers
     *
     * @return Container
     */
    protected function getContainerfromProviders(array $providers = [])
    {
        $container = new LeagueContainerDecorator(new Container());
        foreach ($providers as $provider) {
            $container->addServiceProvider($provider);
        }

        return $container;
    }
}
