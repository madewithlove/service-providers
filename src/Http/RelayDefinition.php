<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Http;

use Assembly\FactoryCallDefinition;
use Assembly\ObjectDefinition;
use Assembly\Reference;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\Container\ImmutableContainerAwareInterface;
use League\Container\ImmutableContainerAwareTrait;
use Relay\Relay;
use Relay\RelayBuilder;

class RelayDefinition implements DefinitionProviderInterface, ImmutableContainerAwareInterface
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
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        $relayFactory = new ObjectDefinition(RelayBuilder::class);
        $relayFactory->setConstructorArguments(function ($callable) {
            return is_string($callable) ? $this->container->get($callable) : $callable;
        });

        $relay = new FactoryCallDefinition(new Reference(RelayBuilder::class), 'newInstance');
        $relay->setArguments($this->middlewares);

        return [
            RelayBuilder::class => $relayFactory,
            Relay::class => $relay,
            'pipeline' => new Reference(Relay::class),
        ];
    }
}
