<?php

namespace App\Serializer;

class MyCircularReferenceHandler
{
    public function __invoke($object)
    {
        return $object->getId();
    }
}