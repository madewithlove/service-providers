<?php

/*
 * This file is part of madewithlove/service-providers
 *
 * (c) madewithlove <heroes@madewithlove.be>
 *
 * For the full copyright and license information, please view the LICENSE
 */

use Illuminate\Support\Fluent;
use League\FactoryMuffin\Facade;

Facade::define(Fluent::class, [
    'name' => 'numberBetween|1;1',
]);
