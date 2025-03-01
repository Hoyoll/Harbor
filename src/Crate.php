<?php
namespace Swim\Harbor;

use Exception;

final class Crate 
{
    private array $worker;
    private $error;
    /**
     * An ergonomic way to create new Crate!
     */

    public static function new() : self 
    {
        return new self();
    }

    /**
     * You can store anything with this, 
     * just make sure you're calling it with the right method!
     */

    public function store( string $name, mixed $process ) : self 
    {
        if ($this->worker[$name] ?? null) {
            return ($this->error)(...$dependency);
        }
        $this->worker[$name] = $process;
        return $this;
    }
    
    /**
     * Retrieve the worker value directly
     */

    public function get(string $name) : mixed
    {
        $worker = $this->worker[$name] ?? null;
        if ($worker === null) {
            return ($this->error)(...$dependency);
        }
        return $this->worker[$name];
    }

    /**
     * If you store a classname that you want to instantiate you wanna use this,
     * don't forget to use fully qualified name like Namespace/classname::class!
     */

    public function charge( string $name, array $dependency = [] ) : object 
    {
        $worker = $this->worker[$name] ?? null;
        if ($worker === null) {
            return ($this->error)(...$dependency);
        }
        return new $this->worker[$name](...$dependency);
    }

    /**
     * If you store a callable, call it using this method,
     * or if it is a class instance or classname that have __invoke method
     */

    public function emit( string $name, array $dependency = [] ) : mixed 
    {

        $worker = $this->worker[$name] ?? null;
        if ($worker === null) {
            return ($this->error)(...$dependency);
        } 
        if (is_string($worker)) {
            return (new $worker(...$dependency))();
        }
        return $worker(...$dependency);
    }

    /**
     * You can override the default error handler here
     */

    public function catch(callable $handler): self 
    {
        $this->error = $handler;
        return $this;
    }

    private function __construct() 
    {
        $this->error = function () {
            throw new Exception("Error! Faulty request!");
        };
    }
}
