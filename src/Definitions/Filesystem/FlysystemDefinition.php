<?php

/*
 * This file is part of madewithlove/definitions
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\Definitions\Definitions\Filesystem;

use Assembly\FactoryCallDefinition;
use Assembly\ObjectDefinition;
use Assembly\Reference;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\MountManager;
use Madewithlove\Definitions\Definitions\AbstractDefinitionProvider;

class FlysystemDefinition extends AbstractDefinitionProvider
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
    public function getDefinitions()
    {
        return [
            MountManager::class => $this->getMountManager(),
            FilesystemInterface::class => $this->getFilesystem(),
            'flysystem.mount-manager' => new Reference(MountManager::class),
            'flysystem' => new Reference(FilesystemInterface::class),
        ];
    }

    /**
     * @return ObjectDefinition
     */
    protected function getMountManager()
    {
        $mountManager = new ObjectDefinition(MountManager::class);
        $mountManager->setConstructorArguments(array_map(function (AdapterInterface $adapter) {
            return new Filesystem($adapter);
        }, $this->adapters));

        return $mountManager;
    }

    /**
     * @return FactoryCallDefinition
     */
    protected function getFilesystem()
    {
        $default = new FactoryCallDefinition(new Reference('flysystem.mount-manager'), 'getFilesystem');
        $default->setArguments($this->default);

        return $default;
    }
}
