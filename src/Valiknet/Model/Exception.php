<?php

namespace Valiknet\Model;

use Symfony\Component\HttpFoundation\Request;

class Exception extends Event
{
    /**
     * @typeProperty('property')
     */
    public $event_replace_date_start;

    /**
     * @typeProperty('property')
     */
    public $event_replace_date_end;

    /**
     * @typeProperty('property')
     */
    public $event_replace_time_start;

    /**
     * @typeProperty('property')
     */
    public $event_replace_time_end;

    /**
     * @typeProperty('object')
     * @typeObject('Valiknet\Model\Event')
     */
    public $parent_event;

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
            $sql = "INSERT INTO events(event_date_start, event_date_end, event_time_start, event_time_end, event_type, teacher_code, subject_code, auditory_number, repeat_type) VALUE(?, ?, ?, ?, ?, ?, ?, ?)";
            $insertInEvents = $this->getPdo()->prepare($sql);
            $insertInEvents->execute(array($this->event_time_start, $this->event_date_end, $this->event_time_start, $this->event_time_end, $this->event_type, $this->teacher->teacher_code, $this->subject->subject_code, $this->auditory->auditory_number, $this->repeat_type));

            $lastIndex = $this->getPdo()->lastInsertId();

            foreach ($this->groups as $group) {
                $sql = "INSERT INTO event_group(event_code, group_code) VALUES(?, ?)";
                $insertInEventGroup = $this->getPdo()->prepare($sql);
                $insertInEventGroup->execute(array($lastIndex, $group->group_code));
            }

            $sql = "INSERT INTO exceptions(event_replace_date_start, event_replace_date_end, event_replace_time_start, event_replace_time_end, event_code) VALUES(?, ?, ?, ?, ?)";

            $insertInEveryday = $this->getPdo()->prepare($sql);
            $insertInEveryday->execute(array($this->event_replace_date_start, $this->event_replace_date_end, $this->event_replace_time_start, $this->event_replace_time_end, $lastIndex));

            $this->getPdo()->commit();
        } catch (\PDOException $pdo) {
            $this->getPdo()->rollBack();
        }
    }

    public function setData(Request $request)
    {
        $this->event_date_start = $request->request->get('event_date_start');
        $this ->event_date_end = $request->request->get('event_date_end');
        $this->event_time_start = $request->request->get('event_time_start');
        $this->event_time_end = $request->request->get('event_time_end');
        $this->event_type = $request->request->get('event_type');

        $this->repeat_type = 5;

        $this->event_replace_date_start = $request->request->get('event_replace_date_start');
        $this->event_replace_date_end = $request->request->get('event_replace_date_end');
        $this->event_replace_time_start = $request->request->get('event_replace_time_start');
        $this->event_replace_time_end = $request->request->get('event_replace_time_end');

        $this->parent_event = Event::findOneBy($request->request->get('parent_event'));
    }
}
