<?php
/**
 * Created by PhpStorm.
 * User: valik-pc
 * Date: 10.05.15
 * Time: 2:33
 */

namespace Valiknet\Model;

class Auditories extends Model implements InterfaceObject
{
    public string $table_name = 'auditories';
    public int $auditory_number;
    public int $auditory_type;

    public static function findOneBy(Pair $pair): Auditories
    {
        $sql = "SELECT * FROM auditories WHERE ? = ? LIMIT 1";

        $result = self::findOne($sql, $pair);

        $this->mappedObject($result);

        return $this;
    }

    public static function findBy(Pair $pair): Vector
    {
        $sql = "SELECT * FROM auditories WHERE ? = ?";

        $resultQuery = self::find($sql, $pair);

        $result = Vector {};

        return $result;
    }

    private function mappedObject(array $data): void
    {
        $this->auditory_number = $data['auditory_number'];
        $this->auditory_type = $data['auditory_type'];
    }

    public function save(): void
    {
        $save = $this->getPdo()->prepare('UPDATE auditories SET auditory_number = ?, auditory_type = ?');
        $save->execute(array($this->auditory_number, $this->auditory_type));
    }
}
