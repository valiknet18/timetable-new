<?php

namespace Valiknet\Model;

class Group extends Model implements InterfaceObject
{
    /**
     * @typeProperty('table_name')
     */
    private $table_name = 'groups';

    /**
     * @typeProperty('property')
     * @key(true)
     */
    public $group_code;

    /**
     * @typeProperty('property')
     */
    public $group_name;

    /**
     * @typeProperty('property')
     */
    public $group_course;

    /**
     * @typeProperty('property')
     */
    public $group_students_count;

    /**
     * @typeProperty('arrayOfObjects')
     * @typeObject('Valiknet\Model\Event')
     */
    public $events;

    public function events()
    {
        $sql = "SELECT event_group.* FROM event_group INNER JOIN events ON events.event_code = event_group.event_code WHERE event_group.group_code = ?";
        $events = self::findBy($sql, $this->group_code);

        return $events;
    }

    public function save()
    {
    }

    public static function findBy($pair = null)
    {
        if (count($pair) > 0) {
            $groups = self::find('SELECT * FROM groups WHERE ? = ?', $pair);
        } else {
            $groups = self::find('SELECT * FROM groups');
        }

        $result = [];

        foreach ($groups as $key => $value) {
            $group = new Group();
            $group->mappedObject($value);

            $result[] = $group;
        }

        return $result;
    }

    public static function findOneBy($group_code)
    {
        $sql = "SELECT groups.* FROM groups WHERE groups.group_code = ?";

        $data = self::findOne($sql, $group_code);

        $group = new Group();
        $group->mappedObject($data);

        return $group;
    }

    public function create()
    {

    }
}
