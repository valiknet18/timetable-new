<?php

namespace Valiknet\Model;

use Symfony\Component\HttpFoundation\Request;

class Everyweek extends Event implements InterfaceObject
{
    /**
     * @typeProperty('property')
     */
    public $everyday;

    /**
     * @typeProperty('property')
     */
    public $everyweek;

    public function save()
    {

    }

    public static function findBy($pair)
    {

    }

    public static function findOneBy($pair)
    {

    }

    public function create()
    {
        $this->getPdo()->beginTransaction();

        try {
            $sql = "INSERT INTO events(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, repeat_type) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insertInEvents = $this->getPdo()->prepare($sql);
            $insertInEvents->execute(array($this->event_date_start, $this->event_date_end, $this->event_time_start, $this->event_time_end, $this->event_type, $this->teacher->teacher_code, $this->subject->subject_code, $this->auditory->auditory_number, $this->repeat_type));

            $lastIndex = $this->getPdo()->lastInsertId('events_event_code_seq');

            foreach ($this->groups as $group) {
                $sql = "INSERT INTO event_group(event_code, group_code) VALUES(?, ?)";
                $insertInEventGroup = $this->getPdo()->prepare($sql);
                $insertInEventGroup->execute(array($lastIndex, $group->group_code));
            }

            $sql = "INSERT INTO everyweek(everyday, everyweek, event_code) VALUES(?, ?, ?)";

            $insertInEveryday = $this->getPdo()->prepare($sql);
            $insertInEveryday->execute(array($this->everyday, $this->everyweek, $lastIndex));

            $this->getPdo()->commit();
        } catch (\PDOException $pdo) {
            $this->getPdo()->rollBack();
        }
    }

    public function setData(Request $request)
    {
        $this->event_date_start = $request->request->get('event_date_start');
        $this->event_date_end = $request->request->get('event_date_end');
        $this->event_time_start = $request->request->get('event_time_start');
        $this->event_time_end = $request->request->get('event_time_end');
        $this->event_type = $request->request->get('event_type');
        $this->repeat_type = 3;

        $byte = "";
        for ($i = 0; $i < 7; $i++) {
            if (in_array($i, $request->request->get('everyday'))) {
                $byte = 1 . $byte;
            } else {
                $byte = 0 . $byte;
            }
        }

        $this->everyday = $byte;
        $this->everyweek = $request->request->get('everyweek');

        $this->teacher = Teacher::findOneBy($request->request->get('teacher'));
        $this->subject = Subject::findOneBy($request->request->get('subject'));

        foreach ($request->request->get('groups') as $group) {
            $this->groups[] = Group::findOneBy($group);
        }

        $this->auditory = Auditory::findOneBy($request->request->get('auditory'));
    }
}
