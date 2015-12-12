<?php
namespace Madewithlove\Definitions\Definitions\Events;

use Assembly\Container\Container;
use League\Event\Emitter;
use League\Event\EventInterface;
use Madewithlove\Definitions\TestCase;

class LeagueEventDefinitionTest extends TestCase
{
    public function testCanBindListeners()
    {
        $this->expectOutputString('foobarbar');

        $listener = function(EventInterface $event) {
            echo $event->getName();
        };

        $container = new Container([], [
            new LeagueEventDefinition([
                'foo' => $listener,
                'bar' => [$listener, $listener],
           ]),
        ]);

        /** @var Emitter $emitter */
        $emitter = $container->get(Emitter::class);
        $emitter->emitBatch(['foo', 'bar']);
    }
}
