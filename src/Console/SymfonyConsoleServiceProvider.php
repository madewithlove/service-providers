<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Console;

use Interop\Container\ServiceProviderInterface;
use Madewithlove\ServiceProviders\Utilities\Alias;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class SymfonyConsoleServiceProvider implements ServiceProviderInterface
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
    public function getServices()
    {
        return [
            Application::class => [$this, 'getApplication'],
            'console' => new Alias(Application::class),
        ];
    }

    /**
     * @param ContainerInterface $container
     *
     * @return Application
     */
    public function getApplication(ContainerInterface $container)
    {
        $console = new Application();
        $console->setName($this->name);
        $console->setVersion($this->version);

        // Register commands
        foreach ($this->commands as $command) {
            $console->add(is_string($command) ? $container->get($command) : $command);
        }

        return $console;
    }
}
