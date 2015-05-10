<?php

namespace Valiknet\Model;

interface Model
{
    public function save();

    public static function findOne(string $table_name, $pair);
}