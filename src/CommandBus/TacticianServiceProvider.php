<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\CommandBus;

use Interop\Container\ServiceProviderInterface;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Middleware;
use Madewithlove\ServiceProviders\Utilities\Alias;
use Psr\Container\ContainerInterface;

class TacticianServiceProvider implements ServiceProviderInterface
{
    /**
     * @var CommandNameExtractor
     */
    protected $extractor;

    /**
     * @var MethodNameInflector
     */
    protected $inflector;

    /**
     * @var HandlerLocator
     */
    protected $locator;

    /**
     * @param string $extractor
     * @param string $locator
     * @param string $inflector
     */
    public function __construct(
        $extractor = ClassNameExtractor::class,
        $locator = InMemoryLocator::class,
        $inflector = HandleInflector::class
    ) {
        $this->extractor = $extractor;
        $this->locator = $locator;
        $this->inflector = $inflector;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return [
            Middleware::class => [$this, 'getHandlerMiddleware'],
            CommandBus::class => [$this, 'getCommandBus'],
            'bus' => new Alias(CommandBus::class),
        ];
    }

    /**
     * @param ContainerInterface $container
     *
     * @return CommandBus
     */
    public function getCommandBus(ContainerInterface $container)
    {
        return new CommandBus([
            $container->get(Middleware::class),
        ]);
    }

    /**
     * @param ContainerInterface $container
     *
     * @return Middleware
     */
    public function getHandlerMiddleware(ContainerInterface $container)
    {
        return new CommandHandlerMiddleware(
            $container->get($this->extractor),
            $container->get($this->locator),
            $container->get($this->inflector)
        );
    }
}
