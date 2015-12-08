<?php
namespace Madewithlove\Definitions\Caching;

use Assembly\ObjectDefinition;
use Assembly\Reference;
use Illuminate\Cache\FileStore;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Cache\Repository as RepositoryInterface;
use Illuminate\Contracts\Cache\Store;
use Interop\Container\Definition\DefinitionProviderInterface;

class IlluminateCacheDefinition implements DefinitionProviderInterface
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
     * IlluminateCacheDefinition constructor.
     *
     * @param string $driver
     * @param array  $configuration
     */
    public function __construct($driver = FileStore::class, array $configuration = [])
    {
        $this->driver = $driver;
        $this->configuration = $configuration;
    }

    /**
     * Returns the definition to register in the container.
     * Definitions must be indexed by their entry ID. For example:
     *     return [
     *         'logger' => ...
     *         'mailer' => ...
     *     ];
     *
     * @return array
     */
    public function getDefinitions()
    {
        $store = new ObjectDefinition($this->driver);
        $store->setConstructorArguments($this->configuration);

        $repository = new ObjectDefinition(Repository::class);
        $repository->setConstructorArguments(new Reference(Store::class));

        return [
            Store::class               => $store,
            RepositoryInterface::class => $repository,
        ];
    }
}
