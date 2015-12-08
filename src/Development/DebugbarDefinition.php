<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Development;

use Assembly\FactoryCallDefinition;
use Assembly\ObjectDefinition;
use Assembly\Reference;
use DebugBar\DebugBar;
use DebugBar\JavascriptRenderer;
use DebugBar\StandardDebugBar;
use Interop\Container\Definition\DefinitionProviderInterface;

class DebugbarDefinition implements DefinitionProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        $debugbar = new ObjectDefinition(StandardDebugBar::class);
        $renderer = new FactoryCallDefinition(new Reference(DebugBar::class), 'getJavascriptRenderer');

        return [
            DebugBar::class => $debugbar,
            JavascriptRenderer::class => $renderer,
        ];
    }
}
