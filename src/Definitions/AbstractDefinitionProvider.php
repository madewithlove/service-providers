<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Definitions;

use Assembly\Container\Container;
use Assembly\Container\DefinitionResolver;
use Interop\Container\Definition\DefinitionInterface;
use Interop\Container\Definition\DefinitionProviderInterface;

abstract class AbstractDefinitionProvider implements DefinitionProviderInterface
{
    /**
     * Resolve a particular definition from the provider.
     *
     * @param string $definitionKey
     *
     * @return mixed
     */
    public function resolve($definitionKey)
    {
        $container = new Container([]);
        $resolver = new DefinitionResolver($container);

        /* @var DefinitionInterface $definition */
        $definitions = $this->getDefinitions();
        $definition = $definitions[$definitionKey];

        return $resolver->resolve($definition);
    }
}
