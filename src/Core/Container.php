<?php

namespace App\Core;

use App\Core\Contracts\ServiceContainer;
use Exception;
use ReflectionClass;

class Container implements ServiceContainer {
    public static $instance;
    private $bindings = [];
    private $singleton = [];
    private $resolved = [];

    public static function init()
    {
        if(!self::$instance){
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function bind($interface, $concrete=null): void
    {
        $this->bindings[$interface] = $concrete ?? $interface;
    }
    
    public function singleton($interface, $concrete=null): void
    {
        $this->singleton[$interface] = $concrete ?? $interface;
    }
    
    public function make($interface): object
    {
        if(isset($this->resolved[$interface])){
            return $this->resolved[$interface];
        }

        return $this->resolve($interface);
    }

    private function resolve($interface)
    {
        if(!$interface){
            throw new Exception('This can not be resolved!');
        }

        $isSingleton = $this->isSingleton($interface);

        $concrete = $this->singleton[$interface] ?? $this->bindings[$interface] ?? $interface;
        
        if(is_callable($concrete) && !$isSingleton){
            return $this->resolvedInstance($interface, $concrete(), $isSingleton);
        }
        
        if(!class_exists($concrete)){
            throw new Exception($concrete. ' can not be resolved!');
        }

        $reflector = new ReflectionClass($concrete);

        if(!$reflector->isInstantiable()){
            throw new Exception($concrete. ' can not be resolved!');
        }

        $dependencies = $reflector->getConstructor()?->getParameters();
        
        if(!$dependencies){
            return $this->resolvedInstance($interface, new $concrete(), $isSingleton);
        }

        $dependencyInstances = $this->resolveDependencies($dependencies);

        $instance = $reflector->newInstanceArgs($dependencyInstances);

        return $this->resolvedInstance($interface, $instance, $isSingleton);
        
    }

    private function resolveDependencies($dependencies)
    {
        $instances = [];
        foreach($dependencies as $dependency){
            $instances[] = $this->resolve($dependency?->getType()?->getName());
        }

        return $instances;
    }

    private function isSingleton($interface)
    {
        return isset($this->singleton[$interface]);
    }
    
    private function resolvedInstance($interface, $instance, $isSingleton=false)
    {
        if($isSingleton){
            $this->resolved[$interface] = $instance;
        }
        return $instance;
    }
}