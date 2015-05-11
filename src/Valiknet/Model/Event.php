<?php

namespace Valiknet\Model;

class Event extends Model implements InterfaceObject
{
    public $event_date_start;
    public $event_date_end;
    public $event_time_start;
    public $event_time_end;
    public $event_replace_date_start = null;
    public $event_replace_date_end = null;
    public $event_replace_time_start = null;
    public $event_replace_time_end = null;
    public $event_type;
    public $repeat_type;
    public $teacher;
    public $subject;
    public $auditory;
    public $groups = [];

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
