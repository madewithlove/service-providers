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
use Illuminate\Database\Capsule\Manager;
use Madewithlove\Definitions\Definitions\AbstractDefinitionProvider;

class EloquentDefinition extends AbstractDefinitionProvider
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
    public function getDefinitions()
    {
        return [
            Manager::class => $this->getDatabaseManager(),
        ];
    }

    /**
     * @return ObjectDefinition
     */
    protected function getDatabaseManager()
    {
        $manager = new ObjectDefinition(Manager::class);
        foreach ($this->connections as $name => $connection) {
            $manager->addMethodCall('addConnection', $connection, $name);
        }

        $manager->addMethodCall('bootEloquent');
        $manager->addMethodCall('setAsGlobal');

        return $manager;
    }
}
