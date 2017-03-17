<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Utilities;

use Psr\Container\ContainerInterface;

class Alias
{
    /**
     * @var string
     */
    protected $resolver;

    /**
     * @param string $resolver
     */
    public function __construct($resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container)
    {
        return $container->get($this->resolver);
    }
}
