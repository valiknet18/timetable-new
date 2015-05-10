<?php

namespace Valiknet\Model;

interface InterfaceObject
{
    public function save();

    public static function findBy(Pair $pair);

    public static function findOneBy(Pair $pair);

    public function create();
}