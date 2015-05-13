<?php

namespace Valiknet\Model;

class Subject extends Model implements InterfaceObject
{
    public $subject_code;
    public $subject_name;
    public $teachers = [];

    public static function findOneBy(array $pair)
    {
        $sql = "SELECT * FROM auditories INNER JOIN events ON auditories.auditory_number = events.auditory_number WHERE ? = ? LIMIT 1";

        $result = self::findOne($sql, $pair);

        self::mappedObject($result);

        return self;
    }

    public static function findBy(array $pair = [])
    {
        if (count($pair) > 0) {
            $sql = "SELECT * FROM subjects WHERE ? = ?";
            $subject = self::find($sql, $pair);
        } else {
            $sql = "SELECT * FROM subjects";
            $subject = self::find($sql);
        }

        $result = [];

        foreach ($subject as $key => $value) {
            $subject = new Subject();
            $subject->mappedObject($value);

            $result[] = $subject;
        }

        return $result;
    }

    public function mappedObject(array $data)
    {
        $this->subject_code = $data['subject_code'];
        $this->subject_name = $data['subject_name'];

        return $this;
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