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
use League\Container\ServiceProvider\AbstractServiceProvider;

class ServiceProviderDecorator extends AbstractServiceProvider
{
    /**
     * @var ServiceProviderInterface
     */
    protected $provider;

    /**
     * @param ServiceProviderInterface $provider
     */
    public function __construct(ServiceProviderInterface $provider)
    {
        $this->provider = $provider;
        $this->provides = array_keys($provider->getServices());
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        foreach ($this->provider->getServices() as $key => $value) {
            $this->container->share($key, function () use ($value) {
                return $value($this->container);
            });
        }
    }
}
