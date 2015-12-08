<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Http;

use Assembly\ObjectDefinition;
use Assembly\Reference;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\Container\Container;
use League\Container\ImmutableContainerAwareInterface;
use League\Container\ImmutableContainerAwareTrait;
use League\Route\RouteCollection;
use League\Route\Strategy\ParamStrategy;
use League\Route\Strategy\StrategyInterface;

class LeagueRouteDefinition implements DefinitionProviderInterface, ImmutableContainerAwareInterface
{
    use ImmutableContainerAwareTrait;

    /**
     * @var string
     */
    protected $strategy;

    /**
     * @param string $strategy
     */
    public function __construct($strategy = ParamStrategy::class)
    {
        $this->strategy = $strategy;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        return [
            StrategyInterface::class => $this->getStrategy(),
            RouteCollection::class => $this->getRouter(),
            'router' => new Reference(RouteCollection::class),
        ];
    }

    /**
     * @return ObjectDefinition
     */
    protected function getStrategy()
    {
        $strategy = new ObjectDefinition($this->strategy);
        if ($this->container) {
            $strategy->addMethodCall('setContainer', $this->container);
        }

        return $strategy;
    }

    /**
     * @return ObjectDefinition
     */
    protected function getRouter()
    {
        $router = new ObjectDefinition(RouteCollection::class);
        $router->setConstructorArguments($this->container ?: new Container());
        $router->addMethodCall('setStrategy', new Reference(StrategyInterface::class));

        return $router;
    }
}
