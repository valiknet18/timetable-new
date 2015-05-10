<?php

namespace Valiknet\Model;

interface InterfaceModel
{
    public static function findOne(string $sql, Pair $pair);

    public static function find(string $sql, Pair $pair);
}
