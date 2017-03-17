<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Http;

use Interop\Container\ServiceProviderInterface;
use Madewithlove\ServiceProviders\Utilities\Alias;
use Psr\Container\ContainerInterface;
use Relay\Relay;
use Relay\RelayBuilder;

class RelayServiceProvider implements ServiceProviderInterface
{
    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @param array $middlewares
     */
    public function __construct(array $middlewares = [])
    {
        $this->middlewares = $middlewares;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return [
            RelayBuilder::class => [$this, 'getFactory'],
            Relay::class => [$this, 'getRelay'],
            'pipeline' => new Alias(Relay::class),
        ];
    }

    /**
     * @param ContainerInterface $container
     *
     * @return RelayBuilder
     */
    public function getFactory(ContainerInterface $container)
    {
        return new RelayBuilder(function ($middleware) use ($container) {
            return is_string($middleware) ? $container->get($middleware) : $middleware;
        });
    }

    /**
     * @param ContainerInterface $container
     *
     * @return Relay
     */
    public function getRelay(ContainerInterface $container)
    {
        /** @var RelayBuilder $builder */
        $builder = $container->get(RelayBuilder::class);

        return $builder->newInstance($this->middlewares);
    }
}
