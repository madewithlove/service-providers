<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Definitions\Database;

use Assembly\ObjectDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\FactoryMuffin\Factory;

class FactoryMuffinDefinition implements DefinitionProviderInterface
{
    /**
     * Path to the factoriese.
     *
     * @var string
     */
    protected $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        // Cancel if no factories
        if (!is_dir($this->path)) {
            return [];
        }

        $factory = new ObjectDefinition(Factory::class);
        $factory->addMethodCall('loadFactories', $this->path);

        return [
            Factory::class => $factory,
        ];
    }
}
