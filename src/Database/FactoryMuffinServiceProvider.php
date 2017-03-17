<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Database;

use Interop\Container\ServiceProviderInterface;
use League\FactoryMuffin\Factory;

class FactoryMuffinServiceProvider implements ServiceProviderInterface
{
    /**
     * Path to the factories.
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
    public function getServices()
    {
        // Cancel if no factories
        if (!is_dir($this->path)) {
            return [];
        }

        return [
            Factory::class => [$this, 'createFactory'],
        ];
    }

    /**
     * @return Factory
     */
    public function createFactory()
    {
        return (new Factory())->loadFactories($this->path);
    }
}
