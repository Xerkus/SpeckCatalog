<?php

namespace SpeckCatalogTest\Helper;

use BadMethodCallException;

class ProtectedSetterAccessor
{
    protected $accessor;

    public function __construct($object)
    {
        $accessor = function ($method, $args) {
            return call_user_func_array(array($this, $method), $args);
        };
        $this->accessor = $accessor->bindTo($object, $object);
    }

    public function __call($method, $args)
    {
        if (strpos($method, 'set') !== 0) {
            throw new BadMethodCallException('Accessing anything but setters is prohibited to prevent further abuse');
        }
        return $this->accessor->__invoke($method, $args);
    }
}
