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
     * @nameForeignKey('teacher_code')
     * @typeObject('Valiknet\Model\Teacher')
     */
    public $teacher;

    /**
     * @typeProperty('object')
     * @nameForeignKey('subject_code')
     * @typeObject('Valiknet\Model\Subject')
     */
    public $subject;

    /**
     * @typeProperty('object')
     * @nameForeignKey('auditory_number')
     * @typeObject('Valiknet\Model\Auditory')
     */
    public $auditory;

    /**
     * @typeProperty('arrayOfObject')
     * @typeObject('Valiknet\Model\Group')
     */
    public $groups = [];

    public function groups()
    {
        $sql = "SELECT * FROM event_group LEFT JOIN groups ON groups.group_code = event_group.group_code WHERE event_group.event_code = ?";

        $groups = self::find($sql, $this->event_code);

        return $groups;
    }

    public function auditory($auditory_number)
    {
        $sql = "SELECT * FROM auditories WHERE auditories.auditory_number = ?";

        $auditory = self::findOne($sql, $auditory_number);

        return $auditory;
    }

    public function subject($subject_code)
    {
        $sql = "SELECT * FROM subjects WHERE subjects.subject_code = ?";

        $subject = self::findOne($sql, $subject_code);

        return $subject;
    }

    public function teacher($teacher_code)
    {
        $sql = "SELECT * FROM teachers WHERE teachers.teacher_code = ?";

        $teacher = self::findOne($sql, $teacher_code);

        return $teacher;
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
