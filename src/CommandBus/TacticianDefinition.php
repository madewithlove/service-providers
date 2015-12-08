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
use League\Tactician\Handler\Locator\CallableLocator;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;
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
     * @param CommandNameExtractor $extractor
     * @param HandlerLocator       $locator
     * @param MethodNameInflector  $inflector
     */
    public function __construct(
        CommandNameExtractor $extractor = null,
        HandlerLocator $locator = null,
        MethodNameInflector $inflector = null
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
        // Set default classes if needed
        $this->extractor = $this->extractor ?: new ClassNameExtractor();
        $this->inflector = $this->inflector ?: new HandleInflector();
        $this->locator = $this->locator ?: new CallableLocator(function ($commandName) {
            $handler = preg_replace('/Command$/', 'Handler', $commandName);

            return $this->container ? $this->container->get($handler) : new $handler;
        });

        $bus = new ObjectDefinition(CommandBus::class);
        $bus->setConstructorArguments([
            new LockingMiddleware(),
            new CommandHandlerMiddleware($this->extractor, $this->locator, $this->inflector),
        ]);

        return [
            CommandBus::class => $bus,
            'bus' => new Reference(CommandBus::class),
        ];
    }
}
