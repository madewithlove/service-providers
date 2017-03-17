<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Development;

use Interop\Container\ServiceProviderInterface;
use Madewithlove\ServiceProviders\Utilities\Alias;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class MonologServiceProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @param string|null $path
     * @param string      $filename
     */
    public function __construct($path = null, $filename = 'logs.log')
    {
        $this->path = $path ?: getcwd();
        $this->filename = $filename;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return [
            HandlerInterface::class => [$this, 'getHandler'],
            LoggerInterface::class => [$this, 'getLogger'],
            'monolog' => new Alias(LoggerInterface::class),
        ];
    }

    /**
     * @return HandlerInterface
     */
    public function getHandler()
    {
        return new RotatingFileHandler($this->path.DIRECTORY_SEPARATOR.$this->filename, 0, Logger::WARNING);
    }

    /**
     * @param ContainerInterface $container
     *
     * @return LoggerInterface
     */
    public function getLogger(ContainerInterface $container)
    {
        $logger = new Logger('logs');
        $logger->pushHandler($container->get(HandlerInterface::class));

        return $logger;
    }
}
