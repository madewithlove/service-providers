<?php
namespace Madewithlove\Definitions\Definitions\Database;

use Assembly\FactoryCallDefinition;
use Assembly\ObjectDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\FactoryMuffin\Facade;
use League\FactoryMuffin\Factory;

class FactoryMuffinDefinition implements DefinitionProviderInterface
{
    /**
     * Path to the factoriese
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
    public function getDefinitions()
    {
        $factory = new ObjectDefinition(Factory::class);
        $factory->addMethodCall('loadFactories', $this->path);

        return [
            Factory::class => $factory,
        ];
    }
}
