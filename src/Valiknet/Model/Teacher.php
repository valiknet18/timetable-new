<?php

namespace Valiknet\Model;

class Teacher extends Model implements InterfaceObject
{
    public $teacher_code;
    public $teacher_name;
    public $teacher_surname;
    public $teacher_last_name;
    public $teacher_phone;
    public $subjects = [];

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