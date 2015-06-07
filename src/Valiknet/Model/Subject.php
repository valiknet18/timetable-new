<?php

namespace Valiknet\Model;

class Subject extends Model implements InterfaceObject
{
    /**
     * @typeProperty('table_name')
     */
    private $table_name;

    /**
     * @typeProperty('property')
     * @key(true)
     */
    public $subject_code;

    /**
     * @typeProperty('property')
     */
    public $subject_name;

    /**
     * @typeProperty('arrayOfObjects')
     * @typeObject('Valiknet\Model\Teacher')
     */
    public $teachers = [];

    /**
     * @typeProperty('arrayOfObjects')
     * @typeObject('Valiknet\Model\Event')
     */
    public $events = [];

    public function teachers()
    {
        $sql = "SELECT * FROM teacher_subject LEFT JOIN teachers ON teacher_subject.teacher_code = teachers.teacher_code WHERE teacher_subject.subject_code = ?";
        $teachers = self::find($sql, $this->subject_code);

        return $teachers;
    }

    public function events()
    {
        $sql = "SELECT * FROM events WHERE events.subject_code = ? AND events.event_date_end > NOW()";
        $events = self::find($sql, $this->subject_code);

        return $events;
    }

    public static function findOneBy($pair)
    {
        $sql = "SELECT * FROM subjects WHERE subjects.subject_code = ?";

        $data = self::findOne($sql, $pair);

        $subject = new Subject();
        $subject->mappedObject($data);

        return $subject;
    }

    public static function findBy($pair = null, $pagination = null)
    {
        if (count($pair) > 0) {
            $sql = "SELECT * FROM subjects WHERE ? = ?";

            if ($pagination) {
                $page = " LIMIT %s OFFSET %s";
                $page = sprintf($page, $pagination['limit'], $pagination['offset']);

                $sql .= $page;
            }

            $subject = self::find($sql, $pair);
        } else {
            $sql = "SELECT * FROM subjects";

            if ($pagination) {
                $page = " LIMIT %s OFFSET %s";
                $page = sprintf($page, $pagination['limit'], $pagination['offset']);

                $sql .= $page;
            }

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

    public function save()
    {
        $save = $this->getPdo()->prepare('UPDATE auditories SET auditory_number = ?, auditory_type = ?');
        $save->execute(array($this->auditory_number, $this->auditory_type));
    }

    public function create()
    {
        $this->getPdo()->beginTransaction();

        try {
            $sql = "INSERT INTO subjects(subject_name) VALUES(?)";

            $create = $this->getPdo()->prepare($sql);
            $create->execute(array($this->subject_name));

            $lastIndex = $this->getPdo()->lastInsertId('subjects_subject_code_seq');

            foreach ($this->teachers as $teacher) {
                $sql = "INSERT INTO teacher_subject(teacher_code, subject_code) VALUES(?, ?)";

                $create = $this->getPdo()->prepare($sql);
                $create->execute(array($teacher->teacher_code, $lastIndex));
            }

            $this->getPdo()->commit();

        } catch (\PDOException $pdo) {
            $this->getPdo()->rollBack();
        }
    }
}
