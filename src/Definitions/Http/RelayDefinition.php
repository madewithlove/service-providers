<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Definitions\Http;

use Assembly\FactoryCallDefinition;
use Assembly\ObjectDefinition;
use Assembly\Reference;
use League\Container\ImmutableContainerAwareInterface;
use League\Container\ImmutableContainerAwareTrait;
use Madewithlove\Definitions\Definitions\AbstractDefinitionProvider;
use Relay\MiddlewareInterface;
use Relay\Relay;
use Relay\RelayBuilder;

class RelayDefinition extends AbstractDefinitionProvider implements ImmutableContainerAwareInterface
{
    use ImmutableContainerAwareTrait;

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
     * Resolve a middleware.
     *
     * @param string|object $middleware
     *
     * @return MiddlewareInterface
     */
    public function resolve($middleware)
    {
        if (!$this->container && !is_string($middleware)) {
            return $middleware;
        } elseif (!$this->container && is_string($middleware)) {
            return new $middleware();
        }

        return $this->container->get($middleware);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        return [
            RelayBuilder::class => $this->getFactory(),
            Relay::class => $this->getRelay(),
            'pipeline' => new Reference(Relay::class),
        ];
    }

    /**
     * @return ObjectDefinition
     */
    protected function getFactory()
    {
        $relayFactory = new ObjectDefinition(RelayBuilder::class);
        $relayFactory->setConstructorArguments([$this, 'resolve']);

        return $relayFactory;
    }

    /**
     * @return FactoryCallDefinition
     */
    protected function getRelay()
    {
        $relay = new FactoryCallDefinition(new Reference(RelayBuilder::class), 'newInstance');
        $relay->setArguments($this->middlewares);

        return $relay;
    }
}
