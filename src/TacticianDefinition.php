<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions;

use Assembly\ObjectDefinition;
use Assembly\Reference;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\InMemoryLocator;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Plugins\LockingMiddleware;

class TacticianDefinition implements DefinitionProviderInterface
{
    /**
     * @var array
     */
    protected $mappings = [];

    /**
     * @param array $mappings
     */
    public function __construct(array $mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        $handler = new CommandHandlerMiddleware(
            new ClassNameExtractor(),
            new InMemoryLocator($this->mappings),
            new HandleInflector()
        );

        $bus = new ObjectDefinition(CommandBus::class);
        $bus->setConstructorArguments([new LockingMiddleware(), $handler]);

        return [
            CommandBus::class => $bus,
            'bus' => new Reference(CommandBus::class),
        ];
    }
}
