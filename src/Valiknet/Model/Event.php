<?php

namespace Valiknet\Model;

use Silex\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

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
     * @typeProperty('arrayOfObjects')
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

    public static function findBy($pair = null, $full = false, $timestamp = null, $pagination = null)
    {
        if ($pair) {
            $sql = "SELECT * FROM events WHERE repeat_type = ?";

            if ($pagination) {
                $page = " LIMIT %s OFFSET %s";
                $page = sprintf($page, $pagination['limit'], $pagination['offset']);

                $sql .= $page;
            }

            $events = self::find($sql, $pair);
        } else {
            $sql = "SELECT * FROM events";

            if ($pagination) {
                $page = " LIMIT %s OFFSET %s";
                $page = sprintf($page, $pagination['limit'], $pagination['offset']);

                $sql .= $page;
            }

            $events = self::find($sql);
        }

        $result  = [];

        foreach ($events as $value) {

            list($event, $value) = self::getEventType($value);

            $event->mappedObject($value);

            $result[] = $event;
        }

        if ($full) {
            $result = self::proccessEvents($result, $timestamp);
        }

        return $result;
    }

    public static function findOneBy($pair = null)
    {
        $sql = "SELECT * FROM events WHERE event_code = ?";
        $data = self::findOne($sql, $pair);

        list($event, $data) = self::getEventType($data);

        $event->mappedObject($data);

        return $event;
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

            $this->getPdo()->commit();
        } catch (\PDOException $pdoex) {
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
        $this->repeat_type = 1;
    }

    private static function proccessEvents($events, $timestamp)
    {
        $date_now = (new \DateTime())->setTimestamp($timestamp)->format('Y-m-d');

        $date = getdate($timestamp);

        $result = [];
        $exceptions = [];

        $date['wday'] = ($date['wday'] == 0)?7:$date['wday'];

        foreach ($events as $event) {
            if (in_array($event->event_code, $exceptions)) {
                continue;
            }

            switch ($event->repeat_type) {
                case 1:
                    if (($event->event_date_start <= $date_now) && ($date_now <= $event->event_date_end)) {
                        $result[] = $event;
                    }
                    break;

                case 2:
                    if (($date['wday'] % $event->everyday == 0) && ($event->event_date_start <= $date_now && $date_now <= $event->event_date_end)) {
                        $result[] = $event;
                    }
                    break;

                case 3:
                    $week = (int) date("W",strtotime("2015-06-12"));
                    $day = (bool) substr($event->everyday, (($date['wday']) * -1), 1);

                    if ($day && (($week % $event->everyweek) == 0) && ($event->event_date_start <= $date_now && $date_now <= $event->event_date_end)) {
                        $result[] = $event;
                    }
                    break;

                case 4:
                    if (($event->repeat_type == $date['mday']) && (($date['mon'] % $event->everymonth) == 0) && ($event->event_date_start <= $date_now && $date_now <= $event->event_date_end)) {
                        $result[] = $event;
                    }
                    break;

                case 5:
                    if ($event->event_replace_date_start <= $date_now && $date_now <= $event->event_replace_date_end && $event->event_date_start <= $date_now && $date_now <= $event->event_date_end) {
                        $parent_code = $event->parent_event->event_code;

                        foreach ($result as $key => $event_local) {
                            if ($event_local->event_code == $parent_code) {
                                unset($result[$key]);
                            }
                        }

                        $exceptions[] = $parent_code;

                        $result[] = $event;
                    }
                    break;
            }
        }

        return $result;
    }

    private static function getEventType($value)
    {
        switch ($value['repeat_type']) {
            case 1:

                $event = new Event();

                break;

            case 2:
                $sql = "SELECT * FROM everyday WHERE event_code = ? LIMIT 1";
                $everyday = self::findOne($sql, $value['event_code']);

                unset($everyday['event_code']);

                $value = array_merge($value, $everyday);
                $event = new Everyday();

                break;

            case 3:
                $sql = "SELECT * FROM everyweek WHERE event_code = ? LIMIT 1";
                $everyweek = self::findOne($sql, $value['event_code']);

                unset($everyweek['event_code']);

                $value = array_merge($value, $everyweek);
                $event = new Everyweek();

                break;

            case 4:
                $sql = "SELECT * FROM everymonth WHERE event_code = ? LIMIT 1";
                $everymonth = self::findOne($sql, $value['event_code']);

                unset($everymonth['event_code']);

                $value = array_merge($value, $everymonth);
                $event = new Everymonth();

                break;

            case 5:
                $sql = "SELECT * FROM exceptions WHERE event_code = ? LIMIT 1";
                $exeptions = self::findOne($sql, $value['event_code']);

                unset($exeptions['event_code']);

                $value = array_merge($value, $exeptions);
                $event = new Exception();

                break;
        }

        return [$event, $value];
    }
}
