<?php

namespace Valiknet\Model;

interface InterfaceObject
{
    public function save();

    public static function findBy($pair);

    public static function findOneBy($data);

    public function create();

//    public function mappedObject(array $attributes, $depth = 0);
}
