<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Definitions\Caching;

use Assembly\ObjectDefinition;
use Assembly\Reference;
use Illuminate\Cache\FileStore;
use Illuminate\Cache\RedisStore;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Cache\Repository as RepositoryInterface;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Contracts\Redis\Database as DatabaseInterface;
use Illuminate\Redis\Database;
use Illuminate\Filesystem\Filesystem;
use Madewithlove\Definitions\Definitions\AbstractDefinitionProvider;

class IlluminateCacheDefinition extends AbstractDefinitionProvider
{
    /**
     * @var string
     */
    protected $driver;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @param string $driver
     * @param array  $configuration
     */
    public function __construct($driver = FileStore::class, array $configuration = [])
    {
        $this->driver = $driver;
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        $definitions = [
            Filesystem::class => new ObjectDefinition(Filesystem::class),
            Store::class => $this->getStore(),
            RepositoryInterface::class => $this->getRepository(),
        ];

        if ($this->driver === RedisStore::class) {
            $redis = new ObjectDefinition(Database::class);
            $redis->setConstructorArguments([
                'cluster' => false,
                'default' => [
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'database' => 1,
                ],
            ]);

            $definitions[DatabaseInterface::class] = $redis;
        }

        return $definitions;
    }

    /**
     * @return ObjectDefinition
     */
    protected function getStore()
    {
        $store = new ObjectDefinition($this->driver);

        switch ($this->driver) {
            case RedisStore::class:
                $store->setConstructorArguments(new Reference(DatabaseInterface::class), ...$this->configuration);
                break;

            default:
            case FileStore::class:
                $store->setConstructorArguments(new Reference(Filesystem::class), ...$this->configuration);
                break;
        }

        return $store;
    }

    /**
     * @return ObjectDefinition
     */
    protected function getRepository()
    {
        $repository = new ObjectDefinition(Repository::class);
        $repository->setConstructorArguments(new Reference(Store::class));

        return $repository;
    }
}
