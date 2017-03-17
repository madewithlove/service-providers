<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Utilities;

use Interop\Container\ServiceProviderInterface;

class ParametersServiceProvider implements ServiceProviderInterface
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
    public function getServices()
    {
        $definitions = [];
        foreach ($this->values as $key => $value) {
            $definitions[$this->key.'.'.$key] = new Parameter($value);
        }

        return $definitions;
    }
}
