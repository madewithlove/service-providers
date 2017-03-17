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
use League\Container\ImmutableContainerAwareTrait;
use League\Route\RouteCollection;
use League\Route\Strategy\AbstractStrategy;
use League\Route\Strategy\ParamStrategy;
use League\Route\Strategy\StrategyInterface;
use Madewithlove\ServiceProviders\Utilities\Alias;
use Psr\Container\ContainerInterface;

class LeagueRouteServiceProvider implements ServiceProviderInterface
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
    public function getServices()
    {
        return [
            StrategyInterface::class => [$this, 'getStrategy'],
            RouteCollection::class => [$this, 'getRouter'],
            'router' => new Alias(RouteCollection::class),
        ];
    }

    /**
     * @param ContainerInterface $container
     *
     * @return StrategyInterface
     */
    public function getStrategy(ContainerInterface $container)
    {
        /** @var AbstractStrategy $strategy */
        $strategy = new $this->strategy();
        $strategy->setContainer($container);

        return $strategy;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return RouteCollection
     */
    public function getRouter(ContainerInterface $container)
    {
        $router = new RouteCollection($container);
        $router->setStrategy($container->get(StrategyInterface::class));

        return $router;
    }
}
