<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Development;

use DebugBar\DebugBar;
use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;
use Interop\Container\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

class DebugbarServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return [
            DebugBar::class => [$this, 'getDebugbar'],
            JavascriptRenderer::class => [$this, 'getJavascriptRenderer'],
        ];
    }

    /**
     * @return StandardDebugBar
     */
    public function getDebugbar()
    {
        return new StandardDebugBar();
    }

    /**
     * @param ContainerInterface $container
     *
     * @return JavascriptRenderer
     */
    public function getJavascriptRenderer(ContainerInterface $container)
    {
        /** @var Debugbar $debugbar */
        $debugbar = $container->get(DebugBar::class);

        return $debugbar->getJavascriptRenderer();
    }
}
