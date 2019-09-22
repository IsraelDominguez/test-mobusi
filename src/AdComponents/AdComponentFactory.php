<?php


namespace App\AdComponents;


abstract class AdComponentFactory
{
    protected $component;

    public static function create(string $type) {
        $class = sprintf("%s\%s", 'App\Entity', ucfirst($type));

        if (!class_exists($class)) {
            throw new \Exception('Ad Component Type Not Defined: '.$class);
        }

        $temp = class_implements($class);
        if (!is_array($temp) || !in_array( AdComponentInterface::class, $temp)) {
            throw new \Exception('Ad Component Type Not Implement correct Interface: '.$class);
        }

        return new $class;
    }
}