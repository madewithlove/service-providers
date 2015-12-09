<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Definitions\Development;

use Assembly\ObjectDefinition;
use Assembly\Reference;
use Madewithlove\Definitions\Definitions\AbstractDefinitionProvider;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class MonologDefinition extends AbstractDefinitionProvider
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
    public function getDefinitions()
    {
        return [
            HandlerInterface::class => $this->getHandler(),
            LoggerInterface::class => $this->getLogger(),
            'monolog' => new Reference(LoggerInterface::class),
        ];
    }

    /**
     * @return ObjectDefinition
     */
    protected function getHandler()
    {
        $handler = new ObjectDefinition(RotatingFileHandler::class);
        $handler->setConstructorArguments($this->path.DIRECTORY_SEPARATOR.$this->filename, 0, Logger::WARNING);

        return $handler;
    }

    /**
     * @return ObjectDefinition
     */
    protected function getLogger()
    {
        $logger = new ObjectDefinition(Logger::class);
        $logger->setConstructorArguments('logs');
        $logger->addMethodCall('pushHandler', new Reference(HandlerInterface::class));

        return $logger;
    }
}
