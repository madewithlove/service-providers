<?php
namespace Madewithlove\Definitions\Definitions\Events;

use Assembly\ObjectDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\Event\Emitter;
use League\Event\ListenerInterface;

class LeagueEventDefinition implements DefinitionProviderInterface
{
    /**
     * @var ListenerInterface[]
     */
    protected $listeners = [];

    /**
     * @param \League\Event\ListenerInterface[] $listeners
     */
    public function __construct(array $listeners)
    {
        $this->listeners = $listeners;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinitions()
    {
        $emitter = new ObjectDefinition(Emitter::class);
        foreach ($this->listeners as $event => $listeners) {
            $listeners = (array) $listeners;
            foreach ($listeners as $listener) {
                $emitter->addMethodCall('addListener', $event, $listener);
            }
        }

        return [
            Emitter::class => $emitter,
        ];
    }
}
