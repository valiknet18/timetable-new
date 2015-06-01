<?php

namespace Valiknet\Model;

class Teacher extends Model implements InterfaceObject
{
    /**
     * @typeProperty('table_name ')
     */
    private $table_name;

    /**
     * @typeProperty('property')
     * @key(true)
     */
    public $teacher_code;

    /**
     * @typeProperty('property')
     */
    public $teacher_name;

    /**
     * @typeProperty('property')
     */
    public $teacher_surname;

    /**
     * @typeProperty('property')
     */
    public $teacher_last_name;

    /**
     * @typeProperty('property')
     */
    public $teacher_phone;

    /**
     * @typeProperty('arrayOfObjects')
     * @typeObject('Valiknet\Model\Subject')
     */
    public $subjects = [];

    /**
     * @typeProperty('arrayOfObjects')
     * @typeObject('Valiknet\Model\Event')
     */
    public $events = [];

    public function events()
    {
        $sql = "SELECT * FROM events WHERE events.teacher_code = ? AND events.event_date_end > NOW()";
        $events = self::find($sql, $this->teacher_code);

        return $events;
    }

    public function subjects()
    {
        $sql = "SELECT * FROM teacher_subject INNER JOIN subjects ON subjects.subject_code = teacher_subject.subject_code WHERE teacher_subject.teacher_code = ? ";
        $subjects = self::find($sql, $this->teacher_code);

        return $subjects;
    }

    public static function findOneBy($pair)
    {
        if (is_array($pair)) {
            $sql = "SELECT * FROM teachers WHERE ? = ?";
        } else {
            $sql = "SELECT * FROM teachers WHERE teachers.teacher_code = ?";
        }

        $data = self::findOne($sql, $pair);

        $teacher = new Teacher();
        $teacher->mappedObject($data);

        return $teacher;
    }

    public static function findBy($pair = null)
    {
        if (count($pair) > 0) {
            $sql = "SELECT * FROM teachers WHERE ? = ?";
            $teachers = self::find($sql, $pair);
        } else {
            $sql = "SELECT * FROM teachers";
            $teachers = self::find($sql);
        }

        $result = [];

        foreach ($teachers as $key => $value) {
            $teacher = new Teacher();
            $teacher->mappedObject($value);

            $result[] = $teacher;
        }

        return $result;
    }

    public function save()
    {
        $save = $this->getPdo()->prepare('UPDATE auditories SET auditory_number = ?, auditory_type = ?');
        $save->execute(array($this->auditory_number, $this->auditory_type));
    }

    public function create()
    {
        $this->getPdo()->beginTransaction();

        try {
            $sql = "INSERT INTO teachers(teacher_name, teacher_surname, teacher_last_name, teacher_phone)  VALUES(?, ?, ?, ?)";

            $createTeacher = $this->getPdo()->prepare($sql);
            $createTeacher->execute(array($this->teacher_name, $this->teacher_surname, $this->teacher_last_name, $this->teacher_phone));

            $lastIndex = $this->getPdo()->lastInsertId('teachers_teacher_code_seq');

            foreach ($this->subjects as $subject) {
                $sql = "INSERT INTO teacher_subject(teacher_code, subject_code)  VALUES(?, ?)";

                $createEventGroup = $this->getPdo()->prepare($sql);
                $createEventGroup->execute(array($lastIndex, $subject->subject_code));
            }

            $this->getPdo()->commit();
        } catch(\PDOException $pdo) {
            $this->getPdo()->rollback();
        }
    }
}
