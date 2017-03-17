<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Database;

use Illuminate\Database\Capsule\Manager;
use Interop\Container\ServiceProviderInterface;

class EloquentServiceProvider implements ServiceProviderInterface
{
    /**
     * @var array
     */
    protected $connections = [];

    /**
     * @param array $connections
     */
    public function __construct(array $connections = [])
    {
        $this->connections = $connections;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return [
            Manager::class => [$this, 'getDatabaseManager'],
        ];
    }

    /**
     * @return Manager
     */
    public function getDatabaseManager()
    {
        $manager = new Manager();
        foreach ($this->connections as $name => $connection) {
            $manager->addConnection($connection, $name);
        }

        $manager->bootEloquent();
        $manager->setAsGlobal();

        return $manager;
    }
}
