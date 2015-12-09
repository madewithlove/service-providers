<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Definitions\Http;

use Assembly\FactoryCallDefinition;
use Assembly\ObjectDefinition;
use Assembly\Reference;
use Madewithlove\Definitions\Definitions\AbstractDefinitionProvider;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

class ZendDiactorosDefinition extends AbstractDefinitionProvider
{
    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        $request = new FactoryCallDefinition(ServerRequestFactory::class, 'fromGlobals');
        $response = new ObjectDefinition(Response::class);

        return [
            ServerRequestInterface::class => $request,
            ResponseInterface::class => $response,
            RequestInterface::class => new Reference(ServerRequestInterface::class),
        ];
    }
}
