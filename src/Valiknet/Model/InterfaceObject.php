<?php

namespace Valiknet\Model;

interface InterfaceObject
{
    public function save();

    public static function findBy(array $pair);

    public static function findOneBy(array $pair);

    public function create();

    public function mappedObject(array $attributes);
}
