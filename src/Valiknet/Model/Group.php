<?php

namespace Valiknet\Model;

class Group extends Model implements InterfaceObject
{
    public $group_code;
    public $group_name;
    public $group_course;
    public $group_students_count;

    public function save()
    {

    }

    public static function findBy(array $pair = [])
    {
        if (count($pair) > 0) {
            $groups = self::getStaticPdo()->prepare('SELECT * FROM groups WHERE ? = ?');
            $groups->execute([$pair[0], $pair[1]]);
        } else {
            $groups = self::getStaticPdo()->prepare('SELECT * FROM groups');
            $groups->execute();
        }

        $data = $groups->fetchAll();

        $result = [];

        foreach ($data as $key => $value) {
            $group = new Group();
            $group->mappedObject($value);

            $result[] = $group;
        }

        return $result;
    }

    public static function findOneBy(array $pair)
    {

    }

    public function create()
    {

    }

    public function mappedObject(array $data)
    {
        $this->group_code = $data['group_code'];
        $this->group_name = $data['group_name'];
        $this->group_course = $data['group_course'];
        $this->group_students_count = $data['group_students_count'];
    }
}