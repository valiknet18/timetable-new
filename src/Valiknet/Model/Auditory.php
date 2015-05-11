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

    public static function findOneBy(array $pair)
    {
        $sql = "SELECT * FROM auditories WHERE ? = ? LIMIT 1";

        $result = self::findOne($sql, $pair);

        self::mappedObject($result);

        return self;
    }

    public static function findBy(array $pair)
    {
        $sql = "SELECT * FROM auditories WHERE ? = ?";

        $resultQuery = self::find($sql, $pair);

        return $resultQuery;
    }

    public function mappedObject(array $data)
    {
        $this->auditory_number = $data['auditory_number'];
        $this->auditory_type = $data['auditory_type'];

        return this;
    }

    public function save()
    {
        $save = $this->getPdo()->prepare('UPDATE auditories SET auditory_number = ?, auditory_type = ?');
        $save->execute(array($this->auditory_number, $this->auditory_type));
    }

    public function create()
    {

    }
}
