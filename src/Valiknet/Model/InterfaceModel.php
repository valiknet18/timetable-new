<?php

namespace Valiknet\Model;

interface InterfaceModel
{
    public static function findOne($sql, $pair);

    public static function find($sql, array $pair);
}
