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
     * @var array
     */
    protected $values = [];

    /**
     * @param array  $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        $services = [];
        foreach ($this->values as $key => $value) {
            $services[$key] = new Parameter($value);
        }

        return $services;
    }
}
