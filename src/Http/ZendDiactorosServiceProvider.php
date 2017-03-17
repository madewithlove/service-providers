<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Http;

use Interop\Container\ServiceProviderInterface;
use Madewithlove\ServiceProviders\Utilities\Alias;
use Madewithlove\ServiceProviders\Utilities\Parameter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;

class ZendDiactorosServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return [
            ServerRequestInterface::class => [$this, 'getRequest'],
            ResponseInterface::class => new Parameter(new Response()),
            RequestInterface::class => new Alias(ServerRequestInterface::class),
        ];
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        return ServerRequestFactory::fromGlobals();
    }
}
