<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\CommandBus;

use Assembly\ObjectDefinition;
use Assembly\Reference;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\Container\ImmutableContainerAwareInterface;
use League\Container\ImmutableContainerAwareTrait;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
use League\Tactician\Middleware;
use League\Tactician\Plugins\LockingMiddleware;

class TacticianDefinition implements DefinitionProviderInterface, ImmutableContainerAwareInterface
{
    use ImmutableContainerAwareTrait;

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
    public function getDefinitions()
    {
        return [
            CommandNameExtractor::class => new ObjectDefinition($this->extractor),
            HandlerLocator::class => new ObjectDefinition($this->locator),
            MethodNameInflector::class => new ObjectDefinition($this->inflector),
            Middleware::class => $this->getHandlerMiddleware(),
            CommandBus::class => $this->getCommandBus(),
            'bus' => new Reference(CommandBus::class),
        ];
    }

    /**
     * @return ObjectDefinition
     */
    protected function getCommandBus()
    {
        $bus = new ObjectDefinition(CommandBus::class);
        $bus->setConstructorArguments([
            new LockingMiddleware(),
            new Reference(Middleware::class),
        ]);

        return $bus;
    }

    /**
     * @return ObjectDefinition
     */
    protected function getHandlerMiddleware()
    {
        $middleware = new ObjectDefinition(CommandHandlerMiddleware::class);
        $middleware->setConstructorArguments(
            new Reference(CommandNameExtractor::class),
            new Reference(HandlerLocator::class),
            new Reference(MethodNameInflector::class)
        );

        return $middleware;
    }
}
