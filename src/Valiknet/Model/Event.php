<?php

namespace Valiknet\Model;

class Event extends Model implements InterfaceObject
{
    /**
     * @typeProperty('property')
     * @key(true)
     */
    public $event_code;

    /**
     * @typeProperty('property')
     */
    public $event_date_start;

    /**
     * @typeProperty('property')
     */
    public $event_date_end;

    /**
     * @typeProperty('property')
     */
    public $event_time_start;

    /**
     * @typeProperty('property')
     */
    public $event_time_end;

    /**
     * @typeProperty('property')
     */
    public $event_type;

    /**
     * @typeProperty('property')
     */
    public $repeat_type;

    /**
     * @typeProperty('object')
     * @typeObject('Valiknet\Model\Teacher')
     */
    public $teacher;

    /**
     * @typeProperty('property')
     * @typeObject('Valiknet\Model\Subject')
     */
    public $subject;

    /**
     * @typeProperty('property')
     * @typeObject('Valiknet\Model\Auditory')
     */
    public $auditory;

    /**
     * @typeProperty('arrayOfObject')
     * @typeObject('Valiknet\Model\Group')
     */
    public $groups = [];

    public static function groups($event_code)
    {
        $sql = "SELECT * FROM event_group LEFT JOIN groups ON groups.group_code = event_group.group_code WHERE event_group.event_code = ?";

        $groups = self::find($sql, $event_code);

        return $groups;
    }

    public function auditory()
    {

    }

    public static function subject()
    {

    }

    public static function teacher()
    {

    }

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
}
