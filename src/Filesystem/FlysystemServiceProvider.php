<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Filesystem;

use Interop\Container\ServiceProviderInterface;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use Psr\Container\ContainerInterface;

class FlysystemServiceProvider implements ServiceProviderInterface
{
    /**
     * The default adapter to use.
     *
     * @var string
     */
    protected $default;

    /**
     * @var AdapterInterface[]
     */
    protected $adapters = [];

    /**
     * @param string $default
     * @param array  $adapters
     */
    public function __construct($default, array $adapters)
    {
        $this->default = $default;
        $this->adapters = $adapters;
    }

    /**
     * {@inheritdoc}
     */
    public function getServices()
    {
        return [
            MountManager::class => [$this, 'getMountManager'],
            FilesystemInterface::class => [$this, 'getFilesystem'],
        ];
    }

    /**
     * @return MountManager
     */
    public function getMountManager()
    {
        $adapters = array_map(function (AdapterInterface $adapter) {
            return new Filesystem($adapter);
        }, $this->adapters);

        return new MountManager($adapters);
    }

    /**
     * @param ContainerInterface $container
     *
     * @return FilesystemInterface
     */
    public function getFilesystem(ContainerInterface $container)
    {
        /** @var MountManager $mountManager */
        $mountManager = $container->get(MountManager::class);

        return $mountManager->getFilesystem($this->default);
    }
}
