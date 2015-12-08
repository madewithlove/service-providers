<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions;

use Assembly\ParameterDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;

class ValuesDefinition implements DefinitionProviderInterface
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * @param string $key
     * @param array  $values
     */
    public function __construct($key, array $values)
    {
        $this->key = $key;
        $this->values = $values;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        $definitions = [];
        foreach ($this->values as $key => $value) {
            $definitions[$this->key.'.'.$key] = new ParameterDefinition($value);
        }

        return $definitions;
    }
}
