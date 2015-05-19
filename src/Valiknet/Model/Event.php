<?php

namespace Valiknet\Model;

use Silex\ExceptionHandler;

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

    public static function findBy($pair = null)
    {

    }

    public static function findOneBy($pair = null)
    {

    }

    public function create()
    {
        $this->getPdo()->beginTransaction();

        try {
            $sql = "INSERT INTO events(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number) VALUE(?, ?, ?, ?, ?, ?, ?, ?)";
            $insertInEvents = $this->getPdo()->prepare($sql);
            $insertInEvents->execute(array($this->event_time_start, $this->event_date_end, $this->event_time_start, $this->event_time_end, $this->event_type, $this->teacher->teacher_code, $this->subject->subject_code, $this->auditory->auditory_number));

            $lastIndex = $this->getPdo()->lastInsertId();

            foreach ($this->groups as $group) {
                $sql = "INSERT INTO event_group(event_code, group_code) VALUES(?, ?)";
                $insertInEventGroup = $this->getPdo()->prepare($sql);
                $insertInEventGroup->execute(array($lastIndex, $group->group_code));
            }

            $this->getPdo()->commit();
        } catch (\PDOException $pdoex) {
            $this->getPdo()->rollBack();
        }

    }
}
