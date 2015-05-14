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

    public static function findOneBy(array $pair)
    {
        $sql = "SELECT * FROM teachers INNER JOIN events ON auditories.auditory_number = events.auditory_number WHERE ? = ? LIMIT 1";

        $result = self::findOne($sql, $pair);

        self::mappedObject($result);

        return self;
    }

    public static function findBy(array $pair = [])
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
        $sql = "INSERT INTO auditories(auditory_number, auditory_type) VALUES(?, ?)";
        $create = $this->getPdo()->prepare($sql);
        $create->execute(array($this->auditory_number, $this->auditory_type));
    }
}
