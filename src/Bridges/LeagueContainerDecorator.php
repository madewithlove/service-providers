<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Bridges;

use Interop\Container\ContainerInterface as InteropContainerInterface;
use Interop\Container\ServiceProviderInterface;
use League\Container\Container;
use League\Container\ContainerInterface;

/**
 * Credit goes to https://github.com/mint-php for original implementation.
 *
 * @mixin Container
 */
class LeagueContainerDecorator implements ContainerInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param ServiceProviderInterface|\League\Container\ServiceProvider\ServiceProviderInterface|string $provider
     *
     * @return $this
     */
    public function addServiceProvider($provider)
    {
        if ($provider instanceof ServiceProviderInterface) {
            foreach ($provider->getServices() as $key => $callable) {
                if (!$this->container->hasShared($key)) {
                    $this->container->share($key, function () use ($callable) {
                        return $callable($this);
                    });
                } else {
                    $previous = $this->container->get($key);
                    $this->container->share($key, function () use ($callable, $previous) {
                        return $callable($this, function () use ($previous) {
                            return $previous;
                        });
                    });
                }
            }
        } else {
            $this->container->addServiceProvider($provider);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasShared($alias, $resolved = false)
    {
        return $this->container->hasShared($alias, $resolved);
    }

    /**
     * {@inheritdoc}
     */
    public function delegate(InteropContainerInterface $container)
    {
        return $this->container->delegate($container);
    }

    /**
     * {@inheritdoc}
     */
    public function hasInDelegate($alias)
    {
        return $this->container->hasInDelegate($alias);
    }

    /**
     * {@inheritdoc}
     */
    public function add($alias, $concrete = null, $share = false)
    {
        return $this->container->add($alias, $concrete, $share);
    }

    /**
     * {@inheritdoc}
     */
    public function share($alias, $concrete = null)
    {
        return $this->container->share($alias, $concrete);
    }

    /**
     * {@inheritdoc}
     */
    public function extend($alias)
    {
        return $this->container->extend($alias);
    }

    /**
     * {@inheritdoc}
     */
    public function call(callable $callable, array $args = [])
    {
        return $this->container->call($callable, $args);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * {@inheritdoc}
     */
    public function inflector($type, callable $callback = null)
    {
        return $this->container->inflector($type, $callback);
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        return $this->container->has($id);
    }
}
