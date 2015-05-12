<?php

namespace Valiknet\Model;

class Subject extends Model implements InterfaceObject
{
    public $subject_code;
    public $subject_name;
    public $teachers = [];

    public function save()
    {

    }

    public static function findBy(array $pair)
    {

    }

    public static function findOneBy(array $pair)
    {

    }

    public function create()
    {

    }

    public function mappedObject(array $data)
    {

    }
}