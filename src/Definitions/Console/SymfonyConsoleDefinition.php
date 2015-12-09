<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Definitions\Console;

use Assembly\ObjectDefinition;
use Assembly\Reference;
use Madewithlove\Definitions\Definitions\AbstractDefinitionProvider;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class SymfonyConsoleDefinition extends AbstractDefinitionProvider
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $version;

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
        $this->name = $name;
        $this->version = $version;
        $this->commands = $commands;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        return [
            Application::class => $this->getApplication(),
            'console' => new Reference(Application::class),
        ];
    }

    /**
     * @return ObjectDefinition
     */
    protected function getApplication()
    {
        $console = new ObjectDefinition(Application::class);
        $console->addMethodCall('setName', $this->name);
        $console->addMethodCall('setVersion', $this->version);

        // Register commands
        foreach ($this->commands as $command) {
            $command = is_string($command) ? new Reference($command) : $command;
            $console->addMethodCall('add', $command);
        }

        return $console;
    }
}
