<?php
/**
 * Created by PhpStorm.
 * User: valik-pc
 * Date: 10.05.15
 * Time: 2:33
 */

namespace Valiknet\Model;

class Auditory extends Model implements InterfaceObject
{
    public $table_name = 'auditories';
    public $auditory_number;
    public $auditory_type;
    public $events = [];

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
            $sql = "SELECT * FROM auditories INNER JOIN events ON auditories.auditory_number = events.auditory_number WHERE ? = ?";
            $auditories = self::find($sql, $pair);
        } else {
            $sql = "SELECT auditories.*, COUNT(events.event_code) AS count_ev FROM auditories LEFT JOIN events ON events.auditory_number = auditories.auditory_number GROUP BY auditories.auditory_number";
            $auditories = self::find($sql);
        }

        $result = [];

        foreach ($auditories as $key => $value) {
            $auditory = new Auditory();
            $auditory->mappedObject($value);

            $result[] = $auditory;
        }

        return $result;
    }

    public function mappedObject(array $data)
    {
        $this->auditory_number = $data['auditory_number'];
        $this->auditory_type = $data['auditory_type'];

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
