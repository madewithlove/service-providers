<?php

use Illuminate\Support\Fluent;
use League\FactoryMuffin\Facade;

Facade::define(Fluent::class, [
   'name' => 'numberBetween|1;1',
]);
