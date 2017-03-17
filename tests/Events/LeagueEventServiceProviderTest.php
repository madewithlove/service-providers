<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Events;

use League\Event\Emitter;
use League\Event\EventInterface;
use Madewithlove\ServiceProviders\TestCase;

class LeagueEventServiceProviderTest extends TestCase
{
    public function testCanBindListeners()
    {
        $this->expectOutputString('foobarbar');

        $listener = function (EventInterface $event) {
            echo $event->getName();
        };

        $container = $this->getContainerfromProviders([
            new LeagueEventsServiceProvider([
                'foo' => $listener,
                'bar' => [$listener, $listener],
            ]),
        ]);

        /** @var Emitter $emitter */
        $emitter = $container->get(Emitter::class);
        $emitter->emitBatch(['foo', 'bar']);
    }
}
