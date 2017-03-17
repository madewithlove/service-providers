<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

namespace Madewithlove\ServiceProviders\Events;

use Interop\Container\ServiceProviderInterface;
use League\Event\Emitter;
use League\Event\ListenerInterface;

class LeagueEventsServiceProvider implements ServiceProviderInterface
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
    public function getServices()
    {
        return [
            Emitter::class => [$this, 'getEmitter'],
        ];
    }

    public function getEmitter()
    {
        $emitter = new Emitter();
        foreach ($this->listeners as $event => $listeners) {
            $listeners = (array) $listeners;
            foreach ($listeners as $listener) {
                $emitter->addListener($event, $listener);
            }
        }

        return $emitter;
    }
}
