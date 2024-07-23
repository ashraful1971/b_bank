<?php

namespace App\Core\Contracts;

interface ServiceContainer {
    public function bind($interface, $concrete=null): void;
    public function singleton($interface, $concrete=null): void;
    public function make($interface): object;
}