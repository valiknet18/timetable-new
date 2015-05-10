<?php

namespace Valiknet\Model;

abstract class AbstractModel implements Model
{
    protected PDO $pdo;

    public function __construct()
    {
        $dsn = sprintf('pgsql:host=%s;dbname=%s', '127.0.0.1:5432', 'timetable');
        $this->pdo = new \PDO($dsn, 'postgres', 994433);
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $this->pdo->exec("SET CHARACTER SET utf8");
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public static function findOne(string $table_name, $pair)
    {
        $findOne = self::getPdo()->prepare('SELECT * FROM ? WHERE ? = ?');
        $result = $findOne->execute(array($table_name, $pair[0], $pair[1]));
    }
}