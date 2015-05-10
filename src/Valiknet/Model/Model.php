<?php

namespace Valiknet\Model;

use Silex\Application;

class Model implements InterfaceModel
{
    protected PDO $pdo;

    public function __construct(Application $app)
    {
        $dsn = sprintf('pgsql:host=%s;dbname=%s', $app['config']['database']['host'], $app['config']['database']['database_name']);
        $this->pdo = new \PDO($dsn, $app['config']['database']['username'], $app['config']['database']['password']);
        $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        $this->pdo->exec("SET CHARACTER SET utf8");
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public static function findOne(string $sql, Pair $parameters)
    {
        $findOne = self::getPdo()->prepare($sql);
        $result = $findOne->execute(array($parameters[0], $parameters[1]));

        return $result;
    }

    public static function find(string $sql, Pair $pair)
    {
        $find = self::getPdo()->prepare($sql);
        $result = $find->execute(array($pair[0], $pair[1]));

        return $result;
    }
}
