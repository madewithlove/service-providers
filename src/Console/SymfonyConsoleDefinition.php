<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Console;

use Assembly\ObjectDefinition;
use Assembly\Reference;
use Interop\Container\Definition\DefinitionProviderInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class SymfonyConsoleDefinition implements DefinitionProviderInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $version;

    /**
     * @var Command[]|string[]
     */
    protected $commands;

    /**
     * @param string             $name
     * @param string             $version
     * @param string[]|Command[] $commands
     */
    public function __construct($name = 'NAME', $version = 'VERSION', $commands = [])
    {
        $this->commands = $commands;
        $this->name = $name;
        $this->version = $version;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        $console = new ObjectDefinition(Application::class);
        $console->addMethodCall('setName', $this->name);
        $console->addMethodCall('setVersion', $this->version);

        // Register commands
        foreach ($this->commands as $command) {
            $command = is_string($command) ? new Reference($command) : $command;
            $console->addMethodCall('add', $command);
        }

        return [
            Application::class => $console,
            'console' => new Reference(Application::class),
        ];
    }
}
