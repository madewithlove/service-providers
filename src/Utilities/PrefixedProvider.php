<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Utilities;

use Interop\Container\ServiceProviderInterface;

/**
 * Prefixes the services of an SP with a prefix.
 */
class PrefixedProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var ServiceProviderInterface
     */
    protected $provider;

    /**
     * @param string                   $prefix
     * @param ServiceProviderInterface $provider
     */
    public function __construct($prefix, ServiceProviderInterface $provider)
    {
        $this->prefix = $prefix;
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        $prefixed = [];
        $services = $this->provider->getServices();
        foreach ($services as $key => $value) {
            $prefixed[$this->prefix.'.'.$key] = $value;
        }

        return $prefixed;
    }
}
